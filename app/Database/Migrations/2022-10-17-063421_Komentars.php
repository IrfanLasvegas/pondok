<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Komentars extends Migration
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
            'beritas_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				
			],
            'parent_komentar_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				
			],

			'comment_text' => [
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
        $this->forge->addForeignKey('beritas_id', 'beritas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('komentars');
    }

    public function down()
    {
        //
        $this->forge->dropTable('komentars');
    }
}
