@extends( 'layout' )

@section( 'contents' )
    <h1>トレーニング実績一覧</h1>
    <table border="1">
        <tr>
            <th>種目名</th>
            <th>負荷重量</th>
            <th>レップ数</th>
            <th>実施日</th>
        </tr>
        @foreach ( $list as $set )
        <tr>
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
    <hr>
    
    <a href="{{ route( 'result.record' ) }}" method="get">戻る</a>
    <a href="" method="get">編集</a>
    <a href="" method="get">削除</a>
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )