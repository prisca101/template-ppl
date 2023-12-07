@extends('doswal.layouts.layout')

@section('content')
<div class="mb-4 col-span-full xl:mb-2">
    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Welcome, {{$dosens->nama}}!</h1>
</div>

<div class="col-span-full xl:col-auto">
    <div
        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
            <img src="{{ Auth::user()->getImageURL() }}" class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0" alt="foto-profil">
            <div>
                <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{$dosens->nama}}</h3>
                <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                    <p>{{$dosens->nip}}</p>
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
        <canvas id="grafik" style="width: 0px; height: 0px;"></canvas> <!-- Mengubah div menjadi canvas untuk grafik -->

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('grafik').getContext('2d');
                var mahasiswaCount = {{ $mahasiswaCount }};
                var mahasiswaPerwalianCount = {{ $mahasiswaPerwalianCount }};
                
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Total Mahasiswa', 'Mahasiswa Perwalian'],
                        datasets: [{
                            label: 'Count',
                            data: [mahasiswaCount, mahasiswaPerwalianCount],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)'
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
        <div class="flex items-center justify-between pt-4 lg:justify-evenly sm:pt-6">
            <div>
                <svg class="w-8 h-8 mb-1 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.25A2.25 2.25 0 014.25 2h11.5A2.25 2.25 0 0118 4.25v8.5A2.25 2.25 0 0115.75 15h-3.105a3.501 3.501 0 001.1 1.677A.75.75 0 0113.26 18H6.74a.75.75 0 01-.484-1.323A3.501 3.501 0 007.355 15H4.25A2.25 2.25 0 012 12.75v-8.5zm1.5 0a.75.75 0 01.75-.75h11.5a.75.75 0 01.75.75v7.5a.75.75 0 01-.75.75H4.25a.75.75 0 01-.75-.75v-7.5z">
                    </path>
                </svg>
                <h3 class="text-gray-500 dark:text-gray-400">Total Mahasiswa</h3>
                <h4 class="text-xl font-bold dark:text-white">
                    {{$mahasiswaCount}}
                </h4>
            </div>

            <div>
                <svg class="w-8 h-8 mb-1 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M8 16.25a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75z"></path>
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M4 4a3 3 0 013-3h6a3 3 0 013 3v12a3 3 0 01-3 3H7a3 3 0 01-3-3V4zm4-1.5v.75c0 .414.336.75.75.75h2.5a.75.75 0 00.75-.75V2.5h1A1.5 1.5 0 0114.5 4v12a1.5 1.5 0 01-1.5 1.5H7A1.5 1.5 0 015.5 16V4A1.5 1.5 0 017 2.5h1z">
                    </path>
                </svg>
                <h3 class="text-gray-500 dark:text-gray-400">Mahasiswa Perwalian</h3>
                <h4 class="text-xl font-bold dark:text-white">
                    {{$mahasiswaPerwalianCount}}
                </h4>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- @section('content2')
<div class="grid w-full grid-cols-1 gap-4 mt-4 xl:grid-cols-2 2xl:grid-cols-3">
  <!-- ... (your existing content) ... -->
  <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <div class="w-full">
      <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Total Mahasiswa</h3>
      <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{$mahasiswaCount}}</span>
    </div>

    <div class="w-full">
      <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Mahasiswa Perwalian</h3>
      <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{$mahasiswaPerwalianCount}}</span>
    </div>
  </div>

  <!-- Add this part for the pie chart -->
  <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
      <div class="w-full">
          <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Mahasiswa Distribution</h3>
          <canvas id="mahasiswaChart" width="400" height="400"></canvas>
      </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Get the data for the pie chart
      var mahasiswaData = {
          labels: ['Total Mahasiswa', 'Mahasiswa Perwalian'],
          datasets: [{
              data: [{{ $mahasiswaCount }}, {{ $mahasiswaPerwalianCount }}],
              backgroundColor: ['#3490dc', '#38c172'], // Add more colors if needed
          }],
      };

      // Create the pie chart
      var mahasiswaChart = new Chart(document.getElementById('mahasiswaChart'), {
          type: 'pie',
          data: mahasiswaData,
      });
  });
</script>
@endsection --}}