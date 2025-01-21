<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tournament extends BaseController
{
    public function getindex()
    {
        $tm = Model("TournamentModel");
        $tournaments = $tm->getTournamentsWithGameNameFront();
        return $this->view('/front/tournament/index.php', ["tournaments" => $tournaments]);
    }

    public function postregister()
    {
        $session = session();
        $pm = Model("ParticipantModel");

        $id_tournament = $this->request->getPost('id_tournament');
        $id_user = $this->request->getPost('id_user');

        if ($pm->insertParticipant($id_tournament, $id_user)) {
            return redirect()->back()->with('success', 'Inscription réussie !');
        } else {
            return redirect()->back()->with('error', 'Vous êtes déjà inscrit à ce tournoi.');
        }

        $this->redirect('/tournament');
    }

}
