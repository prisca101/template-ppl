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
    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white text-center">Progress Perkembangan Studi Mahasiswa Informatika</h1>
    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white text-center">Fakultas Sains dan Matematika</h1>
</div>

@foreach ($mahasiswa as $mhs)
<div class="col-span-full xl:col-auto">
    <div
        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
            <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0" src="{{ $mhs->getImageURL() }}" alt="{{ $mhs->nama }}">
            <div>
                <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{$mhs->nama}}</h3>
                <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                    <p>{{$mhs->nim}}</p>
                    <p>{{$mhs->angkatan}}</p>
                    <p>{{$mhs->dosen_nama}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('content2')
    <div class="form-group">
        <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
    </div>
    <div class="inline-block">
        @for ($i = 1; $i <= 14; $i++)
            @php
                $irs = $irsData[$i] ?? null;
                $khs = $khsData[$i] ?? null;
                $pkl = $pklData[$i] ?? null;
                $skripsi = $skripsiData[$i] ?? null;
                $lastVerifiedPKL;

                $cardClass = 'bg-red-400'; // Default color is red

                if ($irs && !$khs && !$pkl && !$skripsi) {
                    if ($irs->status == 'verified') {
                        $cardClass = 'bg-blue-300'; // Light blue if only IRS is 'verified'
                    }
                } elseif ($irs && $khs && !$pkl && !$skripsi) {
                    if ($irs->status == 'verified' && $khs->status == 'verified') {
                        $cardClass = 'bg-blue-800'; // Dark blue if IRS and KHS are 'verified'
                    }
                } elseif ($irs && $khs && $pkl && !$skripsi ) {
                    if ($irs->status == 'verified' && $khs->status == 'verified' && $pkl->status == 'verified') {
                        $cardClass = 'bg-yellow-400'; // Yellow if IRS, KHS, and PKL are 'verified'
                    }
                } elseif ($irs && $khs && !$pkl && $skripsi && $lastVerifiedPKL && $lastVerifiedPKL->semester_aktif != $irs->semester_aktif) {
                    if ($irs->status == 'verified' && $khs->status == 'verified' && $skripsi->status == 'verified' && $lastVerifiedPKL) {
                        $cardClass = 'bg-green-400'; // Green if all statuses are 'verified'
                    }
                }

            @endphp

            <!-- Tampilkan tombol dengan warna sesuai status -->
            <a data-modal-target="modal-{{ $i }}" data-modal-toggle="modal-{{ $i }}" class="text-white {{ $cardClass }} box-border h-10 w-30 card p-2 overflow-hidden">{{ $i }}</a>

            <!-- Modal for each status -->
            <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full "
                id="modal-{{ $i }}">
                <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                            <h3 class="text-xl font-semibold dark:text-white">
                                Semester - {{$i}}
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                                data-modal-toggle="modal-{{ $i }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Modal body -->
                        @if ($cardClass == 'bg-blue-300' && $irs)
                          <div class="my-4 border-b border-gray-200 dark:border-gray-700">
                              <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                                  <li class="me-2" >
                                      <button id="irs-tab-{{ $i }}" data-tabs-target="#irs-{{ $i }}" type="button" role="tab" aria-controls="irs" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">IRS</button>
                                  </li>
                              </ul>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="irs-{{$i}}" role="tabpanel" aria-labelledby="irs-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $irs->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $irs->jumlah_sks }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan IRS</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $irs->scanIRS) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat IRS</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                        @endif
                        @if ($cardClass == 'bg-blue-800' && $irs && $khs)
                          <div class="my-4 border-b border-gray-200 dark:border-gray-700">
                              <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                                  <li class="me-2" >
                                      <button id="irs-tab-{{ $i }}" data-tabs-target="#irs-{{ $i }}" type="button" role="tab" aria-controls="irs" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">IRS</button>
                                  </li>
                                  <li class="me-2" >
                                      <button id="khs-tab-{{ $i }}" data-tabs-target="#khs-{{ $i }}" type="button" role="tab" aria-controls="khs" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">KHS</button>
                                  </li>
                              </ul>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="irs-{{$i}}" role="tabpanel" aria-labelledby="irs-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $irs->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $irs->jumlah_sks }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan IRS</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $irs->scanIRS) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat IRS</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="khs-{{$i}}" role="tabpanel" aria-labelledby="khs-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->jumlah_sks }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS Kumulatif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->jumlah_sks_kumulatif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">IP Semester</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->ip_semester }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->ip_kumulatif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan KHS</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $khs->scanKHS) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat KHS</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                        @endif
                        @if ($cardClass == 'bg-yellow-400' && $irs && $khs && $pkl)
                          <div class="my-4 border-b border-gray-200 dark:border-gray-700">
                              <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                                  <li class="me-2" >
                                      <button id="irs-tab-{{ $i }}" data-tabs-target="#irs-{{ $i }}" type="button" role="tab" aria-controls="irs" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">IRS</button>
                                  </li>
                                  <li class="me-2" >
                                      <button id="khs-tab-{{ $i }}" data-tabs-target="#khs-{{ $i }}" type="button" role="tab" aria-controls="khs" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">KHS</button>
                                  </li>
                                  <li class="me-2" >
                                      <button id="pkl-tab-{{ $i }}" data-tabs-target="#pkl-{{ $i }}" type="button" role="tab" aria-controls="pkl" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">PKL</button>
                                  </li>
                              </ul>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="irs-{{$i}}" role="tabpanel" aria-labelledby="irs-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-white">{{ $irs->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $irs->jumlah_sks }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan IRS</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $irs->scanIRS) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat IRS</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="khs-{{$i}}" role="tabpanel" aria-labelledby="khs-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->jumlah_sks }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS Kumulatif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->jumlah_sks_kumulatif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">IP Semester</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->ip_semester }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->ip_kumulatif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan KHS</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $khs->scanKHS) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat KHS</a>
                                        </td>
                                    </tr>
                                </tbody>
  
                              </table>
                            </div>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="pkl-{{$i}}" role="tabpanel" aria-labelledby="pkl-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $pkl->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Nilai</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $pkl->nilai }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan PKL</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $pkl->scanPKL) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat PKL</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                        @endif
                        @if ($cardClass == 'bg-green-400' && $irs && $khs && $skripsi && $lastVerifiedPKL && $lastVerifiedPKL->semester_aktif != $irs->semester_aktif)
                          <div class="my-4 border-b border-gray-200 dark:border-gray-700">
                              <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                                  <li class="me-2" >
                                      <button id="irs-tab-{{ $i }}" data-tabs-target="#irs-{{ $i }}" type="button" role="tab" aria-controls="irs" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">IRS</button>
                                  </li>
                                  <li class="me-2" >
                                      <button id="khs-tab-{{ $i }}" data-tabs-target="#khs-{{ $i }}" type="button" role="tab" aria-controls="khs" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">KHS</button>
                                  </li>
                                  <li class="me-2" >
                                      <button id="pkl-tab-{{ $i }}" data-tabs-target="#pkl-{{ $i }}" type="button" role="tab" aria-controls="pkl" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">PKL</button>
                                  </li>
                                  <li class="me-2" >
                                      <button id="skripsi-tab-{{ $i }}" data-tabs-target="#skripsi-{{ $i }}" type="button" role="tab" aria-controls="skripsi" aria-selected="true" class="inline-block py-2 px-5 border-b-2 rounded-t-lg">Skripsi</button>
                                  </li>
                              </ul>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="irs-{{$i}}" role="tabpanel" aria-labelledby="irs-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $irs->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $irs->jumlah_sks }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan IRS</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $irs->scanIRS) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat IRS</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="khs-{{$i}}" role="tabpanel" aria-labelledby="khs-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->jumlah_sks }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS Kumulatif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->jumlah_sks_kumulatif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">IP Semester</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->ip_semester }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Jumlah SKS</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $khs->ip_kumulatif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan KHS</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $khs->scanKHS) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat KHS</a>
                                        </td>
                                    </tr>
                                </tbody>
  
                              </table>
                            </div>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="pkl-{{$i}}" role="tabpanel" aria-labelledby="pkl-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $lastVerifiedPKL->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Nilai</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $lastVerifiedPKL->nilai }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan PKL</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $lastVerifiedPKL->scanPKL) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat PKL</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                          <div id="fullWidthTabContent" >
                            <div class="hidden pt-2 pb-5 mb-5 ml-5 mr-5" id="skripsi-{{$i}}" role="tabpanel" aria-labelledby="skripsi-tab">
                              <table class="table-auto border-collapse w-full ">
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Semester Aktif</td>
                                        <td class="border px-2 py-2 text-white">{{ $skripsi->semester_aktif }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Nilai</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $skripsi->nilai }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Lama Studi</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $skripsi->lama_studi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Tanggal Sidang</td>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">{{ $skripsi->tanggal_sidang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-2 text-gray-900 dark:text-white">Scan Skripsi</td>
                                        <td class="border px-2 py-2 ">
                                          <a href="{{ asset('storage/' . $skripsi->scanSkripsi) }}" target="_blank" class="text-sm font-semibold text-blue-500 ">Lihat Skripsi</a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                        @endif

                    </div>
                </div>
            </div>

        @endfor
    </div>
@endsection