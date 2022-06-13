@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/delete.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング実績 削除</h2>
@endsection( 'page-section' )

@section( 'contents' )
    <div class="message">
      @if ( session( 'front.result_delete_save_null' ) == true )
        <br><span class="failure">削除するデータが選択されていません</span>
      @endif
      @if ( session( 'front.result_delete_save_failure' ) == true )
        <br><span class="failure">実績の削除が失敗しました</span>
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
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" class="invisible" name="muscle_category_id" id="toggle_all" value="0" @if( $muscle_category_id == 0 ) checked @endif>
        {{-- 非表示範囲はここから --}}
        <div class="switch-wrapper">
          <div class="scroll-area">
            <div class="separator"></div>
              <table>
                  <tr>
                    <th>削除対象</th>
                    <th>種目名</th>
                    <th>負荷(kg)</th>
                    <th>レップ</th>
                    <th>実施日</th>
                  </tr>
                  {{-- 削除対象フォーム　ここから --}}
                  <form action="{{ route( 'result.delete.save' ) }}" method="post">
                  @csrf
                  @foreach ( $list_all as $set )
                  <tr>
                    <td>
                      <label for="chk{{ $set->result_id }}" class="label">
                      <input type="checkbox"  name="result{{ $set->result_id }}" class="invisible" id="chk{{ $set->result_id }}" value="{{ $set->result_id }}">
                      <span>x</span>
                    </label>
                    </td>
                    <td>{{ $set->trainning_event_name }}</td>
                    <td>{{ $set->trainning_weight }}  kg</td>
                    <td>{{ $set->trainning_reps }}</td>
                    <td>{{ $set->trainning_timestamp }}</td>
                  </tr>
                  @endforeach
              </table>
            <div class="separator"></div>
            </div>
            <div class="separator"></div>
          <button class="default-button" onclick='return confirm( "選択された実績を削除します。\nこの操作は戻せません。\n削除してよろしいですか？" )'>削除する</button>
          </form>
          <div class="separator"></div>
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
          <div class="scroll-area">
            <div class="separator"></div>
              <table>
                <tr>
                  <th>削除対象</th>
                  <th>種目名</th>
                  <th>負荷(kg)</th>
                  <th>レップ</th>
                  <th>実施日</th>
                </tr>
                {{-- 削除対象フォーム　ここから --}}
                <form action="{{ route( 'result.delete.save' ) }}" method="post">
                @csrf
                @foreach ( $list_category as $set )
                <tr>
                  <td>
                    {{-- idに$set->result_idを付けるだけでは重複するので$muscle_category_idも末尾に付与する --}}
                    <label for="chk{{ $set->result_id . $muscle_category_id }}" class="label">
                    <input type="checkbox"  name="result{{ $set->result_id }}" class="invisible" id="chk{{ $set->result_id . $muscle_category_id }}" value="{{ $set->result_id }}">
                    <span>x</span>
                  </td>
                  <td>{{ $set->trainning_event_name }}</td>
                  <td>{{ $set->trainning_weight }}  kg</td>
                  <td>{{ $set->trainning_reps }}</td>
                  <td>{{ $set->trainning_timestamp }}</td>
                </tr>
                @endforeach
              </table>
            <div class="separator"></div>
            </div>
            <div class="separator"></div>
          <button class="default-button" onclick='return confirm( "選択された実績を削除します。\nこの操作は戻せません。\n削除してよろしいですか？" )'>削除する</button>
          </form>
          {{-- 削除対象フォーム　ここまで --}}
          <div class="separator"></div>
        </div>
        {{-- 非表示範囲はここまで --}}
        @endif
        @endforeach
      </input>
      {{-- 各部位の実績一覧 ここまで --}}
    </div>
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'result.list' ) }}" method="get">戻る</a>
    
    <div class="separator"></div>
    
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )