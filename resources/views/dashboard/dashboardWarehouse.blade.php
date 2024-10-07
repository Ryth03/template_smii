

<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Warehouse') }}
    </h2>
</x-slot>

<!-- WAREHOUSE OCCUPANCY -->
<div class="grid grid-cols-6" style="column-gap: 0.75rem /* 12px */;"> 
    <div style="grid-column-start: 1; ">
        <div class="card border-2 border-warning rounded-2xl ">
            <div class="box-header flex justify-center items-center">
                <h3 class="text-3xl font-medium">Inward Warehouse</h3>
            </div>
            <div class="py-6">
                <div class="px-6">
                    <div class="box-header flex flex-col justify-start items-center">
                        <h3 class="box-title m-0 text-3xl">G1 | <span class="text-orange-500">Ambient</span></h3>
                        <h3 class="box-title m-0 text-2xl">4,132 PP</h3>
                    </div>
                </div>
                <div class="mb-8" id="G1Ambient" style="height:350px;"></div>
            </div>
        </div>
    </div>
    <div style="grid-column: span 5/span 5;">
        <div class="card border-2 border-success rounded-2xl ">
            <div class="box-header flex justify-center items-center relative">
                <h3 class="text-3xl font-medium">Finished Goods / Outward Warehouse</h3>
                <div class="absolute right-0">
                    <!-- Button Pilih Tanggal -->
                    <div class="flex justify-center items-center mr-5">
                        <ul class="m-0" style="list-style: none;">
                            <li class="dropdown">
                                <button id="dateDisplay" class="waves-effect waves-light btn btn-outline dropdown-toggle btn-md"
                                    data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <span class="text-3xl">{{ date('d F Y') }} <!-- Menampilkan tanggal hari ini --></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="will-change: transform;">
                                    <div class="px-3 py-2">
                                        <input type="date" id="dateFilterDropdown" class="bg-gray-200 text-black text-2xl" 
                                            value="{{ date('Y-m-d') }}">
                                        <button id="applyDateFilterDropdown"
                                            class="bg-blue-500 text-white px-2 py-1 mt-2 text-xl">Terapkan</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="box-body grid grid-cols-5" style="column-gap: 0.75rem /* 12px */;">
                <div class="">
                    <div class="box-header flex flex-col justify-start items-center">
                        <h3 class="box-title m-0 text-3xl">G2 | <span class="text-blue-500">16°C</span></h3>
                        <h3 class="box-title m-0 text-2xl">1,000 PP</h3>
                    </div>
                    <div id="G216Degree" style="height:350px;" class=""></div>
                    <div class="flex justify-center items-center">
                        <p class="text-2xl">Tonnage : 1.000 Ton</p>
                    </div>
                </div>
                <div class="">
                    <div class="box-header flex flex-col justify-start items-center">
                        <h3 class="box-title m-0 text-3xl">G2 | <span class="text-green-500">25°C</span></h3>
                        <h3 class="box-title m-0 text-2xl">1,000 PP</h3>
                    </div>
                    <div id="G225Degree" style="height:350px;" class=""></div>
                    <div class="flex justify-center items-center">
                        <p class="text-2xl">Tonnage : 1.000 Ton</p>
                    </div>
                </div>
                <div class="">
                    <div class="box-header flex flex-col justify-start items-center">
                        <h3 class="box-title m-0 text-3xl">G3 | <span class="text-green-500">25°C</span></h3>
                        <h3 class="box-title m-0 text-2xl">1,000 PP</h3>
                    </div>
                    <div id="G325Degree" style="height:350px;" class=""></div>
                    <div class="flex justify-center items-center">
                        <p class="text-2xl">Tonnage : 1.000 Ton</p>
                    </div>
                </div>
                <div class="">
                    <div class="box-header flex flex-col justify-start items-center">
                        <h3 class="box-title m-0 text-3xl">G3 | <span style="color: #FB923C;">Ambient</span></h3>
                        <h3 class="box-title m-0 text-2xl">7,864 PP</h3>
                    </div>
                    <div id="G3Ambient" style="height:350px;" class=""></div>
                    <div class="flex justify-center items-center">
                        <p class="text-2xl">Tonnage : 1.000 Ton</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 items-start">
                        @php
                            $atas = rand(15, 42);
                            $tengah = rand(15, 42);
                            $bawah = rand(15, 42);
                        @endphp
                    <div class="flex justify-center self-center text-3xl col-span-2 " style="">Act. Temp.</div>
                    <div class="flex justify-center text-3xl">Atas</div>
                    <div class="flex"><p class="px-1 text-4xl {{ $atas >= 38 ? 'text-white' : ($atas >= 32 ? 'text-black' : '') }}" style="background-color:  {{ $atas >=38 ? '#FF5E5C' : ($atas >= 32 ? '#EFA70B' : '') }}; ">{{$atas}}°C</p></div>
                    <div class="flex justify-center text-3xl">Tengah</div>
                    <div class="flex"><p class="px-1 text-4xl {{ $tengah >= 38 ? 'text-white' : ($tengah >= 32 ? 'text-black' : '') }}" style="background-color:  {{ $tengah >=38 ? '#FF5E5C' : ($tengah >= 32 ? '#FFB95C' : '') }}; ">{{$tengah}}°C</p></div>
                    <div class="flex justify-center text-3xl">Bawah</div>
                    <div class="flex"><p class="px-1 text-4xl {{ $bawah >= 38 ? 'text-white' : ($bawah >= 32 ? 'text-black' : '') }}" style="background-color:  {{ $bawah >=38 ? '#FF5E5C' : ($bawah >= 32 ? '#FFB95C' : '') }}; ">{{$bawah}}°C</p></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- DISPATCH -->
