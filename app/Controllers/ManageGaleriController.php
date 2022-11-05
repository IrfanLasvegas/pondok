<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GaleriModel;

class ManageGaleriController extends BaseController
{
    function __construct()
    {
        $this->galeriM = new GaleriModel();
        
        
    }

    public function index()
    {
        //
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $per_page=4;
        $query2 = $this->galeriM->getGaleri($keyword)->paginate($per_page,'group_galeri');
        
        $data['title']   = 'Pesantren &mdash; Galeri';
        $data['section_header']   = 'Galeri';
        $data['data_galeri']   = $query2;
        $data['pager']  = $this->galeriM->pager;
        $data['currentPage']  = $this->request->getVar('page_group_galeri');
        $data['tmp_keyword']   = $keyword;
        // $data['tmp_status']   = $status;
        // $data['base_status']   = ['publish', 'pending', 'draft'];
        $data['per_page']   = $per_page;
        return view('admin/manageGaleri/index', $data);
    }

    public function create()
    {
        
        $data['title']   = 'Pesantren &mdash; Manage Galeri-Create';
        $data['section_header']   = 'Create Galeri';
        return view('admin/manageGaleri/create',$data);
    }

    public function store()
    {
        if (strtolower($this->request->getMethod()) == 'post') {//untuk mengecek methodnya
            $rules =[
                'title' => 'required|min_length[5]|max_length[255]',
                'file'    =>'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,2048]',
                'description'    => 'required',
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }

            $dataFile = $this->request->getFile('file');
            $fileName = $dataFile->getRandomName();
            $this->galeriM->insert([
                'users_id' => user()->id,
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'gambar' =>  $fileName,
                
                
            ]);
            // $dataFile->move(WRITEPATH . 'uploads/berita', $fileName);
            $dataFile->move('uploads/galeri', $fileName);
            
            session()->setFlashdata('success', 'Tambah data berhasil');
            return redirect()->to('/manage-galeri');
        }
    }


    function edit($id)
    {
        $tmp_data = $this->galeriM->find($id);
        if (empty($tmp_data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Tidak ditemukan !');
        }
        $data['title']   = 'Pesantren &mdash; Berita';
        $data['section_header']   = 'Edit Galeri';
        $data['data'] = $tmp_data;
        
        return view('admin/manageGaleri/edit', $data);
    }

    public function update($id)
    {
        if (strtolower($this->request->getMethod()) == 'put') {//untuk mengecek methodnya
            $tmp_data = $this->galeriM->find($id);
            $dataFile = $this->request->getFile('file');
            $delGambar=false;
            if($dataFile->getName() != ""){
                $rules =[
                    'file'    =>'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,2048]',
                ];
                if (!$this->validate($rules)) {
                    session()->setFlashdata('error', $this->validator->getErrors());
                    return redirect()->back()->withInput();
                }
                $fileName = $dataFile->getRandomName();
                $dt['gambar'] = $fileName;
                $delGambar=true;
            }
            $rules =[
                'title' => 'required|min_length[5]|max_length[255]',
                'description'    => 'required',
            ];
            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }
            $dt['users_id'] = user()->id;
            $dt['title'] = $this->request->getPost('title');
            $dt['description'] = $this->request->getPost('description');
            $this->galeriM->update($id, $dt);

            if($delGambar == true){
                $path_gambar="../public/uploads/galeri/".$tmp_data->gambar;
                @unlink($path_gambar);
                $dataFile->move('uploads/galeri', $dt['gambar']);
            }
            session()->setFlashdata('success', 'Update data berhasil');
            return redirect()->to('/manage-galeri');

        }else{
            return ('Method Not Allowed');
        }
        
    }


    function destroy($id)
    {
        $data=$this->galeriM->find($id);
        
        if($data!=null){
            $this->galeriM->delete($id);
            $path_gambar="../public/uploads/galeri/".$data->gambar;
            @unlink($path_gambar);
        }else{
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }   
        session()->setFlashdata('success', 'Delete data berhasil');
        return redirect()->to('/manage-galeri');
    }


}
