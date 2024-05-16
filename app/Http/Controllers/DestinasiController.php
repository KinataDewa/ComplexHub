<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DestinasiController extends Controller
{
    public function indexRW()
    {
        $user = auth()->user();

        $breadcrumb = (object)[
            'title' => 'Pemilihan Destinasi Wisata',
            'subtitle' => 'Metode 1 (Satu)'
        ];
        return view('RW.destinasiwisataRW', ['breadcrumb' => $breadcrumb]);
    }
    public function indexDestinasi()
    {
    $user = auth()->user();

    $breadcrumb = (object)[
        'title' => 'Pemilihan Destinasi Wisata (Metode 1)',
        'subtitle' => 'Data Alternatif',
    ];

    return view('Destinasi.alternatifdestinasiRW', ['breadcrumb' => $breadcrumb]);
    }

    public function indexkriteria()
    {
    $user = auth()->user();

    $breadcrumb = (object)[
        'title' => 'Pemilihan Destinasi Wisata (Metode 1)',
        'subtitle' => 'Data Kriteria',
    ];

    return view('kriteria.kriteriadestinasiRW', ['breadcrumb' => $breadcrumb]);
    }

    public function indexbobot()
    {
    $user = auth()->user();

    $breadcrumb = (object)[
        'title' => 'Pemilihan Destinasi Wisata (Metode 1)',
        'subtitle' => 'Ubah Bobot Kriteria',
    ];

    return view('bobot.bobotdestinasiRW', ['breadcrumb' => $breadcrumb]);
    }

    public function indexpenilaian()
    {
    $user = auth()->user();

    $breadcrumb = (object)[
        'title' => 'Pemilihan Destinasi Wisata (Metode 1)',
        'subtitle' => 'Penilaian Alternatif',
    ];

    return view('penilaian.penilaiandestinasiRW', ['breadcrumb' => $breadcrumb]);
    }

    public function indexranking()
    {
    $user = auth()->user();

    $breadcrumb = (object)[
        'title' => 'Pemilihan Destinasi Wisata (Metode 1)',
        'subtitle' => 'Hasil Perhitungan',
    ];

    return view('ranking.rankingdestinasiRW', ['breadcrumb' => $breadcrumb]);
    }

    public function indexPenduduk()
    {
        $user = auth()->user();

        $breadcrumb = (object)[
            'title' => 'Pemilihan Destinasi Wisata',
            'subtitle' => 'Dengan Metode 1 (Satu)',
        ];
        return view('Penduduk.destinasiwisataPD', ['breadcrumb' => $breadcrumb]);
    }

}