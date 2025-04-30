<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller {
    public function index(Request $request) {
        $siswa = Siswa::when($request->search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
   ->orWhere('nisn', 'like', "%{$search}%");
        })->get();

        return Inertia::render('Siswa', ['siswa' => $siswa]);
    }

    public function store(Request $request) {
        $request->validate([
            'nisn' => 'required|string|unique:siswa,nisn|max:10',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
        ]);

        Siswa::create($request->all());

        return redirect()->route('siswa.index')->with('message', 'Siswa ditambahkan.');
    }

    public function update(Request $request, Siswa $siswa) {
        $request->validate([
            'nisn' => 'required|string|max:10|unique:siswa,nisn,' . $siswa->id,
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('message', 'Siswa diubah.');
    }

    public function destroy(Siswa $siswa) {
        $siswa->delete();

        return redirect()->route('siswa.index')->with('message', 'Siswa dihapus.');
    }

    public function report() {
        $siswa = Siswa::all();
        $pdf = PDF::loadView('report.siswa', ['siswa' => $siswa]);
        return $pdf->download('laporan_siswa.pdf');
        // return $pdf;
        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->output();
        // }, 'laporan_siswa.pdf');
    }


}
