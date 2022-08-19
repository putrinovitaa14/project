<?php

namespace App\Http\Controllers;
use App\Models\Wisata;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index()
    {
        $wisata = Wisata::all();
        return view('informasi.wisata', compact('wisata'));

    }
    public function show($id)
    {
        $wisata = Wisata::findOrFail($id);
        return view('wisata.show', compact('wisata'));

    }
    public function create()
    {
        return view('wisata.create');

    }
    public function store(Request $request)
    {
        //validasi
        $validated = $request->validate([
            'galeri' => 'required',
            'nama_wisata' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',

        ]);

        $wisata = new wisata();
        if ($request->hasFile('galeri')) {
            $image = $request->file('galeri');
            $name = rand(1000, 9999) . $image->getClientOriginalName();
            $image->move('images/wisata/', $name);
            $wisata->galeri = $name;
        }

        $wisata->nama_wisata = $request->nama_wisata;
        $wisata->deskripsi = $request->deskripsi;
        $wisata->lokasi = $request->lokasi;
        $wisata->save();
        return redirect()->route('wisata.index')
            ->with('success', 'Data berhasil dibuat!');

    }
    public function edit($id)
    {
        $wisata = Wisata::findOrFail($id);
        return view('wisata.edit', compact('wisata'));

    }
    public function update(Request $request, $id)
    {
        // Validasi
        $validated = $request->validate([
            'galeri' => 'required',
            'nama_wisata' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',

        ]);

        $wisata = Wisata::findOrFail($id);
        if ($request->hasFile('galeri')) {
            $wisata->deleteImage(); //menghapus galeri sebelum di update melalui method deleteImage di model
            $image = $request->file('galeri');
            $name = rand(1000, 9999) . $image->getClientOriginalName();
            $image->move('images/wisata/', $name);
            $wisata->galeri = $name;
        }
        $wisata->nama_wisata = $request->nama_wisata;
        $wisata->deskripsi = $request->deskripsi;
        $wisata->lokasi = $request->lokasi;
        $wisata->save();
        return redirect()->route('wisata.index')
            ->with('success', 'Data berhasil diedit!');

    }

}
