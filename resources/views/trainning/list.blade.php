@extends( 'layout' )

@section( 'contents-css' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/list.css') }}">
@endsection( 'contents-css' )

@section( 'contents' )
    <h1>トレーニング種目一覧</h1>
    
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
      
      <form action="" method="get">
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" id="toggle_all" value="0" checked>
        <div class="switch-wrapper">
          <table border="1">
              <tr>
                <th>部位</th>
                <th>トレーニング種目名</th>
                <th>クールタイム</th>
              </tr>
              @foreach ( $list_all as $set )
              <tr>
                <td>{{ $set->muscle_category_name }}</td>
                <td>{{ $set->trainning_event_name }}</td>
                <td>{{ $set->cooltime }}  日</td>
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
        </div>
      </input>
      {{-- 全部位の実績一覧 ここまで --}}
      
      {{-- 各部位の実績一覧 ここから --}}
      @foreach ( $list as $list_category )
      @if ( count( $list_category ) !== 0 )
      <input type="radio" name="muscle_category_id" id="toggle{{ $list_category[0]->muscle_category_id }}" value="{{ $list_category[0]->muscle_category_id }}">
        <div class="switch-wrapper">
          <table border="1">
            <tr>
              <th>部位</th>
              <th>トレーニング種目名</th>
              <th>クールタイム</th>
            </tr>
            @foreach ( $list_category as $set )
            <tr>
              <td>{{ $set->muscle_category_name }}</td>
              <td>{{ $set->trainning_event_name }}</td>
              <td>{{ $set->cooltime }}  日</td>
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
        </div>
        @endif
        @endforeach
      </input>
      {{-- 各部位の実績一覧 ここまで --}}
    </div>
    <hr>
    
    <input type="submit" value="編集">
    <input type="submit" formaction="" value="削除">
    </form>
    
    <a href="{{ route( 'result.record' ) }}" method="get">戻る</a>
    {{--
    <a href="{{ route( 'result.edit' ) }}" method="get">編集</a>
    <a href="{{ route( 'result.delete' ) }}" method="get">削除</a>
    --}}
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )