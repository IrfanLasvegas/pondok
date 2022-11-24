<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\OrangTuaModel;
use App\Models\UserModel;

class ManageOrangTuaController extends BaseController
{
    function __construct()
    {
        $this->userM = new UserModel();
        $this->mahasiswaM = new MahasiswaModel();
        $this->orangTuaM = new OrangTuaModel();
        
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $per_page=4;
        $query2 = $this->orangTuaM->getOrangTua($keyword)->paginate($per_page,'group_parent');
        
        $data['title']   = 'Pesantren &mdash; Orang Tua';
        $data['section_header']   = 'Orang Tua';
        $data['data_user']   = $query2;
        $data['pager']  = $this->orangTuaM->pager;
        $data['currentPage']  = $this->request->getVar('page_group_parent');
        $data['tmp_keyword']   = $keyword;
        $data['per_page']   = $per_page;
        return view('admin/manageOrangTua/index', $data);
    }

    function edit($id)
    {
        $authorize = service('authorization');
        // cara ini juga bisa tanpa membuat fungsi di dalam model mahasiswa
        // $tmp_data = $this->orangTuaM->select('*')->join('users', 'users.id = mahasiswas.users_id')->where('mahasiswas.id',$id)->first();
        $tmp_data = $this->orangTuaM->getOneOrangTua($id);
        
        if (empty($tmp_data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Tidak ditemukan !');
        }
        $data['title']   = 'Pesantren &mdash; Update Orang Tua';
        $data['section_header']   = 'Orang Tua';
        $data['data'] = $tmp_data;
        
        return view('admin/manageOrangTua/edit', $data);
    }

    public function update($id)
    {
        if (strtolower($this->request->getMethod()) == 'put') {//untuk mengecek methodnya
            
            $jk = array('','pria', 'wanita');
            if (!in_array($this->request->getPost('jenis_kelamin'), $jk))
            {
                session()->setFlashdata('error2', 'no roles');
                return redirect()->back()->withInput();
            }

            $one_data = $this->orangTuaM->getOneOrangTua($id);
            $dt=array();
            if($one_data->username!=$this->request->getPost('no_telp')){
                $rules =[
                    'no_telp' => 'permit_empty|numeric|min_length[3]|max_length[20]',
                ];
                if (!$this->validate($rules)) {
                    session()->setFlashdata('error', $this->validator->getErrors());
                    return redirect()->back();
                }
                $dt['no_telp'] = $this->request->getPost('no_telp');
            }

            if($one_data->alamat!=$this->request->getPost('alamat')){
                $rules =[
                    'alamat' => 'permit_empty|alpha_numeric_space|min_length[3]|max_length[255]',
                ];
                if (!$this->validate($rules)) {
                    session()->setFlashdata('error', $this->validator->getErrors());
                    return redirect()->back();
                }
                $dt['alamat'] = $this->request->getPost('alamat');
            }

            $dt['jenis_kelamin'] = $this->request->getPost('jenis_kelamin');
            $this->orangTuaM->update($id, $dt);
            session()->setFlashdata('success', 'Update data berhasil');
            return redirect()->to('/manage-orang-tua');
        }else{
            return ('Method Not Allowed');
        }
        
    }

    function destroy($id)
    {
        $data=$this->orangTuaM->find($id);
        
        if($data!=null){
            $this->orangTuaM->delete($id);
        }else{
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }   
        session()->setFlashdata('success', 'Delete data berhasil');
        return redirect()->to('/manage-orang-tua');
    }
}
