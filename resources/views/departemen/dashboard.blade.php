@extends('departemen.layouts.layout')

@section('content')
    <div class="mb-4 col-span-full xl:mb-2">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Welcome, departemen!</h1>
    </div>

    <div class="col-span-full xl:col-auto">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0"
                    src="https://flowbite-admin-dashboard.vercel.app/images/users/bonnie-green-2x.png" alt="Jese picture">
                <div>
                    <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Informatika</h3>
                    <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        <p>IF1001</p>
                        <p>INFORMATIKA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-2">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="flow-root">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-gray-900 truncate dark:text-white">
                                    Fakultas
                                </p>
                                <p class="text-sm font-normal text-gray-500 truncate dark:text-gray-400">
                                    Sains dan Matematika
                                </p>
                            </div>
                        </div>
                        {{-- </li>
                    <li class="pt-4 pb-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content2')
    <div class="grid grid-cols-1 gap-4 mt-4 xl:grid-cols-1 2xl:grid-cols-1">
        <div class="col-span-1">
            <div
                class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="relative overflow-x-auto w-full shadow-md sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-300 text-center">
                            Rekap Progress PKL Mahasiswa Informatika Fakultas Sains dan Matematika
                        </h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 dark:border-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="text-center py-2 px-4 text-white" colspan="15">Angkatan</th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2016
                                    </th>
                                    <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2017
                                    </th>
                                    <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2018
                                    </th>
                                    <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2019
                                    </th>
                                    <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2020
                                    </th>
                                    <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2021
                                    </th>
                                    <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2022
                                    </th>
                                </tr>
                                <tr>
                                    <th class="py-2 px-4 text-white border">Sdh</th>
                                    <th class="py-2 px-4 text-white border">Blm</th>
                                    <th class="py-2 px-4 text-white border">Sdh</th>
                                    <th class="py-2 px-4 text-white border">Blm</th>
                                    <th class="py-2 px-4 text-white border">Sdh</th>
                                    <th class="py-2 px-4 text-white border">Blm</th>
                                    <th class="py-2 px-4 text-white border">Sdh</th>
                                    <th class="py-2 px-4 text-white border">Blm</th>
                                    <th class="py-2 px-4 text-white border">Sdh</th>
                                    <th class="py-2 px-4 text-white border">Blm</th>
                                    <th class="py-2 px-4 text-white border">Sdh</th>
                                    <th class="py-2 px-4 text-white border">Blm</th>
                                    <th class="py-2 px-4 text-white border">Sdh</th>
                                    <th class="py-2 px-4 text-white border">Blm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 text-center text-white border">45</td>
                                    <td class="py-2 px-4 text-center text-white border">87</td>
                                    <td class="py-2 px-4 text-center text-white border">45</td>
                                    <td class="py-2 px-4 text-center text-white border">87</td>
                                    <td class="py-2 px-4 text-center text-white border">45</td>
                                    <td class="py-2 px-4 text-center text-white border">87</td>
                                    <td class="py-2 px-4 text-center text-white border">45</td>
                                    <td class="py-2 px-4 text-center text-white border">87</td>
                                    <td class="py-2 px-4 text-center text-white border">45</td>
                                    <td class="py-2 px-4 text-center text-white border">87</td>
                                    <td class="py-2 px-4 text-center text-white border">45</td>
                                    <td class="py-2 px-4 text-center text-white border">87</td>
                                    <td class="py-2 px-4 text-center text-white border">45</td>
                                    <td class="py-2 px-4 text-center text-white border">87</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('content3')
        <div class="grid grid-cols-1 gap-4 mt-4 xl:grid-cols-1 2xl:grid-cols-1">
            <div class="col-span-1">
                <div
                    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <div class="relative overflow-x-auto w-full shadow-md sm:rounded-lg">
                        <div class="p-4 sm:p-6">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-300 text-center">
                                Rekap Progress Skripsi Mahasiswa Informatika Fakultas Sains dan Matematika
                            </h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 dark:border-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="text-center py-2 px-4 text-white" colspan="15">Angkatan</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2016
                                        </th>
                                        <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2017
                                        </th>
                                        <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2018
                                        </th>
                                        <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2019
                                        </th>
                                        <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2020
                                        </th>
                                        <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2021
                                        </th>
                                        <th colspan="2" class="py-2 px-4 text-center border-b border-r text-white">2022
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="py-2 px-4 text-white border">Sdh</th>
                                        <th class="py-2 px-4 text-white border">Blm</th>
                                        <th class="py-2 px-4 text-white border">Sdh</th>
                                        <th class="py-2 px-4 text-white border">Blm</th>
                                        <th class="py-2 px-4 text-white border">Sdh</th>
                                        <th class="py-2 px-4 text-white border">Blm</th>
                                        <th class="py-2 px-4 text-white border">Sdh</th>
                                        <th class="py-2 px-4 text-white border">Blm</th>
                                        <th class="py-2 px-4 text-white border">Sdh</th>
                                        <th class="py-2 px-4 text-white border">Blm</th>
                                        <th class="py-2 px-4 text-white border">Sdh</th>
                                        <th class="py-2 px-4 text-white border">Blm</th>
                                        <th class="py-2 px-4 text-white border">Sdh</th>
                                        <th class="py-2 px-4 text-white border">Blm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4 text-center text-white border">45</td>
                                        <td class="py-2 px-4 text-center text-white border">87</td>
                                        <td class="py-2 px-4 text-center text-white border">45</td>
                                        <td class="py-2 px-4 text-center text-white border">87</td>
                                        <td class="py-2 px-4 text-center text-white border">45</td>
                                        <td class="py-2 px-4 text-center text-white border">87</td>
                                        <td class="py-2 px-4 text-center text-white border">45</td>
                                        <td class="py-2 px-4 text-center text-white border">87</td>
                                        <td class="py-2 px-4 text-center text-white border">45</td>
                                        <td class="py-2 px-4 text-center text-white border">87</td>
                                        <td class="py-2 px-4 text-center text-white border">45</td>
                                        <td class="py-2 px-4 text-center text-white border">87</td>
                                        <td class="py-2 px-4 text-center text-white border">45</td>
                                        <td class="py-2 px-4 text-center text-white border">87</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('content4')
        <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
                <dl>
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Mahasiswa PKL</dt>
                    <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">1000</dd>
                </dl>
            </div>

            <div id="bar-chart"></div>

            <script>
                // Data for the bar chart
                var barChartData = [{
                        name: "Sdh",
                        data: [45, 45, 45, 45, 45, 45],
                        color: "#31C48D",
                    },
                    {
                        name: "Blm",
                        data: [87, 87, 87, 87, 87, 87],
                        color: "#F05252",
                    },
                ];

                // ApexCharts options and config
                window.addEventListener("load", function() {
                    var options = {
                        series: barChartData,
                        chart: {
                            sparkline: {
                                enabled: false,
                            },
                            type: "bar",
                            width: "100%",
                            height: 400,
                            toolbar: {
                                show: false,
                            },
                        },
                        fill: {
                            opacity: 1,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                columnWidth: "100%",
                                borderRadiusApplication: "end",
                                borderRadius: 6,
                                dataLabels: {
                                    position: "top",
                                },
                            },
                        },
                        legend: {
                            show: true,
                            position: "bottom",
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            formatter: function(value) {
                                return value;
                            },
                        },
                        xaxis: {
                            labels: {
                                show: true,
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    cssClass: "text-xs font-normal fill-gray-500 dark:fill-gray-400",
                                },
                            },
                            categories: ["2017", "2018", "2019", "2020", "2021", "2022"],
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                        },
                        yaxis: {
                            labels: {
                                show: true,
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    cssClass: "text-xs font-normal fill-gray-500 dark:fill-gray-400",
                                },
                            },
                        },
                        grid: {
                            show: true,
                            strokeDashArray: 4,
                            padding: {
                                left: 2,
                                right: 2,
                                top: -20,
                            },
                        },
                        fill: {
                            opacity: 1,
                        },
                    };

                    if (document.getElementById("bar-chart") && typeof ApexCharts !== "undefined") {
                        const chart = new ApexCharts(document.getElementById("bar-chart"), options);
                        chart.render();
                    }
                });
            </script>
        </div>
    @endsection
