<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $title      = 'Tableau de Bord';
    protected $require_auth = true;

    public function index(): string
    {
        return $this->view('/front/dashboard/index.php');
    }

    public function getforbidden() : string
    {
        return view('/templates/forbidden');
    }
}