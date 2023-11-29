<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List Progress Skripsi Mahasiswa Informatika</title>
    <!-- Bootstrap CSS (jika menggunakan framework Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS styling -->
    <style>
        /* CSS style untuk membuat tampilan tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; /* Jarak antara tabel dan tombol */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
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
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white text-center">Daftar Belum Lulus Skripsi Mahasiswa Informatika</h1>
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
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    
    </div>

    
    
</body>
</html>
