<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Production') }}
        </h2>
    </x-slot>

<!-- Weight and Quantity Comparison -->
<div class="flex justify-between">
    <!-- Weight Comparison -->
    <div class="box pull-up w-1/2 mr-2">
        <div class="box-body h-36"> <!-- Adjust height as needed -->
            <div class="flex justify-between items-center">
                <div class="bs-5 ps-10 border-info">
                    <p class="text-fade mb-10">Total Production Last Month</p>
                    <h2 id="weightLastMonth" class="my-0 fw-700 text-3xl"></h2>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-box bg-info-light me-0 fs-24 rounded-3"></i>
                </div>
            </div>
            <p id="weightComparison" class="text-danger mb-0 mt-10"><i class="fa-solid fa-arrow-down"></i></p>
        </div>
    </div>
    <!-- Quantity Comparison -->
    <div class="box pull-up w-1/2 ml-2">
        <div class="box-body h-36"> <!-- Adjust height as needed -->
            <div class="flex justify-between items-center">
                <div class="bs-5 ps-10 border-info">
                    <p class="text-fade mb-10">Quantity Last Month</p>
                    <h2 id="qtyLastMonth" class="my-0 fw-700 text-3xl"></h2>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-boxes-stacked bg-info-light me-0 fs-24 rounded-3"></i>
                </div>
            </div>
            <p id="qtyComparison" class="text-danger mb-0 mt-10"><i class="fa-solid fa-arrow-down"></i> </p>
        </div>
    </div>
