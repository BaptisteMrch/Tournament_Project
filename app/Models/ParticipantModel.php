<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantModel extends Model
{
    protected $table = 'participant';


    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['id_tournament','id_user'];

    // Activer le soft delete
    protected $useSoftDeletes = true;

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

    public function deleteParticipant($id_tournament,$id_user)
    {
        $builder = $this->db->table('participant');
        $builder->where('id_tournament',$id_tournament);
        $builder->where('id_user',$id_user);
        return $this->delete($id_tournament and $id_user);
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
    $builder->select('participant.id_user, user.username as user_name');
    $builder->join('user', 'user.id = participant.id_user', 'left'); // Jointure correcte entre id_user et id
    return $builder->get()->getResultArray(); // Récupère les résultats sous forme de tableau associatif
    }

}
