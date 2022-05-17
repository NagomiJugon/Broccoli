@extends( 'layout' )

@section( 'contents-css' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/menu/record.css') }}">
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
    <form action="/result/register" method="get">
        @csrf
        <div class="toggle-test">
            <label for="toggle" class="label">トレーニング種目</label><br>
            <input type="checkbox" id="toggle">
                <select name="trainning_event_id">
                    @foreach ( $list as $trainning_event )
                    <option value="{{ $trainning_event->id }}">{{ $trainning_event->name }}</option>
                    @endforeach
                </select>
            </input>
        </div>
        <br>
        @for ( $i = 1 ; $i < 6 ; $i++ )
            <input type="number" min="0" name="weight{{ $i }}" value="{{ old( 'weight'.$i ) }}">kg / 
            <input type="number" min="0" name="reps{{ $i }}" value="{{ old( 'reps'.$i ) }}">レップ
            <br>
        @endfor
        <button>記録する</button>
        <br>
        <a href="/trainning/register/index" method="get">新しい種目を追加する</a><br>
        <a href="/result/list" method="get">トレーニング実績リスト</a><br>
        <a href="/user/table_init_trainning_event" method="get">トレ種目 テーブル初期化</a>
    </form>
@endsection( 'contents' )