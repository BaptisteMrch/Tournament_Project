<?php

use App\Models\ApiTokenModel;
use App\Models\BlacklistModel;
use CodeIgniter\I18n\Time;

function generateToken($userId, $force_regen = false, $never_expired = false)
{
    $token = bin2hex(random_bytes(32)); // Crée un token sécurisé

    $expiresAt = Time::now()->addHours(24); // Expiration dans 24 heures
    if ($never_expired) {
        $expiresAt = null;
    }
    // Sauvegarder le token en BDD
    $blacklistModel = new BlacklistModel();
    $apiTokenModel = new ApiTokenModel();
    $idData = $blacklistModel->where('user_id', $userId)->first();
    $tokenData = $apiTokenModel->where('user_id', $userId)->first();

    if (!isset($idData)) {
        if ($tokenData && ($tokenData['expires_at'] < Time::now() || $force_regen == true)) {
            $apiTokenModel->update($tokenData['id'], [
                'user_id' => $userId,
                'token' => $token,
                'counter' => 10,
                'created_at' => Time::now(),
                'expires_at' => $expiresAt,
            ]);
        } else {
            if ($tokenData) {
                return $tokenData['token'];
            }
            $apiTokenModel->insert([
                'user_id' => $userId,
                'token' => $token,
                'created_at' => Time::now(),
                'expires_at' => $expiresAt,
            ]);
        }
        return $token;
    } else {
        return (["message" => "Erreur, vous ne pouvez plus créer de token"]);
    }
}

function validateToken($token)
{
    $apiTokenModel = new ApiTokenModel();
    $blacklistModel = new BlacklistModel();
    $tokenData = $apiTokenModel->where('token', $token)->first();

    if ($tokenData && $tokenData['expires_at'] > Time::now() && $tokenData['counter'] > 0) {
        $apiTokenModel->decount($tokenData['user_id']);
        return $tokenData['user_id']; // Retourne l’ID utilisateur si valide
    }
    if ( $tokenData && $tokenData['counter'] == 0 ) {

        $blacklistModel->insert([
            'user_id' => $tokenData['user_id'],
            'created_at' => Time::now(),
        ]);
        $apiTokenModel->where('token', $token)->delete();
    }
    return null; // Token invalide ou expiré
}

