@extends('template/main')

@section('content')
<div class="bg-theme-1 bg-header">
    <h3 class="m-0 text-center text-white">{{ $packet->name }}</h3>
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
			    <input type="hidden" name="path" value="{{ $path }}">
			    <input type="hidden" name="packet_id" value="{{ $packet->id }}">
			    <input type="hidden" name="test_id" value="{{ $test->id }}">
        		@csrf
        		<div class="row justify-content-center">
                    @php $letters = ['A','B','C','D','E','F','G','H','I']; @endphp
                    @foreach($questions as $keysoal=>$q)
        			<div class="col-lg-8 mx-auto" style="margin-top: 20px;">
        				<div class="card soal rounded-1">
                            <div class="card-header bg-transparent">
                                <span class="num fw-bold" data-id="{{ $q->number }}"><i class="fa fa-edit"></i> Soal {{ $q->number }}</span>
                            </div>
                            @php
                                $questions_array = json_decode($q->description, true);
                            @endphp
        					<div class="card-body">
        						<table class="table table-sm table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="200">Laki-Laki</th>
                                            <th width="100">{{ $letters[$keysoal] }}</th>
                                            <th width="200">Perempuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($questions_array['L'] as $key=>$occupation)
                                        <tr>
                                            <td>{{ $questions_array['L'][$key] }}</td>
                                            <td>
                                                <select name="score[{{ $q->number }}][]" class="form-select form-select-sm select-score" data-id="{{ $q->number }}" data-key="{{ $key }}">
                                                    <option value="" disabled selected>--Pilih--</option>
                                                    @for($i=1; $i<=count($questions_array['L']); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td>{{ $questions_array['P'][$key] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
        		</div>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Tulislah dibawah ini tiga (3) macam pekerjaan yang paling ingin anda lakukan atau paling anda sukai (tidak harus pekerjaan yang tercantum di dalam daftar yang ada):</label>
                            @for($i=1; $i<=3; $i++)
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">({{ $i }})</span>
                                <input type="text" name="occupations[]" class="form-control">
                            </div>
                            @endfor
                        </div>
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
                    <p>Dibawah ini anda akan menemui daftar-daftar berbagai macam pekerjaan yang tersusun dalam berbagai kelompok. Setiap kelompok terdiri dari 12 macam pekerjaan. Setiap pekerjaan merupakan keahlian khusus yang memerlukan latihan atau pendidikan keahlian sendiri. Mungkin hanya beberapa diantaranya yang anda sukai. Disini anda diminta untuk memilih pekerjaan mana yang ingin anda lakukan atau pekerjaan mana yang anda sukai, terlepas dari besarnya upah gaji yang akan anda terima. Juga terlepas apakah anda berhasil atau tidak dalam mengerjakan pekerjaan tersebut.</p>
                    <p>Tugas anda adalah mencantumkan nomor atau angka pada tiap pekerjaan dalam kelompok-kelompok yang tersedia. Berikanlah nomor (angka) 1 untuk pekerjaan yang paling anda sukai diantara ke 12 pekerjaan yang tersedia pada setiap kelompok, dan dilanjutkan dengan pemberian nomor 2, 3, dan seterusnya berurutan berdasarkan besarnya kadar kesukaan/minat anda terhadap pekerjaan itu, dan nomor/angka 12 anda cantumkan untuk pekerjaan yang paling tidak disukai dari daftar pekerjaan yang tersedia pada kelompok-kelompok tersebut.</p>
                    <p>Bekerjalah secepatnya dan tulislah nomor-nomor (angka-angka) sesuai dengan kesan dan keinginan anda yang pertama muncul.</p>
                    <p>Jika anda <strong>Perempuan</strong> gunakanlah daftar pekerjaan yang tersusun di bagian kanan pada setiap kelompok.</p>
                    <p>Jika anda <strong>Laki-laki</strong>, gunakanlah daftar pekerjaan yang tersusun di bagian kiri pada setiap kelompok. Selamat bekerja !</p>
		      	</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-primary text-uppercase " data-bs-dismiss="modal">MENGERTI</button>
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

    // Select score
    $(document).on("change", ".select-score", function() {
        var id = $(this).data("id");
        var key = $(this).data("key");
        var value = $(this).val();
        var arrayScore = [];
        $(".select-score[data-id="+ id +"]").each(function(index, elem) {
            arrayScore.push($(elem).val());
        });

        // Count occurences
        if(countOccurrences(value, arrayScore) > 1) {
            // Change other scores to be null
            $(".select-score[data-id="+ id +"]").each(function(index, elem) {
                if(value === $(elem).val() && index !== key)
                    $(elem).val(null);
            });
        }

        // Count answered question
        countAnswered();

        // Enable submit button
        countAnswered() >= totalQuestion() ? $("#btn-submit").removeAttr("disabled") : $("#btn-submit").attr("disabled", "disabled");
    });

    // Count occurences
    function countOccurrences(val, arr) {
        var occurences = 0;
        for(var i=0; i<arr.length; i++) {
            if(val === arr[i]) occurences++;
        }
        return occurences;
    }

	// Count answered questions
	function countAnswered() {
		var total = 0;
		$(".num").each(function(key, elem) {
			var id = $(elem).data("id");
            var selected = 0;
            $(".select-score[data-id="+ id +"]").each(function(index, elem) {
                if($(elem).val() !== null) selected++;
            });
            if(selected === $(".select-score[data-id="+ id +"]").length) total++;
		});
		$("#answered").text(total);
		return total;
	}

	// Total questions
	function totalQuestion() {
		var total = $(".num").length;
		$("#total").text(total);
		return total;
	}
</script>
@endsection

@section('css-extra')
<style type="text/css">
	.modal .modal-body {font-size: 14px;}
	.table {margin-bottom: 0;}
    .table thead tr th {text-align: center;}
    .soal {font-size: 85%;}
</style>
@endsection