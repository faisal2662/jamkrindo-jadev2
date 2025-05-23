 @extends('layouts.main')
 @section('main')
     <div class="pagetitle">
         <h1>Dashboard</h1>
         <nav>
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                 <li class="breadcrumb-item active">Dashboard</li>
             </ol>
         </nav>
     </div><!-- End Page Title -->


     <section class="section dashboard">
         <div class="row">
             <div class="row mb-2">
                 <div class="col bg-white p-4">
                     <h5 class="card-title ">Customer Grafik</h5>

                     <div class="mb-2 w-25">
                        <label for="yearSelect" class="form-label">Tahun</label>
                        <select id="yearSelect" class="form-select">
                            <option value=""> - Pilih Tahun - </option>
                            @for ($year = 2024; $year <= date('Y'); $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div id="lineChart"></div>
   
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const customerData = @json($customers); // Mengambil data pelanggan dari server
                            const currentYear = new Date().getFullYear(); // Mendapatkan tahun saat ini
                            const monthlyData = {};
   
                            // Mengelompokkan data berdasarkan bulan untuk tahun saat ini
                            customerData.forEach(data => {
                                const date = new Date(data.created_date);
                                const monthYear = date.toLocaleString('default', {
                                    month: 'long',
                                    year: 'numeric'
                                });
   
                                // Hanya   menambahkan data untuk tahun saat ini
                                if (date.getFullYear() === currentYear) {
                                    if (!monthlyData[monthYear]) {
                                        monthlyData[monthYear] = 0; // Inisialisasi jika bulan belum ada
                                    }
                                    monthlyData[monthYear] += 1; // Menambahkan 1 untuk setiap entri
                                }
                            });
   
                            // Mengubah objek menjadi array untuk grafik
   
                            let categories = Object.keys(monthlyData);
                            let seriesData = Object.values(monthlyData);
   
                            // Membuat grafik awal
                            let chart = renderChart(categories, seriesData);
   
                            document.getElementById('yearSelect').addEventListener('change', function() {
                                const selectedYear = parseInt(this.value);
                                let filteredMonthlyData = {};
   
                                if (isNaN(selectedYear) || this.value === "") {
                                    // Jika tidak ada tahun yang dipilih, gunakan semua data
   
                                    categories = Object.keys(monthlyData);
                                    seriesData = Object.values(monthlyData);
                                } else {
                                    customerData.forEach(data => {
                                        const date = new Date(data.created_date);
                                        const monthYear = date.toLocaleString('default', {
                                            month: 'long',
                                            year: 'numeric'
                                        });
   
                                        // Hanya   menambahkan data untuk tahun saat ini
                                        if (date.getFullYear() === selectedYear) {
                                            if (!monthlyData[monthYear]) {
                                                monthlyData[monthYear] = 0; // Inisialisasi jika bulan belum ada
                                            }
                                            monthlyData[monthYear] += 1; // Menambahkan 1 untuk setiap entri
                                        }
                                    });
                                    // Filter data berdasarkan tahun yang dipilih
                                    filteredMonthlyData = Object.fromEntries(
                                        Object.entries(monthlyData).filter(([monthYear]) => {
                                            const year = monthYear.split(' ')[1];
                                        
                                            return year == selectedYear;
                                        })
                                    );
                                    categories = Object.keys(filteredMonthlyData);
                                    seriesData = Object.values(filteredMonthlyData);
   
                                }
   
                                // Render ulang grafik dengan data yang difilter
                                chart.destroy(); // Hancurkan grafik sebelumnya
                                chart = renderChart(categories, seriesData); // Fungsi renderChart
                            });
   
   
   
                            // Fungsi untuk merender grafik
                            function renderChart(categories, seriesData) {
                                const chart = new ApexCharts(document.querySelector("#lineChart"), {
                                    series: [{
                                        name: "Customers",
                                        data: seriesData
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'line',
                                        zoom: {
                                            enabled: true
                                        }
                                    },
                                    dataLabels: {
                                        enabled: true
                                    },
                                    stroke: {
                                        curve: 'smooth'
                                    },
                                    grid: {
                                        row: {
                                            colors: ['#f3f3f3', 'transparent'],
                                            opacity: 0.5
                                        },
                                    },
                                    xaxis: {
                                        categories: categories,
                                    }
                                });
                                chart.render();
                                return chart; // Kembalikan objek chart untuk digunakan nanti
                            }
                        });
                    </script>  

                     <!-- End Line Chart -->
                 </div>
             </div>

             <hr style="border : 1px dashed;">
             <!-- Left side columns -->
             <div class="col-lg-12">
                 <div class="row">
                     @if (Auth::guard('web')->user())
                         <!-- Sales Card -->
                         <div class="col-xxl-4 col-md-6">
                             <div class="card info-card sales-card">

                                 <div class="filter">
                                     <a class="icon" href="{{ route('customer-manager.index') }}"> <i
                                             class="bi bi-arrow-right-circle-fill"></i></a>

                                 </div>

                                 <div class="card-body">
                                     <h5 class="card-title">Customer <span>| Active</span></h5>
                                     <div class="d-flex align-items-center">
                                         <div
                                             class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                             <i class="bi bi-person-circle"></i>
                                         </div>
                                         <div class="ps-3">
                                             <h6>{{ $customers->count() }}</h6>
                                             <span class="text-success small pt-1 fw-bold">Person</span>
                                             {{-- <span class="text-muted small pt-2 ps-1">increase</span> --}}

                                         </div>
                                     </div>
                                 </div>

                             </div>
                         </div><!-- End Sales Card -->

                         <!-- Revenue Card -->
                         <div class="col-xxl-4 col-md-6">
                             <div class="card info-card revenue-card">

                                 <div class="filter">
                                     <a class="icon" href="{{ route('branch-manager.index') }}"><i
                                             class="bi bi-arrow-right-circle-fill"></i></a>

                                 </div>

                                 <div class="card-body">
                                     <h5 class="card-title">Cabang<span></span></h5>

                                     <div class="d-flex align-items-center">
                                         <div
                                             class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                             <i class="bi bi-building"></i>
                                         </div>
                                         <div class="ps-3">
                                             <h6>{{ $branchs->count() }}</h6>
                                             <span class="text-success small pt-1 fw-bold">Tersedia</span>

                                         </div>
                                     </div>
                                 </div>

                             </div>
                         </div><!-- End Revenue Card -->

                         <!-- Customers Card -->
                         <div class="col-xxl-4 col-xl-12">

                             <div class="card info-card customers-card">

                                 <div class="filter">
                                     <a class="icon" href="{{ route('region-manager.index') }}"><i
                                             class="bi bi-arrow-right-circle-fill"></i></a>

                                 </div>

                                 <div class="card-body">
                                     <h5 class="card-title">Wilayah <span></span></h5>

                                     <div class="d-flex align-items-center">
                                         <div
                                             class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                             <i class="bi bi-building"></i>
                                         </div>
                                         <div class="ps-3">
                                             <h6>{{ $regions->count() }}</h6>
                                             <span class="text-danger small pt-1 fw-bold">Tersedia</span>

                                         </div>
                                     </div>

                                 </div>
                             </div>

                         </div><!-- End Customers Card -->
                     @endif
                     @if (Auth::guard('customer') || Auth::guard('web'))
                         <!-- Customers Card -->
                         <div class="col-xxl-4 col-xl-6">

                             <div class="card info-card sales-card">

                                 <div class="filter">
                                     <a class="icon" href="{{ route('product-manager.index') }}"><i
                                             class="bi bi-arrow-right-circle-fill"></i></a>

                                 </div>
                                 <div class="card-body">
                                     <h5 class="card-title">Produk <span></span></h5>

                                     <div class="d-flex align-items-center">
                                         <div
                                             class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                             <i class="bi bi-building"></i>
                                         </div>
                                         <div class="ps-3">
                                             <h6>{{ $products->count() }}</h6>
                                             <span class="text-danger small pt-1 fw-bold">Tersedia</span>

                                         </div>
                                     </div>

                                 </div>

                             </div>

                         </div><!-- End Customers Card -->
                         <div class="col-xxl-4 col-xl-6">

                             <div class="card info-card sales-card">

                                 <div class="filter">
                                     <a class="icon" href="{{ route('report.dwh') }}"><i
                                             class="bi bi-arrow-right-circle-fill"></i></a>

                                 </div>
                                 <div class="card-body">
                                     <h5 class="card-title">Jumlah SP <span></span></h5>

                                     <div class="d-flex align-items-center">
                                         <div
                                             class="card-icon rounded-circle d-flex align-items-center justify-content-center text-success">
                                             <i class="bi bi-file-earmark-text"></i>
                                         </div>
                                         <div class=" text-success ps-3">
                                             <!-- <h6>2</h6> -->
                                             <span class="text-danger small pt-1 fw-bold">Tersedia</span>
 
                                         </div>
                                     </div>

                                 </div>

                             </div>

                         </div><!-- End Customers Card -->
                     @endif
                 </div>
             </div><!-- End Left side columns -->

         </div>
     </section>
 @endsection
