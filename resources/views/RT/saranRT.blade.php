@extends('layouts.welcome')
@section('content')
    {{-- Content --}}
    <main class="mx-auto p-36 contain-responsive" style="min-height: 100vh; background-color: #FBEEC1;">
        <div class="rounded-md relative p-16 top-32 left-16" style="background-color: white">
            <p class="mb-10"  style="font-size: 24px; font-family: 'Poppins', sans-serif; font-weight: 600; color: black;">Daftar Saran dan Pengaduan:</p>
            <hr class="mb-6">
            <table class="md:table-fixed w-full">
                <thead>
                    <tr>
                        <th class="border px-4 py-2 text-center w-1/6" style="color: black">No</th>
                        <th class="border px-4 py-2 text-center w-1/6" style="color: black">Tanggal</th>
                        <th class="border px-4 py-2 text-center w-1/6" style="color: black">Bidang</th>
                        <th class="border px-4 py-2 text-center w-1/6" style="color: black">Nama</th>
                        <th class="border px-4 py-2 text-center w-1/6" style="color: black">Isi Laporan</th>
                        <th class="border px-4 py-2 text-center w-1/6" style="color: black">Status</th>
                        <th class="border px-4 py-2 text-center w-1/6" style="color: black">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td class="border px-4 py-2 text-center" style="color: black">
                            <button class="btn-detail bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded" style="border-radius: 10px"><a href="{{ url('/detailSaran') }}">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5 3H21.5V9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.5 21H3.5V15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M21.5 3L14.5 10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.5 21L10.5 14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg></a>
                            </button>
                            <button class="btn-tolak bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded ml-2" style="border-radius: 10px">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.5 6L6.5 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.5 6L18.5 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button class="btn-acc bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-2 rounded ml-2" style="border-radius: 10px">
                                <svg width="25" height="24" viewBox="0 0 25 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.5 1L6.5 12L1.5 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </td>



                    </tr>
                </tbody>
            </table>
        </div>

    </main>
@endsection
