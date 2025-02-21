<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Login extends ResourceController
{
    public function gettoken($userId = null)
    {
        $data = $this->request->getGet();

        if (!isset($data['force_regenerate'])) {
            $data['force_regenerate'] = false;
        }

        if ($userId !== null) {
            $um = Model('UserModel');
            $user = $um->find($userId);
        } // Sinon, utiliser mail + password pour vérifier l'utilisateur
        else if (isset($data['mail']) && isset($data['password'])) {
            $um = Model('UserModel');
            $user = $um->verifyLogin($data['mail'], $data['password']);
        } else {
            return $this->respond(["message" => "Erreur, identifiant ou mot de passe manquant"], 400);
        }

        // Vérifier que l'utilisateur existe
        if (!isset($user['id'])) {
            return $this->respond(["message" => "Erreur, identifiant ou mot de passe incorrect"], 401);
        }

        // Vérifier si l'utilisateur est blacklisté
        $bm = Model('BlacklistModel');
        $isBlacklisted = $bm->where('user_id', $user['id'])->first();
        if ($isBlacklisted) {
            return $this->respond(["message" => "Utilisateur bloqué, impossible de générer un jeton"], 403);
        }

        // Supprimer l'ancien token s'il existe
        $atm = Model('ApiTokenModel');
        $atm->where('user_id', $user['id'])->delete();

        // Générer un nouveau token
        $token = generateToken($user['id'], $data['force_regenerate']);

        return $this->respond(['token' => $token], 200);
    }

    public function postlogin()
    {
        $userModel = Model('UserModel');
        $blacklistModel = Model('BlacklistModel');

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Récupération de l'utilisateur
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return $this->response->setJSON(['message' => 'Erreur, identifiant ou mot de passe incorrect'])->setStatusCode(401);
        }

        // Vérifier si l'utilisateur est en blacklist
        $isBlacklisted = $blacklistModel->where('user_id', $user['id'])->first();
        if ($isBlacklisted) {
            return $this->response->setJSON(['message' => 'Compte bloqué, veuillez contacter l\'administration'])->setStatusCode(403);
        }

        // Vérification du mot de passe
        if (!password_verify($password, $user['password'])) {
            $userModel->decrementCounterUser($user['id']);
            $user = $userModel->find($user['id']);

            // Vérification si le compteur atteint 0
            if ($user['counter_user'] <= 0) {
                $blacklistModel->addToBlacklistuser($user['id']);
                return $this->response->setJSON(['message' => 'Compte bloqué et ajouté en blacklist'])->setStatusCode(403);
            }
            return $this->response->setJSON(['message' => 'Erreur, identifiant ou mot de passe incorrect'])->setStatusCode(401);
        }

        // Réinitialisation du compteur après une connexion réussie
        $userModel->resetCounter($email);

        // Vérifier si un token existe déjà pour cet utilisateur
        $atm = Model('ApiTokenModel');
        $apiToken = $atm->where('user_id', $user['id'])->first();

        if ($apiToken) {
            // Token déjà existant, le renvoyer
            return $this->response->setJSON(['token' => $apiToken['token']]);
        } else {
            // Si aucun token n'existe, utiliser la fonction gettoken pour le générer
            return $this->gettoken($user['id']);
        }
    }

    public function postsetRequestLimit()
    {
        $input = $this->request->getJSON();
        $limit = $input->limit ?? null;

        if ($limit !== null) {
            $tournamentOptionsModel = Model('OptionsModel');
            $apiTokenModel = new \App\Models\ApiTokenModel();

            $result = $tournamentOptionsModel->updateOrInsertLimit('api_request_limit', $limit);

            if ($result) {
                // Mise à jour du 'counter' dans api_token
                $newCounter = ($limit === 'infinite') ? 10000 : (int)$limit;
                $apiTokenModel->updateAllCounters($newCounter);

                return $this->response->setJSON(['success' => true, 'message' => 'Limite et compteurs mis à jour.']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de la mise à jour.']);
            }
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Paramètre manquant.']);
    }
}