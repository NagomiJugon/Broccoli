@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/list.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング実績登録</h2>
@endsection( 'page-section' )

@section( 'contents' )
    @if ( session( 'front.trainning_event_register_success' ) == true )
        トレーニング種目の登録が完了しました<br>
    @endif
    @if ( session( 'front.trainning_event_register_failure' ) == true )
        トレーニング種目の登録が失敗しました<br>
    @endif
    @if ( session( 'front.trainning_result_register_success' ) == true )
        トレーニング実績の登録が完了しました<br>
    @endif
    @if ( session( 'front.trainning_result_register_failure' ) == true )
        トレーニング実績の登録が失敗しました<br>
    @endif
    @if ( session( 'front.trainning_result_register_null' ) == true )
        登録するデータがありません<br>
    @endif
    
    
    <form action="{{ route( 'result.register' ) }}" method="post">
        @csrf
        
        <div class="toggle-test">
            
            <div class="label-button-area">
                <span>ラベルを押すとトレーニング種目を絞り込めます</span><br>
                {{-- 筋肉部位ごとのトレーニングメニュー表示ボタンを作成するLABEL --}}
                {{-- 全部位用ボタン --}}
                <label for="toggle_all label-button-all">
                    <span>全種目</span>
                </label>
                {{-- 各部位用ボタン --}}
                @foreach ( $list as $list_category )
                <label for="toggle{{ current( $list_category )[0]->muscle_category_id }}">
                    <span>{{ current( $list_category )[0]->muscle_category_name }}</span>
                    @if ( current( $list_category )[0]->muscle_category_id == 3 ) <br> @endif
                </label>
                @endforeach
            </div>
            
            {{-- 
                筋肉部位ごとのトレーニングメニューをドロップダウンで表示
                ラジオボタンはカテゴリーコードの送信とCSSで選択時以外は非表示するために使用
                $list_all : らuser_idで検索したTrainningEventModel
                $list     : カテゴリーごとのTrainningEventModelを配列で格納している
            --}}
            {{-- 全部位を含めたリスト --}}
            <input type="radio" name="selected_category" id="toggle_all" value="0" checked>
                {{-- 非表示範囲　ここから --}}
                <div class="switch-wrapper">
                    <select name="trainning_event_id0">
                        @foreach ( $list_all as $trainning_event )
                        <option value="{{ $trainning_event->id }}">{{ $trainning_event->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- 非表示範囲　ここまで --}}
            </input>
            {{-- 各部位ごとのリスト --}}
            @foreach ( $list as $list_category )
            <input type="radio" name="selected_category" id="toggle{{ current( $list_category )[0]->muscle_category_id }}" value="{{ current( $list_category )[0]->muscle_category_id }}">
                {{-- 非表示範囲　ここから --}}
                <div class="switch-wrapper">
                    <select name="trainning_event_id{{ current( $list_category )[0]->muscle_category_id }}">
                        @foreach ( $list_category as $category )
                        <option value="{{ $category->trainning_event_id }}">{{ $category->trainning_event_name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- 非表示範囲　ここまで --}}
            </input>
            @endforeach
        </div>
            
        <div class="separator"></div>
        
        {{-- 重量とレップ数入力用フォーム --}}
        <table>
            <tr>
                <th><span>重量(kg)</span></th>
                <th><span>レップ数</span></th>
            </tr>
            @for ( $i = 1 ; $i < 6 ; $i++ )
            <tr>
                <td>
                    <input type="number" min="0" step="0.01" name="weight{{ $i }}" value="{{ old( 'weight'.$i ) }}">
                </td>
                <td>
                    <input type="number" min="0" name="reps{{ $i }}" value="{{ old( 'reps'.$i ) }}">
                </td>
            </tr>
            @endfor
        </table>
        <button class="default-button">記録する</button>
            
        <div class="separator"></div>
        
        <hr>
        
        <div class="separator"></div>
        
        <a class="wide-button" href="{{ route( 'trainning.register' ) }}" method="get">新しい種目を追加する</a><br>
        <a class="wide-button" href="{{ route( 'trainning.list' ) }}" method="get">トレーニング種目リスト</a><br>
        <a class="wide-button" href="{{ route( 'result.list' ) }}" method="get">トレーニング実績リスト</a>
        
        <div class="separator"></div>
        
        <hr>
        
        <div class="separator"></div>
        
        <a class="default-button" href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
    </form>
@endsection( 'contents' )