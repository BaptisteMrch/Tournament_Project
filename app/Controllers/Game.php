<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Game extends BaseController
{
    public function getindex()
    {
        $gm = Model("GameModel");
        $games = $gm->withDeleted()->getAllGames();
        return $this->view('/front/game/index.php', ["games" => $games]);
    }
}
