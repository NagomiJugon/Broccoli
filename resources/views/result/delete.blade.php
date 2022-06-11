@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/edit.css') }}">
@endsection( 'head-option' )

@section( 'contents' )
    <div class="message">
      <h1>トレーニング実績 削除画面</h1>
      @if ( session( 'front.result_delete_save_null' ) == true )
        <br><span class="failure">削除するデータが選択されていません</span>
      @endif
      @if ( session( 'front.result_delete_save_failure' ) == true )
        <br><span class="failure">実績の削除が失敗しました</span>
      @endif
    </div>
    
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
      <input type="radio" class="invisible" name="muscle_category_id" id="toggle_all" value="0" @if( $muscle_category_id == 0 ) checked @endif>
        {{-- 非表示範囲はここから --}}
        <div class="switch-wrapper">
          <table border="1">
              <tr>
                <th>削除対象</th>
                <th>種目名</th>
                <th>負荷重量</th>
                <th>レップ数</th>
                <th>実施日</th>
              </tr>
              {{-- 削除対象フォーム　ここから --}}
              <form action="{{ route( 'result.delete.save' ) }}" method="post">
              @csrf
              @foreach ( $list_all as $set )
              <tr>
                <td><input type="checkbox" name="result{{ $set->result_id }}" value="{{ $set->result_id }}"></td>
                <td>{{ $set->trainning_event_name }}</td>
                <td>{{ $set->trainning_weight }}  kg</td>
                <td>{{ $set->trainning_reps }}</td>
                <td>{{ $set->trainning_timestamp }}</td>
              </tr>
              @endforeach
          </table>
        
          現在 {{ $list_all->currentPage() }} 目<br>
          @if ( $list_all->onFirstPage() === false )
            <a href="{{ route( 'result.delete' ) }}">最初のページ</a>
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
          <button onclick='return confirm( "選択された実績を削除します。\nこの操作は戻せません。\n削除してよろしいですか？" )'>削除する</button>
          </form>
          {{-- 削除対象フォーム　ここまで --}}
        </div>
        {{-- 非表示範囲はここまで --}}
      </input>
      {{-- 全部位の実績一覧 ここまで --}}
      
      {{-- 各部位の実績一覧 ここから --}}
      @foreach ( $list as $list_category )
      @if ( count( $list_category ) !== 0 )
      <input type="radio" class="invisible" name="muscle_category_id" id="toggle{{ $list_category[0]->muscle_category_id }}" value="{{ $list_category[0]->muscle_category_id }}" @if( $list_category[0]->muscle_category_id == $muscle_category_id ) checked @endif>
        {{-- 非表示範囲はここから --}}
        <div class="switch-wrapper">
          <table border="1">
            <tr>
              <th>削除対象</th>
              <th>種目名</th>
              <th>負荷重量</th>
              <th>レップ数</th>
              <th>実施日</th>
            </tr>
            {{-- 削除対象フォーム　ここから --}}
            <form action="{{ route( 'result.delete.save' ) }}" method="post">
            @csrf
            @foreach ( $list_category as $set )
            <tr>
              <td><input type="checkbox" name="result{{ $set->result_id }}" value="{{ $set->result_id }}"></td>
              <td>{{ $set->trainning_event_name }}</td>
              <td>{{ $set->trainning_weight }}  kg</td>
              <td>{{ $set->trainning_reps }}</td>
              <td>{{ $set->trainning_timestamp }}</td>
            </tr>
            @endforeach
          </table>
          
          現在 {{ $list_category->currentPage() }} 目<br>
          @if ( $list_category->onFirstPage() === false )
            <a href="{{ route( 'result.delete' ) }}">最初のページ</a>
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
          <button onclick='return confirm( "選択された実績を削除します。\nこの操作は戻せません。\n削除してよろしいですか？" )'>削除する</button>
          </form>
          {{-- 削除対象フォーム　ここまで --}}
        </div>
        {{-- 非表示範囲はここまで --}}
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