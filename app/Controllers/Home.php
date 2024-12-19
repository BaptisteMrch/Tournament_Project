<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $require_auth = true;
    public function index(): string
    {
        return view('/front/user/index');
    }

    public function getforbidden() : string
    {
        return view('/templates/forbidden');
    }
}
