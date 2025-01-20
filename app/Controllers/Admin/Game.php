<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Game extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard'],['text'=> 'Gestion des jeux', 'url' => '/admin/game']];

    public function getindex($id = null) {

        $gm = Model("GameModel");
        $categories = Model("CategoryGameModel")->getAllCategories();
        $games = $gm->withDeleted()->getGameById($id);

        if ($id == null) {
            return $this->view("/admin/game/index.php",["games" => $games], true);
        } else {
            if ($id == "new") {
                $this->addBreadcrumb('Création d\'un jeu','');
                return $this->view("/admin/game/game",["categories" => $categories], true);
            }
            if ($games) {
                $this->addBreadcrumb('Modification de ' . $games['name'], '');
                return $this->view("/admin/game/game", ["games" => $games, "categories" => $categories ], true);
            } else {
                $this->error("L'ID du jeu n'existe pas");
                $this->redirect("/admin/game");
            }
        }
    }

    public function postupdate() {
        // Récupération des données envoyées via POST
        $data = $this->request->getPost();

        // Récupération du modèle UserModel
        $gm = Model("GameModel");

        // Mise à jour des informations utilisateur dans la base de données
        if ($gm->updateGame($data['id'], $data)) {
            // Si la mise à jour réussit
            $this->success("Le jeu a bien été modifié.");
        } else {
            $errors = $gm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        // Redirection vers la page des utilisateurs après le traitement
        return $this->redirect("/admin/game");
    }



    public function postcreate() {
        $data = $this->request->getPost();
        $gm = Model("GameModel");

        // Créer l'utilisateur et obtenir son ID
        $newSchoolId = $gm->createGame($data);

        // Vérifier si la création a réussi
        if ($newSchoolId) {
            $this->success("Le jeu à bien été ajouté.");
            $this->redirect("/admin/game");
        } else {
            $errors = $gm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect("/admin/game/new");
        }
    }

    public function getdelete($id){
        $gm = Model('GameModel');
        if ($gm->deleteGame($id)) {
            $this->success("Jeu supprimé");
        } else {
            $this->error("Jeu non supprimé");
        }
        $this->redirect('/admin/game');
    }


    /**
     * Renvoie pour la requete Ajax les stocks fournisseurs rechercher par SKU ( LIKE )
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function postSearchGame()
    {
        $gm = model('GameModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDirection = $this->request->getPost('order')[0]['dir'] ?? 'asc';
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'] ?? 'id';


        // Obtenez les données triées et filtrées
        $data = $gm->getPaginatedGame($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $gm->getTotalGame();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $gm->getFilteredGame($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }

    public function getdeactivate($id){
        $gm = Model('GameModel');
        if ($gm->deleteGame($id)) {
            $this->success("Jeu désactivé");
        } else {
            $this->error("Jeu non désactivé");
        }
        $this->redirect('/admin/game');
    }

    public function getactivate($id){
        $gm = Model('GameModel');
        if ($gm->activateGame($id)) {
            $this->success("Jeu activé");
        } else {
            $this->error("Jeu non activé");
        }
        $this->redirect('/admin/game');
    }
}
