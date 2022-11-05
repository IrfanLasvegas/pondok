<?php

namespace App\Models;

use CodeIgniter\Model;
use Myth\Auth\Models\UserModel as MythModel;

class UserModel extends MythModel
{
    protected $table   = 'users';
    protected $returnType = 'App\Entities\User';
    // protected $useTimestamps = true; //$useTimestamps dengan nilai true karena kita akan mengisikan kolom created_at (saat insert data), dan kolom updated_at (saat update data)
    // protected $skipValidation     = true;
    protected $allowedFields = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
        'firstname', 'lastname', 'phone',
    ];
    

    // jika ingin melakukan join,where,dll buatlah di dalam fungsi seperti dibawah
    // public function getUser()
    // {
    //     $builder = $this->db->table('users');
    //     $builder->select('id, username , email, created_at');
    //     $query = $builder->get();
    //     return $query;

    // }
    
    // with pagination
    // public function getUser()
    // {
    //     $this->builder()->select('id, username , email, created_at');
    //     return $this;
    // }

    public function getUser($keyword=null)
    {
        $this->builder()->select('id, username , email, created_at, active');
        if($keyword != ''){
            $this->builder->like('username',$keyword);
            $this->builder->orLike('email',$keyword);
        }
        return $this;
    }

    public function getUserWithRole($id){
        // $this->builder()->select('*');
        // $this->builder()->join('auth_groups_users', 'auth_groups_users.group_id = users.id');
        // return $this;
        $builder = $this->db->table('auth_groups_users a');
        $builder->select('a.user_id, a.group_id, b.id, b.username, b.email, c.name');
        $builder->join('users b', 'b.id = a.user_id');
        $builder->join('auth_groups c', 'c.id = a.group_id');
        $builder->where('user_id',$id);
        // $builder->where('id', $id);
        $query = $builder->get()->getRow();
        return $query;

    }


    
    // protected $DBGroup          = 'default';
    // protected $table            = 'users';
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
