<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table = 'game';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['name', 'id_category','created_at', 'updated_at', 'deleted_at'];

    // Activer le soft delete
    protected $useSoftDeletes = true;

    // Champs de gestion des dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|is_unique[school.name,id,{id}]|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom d\'ecole est requis.',
            'min_length' => 'Le nom d\'ecole doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom d\'ecole ne doit pas dépasser 100 caractères.',
            'is_unique'   => 'Ce nom d\'ecole est déja utilisé.',
        ],
    ];

    // Relations avec les permissions
    public function getCategory()
    {
        return $this->join('game_category', 'game.id_category = game_category.id')
            ->select('game.*, game_category.name as category_name')
            ->findAll();
    }

    public function getGameById($id)
    {
        return $this->find($id);
    }
    public function getAllGames()
    {
        return $this->findAll();
    }

    public function createGame($data)
    {
        return $this->insert($data);
    }
    public function updateGame($id, $data)
    {
        return $this->update($data);
    }
    public function deleteGame($id)
    {
        return $this->delete($id);
    }

    public function getPaginatedGame($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->table('game');
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
        $builder = $this->table('game');
        return $builder->countAllResults();
    }

    public function getFilteredGame($searchValue)
    {
        $builder = $this->table('game');
        // @phpstan-ignore-next-line
        if (! empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }
}
