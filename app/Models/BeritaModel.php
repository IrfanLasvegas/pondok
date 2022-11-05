<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = "beritas";
    protected $primaryKey = "id";
    protected $returnType = "object"; //$returnType dengan nilai object karena kita ingin untuk return type nanti berupa object. bisa juga array
    protected $useTimestamps = true; //$useTimestamps dengan nilai true karena kita akan mengisikan kolom created_at (saat insert data), dan kolom updated_at (saat update data)
    protected $allowedFields = ['users_id','title', 'slug', 'description', 'status', 'gambar'];


    // public function getBerita($keyword=null)
    // {
    //     $this->builder()->select('users.username, beritas.*');
    //     $this->builder()->join('users', 'users.id = beritas.users_id');
    //     if($keyword != ''){
    //         $this->builder->like('title',$keyword);
    //         $this->builder->orLike('description',$keyword);
    //     }
    //     return $this;
    // }

    public function getBerita($keyword=null, $status=null)
    {
        $this->builder()->select('users.username, beritas.*');
        $this->builder()->join('users', 'users.id = beritas.users_id');
        if($keyword != '' && $status != ''){
            $this->builder->where('beritas.status',$status);
            $this->builder->like('title',$keyword);
            $this->builder->orLike('description',$keyword);
        }else if($keyword == '' && $status != ''){
            $this->builder->where('beritas.status',$status);
        }else if($keyword != '' && $status == ''){
            $this->builder->like('title',$keyword);
            $this->builder->orLike('description',$keyword);
        }
        $this->builder()->orderBy('id', 'DESC');
        return $this;
    }


    // protected $DBGroup          = 'default';
    // protected $table            = 'beritas';
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
