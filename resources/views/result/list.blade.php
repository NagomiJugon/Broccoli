@extends( 'layout' )

@section( 'contents-css' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/list.css') }}">
@endsection( 'contents-css' )

@section( 'contents' )
    <h1>トレーニング実績一覧</h1>
    @if ( session( 'front.result_edit_save_seccess' ) == true )
      実績の編集が完了しました<br>
    @endif
    @if ( session( 'front.result_edit_save_failure' ) == true )
      実績の編集が失敗しました<br>
    @endif
    @if ( session( 'front.result_delete_save_seccess' ) == true )
      実績の削除が完了しました<br>
    @endif
    @if ( session( 'front.result_delete_save_failure' ) == true )
      実績の削除が失敗しました<br>
    @endif
    
    <div class="toggle-test">
    
      <label for="toggle_all" class="label">全種目</label>
      @foreach ( $muscle_categories as $category )
      <label for="toggle{{ $category->id }}" class="label">
        @if ( count( $list[ 'list_id_'.$category->id ] ) !== 0 )
        {{ $category->name }}
        @endif
      </label>
      @endforeach
      <br>
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="trainning_event" id="toggle_all" checked>
        <div class="switch-wrapper">
          <table border="1">
              <tr>
                  <th>種目名</th>
                  <th>負荷重量</th>
                  <th>レップ数</th>
                  <th>実施日</th>
              </tr>
              @foreach ( $list_all as $set )
              <tr>
                  <td>{{ $set->trainning_events_name }}</td>
                  <td>{{ $set->trainning_weight }}  kg</td>
                  <td>{{ $set->trainning_reps }}</td>
                  <td>{{ $set->trainning_set_datetime }}</td>
              </tr>
              @endforeach
          </table>
        
          現在 {{ $list_all->currentPage() }} 目<br>
          @if ( $list_all->onFirstPage() === false )
            <a href="{{ route( 'result.list' ) }}">最初のページ</a>
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
      <input type="radio" name="trainning_event" id="toggle{{ $list_category[0]->muscle_category_id }}">
        <div class="switch-wrapper">
          <table border="1">
            <tr>
                <th>種目名</th>
                <th>負荷重量</th>
                <th>レップ数</th>
                <th>実施日</th>
            </tr>
            @foreach ( $list_category as $set )
            <tr>
                <td>{{ $set->trainning_events_name }}</td>
                <td>{{ $set->trainning_weight }}  kg</td>
                <td>{{ $set->trainning_reps }}</td>
                <td>{{ $set->trainning_set_datetime }}</td>
            </tr>
            @endforeach
          </table>
          
          現在 {{ $list_category->currentPage() }} 目<br>
          @if ( $list_category->onFirstPage() === false )
            <a href="{{ route( 'result.list' ) }}">最初のページ</a>
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
      {{-- 全部位の実績一覧 ここまで --}}
    </div>
    <hr>
    
    <a href="{{ route( 'result.record' ) }}" method="get">戻る</a>
    <a href="{{ route( 'result.edit' ) }}" method="get">編集</a>
    <a href="{{ route( 'result.delete' ) }}" method="get">削除</a>
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )