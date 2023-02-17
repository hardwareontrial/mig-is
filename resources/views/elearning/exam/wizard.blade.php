@extends('layouts.topbar.app')

@section('title','Ujian')

@section('brand','Liquid CO2 Manufacture')

@section('content')

<div class="container-fluid">

    <div class="card m-b-30">
        <div class="card-header">
            Info
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Judul</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-file"></i>&nbsp;&nbsp;{{ $schedule->collection['title'] }}</p>
                </div>
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Jumlah Soal</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ count($questions_count) }}</p>
                </div>
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Durasi</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ $schedule->collection['duration'] }} Menit</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-header">
            Soal
        </div>
        <div class="card-body">
            <form role="form" id="question-form">
            @csrf
                @foreach ($questions as $r)
                <div class="row">
                    <div class="col-md-1">
                        <span class="float-right">{{ $questions->currentPage() }}.</span> 
                    </div>
                    <div class="col-md-10">
                        <input type="hidden" value="{{ $schedule->id }}" id="schedule_id">
                        <input type="hidden" value="{{ $r->id }}" id="question_id">
                        {{ $r->question }}
                        <div class="radio radio-complete m-t-30">
                        <br>
                        @foreach ($r->answers->shuffle() as $a) 
                            &nbsp;<input type="radio" value="<?php echo $a->id ?>" name="<?php echo $r->id ?>" id="<?php echo $a->id ?>" @if (!empty($user_answer) && $user_answer->answer_id == $a->id) checked @endif>
                            <label for="<?php echo $a->id ?>"><?php echo $a->answer ?></label><br>
                        @endforeach
                        </div>
                        <br>
                    </div>
                </div>
                @endforeach
                <div class="row">
                    <div class="col-lg-3">
                        <small>Halaman</small><br>
                        <select class="form-control select2" style="width: 40%;" 
                            id="select_page">
                            <option value="">Pilih</option>
                            @foreach ($user_page as $r)
                                <option value="{{ $questions->url($r->page) }}" @if ($questions->currentPage() == $r->page) selected @endif>{{ $r->page }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-9 text-right">
                        @if ($questions->currentPage() != 1) 
                        <button class="btn btn-sm btn-icon waves-effect waves-light btn-primary mr-sm-2" id="back_exam">
                            <i class="fa fa-arrow-left"></i> 
                            <span class="bold">Kembali</span>
                        </button>
                        @endif
                        @if ($questions->currentPage() != $questions->total())
                        <button class="btn btn-sm btn-icon waves-effect waves-light btn-primary" id="next_exam">
                            <span class="bold">Berikut 
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </button>
                        @endif
                        @if ($questions->currentPage() == $questions->total())
                        <button class="btn btn-sm btn-icon waves-effect waves-light btn-success" id="finish_exam">
                            <span class="bold">Selesai <i class="fa fa-check"></i></span>
                        </button>
                        @endif
                        <button class="btn btn-sm btn-icon waves-effect waves-light btn-success" id="end_exam" hidden>
                            <span class="bold">End <i class="fa fa-check"></i></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</div>
@stop

@section('script2')
<script>
    $("#question-form input").on("change", function(e){
        e.preventDefault();
        // alert($('input[type=radio]:checked', '#question-form').val());
        // alert('{{ $questions->nextPageUrl() }}');
        // alert('{{ $questions->previousPageUrl() }}');
    });

    $('#select_page').on("change", function(e){
        e.preventDefault();
        var url = $('#select_page option:selected').val();
		var sparatorPos = [];        
		$.each(url.split(''),function(i,v){
			if(v === '-') sparatorPos.push(i);
		});
		
        //var sparatorPos = url.indexOf('-');
        
		var limitPos = url.indexOf('?');
        var lastPos = url.lastIndexOf();

        if (sparatorPos.length == 1){
            window.location.href = url.slice(0,sparatorPos[sparatorPos.length-1]) + url.slice(limitPos);
            // window.location.href = url;
        } else {
            // window.location.href = url.slice(0,sparatorPos[sparatorPos.length-1]) + url.slice(limitPos);
            window.location.href = url;
        }
    });

    $("#next_exam").on("click", function(e){
        e.preventDefault();
        var isChecked = $('input[type=radio]', '#question-form').is(":checked")
        if (isChecked) {
            var schedule_id = $('#schedule_id').val();
            var answer_id = $('input[type=radio]:checked', '#question-form').val();
            var question_id = $('#question_id').val();
            var page_number = "{{ $questions->currentPage() }}";                                                
                        
            $.ajax({
                type:'POST',
                // url: '{{ url('/') }}' + '/okm/exam/store_answer/'+ schedule_id +'/'+ question_id +'-'+answer_id,
                url: '{{ url('/') }}' + '/okm/exam/store_answer/'+ schedule_id +'-'+ question_id +'-'+answer_id+'-'+page_number,
                success:function(){                    
                    var url = "{{ $questions->nextPageUrl() }}";
					var sparatorPos = [];
					$.each(url.split(''),function(i,v){
						if(v === '-') sparatorPos.push(i);                                                
                    });                                     
					
                    var limitPos = url.indexOf('?');
                    var lastPos = url.lastIndexOf();                    

                    if (sparatorPos.length == 1){
                        //window.location.href = "{{ $questions->nextPageUrl() }}";
                        window.location.href = url.slice(0,sparatorPos[sparatorPos.length-1]) + url.slice(limitPos);

                    } else {
                        // window.location.href = url.slice(0,sparatorPos[sparatorPos.length-1]) + url.slice(limitPos);
                        window.location.href = "{{ $questions->nextPageUrl() }}";
                    }
                }
            });        
        } else {
            alert("Jawaban belum dipilih");
        }
    });

    $("#back_exam").on("click", function(e){
        e.preventDefault();
        var isChecked = $('input[type=radio]', '#question-form').is(":checked")
        if (isChecked) {
            var schedule_id = $('#schedule_id').val();
            var answer_id = $('input[type=radio]:checked', '#question-form').val();
            var question_id = $('#question_id').val();
            var page_number = "{{ $questions->currentPage() }}";

            $.ajax({
                type:'POST',
                url: '{{ url('/') }}' + '/okm/exam/store_answer/'+ schedule_id +'-'+ question_id +'-'+answer_id+'-'+page_number,
                success:function(){
                    var url = "{{ $questions->previousPageUrl() }}";
                    var sparatorPos = [];
					$.each(url.split(''),function(i,v){
						if(v === '-') sparatorPos.push(i);
					});
					
                    var limitPos = url.indexOf('?');
                    var lastPos = url.lastIndexOf();

                    if (sparatorPos.length == 1){
                        window.location.href = url.slice(0,sparatorPos[sparatorPos.length-1]) + url.slice(limitPos);
                    } else {                        
                        window.location.href = "{{ $questions->previousPageUrl() }}";
                    }
                }
            });
        } else {
            alert("Jawaban belum dipilih");
        }
    });

    $("#finish_exam").on("click", function(e){
        e.preventDefault();
        var isChecked = $('input[type=radio]', '#question-form').is(":checked")
        if (isChecked) {
            var schedule_id = $('#schedule_id').val();
            var answer_id = $('input[type=radio]:checked', '#question-form').val();
            var question_id = $('#question_id').val();
            var page_number = "{{ $questions->currentPage() }}";
      
            $.ajax({
                type:'POST',
                url: '{{ url('/') }}' + '/okm/exam/store_answer/'+ schedule_id +'-'+ question_id +'-'+answer_id+'-'+page_number,
                success:function(){
                    window.location.href = "{{ route('exam.result','') }}/"+schedule_id;
                }
            });
        } else {
            alert("Jawaban belum dipilih");
        }
    });

    $("#end_exam").on("click", function(e){
        e.preventDefault();
        var schedule_id = $('#schedule_id').val();
        window.location.href = "{{ route('exam.result','') }}/"+schedule_id;
    });
</script>
@stop

<?php
    $date = $timer_end;
    $exp_date = strtotime($date);
    $now = time();

    if ($now < $exp_date) {
?>

@section('script')
<script>
    var server_end = <?php echo $exp_date; ?> * 1000;
    var server_now = <?php echo time(); ?> * 1000;
    var client_now = new Date().getTime();
    var end = server_end - server_now + client_now; // this is the real end time

    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour *24
    var timer;
    
    function showRemaining()
    {
        var now = new Date();
        var distance = end - now;
        if (distance < 0 ) {
            clearInterval( timer );
            //document.getElementById('#timer').innerHTML = 'EXPIRED!';
            $('#timer').html('EXPIRED');
            $("#end_exam").trigger( "click" );
            
            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor( (distance % _day ) / _hour );
        if((hours + '').length == 1){
            hours = '0' + hours;
        }
        var minutes = Math.floor( (distance % _hour) / _minute );
        if((minutes + '').length == 1){
            minutes = '0' + minutes;
        }
        var seconds = Math.floor( (distance % _minute) / _second );
        if((seconds + '').length == 1){
            seconds = '0' + seconds;
        }

        //var countdown = document.getElementById('#timer');
        var countdown = $('#timer').val();
        countdown.innerHTML = '';
        if (days) {
            //countdown.innerHTML += 'Days: ' + days + '<br />';
        }
        $('#timer').html(hours+':'+minutes+':'+seconds);
        
        /* countdown.innerHTML += 'Hours: ' + hours+ '<br />';
        countdown.innerHTML += 'Minutes: ' + minutes+ '<br />';
        countdown.innerHTML += 'Seconds: ' + seconds+ '<br />'; */
    }

    timer = setInterval(showRemaining, 1000);
</script>
@stop

<?php
    }
?>
