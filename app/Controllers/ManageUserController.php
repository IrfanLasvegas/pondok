<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\MahasiswaModel;
use App\Models\OrangTuaModel;
use App\Models\UserModel;
use Myth\Auth\Password;

class ManageUserController extends BaseController
{
    function __construct()
    {
        $this->userM = new UserModel();
        $this->mahasiswaM = new MahasiswaModel();
        $this->orangTuaM = new OrangTuaModel();
        
    }

    public function index()
    {
        // $db = \Config\Database::connect();
        // $pager = \Config\Services::pager();
        $keyword = $this->request->getGet('keyword');
        // query biasa
        // $query = $db->query('SELECT id, username , email, created_at  FROM users'); 
        
        // query builder 2 bisa tapi kurang benar
        // $builder = $db->table('users');
        // $builder->select('id, username , email, created_at');
        // $query = $builder->get();

        // implementasi query builder  yang benar
        $model = new \App\Models\UserModel();
        // $query2 = $model->getUser()->get()->getResult();//tanpa pagination

        // $query2 = $model->getUser()->paginate(2,'group_user');
        $per_page=2;
        $query2 = $model->getUser($keyword)->paginate($per_page,'group_user');

        
        
        
    

        $data['title']   = 'Pesantren &mdash; Manage User';
        $data['section_header']   = 'Autentikasi';
        // $data['data_user']   = $query2;//tanpa pagination

        $data['data_user']   = $query2;
        $data['pager']  = $model->pager;
        $data['currentPage']  = $this->request->getVar('page_group_user');
        $data['tmp_keyword']   = $keyword;
        $data['per_page']   = $per_page;

        
        return view('admin/manageUser/index', $data);
    }

    public function create()
    {
        $authorize = service('authorization');
        $groups = $authorize->groups();
        $data['title']   = 'Pesantren &mdash; Manage User-Create';
        $data['section_header']   = 'Create User';
        $data['groups'] = $groups;
        return view('admin/manageUser/create',$data);
    }

