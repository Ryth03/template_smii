
@push('css')
<!-- <style src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.2.0/apexcharts.min.css"></style> -->

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.2.0/apexcharts.min.css"> -->
<style>
    @media (min-width: 1024px) {
        .lg\:grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }
    }
    .table-striped thead th:nth-child(1) {
        color: #28a745;
    }
    .table-striped thead th:nth-child(2) {
        color: #007bff;
    }
    .table-striped thead th:nth-child(3) {
        color:#FF8C00;
    }

    .table-striped thead th{
        background-color: #f1e6d2;
    }
    .dark-skin .table-striped thead th{
        background-color: #3f2177;
    } 


    /* Custom Scroll saat light mode */
    .scrollable-content::-webkit-scrollbar { /* Ukuran scrollbar*/
        width: 7px;
        height: 7px;
    }
    .scrollable-content::-webkit-scrollbar-track { /* Track scrollbar  */
        background: white; /* Latar belakang  */
        border-radius: 10px;
    }
    .scrollable-content::-webkit-scrollbar-thumb { /* Thumb scrollbar */
        background: #0CC3AB; 
        border-radius: 10px;
    }
    .scrollable-content::-webkit-scrollbar-thumb:hover { /* Thumb scrollbar saat hover */
        background: #0DB5A0;
    }

    /* Custom Scroll saat light mode */
    .dark-skin .scrollable-content::-webkit-scrollbar { /* Ukuran scrollbar*/
        width: 8px;
        height: 8px;
    }
    .dark-skin .scrollable-content::-webkit-scrollbar-track { /* Track scrollbar  */
        background: inherit; /* Latar belakang  */
        border: 1px solid #323B40;
    }
    .dark-skin .scrollable-content::-webkit-scrollbar-thumb { /* Thumb scrollbar */
        background: #0CC3AB; 
    }
    .dark-skin .scrollable-content::-webkit-scrollbar-thumb:hover { /* Thumb scrollbar saat hover */
        background: #0DB5A0;
    }
</style>
@endpush

<div class="grid sm:grid-cols-2 ">
    <!--  Leaderboard -->
    <div class="card card-body mx-2" style="border-radius: 10px;">
        <h4 class="card-title flex justify-center">  
        @if (auth()->user()->can('view all form hse'))
            <a class="underline" href="{{ route('hse.dashboard') }}">
                Active
            </a>
        @else
            Active
        @endif
        </h4>
        <div class="table-responsive scrollable-content" style="max-height: 300px; overflow-y: auto;">
            <table id="activeTable" class="table table-striped w-full" style="position: relative;">
                <thead style="position: sticky; top:0px">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @for($j = 0; $j<=5 ; $j++)
                    <tr class="">
                        <td>{{$j+1}}</td>
                        <td>PT Sinar Meadow International Indonesia</td>
                        <td>In Progress</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-body mx-2" style="border-radius: 10px;">
        <h4 class="card-title flex justify-center" >
            Rating
        </h4>
        <div class="table-responsive scrollable-content" style="max-height: 300px; overflow-y: auto;">
            <table id="ratingTable" class="table table-striped w-full" style="position: relative;">
                <thead style="position: sticky; top:0px">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @for($j = 0; $j<=5 ; $j++)
                    <tr class="">
                        <td>{{$j+1}}</td>
                        <td>PT Sinar Meadow International Indonesia</td>
                        <td>In Progress</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="grid md:grid-cols-3 sm:grid-cols-2 ">
    
    <div class="card card-body mx-2" style="border-radius: 10px;">
        <h4 class="card-title flex justify-center">
            @if (auth()->user()->can('review form hse'))
                <a class="underline" href="{{ route('review.table') }}">
                    Review
                </a>
            @else
                Review
            @endif
        </h4>
        <div class="table-responsive scrollable-content" style="max-height: 300px; overflow-y: auto;">
            <table id="reviewTable" class="table table-striped w-full" style="position: relative;">
                <thead style="position: sticky; top:0px">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @for($j = 0; $j<=5 ; $j++)
                    <tr class="">
                        <td>{{$j+1}}</td>
                        <td>PT Sinar Meadow International Indonesia</td>
                        <td>In Progress</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-body mx-2" style="border-radius: 10px;">
        <h4 class="card-title flex justify-center">
            @if (auth()->user()->can('approve form hse'))
                <a class="underline" href="{{ route('approval.table') }}">
                    Approval
                </a>
            @else
                Approval
            @endif
        </h4>
        <div class="table-responsive scrollable-content" style="max-height: 300px; overflow-y: auto;">
            <table id="approvalTable" class="table table-striped w-full" style="position: relative;">
                <thead style="position: sticky; top:0px">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @for($j = 0; $j<=5 ; $j++)
                    <tr class="">
                        <td>{{$j+1}}</td>
                        <td>PT Sinar Meadow International Indonesia</td>
                        <td>In Progress</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-body mx-2" style="border-radius: 10px;">
        <h4 class="card-title flex justify-center">
            <a class="underline" href="{{ route('hse.dashboard') }}">
                Need Evaluation
            </a>
        </h4>
        <div class="table-responsive scrollable-content" style="max-height: 300px; overflow-y: auto;">
            <table id="evaluationTable" class="table table-striped w-full" style="position: relative;">
                <thead style="position: sticky; top:0px">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @for($j = 0; $j<=5 ; $j++)
                    <tr class="">
                        <td>{{$j+1}}</td>
                        <td>PT Sinar Meadow International Indonesia</td>
                        <td>In Progress</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>


