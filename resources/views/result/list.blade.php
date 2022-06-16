@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/list.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング実績一覧</h2>
@endsection( 'page-section' )

@section( 'contents' )
    <div class="message">
      @if ( session( 'front.result_edit_save_seccess' ) == true )
        <br><span class="success">トレーニング実績の編集が完了しました</span>
      @endif
      @if ( session( 'front.result_delete_save_seccess' ) == true )
        <br><span class="success">トレーニング実績の削除が完了しました</span>
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
          @if ( $category->id == $muscle_categories[2]->id ) <br> @endif
        </label>
        @endforeach
      </div>
      
      {{-- 絞った部位のまま編集画面に遷移するために非表示のチェックボックスの値を渡すform --}}
      <form action="{{ route( 'result.edit' ) }}" method="get">
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" id="toggle_all" value="0" checked>
        {{-- 非表示範囲　ここから --}}
        <div class="switch-wrapper">
          <div class="scroll-area">
            <div class="separator"></div>
            <table>
              <tr>
                  <th>種目名</th>
                  <th>負荷(kg)</th>
                  <th>レップ</th>
                  <th>実施日</th>
              </tr>
              @foreach ( $list_all as $set )
              <tr>
                  <td>{{ $set->trainning_event_name }}</td>
                  <td>{{ $set->trainning_weight }}</td>
                  <td>{{ $set->trainning_reps }}</td>
                  <td>{{ $set->trainning_timestamp }}</td>
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
                  <th>種目名</th>
                  <th>負荷(kg)</th>
                  <th>レップ</th>
                  <th>実施日</th>
              </tr>
              @foreach ( $list_category as $set )
              <tr>
                  <td>{{ $set->trainning_event_name }}</td>
                  <td>{{ $set->trainning_weight }}</td>
                  <td>{{ $set->trainning_reps }}</td>
                  <td>{{ $set->trainning_timestamp }}</td>
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