<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;  // No olvides importar el modelo Image.

class AdminController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('admin', compact('images'));
    }
    
}
