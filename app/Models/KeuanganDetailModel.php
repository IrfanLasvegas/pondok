<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganDetailModel extends Model
{
    protected $table = "keuangan_details";
    protected $primaryKey = "id";
    protected $returnType = "object"; //$returnType dengan nilai object karena kita ingin untuk return type nanti berupa object. bisa juga array
    protected $useTimestamps = true; //$useTimestamps dengan nilai true karena kita akan mengisikan kolom created_at (saat insert data), dan kolom updated_at (saat update data)
    protected $allowedFields = ['keuangans_id', 'nominal', 'status'];

    
    public function getKeuanganDetail($keyword=null)
    {
        $this->builder()->select('keuangans.title, keuangan_details.*');
        $this->builder()->join('keuangans', 'keuangans.id = keuangan_details.keuangans_id');
        if($keyword != ''){
            $this->builder->like('title',$keyword);
        }
        return $this;
    }



    // protected $DBGroup          = 'default';
    // protected $table            = 'keuangan_details';
    // protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    // protected $insertID         = 0;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    // protected $allowedFields    = [];

    // // Dates
    // protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
}
