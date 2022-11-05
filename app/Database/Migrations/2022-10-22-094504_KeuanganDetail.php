<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KeuanganDetail extends Migration
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
            'keuangans_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				
			],
			'nominal' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
                'null'           => true,
			],
			'status' => [
				'type'       => 'ENUM',
				'constraint' => ['0', '1'],
				'default'    => '0',
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
		$this->forge->addForeignKey('keuangans_id', 'keuangans', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('keuangan_details');
    }

    public function down()
    {
        //
        $this->forge->dropTable('keuangan_details');
    }
}
