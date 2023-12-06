<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Progress Skripsi Mahasiswa Informatika</title>
    <!-- CSS styling -->
    <style>
        /* CSS style untuk membuat tampilan tabel */
        @page {
            size: landscape;
        }
        body {
            width: 21cm;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <h2>Rekap Progress Skripsi Mahasiswa Informatika</h2>
    <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
        <thead class="bg-gray-50 dark:bg-gray-700 border-b">
            <tr>
                @foreach($angkatan as $tahun)
                    <th colspan="2" scope="col" class="border-r text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        {{ $tahun }}
                    </th>
                @endforeach
            </tr>
            <tr>
                @foreach($angkatan as $tahun)
                    <th scope="col" class="border-r text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Sudah
                    </th>
                    <th scope="col" class="border-r text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Belum
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800">
            
                <tr>
                    @foreach($result as $angkatan => $data)
                        <td class="border-r text-center p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">{{ $data['lulus_count'] }}</td>
                        <td class="border-r text-center p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">{{ $data['tidak_lulus_count'] }}</td>
                    @endforeach
                </tr>
            
        </tbody>
    </table>
</body>
</html>
