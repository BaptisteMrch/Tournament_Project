<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Gamecategory extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    public function getindex($id = null) {

        $categoryModel = Model("/GameCategoryModel");
        $categories = $categoryModel->findAll();

        if ($id == null) {
            return $this->view('/admin/game/index-category', ['categories' => $categories], true);
        } else {
            $gcm = Model("GameCategoryModel");
            if ($id == "new") {
                return $this->view('/admin/game/game-category', [], true);
            }
            $category = $gcm->getGameCategoryById($id);
            return $this->view('/admin/game/game-category', ["category" => $category, 'categories' => $categories], true);
        }
    }

    public function postupdate() {
        $data = $this->request->getPost();
        $gcm = Model("/GameCategoryModel");
        if ($gcm->updateCategory($data['id'], $data)) {
            $this->success("La catégorie à bien été modifié");
        } else {
            $this->error("Une erreur est survenue");
        }
        $this->redirect("/admin/gamecategory");
    }

    public function postcreate() {
        $data = $this->request->getPost();
        $gcm = Model("GameCategoryModel");
        if ($gcm->createCategory($data)) {
            $this->success("La catégorie à bien été ajouté.");
            $this->redirect("/admin/gamecategory");
        } else {
            $errors = $gcm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect("/admin/gamecategory/new");
        }
    }

    public function getdelete($id){
        $gcm = Model('GameCategoryModel');
        if ($gcm->deleteCategory($id)) {
            $this->success("Catégorie supprimé");
        } else {
            $this->error("Catégorie non supprimé");
        }
        $this->redirect('/admin/gamecategory');
    }

    public function postSearchPermission()
    {
        $UserModel = model('App\Models\UserPermissionModel');

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
        $data = $UserModel->getPaginatedPermission($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $UserModel->getTotalPermission();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $UserModel->getFilteredPermission($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }
}