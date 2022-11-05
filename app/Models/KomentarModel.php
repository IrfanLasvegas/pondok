<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table = "komentars";
    protected $primaryKey = "id";
    protected $returnType = "object"; //$returnType dengan nilai object karena kita ingin untuk return type nanti berupa object. bisa juga array
    protected $useTimestamps = true; //$useTimestamps dengan nilai true karena kita akan mengisikan kolom created_at (saat insert data), dan kolom updated_at (saat update data)
    protected $allowedFields = ['users_id','beritas_id', 'parent_komentar_id', 'comment_text'];

    // 
    public function listComment($brt_id=null)
    {
        $builder = $this->db->table('komentars');
        $builder->select('users.username, komentars.*');
        $builder->join('beritas', 'beritas.id = komentars.beritas_id');
        $builder->join('users', 'users.id = komentars.users_id');
        $builder->where('parent_komentar_id', '0');
        $builder->where('beritas_id',$brt_id);
        $builder->orderBy('id', 'DESC');
        $query = $builder->get()->getResult();
        return $query;
    }

    public function listLevelComment($parent_id=null)
    {
        $builder = $this->db->table('komentars');
        $builder->select('users.username, komentars.*');
        $builder->join('beritas', 'beritas.id = komentars.beritas_id');
        $builder->join('users', 'users.id = komentars.users_id');
        $builder->where('parent_komentar_id',$parent_id);
        $builder->orderBy('id', 'DESC');
        // $query = $builder->get()->getResult();
        $query = $builder->get();
        return $query;
    }

    // protected $DBGroup          = 'default';
    // protected $table            = 'komentars';
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
