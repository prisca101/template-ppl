@extends('operator.layouts.layout')

@section('content')
    <div class="mb-4 col-span-full xl:mb-2">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Welcome, {{ $operators->nama }}!</h1>
    </div>

    <div class="col-span-full xl:col-auto">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                <img src="{{ Auth::user()->getImageURL() }}" class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0"
                    alt="foto-profil" />
                <div>
                    <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ $operators->nama }}</h3>
                    <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        <p>{{ $operators->nip }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-2">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Grafik</h3>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">Mahasiswa</span>
                </div>
            </div>
            <canvas id="grafik"></canvas> <!-- Mengubah div menjadi canvas untuk grafik -->

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById('grafik').getContext('2d');
                    var mahasiswaAktifCount = {{ $mahasiswa_aktif }}; // change this to count mhs aktif
                    var mahasiswaTidakAktifCount = {{ $mahasiswa_tidak_aktif }}; // change this to count mhs tidak aktif

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Mahasiswa Aktif', 'Mahasiswa Tidak Aktif'],
                            datasets: [{
                                label: 'Count',
                                data: [mahasiswaAktifCount, mahasiswaTidakAktifCount],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>




            <!-- Card Footer -->
            {{-- <div class="flex items-center justify-between pt-4 lg:justify-evenly sm:pt-6">
                <div>
                    <h3 class="text-gray-500 dark:text-gray-400">Mahasiswa Aktif</h3>
                    <h4 class="text-xl font-bold dark:text-white">
                        {{$mahasiswa_aktif}}
                    </h4>
                </div>
                <div>
                    <h3 class="text-gray-500 dark:text-gray-400">Mahasiswa Tidak Aktif</h3>
                    <h4 class="text-xl font-bold dark:text-white">
                        {{$mahasiswa_tidak_aktif}}
                    </h4>                    
                </div>
            </div> --}}
        </div>
    </div>
@endsection




@section('content5')
    <div class="col-span-1">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Grafik</h3>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">Mahasiswa
                        PKL</span>
                </div>
            </div>

            <div id="column-chart3"></div>


            <script>
                // ApexCharts options and config
                window.addEventListener("load", function() {
                    const categories = {!! json_encode($result->keys()) !!};
                    const options = {
                        colors: ["#1A56DB", "#FDBA8C"],
                        series: [{
                                name: "Lulus",
                                color: "#1A56DB",
                                data: {!! json_encode($result->pluck('pkl_lulus_count')) !!}, // change x to angkatan and y to pkl lulus
                            },
                            {
                                name: "Tidak Lulus",
                                color: "#FDBA8C",
                                data: {!! json_encode($result->pluck('pkl_tidak_lulus_count')) !!}, // change x to angkatan and y to pkl tidak lulus
                            },
                        ],
                        chart: {
                            type: "bar",
                            height: "320px",
                            fontFamily: "Inter, sans-serif",
                            toolbar: {
                                show: false,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "70%",
                                borderRadiusApplication: "end",
                                borderRadius: 8,
                            },
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            style: {
                                fontFamily: "Inter, sans-serif",
                            },
                        },
                        states: {
                            hover: {
                                filter: {
                                    type: "darken",
                                    value: 1,
                                },
                            },
                        },
                        stroke: {
                            show: true,
                            width: 0,
                            colors: ["transparent"],
                        },
                        grid: {
                            show: false,
                            strokeDashArray: 4,
                            padding: {
                                left: 2,
                                right: 2,
                                top: -14
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            floating: false,
                            labels: {
                                show: true,
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                                },
                            },
                            categories: categories,
                            axisBorder: {
                                show: true,
                            },
                            axisTicks: {
                                show: false,
                            },
                        },
                        yaxis: {
                            labels: {
                                show: true,
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                                },
                            },
                            axisBorder: {
                                show: true,
                            },
                            axisTicks: {
                                show: true,
                            },
                        },
                        fill: {
                            opacity: 1,
                        },
                    }

                    if (document.getElementById("column-chart3") && typeof ApexCharts !== 'undefined') {
                        const chart = new ApexCharts(document.getElementById("column-chart3"), options);
                        chart.render();
                    }
                });
            </script>
        </div>
    </div>

    <div class="col-span-1">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Grafik</h3>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">Mahasiswa
                        Skripsi</span>
                </div>
            </div>

            <div id="column-chart2"></div>


            <script>
                // ApexCharts options and config
                window.addEventListener("load", function() {
                    const categories = {!! json_encode($result->keys()) !!};
                    const options = {
                        colors: ["#1A56DB", "#FDBA8C"],
                        series: [{
                                name: "Lulus",
                                color: "#1A56DB",
                                data: {!! json_encode($result->pluck('lulus_count')) !!},
                            },
                            {
                                name: "Tidak Lulus",
                                color: "#FDBA8C",
                                data: {!! json_encode($result->pluck('tidak_lulus_count')) !!},
                            },
                        ],
                        chart: {
                            type: "bar",
                            height: "320px",
                            fontFamily: "Inter, sans-serif",
                            toolbar: {
                                show: false,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "70%",
                                borderRadiusApplication: "end",
                                borderRadius: 8,
                            },
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            style: {
                                fontFamily: "Inter, sans-serif",
                            },
                        },
                        states: {
                            hover: {
                                filter: {
                                    type: "darken",
                                    value: 1,
                                },
                            },
                        },
                        stroke: {
                            show: true,
                            width: 0,
                            colors: ["transparent"],
                        },
                        grid: {
                            show: false,
                            strokeDashArray: 4,
                            padding: {
                                left: 2,
                                right: 2,
                                top: -14
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            floating: false,
                            labels: {
                                show: true,
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                                },
                            },
                            categories: categories,
                            axisBorder: {
                                show: true,
                            },
                            axisTicks: {
                                show: false,
                            },
                        },
                        yaxis: {
                            labels: {
                                show: true,
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                                },
                            },
                            axisBorder: {
                                show: true,
                            },
                            axisTicks: {
                                show: true,
                            },
                        },
                        fill: {
                            opacity: 1,
                        },
                    }

                    if (document.getElementById("column-chart2") && typeof ApexCharts !== 'undefined') {
                        const chart = new ApexCharts(document.getElementById("column-chart2"), options);
                        chart.render();
                    }
                });
            </script>
        </div>
    </div>
@endsection





@section('content2')
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <!-- Card header -->
        <div class="items-center justify-between lg:flex">
            <div class="mb-4 lg:mb-0">
                <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">PKL Recap</h3>
                <span class="text-base font-normal text-gray-500 dark:text-gray-400">Rekap progres PKL seluruh mahasiswa
                    Informatika berdasarkan angkatan</span>
            </div>

            <div class="items-center sm:flex">
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <a href="{{ route('rekapPKL') }}"
                        class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Download recap
                    </a>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="flex flex-col mt-6">
            <div class="overflow-x-auto rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow sm:rounded-lg border">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700 border-b">
                                <tr>
                                    @foreach ($angkatan as $tahun)
                                        <th scope="col"
                                            class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            {{ $tahun }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800">

                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            @foreach ($angkatan as $tahun)
                                                <th scope="col"
                                                    class="border-r text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    Sudah
                                                </th>
                                                <th scope="col"
                                                    class="border-r text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    Belum
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        <tr>

                                            @foreach ($result as $angkatan => $data)
                                                <td
                                                    class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                                    <a href="{{ route('list.index', ['angkatan' => $angkatan, 'status' => 'verified']) }}"
                                                        class="hover:underline">{{ $data['pkl_lulus_count'] }}</a>
                                                </td>
                                                <td
                                                    class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                                    <a href="{{ route('list.index2', ['angkatan' => $angkatan, 'status' => 'pending']) }}"
                                                        class="hover:underline">{{ $data['pkl_tidak_lulus_count'] }}</a>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="mt-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <!-- Card header -->
        <div class="items-center justify-between lg:flex">
            <div class="mb-4 lg:mb-0">
                <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Skripsi Recap</h3>
                <span class="text-base font-normal text-gray-500 dark:text-gray-400">Rekap progres skripsi seluruh mahasiswa
                    Informatika berdasarkan angkatan</span>
            </div>

            <div class="items-center sm:flex">
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <a href="{{ route('rekapSkripsi') }}"
                        class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Download recap
                    </a>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="flex flex-col mt-6">
            <div class="overflow-x-auto rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow sm:rounded-lg border">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700 border-b">
                                <tr>
                                    @foreach ($angkatan2 as $tahun)
                                        <th scope="col"
                                            class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            {{ $tahun }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800">

                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            @foreach ($angkatan2 as $tahun)
                                                <th scope="col"
                                                    class="border-r text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    Sudah
                                                </th>
                                                <th scope="col"
                                                    class="border-r text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    Belum
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">

                                        <tr>
                                            @foreach ($result as $angkatan => $data)
                                                <td
                                                    class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                                    <a href="{{ route('list.skripsi', ['angkatan' => $angkatan, 'status' => 'verified']) }}"
                                                        class="hover:underline">{{ $data['lulus_count'] }}</a>
                                                </td>
                                                <td
                                                    class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                                    <a href="{{ route('list.skripsi2', ['angkatan' => $angkatan, 'status' => 'pending']) }}"
                                                        class="hover:underline">{{ $data['tidak_lulus_count'] }}</a>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div
        class="mt-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <!-- Card header -->
        <div class="items-center justify-between lg:flex">
            <div class="mb-4 lg:mb-0">
                <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Status Recap</h3>
                <span class="text-base font-normal text-gray-500 dark:text-gray-400">Rekap status seluruh mahasiswa
                    Informatika berdasarkan angkatan</span>
            </div>

            <div class="items-center sm:flex">
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <a href="{{ route('rekapSkripsi') }}"
                        class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Download recap
                    </a>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="flex flex-col mt-6">
            <div class="overflow-x-auto rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow sm:rounded-lg border">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700 border-b">
                                <tr>
                                    <th scope="col"
                                        class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Status
                                    </th>
                                    @foreach ($angkatan2 as $tahun)
                                        <th scope="col"
                                            class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            {{ $tahun }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800">

                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <tbody class="bg-white dark:bg-gray-800">
                                        {{-- @foreach ($result as $angkatan => $data) --}}
                                            <tr>
                                                <td class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                    Aktif
                                                </td>
                                                @foreach ($result as $angkatan => $data)
                                                <td
                                                    class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                                    <a href="{{ route('list.skripsi', ['angkatan' => $angkatan, 'status' => 'active']) }}"
                                                        class="hover:underline">{{ $data['active'] }} aktif </a>
                                                </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Lulus</td>
                                                <td
                                                    class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                                    {{-- <a href="{{ route('list.skripsi', ['angkatan' => $angkatan, 'status' => 'verified']) }}"
                                                        class="hover:underline">{{ $data['lulus'] }} lulus </a> --}}
                                                        HA
                                                </td>
                                            </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
