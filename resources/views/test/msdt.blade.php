@extends('template/main')

@section('content')
<div class="bg-theme-1 bg-header">
    <div class="container text-center text-white">
        <h3>{{ $packet->name }}</h3>
    </div>
</div>
<div class="custom-shape-divider-top-1617767620">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M0,0V7.23C0,65.52,268.63,112.77,600,112.77S1200,65.52,1200,7.23V0Z" class="shape-fill"></path>
    </svg>
</div>
<div class="container main-container">
    @if($selection != null)
	    @if(strtotime('now') < strtotime($selection->test_time))
	    <div class="row">
	        <!-- Alert -->
	        <div class="col-12 mb-2">
	            <div class="alert alert-danger fade show text-center" role="alert">
	                Tes akan dilaksanakan pada tanggal <strong>{{ \Ajifatur\Helpers\DateTimeExt::full($selection->test_time) }}</strong> mulai pukul <strong>{{ date('H:i:s', strtotime($selection->test_time)) }}</strong>.
	            </div>
	        </div>
	    </div>
	    @endif
    @endif
    @if($selection == null || ($selection != null && strtotime('now') >= strtotime($selection->test_time)))
	<div class="row" style="margin-bottom:100px">
	    <div class="col-12">
			<form id="form" method="post" action="/tes/{{ $path }}/store">
			    @csrf
			    <input type="hidden" name="path" value="{{ $path }}">
			    <input type="hidden" name="packet_id" value="{{ $packet->id }}">
			    <input type="hidden" name="test_id" value="{{ $test->id }}">
				<div class="">
					<div class="row">
					    @foreach($questions->description as $question)
					    <div class="col-12">
                            <div class="card soal rounded-1 mb-3">
                      			<div class="card-header bg-transparent">
					    			<span class="num fw-bold"><i class="fa fa-edit"></i> Soal {{$question['id']}}</span>
					    		</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="form-check-input radio{{$question['id']}}"
                                                        id="customRadio{{$question['id']}}a" name="p[{{$question['id']}}]"
                                                        value="A">
                                                    <label class="custom-control-label text-justify" for="customRadio{{$question['id']}}a">
                                                        <span>
                                                            {{$question['pilihan1']}}
                                                        </span>
                                                    </label>
                                                </div>
            
                                                <div class="custom-control custom-radio mt-3">
                                                    <input type="radio" class="form-check-input radio{{$question['id']}}"
                                                        id="customRadio{{$question['id']}}b" name="p[{{$question['id']}}]"
                                                        value="B">
                                                    <label class="custom-control-label text-justify" for="customRadio{{$question['id']}}b">
                                                        <span>
                                                            {{$question['pilihan2']}}
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
            
                                </div>
                            </div>
                        </div>
						@endforeach
					</div>
				</div>
			</form>
    	</div>
	</div>
	<nav class="navbar navbar-expand-lg fixed-bottom navbar-light bg-white shadow">
		<div class="container">
			<ul class="navbar nav ms-auto">
				<li class="nav-item">
					<span id="answered">0</span>/<span id="total"></span> Soal Terjawab
				</li>
				<li class="nav-item ms-3">
					<a href="#" class="text-secondary" data-bs-toggle="modal" data-bs-target="#tutorialModal" title="Tutorial"><i class="fa fa-question-circle" style="font-size: 1.5rem"></i></a>
				</li>
				<li class="nav-item ms-3">
					<button class="btn btn-md btn-primary text-uppercase " id="btn-submit" disabled>Submit</button>
				</li>
			</ul>
		</div>
	</nav>
	<div class="modal fade" id="tutorialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="exampleModalLabel">
	        			<span class="bg-warning rounded-1 text-center px-3 py-2 me-2"><i class="fa fa-lightbulb-o text-dark" aria-hidden="true"></i></span> 
	        			Tutorial Tes
	        		</h5>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      		</div>
		      	<div class="modal-body">
		      	    <p>Pada tes ini, Anda akan membaca sejumlah pernyataan mengenai tindakan yang mungkin Anda lakukan dalam tugas Anda di perusahaan.</p>
		        	<p>Tes ini terdiri dari 64 Soal dan 1 jawaban setiap soal. Jawab secara jujur dan spontan. Estimasi waktu pengerjaan adalah 5-10 menit.</p>
		        	<p>Anda diminta untuk memilih salah satu pernyataan yang paling sesuai dengan diri Anda , Atau paling mungkin Anda lakukan.</p>
		        	<p style="margin-bottom: .5rem;"><strong>Perhatikan contoh berikut:</strong></p>
		        	<ul style="list-style: upper-alpha; font-weight: bold; padding-left: 2rem;">
		        		<li>Saya datang ke kantor lebih awal bila sedang banyak pekerjaan</li>
		        		<li>Saya bersedia bekerja lembur bila tugas saya belum selesai</li>
		        	</ul>
		        	<p>Manakah dari dua pernyataan tersebut yang paling mungkin Anda lakukan. Jika Anda lebih memilih datang lebih awal daripada bekerja lembur maka pilihlah pernyataan <strong>A</strong>. Tetapi bila Anda lebih memilih bekerja lembur , maka pilihlah <strong>B</strong>.</p>
		        	<p>Karena kedua pernyataan selalu disajikan berpasangan, mungkin saya Anda memilih pernyataan <strong>A</strong> maupun <strong>B</strong> sekaligus. Dalam hal ini , Anda tetap diminta untuk hanya memilih satu pernyataan.</p>
		      	    <p>Ini bukan suatu tes. Disini tidak ada jawaban “benar” atau “salah”. Apapun yang Anda pilih , hendaknya sungguh-sungguh menggambarkan diri Anda.</p>
		      	</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-primary text-uppercase " data-bs-dismiss="modal">Mengerti</button>
	      		</div>
	    	</div>
	  	</div>
	</div>
    @endif
</div>
@endsection

@section('js-extra')
<script type="text/javascript">
	$(document).ready(function(){
		$("#tutorialModal").modal("toggle");
	    totalQuestion();
	});

	// Change value
	$(document).on("change", "input[type=radio]", function(){
		// Count answered question
		countAnswered();

		// Enable submit button
		countAnswered() >= totalQuestion() ? $("#btn-submit").removeAttr("disabled") : $("#btn-submit").attr("disabled", "disabled");
	});

	// Count answered question
	function countAnswered(){
		var total = 0;
		$(".num").each(function(key, elem){
			var value = $(".radio" + (key+1) + ":checked").val();
			value != undefined ? total++ : "";
		});
		$("#answered").text(total);
		return total;
	}

	// Total question
	function totalQuestion(){
		var totalRadio = $("input[type=radio]").length;
		var pointPerQuestion = 2;
		var total = totalRadio / pointPerQuestion;
		$("#total").text(total);
		return total;
	}
</script>
@endsection

@section('css-extra')
<style type="text/css">
	.modal .modal-body {font-size: 14px;}
	.table {margin-bottom: 0;}
</style>
@endsection