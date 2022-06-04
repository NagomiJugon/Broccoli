@extends( 'layout' )

@section( 'contents-css' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/list.css') }}">
@endsection( 'contents-css' )

@section( 'contents' )
    <h1>トレーニング実績一覧</h1>
    @if ( session( 'front.result_edit_save_seccess' ) == true )
      トレーニング実績の編集が完了しました<br>
    @endif
    @if ( session( 'front.result_delete_save_seccess' ) == true )
      トレーニング実績の削除が完了しました<br>
    @endif
    
    <div class="toggle-test">
    
      <label for="toggle_all" class="label">全種目</label>
      @foreach ( $muscle_categories as $category )
      @if ( count( $list[ 'list_id_'.$category->id ] ) !== 0 )
      <label for="toggle{{ $category->id }}" class="label">
        {{ $category->name }}
      </label>
      @endif
      @endforeach
      <br>
      
      {{-- 絞った部位のまま編集画面に遷移するために非表示のチェックボックスの値を渡すform --}}
      <form action="{{ route( 'result.edit' ) }}" method="get">
      
      {{-- 全部位の実績一覧 ここから --}}
      <input type="radio" name="muscle_category_id" id="toggle_all" value="0" checked>
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
                  <td>{{ $set->trainning_event_name }}</td>
                  <td>{{ $set->trainning_weight }}  kg</td>
                  <td>{{ $set->trainning_reps }}</td>
                  <td>{{ $set->trainning_timestamp }}</td>
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
      <input type="radio" name="muscle_category_id" id="toggle{{ $list_category[0]->muscle_category_id }}" value="{{ $list_category[0]->muscle_category_id }}">
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
                <td>{{ $set->trainning_event_name }}</td>
                <td>{{ $set->trainning_weight }}  kg</td>
                <td>{{ $set->trainning_reps }}</td>
                <td>{{ $set->trainning_timestamp }}</td>
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
      {{-- 各部位の実績一覧 ここまで --}}
    </div>
    <hr>
    
    <input type="submit" value="編集">
    <input type="submit" formaction="{{ route( 'result.delete' ) }}" value="削除">
    </form>
    
    <a href="{{ route( 'result.record' ) }}" method="get">戻る</a>
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )