<?php
namespace App\Models;

use CodeIgniter\Model;

class BlacklistModel extends Model
{
    protected $table = 'blacklist_token';

    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'created_at'];

    protected $useTimestamps = false;


    public function add_blacklist($id){

        $builder = $this->builder();
        return $builder->insert([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }

    public function unblacklist($id) {

        $builder = $this->builder();
        $builder->where('user_id', $id);
        return $builder->delete();
    }

    public function isBlacklisted($id)
    {
        $builder = $this->builder();
        $builder->where('user_id', $id);
        return $builder->countAllResults() > 0;
    }

    function addToBlacklistuser($userId)
    {
        return $this->insert([
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

}
