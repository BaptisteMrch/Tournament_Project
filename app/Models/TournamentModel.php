<?php

namespace App\Models;

use CodeIgniter\Model;

class TournamentModel extends Model
{
    protected $table = 'tournament';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['name','id_game','created_at', 'updated_at', 'deleted_at'];

    // Activer le soft delete
    protected $useSoftDeletes = true;

    // Champs de gestion des dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|is_unique[tournament.name,id,{id}]|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom est requis.',
            'min_length' => 'Le nom doit comporter au moins 0 caractères.',
            'max_length' => 'Le nom ne doit pas dépasser 100 caractères.',
            ],
    ];

    public function getTournamentById($id)
    {
        return $this->find($id);
    }
    public function getAllTournaments()
    {
        return $this->findAll();
    }

    public function createTournament($data)
    {
        // Charger le modèle `GameModel`
        $gameModel = model('GameModel');

        // Vérifier si l'id_game existe dans la table game
        if (!$gameModel->find($data['id_game'])) {
            return false; // Retourner une erreur si le jeu n'existe pas
        }

        return $this->insert($data);
    }
    public function updateTournament($id, $data)
    {
        $builder = $this->builder();
        $data['updated_at'] = ('Y-m-d H:i:s');
        $builder->where('id', $id);
        return $builder->update($data);
    }
    public function deleteTournament($id)
    {
        return $this->delete($id);
    }

    public function getPaginatedTournament($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->table('tournament');
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

    public function getTotaltournament()
    {
        $builder = $this->table('tournament');
        return $builder->countAllResults();
    }

    public function getFilteredtournament($searchValue)
    {
        $builder = $this->table('tournament');
        // @phpstan-ignore-next-line
        if (! empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }

    public function activateTournament($id) {
        $builder = $this->builder();
        $builder->set('deleted_at', NULL);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function getTournamentsWithGameName()
    {
        $builder = $this->db->table('tournament');
        $builder->select('tournament.*, game.name as game_name');
        $builder->join('game', 'game.id = tournament.id_game', 'left'); // Jointure entre tournament et game
        return $builder->get()->getResultArray(); // Récupère les résultats sous forme de tableau associatif
    }

}
