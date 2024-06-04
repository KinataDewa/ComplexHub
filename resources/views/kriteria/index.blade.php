@extends('layouts.welcome')

@section('content')
    {{-- Content --}}
    <style>
            /* Table styles */
    table {
      border-collapse: collapse;
      width: 100%;
      margin: 20px auto;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
      
        /* Remove border on the bottom of the table body */
        .table tbody tr:last-child td {
          border-bottom: none;
        }
      
        /* Style for the "Edit" button within the table cell */
        .btn-warning {
        background-color: #ffc107;
        color: #212529;
        .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }
    }
      </style>
    <main class="mx-auto p-36 contain-responsive" style="min-height: 100vh; background-color: #FBEEC1;">
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Navbar, Tabel</title>
            <style>
                #navbar {
                    text-align: center;
                }
                #navbar a {
                    display: inline-block;
                    padding: 10px 20px;
                    text-decoration: none;
                    font-size: 24px;
                    font-weight: 600;
                }
            </style>
        </head>
        <body>
            <nav id="navbar">
                <a href="{{ url('destinasi/RW/destinasiwisataRW') }}">Beranda</a>
                <a href="{{ url('/kriteria') }}">Kriteria</a>
                <a href="{{ url('/alternatif') }}">Alternatif</a>
                <a href="{{ url('/penilaian') }}">Penilaian</a>
                <a href="{{ url('/saw') }}">Ranking</a>
            </nav>

            <div class="rounded-md relative p-16 top-24 left-16 bg-white mr-28">
                <p class="mb-10" style="font-size: 24px; font-family: 'Poppins', sans-serif; font-weight: 600; color: #2A424F;">
                  Data Kriteria Destinasi Wisata:
                </p>
              
                <table class="md:table-fixed w-full table">
                  <thead>
                    <tr>
                    <th class="text-center">No</th>
                    <th class="text-center w-1/7">Nama Wisata</th>
                    <th class="text-center w-1/7">Jenis</th>
                    <th class="text-center w-1/7">Bobot</th>
                    <th class="text-center w-1/7">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($kriterias as $index => $kriteria)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $kriteria->nama }}</td>
                        <td class="text-center">{{ $kriteria->jenis }}</td>
                        <td class="text-center">{{ $kriteria->bobot }}</td>
                        <td class="text-center">
                          <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="btn btn-warning">Edit</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
    </body>
        </html>
    </main>
@endsection