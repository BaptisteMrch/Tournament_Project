<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tournament extends BaseController
{
    public function getindex()
    {
        $tm = Model("TournamentModel");
        $pm = model("ParticipantModel");

        $tournaments = $tm->getTournamentsWithGameNameFront();
        $participants = $pm->getParticipantWithUser();

        return $this->view('/front/tournament/index.php', ["tournaments" => $tournaments, "participants" => $participants]);

    }

    public function getregister()
    {
        $pm = Model("ParticipantModel");

        $id_tournament = $this->request->getGet('id_tournament');
        $id_user = $this->request->getGet('id_user');

        $newParticipantId = $pm->insertParticipant($id_tournament, $id_user);
        if ($newParticipantId) {
            $this->success("Le participant à bien été inscrit au tournoi");
            $this->redirect('/tournament');
        } else {
            $errors = $pm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect('/tournament');
        }
    }

    public function getunregister()
    {
        $pm = Model("ParticipantModel");

        $id_tournament = $this->request->getGet('id_tournament');
        $id_user = $this->request->getGet('id_user');

        $pm->unregisterParticipant($id_tournament, $id_user);

        $this->redirect('/tournament');
    }
}
