<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUser extends Migration
{
    public function up()
    {
        $data = [
            'username'     => 'user',
            'name'         => 'Test',
            'firstname'    => 'Test',
            'email'        => 'user@user.fr',
            'password'     => password_hash('user', PASSWORD_DEFAULT),
            'id_permission' => 3, // Id de la permission User
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        $this->db->table('user')->insert($data);
    }

    public function down()
    {
        //
    }
}
