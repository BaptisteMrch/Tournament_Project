<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Game extends BaseController
{
    protected $require_auth = true;
    protected $requiredGames = ['administrateur'];
    public function getindex($id = null) {
        if ($id == null) {
            return $this->view('/admin/game/index-game', [], true);
        } else {
            $g = Model("GameModel");
            if ($id == "new") {
                $categories = model("CategoryGameModel")->getAllCategoryGame();
                return $this->view('/admin/game/game', ["categories" => $categories], true);
            }
            $game = $g->getGameById($id);
            return $this->view('/admin/game/game', ["game" => $game], true);
        }
    }

    public function postupdate() {
        $data = $this->request->getPost();
        $g = Model("/GameModel");
        if ($g->updateGame($data['id'], $data)) {
            $this->success("Jeux à bien été modifié");
        } else {
            $this->error("Une erreur est survenue");
        }
        $this->redirect("/admin/game");
    }

    public function postcreate() {
        $data = $this->request->getPost();
        $g = Model("GameModel");
        if ($g->createGame($data)) {
            $this->success("Le jeux à bien été ajouté.");
            $this->redirect("/admin/game");
        } else {
            $errors = $g->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect("/admin/game/new");
        }
    }

    public function getdelete($id){
        $g = Model('GameModel');
        if ($g->deleteGame($id)) {
            $this->success("jeux supprimé");
        } else {
            $this->error("jeux non supprimé");
        }
        $this->redirect('/admin/game');
    }

    public function postSearchGame()
    {
        $GameModel = model('GameModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];

        // Obtenez les données triées et filtrées
        $data = $GameModel->getPaginatedGame($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $GameModel->getTotalGame();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $GameModel->getFilteredGame($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }

    public function getdeactivate($id){
        $g = Model('GameModel');
        if ($g->deactivateGame($id)) {
            $this->success("Jeux désactivée");
        } else {
            $this->error("Jeux non désactivée");
        }
        $this->redirect('/admin/game');
    }

    public function getactivate($id){
        $g = Model('GameModel');
        if ($g->activategame($id)) {
            $this->success("Jeux activée");
        } else {
            $this->error("Jeux non activée");
        }
        $this->redirect('/admin/game');
    }
}