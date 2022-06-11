@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/trainning/list.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング種目一覧</h2>
@endsection( 'page-section' )

@section( 'contents' )
      <div class="message">
      @if ( session( 'front.trainning_event_edit_save_success' ) == true )
        <br><span class="success">トレーニング種目の編集が完了しました</span>
      @endif
      @if ( session( 'front.trainning_event_delete_save_seccess' ) == true )
        <br><span class="success">トレーニング種目の削除が完了しました</span>
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
      
      {{-- 絞った部位のまま編集画面に遷移するために非表示のチェックボックスの値を渡すform --}}
      <form action="{{ route( 'trainning.edit' ) }}" method="get">
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" id="toggle_all" value="0" checked>
        {{-- 非表示範囲　ここから --}}
        <div class="switch-wrapper">
          <div class="scroll-area">
            <div class="separator"></div>
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
            <div class="separator"></div>
          </div>
          <div class="separator"></div>
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
          <div class="scroll-area">
            <div class="separator"></div>
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
            <div class="separator"></div>
          </div>
          <div class="separator"></div>
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