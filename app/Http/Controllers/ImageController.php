<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Str;  // Importa la clase Str en la parte superior de tu archivo


class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('index', compact('images'));
    }

    public function admin()
    {
        $images = Image::all();

        // Ajusta las rutas de los archivos si es necesario
        foreach ($images as $image) {
            $image->file_path = Str::after($image->file_path, 'public/');
        }

        return view('admin', compact('images'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'duration' => 'required|integer'
        ]);        

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        Image::create([
            'file_path' => '/images/'.$imageName,
            'duration' => $request->duration
        ]);
        
        session()->flash('message', 'Imagen subida exitosamente');
        session()->flash('message_type', 'success');

        return redirect()->route('image.admin');
    }

    public function update(Request $request, Image $image)
    {
        $request->validate([
            'duration' => 'required|integer'
        ]);

        $image->update([
            'duration' => $request->duration
        ]);

        session()->flash('message', 'Duración actualizada exitosamente');
        session()->flash('message_type', 'success');

        return redirect()->route('image.admin');
    }

    public function destroy(Image $image)
    {
        $imagePath = public_path($image->file_path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        } 

        $image->delete();

        session()->flash('message', 'Imagen eliminada exitosamente');
        session()->flash('message_type', 'success');

        return redirect()->route('image.admin');
    }
}
