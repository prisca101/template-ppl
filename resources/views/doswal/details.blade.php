@extends('doswal.layouts.layout')

@section('content')
<div class="mb-4 col-span-full xl:mb-2">
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
            <li class="inline-flex items-center">
                <a href="/dashboardDoswal"
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
                    <a href="/perwalian"
                        class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Perwalian</a>
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
                    <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Details</span>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Mahasiswa Details</h1>
</div>


<div class="col-span-full xl:col-auto">
    <div
        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
            <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0"
                src="https://flowbite-admin-dashboard.vercel.app/images/users/bonnie-green-2x.png" alt="Jese picture">
            <div>
                <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Michael Jackson</h3>
                <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                    <p>24060121100037</p>
                    <p>2021</p>
                    <p>Semester 2</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content2')
<!--Tabs widget -->
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
      <li class="w-full">
          <button id="irs-tab" data-tabs-target="#irs" type="button" role="tab" aria-controls="irs" aria-selected="true" class="inline-block w-full p-4 rounded-tl-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">IRS</button>
      </li>
        <li class="w-full">
            <button id="khs-tab" data-tabs-target="#khs" type="button" role="tab" aria-controls="khs" aria-selected="false" class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">KHS</button>
        </li>
        <li class="w-full">
            <button id="pkl-tab" data-tabs-target="#pkl" type="button" role="tab" aria-controls="pkl" aria-selected="false" class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">PKL</button>
        </li>
        <li class="w-full">
            <button id="skripsi-tab" data-tabs-target="#skripsi" type="button" role="tab" aria-controls="skripsi" aria-selected="false" class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Skripsi</button>
        </li>
    </ul>

    <!--IRS -->
    <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
        <div class="hidden pt-4" id="irs" role="tabpanel" aria-labelledby="irs-tab">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="flex flex-col mt-6">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                              SKS Total
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                              Scan IRS
                                            </th>
                                          </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        <tr>
                                            <td class="text-center p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                              24
                                            </td>
                                            <td class="flex justify-center items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div class="flex items-center p-3 mb-3.5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                    <div class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
                                                      <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"></path>
                                                        <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"></path>
                                                      </svg>
                                                    </div>
                                                    <div class="mr-4">
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">irs_dipdip</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">PDF, 2.3 MB</p>
                                                    </div>
                                                    <div class="flex items-center ml-auto">
                                                      <button type="button" class="p-2 rounded hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                          <path clip-rule="evenodd" fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"></path>
                                                        </svg>
                                                        <span class="sr-only">Download</span>
                                                      </button>
                                                      <button type="button" class="p-2 rounded hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                          <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                        </svg>
                                                        <span class="sr-only">Actions</span>
                                                      </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                                
            </ul>
        </div>    
    </div>

    <!--KHS -->
    <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
        <div class="hidden pt-4" id="khs" role="tabpanel" aria-labelledby="khs-tab">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="flex flex-col mt-6">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                              IP Semester
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                              IP Kumulatif
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                SKS Total
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                SKS Kumulatif
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                                Scan KHS
                                            </th>
                                          </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        <tr>
                                            <td class="text-center p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                              4.0
                                            </td>
                                            <td class="text-center p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                4.0
                                            </td>
                                            <td class="text-center p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                23
                                            </td>
                                            <td class="text-center p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                50
                                            </td>
                                            <td class="flex justify-center items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div class="flex items-center p-3 mb-3.5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                    <div class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
                                                      <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"></path>
                                                        <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"></path>
                                                      </svg>
                                                    </div>
                                                    <div class="mr-4">
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">khs_dip</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">PDF, 2.3 MB</p>
                                                    </div>
                                                    <div class="flex items-center ml-auto">
                                                      <button type="button" class="p-2 rounded hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                          <path clip-rule="evenodd" fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"></path>
                                                        </svg>
                                                        <span class="sr-only">Download</span>
                                                      </button>
                                                      <button type="button" class="p-2 rounded hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                          <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                        </svg>
                                                        <span class="sr-only">Actions</span>
                                                      </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                                
            </ul>
        </div>    
    </div>

    <!--PKL -->
    <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
        <div class="hidden pt-4" id="pkl" role="tabpanel" aria-labelledby="pkl-tab">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="flex flex-col mt-6">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                              Nilai
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                              Status
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Scan PKL
                                            </th>
                                          </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        <tr>
                                            <td class="text-center p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                              100
                                            </td>
                                            <td class="text-center p-4 whitespace-nowrap">
                                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">Lulus</span>
                                            </td>
                                            <td class="flex justify-center items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div class="flex items-center p-3 mb-3.5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                    <div class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
                                                      <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"></path>
                                                        <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"></path>
                                                      </svg>
                                                    </div>
                                                    <div class="mr-4">
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">pkl_dip</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">PDF, 2.3 MB</p>
                                                    </div>
                                                    <div class="flex items-center ml-auto">
                                                      <button type="button" class="p-2 rounded hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                          <path clip-rule="evenodd" fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"></path>
                                                        </svg>
                                                        <span class="sr-only">Download</span>
                                                      </button>
                                                      <button type="button" class="p-2 rounded hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                          <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                        </svg>
                                                        <span class="sr-only">Actions</span>
                                                      </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                                
            </ul>
        </div>    
    </div>

    <!--Skripsi -->
    <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
        <div class="hidden pt-4" id="skripsi" role="tabpanel" aria-labelledby="skripsi-tab">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="flex flex-col mt-6">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                              Nilai
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                              Status
                                            </th>
                                            <th scope="col" class="text-center p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Scan Skripsi
                                            </th>
                                          </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        <tr>
                                            <td class="text-center p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                              100
                                            </td>
                                            <td class="text-center p-4 whitespace-nowrap">
                                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">Lulus</span>
                                            </td>
                                            <td class="flex justify-center items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div class="flex items-center p-3 mb-3.5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                    <div class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
                                                      <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"></path>
                                                        <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"></path>
                                                      </svg>
                                                    </div>
                                                    <div class="mr-4">
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">skripsi_dip</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">PDF, 2.3 MB</p>
                                                    </div>
                                                    <div class="flex items-center ml-auto">
                                                      <button type="button" class="p-2 rounded hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                          <path clip-rule="evenodd" fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"></path>
                                                        </svg>
                                                        <span class="sr-only">Download</span>
                                                      </button>
                                                      <button type="button" class="p-2 rounded hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                          <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                        </svg>
                                                        <span class="sr-only">Actions</span>
                                                      </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                                
            </ul>
        </div>    
    </div>
</div>
@endsection

