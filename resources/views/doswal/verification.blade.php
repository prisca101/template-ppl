@extends('doswal.layouts.layout')

@section('content')
    <div class="mb-4 col-span-full xl:mb-2">
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="/dashboardDosen"
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
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Verification</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Verification</h1>
    </div>
@endsection

@section('content2')

    <!--Tabs widget -->
    <div class="my-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="fullWidthTab"
            data-tabs-toggle="#fullWidthTabContent" role="tablist">
            <li class="me-2" role="presentation">
                <button id="irs-tab" data-tabs-target="#irs" type="button" role="tab" aria-controls="irs"
                    aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">IRS</button>
            </li>
            <li class="me-2" role="presentation">
                <button id="khs-tab" data-tabs-target="#khs" type="button" role="tab" aria-controls="khs"
                    aria-selected="false"
                    class="inline-block py-2 px-5 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">KHS</button>
            </li>
            <li class="me-2" role="presentation">
                <button id="pkl-tab" data-tabs-target="#pkl" type="button" role="tab" aria-controls="pkl"
                    aria-selected="false"
                    class="inline-block py-2 px-5 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">PKL</button>
            </li>
            <li class="me-2" role="presentation">
                <button id="skripsi-tab" data-tabs-target="#skripsi" type="button" role="tab" aria-controls="skripsi"
                    aria-selected="false"
                    class="inline-block py-2 px-5 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Skripsi</button>
            </li>
        </ul>
    </div>

    <div
    class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <!--IRS -->
    <div id="fullWidthTabContent" class="">
        <div class="hidden pt-4" id="irs" role="tabpanel" aria-labelledby="irs-tab">
            <div class="sm:flex mb-4">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3" action="" method="GET">
                        <label for="users-search" class="sr-only">Search</label>
                        <div class="relative mt-1 lg:w-64 xl:w-96">
                            <input type="text" name="email" id="users-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search for users">
                        </div>
                    </form>
                    <div class="flex pl-0 mt-3 space-x-1 sm:pl-2 sm:mt-0">
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-circle-check fa-lg"></i></span>                         
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-circle-xmark fa-lg"></i></span>
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-trash-can fa-lg"></i></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="flex flex-col">
                <div class="overflow-x-auto rounded-t-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        
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
                                            Semester Aktif
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Jumlah SKS
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Scan IRS
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Approval
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">

                                    <tr>
                                    @foreach($irs as $ir)
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$ir->nama}}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$ir->nim}}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{$ir->semester_aktif}}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{$ir->jumlah_sks}}
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            <div
                                                class="flex items-center p-3 mb-3.5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                <div
                                                    class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
                                                    <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300"
                                                        fill="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                                            d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z">
                                                        </path>
                                                        <path
                                                            d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="mr-4">
                                                    <a href="{{ asset('storage/' . $ir->scanIRS) }}" target="_blank" class="text-sm font-semibold text-gray-900 dark:text-white">Lihat IRS</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <div class="flex space-x-2">
                                                <form action="{{ route('verifikasi', ['nim' => $ir->nim, 'semester_aktif' => $ir->semester_aktif]) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                                        <span><i class="fa-solid fa-check" style="color: #ffffff;"></i></span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('rejected', ['nim' => $ir->nim, 'semester_aktif' => $ir->semester_aktif]) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-red-700 rounded-lg focus:ring-4 focus:ring-red-200 dark:focus:ring-red-900 hover:bg-red-800">
                                                        <span><i class="fa-solid fa-xmark" style="color: #ffffff;"></i></span>
                                                    </button>
                                                </form>
                                                <form action="" method="get">
                                                    @csrf
                                                    <button type="submit" class="edit-btn rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                                        <span><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="rounded-b-lg sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span
                            class="font-semibold text-gray-900 dark:text-white">1-20</span> of <span
                            class="font-semibold text-gray-900 dark:text-white">2290</span></span>
                </div>
            </div>
        </div>
    </div>


    <!--KHS -->
    <div id="fullWidthTabContent">
        <div class="hidden pt-4" id="khs" role="tabpanel" aria-labelledby="khs-tab">
            <div class="sm:flex mb-4">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3" action="" method="GET">
                    <label for="users-search" class="sr-only">Search</label>
                    <div class="relative mt-1 lg:w-64 xl:w-96">
                        <input type="text" name="email" id="users-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search for users">
                    </div>
                    </form>
                    <div class="flex pl-0 mt-3 space-x-1 sm:pl-2 sm:mt-0">
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-circle-check fa-lg"></i></span>                         
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-circle-xmark fa-lg"></i></span>
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-trash-can fa-lg"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Table -->
            <div class="w-full mb-1">
                <div class="flex flex-col">
                    <div class="overflow-x-auto rounded-t-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr> 
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
                                                Semester Aktif
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                IP Semester
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                IP Kumulatif
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Jumlah SKS
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Jumlah SKS Kumulatif
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Scan KHS
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Approval
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        <tr>
                                        @foreach($khs as $kh)
                                            <td
                                                class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$kh->nama}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$kh->nim}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$kh->semester_aktif}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$kh->ip_semester}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$kh->ip_kumulatif}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$kh->jumlah_sks}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$kh->jumlah_sks_kumulatif}}
                                            </td>
                                            <td
                                                class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div
                                                    class="flex items-center p-3 mb-3.5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                    <div
                                                        class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
                                                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300"
                                                            fill="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                                d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z">
                                                            </path>
                                                            <path
                                                                d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div class="mr-4">
                                                        <a href="{{ asset('storage/' . $kh->scanKHS) }}" target="_blank" class="text-sm font-semibold text-gray-900 dark:text-white">Lihat KHS</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 space-x-2 whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('verifikasiKHS', ['nim' => $kh->nim, 'semester_aktif' => $kh->semester_aktif]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                                            <span><i class="fa-solid fa-check" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('rejectedKHS', ['nim' => $kh->nim, 'semester_aktif' => $kh->semester_aktif]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-red-700 rounded-lg focus:ring-4 focus:ring-red-200 dark:focus:ring-red-900 hover:bg-red-800">
                                                            <span><i class="fa-solid fa-xmark" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                    <form action="" method="get">
                                                        @csrf
                                                        <button type="submit" class="edit-btn rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                                            <span><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                </div>
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
                class="rounded-b-lg sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span
                            class="font-semibold text-gray-900 dark:text-white">1-20</span> of <span
                            class="font-semibold text-gray-900 dark:text-white">2290</span></span>
                </div>
            </div>
        </div>
    </div>

    <!--PKL -->
    <div id="fullWidthTabContent">
        <div class="hidden pt-4" id="pkl" role="tabpanel" aria-labelledby="pkl-tab">
            <div class="sm:flex mb-4">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3" action="" method="GET">
                    <label for="users-search" class="sr-only">Search</label>
                    <div class="relative mt-1 lg:w-64 xl:w-96">
                        <input type="text" name="email" id="users-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search for users">
                    </div>
                    </form>
                    <div class="flex pl-0 mt-3 space-x-1 sm:pl-2 sm:mt-0">
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-circle-check fa-lg"></i></span>                         
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-circle-xmark fa-lg"></i></span>
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-trash-can fa-lg"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Table -->
            <div class="w-full mb-1">
                <div class="flex flex-col">
                    <div class="overflow-x-auto rounded-t-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            
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
                                                Semester Aktif
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Nilai
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Scan PKL
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Approval
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        <tr>
                                        @foreach($pkl as $pk)
                                            <td
                                                class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$pk->nama}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$pk->nim}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$pk->semester_aktif}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$pk->nilai}}
                                            </td>
                                            <td
                                                class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div
                                                    class="flex items-center p-3 mb-3.5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                    <div
                                                        class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
                                                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300"
                                                            fill="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                                d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z">
                                                            </path>
                                                            <path
                                                                d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div class="mr-4">
                                                        <a href="{{ asset('storage/' . $pk->scanPKL) }}" target="_blank" class="text-sm font-semibold text-gray-900 dark:text-white">Lihat PKL</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 space-x-2 whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('verifikasiPKL', ['nim' => $pk->nim, 'semester_aktif' => $pk->semester_aktif]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                                            <span><i class="fa-solid fa-check" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('rejectedPKL', ['nim' => $pk->nim, 'semester_aktif' => $pk->semester_aktif]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-red-700 rounded-lg focus:ring-4 focus:ring-red-200 dark:focus:ring-red-900 hover:bg-red-800">
                                                            <span><i class="fa-solid fa-xmark" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                    <form action="" method="get">
                                                        @csrf
                                                        <button type="submit" class="edit-btn rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                                        <span><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                </div>
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
                class="rounded-b-lg sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span
                            class="font-semibold text-gray-900 dark:text-white">1-20</span> of <span
                            class="font-semibold text-gray-900 dark:text-white">2290</span></span>
                </div>
            </div>
        </div>
    </div>

    <!--Skripsi -->
    <div id="fullWidthTabContent">
        <div class="hidden pt-4" id="skripsi" role="tabpanel" aria-labelledby="skripsi-tab">
            <div class="sm:flex mb-4">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3" action="" method="GET">
                    <label for="users-search" class="sr-only">Search</label>
                    <div class="relative mt-1 lg:w-64 xl:w-96">
                        <input type="text" name="email" id="users-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search for users">
                    </div>
                    </form>
                    <div class="flex pl-0 mt-3 space-x-1 sm:pl-2 sm:mt-0">
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-circle-check fa-lg"></i></span>                         
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-circle-xmark fa-lg"></i></span>
                        </a>
                        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span><i class="fa-solid fa-trash-can fa-lg"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Table -->
            <div class="w-full mb-1">
                <div class="flex flex-col">
                    <div class="overflow-x-auto rounded-t-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            
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
                                                Semester Aktif
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Lama Studi
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Tanggal Sidang
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Nilai
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Scan Skripsi
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Approval
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        <tr>
                                        @foreach($skripsi as $skrips)
                                            <td
                                                class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$skrips->nama}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$skrips->nim}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$skrips->semester_aktif}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$skrips->lama_studi}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$skrips->tanggal_sidang}}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{$skrips->nilai}}
                                            </td>
                                            <td
                                                class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div
                                                    class="flex items-center p-3 mb-3.5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                    <div
                                                        class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
                                                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300"
                                                            fill="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                                d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z">
                                                            </path>
                                                            <path
                                                                d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div class="mr-4">
                                                        <a href="{{ asset('storage/' . $skrips->scanSkripsi) }}" target="_blank" class="text-sm font-semibold text-gray-900 dark:text-white">Lihat Skripsi</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 space-x-2 whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('verifikasiSkripsi', ['nim' => $skrips->nim, 'semester_aktif' => $skrips->semester_aktif]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                                            <span><i class="fa-solid fa-check" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('rejectedSkripsi', ['nim' => $skrips->nim, 'semester_aktif' => $skrips->semester_aktif]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-red-700 rounded-lg focus:ring-4 focus:ring-red-200 dark:focus:ring-red-900 hover:bg-red-800">
                                                            <span><i class="fa-solid fa-xmark" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                    <form action="" method="get">
                                                        @csrf
                                                        <button type="submit" class="edit-btn rounded-full inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                                        <span><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></span>
                                                        </button>
                                                    </form>
                                                </div>
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
                class="rounded-b-lg sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span
                            class="font-semibold text-gray-900 dark:text-white">1-20</span> of <span
                            class="font-semibold text-gray-900 dark:text-white">2290</span></span>
                </div>
            </div>
        </div>
    </div>

    </div>

    </div>
    </div>
    </div>
  </div>

    </div>
@endsection
