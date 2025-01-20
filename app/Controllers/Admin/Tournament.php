<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Tournament extends BaseController
{
    public function getindex($id = null)
    {
        $tm = Model("TournamentModel");
        $games = Model("GameModel")->getAllGames();
        $tournaments = $tm->getTournamentsWithGameName();

        if ($id == null) {
            return $this->view('/admin/tournament/index.php',["tournaments" => $tournaments, "games" => $games], true);
        } else {
            if ($id == "new") {
                return $this->view("/admin/tournament/tournament",["games" => $games], true);
            }
            if ($tournaments) {
                return $this->view("/admin/tournament/tournament", ["tournaments" => $tournaments, "games" => $games], true);
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
}
