

<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Warehouse') }}
    </h2>
</x-slot>

<!-- WAREHOUSE OCCUPANCY -->
<div class="box-body">
    <div class="table-responsive">
        <div class="card rounded-2xl">
            <table id="dataTable" class="table mb-0 w-full">
                <thead class="box-header" style="display:table-header-group;">
                    <tr>
                        <th colspan="4" class="text-center px-6 py-3 text-xl font-medium uppercase tracking-wider">Warehouse Occupancy</th>
                    </tr>
                    <tr>
                        <th style="width:15%;">
                            <!-- Button Pilih Tanggal -->
                            <div class="flex justify-center items-center">
                                <ul class="m-0" style="list-style: none;">
                                    <li class="dropdown">
                                        <button id="dateDisplay" class="waves-effect waves-light btn btn-outline dropdown-toggle btn-md"
                                            data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                            {{ date('d F Y') }} <!-- Menampilkan tanggal hari ini -->
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" style="will-change: transform;">
                                            <div class="px-3 py-2">
                                                <input type="date" id="dateFilterDropdown" class="bg-gray-200 text-black"
                                                    value="{{ date('Y-m-d') }}">
                                                <button id="applyDateFilterDropdown"
                                                    class="bg-blue-500 text-white px-2 py-1 mt-2">Terapkan</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </th>
                        @foreach ($warehouses as $warehouse)
                        <th>
                            <div>
                                <p class="px-6 text-center text-md font-medium uppercase tracking-wider">Total Pallet: {{ $warehouse->pallet }}</p>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="box-body">
                    <tr>
                        <th>
                            <p class="text-center m-0 p-0 text-md font-medium uppercase">Occupancy</p> 
                        </th>
                        @foreach ($warehouses as $warehouse)
                        <td>
                            <div style="display:flex; justify-content:center; ">
                                <div class="" style="display:flex; flex-direction: column; width:180px; height:300px; position:relative; display:flex;  justify-content:center; align-items:center; background-image: url(''); background-repeat: no-repeat;  z-index:2;">
                                    <!-- Sesuai dengan nama img di folder-->
                                    <img src="{{asset('assets/images/warehouse/' . $warehouse->temperature . '.png')}}" style="position:absolute; width: 100%; height:100%;" alt=""> 
                                    <h2 class="fw-700 text-3xl" style="position:absolute;">{{ $warehouse->percentage }}%</h2> 
                                    <div style="margin-top:auto; width:100%; height:70%; display:flex; flex-direction: column; border: 2px solid black; border-radius:10px;">
                                        <div style="margin-top:auto; background-color:#22B14C; width:100%; height:{{ $warehouse->percentage }}%;"></div>
                                    </div>
                                </div>
                                @if ($warehouse->temperature == 'Ambient')
                                <div class="m-4" style="display:flex; flex-direction: column; justify-content: space-between;">
                                    <div class="flex">ATAS</div>
                                    <div class="flex">TENGAH</div>
                                    <div class="flex">BAWAH</div>
                                </div>
                                @elseif ($warehouse->temperature == '25 Degree')
                                <div class="m-4" style="display:flex; flex-direction: column; justify-content: space-around;">
                                    <div class="flex">G3</div>
                                    <div class="flex">G2</div>
                                </div>
                                @elseif ($warehouse->temperature == '16 Degree')
                                <div class="m-4" style="display:flex; flex-direction: column; justify-content: space-between;">
                                    <div class="flex">G2</div>
                                </div>
                                @endif
                            </div>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>

