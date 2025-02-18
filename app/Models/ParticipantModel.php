<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantModel extends Model
{
    protected $table = 'participant';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['id_tournament','id_user'];

    // Activer le soft delete
    protected $useSoftDeletes = false;

    // Champs de gestion des dates
    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules = [];

    protected $validationMessages = [];

    public function getParticipantById($id)
    {
        return $this->find($id);
    }
    public function getAllParticipants()
    {
        return $this->findAll();
    }

    public function deleteParticipant($id_tournament, $id_user)
    {
        $builder = $this->db->table('participant');
        $builder->where('id_tournament', $id_tournament);
        $builder->where('id_user', $id_user);

        return $builder->delete(); // Supprime les enregistrements correspondant aux conditions
    }

    public function insertParticipant($id_tournament, $id_user)
    {
            return $this->insert([
                'id_tournament' => $id_tournament,
                'id_user' => $id_user
            ]);

    }


    public function getParticipantWithUser()
    {
        $builder = $this->db->table('participant');
        $builder->select('participant.*, user.username as user_name');
        $builder->join('user', 'user.id = participant.id_user', 'left'); // Jointure correcte entre id_user et id
        return $builder->get()->getResultArray(); // Récupère les résultats sous forme de tableau associatif
    }

    public function unregisterParticipant($id_tournament, $id_user)
    {
        $this->db->table('participant')->delete(['id_tournament' => $id_tournament, 'id_user' => $id_user]);
    }

    public function getParticipantsByTournament($id_tournament)
    {
        // Sélectionner les participants associés à ce tournoi
        return $this->db->table('participant')  // Nom de la table des participants
        ->select('participant.*, user.username as user_name')  // Sélectionner les informations des participants
        ->join('user', 'user.id = participant.id_user')  // Rejoindre la table des utilisateurs pour récupérer le nom
        ->where('participant.id_tournament', $id_tournament)  // Filtrer par ID du tournoi
        ->get()
            ->getResultArray();  // Récupérer les résultats sous forme de tableau
    }

    public function countParticipants($id_tournament)
    {
        // Compter le nombre de participants pour ce tournoi
        return $this->db->table('participant') // Remplacez 'participants' par le nom de la table qui contient les participants
        ->where('id_tournament', $id_tournament)
            ->countAllResults(); // Compte le nombre de lignes qui correspondent à ce tournoi
    }

    public function getTournamentsWithParticipants()
    {
        // Récupérer tous les tournois
        $tournaments = $this->findAll();

        // Ajouter le nombre de participants pour chaque tournoi
        foreach ($tournaments as &$tournament) {
            // Compter les participants
            $count = $this->countParticipants($tournament['id']);
        }

        return $count;
    }

}
