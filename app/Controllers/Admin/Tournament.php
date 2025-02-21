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
        $tournaments = Model("TournamentModel")->getTournamentsWithGameName();
        $tournament = Model("TournamentModel")->getTournamentById($id);
        $participants = Model("ParticipantModel")->getParticipantsByTournament($id);
        $games = Model("GameModel")->getAllGames();

        if ($id == null) {
            return $this->view('/admin/tournament/index.php',["tournaments" => $tournaments, "games" => $games], true);

        } else {
            if ($id == "new") {
                $this->addBreadcrumb('Création d\'un tournois','');
                return $this->view("/admin/tournament/tournament",["tournament" => $tournament, "games" => $games, "participants" => $participants], true);
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

        $data = $this->request->getPost();
        $tm = Model("TournamentModel");

        if ($tm->updateTournament($data['id'], $data)) {
            $this->success("Le tournois a bien été modifié.");
        } else {
            $errors = $tm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }
        return $this->redirect("/admin/tournament");
    }

    public function postcreate() {
        $data = $this->request->getPost();
        $tm = Model("tournamentModel");
        $newTournamentId = $tm->createTournament($data);

        if ($newTournamentId) {
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

    public function getdeleteparticipant() {
        $tm = model('ParticipantModel');
        $id_user = $this->request->getGet('id_user');
        $id_tournament = $this->request->getGet('id_tournament');

        if ($tm->deleteParticipant($id_tournament, $id_user)) {
            $this->success("Participant supprimé");
        } else {
            $this->error("Participant non supprimé");
        }
        $this->redirect('/admin/tournament');
    }

    public function getdeactivate($id){
        $tm = Model('TournamentModel');
        if ($tm->deleteTournament($id)) {
            $this->success("Tournoi désactivé");
        } else {
            $this->error("Tournoi non désactivé");
        }
        $this->redirect('/admin/tournament');
    }

    public function getactivate($id){
        $tm = Model('TournamentModel');
        if ($tm->activateTournament($id)) {
            $this->success("Tournoi activé");
        } else {
            $this->error("Tournoi non activé");
        }
        $this->redirect('/admin/tournament');
    }
}
