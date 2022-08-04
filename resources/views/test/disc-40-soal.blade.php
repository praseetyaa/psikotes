@extends('template/main')

@section('content')
<div class="bg-theme-1 bg-header">
	<h3 class="m-0 text-center text-white">{{ $packet->nama_paket }}</h3>
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
	<div class="row" style="margin-bottom:100px">
	    <div class="col-12">
			<form id="form" method="post" action="/tes/{{ $path }}/store">
			    {{ csrf_field() }}
			    <input type="hidden" name="path" value="{{ $path }}">
			    <input type="hidden" name="packet_id" value="{{ $packet->id }}">
			    <input type="hidden" name="test_id" value="{{ $test->id }}">
				<div class="container-fluid">
					<div class="row">
					    @foreach($questions as $question)
					    <div class="col-lg-6 mb-3">
					    	<div class="card soal rounded-1">
					    		<div class="card-header bg-transparent">
					    			<span class="num fw-bold" data-id="{{ $question->number }}"><i class="fa fa-edit"></i> Soal {{ $question->number }}</span>
					    		</div>
    							<div class="card-body">
    								<div class="row">
    									<div class="col-2"><i class="fa fa-thumbs-up text-success"></i></div>
	    								<div class="col-2"><i class="fa fa-thumbs-down text-danger"></i></div>
	    								<div class="col-8"><span class="fw-bold">Karakteristik</span></div>
	    							</div>
	    							<div class="row">
	    								<div class="col-2"><input type="radio" name="m[{{ $question->number }}]" class="form-check-input {{ $question->number }}m" value="A"></div>
	    								<div class="col-2"><input type="radio" name="l[{{ $question->number }}]" class="form-check-input {{ $question->number }}l" value="A"></div>
	    								<div class="col-8"><span>{{ $question->description[0]['pilihan']['A'] }}</span></div>
	    							</div>
	    							<div class="row">
	    								<div class="col-2"><input type="radio" name="m[{{ $question->number }}]" class="form-check-input {{ $question->number }}m" value="B"></div>
	    								<div class="col-2"><input type="radio" name="l[{{ $question->number }}]" class="form-check-input {{ $question->number }}l" value="B"></div>
	    								<div class="col-8"><span>{{ $question->description[0]['pilihan']['B'] }}</span></div>
	    							</div>
	    							<div class="row">
	    								<div class="col-2"><input type="radio" name="m[{{ $question->number }}]" class="form-check-input {{ $question->number }}m" value="C"></div>
	    								<div class="col-2"><input type="radio" name="l[{{ $question->number }}]" class="form-check-input {{ $question->number }}l" value="C"></div>
	    								<div class="col-8"><span>{{ $question->description[0]['pilihan']['C'] }}</span></div>
	    							</div>
	    							<div class="row">
	    								<div class="col-2"><input type="radio" name="m[{{ $question->number }}]" class="form-check-input {{ $question->number }}m" value="D"></div>
	    								<div class="col-2"><input type="radio" name="l[{{ $question->number }}]" class="form-check-input {{ $question->number }}l" value="D"></div>
	    								<div class="col-8"><span>{{ $question->description[0]['pilihan']['D'] }}</span></div>
	    							</div>
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
					<button class="btn btn-md btn-primary text-uppercase" id="btn-submit" disabled>Submit</button>
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
		        	<p>Tes ini terdiri dari 40 Soal dan 2 jawaban setiap soal. Jawab secara jujur dan spontan. Estimasi waktu pengerjaan adalah 5-10 menit.</p>
		        	<ul>
		        		<li>Pelajari semua jawaban pada setiap pilihan</li>
		        		<li>Pilih satu jawaban yang <strong>paling mendekati diri kamu</strong> (<i class="fa fa-thumbs-up text-success"></i>)</li>
		        		<li>Pilih satu jawaban yang <strong>paling tidak mendekati diri kamu</strong> (<i class="fa fa-thumbs-down text-danger"></i>)</li>
		        	</ul>
		        	<p>Pada setiap soal harus memiliki jawaban <u>satu</u> <strong>paling mendekati diri kamu</strong> dan hanya <u>satu</u> <strong>paling tidak mendekati diri kamu</strong>.</p>
		        	<p>Terkadang akan sedikit sulit untuk memutuskan jawaban yang terbaik. Ingat, tidak ada jawaban yang benar atau salah dalam tes ini.</p>
		        	<p>Maka pikirkan baik-baik.</p>
		      	</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-primary" data-bs-dismiss="modal">MENGERTI</button>
	      		</div>
	    	</div>
	  	</div>
	</div>
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
		var className = $(this).attr("class");
		var currentNumber = className.replace(/\D/g,'');
		var currentCode = className.charAt(className.length-1);
		var oppositeCode = currentCode == "m" ? "l" : "m";
		var currentValue = $(this).val();
		var oppositeValue = $("." + currentNumber + oppositeCode + ":checked").val();

		// Detect if one question has same answer
		if(currentValue == oppositeValue){
			$("." + currentNumber + oppositeCode + ":checked").prop("checked", false);
			oppositeValue = $("." + currentNumber + oppositeCode + ":checked").val();
		}

		// Count answered question
		countAnswered();

		// Enable submit button
		countAnswered() >= totalQuestion() ? $("#btn-submit").removeAttr("disabled") : $("#btn-submit").attr("disabled", "disabled");
	});

	// Count answered question
	function countAnswered(){
		var total = 0;
		$(".num").each(function(key, elem){
			var id = $(elem).data("id");
			var mValue = $("." + id + "m:checked").val();
			var lValue = $("." + id + "l:checked").val();
			mValue != undefined && lValue != undefined ? total++ : "";
		});
		$("#answered").text(total);
		return total;
	}

	// Total question
	function totalQuestion(){
		var totalRadio = $("input[type=radio]").length;
		var pointPerQuestion = 4;
		var total = totalRadio / pointPerQuestion / 2;
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