<div class="grid grid-cols-4 gap-x-4 mb-4">
    <!-- Area Chart -->
    <div class="col-span-3" stlye="margin-top:10px;">
        <div class="box rounded-2xl">
            <div class="box-body analytics-info">
                <div class="flex py-2" style="width:100%; justify-content:space-between;">
                    <div class="text-3xl font-medium">DISPATCH</div>
                    <div>
                        <!-- Daftar Tahun -->
                        <select id="yearFilterArea" class="mr-2 bg-gray-500 text-xl rounded text-black">
                            @php
                                $currentYear = date('Y'); // Mengambil tahun saat ini
                            @endphp
                            <option value="" class="" disabled selected hidden>{{$currentYear}}</option>
                            
                            @for ($i = $currentYear; $i >= $currentYear - 10; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <!-- Daftar bulan -->
                        <select id="monthFilterArea" class="mr-2 bg-gray-500 text-xl rounded text-black">
                            <option value="" class="" disabled selected hidden>{{ date('F') }}</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" >{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="flex" >
                    <canvas id="myAreaChartMonthly" width="100%" height="48" style="max-width:48%; height:800px;"></canvas>
                    <canvas id="myAreaChart" width="100%" height="48" style="max-width:48%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Table Dispatch-->
    <div class="col-span-1">
        <div class="card rounded-2xl">
            <div class="box-header flex justify-between items-center">
                <div class="flex flex-row flex-wrap">
                    <h4 class="box-title text-3xl font-medium">Daily Dispatch</h4>
                    <h4 class="box-title text-3xl font-medium">(in Tonnage)</h4>
                </div>
                <ul class="m-0" style="list-style: none;">
                    <li class="dropdown">
                        <button id="dateDisplay2" class="waves-effect waves-light btn btn-outline dropdown-toggle btn-md text-3xl"
                            data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            {{ date('d F Y') }}<!-- Menampilkan tanggal hari ini -->
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="will-change: transform;">
                            <div class="px-3 py-2">
                                <input type="date" id="dateFilterDropdown2" class="bg-gray-200 text-black text-2xl"
                                    value="{{ date('Y-m-d') }}">
                                <button id="applyDateFilterDropdown2"
                                    class="bg-blue-500 text-white px-2 py-1 mt-2 text-xl">Terapkan</button>
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
                                    <div class="text-3xl" style="width:30%;">
                                        Harian
                                    </div>
                                </th>
                                <td class="text-center text-4xl">100.00 ton</td>
                            </tr>
                            <tr>
                                <th style="display:flex; justify-content:center;">
                                    <div class="text-3xl" style="width:30%;">
                                        Bulanan
                                    </div>
                                </th>
                                <td class="text-center text-4xl">100.00 ton</td>
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
<script src="https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
<script>

// Mengambil dark mode
const darkModeStorage = localStorage.getItem('darkMode');

const myCharts = {}; // Init for gauge charts
var myLineChart; // Init for daily line chart
var myLineChartMonthly; // Init for monthly line chart

document.addEventListener('DOMContentLoaded', function() {
    createGaugeChart();
    createDailyChart();
    createMonthlyChart();
    updateLineChart();
    updateTotalDispatch();
});

// Create Gauge Charts
function createGaugeChart(){
    const temps = ['G1Ambient', 'G216Degree', 'G225Degree', 'G325Degree', 'G3Ambient'];
    temps.forEach(temp => {
        let normalText;

        // jika darkmode, init dark
        const gauge = document.getElementById(`${temp}`);
        if (darkModeStorage === 'enabled') {
            myCharts[temp] = echarts.init(gauge, 'dark');
            normalText = 'white';
        }else{
            myCharts[temp] = echarts.init(gauge);
            normalText = 'black';
        }

        var number = (Math.random() * 100).toFixed(2);
        let bgColor = 
        number >= 90 ? '#FF5E5C' :
        number >= 70 ? '#FFB95C' :
        number <= 10 ? '#FF5E5C' :
        number <= 20 ? '#FFB95C' :
        ''; // default
        
        let txtColor = 
        number >= 90 ? 'white' :
        number >= 70 ? 'black' :
        number <= 10 ? 'white' :
        number <= 20 ? 'black' :
        normalText ; // default

        let tempColor = 
        temp === "G1Ambient" ? '#F97316' :
        temp === "G216Degree" ? '#3B82F6':
        temp === "G225Degree" ? '#22C55E':
        temp === "G325Degree" ? '#22C55E':
        temp === "G3Ambient" ? '#FB923C':
        'orange'; // default

        let data2 = {
                value:  Math.floor(Math.random() * (30 - 15 + 1)) + 15,
                name: 'Act. Temp.',
                itemStyle: {
                    color: 'transparent' // Menyembunyikan item ini
                },
                title: {
                    fontSize: 20,
                    offsetCenter: ['0%', '30%']
                },
                detail: {
                    show: true,
                    fontSize: 25,
                    color: tempColor,
                    formatter: '{value}°C',
                    offsetCenter: ['0%', '55%']
                }
            };


        var option;
        const gaugeData = [
            {
            value: number,
            name: 'Occupancy',
            itemStyle: {
                color: tempColor
            },
            title: {
                fontSize: 25,
                offsetCenter: ['0%', '-40%']
            },
            detail: {
                valueAnimation: true,
                fontSize: 30,
                formatter: '{value}%',
                offsetCenter: ['0%', '-10%'],
                lineHeight: 25,
                width: 100,
                height: 20,
                backgroundColor: bgColor,
                color: txtColor,
                rich: {}
            }
            } 
        ];
        if (temp !== "G3Ambient") {
            gaugeData.push(data2); // Pastikan data2 didefinisikan
        }
        option = {
            series: [
            {
                type: 'gauge',
                startAngle: 90,
                endAngle: -270,
                pointer: {
                show: false
                },
                progress: {
                show: true,
                overlap: true,
                roundCap: false,
                clip: false,
                width: 20
                },
                axisLine: {
                lineStyle: {
                    shadowColor: 'black',
                    shadowBlur: 4,
                    shadowOffsetX: 0,
                    shadowOffsetY: 0,
                    width: 20
                }
                },
                splitLine: {
                show: false
                },
                axisTick: {
                show: false
                },
                axisLabel: {
                show: false
                },
                data: gaugeData,
            }]
        };

        option && myCharts[temp].setOption(option);
    });
}


// create line chart for daily
function createDailyChart(){
    var dailyChart = document.getElementById("myAreaChart");
    myLineChart = new Chart(dailyChart, {
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
}


// create line chart for monthly
function createMonthlyChart(){
    var monthlyChart = document.getElementById("myAreaChartMonthly");
    myLineChartMonthly = new Chart(monthlyChart, {
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
            title: {
                display: true,
                text: 'Monthly Dispatch',
                fontSize: 25
            },
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
}

// set new data for daily line chart
function setDailyChartOption(label, ton) {
    // Mengubah data
    myLineChart.data.labels = label;
    myLineChart.data.datasets[0].data = ton;
    myLineChart.options = {
        title: {
            display: true,
            text: 'Daily Dispatch',
            fontSize: 25
        },
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
                    fontSize: 16
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: Math.round(Math.max(...ton) * 1.1),
                    maxTicksLimit: 5,
                    fontSize: 20
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
    
// set new data for monthly line chart
function setMonthlyChartOption(label, ton) {
    // Mengubah data
    myLineChartMonthly.data.labels = label;
    myLineChartMonthly.data.datasets[0].data = ton;
    myLineChartMonthly.options = {
        title: {
            display: true,
            text: 'Monthly Dispatch',
            fontSize: 25
        },
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
                    fontSize: 20
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: Math.round(Math.max(...ton) * 1.1),
                    maxTicksLimit: 5,
                    fontSize: 20
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
    myLineChartMonthly.update();
}


// Update berdasarkan bulan dan minggu yang dipilih
document.getElementById('monthFilterArea').addEventListener('change', updateLineChart);
document.getElementById('yearFilterArea').addEventListener('change', updateLineChart);

// Update daily dan monthly chart
function updateLineChart() {
    const month = document.getElementById('monthFilterArea').value;
    const year = document.getElementById('yearFilterArea').value;
    // Fetch dan update data bar chart berdasarkan bulan dan minggu yang dipilih
    fetch(`/area-data?month=${month}&year=${year}`)
        .then(response => response.json())
        .then(data => {
            console.log('Area Chart Data:', data); // Log data respons

            // Memastikan data yang diterima tidak undefined
            if (data && data.labels && data.tons && data.monthlyLabels && data.monthlyTons) {
                // && data.labels && data.tons
                setDailyChartOption(data.labels, data.tons.map(value => parseInt(value.replace(/\./g, ''), 10))); // Mengatur opsi chart
                setMonthlyChartOption(data.monthlyLabels, data.monthlyTons.map(value => parseInt(value.replace(/\./g, ''), 10)));
            } else {
                console.error('Data tidak valid:', data);
            }
        })
        .catch(error => console.error('Error fetching area chart data:', error));
}    

// Update tampilan daily dispatch tabel    
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
    const fomattedYear= new Date(selectedDate).toLocaleDateString('id-ID', {
        year: 'numeric'
    });
    document.getElementById('dateDisplay2').innerText = formattedDate;
    // Fetch dan update data berdasarkan tanggal yang dipilih
    fetch(`/warehouse-dispatch-filter?date=${selectedDate}&month=${fomattedMonth}&year=${fomattedYear}`)
        .then(response => response.json())
            .then(data => {
                console.log('Data Filtered:', data);


            if (data) { //Memastikan ada data di daily dan month
                // Kosongkan tabel sebelum menambahkan data baru
                const tbody = document.querySelector('#dispatchTable tbody');
                tbody.innerHTML = ''; // Menghapus isi tabel
                
                tbody.innerHTML +=`
                    <tr>
                        <th style="display:flex; justify-content:center;">
                            <div class="text-3xl" style="width:30%;">
                                Harian
                            </div>
                        </th>
                        <td class="text-center text-4xl">${data.daily[0] ? data.daily[0]['tons'] : '0'} ton</td>
                    </tr>
                    <tr>
                        <th style="display:flex; justify-content:center;">
                            <div class="text-3xl" style="width:30%;">
                                Bulanan
                            </div>
                        </th>
                        <td class="text-center text-4xl">${data.monthly[0] ? data.monthly[0]['tons'] : '0'} ton</td>
                    </tr>
                `;
            }

    })
    .catch(error => console.error('Error fetching filtered data:', error));
}

// Event listener untuk tombol filter tanggal di dropdown daily dispatch
document.getElementById('applyDateFilterDropdown2').addEventListener('click', function() {
    updateTotalDispatch();
});

</script>
@endpush

</x-app-layout>


