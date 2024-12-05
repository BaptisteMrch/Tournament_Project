<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table = 'game';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name','id_category'];

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom du jeux est requis.',
            'min_length' => 'Le nom du jeux doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom du jeux ne doit pas dépasser 100 caractères.',
        ],
    ];

    public function createGame($data)
    {
        // Pas de génération de slug ici
        return $this->insert($data);
    }

    public function updateGame($id, $data)
    {
        return $this->update($id, $data);
    }

    public function getGameById($id)
    {
        return $this->find($id);
    }


    public function getAllGame()
    {
        return $this->findAll();
    }

    public function deleteGame($id)
    {
        return $this->delete($id);
    }

    public function deactivateGame($id) {
        $builder = $this->builder();
        $builder->set('deleted_at', date('Y-m-d H:i:s'));
        $builder->where('id', $id);
        return $builder->update();
    }

    public function activateGame($id) {
        $builder = $this->builder();
        $builder->set('deleted_at', NULL);
        $builder->where('id', $id);
        return $builder->update();
    }


    public function getPaginatedGame($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        // Recherche
        if ($searchValue != null) {
            $builder->like('name', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotalGame()
    {
        $builder = $this->builder();
        return $builder->countAllResults();
    }

    public function getFilteredGame($searchValue)
    {
        $builder = $this->builder();
        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }
}
