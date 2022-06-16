@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/trainning/edit.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング種目 編集</h2>
@endsection( 'page-section' )

@section( 'contents' )
    <div class="message">
      @if ( session( 'front.trainning_event_edit_save_failure' ) == true )
        <br><span class="failure">トレーニング種目の登録に失敗しました</span>
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
      <br>
      
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" class="invisible" id="toggle_all" value="0" @if( $muscle_category_id == 0 )checked @endif>
        <div class="switch-wrapper">
          <div class="scroll-area">
            <div class="separator"></div>
            <table>
                <tr>
                  <th>部位</th>
                  <th>トレーニング種目名</th>
                  <th>クールタイム(日)</th>
                </tr>
            <form action="{{ route( 'trainning.edit.save' ) }}" method="post">
            @csrf
                @foreach ( $list_all as $event )
                <tr>
                  <input type="hidden" name="trainning_event_id{{ $event->trainning_event_id }}" value="{{ $event->trainning_event_id }}">
                  <td>
                    {{-- 部位を編集するドロップリスト --}}
                    <select name="muscle_category_id{{ $event->trainning_event_id }}">
                      @foreach ( $muscle_categories as $muscle_category )
                      <option value="{{ $muscle_category->id }}" @if ( $muscle_category->id == $event->muscle_category_id ) selected @endif>{{ $muscle_category->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  {{-- トレーニング種目名を編集するテキストフィールド --}}
                  <td><input name="trainning_event_name{{ $event->trainning_event_id }}" value="{{ $event->trainning_event_name }}" required></td>
                  {{-- クールタイムを編集するフィールド --}}
                  <td><input type="number" min="0" name="cooltime{{ $event->trainning_event_id }}" value="{{ $event->cooltime }}" required></td>
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
      {{-- 登録件数０の部位はテーブルを表示しない --}}
      @if ( count( $list_category ) !== 0 )
      <input type="radio" name="muscle_category_id" class="invisible" id="toggle{{ $list_category[0]->muscle_category_id }}" value="{{ $list_category[0]->muscle_category_id }}" @if( $list_category[0]->muscle_category_id == $muscle_category_id ) checked @endif>
        <div class="switch-wrapper">
          <div class="scroll-area">
            <div class="separator"></div>
            <table>
              <tr>
                <th>部位</th>
                <th>トレーニング種目名</th>
                <th>クールタイム(日)</th>
              </tr>
            <form action="{{ route( 'trainning.edit.save' ) }}" method="post">
            @csrf
              @foreach ( $list_category as $event )
              <tr>
                <input type="hidden" name="trainning_event_id{{ $event->trainning_event_id }}" value="{{ $event->trainning_event_id }}">
                <td>
                    {{-- 部位を編集するドロップリスト --}}
                    <select name="muscle_category_id{{ $event->trainning_event_id }}">
                      @foreach ( $muscle_categories as $muscle_category )
                      <option value="{{ $muscle_category->id }}" @if ( $muscle_category->id == $event->muscle_category_id ) selected @endif>{{ $muscle_category->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  {{-- トレーニング種目名を編集するテキストフィールド --}}
                  <td><input name="trainning_event_name{{ $event->trainning_event_id }}" value="{{ $event->trainning_event_name }}" required></td>
                  {{-- クールタイムを編集するフィールド --}}
                  <td><input type="number" min="0" name="cooltime{{ $event->trainning_event_id }}" value="{{ $event->cooltime }}" required></td>
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
    
    <a class="default-button" href="{{ route( 'trainning.list' ) }}" method="get">戻る</a>
    
    <div class="separator"></div>
    
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )