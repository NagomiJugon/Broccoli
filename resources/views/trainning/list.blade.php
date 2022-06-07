@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/trainning/list.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング種目一覧</h2>
@endsection( 'page-section' )

@section( 'contents' )
    @if ( session( 'front.trainning_event_edit_save_success' ) == true )
      トレーニング種目の登録が完了しました<br>
    @endif
    @if ( session( 'front.trainning_event_delete_save_seccess' ) == true )
      トレーニング種目の削除が完了しました<br>
    @endif
    
    <div class="toggle-test">
      
      <div class="label-button-area">
        <span>ラベルを押すとトレーニング種目を絞り込めます</span><br>
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
      
      {{-- 絞った部位のまま編集画面に遷移するために非表示のチェックボックスの値を渡すform --}}
      <form action="{{ route( 'trainning.edit' ) }}" method="get">
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" id="toggle_all" value="0" checked>
        {{-- 非表示範囲　ここから --}}
        <div class="switch-wrapper">
          <table>
              <tr>
                <th>部位</th>
                <th>トレーニング種目名</th>
                <th>クールタイム</th>
              </tr>
              @foreach ( $list_all as $event )
              <tr>
                <td>{{ $event->muscle_category_name }}</td>
                <td>{{ $event->trainning_event_name }}</td>
                <td>{{ $event->cooltime }}  日</td>
              </tr>
              @endforeach
          </table>
        
          <span>現在 {{ $list_all->currentPage() }} ページ目</span><br>
          @if ( $list_all->onFirstPage() === false )
            <a href="{{ route( 'trainning.list' ) }}"><span>最初のページ</span></a>
          @else
            <span>最初のページ</span>
          @endif
          <span> / </span>
          @if ( $list_all->previousPageUrl() !== null )
            <a href="{{ $list_all->previousPageUrl() }}"><span>前に戻る</span></a>
          @else
            <span>前に戻る</span>
          @endif
            <span> / </span>
          @if ( $list_all->nextPageUrl() !== null )
            <a href="{{ $list_all->nextPageUrl() }}"><span>次に進む</span></a>
          @else
            <span>次に進む</span>
          @endif
        </div>
        {{-- 非表示範囲　ここまで --}}
      </input>
      {{-- 全部位の実績一覧 ここまで --}}
      
      {{-- 各部位の実績一覧 ここから --}}
      @foreach ( $list as $list_category )
      @if ( count( $list_category ) !== 0 )
      <input type="radio" name="muscle_category_id" id="toggle{{ $list_category[0]->muscle_category_id }}" value="{{ $list_category[0]->muscle_category_id }}">
        {{-- 非表示範囲　ここから --}}
        <div class="switch-wrapper">
          <table>
            <tr>
              <th>部位</th>
              <th>トレーニング種目名</th>
              <th>クールタイム</th>
            </tr>
            @foreach ( $list_category as $event )
            <tr>
              <td>{{ $event->muscle_category_name }}</td>
              <td>{{ $event->trainning_event_name }}</td>
              <td>{{ $event->cooltime }}  日</td>
            </tr>
            @endforeach
          </table>
          
          <span>現在 {{ $list_category->currentPage() }} ページ目</span><br>
          @if ( $list_category->onFirstPage() === false )
            <a href="{{ route( 'trainning.list' ) }}"><span>最初のページ</span></a>
          @else
            <span>最初のページ</span>
          @endif
           <span> / </span> 
          @if ( $list_category->previousPageUrl() !== null )
            <a href="{{ $list_category->previousPageUrl() }}"><span>前に戻る</span></a>
          @else
            <span>前に戻る</span>
          @endif
           <span> / </span>
          @if ( $list_category->nextPageUrl() !== null )
            <a href="{{ $list_category->nextPageUrl() }}"><span>次に進む</span></a>
          @else
            <span>次に進む</span>
          @endif
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
    
    <input type="submit" value="編集" class="default-button">
    <input type="submit" formaction="{{ route( 'trainning.delete' ) }}" value="削除" class="default-button">
    </form>
    
    <a href="{{ route( 'result.record' ) }}" method="get" class="default-button">戻る</a>
    
    <div class="separator"></div>
    
    <hr>
    
    <div class="separator"></div>
    
    <a href="{{ route( 'front.logout' ) }}" method="get" class="default-button">ログアウト</a>
@endsection( 'contents' )