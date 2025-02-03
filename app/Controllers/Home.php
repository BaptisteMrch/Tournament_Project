<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $title      = 'Tableau de Bord';
    protected $require_auth = true;

    public function index()
    {
        return $this->view('/front/dashboard/index.php');
    }

    public function getforbidden()
    {
        return view('/templates/forbidden');
    }
}