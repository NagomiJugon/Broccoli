@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/edit.css') }}">
@endsection( 'head-option' )

@section( 'contents' )
    <h1>トレーニング種目 編集</h1>
    @if ( session( 'front.trainning_event_edit_save_failure' ) == true )
      トレーニング種目の登録に失敗しました。<br>
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
        <div class="switch-wrapper">
          <table border="1">
              <tr>
                <th>部位</th>
                <th>トレーニング種目名</th>
                <th>クールタイム</th>
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
                <td><input type="number" min="0" name="cooltime{{ $event->trainning_event_id }}" value="{{ $event->cooltime }}" required>  日</td>
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
          <button>保存する</button>
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
          <table border="1">
            <tr>
              <th>部位</th>
              <th>トレーニング種目名</th>
              <th>クールタイム</th>
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
                <td><input type="number" min="0" name="cooltime{{ $event->trainning_event_id }}" value="{{ $event->cooltime }}" required>  日</td>
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
          <button>保存する</button>
          </form>
        </div>
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