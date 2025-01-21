<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Tournament extends BaseController
{

    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard'],['text'=> 'Gestion des tournois', 'url' => '/admin/tournament']];

    public function getindex($id = null)
    {
        $tm = Model("TournamentModel");
        $games = Model("GameModel")->getAllGames();
        $tournaments = $tm->getTournamentsWithGameName();
        $tournament = $tm->getTournamentById($id);
        $pm = Model("ParticipantModel");
        $participants = $pm->getParticipantWithUser();

        if ($id == null) {
            return $this->view('/admin/tournament/index.php',["tournaments" => $tournaments, "games" => $games], true);
        } else {
            if ($id == "new") {
                $this->addBreadcrumb('Création d\'un tournois','');
                return $this->view("/admin/tournament/tournament",["tournament" => $tournament, "games" => $games], true);
            }
            if ($tournaments) {
                $this->addBreadcrumb('Modification de ' . $tournament['name'], '');
                return $this->view("/admin/tournament/tournament", ["tournament" => $tournament, "games" => $games, "participants" => $participants], true);
            } else {
                $this->error("L'ID du tournois n'existe pas");
                $this->redirect("/admin/tournament");
            }
        }
    }

    public function postupdate() {
        // Récupération des données envoyées via POST
        $data = $this->request->getPost();

        // Récupération du modèle UserModel
        $tm = Model("TournamentModel");

        // Mise à jour des informations utilisateur dans la base de données
        if ($tm->updateTournament($data['id'], $data)) {
            // Si la mise à jour réussit
            $this->success("Le tournois a bien été modifié.");
        } else {
            $errors = $tm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        // Redirection vers la page des utilisateurs après le traitement
        return $this->redirect("/admin/tournament");
    }



    public function postcreate() {
        $data = $this->request->getPost();
        $tm = Model("tournamentModel");

        // Créer l'utilisateur et obtenir son ID
        $newSchoolId = $tm->createTournament($data);

        // Vérifier si la création a réussi
        if ($newSchoolId) {
            $this->success("Le tournois à bien été ajouté.");
            $this->redirect("/admin/tournament");
        } else {
            $errors = $tm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect("/admin/tournament/new");
        }
    }

    public function getdelete($id){
        $tm = Model('tournamentModel');
        if ($tm->deleteTournament($id)) {
            $this->success("Tournois supprimé");
        } else {
            $this->error("Tournois non supprimé");
        }
        $this->redirect('/admin/tournament');
    }

    public function getdeleteparticipant(){
        $id_user = $this->get('id_user');
        $id_tournament = $this->get('id_tournament');
        $tm = Model('participantModel');
        if ($tm->deleteParticipant($id_tournament, $id_user)) {
            $this->success("Participant supprimé");
        } else {
            $this->error("Participant non supprimé");
        }
        $this->redirect('/admin/tournament');
    }

    public function getdeactivate($id){
        $um = Model('TournamentModel');
        if ($um->deleteTournament($id)) {
            $this->success("Tournoi désactivé");
        } else {
            $this->error("Tournoi non désactivé");
        }
        $this->redirect('/admin/tournament');
    }

    public function getactivate($id){
        $um = Model('TournamentModel');
        if ($um->activateTournament($id)) {
            $this->success("Tournoi activé");
        } else {
            $this->error("Tournoi non activé");
        }
        $this->redirect('/admin/tournament');
    }
}
