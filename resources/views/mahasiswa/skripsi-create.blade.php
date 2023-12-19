@extends('mahasiswa.layouts.layout2')

@section('content')
    <div class="mb-4 col-span-full xl:mb-2">
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="/dashboardMahasiswa"
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
                        <a href="/skripsi"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Skripsi</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Tambah
                            Skripsi</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Skripsi Mahasiswa</h1>
    </div>
    <!-- Right Content -->
    <div class="col-span-full xl:col-auto">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                <img src="{{ Auth::user()->getImageURL() }}" class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0"
                    alt="foto-profil">
                <div>
                    <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ $mahasiswa->nama }}</h3>
                    <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        <p>{{ $mahasiswa->nim }}</p>
                        <p>INFORMATIKA</p>
                        <p>{{ $mahasiswa->angkatan }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="flow-root">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="text-gray-900 truncate dark:text-white">
                                    <i class="fa-solid fa-building-columns fa-xl"></i>
                                </span>
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
                    <li class="pt-4 pb-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="text-gray-900 truncate dark:text-white">
                                    <i class="fa-solid fa-user-tie fa-xl"></i>
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-gray-900 truncate dark:text-white">
                                    Dosen Wali
                                </p>
                                <p class="text-sm font-normal text-gray-500 truncate dark:text-gray-400">
                                    {{ $mahasiswa->dosen_nama }}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-span-2">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">Tambah Skripsi</h3>
            <form action="{{ route('skripsi.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="semester_aktif"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester Aktif</label>
                        <select id="semester_aktif" name="semester_aktif"
                            class="bg-gray-50 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected disabled>Pilih semester</option>
                            @foreach ($availableSemesters as $semester)
                                <option value="{{ $semester }}">{{ $semester }}</option>
                            @endforeach
                        </select>
                        @error('semester_aktif')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="nilai"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                        <select id="nilai" name="nilai" required
                            class="bg-gray-50 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected disabled>Pilih nilai</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                        @error('nilai')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="lama_studi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama
                            studi</label>
                        <select id="lama_studi" name="lama_studi" required
                            class="bg-gray-50 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected disabled>Pilih lama studi</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                        @error('lama_studi')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="tanggal_sidang"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal sidang</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 ml-2 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input datepicker datepicker-format="yyyy-mm-dd" type="text" name="tanggal_sidang" id="tanggal_sidang"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 datepicker-input"
                                placeholder="Select date" value="{{ old('tanggal_sidang', date('Y-m-d')) }}">
                        </div>
                        @error('tanggal_sidang')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="statusSkripsi"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Skripsi</label>
                        <input type="hidden" name="statusSkripsi" value="Lulus">
                        <!-- Simpan nilai "Lulus" sebagai hidden input -->
                        <input type="text" id="statusSkripsi"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="24" value="Lulus" disabled>
                        @error('statusSkripsi')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="scanSkripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan
                            Skripsi</label>
                        <input type="file"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="scanSkripsi" name="scanSkripsi" accept=".pdf">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF (MAX. 5MB)</p>
                        @error('scanSkripsi')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">Some error message.</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-full">
                        <button
                            class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            type="submit">Save all</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
