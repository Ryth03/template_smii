<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Shipment') }}
    </h2>
</x-slot>

@push('css')
<style>
    /* Styling untuk card secara keseluruhan */
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek melayang */
        border-radius: 8px; /* Membuat sudut yang membulat */
        border: none; /* Menghilangkan border default */
        transition: all 0.3s ease-in-out; /* Animasi saat hover */
    }

    /* Efek zoom in saat hover */
    .card:hover {
        /* transform: translateY(-5px); Mengangkat card sedikit ke atas */
        /* box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); Tambahkan bayangan saat hover */
    }

    /* Styling untuk header card */
    .card-header {
        background-color: #4e73df; /* Warna latar belakang biru */
        color: white; /* Warna teks putih */
        font-weight: bold; /* Membuat teks lebih tebal */
        font-size: 1.1rem; /* Ukuran font lebih besar */
        padding: 12px 15px; /* Menambahkan padding untuk estetika */
        display: flex;
        align-items: center; /* Align ikon dan teks secara vertikal */
        justify-content: space-between; /* Menyebarkan konten */
    }

    /* Styling ikon di header */
    .card-header i {
        margin-right: 8px; /* Spasi antara ikon dan teks */
    }

    /* Styling untuk body card yang berisi canvas */
    .card-body {
        padding: 20px; /* Memberikan ruang di sekitar canvas */
        background-color: #f8f9fc; /* Warna latar belakang body card */
    }

</style>
@endpush


<div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 mb-4">
    <!-- Bar Chart -->
    <div class="col-span-2">
        <div class="box">
            <div class="box-body analytics-info">
                <div class="text-xl font-medium">Area Chart</div>
                <div><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
    <!-- Table -->
    <div class="col-span-1">
        <div class="card rounded-2xl">
            <div class="box-header flex b-0 justify-between items-center">
                <h4 class="box-title text-2xl">Line</h4>
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
            <div class="card-body pt-0"></div>
            <div class="table-responsive">
                <table class="table mb-0 w-full">
                    <thead>
                        <tr>
                            <th>Line</th>
                            <th class="text-center">Shift 1</th>
                            <th class="text-center">Shift 2</th>
                            <th class="text-center">Shift 3</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Area Chart 
        </div>
        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
    </div>

</div>

    


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script>
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
        datasets: [{
        label: "Sessions",
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
        data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451],
        }],
    },
    options: {
            title: {
                display: true,
                text: 'Chart.js Line Chart - Cubic interpolation mode'
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
            maxTicksLimit: 7
            }
        }],
        yAxes: [{
            ticks: {
            min: 0,
            max: 40000,
            maxTicksLimit: 5
            },
            gridLines: {
            color: "rgba(0, 0, 0, .125)",
            }
        }],
        },
        legend: {
        display: false
        }
    }
    });
</script>
@endpush


</x-app-layout>



