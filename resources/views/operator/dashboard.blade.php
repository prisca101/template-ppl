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
    <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Grafik</h3>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">Mahasiswa Status</span>
                </div>
            </div>

            <div id="column-chart4"></div>


            <script>
                // ApexCharts options and config
                window.addEventListener("load", function() {
                    const categories = {!! json_encode($result->keys()) !!};
                    const options = {
                        colors: ["#AECDC2", "#FDBA8C", "#FFABAB", "#D4A5A5", "#392F5A","#31A2AC"],
                        series: [{
                                name: "Aktif",
                                color: "#AECDC2",
                                data: {!! json_encode($result->pluck('active')) !!},
                            },
                            {
                                name: "Lulus",
                                color: "#FDBA8C",
                                data: {!! json_encode($result->pluck('lulus')) !!},
                            },
                            {
                                name: "Drop Out",
                                color: "#FFABAB",
                                data: {!! json_encode($result->pluck('do')) !!},
                            },
                            {
                                name: "Meninggal Dunia",
                                color: "#D4A5A5",
                                data: {!! json_encode($result->pluck('meninggal_dunia')) !!},
                            },
                            {
                                name: "Undur Diri",
                                color: "#392F5A",
                                data: {!! json_encode($result->pluck('undur_diri')) !!},
                            },
                            {
                                name: "Mangkir",
                                color: "#31A2AC",
                                data: {!! json_encode($result->pluck('mangkir')) !!},
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

                    if (document.getElementById("column-chart4") && typeof ApexCharts !== 'undefined') {
                        const chart = new ApexCharts(document.getElementById("column-chart4"), options);
                        chart.render();
                    }
                });
            </script>
        </div>
    </div>
@endsection