</div>


 <div class="grid grid-cols-5 gap-x-4 mb-4"> <!--grid-cols-1 md:grid-cols-3 -->
    <!-- Bar Chart -->
    <div class="col-span-3">
        <div class="box rounded-2xl">
            <div class="box-body analytics-info">
                <div class="flex justify-between">
                    <div class="text-3xl font-medium">Production Period</div>
                    <div class="flex">
                        <!-- Daftar Tahun -->
                        <select id="yearFilterBar" class="mr-2 bg-gray-500 text-3xl rounded text-black">
                            @php
                                $currentYear = date('Y'); // Mengambil tahun saat ini
                            @endphp
                            <option value="" class="" disabled selected hidden>{{$currentYear}}</option>
                            @for ($i = $currentYear; $i >= $currentYear - 10; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <!-- Daftar bulan -->
                        <select id="monthFilterBar" class="mr-2 bg-gray-500 text-3xl rounded text-black">
                            <option value="" class="" disabled selected hidden>{{ date('F') }}</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" >{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div id="barChart" style="height:450px;"></div>
            </div>
        </div>
    </div>
    <!-- Table -->
    <div class="col-span-2">
        <div class="card rounded-2xl">
            <div class="box-header flex justify-between items-center">
                <h4 class="box-title text-3xl">Line</h4>
                <ul class="m-0" style="list-style: none;">
                    <li class="dropdown">
                        <button id="dateDisplay" class="waves-effect waves-light btn btn-outline dropdown-toggle btn-md text-3xl"
                            data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            {{ date('d F Y') }} <!-- Menampilkan tanggal hari ini -->
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="will-change: transform;">
                            <div class="px-3 py-2">
                                <input type="date" id="dateFilterDropdown" class="bg-gray-200 text-black text-3xl"
                                    value="{{ date('Y-m-d') }}">
                                <button id="applyDateFilterDropdown"
                                    class="bg-blue-500 text-white px-2 py-1 mt-2">Terapkan</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 w-full">
                    <thead>
                        <tr>
                            <th class="text-3xl">Line</th>
                            <th class="text-center text-3xl">Shift 1</th>
                            <th class="text-center text-3xl">Shift 2</th>
                            <th class="text-center text-3xl">Shift 3</th>
                            <th class="text-center text-3xl">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center text-3xl">Tidak ada data untuk ditampilkan.</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<div id="gaugeChart" class="grid grid-cols-5 gap-x-4 mb-4">
    <!-- Line A -->
    <div class="card rounded-2xl pull-up" style="border:2px solid rgb(96 165 250)">
        <div class="box-header flex justify-start items-center">
            <h3 class="box-title m-0 text-3xl">A</h3>
        </div>
        <div id="lineAChart" style="height:350px;" class=""></div>
    </div>
    <div class="card rounded-2xl pull-up" style="border:2px solid rgb(248 113 113)">
        <div class="box-header flex justify-start items-center">
            <h3 class="box-title m-0 text-3xl">B</h3>
        </div>
        <div id="lineBChart" style="height:350px;" class="m-0 p-0"></div>
    </div>
    <div class="card rounded-2xl pull-up" style="border:2px solid rgb(216 180 254)">
        <div class="box-header flex justify-start items-center">
            <h3 class="box-title m-0 text-3xl">C</h3>
        </div>
        <div id="lineCChart" style="height:350px;" class="m-0 p-0"></div>
    </div>
    <div class="card rounded-2xl pull-up" style="border:2px solid rgb(134 239 172)">
        <div class="box-header flex justify-start items-center">
            <h3 class="box-title m-0 text-3xl">D</h3>
        </div>
        <div id="lineDChart" style="height:350px;" class="m-0 p-0"></div>
    </div>
    <div class="card rounded-2xl pull-up" style="border:2px solid rgb(253 186 116)">
        <div class="box-header flex justify-start items-center">
            <h3 class="box-title m-0 text-3xl">E</h3>
        </div>
        <div id="lineEChart" style="height:350px;" class="m-0 p-0"></div>
    </div>
</div>

@push('scripts')
<!-- Import Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>


<!-- Scripts for Charts -->
<script>


// Inisialisasi ECharts
var barChart = echarts.init(document.getElementById('barChart'));

// Inisialisasi untuk setiap Line (A, B, C, D. E) Gauge Chart
var doughnutData;
const myCharts = {};

// Line A, B, C, D, E
const lines = ['A', 'B', 'C', 'D', 'E'];

document.addEventListener('DOMContentLoaded', function() {
    fetchDashboardData();
    updateBarChart();
    updateFilterDropdown();
    createInterval();
});

function createInterval() {
    setInterval(() => {
        updateBarChart();
        updateFilterDropdown();
    }, 5000);
}

function fetchDashboardData() {
            fetch('/get-dashboard-production')
                .then(response => response.json())
                .then(data => {
                    console.log('Dashboard Data:', data);
                    // Update Weight and Quantity Comparison
                    document.getElementById('weightLastMonth').innerText = `${data.weightLastMonth} KG`;
                    document.getElementById('weightComparison').innerHTML =
                        `<i class="fa-solid fa-arrow-down"></i> ${data.weightComparison} since last month`;
                    document.getElementById('qtyLastMonth').innerText = data.qtyLastMonth;
                    document.getElementById('qtyComparison').innerHTML =
                        `<i class="fa-solid fa-arrow-down"></i> ${data.qtyComparison} since last month`;

                    // Create gauge chart (Lines A B C D E)
                    createGaugeChart();
                    // Inisialisasi standard data
                    doughnutData = data.gaugeStandarData;
            })
            .catch(error => console.error('Error fetching dashboard data:', error));
}

function createGaugeChart(){

    // Gauge Charts for Lines A, B, C, D, E
    lines.forEach(line => {
        const ctx = document.getElementById(`line${line}Chart`);
        myCharts[line] = echarts.init(ctx);
        var option;
        option = {
        series: [
            {
            type: 'gauge',
            startAngle: 180,
            endAngle: 0,
            min: 0,
            max: 1,
            splitNumber: 2,
            itemStyle: {
                color: '#007BFF',
                shadowColor: 'rgba(0,138,255,0.45)',
                shadowBlur: 10,
                shadowOffsetX: 2,
                shadowOffsetY: 2
            },
            progress: {
                show: true,
                roundCap: true,
                width: 10
            },
            pointer: {
                icon: 'path://M2090.36389,615.30999 L2090.36389,615.30999 C2091.48372,615.30999 2092.40383,616.194028 2092.44859,617.312956 L2096.90698,728.755929 C2097.05155,732.369577 2094.2393,735.416212 2090.62566,735.56078 C2090.53845,735.564269 2090.45117,735.566014 2090.36389,735.566014 L2090.36389,735.566014 C2086.74736,735.566014 2083.81557,732.63423 2083.81557,729.017692 C2083.81557,728.930412 2083.81732,728.84314 2083.82081,728.755929 L2088.2792,617.312956 C2088.32396,616.194028 2089.24407,615.30999 2090.36389,615.30999 Z',
                length: '75%',
                width: 8,
                offsetCenter: [0, '5%']
            },
            axisLine: {
                roundCap: true,
                lineStyle: {
                width: 5
                }
            },
            axisTick: {
                splitNumber: 2,
                lineStyle: {
                width: 2,
                color: '#999'
                }
            },
            splitLine: {
                length: 12,
                lineStyle: {
                width: 3,
                color: '#999'
                }
            },
            axisLabel: {
                distance: 10,
                color: '#999',
                fontSize: 24
            },
            title: {
                fontSize: 24
            },
            detail: {
                backgroundColor: '#fff',
                borderColor: '#999',
                borderWidth: 2,
                width: '90%',
                lineHeight: 30,
                height: 24,
                borderRadius: 8,
                offsetCenter: [0, '35%'],
                valueAnimation: true,
                formatter: function (value) {
                    return '{value|' + value.toLocaleString('id-ID') + '}';
                },
                rich: {
                value: {
                    fontSize: 24,
                    fontWeight: 'bolder',
                    color: 'inherit'
                }
                }
            },
            data: [
                {
                value: 1,
                name: 'Actual Data',
                title: {
                    offsetCenter: ['-65%', '70%']
                },
                detail: {
                    offsetCenter: ['-65%', '35%']
                },
                
                },
                {
                value: 1,
                name: 'Standard Data',
                itemStyle: {
                    color: 'red',
                    shadowColor: 'rgba(0,138,255,0.45)',
                    shadowBlur: 10,
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                },
                title: {
                    offsetCenter: ['65%', '70%']
                },
                detail: {
                    offsetCenter: ['65%', '35%']
                }
                }
            ]
            }
        ]
        };

        option && myCharts[line].setOption(option);
        
    });
}
    

// Fungsi untuk mengatur opsi chart
function setBarChartOption(label, actualData, standardData, actualHeight) {
    var option;

    const rawData = actualData;
    const grid = {
    left: 100,
    right: 100,
    top: 50,
    bottom: 50
    };
    const series = ['A', 'B', 'C', 'D', 'E'].map((name, sid) => {
    return {
        name,
        type: 'bar',
        stack: 'total',
        barWidth: '60%',
        label: {
        show: false
        },
        data: rawData[sid],
        markLine: {
            data: [
                {
                    yAxis: standardData[0], // Tambahkan threshold di sumbu Y
                    label: {
                        formatter: function(params) {
                            return params.value.toLocaleString('id-ID'); // Memformat angka ribuan dengan koma
                        },
                        color: '#73757D',
                        fontSize: 20 // Tambahkan properti fontSize di sini
                    }
                }
            ],
            lineStyle: {
                color: 'red',
                type: 'dashed',
            }
        }
    };
    });
    option = {
        color: ['#609CFA', '#F87171', '#D8B4FE', '#86EFAC', '#FDBA74'],
        legend: {
            // data: ['P3', 'P2', 'P1', 'Liquid', 'Pastry'],
            selectedMode: false,
            textStyle: {
                fontSize: 20, // Sesuaikan ukuran font di sini
            }
        },
        grid,
        yAxis: {
            type: 'value',
            min: 0,
            max: Math.round(Math.max(actualHeight, standardData) * 1.03), // Menentukan tinggi maksimum berdasarkan data yang lebih tinggi
            axisLabel:{
                fontSize: 17,
                formatter: function(value) {
                    return value.toLocaleString('id-ID'); // Memformat angka dengan titik
                }
            }
        },
        xAxis: {
            type: 'category',
            data: label,
            axisLabel:{
                fontSize: 15
            }
        },
        series
    };
    
    // Menggunakan opsi yang telah ditentukan untuk menampilkan chart
    option && barChart.setOption(option);
}

// Update Bar Chart berdasarkan bulan dan minggu yang dipilih
document.getElementById('monthFilterBar').addEventListener('change', updateBarChart);
document.getElementById('yearFilterBar').addEventListener('change', updateBarChart);

function updateBarChart() {
    const month = document.getElementById('monthFilterBar').value;
    const year = document.getElementById('yearFilterBar').value;
    
    // Fetch dan update data bar chart berdasarkan bulan dan minggu yang dipilih
    fetch(`/bar-data?month=${month}&year=${year}`)
        .then(response => response.json())
        .then(data => {
            console.log('Bar Chart Data:', data); // Log data respons

            // Memastikan data yang diterima tidak undefined
            if (data && data.labels && data.actual_qty && data.standard_qty && data.actual_height ) {

                setBarChartOption([...new Set(data.labels)], data.actual_qty, data.standard_qty.map(Number), data.actual_height); // Mengatur opsi chart
                    
            } else {
                console.error('Data tidak valid:', data);
            }
        })
        .catch(error => console.error('Error fetching bar chart data:', error));
}

// Event listener untuk tombol filter tanggal di dropdown
document.getElementById('applyDateFilterDropdown').addEventListener('click', function() {
    updateFilterDropdown();
});

function updateFilterDropdown(){
    const selectedDate = document.getElementById('dateFilterDropdown').value;
    // Mengubah teks tombol untuk menampilkan tanggal yang dipilih
    const formattedDate = new Date(selectedDate).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
    document.getElementById('dateDisplay').innerText = formattedDate;

    // Fetch dan update data berdasarkan tanggal yang dipilih
    fetch(`/data-filter?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data Filtered:', data);

            // Kosongkan tabel sebelum menambahkan data baru
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = ''; // Menghapus isi tabel

            // Pastikan data memiliki struktur yang benar ### Panjang isi data lebih dari 0 ###
            if (data && data.data && Array.isArray(data.data) && Object.keys(data.data).length > 0) {
                
                // Inisialisasi objek untuk menyimpan total per line
                const totals = {};

                // Tambahkan data baru ke objek totals
                data.data.forEach(item => {
                    if (!totals[item.line]) {
                        totals[item.line] = {
                            shift1: 0,
                            shift2: 0,
                            shift3: 0,
                            total: 0
                        };
                    }
                    // Menambahkan total_weight ke shift yang sesuai
                    if (item.shift === 'Shift 1') {
                        totals[item.line].shift1 += parseFloat(item.total_weight);
                    } else if (item.shift === 'Shift 2') {
                        totals[item.line].shift2 += parseFloat(item.total_weight);
                    } else if (item.shift === 'Shift 3') {
                        totals[item.line].shift3 += parseFloat(item.total_weight);
                    }
                });

                // Menampilkan data ke dalam tabel
                for (const line in totals) {

                    // cek apakah line adalah A/B/C/D/E
                    if (lines.includes(line)){
                        const shifts = totals[line];
                        const totalWeight = shifts.shift1 + shifts.shift2 + shifts.shift3;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="pt-0 px-0 b-0">
                                <div class="flex items-center">
                                    <div class="w-10 h-50 rounded ${line == 'A' ? 'bg-blue-400' : (line == 'B' ? 'bg-red-400' : (line == 'C' ? 'bg-purple-300' : (line == 'D' ? 'bg-green-300' : 'bg-orange-300')))}"></div>
                                            <span class="text-fade text-3xl ml-2 font-semibold">${line == 'A' ? 'A' : (line == 'B' ? 'B' : (line == 'C' ? 'C' : (line == 'D' ? 'D' : (line == 'E' ? 'E' : ''))))}</span>
                                </div>
                            </td>
                            <td class="text-right b-0 pt-0 px-0">
                                <span class="text-fade text-4xl">${shifts.shift1.toLocaleString('id-ID')} KG</span>
                            </td>
                            <td class="text-right b-0 pt-0 px-0">
                                <span class="text-fade text-4xl">${shifts.shift2.toLocaleString('id-ID')} KG</span>
                            </td>
                            <td class="text-right b-0 pt-0 px-0">
                                <span class="text-fade text-4xl">${shifts.shift3.toLocaleString('id-ID')} KG</span>
                            </td>
                            <td class="text-right b-0 pt-0 px-0">
                                <span class="text-fade text-4xl">${totalWeight.toLocaleString('id-ID')} KG</span>
                            </td>
                        `;
                        tbody.appendChild(row);

                        // Gauge Chart set new Option
                        myCharts[line].setOption({
                            series: [
                            {
                                max: Math.round(Math.max(totalWeight.toFixed(2), doughnutData[line]*1.3)),
                                data: [
                                    {
                                        value: doughnutData[line],
                                        name: 'Standard Data',
                                        itemStyle: {
                                            color: 'red',
                                            shadowColor: 'rgba(0,138,255,0.45)',
                                            shadowBlur: 10,
                                            shadowOffsetX: 2,
                                            shadowOffsetY: 2
                                        },
                                        title: {
                                            offsetCenter: ['65%', '70%']
                                        },
                                        detail: {
                                            offsetCenter: ['65%', '35%']
                                        }
                                    },
                                    {
                                        value: totalWeight.toFixed(2),
                                        name: 'Actual Data',
                                        title: {
                                            offsetCenter: ['-65%', '70%']
                                        },
                                        detail: {
                                            offsetCenter: ['-65%', '35%']
                                        }
                                    }
                                    
                                ]
                            }]
                        });
                    }else{
                        console.log("tidak ada line '",line,"'");
                    }
                }

                // Tambahkan baris untuk grand total jika diperlukan
                const grandTotalRow = document.createElement('tr');
                const grandTotal = Object.values(totals).reduce((acc, curr) => acc + curr.shift1 + curr.shift2 + curr.shift3, 0);
                grandTotalRow.innerHTML = `
                    <td class="text-right text-4xl" colspan="4"><strong>Grand Total</strong></td>
                    <td class="text-left text-4xl"><strong>${grandTotal.toLocaleString('id-ID')} KG</strong></td>
                `;
                tbody.appendChild(grandTotalRow);
            } else {
                console.error('Data tidak valid:', data);
                console.log('Data tidak valid:', data);
                console.log('Data lenght:', Object.keys(data.data).length);

                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="5" class="text-center text-3xl">Tidak ada data untuk ditampilkan.</td>
                `;
                tbody.appendChild(row);

                const lines = ['A', 'B', 'C', 'D', 'E'];
                for (const line of lines) {
                    myCharts[line].setOption({
                        series: [
                        {
                            max: 1,
                            data: [
                                {
                                    value: 0,
                                    name: 'Standard Data',
                                    itemStyle: {
                                        color: 'red',
                                        shadowColor: 'rgba(0,138,255,0.45)',
                                        shadowBlur: 10,
                                        shadowOffsetX: 2,
                                        shadowOffsetY: 2
                                    },
                                    title: {
                                        offsetCenter: ['65%', '70%']
                                    },
                                    detail: {
                                        offsetCenter: ['65%', '35%']
                                    }
                                },
                                {
                                    value: 0,
                                    name: 'Actual Data',
                                    title: {
                                        offsetCenter: ['-65%', '70%']
                                    },
                                    detail: {
                                        offsetCenter: ['-65%', '35%']
                                    }
                                }
                                
                            ]
                        }]
                    });
                }
            }
        })
        .catch(error => console.error('Error fetching filtered data:', error));
}

</script>
@endpush

</x-app-layout>

