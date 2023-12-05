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
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content2')
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Daftar Mahasiswa PKL</h3>
        </div>
    </div>
    <!-- Table -->
    <div class="flex flex-col mt-6">
        <div class="overflow-x-auto rounded-lg">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow sm:rounded-lg">
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
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            <tr>
                                <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                    <span class="font-semibold">1</span>
                                </td>
                                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                    Ariana Grande
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                    24060121120013
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                    2021
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">Lulus</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                    <span class="font-semibold">2</span>
                                </td>
                                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                    Taylor Swift
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                    24060121130010
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                    2020
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">Lulus</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                    <span class="font-semibold">3</span>
                                </td>
                                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                    Niki Zefanya
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                    24060121140151
                                </td>
                                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                    2019
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-red-100 dark:border-red-400 dark:bg-gray-700 dark:text-red-400">Tidak Lulus</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Footer -->
    {{-- <div class="flex items-center justify-end pt-3 sm:pt-6">
        <div class="flex-shrink-0">
            <a href="/tambahKhs" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700">
                Tambah KHS
                <svg class="w-4 h-4 ml-1 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div> --}}
</div>
@endsection
