<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index(){
        $motos = Moto::paginate(5);
        return view('listemotos', compact('motos'));
    }
    
 
}