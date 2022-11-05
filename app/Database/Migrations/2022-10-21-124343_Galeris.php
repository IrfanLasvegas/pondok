<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Galeris extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
            'users_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				
			],
			'title' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
                'null'           => true,
			],
			'description' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'gambar' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
                'null'           => true,
			],
			'created_at' => [
				'type'           => 'DATETIME',
				'null'           => true,
			],
			'updated_at' => [
				'type'           => 'DATETIME',
				'null'           => true,
			]
		]);
		$this->forge->addPrimaryKey('id');
		$this->forge->addForeignKey('users_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Galeris');
    }

    public function down()
    {
        //
        $this->forge->dropTable('Galeris');
    }
}
