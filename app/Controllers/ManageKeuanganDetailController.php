<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KeuanganDetailModel;
use App\Models\KeuanganModel;

class ManageKeuanganDetailController extends BaseController
{
    function __construct()
    {
        $this->keuanganM = new KeuanganModel();        
        $this->keuanganDetailM = new KeuanganDetailModel();        
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $per_page=20;
        $query2 = $this->keuanganDetailM->getKeuanganDetail($keyword)->paginate($per_page,'group_detail_keuangan');
        
        $data['title']   = 'Pesantren &mdash; Detail Keuangan';
        $data['section_header']   = 'Detail Keuangan';
        $data['data_detail_keuangan']   = $query2;
        $data['pager']  = $this->keuanganDetailM->pager;
        $data['currentPage']  = $this->request->getVar('page_group_detail_keuangan');
        $data['tmp_keyword']   = $keyword;
        $data['per_page']   = $per_page;
        return view('admin/manageKeuanganDetail/index', $data);
    }

    public function create()
    {
        $data['title']   = 'Pesantren &mdash; Manage Set Keuangan-Create';
        $data['section_header']   = 'Create Detail Keuangan';
        $data['base_keuangan'] = $this->keuanganM->get()->getResult();
        return view('admin/manageKeuanganDetail/create',$data);
    }

    public function store()
    {
        if (strtolower($this->request->getMethod()) == 'post') {//untuk mengecek methodnya
            $keuangan=$this->keuanganM->get()->getResult();
            $all_id_keuangan="[";
            foreach ($keuangan as $row) {
                $all_id_keuangan =$all_id_keuangan.$row->id.",";
            }
            $all_id_keuangan=$all_id_keuangan."]";
            $all_id_keuangan="required|in_list".$all_id_keuangan;
            
            $rules =[
                
                'keuangan' => $all_id_keuangan,            
                'nominal' => 'required|min_length[2]|max_length[255]',            
                'status'    => 'required|in_list[1,0]',
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }
            // dd('sss');
            $this->keuanganDetailM->insert([
                'keuangans_id' => $this->request->getPost('keuangan'),
                'nominal' => str_replace(array('R','p','.',' '),'',$this->request->getPost('nominal')),
                'status' => $this->request->getPost('status'),
            ]);
            session()->setFlashdata('success', 'Tambah data berhasil');
            return redirect()->to('/manage-detail-keuangan');
        }
    }

    function edit($id)
    {
        $tmp_data = $this->keuanganDetailM->find($id);
        if (empty($tmp_data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Tidak ditemukan !');
        }
        $data['title']   = 'Pesantren &mdash; Berita';
        $data['section_header']   = 'Edit Detail Keuangan';
        $data['data'] = $tmp_data;
        $data['base_keuangan'] = $this->keuanganM->get()->getResult();
        
        return view('admin/manageKeuanganDetail/edit', $data);
    }

    public function update($id)
    {
        if (strtolower($this->request->getMethod()) == 'put') {//untuk mengecek methodnya
            $keuangan=$this->keuanganM->get()->getResult();
            $all_id_keuangan="[";
            foreach ($keuangan as $row) {
                $all_id_keuangan =$all_id_keuangan.$row->id.",";
            }
            $all_id_keuangan=$all_id_keuangan."]";
            $all_id_keuangan="required|in_list".$all_id_keuangan;
            
            $rules =[
                
                'keuangan' => $all_id_keuangan,            
                'nominal' => 'required|min_length[2]|max_length[255]',            
                'status'    => 'required|in_list[1,0]',
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }
            
            
            $this->keuanganDetailM->update($id, 
                [
                    'keuangans_id' => $this->request->getPost('keuangan'),
                    'nominal' => str_replace(array('R','p','.',' '),'',$this->request->getPost('nominal')),
                    'status' => $this->request->getPost('status'),
                ]
            );

            session()->setFlashdata('success', 'Update data berhasil');
            return redirect()->to('/manage-detail-keuangan');

        }else{
            return ('Method Not Allowed');
        }
        
    }

    function destroy($id)
    {
        $data=$this->keuanganDetailM->find($id);
        
        if($data!=null){
            $this->keuanganDetailM->delete($id);
        }else{
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }   
        session()->setFlashdata('success', 'Delete data berhasil');
        return redirect()->to('/manage-detail-keuangan');
    }

    public function changest(){
        // Read new token and assign in $data['token']
        $data['token'] = csrf_hash();
        $data['success'] = 1;

        $rules =[
                
            'tmp_id' => 'required|min_length[1]',
            'tmp_st' => 'required|min_length[1]'
        ];
        if (!$this->validate($rules)) {
            $data['success'] = 0;
            $data['error'] = $this->validator->getError('tmp_id'); // Error response
        } 
        
        if ($this->request->getPost('tmp_st')=='1') {
            $this->keuanganDetailM->update($this->request->getPost('tmp_id'), 
                [
                    'status' => '0',
                ]
            );
            $data['st_u'] = 0;
        }else if ($this->request->getPost('tmp_st')=='0') {
            $this->keuanganDetailM->update($this->request->getPost('tmp_id'), 
                [
                    'status' => '1',
                ]
            );
            $data['st_u'] = 1;
        }
        return $this->response->setJSON($data);
    }
}
