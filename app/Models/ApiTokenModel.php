<?php
namespace App\Models;

use CodeIgniter\Model;

class ApiTokenModel extends Model
{
    protected $table = 'api_token';

    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'token', 'counter', 'created_at', 'expires_at'];

    protected $useTimestamps = false;

    public function decount($userId)
    {
        $this->where('user_id', $userId)->set('counter', 'counter - 1', false)->update();
    }

    public function updateAllCounters($newCounter)
    {
        if ($newCounter === null) {
            return $this->set(['counter' => null])->where('id >', 0)->update();
        }
        return $this->set(['counter' => $newCounter])->where('id >', 0)->update();
    }

}