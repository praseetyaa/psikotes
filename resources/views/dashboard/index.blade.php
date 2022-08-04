@extends('template/main')

@section('content')

<section>
    <div class="bg-theme-1 text-white" style="padding: 7em 0 8em 0; background-image:url('assets/images/background/bg-tes.svg')">
		<div class="container">
			<div class="d-flex align-items-center rounded-2 shadow-sm p-3 bg-glass-light">
				<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" width="70" height="70" style="background:url('assets/images/pas-foto/default-man.png'); background-size:70px; background-position:center; border:2px solid #fff" class="me-3 rounded-circle">
				<div>
					<p class="fw-bold text-capitalize mb-0">{{Auth::user()->name}}</p>
					<p class="mb-0">Selamat datang di Tes Online Psikologi<br>Kamu dapat melakukan tes online dengan memilih menu tes yang ada di bawah ini.</p>
				</div>
			</div>
		</div>
    </div>
</section>
<div class="bg-white position-relative" style="top:-4.5rem; border-radius: 1rem 1rem 0 0">
	<div class="d-flex justify-content-center py-3">
		<div style="height:5px; width:5rem; background-color:#ced4da" class="rounded-1"></div>
	</div>
<section class="container">	
	<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
	  <div class="carousel-indicators">
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active bg-dark rounded-circle" style="width:8px; height:8px" aria-current="true" aria-label="Slide 1"></button>
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class=" bg-dark rounded-circle" style="width:8px; height:8px" aria-label="Slide 2"></button>
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class=" bg-dark rounded-circle" style="width:8px; height:8px" aria-label="Slide 3"></button>
	  </div>
	  <div class="carousel-inner">
		<div class="carousel-item active">
		  <p class="py-5 px-3 border rounded-2">Taukah kamu? Tes psikologi mampu untuk memprediksi potensi pencapaian hasil belajar dan kemampuan kamu.</p>
		</div>
		<div class="carousel-item">
		  <p class="py-5 px-3 border rounded-2">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		</div>
		<div class="carousel-item">
		  <p class="py-5 px-3 border rounded-2">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
		</div>
	  </div>
	  <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
		<img width="40" src="{{ asset('assets/images/icon/next.png') }}">
	  </button>
	</div>	
	<div class="w-100 my-3 rounded-1" style="height:3px; background-color:#dee2e6"></div>
	<div class="heading">
		<p class="m-0 fw-bold">Daftar Tes</p>
	</div>
    @if($selection != null)
        @if(strtotime('now') < strtotime($selection->test_time))
        <div class="row">
            <!-- Alert -->
            <div class="col-12 mb-2">
                <div class="alert alert-danger fade show text-center" role="alert">
                    Tes akan dilaksanakan pada tanggal <strong>{{ setFullDate($selection->test_time) }}</strong> mulai pukul <strong>{{ date('H:i:s', strtotime($selection->test_time)) }}</strong>.
                </div>
            </div>
        </div>
        @endif
    @endif

    @if(Auth::user()->role_id == role('super-admin') || Auth::user()->role_id == role('hrd') || Auth::user()->role_id == role('employee') || Auth::user()->role_id == role('general'))
    <div class="content">
        @if(Session::get('message'))
        <div class="row">
            <!-- Alert -->
            <div class="col-12 mb-2">
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif
        <div class="row justify-content-center">
            @if(count($tests)>0)
                @foreach($tests as $key=>$test)
                <div class="col-auto">
                    <a href="/tes/{{ $test->code }}" class="btn btn-md btn-block btn-outline-dark d-flex border-0 fw-bold py-3 my-3">
                        <img width="100" class="me-3" src="{{asset('assets/images/icon/'.$images[$key])}}">
                        <p class="m-0 mb-2">{{ $test->name }}</p>
                    </a>
                </div>
                @endforeach
            @else
                <div class="col-12 mb-0">
                    <div class="alert alert-danger fade show text-center mb-0" role="alert">
                        Tidak ada tes yang akan dilakukan.
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

    @if(Auth::user()->role_id == role('applicant'))
        @if($selection)
            @if(strtotime('now') >= strtotime($selection->test_time))
            <div class="content">
                @if(Session::get('message'))
                <div class="row">
                    <!-- Alert -->
                    <div class="col-12 mb-2">
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row justify-content-start">
                    @if(count($tests)>0)
                        @foreach($tests as $key=>$test)
                        <div class="col-md-6 d-flex align-items-stretch col-lg-3">
							<a href="/tes/{{ $test->code }}" class="btn btn-md btn-block btn-outline-dark rounded-2 d-flex border py-3 my-2 w-100">
								<img width="80" class="me-3" src="{{asset('assets/images/icon/'.$images[$key])}}">
								<div class="text-start">
									<p class="m-0 fw-bold">{{ $test->name }}</p>
									<p>Tes kepribadian</p>
								</div>
							</a>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12 mb-0">
                            <div class="alert alert-danger fade show text-center mb-0" role="alert">
                                Tidak ada tes yang akan dilakukan.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        @endif
    @endif

    @if(Auth::user()->role_id == role('internship'))
        @if($check != null)
        <div class="row">
            <!-- Alert -->
            <div class="col-12 mb-2">
                <div class="alert alert-danger fade show text-center" role="alert">
                    Anda sudah melakukan tes.
                </div>
            </div>
        </div>
        @else
        <div class="content">
            @if(Session::get('message'))
            <div class="row">
                <!-- Alert -->
                <div class="col-12 mb-2">
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
            <div class="row justify-content-center">
                @if(count($tests)>0)
                    @foreach($tests as $key=>$test)
                    <div class="col-auto">
                        <a href="/tes/{{ $test->code }}" class="btn btn-md btn-block btn-outline-dark border-0 fw-bold py-3 my-3">
                            <p class="m-0 mb-2">{{ $test->name }}</p>
                            <img width="100" src="{{asset('assets/images/icon/'.$images[$key])}}">
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 mb-0">
                        <div class="alert alert-danger fade show text-center mb-0" role="alert">
                            Tidak ada tes yang akan dilakukan.
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif
    @endif
</section>
</div>
<style>
	body.bg-light{background-color:#fff!important}
</style>
<script>
function myFunction() {
    var greeting;
    var time = new Date().getHours();
    if (time < 12) {
        greeting = "Selamat Pagi";
    } else if (time >= 12 && time < 18) {
        greeting = "Selamat Siang";
    } else {
        greeting = "Selamat Malam";
    }
    document.getElementById("demo").innerHTML = greeting;
}
myFunction();
</script>
@endsection
