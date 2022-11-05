<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Beritas extends Migration
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
			'slug' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
                'null'           => true,
			],
			'description' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'status' => [
				'type'       => 'ENUM',
				'constraint' => ['publish', 'pending', 'draft'],
				'default'    => 'pending',
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
        $this->forge->createTable('Beritas');
    }

    public function down()
    {
        //
		$this->forge->dropTable('Beritas');
    }
}
