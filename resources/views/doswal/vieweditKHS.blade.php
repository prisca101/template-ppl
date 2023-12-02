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
                <li class="flex items-center">
                    <a href="/showAllVerifikasi"
                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Verifikasi
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
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Edit KHS</h1>
    </div>
    <!-- Right Content -->
    <div class="col-span-full xl:col-auto">
            <form action="{{ route('editKHS', ['idkhs' => $khs->idkhs]) }}}" method="post">
                @csrf
        </div>
        <div class="col-span-4">
                <div
                    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="mb-4 text-xl font-semibold dark:text-white">General information</h3>
                    
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="nama"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                <input type="text" name="nama" id="nama"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    value="{{ $khs->nama }}" wfd-id="id1" readonly disabled>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="nim"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                                <input type="text" name="nim" id="nim"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    value="{{ $khs->nim }}" wfd-id="id2" readonly disabled>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="angkatan"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Angkatan</label>
                                <input type="text" name="angkatan" id="angkatan"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    value="{{ $khs->angkatan }}" wfd-id="id2" readonly disabled>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="semester_aktif"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester Aktif</label>
                                <select id="semester_aktif" name="semester_aktif"
                                    class="bg-gray-50 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option disabled>Pilih semester</option>
                                    @for ($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ $i == $khs->semester_aktif ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('semester_aktif')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="jumlah_sks"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS</label>
                                <input type="text" name="jumlah_sks" id="jumlah_sks"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    value="{{ $khs->jumlah_sks }}" wfd-id="id6"  max = "24" min="18">
                                @error('jumlah_sks')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="jumlah_sks_kumulatif"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS Kumulatif</label>
                                <input type="text" name="jumlah_sks_kumulatif" id="jumlah_sks_kumulatif"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    value="{{ $khs->jumlah_sks_kumulatif }}" wfd-id="id6"  min="18">
                                @error('jumlah_sks_kumulatif')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="ip_semester"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Semester</label>
                                <input type="text" name="ip_semester" id="ip_semester"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    value="{{ $khs->ip_semester }}" wfd-id="id6"  max="4">
                                @error('ip_semester')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="ip_kumulatif"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Kumulatif</label>
                                <input type="text" name="ip_kumulatif" id="ip_kumulatif"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    value="{{ $khs->ip_kumulatif }}" wfd-id="id6"  max="4">
                                @error('ip_semester')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-full">
                                <button
                                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                    type="submit">Save all</button>
                            </div>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection