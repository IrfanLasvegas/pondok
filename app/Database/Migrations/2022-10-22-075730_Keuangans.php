<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Keuangans extends Migration
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
			'title' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
                'null'           => true,
			],
			'description' => [
				'type' => 'TEXT',
				'null' => true,
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
        $this->forge->createTable('Keuangans');
    }

    public function down()
    {
        //
        $this->forge->dropTable('Keuangans');
    }
}
