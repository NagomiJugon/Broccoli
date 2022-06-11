@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/trainning/delete.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング種目 削除</h2>
@endsection( 'page-section' )

@section( 'contents' )
    <div class="message">
      @if ( session( 'front.trainning_event_delete_save_failure' ) == true )
        <br><span class="failure">トレーニング種目の削除に失敗しました</span>
      @endif
      @if ( session( 'front.trainning_event_delete_save_null' ) == true )
        <br><span class="failure">削除するデータが選択されていません</span>
      @endif
    </div>
    
    <div class="toggle-test">
      
      <div class="label-button-area">
        <span class="default-message">ラベルを押すとトレーニング種目を絞り込めます</span><br>
        {{-- 筋肉部位ごとのトレーニングメニュー表示ボタンを作成するLABEL --}}
        {{-- 全部位用ボタン --}}
        <label for="toggle_all" class="label"><span>全種目</span></label>
        {{-- 各部位用ボタン --}}
        @foreach ( $muscle_categories as $category )
        {{-- トレーニング種目が登録されていない部位はボタンは不活性にする --}}
        @if ( count( $list[ 'list_id_'.$category->id ] ) !== 0 )
        <label for="toggle{{ $category->id }}" class="label">
        @else
        <label class="disabled-label">
        @endif
          <span>{{ $category->name }}</span>
          @if ( $category->id == 3 ) <br> @endif
        </label>
        @endforeach
      </div>
      <br>
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" class="invisible" id="toggle_all" value="0" @if( $muscle_category_id == 0 )checked @endif>
        {{-- 非表示範囲　ここから --}}
        <div class="switch-wrapper">
          <table>
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
                <td>
                  <label for="chk{{ $event->trainning_event_id }}" class="label">
                    <input type="checkbox"  name="trainning_event_id{{ $event->trainning_event_id }}" class="invisible" id="chk{{ $event->trainning_event_id }}" value="{{ $event->trainning_event_id }}">
                    <span>x</span>
                  </label>
                </td>
                <td>{{ $event->muscle_category_name }}</td>
                <td>{{ $event->trainning_event_name }}</td>
                <td>{{ $event->cooltime }}  日</td>
              </tr>
              @endforeach
          </table>
        
          <span class="default-message">現在 {{ $list_all->currentPage() }} ページ目</span><br>
          @if ( $list_all->onFirstPage() === false )
            <a href="{{ route( 'trainning.list' ) }}"><span class="default-message">最初のページ</span></a>
          @else
            <span class="default-message">最初のページ</span>
          @endif
          <span class="default-message"> / </span>
          @if ( $list_all->previousPageUrl() !== null )
            <a href="{{ $list_all->previousPageUrl() }}"><span class="default-message">前に戻る</span></a>
          @else
            <span class="default-message">前に戻る</span>
          @endif
            <span class="default-message"> / </span>
          @if ( $list_all->nextPageUrl() !== null )
            <a href="{{ $list_all->nextPageUrl() }}"><span class="default-message">次に進む</span></a>
          @else
            <span class="default-message">次に進む</span>
          @endif
          <br>
          <div class="separator"></div>
          <button class="default-button" onclick='return confirm( "選択されたトレーニング種目を削除します。\nこの操作は戻せません。\n削除してよろしいですか？" )'>保存する</button>
          </form>
          {{-- 削除対象フォーム　ここまで --}}
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
          <table>
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
              <td>
                <label for="chk{{ $event->trainning_event_id }}" class="label">
                  <input type="checkbox" name="trainning_event_id{{ $event->trainning_event_id }}" class="invisible" id="chk{{ $event->trainning_event_id }}" value="{{ $event->trainning_event_id }}">
                  <span>x</span>
                </label>
              </td>
              <td>{{ $event->muscle_category_name }}</td>
              <td>{{ $event->trainning_event_name }}</td>
              <td>{{ $event->cooltime }}  日</td>
            </tr>
            @endforeach
          </table>
          
          <span class="default-message">現在 {{ $list_category->currentPage() }} ページ目</span><br>
          @if ( $list_category->onFirstPage() === false )
            <a href="{{ route( 'trainning.list' ) }}"><span class="default-message">最初のページ</span></a>
          @else
            <span class="default-message">最初のページ</span>
          @endif
           <span class="default-message"> / </span> 
          @if ( $list_category->previousPageUrl() !== null )
            <a href="{{ $list_category->previousPageUrl() }}"><span class="default-message">前に戻る</span></a>
          @else
            <span class="default-message">前に戻る</span>
          @endif
           <span class="default-message"> / </span>
          @if ( $list_category->nextPageUrl() !== null )
            <a href="{{ $list_category->nextPageUrl() }}"><span class="default-message">次に進む</span></a>
          @else
            <span class="default-message">次に進む</span>
          @endif
          <br>
          <div class="separator"></div>
          <button class="default-button" onclick='return confirm( "選択されたトレーニング種目を削除します。\nこの操作は戻せません。\n削除してよろしいですか？" )'>保存する</button>
          </form>
          {{-- 削除対象フォーム　ここまで --}}
        </div>
        {{-- 非表示範囲　ここまで --}}
        @endif
        @endforeach
      </input>
      {{-- 各部位の実績一覧 ここまで --}}
    </div>
    
    <div class="separator"></div>
    
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'trainning.list' ) }}" method="get">戻る</a>
    
    <div class="separator"></div>
    
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )