<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class ManageBeritaController extends BaseController
{
    function __construct()
    {
        $this->beritaM = new BeritaModel();
        
        
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $per_page=4;
        $query2 = $this->beritaM->getBerita($keyword, $status)->paginate($per_page,'group_berita');
        
        $data['title']   = 'Pesantren &mdash; Berita';
        $data['section_header']   = 'Berita';
        $data['data_berita']   = $query2;
        $data['pager']  = $this->beritaM->pager;
        $data['currentPage']  = $this->request->getVar('page_group_berita');
        $data['tmp_keyword']   = $keyword;
        $data['tmp_status']   = $status;
        $data['base_status']   = ['publish', 'pending', 'draft'];
        $data['per_page']   = $per_page;
        return view('admin/manageBerita/index', $data);
    }

    public function create()
    {
        // 'publish', 'pending', 'draft'
        $data['title']   = 'Pesantren &mdash; Manage Berita-Create';
        $data['section_header']   = 'Create Berita';
        return view('admin/manageBerita/create',$data);
    }
    public function store()
    {
        if (strtolower($this->request->getMethod()) == 'post') {//untuk mengecek methodnya

            // dd(user()->id);
            
            $rules =[
                'title' => 'required|min_length[5]|max_length[255]',
                'file'    =>'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,2048]',
                'status'    => 'required|in_list[publish,pending,draft]',
                'description'    => 'required',
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }

            $dataFile = $this->request->getFile('file');
            $fileName = $dataFile->getRandomName();
            $this->beritaM->insert([
                'users_id' => user()->id,
                'title' => $this->request->getPost('title'),
                'slug' => url_title($this->request->getPost('title'), '-', TRUE),
                'description' => $this->request->getPost('description'),
                'status' => $this->request->getPost('status'),
                'gambar' =>  $fileName,
                
                
            ]);
            // $dataFile->move(WRITEPATH . 'uploads/berita', $fileName);
            $dataFile->move('uploads/berita', $fileName);
            
            session()->setFlashdata('success', 'Tambah data berhasil');
            return redirect()->to('/manage-berita');
        }
        
    }

    function edit($id)
    {
        $tmp_data = $this->beritaM->find($id);
        // $g="../public/uploads/berita/"."1665920944_2213825d1d1dde5bd5d0 - Copy.jpg";
        // @unlink($g);
        // return $g;
        if (empty($tmp_data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Tidak ditemukan !');
        }
        $data['title']   = 'Pesantren &mdash; Berita';
        $data['section_header']   = 'Edit Berita';
        $data['data'] = $tmp_data;
        $data['base_status']   = ['publish', 'pending', 'draft'];
        
        return view('admin/manageBerita/edit', $data);
    }

    public function update($id)
    {
        if (strtolower($this->request->getMethod()) == 'put') {//untuk mengecek methodnya
            $tmp_data = $this->beritaM->find($id);
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
                'status'    => 'required|in_list[publish,pending,draft]',
                'description'    => 'required',
            ];
            if (!$this->validate($rules)) {
                session()->setFlashdata('error', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }
            $dt['users_id'] = user()->id;
            $dt['title'] = $this->request->getPost('title');
            $dt['slug'] = url_title($this->request->getPost('title'), '-', TRUE);
            $dt['description'] = $this->request->getPost('description');
            $dt['status'] = $this->request->getPost('status');
            $this->beritaM->update($id, $dt);

            if($delGambar == true){
                $path_gambar="../public/uploads/berita/".$tmp_data->gambar;
                @unlink($path_gambar);
                $dataFile->move('uploads/berita', $dt['gambar']);
            }
            session()->setFlashdata('success', 'Update data berhasil');
            return redirect()->to('/manage-berita');

        }else{
            return ('Method Not Allowed');
        }
        
    }

    function show($id)
    {
        $tmp_data = $this->beritaM->select('users.username, beritas.*')->join('users', 'users.id = beritas.users_id')->find($id);
        if (empty($tmp_data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Tidak ditemukan !');
        }
        $data['title']   = 'Pesantren &mdash; Berita';
        $data['section_header']   = 'Show Berita';
        $data['data'] = $tmp_data;
        return view('admin/manageBerita/show', $data);
    }

    function destroy($id)
    {
        $data=$this->beritaM->find($id);
        
        if($data!=null){
            $this->beritaM->delete($id);
            $path_gambar="../public/uploads/berita/".$data->gambar;
            @unlink($path_gambar);
        }else{
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }   
        session()->setFlashdata('success', 'Delete data berhasil');
        return redirect()->to('/manage-berita');
    }
    
    

}
