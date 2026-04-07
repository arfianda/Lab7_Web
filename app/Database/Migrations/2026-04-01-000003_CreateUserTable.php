<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'useremail' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'userpassword' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('useremail');
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