<!-- DISPATCH -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 mb-4">
    <!-- Area Chart -->
    <div class="col-span-2" stlye="margin-top:10px;">
        <div class="box">
            <div class="box-body analytics-info">
                <div class="flex py-2" style="width:100%; justify-content:space-between;">
                    <div class="text-xl font-medium">DISPATCH</div>
                    <div>
                        <!-- Daftar Tahun -->
                        <select id="yearFilterArea" class="mr-2 bg-gray-500 text-1xl rounded text-black">
                            <option value="" class="">Select Year</option>
                            @php
                                $currentYear = date('Y'); // Mengambil tahun saat ini
                            @endphp
                            @for ($i = $currentYear; $i >= $currentYear - 10; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <!-- Daftar bulan -->
                        <select id="monthFilterArea" class="mr-2 bg-gray-500 text-1xl rounded text-black">
                            <option value="" class="">Select Month</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" >{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
            </div>
        </div>
    </div>
    <!-- Table Dispatch-->
    <div class="col-span-1">
        <div class="card rounded-2xl">
            <div class="box-header flex justify-between items-center">
                <h4 class="box-title text-2xl">Total Dispatch</h4>
                <ul class="m-0" style="list-style: none;">
                    <li class="dropdown">
                        <button id="dateDisplay2" class="waves-effect waves-light btn btn-outline dropdown-toggle btn-md text-xl"
                            data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            {{ date('d F Y') }} <!-- Menampilkan tanggal hari ini -->
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="will-change: transform;">
                            <div class="px-3 py-2">
                                <input type="date" id="dateFilterDropdown2" class="bg-gray-200 text-black"
                                    value="{{ date('Y-m-d') }}">
                                <button id="applyDateFilterDropdown2"
                                    class="bg-blue-500 text-white px-2 py-1 mt-2">Terapkan</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card-body pt-0"></div>
                <div class="table-responsive">
                    <table id="dispatchTable" class="table mb-0 w-full">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center text-xl">Total Dispatch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="display:flex; justify-content:center;">
                                    <div class="text-xl" style="width:30%;">
                                        Harian
                                    </div>
                                </th>
                                <td class="text-center text-xl">100.00 ton</td>
                            </tr>
                            <tr>
                                <th style="display:flex; justify-content:center;">
                                    <div class="text-xl" style="width:30%;">
                                        Bulanan
                                    </div>
                                </th>
                                <td class="text-center text-xl">100.00 ton</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

<script>

var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
        label: "Dispatch (In Tonnage)",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: [],
        }],
    },
    options: {
        scales: {
            xAxes: [{
                time: {
                unit: 'date'
                },
                gridLines: {
                    display: false
                }
            }],
            yAxes: [{
                ticks: {
                min: 0,
                max: 100,
                maxTicksLimit: 5
                },
                gridLines: {
                color: "rgba(0, 0, 0, .125)",
                }
            }]
        },
        legend: {
            display: false
        }
    }
});
     // Area Chart
    function setAreaChartOption(label, ton) {
        // Mengubah data
        myLineChart.data.labels = label;
        myLineChart.data.datasets[0].data = ton;
        myLineChart.options = {
            scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        // maxTicksLimit: 1,
                        fontSize: 14
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: Math.round(Math.max(...ton) * 1.1),
                        maxTicksLimit: 5,
                        fontSize: 14
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }]
            },
            legend: {
                display: false
            },
            tooltips: {
                titleFontSize: 22,
                bodyFontSize: 20,
                displayColors: false
                // backgroundColor: '#FFF',
                // titleFontColor: '#0066ff',
                // bodyFontColor: '#000',
            }
                
        };

        // Memperbarui grafik
        myLineChart.update();
       
    }
    
    // Update Bar Chart berdasarkan bulan dan minggu yang dipilih
    document.getElementById('monthFilterArea').addEventListener('change', updateAreaChart);
    document.getElementById('yearFilterArea').addEventListener('change', updateAreaChart);

    document.addEventListener('DOMContentLoaded', function() {
        updateAreaChart();
        updateTotalDispatch();
    });

    function updateAreaChart() {
        const month = document.getElementById('monthFilterArea').value;
        const year = document.getElementById('yearFilterArea').value;
        // Fetch dan update data bar chart berdasarkan bulan dan minggu yang dipilih
        fetch(`/area-data?month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                console.log('Area Chart Data:', data); // Log data respons

                // Memastikan data yang diterima tidak undefined
                if (data && data.labels && data.tons) {
                    // && data.labels && data.tons
                    setAreaChartOption(data.labels, data.tons.map(value => parseInt(value.replace(/\./g, ''), 10))); // Mengatur opsi chart
                } else {
                    console.error('Data tidak valid:', data);
                }
            })
            .catch(error => console.error('Error fetching area chart data:', error));
    }    

    // Event listener untuk tombol filter tanggal di dropdown bar chart
    document.getElementById('applyDateFilterDropdown').addEventListener('click', function() {
        const selectedDate = document.getElementById('dateFilterDropdown').value;
        // Mengubah teks tombol untuk menampilkan tanggal yang dipilih
        const formattedDate = new Date(selectedDate).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('dateDisplay').innerText = formattedDate;
        
        // Fetch dan update data berdasarkan tanggal yang dipilih
        fetch(`/warehouse-data-filter?date=${selectedDate}`)
        .then(response => response.json())
            .then(data => {
                console.log('Data Filtered:', data);
                // Pastikan data memiliki struktur yang benar
                if (data && data.data && Array.isArray(data.data)) {
                    // Kosongkan tabel sebelum menambahkan data baru
                    const tbody = document.querySelector('#dataTable tbody');
                    tbody.innerHTML = ''; // Menghapus isi tabel

                    
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                    <th>
                            <p class="text-center m-0 p-0 text-md font-medium uppercase">Occupancy</p> 
                        </th>
                        `;
                    
                    // Masukan data ke hashmap
                    const datas = data.data;
                    // Sesuai urutan dari terbesar ke terkecil
                    let hashMap = {
                        "Ambient": null,
                        "25 Degree": null,
                        "16 Degree": null
                    };
                    datas.forEach(item => {
                        hashMap[item.temperature]=item;
                    });
                    function appendRow(name,percentage) {
                            row.innerHTML +=`
                            <td>
                                <div style="display:flex; justify-content:center; ">
                                    <div style="display:flex; flex-direction: column; width:180px; height:300px; position:relative; display:flex;  justify-content:center; align-items:center; background-image: url(''); background-repeat: no-repeat;  z-index:2;">
                                            <img src="{{asset('assets/images/warehouse/${name}.png')}}" style="position:absolute; width: 100%; height:100%;" alt="">
                                        <h2 class="fw-700 text-3xl" style="position:absolute;">${percentage}%</h2>
                                        <div style="margin-top:auto; width:100%; height:70%; display:flex; flex-direction: column; border: 2px solid black; border-radius:10px;">
                                            <div style="margin-top:auto; background-color:#22B14C; width:100%; height:${percentage}%;"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(row);
                    }
                    // Memasukan data ke tabel, jika tidak ada data dari hashmap, akan diisi 0
                    for (let key in hashMap){
                        console.log(key);
                        if(hashMap[key]){
                            appendRow(key,hashMap[key].percentage);
                        }else{
                            appendRow(key,0)
                        }
                    }
                }else {
                    console.error('Data tidak valid:', data);
                }
        })
        .catch(error => console.error('Error fetching filtered data:', error));
    });
    
    function updateTotalDispatch(){
        const selectedDate = document.getElementById('dateFilterDropdown2').value;
        // Mengubah teks tombol untuk menampilkan tanggal yang dipilih
        const formattedDate = new Date(selectedDate).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        const fomattedMonth = new Date(selectedDate).toLocaleDateString('id-ID', {
            month: 'numeric'
        });
        document.getElementById('dateDisplay2').innerText = formattedDate;
        // Fetch dan update data berdasarkan tanggal yang dipilih
        fetch(`/warehouse-dispatch-filter?date=${selectedDate}&month=${fomattedMonth}`)
            .then(response => response.json())
                .then(data => {
                    console.log('Data Filtered:', data);


                if (data && data.daily[0] && data.monthly[0]) { //Memastikan ada data di daily dan month
                    // Kosongkan tabel sebelum menambahkan data baru
                    const tbody = document.querySelector('#dispatchTable tbody');
                    tbody.innerHTML = ''; // Menghapus isi tabel
                    
                    tbody.innerHTML +=`
                        <tr>
                            <th style="display:flex; justify-content:center;">
                                <div class="text-xl" style="width:30%;">
                                    Harian
                                </div>
                            </th>
                            <td class="text-center text-xl">${data.daily[0]['tons']} ton</td>
                        </tr>
                        <tr>
                            <th style="display:flex; justify-content:center;">
                                <div class="text-xl" style="width:30%;">
                                    Bulanan
                                </div>
                            </th>
                            <td class="text-center text-xl">${data.monthly[0]['tons']} ton</td>
                        </tr>
                    `;
                    
                    
                }else {
                    console.error('Data tidak valid:', data);
                    const tbody = document.querySelector('#dispatchTable tbody');
                    tbody.innerHTML = ''; // Menghapus isi tabel
                    
                    tbody.innerHTML +=`
                        <tr>
                            <th style="display:flex; justify-content:center;">
                                <div class="text-xl" style="width:30%;">
                                    Harian
                                </div>
                            </th>
                            <td class="text-center text-xl">0 ton</td>
                        </tr>
                        <tr>
                            <th style="display:flex; justify-content:center;">
                                <div class="text-xl" style="width:30%;">
                                    Bulanan
                                </div>
                            </th>
                            <td class="text-center text-xl">0 ton</td>
                            
                        </tr>
                    `;
                }

        })
        .catch(error => console.error('Error fetching filtered data:', error));
    }

    // Event listener untuk tombol filter tanggal di dropdown area chart
    document.getElementById('applyDateFilterDropdown2').addEventListener('click', function() {
        updateTotalDispatch();
    });

</script>
@endpush

</x-app-layout>


