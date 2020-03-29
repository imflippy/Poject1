<?php
/*
* @created 27/03/2020 - 12:34 PM
* @author flippy
*/
namespace App\Controllers;

use App\Controllers\Controller;

class FrontendController extends Controller
{

    public function homePage() {
        $this->loadView('home');
    }
}