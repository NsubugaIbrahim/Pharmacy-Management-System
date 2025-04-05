<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicalAssistantController extends Controller
{
    public function index()
    {
        return view('medical-assistant.dashboard');
    }
}
