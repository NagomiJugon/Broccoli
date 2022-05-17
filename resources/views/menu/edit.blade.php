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
        @foreach ( $list_result as $result )
        <tr>
            <td>
              <select name="trainning_event_id">
                @foreach ( $list_trainning_event as $trainning_event )
                <option value="{{ $trainning_event->id }}" @if ( $trainning_event->id === $result->trainning_event_id ) selected @endif>{{ $trainning_event->name }}</option>
                @endforeach
              </select>
              {{ $result->trainning_events_name }}
            </td>
            <td>{{ $result->trainning_weight }}  kg</td>
            <td>{{ $result->trainning_reps }}</td>
            <td>{{ $result->trainning_set_datetime }}</td>
        </tr>
        @endforeach
    </table>
    
    現在 {{ $list->currentPage() }} 目<br>
    @if ( $list->onFirstPage() === false )
      <a href="/task/list">最初のページ</a>
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
    
    <button type="button" onclick="history.back()">戻る</button>
    <a href="" method="get">編集</a>
    <a href="" method="get">削除</a>
    
@endsection( 'contents' )