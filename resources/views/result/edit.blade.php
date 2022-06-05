@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/edit.css') }}">
@endsection( 'head-option' )

@section( 'contents' )
    <h1>トレーニング実績 編集画面</h1>
    @if ( session( 'front.result_edit_save_failure' ) == true )
      実績の編集が失敗しました<br>
    @endif
    
    <div class="toggle-test">
    
      <label for="toggle_all" class="label">全種目</label>
      @foreach ( $muscle_categories as $category )
      @if ( count( $list[ 'list_id_'.$category->id ] ) !== 0 )
      <label for="toggle{{ $category->id }}" class="label">
        {{ $category->name }}
      </label>
      @endif
      @endforeach
      <br>
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" class="invisible" name="muscle_category_id" id="toggle_all" value="0" @if( $muscle_category_id == 0 )checked @endif>
        <div class="switch-wrapper">
          <table border="1">
              <tr>
                <th>種目名</th>
                <th>負荷重量</th>
                <th>レップ数</th>
                <th>実施日</th>
              </tr>
          <form action="{{ route( 'result.edit.save' ) }}" method="post">
          @csrf
              @foreach ( $list_all as $set )
              <tr>
                <input type="hidden" name="result{{ $set->result_id }}" value="{{ $set->result_id }}">
                <td>
                  <select name="trainning_event_id{{ $set->result_id }}">
                    @foreach ( $list_trainning_event as $trainning_event )
                    <option value="{{ $trainning_event->id }}" @if ( $trainning_event->id == $set->trainning_event_id ) selected @endif>{{ $trainning_event->name }}</option>
                    @endforeach
                  </select>
                </td>
                <td><input type="number" min="0" step="0.01" name="weight{{ $set->result_id }}" value="{{ $set->trainning_weight }}"> kg</td>
                <td><input type="number" min="0" name="reps{{ $set->result_id }}" value="{{ $set->trainning_reps }}"></td>
                <td><input type="datetime-local" name="timestamp{{ $set->result_id }}" value="{{ str_replace( " " , "T" , $set->trainning_timestamp ) }}"></td>
              </tr>
              @endforeach
          </table>
        
          現在 {{ $list_all->currentPage() }} 目<br>
          @if ( $list_all->onFirstPage() === false )
            <a href="{{ route( 'result.edit' ) }}">最初のページ</a>
          @else
            最初のページ
          @endif
           / 
          @if ( $list_all->previousPageUrl() !== null )
            <a href="{{ $list_all->previousPageUrl() }}">前に戻る</a>
          @else
            前に戻る
          @endif
           / 
          @if ( $list_all->nextPageUrl() !== null )
            <a href="{{ $list_all->nextPageUrl() }}">次に進む</a>
          @else
            次に進む
          @endif
          <br>
          <button>保存する</button>
          </form>
        </div>
      </input>
      {{-- 全部位の実績一覧 ここまで --}}
      
      {{-- 各部位の実績一覧 ここから --}}
      @foreach ( $list as $list_category )
      @if ( count( $list_category ) !== 0 )
      <input type="radio" class="invisible" name="muscle_category_id" id="toggle{{ $list_category[0]->muscle_category_id }}" value="{{ $list_category[0]->muscle_category_id }}" @if( $list_category[0]->muscle_category_id == $muscle_category_id ) checked @endif>
        <div class="switch-wrapper">
          <table border="1">
            <tr>
                <th>種目名</th>
                <th>負荷重量</th>
                <th>レップ数</th>
                <th>実施日</th>
            </tr>
          <form action="{{ route( 'result.edit.save' ) }}" method="post">
          @csrf
            @foreach ( $list_category as $set )
            <tr>
              {{-- 編集対象の実績id --}}
              <input type="hidden" name="result{{ $set->result_id }}" value="{{ $set->result_id }}">
              <td>
                {{-- nameに実績idをつけて送信後に編集対象の値を特定できるようにする --}}
                <select name="trainning_event_id{{ $set->result_id }}">
                  {{-- トレーニング種目はドロップリストで編集する --}}
                  @foreach ( $list_trainning_event as $trainning_event )
                  <option value="{{ $trainning_event->id }}" @if ( $set->trainning_event_id == $trainning_event->id ) selected @endif>{{ $trainning_event->name }}</option>
                  @endforeach
                </select>
              </td>
              <td><input type="number" min="0" step="0.01" name="weight{{ $set->result_id }}" value="{{ $set->trainning_weight }}"> kg</td>
              <td><input type="number" min="0" name="reps{{ $set->result_id }}" value="{{ $set->trainning_reps }}"></td>
              <td><input type="datetime-local" name="timestamp{{ $set->result_id }}" value="{{ str_replace( " " , "T" , $set->trainning_timestamp ) }}"></td>
            </tr>
            @endforeach
          </table>
          
          現在 {{ $list_category->currentPage() }} 目<br>
          @if ( $list_category->onFirstPage() === false )
            <a href="{{ route( 'result.edit' ) }}">最初のページ</a>
          @else
            最初のページ
          @endif
           / 
          @if ( $list_category->previousPageUrl() !== null )
            <a href="{{ $list_category->previousPageUrl() }}">前に戻る</a>
          @else
            前に戻る
          @endif
           / 
          @if ( $list_category->nextPageUrl() !== null )
            <a href="{{ $list_category->nextPageUrl() }}">次に進む</a>
          @else
            次に進む
          @endif
          <br>
          <button>保存する</button>
          </form>
        </div>
        @endif
        @endforeach
      </input>
      {{-- 各部位の実績一覧 ここまで --}}
    </div>
    <hr>
    
    <a href="{{ route( 'result.list' ) }}" method="get">戻る</a>
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )