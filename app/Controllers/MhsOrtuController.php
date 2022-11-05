<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\MhsOrtuModel;
use App\Models\OrangTuaModel;

class MhsOrtuController extends BaseController
{
    function __construct()
    {
        $this->mhsOrtuM = new MhsOrtuModel();  
        $this->mahasiswaM = new MahasiswaModel();
        $this->orangTuaM = new OrangTuaModel(); 
    }
    
    public function takeParent($id_mhs)
    {
        if($this->mhsOrtuM->getMhsOrtu($id_mhs)==[]){
            $data['success'] = 0;
        }
        $data['success'] = 1;
        $data['data']=$this->mhsOrtuM->getMhsOrtu($id_mhs);
        return $this->response->setJSON($data);
    }

    public function takeStudent($id_ortu)
    {
        // dd($this->mhsOrtuM->getOrtuMhs($id_ortu));
        if($this->mhsOrtuM->getOrtuMhs($id_ortu)==[]){
            $data['success'] = 0;
        }
        $data['success'] = 1;
        $data['data']=$this->mhsOrtuM->getOrtuMhs($id_ortu);
        return $this->response->setJSON($data);
    }

    public function create(){
        $data['token'] = csrf_hash();
        // ## Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'tmp_email' => 'required',
        ]);

        if ($validation->withRequest($this->request)->run() == FALSE) {
            $data['success'] = 0;
            $data['error'] = 'Email tidak boleh kosong'; // Error response
            return $this->response->setJSON($data);
        } 

        

        $cekPerent=$this->orangTuaM->getOneOrangTuaByEmail( $this->request->getPost('tmp_email'));
        $cekStudensParent=$this->mhsOrtuM->getMhsOrtuByIdEmail( $this->request->getPost('tmp_id'), $this->request->getPost('tmp_email'));
        if($cekPerent==null){
            $data['error'] = 'email belum terdaftar sebagai orang tua';
            $data['success'] = 0;
            return $this->response->setJSON($data);
        }
        if($cekStudensParent!=null){
            $data['error'] = 'email sudah terdaftar pada mahasiswa';
            $data['success'] = 0;
            return $this->response->setJSON($data);
        }
        
        $data['success'] = 1;
        $this->mhsOrtuM->insert([
            'mahasiswas_id' => $this->request->getPost('tmp_id'),
            'orang_tuas_id' => $cekPerent->id,
        ]);
        return $this->response->setJSON($data);
    }

    public function destroy(){
        $data['token'] = csrf_hash();
        $data['success'] = 1;
        $cek=$this->mhsOrtuM->find($this->request->getPost('tmp_id'));
        
        if($cek!=null){
            $data['success'] = 1;
            $this->mhsOrtuM->delete($this->request->getPost('tmp_id'));
            return $this->response->setJSON($data);
        }else{
            $data['success'] = 0;
        } 
    }






    public function create2(){
        $data['token'] = csrf_hash();
        // ## Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'tmp_email' => 'required',
        ]);

        if ($validation->withRequest($this->request)->run() == FALSE) {
            $data['success'] = 0;
            $data['error'] = 'Email tidak boleh kosong'; // Error response
            return $this->response->setJSON($data);
        } 

        

        $cekStudent=$this->mahasiswaM->getOneMahasiswaByEmail( $this->request->getPost('tmp_email'));
        $cekParentsStuden=$this->mhsOrtuM->getOrtuMhsIdEmail( $this->request->getPost('tmp_id'), $this->request->getPost('tmp_email'));
        if($cekStudent==null){
            $data['error'] = 'email belum terdaftar sebagai mahasiswa';
            $data['success'] = 0;
            return $this->response->setJSON($data);
        }
        if($cekParentsStuden!=null){
            $data['error'] = 'email sudah terdaftar pada orang tua';
            $data['success'] = 0;
            return $this->response->setJSON($data);
        }
        
        $data['success'] = 1;
        $this->mhsOrtuM->insert([
            'mahasiswas_id' => $cekStudent->id,
            'orang_tuas_id' => $this->request->getPost('tmp_id'),
        ]);
        return $this->response->setJSON($data);
    }



    public function destroy2(){
        $data['token'] = csrf_hash();
        $data['success'] = 1;
        $cek=$this->mhsOrtuM->find($this->request->getPost('tmp_id'));
        
        if($cek!=null){
            $data['success'] = 1;
            $this->mhsOrtuM->delete($this->request->getPost('tmp_id'));
            return $this->response->setJSON($data);
        }else{
            $data['success'] = 0;
        } 
    }
}
