<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TournamentOptions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'value' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tournament_options');
    }

    public function down()
    {
        //
    }
}
