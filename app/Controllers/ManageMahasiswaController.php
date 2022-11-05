<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\MhsOrtuModel;
use App\Models\OrangTuaModel;
use App\Models\UserModel;

class ManageMahasiswaController extends BaseController
{
    function __construct()
    {
        $this->userM = new UserModel();
        $this->mahasiswaM = new MahasiswaModel();
        $this->orangTuaM = new OrangTuaModel();
        $this->mhsOrtuM = new MhsOrtuModel();
        
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $per_page=2;
        $query2 = $this->mahasiswaM->getMahasiswa($keyword)->paginate($per_page,'group_mahasiswa');
        
        $data['title']   = 'Pesantren &mdash; Mahasiswa';
        $data['section_header']   = 'Mahasiswa';
        $data['data_user']   = $query2;
        $data['pager']  = $this->mahasiswaM->pager;
        $data['currentPage']  = $this->request->getVar('page_group_mahasiswa');
        $data['tmp_keyword']   = $keyword;
        $data['per_page']   = $per_page;
        return view('admin/manageMahasiswa/index', $data);
    }

    function edit($id)
    {
        $authorize = service('authorization');
        // cara ini juga bisa tanpa membuat fungsi di dalam model mahasiswa
        // $tmp_data = $this->mahasiswaM->select('*')->join('users', 'users.id = mahasiswas.users_id')->where('mahasiswas.id',$id)->first();
        $tmp_data = $this->mahasiswaM->getOneMahasiswa($id);
        
        if (empty($tmp_data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Tidak ditemukan !');
        }
        $data['title']   = 'Pesantren &mdash; Update Mahasiswa';
        $data['section_header']   = 'Mahasiswa';
        $data['data'] = $tmp_data;
        
        return view('admin/manageMahasiswa/edit', $data);
    }

    public function update($id)
    {
        if (strtolower($this->request->getMethod()) == 'put') {//untuk mengecek methodnya
            
            $jk = array('','pria', 'wanita');
            if (!in_array($this->request->getPost('jenis_kelamin'), $jk))
            {
                session()->setFlashdata('error2', 'no gender');
                return redirect()->back()->withInput();
            }

            $one_data = $this->mahasiswaM->getOneMahasiswa($id);
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

            if($one_data->status!=$this->request->getPost('status')){
                $rules =[
                    'status'    => 'required|in_list[active, inactive, lulus]',
                ];
                if (!$this->validate($rules)) {
                    session()->setFlashdata('error', $this->validator->getErrors());
                    return redirect()->back();
                }
                $dt['status'] = $this->request->getPost('status');
            }

            $dt['jenis_kelamin'] = $this->request->getPost('jenis_kelamin');
            $this->mahasiswaM->update($id, $dt);
            session()->setFlashdata('success', 'Update data berhasil');
            return redirect()->to('/manage-mahasiswa');
        }else{
            return ('Method Not Allowed');
        }
        
    }

    function destroy($id)
    {
        $data=$this->mahasiswaM->find($id);
        
        if($data!=null){
            $this->mahasiswaM->delete($id);
        }else{
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }   
        session()->setFlashdata('success', 'Delete data berhasil');
        return redirect()->to('/manage-mahasiswa');
    }
}
