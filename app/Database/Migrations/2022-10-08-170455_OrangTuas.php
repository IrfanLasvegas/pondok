<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrangTuas extends Migration
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
			
			'jenis_kelamin'       => [
				'type'              => 'ENUM',
				'constraint'        => "'pria','wanita'",
                'null'           => true,
			],
			'no_telp' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
                'null'           => true,
			],
		
			'alamat' => [
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
        $this->forge->createTable('orang_tuas');
    }

    public function down()
    {
        //
        $this->forge->dropTable('orang_tuas');
        
    }
}
