<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function onPageLoad() {
        return (view('register'));
    }
}