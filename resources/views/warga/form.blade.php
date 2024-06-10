@extends('layouts.welcome')

@section('content')
<style>
    .custom-button {
        padding: 15px 30px;
        font-size: 20px;
        cursor: pointer;
        border: none;
        border-radius: 15px;
        background-color: #6f9bca;
        color: white;
        transition: all 0.3s ease;
    }

    .form-container {
        margin: 20px auto;
        background: #fff;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .button {
        background-color: #007bff;
        color: #fff;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #0056b3;
    }

    /* Medium devices (tablets, 768px and up) */
    @media (max-width: 768px) {
        .custom-button {
            padding: 12px 25px;
            font-size: 18px;
        }
    }

    /* Small devices (landscape phones, 576px and up) */
    @media (max-width: 576px) {
        .custom-button {
            padding: 10px 20px;
            font-size: 16px;
        }
    }

    /* Extra small devices (phones, less than 576px) */
    @media (max-width: 480px) {
        .custom-button {
            padding: 8px 15px;
            font-size: 14px;
        }

        .form-container {
            padding: 15px;
            box-shadow: none;
            max-width: 100%;
        }

        .button {
            width: 100%;
            padding: 10px;
        }

        .label, .input, .button {
            font-size: 14px;
        }

        .input {
            padding: 6px;
        }
    }
</style>

<main class="mx-auto p-4 sm:p-6 md:p-36" style="min-height: 100vh; background-color: #FBEEC1;">
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Form Input Iuran</h2>
        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-medium">Nama:</label>
                <input type="text" id="nama" name="nama" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ auth()->user()->name }}" readonly>
            </div>
            
            <div class="mb-4">
                <label for="periode" class="block text-gray-700 font-medium">Tanggal Pembayaran:</label>
                <input type="date" id="periode" name="periode" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="total" class="block text-gray-700 font-medium">Total:</label>
                <input type="number" id="total" name="total" placeholder="Nominal" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 font-medium">Keterangan:</label>
                <select id="keterangan" name="keterangan" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih bulan</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="bukti" class="block text-gray-700 font-medium">Bukti:</label>
                <input type="file" id="bukti" name="bukti" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="rt_id" class="block text-gray-700 font-medium">RT:</label>
                <select id="rt_id" name="rt_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>Select RT</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" onclick="return confirmSubmit()" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Kirim</button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    $(function(){
        $(document).on('click', '#kirim', function(e) {
            e.preventDefault();
            var form = $(this).closest('form'); // get the closest form to the button

            swalWithBootstrapButtons.fire({
                title: "Apakah Anda Yakin?",
                text: "Mengirim Iuran RT",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "YA, Kirimkan!",
                cancelButtonText: "Tidak, Batalkan!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // submit the form if the user confirms
                    swalWithBootstrapButtons.fire({
                        title: "Iuran Berhasil Dikirim!",
                        icon: "success"
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Dibatalkan",
                        text: "Iuran GAGAL di Input",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>
@endsection
