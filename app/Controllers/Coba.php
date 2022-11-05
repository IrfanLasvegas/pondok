<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Config\Services;

class Coba extends BaseController
{
    
    public function index()
    {
        // 

        //
        // $authenticate = Services::authentication();

        // instance
        // $authorize = $auth = service('authorization');
        $authorize = service('authorization');

        // return($authorize->usersInGroup('admin')[0]['email']);
        dd($authorize->inGroup(['admin', 'super admin'], '7'));

        // add groups
        // $id = $authorize->createGroup('student', 'pengguna yang mempunyai otoritas sebagai mahasiswa');
        // $id = $authorize->createGroup('parent', 'pengguna yang mempunya9 otoritas sebagai orang tua');

        // update groups
        // $authorize->updateGroup('3', 'moderator', 'No description today.');

        // delete groups
        // $authorize->deleteGroup('3');

        // select all groups
        // $groups = $authorize->groups();

        // select one group
        // $group = $authorize->group($group_id);
		// or
        // $group = $authorize->group('administrator');

        $data['title']   = 'My Real Title';
        $data['heading'] = 'My Real Heading';
        // $data['dt'] = $groups;
        // $data['dt2'] = $group;


        // $routes->get('/manage-user', 'ManageUserController::index');
        $arraymultidimensi=[["url"=>'/manage-user', "cont"=>'ManageUserController::index'],    
                            ["url"=>'/manage-user2', "cont"=>'ManageUserController::index'],    
                            ["url"=>'/manage-user3', "cont"=>'ManageUserController::index'],    ];
        $t=array(
            array('url'=>'/', 'contr'=>'kdjf')
        );

        $data['t'] = $arraymultidimensi;
        return view('v_coba',$data);
    }
}
