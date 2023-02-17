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
                    </p><p class="font-montserrat bold"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ count($questions) }}</p>
                </div>
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Durasi</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ $schedule->duration }} Menit</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-header">
            Soal
        </div>
        <div class="card-body">
            <form role="form" method="post" action="{{ route('exam.score',$schedule->id) }}">
            @csrf
                <?php $no = 1; ?>
                @foreach ($questions as $r)
                <div class="row">
                    <div class="col-md-1">
                        <span class="float-right">{{ $no }}.</span> 
                    </div>
                    <div class="col-md-10">
                        {{ $r->question }}
                        <div class="radio radio-complete m-t-30">
                        <br>
                        @foreach ($r->answers->shuffle() as $a) 
                            &nbsp;<input type="radio" value="<?php echo $a->id ?>" name="<?php echo $r->id ?>" id="<?php echo $a->id ?>">
                            <label for="<?php echo $a->id ?>"><?php echo $a->answer ?></label><br>
                        @endforeach
                        </div>
                        <br>
                    </div>
                </div>
                <?php $no++; ?>
                @endforeach
                <button class="btn btn-complete btn-cons m-t-30 pull-right" id="finish_exam" type="submit"><i class="pg-save"></i> <span class="bold">Finish</span>
                            </button>
            </form>
        </div>
    </div>
    
</div>
@stop

<?php
    $date = $date_time_end;
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
            $("#finish_exam").trigger( "click" );
            
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
