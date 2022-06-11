@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/list.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング実績一覧</h2>
@endsection( 'page-section' )

@section( 'contents' )
    @if ( session( 'front.result_edit_save_seccess' ) == true )
      トレーニング実績の編集が完了しました<br>
    @endif
    @if ( session( 'front.result_delete_save_seccess' ) == true )
      トレーニング実績の削除が完了しました<br>
    @endif
    
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
      
      {{-- 絞った部位のまま編集画面に遷移するために非表示のチェックボックスの値を渡すform --}}
      <form action="{{ route( 'result.edit' ) }}" method="get">
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" id="toggle_all" value="0" checked>
        {{-- 非表示範囲　ここから --}}
        <div class="switch-wrapper">
          <table>
              <tr>
                  <th>種目名</th>
                  <th>負荷重量</th>
                  <th>レップ</th>
                  <th>実施日</th>
              </tr>
              @foreach ( $list_all as $set )
              <tr>
                  <td>{{ $set->trainning_event_name }}</td>
                  <td>{{ $set->trainning_weight }}  kg</td>
                  <td>{{ $set->trainning_reps }}</td>
                  <td>{{ $set->trainning_timestamp }}</td>
              </tr>
              @endforeach
          </table>
        
          <span class="default-message">現在 {{ $list_all->currentPage() }} ページ目</span><br>
          @if ( $list_all->onFirstPage() === false )
            <a href="{{ route( 'result.list' ) }}"><span class="active-a-message">最初のページ</span></a>
          @else
            <span class="default-message">最初のページ</span>
          @endif
          <span class="default-message"> / </span>
          @if ( $list_all->previousPageUrl() !== null )
            <a href="{{ $list_all->previousPageUrl() }}"><span class="active-a-message">前に戻る</span></a>
          @else
            <span class="default-message">前に戻る</span>
          @endif
            <span class="default-message"> / </span>
          @if ( $list_all->nextPageUrl() !== null )
            <a href="{{ $list_all->nextPageUrl() }}"><span class="active-a-message">次に進む</span></a>
          @else
            <span class="default-message">次に進む</span>
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
                <th>種目名</th>
                <th>負荷重量</th>
                <th>レップ</th>
                <th>実施日</th>
            </tr>
            @foreach ( $list_category as $set )
            <tr>
                <td>{{ $set->trainning_event_name }}</td>
                <td>{{ $set->trainning_weight }}  kg</td>
                <td>{{ $set->trainning_reps }}</td>
                <td>{{ $set->trainning_timestamp }}</td>
            </tr>
            @endforeach
          </table>
          
          <span class="default-message">現在 {{ $list_category->currentPage() }} ページ目</span><br>
          @if ( $list_category->onFirstPage() === false )
            <a href="{{ route( 'result.list' ) }}"><span class="active-a-message">最初のページ</span></a>
          @else
            <span class="default-message">最初のページ</span>
          @endif
           <span class="default-message"> / </span> 
          @if ( $list_category->previousPageUrl() !== null )
            <a href="{{ $list_category->previousPageUrl() }}"><span class="active-a-message">前に戻る</span></a>
          @else
            <span class="default-message">前に戻る</span>
          @endif
           <span class="default-message"> / </span>
          @if ( $list_category->nextPageUrl() !== null )
            <a href="{{ $list_category->nextPageUrl() }}"><span class="active-a-message">次に進む</span></a>
          @else
            <span class="default-message">次に進む</span>
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
    
    {{-- 絞った部位のまま編集画面に遷移するために非表示のチェックボックスの値を渡すbottun --}}
    <input type="submit" value="編集" class="default-button">
    {{-- 絞った部位のまま削除画面に遷移するために非表示のチェックボックスの値を渡すbutton --}}
    <input type="submit" formaction="{{ route( 'result.delete' ) }}" value="削除" class="default-button">
    {{-- 絞った部位のままチャート画面に遷移するために非表示のチェックボックスの値を渡すbutton --}}
    <input type="submit" formaction="{{ route( 'result.chart' ) }}" value="チャート" class="default-button">
    </form>
    
    <a class="default-button" href="{{ route( 'result.record' ) }}" method="get">戻る</a>
    
    <div class="separator"></div>
    
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )