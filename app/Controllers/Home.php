<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // if(in_groups('administrator')){
        //     return redirect()->route('cb');
        // }elseif (in_groups('user')) {
        //     $auth = service('authentication');
        //     $current_user = $auth->user();
        //     dd($current_user);
        //     return 'ini login sebeagai user'.$current_user;
        // }
        return view('welcome_message');
    }
}
