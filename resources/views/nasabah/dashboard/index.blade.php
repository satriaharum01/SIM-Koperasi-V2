@extends('template.onepage')

@section('content')
        <!-- start home -->
        <section id="feature1">
			<div class="container">
				<div class="row">
					<div class="col-md-6 wow fadeInUp animated" data-wow-delay="0.6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
						<img src="images/software-img.png" class="img-responsive" alt="feature img">
					</div>
					<div class="col-md-6 wow fadeInUp animated" data-wow-delay="0.6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
						<h2 class="text-uppercase">{{$title}}</h2>
						<!-- Content Row -->
                        <div class="row">
                    
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Pinjaman
                                                </div>
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 d-flex col-md-12 justify-content-between">
                                                    <span>Rp. </span>
                                                    <span> {{number_format($c_pinjaman)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Simpanan
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800 d-flex col-md-12 justify-content-between">
                                                    <span>Rp. </span>
                                                    <span> {{number_format($c_simpanan)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
					</div>
				</div>
			</div>
		</section>
		<!-- end home -->
		<!-- start footer -->
@endsection
@section('js')
<script src="{{asset('node_modules/axios/dist/axios.min.js')}}"></script>
@endsection