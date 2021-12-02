<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends WebBaseController
{
    public function actionWelcome()
    {
        return view('welcome');
    }
}