</div>

<div>
    <div class="card">
        <div class="card-body">
            <div class="flex justify-between">
                <h4 class="card-title">Permit Form Bar Chart</h4>
                <div id="selectDiv">
                    <select name="" id="categoryFilterChart" class="form-select filter-select"
                        aria-label="Filter by Category" onChange="getChartData()">
                        <option value="">Select Category</option>
                    </select>
                    <select id="yearFilterChart" class="form-select filter-select"
                        aria-label="Filter by Year" onChange="getChartData()">
                        <option value="" disabled>Select year</option>
                        <!-- <option value="2023">2023</option> -->
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
            </div>
            <div id="stackedBarChart"></div>
        </div>
    </div>
</div>
    

@push('scripts')
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.2.0/apexcharts.min.js"></script> -->
<script>
    window.addEventListener('load', () => {
        getLeaderboardData('activeTable');
        getLeaderboardData('reviewTable');
        getLeaderboardData('approvalTable');
        getLeaderboardData('evaluationTable');
        getLeaderboardData('ratingTable');

        categoryFilterChartData();
        getChartData();
    });

    // Inisialisasi grafik
    var months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    var stackedBarOptions = {
        series: [
            {
                name: 'Created',
                type: 'bar',
                emphasis: {
                    focus: 'series'
                },
                data: [320, 332, 301, 334, 390, 330, 320]
            },
            {
                name: 'Finished',
                type: 'bar',
                emphasis: {
                    focus: 'series'
                },
                
                data: [120, 132, 101, 134, 90, 230, 210]
            }
        ],
        chart: {
            type: 'bar',
            height: 350,
            stacked: false,
            foreColor: '#b0bac2', // Text color for dark mode
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: false, // Ubah dari true ke false
            },
        },
        dataLabels: {
          enabled: true,
          style: {
            fontSize: '12px',
            colors: ['#3c3d54']
          }
        },
        xaxis: {
            type: 'category',
            categories: months
        },
        legend: {
            position: 'right',
            offsetY: 40
        },
        fill: {
            opacity: 1
        },
        responsive: [{
            breakpoint: 768,
            options: {
                plotOptions: {
                    bar: {
                        horizontal: false // Pastikan ini juga diatur ke false
                    }
                },
                legend: {
                    position: 'bottom',
                    offsetY: 0
                }
            }
        }]
    };
    
    var stackedBarChart = new ApexCharts(document.querySelector("#stackedBarChart"), stackedBarOptions);
    stackedBarChart.render();

    function getLeaderboardData(id){
        $.ajax({
            url: '{{ route('leaderboard.dashboard.hse') }}', // Route untuk mencari ide
            type: 'GET',
            data: { 
                category: id
            },
            success: function(response) {
                console.log(response);
                const table = document.querySelector(`#${id} tbody`);
                table.innerHTML = '';
                if(response.length > 0){
                    response.forEach(function(data, index){
                        table.innerHTML += `
                                <td>${index+1}</td>
                                <td>${data.company_department}</td>
                                <td>${data.extra}</td>
                            
                        `;
                    })
                }
                else{
                    table.innerHTML += `<td class="text-center" colspan="3">No Data Available</td>`;
                }
            }
        });
    }

    function getChartData(){
        const yearSelect = document.getElementById('yearFilterChart').value;
        const categorySelect = document.getElementById('categoryFilterChart').value;
        console.log("Year: ",yearSelect);
        console.log("Category: ",categorySelect);
        $.ajax({
            url: '{{ route('chart.dashboard.hse') }}', // Route untuk mencari ide
            type: 'GET',
            data: { 
                year: yearSelect,
                category: categorySelect
            },
            success: function(response) {
                console.log(response);
                stackedBarChart.updateOptions({
                    xaxis: {
                        type: 'year',
                        categories: response.months
                    },
                    series: [
                        {
                            name: 'Created',
                            type: 'bar',
                            emphasis: {
                                focus: 'series'
                            },
                            data: response.formsCreated
                        },
                        {
                            name: 'Finished',
                            type: 'bar',
                            emphasis: {
                                focus: 'series'
                            },
                            data: response.formsFinished
                        }
                    ]
                });
            }
        });
    }


    function categoryFilterChartData(){
        const categorySelect = document.getElementById('categoryFilterChart');
        $.ajax({
            url: '{{ route('chart.dashboard.category') }}', // Route untuk mencari ide
            type: 'GET',
            success: function(response) {
                console.log(response);
                response.forEach(item => {
                    categorySelect.innerHTML += `
                        <option value="${item.id}">${item.name}</option>
                    `;
                });
            }
        });
    }
</script>
@endpush