    public function store()
    {
        if (strtolower($this->request->getMethod()) == 'post') {//untuk mengecek methodnya
            $authorize = service('authorization');
            // select all groups
            // $a=['c','s','d'];
            // $groups = $authorize->groups();
            // echo '--'.gettype($groups).'<br>';
            // echo '--'.gettype($a).'<br>';

            // echo '--'.($groups[0]->name).'<br>';



            

            // print_r($groups);
            // print_r($a);
            // dd($groups);
            
            
            $rules =[
                'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'role'    => 'required',
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }

            // Validate passwords since they can only be validated properly here
            $rules = [
                'password'     => 'required|strong_password',
                'pass_confirm' => 'required|matches[password]',
            ];

            if (! $this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }

            // cek role
            $group = $authorize->group($this->request->getPost('role'),);
            if(!$group){
                session()->setFlashdata('error2', 'no roles');
                return redirect()->back()->withInput();
                
            }

            // $new_hash = Password::hash($password);
            
            // return (Password::hash($this->request->getPost('password')));
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->insert([
                'username ' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password_hash' => Password::hash($this->request->getPost('password')),
                'active' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $tmp_user_id=$db->insertID();
            $authorize->addUserToGroup($tmp_user_id, $this->request->getPost('role'));
            
            if($this->request->getPost('role') == 'student'){
                $this->mahasiswaM->insert([
                    'users_id' => $tmp_user_id,
                ]);
            }
            if($this->request->getPost('role') == 'parent'){
                $this->orangTuaM->insert([
                    'users_id' => $tmp_user_id,
                ]);
            }


            
            // dd($tmp_user_id) ;
            
            
            

            // $users = model(UserModel::class);
            // $user              = new User([
            //     'username ' => $this->request->getPost('username'),
            //     'email' => $this->request->getPost('email'),
            //     'password_hash' => Password::hash($this->request->getPost('password')),
            //     'active' => '1',
            // ]);

            // $modelU = new \App\Models\UserModel();
            // $modelU->save([
            //     'username ' => 'jjjjjjjjjjjjjjjjjj',
            //     'email' => $this->request->getPost('email'),
            //     'password_hash' => Password::hash($this->request->getPost('password')),
            //     'active' => '1',
            // ]);

            // dd($modelU);

           
            // dd($modelU);
            session()->setFlashdata('success', 'Tambah data berhasil');
            return redirect()->to('/manage-user');
        }
        
    }


    function edit($id)
    {
        // $tmp_data = $this->userM->find($id);
        $authorize = service('authorization');
        $tmp_data = $this->userM->getUserWithRole($id);
        $groups = $authorize->groups();
        // dd($this->userM->getUserWithRole($id));
        
        if (empty($tmp_data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Tidak ditemukan !');
        }
        $data['title']   = 'Pesantren &mdash; Manage User';
        $data['section_header']   = 'Manage User';
        $data['data'] = $tmp_data;
        $data['groups'] = $groups;
        return view('admin/manageUser/edit', $data);
    }

    public function update($id)
    {
        if (strtolower($this->request->getMethod()) == 'put') {//untuk mengecek methodnya
            // jika menggunakan csrf tanpa ajax maka pengecekannya dilakukan otomatis oleh ci4 di $this->validate(.....
            $authorize = service('authorization');

            $one_data_user = $this->userM->getUserWithRole($id);
            $dt=array();
            if($one_data_user->username!=$this->request->getPost('username')){
                $rules =[
                    'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]',
                ];
                if (!$this->validate($rules)) {
                    session()->setFlashdata('error', $this->validator->getErrors());
                    return redirect()->back();
                }
                $dt['username'] = $this->request->getPost('username');
            }

            if($one_data_user->email!=$this->request->getPost('email')){
                $rules =[
                    'email'    => 'required|valid_email|is_unique[users.email]',
                ];
                if (!$this->validate($rules)) {
                    session()->setFlashdata('error', $this->validator->getErrors());
                    return redirect()->back();
                }
                $dt['email'] = $this->request->getPost('email');
            }

            if($one_data_user->name!=$this->request->getPost('role')){
                $rules =[
                    'role'    => 'required',
                ];
                if (!$this->validate($rules)) {
                    session()->setFlashdata('error', $this->validator->getErrors());
                    return redirect()->back();
                }
                $group = $authorize->group($this->request->getPost('role'),);
                if(!$group){
                    session()->setFlashdata('error2', 'no roles');
                    return redirect()->back()->withInput();
                    
                }
                $authorize->removeUserFromGroup($one_data_user->user_id, $one_data_user->name);
                $authorize->addUserToGroup($one_data_user->user_id, $this->request->getPost('role'));
                if($this->request->getPost('role') == 'student'){
                    $cek_data_mhs=$this->mahasiswaM->where('users_id', $one_data_user->user_id)->first();
                    if($cek_data_mhs == null){
                        $this->mahasiswaM->insert([
                            'users_id' => $one_data_user->user_id,
                        ]);
                    }
                }
                if($this->request->getPost('role') == 'parent'){
                    $cek_data_orangtua=$this->orangTuaM->where('users_id', $one_data_user->user_id)->first();
                    if ($cek_data_orangtua == null) {
                        $this->orangTuaM->insert([
                            'users_id' => $one_data_user->user_id,
                        ]);
                    }
                    
                }
            }

            if($this->request->getPost('password')!=null || $this->request->getPost('pass_confirm')!=null){
                $rules = [
                    'password'     => 'required|strong_password',
                    'pass_confirm' => 'required|matches[password]',
                ];
    
                if (! $this->validate($rules)) {
                    session()->setFlashdata('error', $this->validator->getErrors());
                    return redirect()->back()->withInput();
                }
                $dt['password_hash'] = Password::hash($this->request->getPost('password'));
            }
            
            
            $dt['updated_at'] = date('Y-m-d H:i:s');
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->where('id',$id);
            $builder->update($dt);
            
            session()->setFlashdata('success', 'Update data berhasil');
            return redirect()->to('/manage-user');
        }else{
            return ('Method Not Allowed');
        }
        
    }


    public function changest(){
        $data = array();

        // Read new token and assign in $data['token']
        $data['token'] = csrf_hash();
        $data['success'] = 1;

        // ## Validation
        $validation = \Config\Services::validation();

        $validation->setRules([
            'tmp_id_user' => 'required|min_length[1]',
            'tmp_st_user' => 'required|min_length[1]'
        ]);

        if ($validation->withRequest($this->request)->run() == FALSE) {
            $data['success'] = 0;
            $data['error'] = $validation->getError('tmp_id_user'); // Error response
        } 

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', $this->request->getPost('tmp_id_user'));
        
        if ($this->request->getPost('tmp_st_user')=='1') {
            
            $builder->update([
                'active' => '0',
            ]);
            $data['st_u'] = 0;
        }else if ($this->request->getPost('tmp_st_user')=='0') {
            
            $builder->update([
                'active' => '1',
            ]);
            $data['st_u'] = 1;
        }
        return $this->response->setJSON($data);
    }

    function destroy($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $data=$builder->where('id', $id)->get()->getRow();
        if($data!=null){
            $builder->where('id', $id);
            $builder->delete();
        }else{
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }   
        session()->setFlashdata('success', 'Delete data berhasil');
        return redirect()->to('/manage-user');
    }
}
