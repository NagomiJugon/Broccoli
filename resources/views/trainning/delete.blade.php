@extends( 'layout' )

@section( 'contents-css' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/edit.css') }}">
@endsection( 'contents-css' )

@section( 'contents' )
    <h1>トレーニング種目 削除</h1>
    @if ( session( 'front.trainning_event_delete_save_failure' ) == true )
      トレーニング種目の削除に失敗しました<br>
    @endif
    @if ( session( 'front.trainning_event_delete_save_null' ) == true )
      削除するデータが選択されていません<br>
    @endif
    
    <div class="toggle-test">
      
      {{-- 筋肉部位ごとのトレーニングメニュー表示ボタンを作成するLABEL --}}
      {{-- 全部位用ボタン --}}
      <label for="toggle_all" class="label">全種目</label>
      {{-- 各部位用ボタン --}}
      @foreach ( $muscle_categories as $category )
      {{-- トレーニング種目が登録されていない部位はボタンを表示しない --}}
      @if ( count( $list[ 'list_id_'.$category->id ] ) !== 0 )
      <label for="toggle{{ $category->id }}" class="label">
        {{ $category->name }}
      </label>
      @endif
      @endforeach
      <br>
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" class="invisible" id="toggle_all" value="0" @if( $muscle_category_id == 0 )checked @endif>
        {{-- 非表示範囲　ここから --}}
        <div class="switch-wrapper">
          <table border="1">
              <tr>
                <th>削除対象</th>
                <th>部位</th>
                <th>トレーニング種目名</th>
                <th>クールタイム</th>
              </tr>
              {{-- 削除対象フォーム　ここから --}}
              <form action="{{ route( 'trainning.delete.save' ) }}" method="post">
              @csrf
              @foreach ( $list_all as $event )
              <tr>
                <td><input type="checkbox" name="trainning_event_id{{ $event->trainning_event_id }}" value="{{ $event->trainning_event_id }}"></td>
                <td>{{ $event->muscle_category_name }}</td>
                <td>{{ $event->trainning_event_name }}</td>
                <td>{{ $event->cooltime }}  日</td>
              </tr>
              @endforeach
          </table>
        
          現在 {{ $list_all->currentPage() }} 目<br>
          @if ( $list_all->onFirstPage() === false )
            <a href="{{ route( 'trainning.list' ) }}">最初のページ</a>
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
          {{-- 削除対象フォーム　ここまで--}}
        </div>
        {{-- 非表示範囲　ここまで --}}
      </input>
      {{-- 全部位の実績一覧 ここまで --}}
      
      {{-- 各部位の実績一覧 ここから --}}
      @foreach ( $list as $list_category )
      @if ( count( $list_category ) !== 0 )
      <input type="radio" name="muscle_category_id" class="invisible" id="toggle{{ $list_category[0]->muscle_category_id }}" value="{{ $list_category[0]->muscle_category_id }}" @if( $list_category[0]->muscle_category_id == $muscle_category_id ) checked @endif>
        {{-- 非表示範囲　ここから --}}
        <div class="switch-wrapper">
          <table border="1">
            <tr>
              <th>削除対象</th>
              <th>部位</th>
              <th>トレーニング種目名</th>
              <th>クールタイム</th>
            </tr>
            {{-- 削除対象フォーム　ここから --}}
            <form action="{{ route( 'trainning.delete.save' ) }}" method="post">
            @csrf
            @foreach ( $list_category as $event )
            <tr>
              <td><input type="checkbox" name="trainning_event_id{{ $event->trainning_event_id }}" value="{{ $event->trainning_event_id }}"></td>
              <td>{{ $event->muscle_category_name }}</td>
              <td>{{ $event->trainning_event_name }}</td>
              <td>{{ $event->cooltime }}  日</td>
            </tr>
            @endforeach
          </table>
          
          現在 {{ $list_category->currentPage() }} 目<br>
          @if ( $list_category->onFirstPage() === false )
            <a href="{{ route( 'trainning.list' ) }}">最初のページ</a>
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
        {{-- 非表示範囲　ここまで --}}
        @endif
        @endforeach
      </input>
      {{-- 各部位の実績一覧 ここまで --}}
    </div>
    <hr>
    
    <a href="{{ route( 'trainning.list' ) }}" method="get">戻る</a>
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )