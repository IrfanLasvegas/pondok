<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KeuanganModel;

class ManageKeuanganController extends BaseController
{
    function __construct()
    {
        $this->keuanganM = new KeuanganModel();        
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $per_page=20;
        $query2 = $this->keuanganM->getKeuangan($keyword)->paginate($per_page,'group_keuangan');
        
        $data['title']   = 'Pesantren &mdash; Keuangan';
        $data['section_header']   = 'Set Keuangan';
        $data['data_keuangan']   = $query2;
        $data['pager']  = $this->keuanganM->pager;
        $data['currentPage']  = $this->request->getVar('page_group_keuangan');
        $data['tmp_keyword']   = $keyword;
        $data['per_page']   = $per_page;
        return view('admin/manageKeuangan/index', $data);
    }

    public function create()
    {
        $data['title']   = 'Pesantren &mdash; Manage Set Keuangan-Create';
        $data['section_header']   = 'Create Set Keuangan';
        return view('admin/manageKeuangan/create',$data);
    }

    public function store()
    {
        if (strtolower($this->request->getMethod()) == 'post') {//untuk mengecek methodnya
            $rules =[
                'title' => 'required|min_length[5]|max_length[255]',            
                'description'    => 'required',
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }

            $this->keuanganM->insert([
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
            ]);
            session()->setFlashdata('success', 'Tambah data berhasil');
            return redirect()->to('/manage-keuangan');
        }
    }

    function edit($id)
    {
        $tmp_data = $this->keuanganM->find($id);
        if (empty($tmp_data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Tidak ditemukan !');
        }
        $data['title']   = 'Pesantren &mdash; Berita';
        $data['section_header']   = 'Edit Set Keuangan';
        $data['data'] = $tmp_data;
        
        return view('admin/manageKeuangan/edit', $data);
    }

    public function update($id)
    {
        if (strtolower($this->request->getMethod()) == 'put') {//untuk mengecek methodnya
            
            
            $rules =[
                'title' => 'required|min_length[5]|max_length[255]',
                'description'    => 'required',
            ];
            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }
            
            
            $this->keuanganM->update($id, 
                [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                ]
            );

            session()->setFlashdata('success', 'Update data berhasil');
            return redirect()->to('/manage-keuangan');

        }else{
            return ('Method Not Allowed');
        }
        
    }

    function destroy($id)
    {
        $data=$this->keuanganM->find($id);
        
        if($data!=null){
            $this->keuanganM->delete($id);
        }else{
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }   
        session()->setFlashdata('success', 'Delete data berhasil');
        return redirect()->to('/manage-keuangan');
    }


    // function all()
    // {
    //     // $data=$this->keuanganM->get()->getResult();
    //     $data['success'] = 1;
    //     $data['data'] = $this->keuanganM->get()->getResult();
    //     return $this->response->setJSON($data);
    // }
}
