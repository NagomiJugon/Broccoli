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
  <form action="{{ route( 'result.edit.save' ) }}" method="post">
  @csrf
        @foreach ( $list_result as $result )
        <tr>
          <input type="hidden" name="result{{ $result->trainning_set_id }}" value="{{ $result->result_id }}">
          <input type="hidden" name="trainning_set_id{{ $result->trainning_set_id }}" value="{{ $result->trainning_set_id }}">
          <td>
            <select name="trainning_event_id{{ $result->trainning_set_id }}">
              @foreach ( $list_trainning_event as $trainning_event )
              <option value="{{ $trainning_event->id }}" @if ( $trainning_event->id === $result->trainning_event_id ) selected @endif>{{ $trainning_event->name }}</option>
              @endforeach
            </select>
          </td>
          <td><input type="number" min="0" step="0.01" name="weight{{ $result->trainning_set_id }}" value="{{ $result->trainning_weight }}"> kg</td>
          <td><input type="number" min="0" name="reps{{ $result->trainning_set_id }}" value="{{ $result->trainning_reps }}"></td>
          {{-- <td>{{ $result->trainning_set_datetime }}</td> --}}
          <td><input type="datetime-local" name="timestamp{{ $result->trainning_set_id }}" value="{{ str_replace( " " , "T" , $result->trainning_set_datetime ) }}"></td>
        </tr>
        @endforeach
    </table>
    
    現在 {{ $list_result->currentPage() }} 目<br>
    @if ( $list_result->onFirstPage() === false )
      <a href="{{ route( 'result.edit' ) }}">最初のページ</a>
    @else
      最初のページ
    @endif
     / 
    @if ( $list_result->previousPageUrl() !== null )
      <a href="{{ $list_result->previousPageUrl() }}">前に戻る</a>
    @else
      前に戻る
    @endif
     / 
    @if ( $list_result->nextPageUrl() !== null )
      <a href="{{ $list_result->nextPageUrl() }}">次に進む</a>
    @else
      次に進む
    @endif
    <br>
    <button>保存する</button>
    </form>
    <hr>
    
    <a href="{{ route( 'result.list' ) }}" method="get">戻る</a>
    
@endsection( 'contents' )