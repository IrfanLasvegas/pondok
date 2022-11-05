<?php

namespace App\Models;

use CodeIgniter\Model;

class OrangTuaModel extends Model
{
    
    protected $table = "orang_tuas";
    protected $primaryKey = "id";
    protected $returnType = "object"; //$returnType dengan nilai object karena kita ingin untuk return type nanti berupa object. bisa juga array
    protected $useTimestamps = true; //$useTimestamps dengan nilai true karena kita akan mengisikan kolom created_at (saat insert data), dan kolom updated_at (saat update data)
    protected $allowedFields = ['users_id','jenis_kelamin', 'no_telp', 'alamat'];

    public function getOrangTua($keyword=null)
    {
        $this->builder()->select('users.username, users.email, users.active, orang_tuas.*');
        $this->builder()->join('users', 'users.id = orang_tuas.users_id');
        if($keyword != ''){
            $this->builder->like('username',$keyword);
            $this->builder->orLike('email',$keyword);
        }
        return $this;
    }

    public function getOneOrangTua($id=null)
    {
        $builder = $this->db->table('orang_tuas');
        $builder->select('users.username, users.email, users.active, orang_tuas.*');
        $builder->join('users', 'users.id = orang_tuas.users_id');
        $builder->where('orang_tuas.id',$id);
        $query = $builder->get()->getRow();
        return $query;
    }

    public function getOneOrangTuaByEmail($email=null)
    {
        $builder = $this->db->table('orang_tuas');
        $builder->select('users.username, users.email, users.active, orang_tuas.*');
        $builder->join('users', 'users.id = orang_tuas.users_id');
        $builder->where('users.email',$email);
        $query = $builder->get()->getRow();
        return $query;
    }

    // protected $DBGroup          = 'default';
    // protected $table            = 'orang_tuas';
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
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
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
