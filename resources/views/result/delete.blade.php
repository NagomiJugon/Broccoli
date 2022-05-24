@extends( 'layout' )

@section( 'contents-css' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/delete.css') }}">
@endsection( 'contents-css' )

@section( 'contents' )
    <h1>トレーニング実績削除</h1>
    <table border="1">
      <tr>
        <th>削除対象</th>
        <th>種目名</th>
        <th>負荷重量</th>
        <th>レップ数</th>
        <th>実施日</th>
      </tr>
    <form action="{{ route( 'result.delete.save' ) }}" method="post">
    @csrf
      @foreach ( $list as $set )
      <tr class="result-record">
        <td><input type="checkbox" name="trainning_set_id{{ $set->trainning_set_id }}" value="{{ $set->trainning_set_id }}"></td>
        <td>{{ $set->trainning_events_name }}</td>
        <td>{{ $set->trainning_weight }}  kg</td>
        <td>{{ $set->trainning_reps }}</td>
        <td>{{ $set->trainning_set_datetime }}</td>
      </tr>
      @endforeach
    </table>
    
    現在 {{ $list->currentPage() }} 目<br>
    @if ( $list->onFirstPage() === false )
      <a href="{{ route( 'result.list' ) }}">最初のページ</a>
    @else
      最初のページ
    @endif
     / 
    @if ( $list->previousPageUrl() !== null )
      <a href="{{ $list->previousPageUrl() }}">前に戻る</a>
    @else
      前に戻る
    @endif
     / 
    @if ( $list->nextPageUrl() !== null )
      <a href="{{ $list->nextPageUrl() }}">次に進む</a>
    @else
      次に進む
    @endif
    <br>
    <button onclick='return confirm( "選択された実績を削除します。\nこの操作は戻せません。\n削除してよろしいですか？" )'>削除する</button>
    </form>
    <hr>
    
    <a href="{{ route( 'result.list' ) }}" method="get">戻る</a>
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
    
@endsection( 'contents' )