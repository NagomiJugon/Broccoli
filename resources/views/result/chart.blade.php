@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/list2.css') }}">
@endsection( 'head-option' )

@section( 'contents' )
    <h1>トレーニング実績 チャート</h1>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <style>
      .chart {max-width:640px;max-height:280px;}
    </style>
    
    {{-- aa --}}
    @foreach ( $muscle_categories as $muscle_category )
      @if ( $muscle_category->id == $muscle_category_id )
        <h2>トレーニング部位：{{ $muscle_category->name }}</h2>
      @endif
    @endforeach
    
    {{-- トレーニング種目ごとのチャートを作成する --}}
    @foreach ( $trainning_events as $trainning_event )
    <h3>{{ $trainning_event->name }}</h3>
    <canvas class="chart" id="ex_chart{{ $trainning_event->id }}"></canvas>
    
    <script>
    var ctx = document.getElementById( "ex_chart{{ $trainning_event->id }}" );
    var labels = @json( $chart_list[ "labels$trainning_event->id" ] );
    var data = @json( $chart_list[ "data$trainning_event->id" ] );
    
    var data = {
        labels: labels,
        datasets: [{
            data: data,
            borderColor: 'rgba(255, 100, 100, 1)',
            lineTension: 0.3,
            fill: true,
            borderWidth: 3
        }]
    };
    
    var options = {
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 10,
          },
          suggestedMax: 50
        }
      }
    };
    
    var ex_chart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
    </script>
    @endforeach
    <hr>
    
    <a href="{{ route( 'result.list' ) }}" method="get">戻る</a><br>
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )