<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KomentarModel;

class ManageKomentarController extends BaseController
{
    function __construct()
    {
        $this->komentarM = new KomentarModel();
        
        
    }
    public function index()
    {
        //
    }

    function show($id)
    {
        $data['success'] = 1;
        $data['idberita'] = $id;
        $data['listKomen'] = $this->komentarM->listComment($id);
        $data['listKomenReply'] = $this->reply('1');
        $authorize = service('authorization');
        $cek_authorize_user=$authorize->inGroup(['admin', 'super admin'], user()->id);


        $output='';
        $res1 = $this->komentarM->listComment($id);
        foreach ($res1 as $row) {
            // $data['forec'] = $row->username;
            $output .= '
                        <div class="media border p-3 mb-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" alt="foto-user" class="mr-3  rounded-circle" width="60" height="60" id="foto'.$row->id.'">
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span style="font-size: 16;" id="nama'.$row->id.'"><b>'.$row->username.'</b></span>
                                        <p id="komentar'.$row->id.'">'.$row->comment_text.'</p>
                                        <div class="text-right">            
            ';
            if ($cek_authorize_user==true) {
                $output .='<a href=""   id="'.$row->id.'" class="text-danger mr-2 deleteReplay">Delete</a>';
            }
            

            $output .='
                                        <a href="" class="reply " id="'.$row->id.'-_-'.$row->id.'">Reply</a>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            ';
            $output .= $this->reply($row->id);
        }
        $data['allComment'] = $output;
        return $this->response->setJSON($data);
    }


    function reply($parent_id = 0, $marginleft = 0)
    {
        $authorize = service('authorization');
        $cek_authorize_user=$authorize->inGroup(['admin', 'super admin'], user()->id);
        $output='';
        $res1 = $this->komentarM->listLevelComment($parent_id)->getResult();
        $count = $this->komentarM->listLevelComment($parent_id)->getNumRows();
        if($parent_id == 0) {
            $marginleft = 0;
        } else {
            $marginleft = $marginleft + 48;
        }
        if($count > 0){
            foreach ($res1 as $row) {
                // $data['forec'] = $row->username;
                $output .= '
                            <div class="media border p-3 mb-2" style="margin-left:'.$marginleft.'px">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" alt="foto-user" class="mr-3  rounded-circle" width="60" height="60" id="foto'.$row->id.'">
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span style="font-size: 16;" id="nama'.$row->id.'"><b>'.$row->username.'</b></span>
                                            <p id="komentar'.$row->id.'">'.$row->comment_text.'</p>
                                            <div class="text-right">            
                ';

                if ($cek_authorize_user==true) {
                    $output .='<a href=""   id="'.$row->id.'" class="text-danger mr-2 deleteReplay">Delete</a>';
                }
    
                $output .='
                                            <a href="" class="reply " id="'.$row->parent_komentar_id.'-_-'.$row->id.'">Reply</a>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                ';
            }
        }
        return $output;

        // return $this->komentarM->listLevelComment($parent_id)->getResult();
        // return $this->komentarM->listLevelComment($parent_id)->getNumRows();
        // return 'ini replay';
    }


    function store(){
        $data['token'] = csrf_hash();
        if (logged_in()==false) {
            $data['success'] = 0;
            $data['error'] = 'Anda belum login';    
        }

        $rules =[
            'berita_id'    => 'required|is_natural',
            'parent_komentar_id' => 'required|is_natural',
            'komen'    => 'required',
        ];
        if (!$this->validate($rules)) {
            $data['success'] = 0;
            $data['error'] = $this->validator->listErrors();
            return $this->response->setJSON($data);
        }

        $data['success'] = 1;
        $this->komentarM->insert([
            'users_id' => user()->id,
            'beritas_id' => $this->request->getPost('berita_id'),
            'parent_komentar_id' => $this->request->getPost('parent_komentar_id'),
            'comment_text' => $this->request->getPost('komen'),

        ]);
        return $this->response->setJSON($data);
        
    }


    public function destroy(){
        $data['token'] = csrf_hash();
        $cek=$this->komentarM->find($this->request->getPost('tmp_id'));
        if($cek!=null){
            if ($cek->parent_komentar_id=='0') {
                $data['p0'] = 'yaaa';
                $data['success'] = 1;
                $this->komentarM->where('id', $this->request->getPost('tmp_id'))->delete();
                $this->komentarM->where('parent_komentar_id', $this->request->getPost('tmp_id'))->delete();
                return $this->response->setJSON($data);
            }else{
                $data['p0'] = 'tidakkk';
                $this->komentarM->where('id', $this->request->getPost('tmp_id'))->delete();
                return $this->response->setJSON($data);
            }
        }else{
            $data['success'] = 0;
        } 
    }
}
