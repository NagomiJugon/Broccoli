@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/edit.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング実績 編集</h2>
@endsection( 'page-section' )

@section( 'contents' )
    <div class="message">
      @if ( session( 'front.result_edit_save_failure' ) == true )
        <br><span class="failure">実績の編集が失敗しました</span>
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
      <input type="radio" class="invisible" name="muscle_category_id" id="toggle_all" value="0" @if( $muscle_category_id == 0 )checked @endif>
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
                  <td><input type="number" min="0" step="0.01" name="weight{{ $set->result_id }}" value="{{ $set->trainning_weight }}"></td>
                  <td><input type="number" min="0" name="reps{{ $set->result_id }}" value="{{ $set->trainning_reps }}"></td>
                  <td><input type="datetime-local" name="timestamp{{ $set->result_id }}" value="{{ str_replace( " " , "T" , $set->trainning_timestamp ) }}"></td>
                </tr>
                @endforeach
            </table>
            <div class="separator"></div>
            </div>
          <div class="separator"></div>
          <button class="default-button">保存する</button>
          </form>
        </div>
      </input>
      {{-- 全部位の実績一覧 ここまで --}}
      
      {{-- 各部位の実績一覧 ここから --}}
      @foreach ( $list as $list_category )
      @if ( count( $list_category ) !== 0 )
      <input type="radio" class="invisible" name="muscle_category_id" id="toggle{{ $list_category[0]->muscle_category_id }}" value="{{ $list_category[0]->muscle_category_id }}" @if( $list_category[0]->muscle_category_id == $muscle_category_id ) checked @endif>
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
                <td><input type="number" min="0" step="0.01" name="weight{{ $set->result_id }}" value="{{ $set->trainning_weight }}"></td>
                <td><input type="number" min="0" name="reps{{ $set->result_id }}" value="{{ $set->trainning_reps }}"></td>
                <td><input type="datetime-local" name="timestamp{{ $set->result_id }}" value="{{ str_replace( " " , "T" , $set->trainning_timestamp ) }}"></td>
              </tr>
              @endforeach
            </table>
            <div class="separator"></div>
          </div>
          <div class="separator"></div>
          <button class="default-button">保存する</button>
          </form>
        </div>
        @endif
        @endforeach
      </input>
      {{-- 各部位の実績一覧 ここまで --}}
    </div>
    
    <div class="separator"></div>
    
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'result.list' ) }}" method="get">戻る</a>
    
    <div class="separator"></div>
    
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )