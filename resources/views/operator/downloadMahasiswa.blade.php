<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Mahasiswa Informatika</title>
    <!-- Bootstrap CSS (jika menggunakan framework Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS styling -->
    <style>
        /* CSS style untuk membuat tampilan tabel */
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            margin: 20px;
        }
        table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
            margin-bottom: 1px; /* Jarak antara tabel dan tombol */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container-lg {
            margin-top: 20px; /* Jarak atas container */
        }
        .btn-print {
            float: right; /* Tombol Cetak di sebelah kanan */
            margin-bottom: 10px; /* Jarak dari bawah tombol */
        }
    </style>

</head>
<body>
    <div class="container-lg">
        <div class="mb-4 col-span-full xl:mb-2">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white text-center">Daftar Akun Mahasiswa Informatika</h1>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white text-center">Fakultas Sains dan Matematika</h1>
        </div>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Nomor
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Nama
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        NIM
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Angkatan
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Status
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Jalur Masuk
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Nama Dosen Wali
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        NIP Dosen Wali
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Username
                    </th>
                    <th scope="col"
                        class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Password
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
                @php
                    $counter = 1;
                @endphp
                @foreach ($mahasiswas as $mahasiswa)
                <tr>
                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <span class="font-semibold">{{$counter++}}</span>
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                        {{$mahasiswa->nama}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        {{$mahasiswa->nim}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        {{$mahasiswa->angkatan}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        {{$mahasiswa->status}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        {{$mahasiswa->jalur_masuk}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        {{$mahasiswa->dosen_nama}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        {{$mahasiswa->nip}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        {{$mahasiswa->username}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        {{$mahasiswa->password}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
    </div>

    
    
</body>
</html>
