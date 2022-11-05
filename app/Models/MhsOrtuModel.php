<?php

namespace App\Models;

use CodeIgniter\Model;

class MhsOrtuModel extends Model
{
    protected $table = "mhs_ortus";
    protected $primaryKey = "id";
    protected $returnType = "object"; //$returnType dengan nilai object karena kita ingin untuk return type nanti berupa object. bisa juga array
    protected $useTimestamps = true; //$useTimestamps dengan nilai true karena kita akan mengisikan kolom created_at (saat insert data), dan kolom updated_at (saat update data)
    protected $allowedFields = ['mahasiswas_id','orang_tuas_id'];

    public function getMhsOrtu($mhs_id=null)
    {
        $builder = $this->db->table('mhs_ortus');
        $builder->select('users.username, users.email ,orang_tuas.*, mhs_ortus.*');
        $builder->join('orang_tuas', 'orang_tuas.id = mhs_ortus.orang_tuas_id');
        $builder->join('users', 'users.id = orang_tuas.users_id');
        $builder->where('mahasiswas_id',$mhs_id);
        $query = $builder->get()->getResult();
        return $query;
    }

    public function getOrtuMhs($ortu_id=null)
    {
        $builder = $this->db->table('mhs_ortus');
        $builder->select('users.username, users.email ,mahasiswas.*, mhs_ortus.*');
        $builder->join('mahasiswas', 'mahasiswas.id = mhs_ortus.mahasiswas_id');
        $builder->join('users', 'users.id = mahasiswas.users_id');
        $builder->where('orang_tuas_id',$ortu_id);
        $query = $builder->get()->getResult();
        return $query;
    }



    public function getMhsOrtuByIdEmail($mhs_id=null, $email=null)
    {
        $builder = $this->db->table('mhs_ortus');
        $builder->select('users.username, users.email ,orang_tuas.*, mhs_ortus.*');
        $builder->join('orang_tuas', 'orang_tuas.id = mhs_ortus.orang_tuas_id');
        $builder->join('users', 'users.id = orang_tuas.users_id');
        $builder->where('mahasiswas_id',$mhs_id);
        $builder->where('users.email',$email);
        $query = $builder->get()->getRow();
        return $query;
    }



    public function getOrtuMhsIdEmail($ortu_id=null, $email=null)
    {
        $builder = $this->db->table('mhs_ortus');
        $builder->select('users.username, users.email ,mahasiswas.*, mhs_ortus.*');
        $builder->join('mahasiswas', 'mahasiswas.id = mhs_ortus.mahasiswas_id');
        $builder->join('users', 'users.id = mahasiswas.users_id');
        $builder->where('orang_tuas_id',$ortu_id);
        $builder->where('users.email',$email);
        $query = $builder->get()->getRow();
        return $query;
    }
    
    // protected $DBGroup          = 'default';
    // protected $table            = 'mhsortus';
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
