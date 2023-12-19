@extends('operator.layouts.layout')

@section('content')
    <div class="mb-4 col-span-full xl:mb-2">
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="/dashboardOperator"
                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Rekap</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Rekap Mahasiswa</h1>
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
                    <a href="{{ route('downloadRekapPKL') }}"
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
                                                    <a href="{{ route('pkllulus', ['angkatan' => $angkatan, 'status' => 'verified']) }}"
                                                        class="hover:underline">{{ $data['pkl_lulus_count'] }}</a>
                                                </td>
                                                <td
                                                    class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                                    <a href="{{ route('pkltidaklulus', ['angkatan' => $angkatan, 'status' => 'pending']) }}"
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
                    <a href="{{ route('downloadRekapSkripsi') }}"
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
                                                    <a href="{{ route('skripsilulus', ['angkatan' => $angkatan, 'status' => 'verified']) }}"
                                                        class="hover:underline">{{ $data['lulus_count'] }}</a>
                                                </td>
                                                <td
                                                    class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                                    <a href="{{ route('skripsitidaklulus', ['angkatan' => $angkatan, 'status' => 'pending']) }}"
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

    <div class="mt-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <!-- Card header -->
        <div class="items-center justify-between lg:flex">
            <div class="mb-4 lg:mb-0">
                <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Status Recap</h3>
                <span class="text-base font-normal text-gray-500 dark:text-gray-400">Rekap status seluruh mahasiswa
                    Informatika berdasarkan angkatan</span>
            </div>

            <div class="items-center sm:flex">
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <a href="{{ route('downloadRekapStatus') }}"
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
                                    @foreach ($angkatan3 as $tahun)
                                        <th scope="col"
                                            class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            {{ $tahun }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800">
                                <tr>
                                    <td
                                        class=" text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Aktif
                                    </td>
                                    @foreach ($result as $angkatan => $data)
                                        <td
                                            class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                            <a href="{{ route('daftarstatus', ['angkatan' => $angkatan, 'status' => 'active']) }}"
                                                class="hover:underline">{{ $data['active'] }} </a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td
                                        class="  text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Lulus</td>
                                    @foreach ($result as $angkatan => $data)
                                        <td
                                            class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                            <a href="{{ route('daftarstatus', ['angkatan' => $angkatan, 'status' => 'lulus']) }}"
                                                class="hover:underline">{{ $data['lulus'] }} </a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td
                                        class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Drop Out</td>
                                    @foreach ($result as $angkatan => $data)
                                        <td
                                            class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                            <a href="{{ route('daftarstatus', ['angkatan' => $angkatan, 'status' => 'do']) }}"
                                                class="hover:underline">{{ $data['do'] }} </a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td
                                        class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Meninggal Dunia</td>
                                    @foreach ($result as $angkatan => $data)
                                        <td
                                            class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                            <a href="{{ route('daftarstatus', ['angkatan' => $angkatan, 'status' => 'meninggal']) }}"
                                                class="hover:underline">{{ $data['meninggal'] }} </a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td
                                        class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Cuti</td>
                                    @foreach ($result as $angkatan => $data)
                                        <td
                                            class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                            <a href="{{ route('daftarstatus', ['angkatan' => $angkatan, 'status' => 'cuti']) }}"
                                                class="hover:underline">{{ $data['cuti'] }} </a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td
                                        class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Undur Diri</td>
                                    @foreach ($result as $angkatan => $data)
                                        <td
                                            class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                            <a href="{{ route('daftarstatus', ['angkatan' => $angkatan, 'status' => 'undur diri']) }}"
                                                class="hover:underline">{{ $data['undur diri'] }} </a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td
                                        class="text-center border-r text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Mangkir</td>
                                    @foreach ($result as $angkatan => $data)
                                        <td
                                            class="border-r text-center p-4 text-sm font-semibold text-blue-500 whitespace-nowrap dark:text-blue-500">
                                            <a href="{{ route('daftarstatus', ['angkatan' => $angkatan, 'status' => 'mangkir']) }}"
                                                class="hover:underline">{{ $data['mangkir'] }} </a>
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
@endsection
