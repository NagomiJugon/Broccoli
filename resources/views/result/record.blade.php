@extends( 'layout' )

@section( 'contents-css' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/result/record.css') }}">
@endsection( 'contents-css' )

@section( 'contents' )
    <h1>トレーニング実績登録</h1>
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
            {{-- 筋肉部位ごとのトレーニングメニュー表示ボタンを作成するLABEL --}}
            {{-- 全部位用ボタン --}}
            <label for="toggle_all" class="label">全種目</label>
            {{-- 各部位用ボタン --}}
            @foreach ( $list as $list_category )
            <label for="toggle{{ current( $list_category )[0]->muscle_category_id }}" class="label">
                {{ current( $list_category )[0]->muscle_category_name }}
            </label>
            @endforeach
            
            {{-- 
                筋肉部位ごとのトレーニングメニューをドロップダウンで表示
                ラジオボタンはカテゴリーコードの送信とCSSで選択時以外は非表示するために使用
                $list_all : らuser_idで検索したTrainningEventModel
                $list     : カテゴリーごとのTrainningEventModelを配列で格納している
            --}}
            {{-- 全部位を含めたリスト --}}
            <input type="radio" name="selected_category" id="toggle_all" value="0" checked>
                <select name="trainning_event_id0">
                    @foreach ( $list_all as $trainning_event )
                    <option value="{{ $trainning_event->id }}">{{ $trainning_event->name }}</option>
                    @endforeach
                </select>
            </input>
            {{-- 各部位ごとのリスト --}}
            @foreach ( $list as $list_category )
            <input type="radio" name="selected_category" id="toggle{{ current( $list_category )[0]->muscle_category_id }}" value="{{ current( $list_category )[0]->muscle_category_id }}">
                <select name="trainning_event_id{{ current( $list_category )[0]->muscle_category_id }}">
                    @foreach ( $list_category as $category )
                    <option value="{{ $category->trainning_event_id }}">{{ $category->trainning_event_name }}</option>
                    @endforeach
                </select>
            </input>
            @endforeach
        </div>
        <br>
        
        {{-- 重量とレップ数入力用フォーム --}}
        @for ( $i = 1 ; $i < 6 ; $i++ )
            <input type="number" min="0" step="0.01" name="weight{{ $i }}" value="{{ old( 'weight'.$i ) }}">kg / 
            <input type="number" min="0" name="reps{{ $i }}" value="{{ old( 'reps'.$i ) }}">レップ
            <br>
        @endfor
        
        <button>記録する</button>
        
        <br>
        <a href="{{ route( 'trainning.register.index' ) }}" method="get">新しい種目を追加する</a><br>
        <a href="{{ route( 'trainning.list' ) }}" method="get">トレーニング種目リスト</a><br>
        <a href="" method="get">新しいプリセットメニューを追加する</a><br>
        <a href="{{ route( 'result.list' ) }}" method="get">トレーニング実績リスト</a><br>
        <a href="/user/table_init_trainning_event" method="get">トレ種目 テーブル初期化</a><br>
        
        <hr>
        
        <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
    </form>
@endsection( 'contents' )