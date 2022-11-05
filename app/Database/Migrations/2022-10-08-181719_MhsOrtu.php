<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MhsOrtu extends Migration
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
            'mahasiswas_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,				
			],
			
			'orang_tuas_id'       => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
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
		$this->forge->addForeignKey('mahasiswas_id', 'mahasiswas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('orang_tuas_id', 'orang_tuas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mhs_ortus');
    }

    public function down()
    {
        //
        $this->forge->dropTable('mhs_ortus');
        
    }
}
