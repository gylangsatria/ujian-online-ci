<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['group_name'] = $this->auth->getGroupName();
        $data['user_name'] = $this->auth->getUserId() ? session()->get('first_name') . ' ' . session()->get('last_name') : '';

        return view('dashboard', $data);
    }
}