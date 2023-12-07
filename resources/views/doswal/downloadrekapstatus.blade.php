<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Progress Status Mahasiswa Informatika</title>
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
        h1, h2, h3, h4, h5, h6 {
            text-align: center;
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
    <h2>Rekap Status Mahasiswa Informatika</h2>
    <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
        <thead class="bg-gray-50 dark:bg-gray-700 border-b">
            <tr>
                <th scope="col"
                    class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                    Status
                </th>
                @foreach ($angkatan as $tahun)
                    <th scope="col"
                        class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        {{ $tahun }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800">
            <tr>
                <td class=" text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                    Aktif
                </td>
                @foreach ($result as $angkatan => $data)
                <td
                    class="border-r text-center p-4 text-sm font-semibold text-grey-900 whitespace-nowrap dark:text-blue-500">
                   {{ $data['active'] }}
                </td>
                @endforeach
            </tr>
            <tr>
                <td class="  text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Lulus</td>
                @foreach ($result as $angkatan => $data)
                <td
                    class="border-r text-center p-4 text-sm font-semibold text-grey-900 whitespace-nowrap dark:text-blue-500">
                    {{ $data['lulus'] }} 
                </td>
                @endforeach
            </tr>
            <tr>
                <td class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Drop Out</td>
                @foreach ($result as $angkatan => $data)
                <td
                    class="border-r text-center p-4 text-sm font-semibold text-grey-900 whitespace-nowrap dark:text-blue-500">
                    {{ $data['do'] }}
                </td>
                @endforeach
            </tr>
            <tr>
                <td class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Meninggal Dunia</td>
                @foreach ($result as $angkatan => $data)
                <td
                    class="border-r text-center p-4 text-sm font-semibold text-grey-900 whitespace-nowrap dark:text-blue-500">
                   {{ $data['meninggal_dunia'] }} 
                </td>
                @endforeach
            </tr>
            <tr>
                <td class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Cuti</td>
                @foreach ($result as $angkatan => $data)
                <td
                    class="border-r text-center p-4 text-sm font-semibold text-grey-900 whitespace-nowrap dark:text-blue-500">
                    {{ $data['cuti'] }} 
                </td>
                @endforeach
            </tr>
            <tr>
                <td class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Undur Diri</td>
                @foreach ($result as $angkatan => $data)
                <td
                    class="border-r text-center p-4 text-sm font-semibold text-grey-900 whitespace-nowrap dark:text-blue-500">
                    {{ $data['undur_diri'] }} 
                </td>
                @endforeach
            </tr>
            <tr>
                <td class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Mangkir</td>
                @foreach ($result as $angkatan => $data)
                <td
                    class="border-r text-center p-4 text-sm font-semibold text-grey-900 whitespace-nowrap dark:text-blue-500">
                   {{ $data['mangkir'] }} 
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</body>
</html>
