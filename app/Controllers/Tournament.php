<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tournament extends BaseController
{
    public function getindex()
    {
        $tm = Model("TournamentModel");
        $tournaments = $tm->getTournamentsWithGameName();
        return $this->view('/front/tournament/index.php', ["tournaments" => $tournaments]);
    }
}
