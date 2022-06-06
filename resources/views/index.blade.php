@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/index.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>ログイン</h2>
@endsection( 'page-section' )
    
@section( 'contents' )
    @if ( session( 'front.user_register_success' ) == true  )
        ユーザーの登録が完了しました<br>
    @endif
    @if ( session( 'front.user_register_failure' ) ==true  )
        ユーザーの登録に失敗しました<br>
    @endif
    @if ( $errors->any() )
        <div>
        @foreach ( $errors->all() as $error )
            {{ $error }}<br>
        @endforeach
        </div>
    @endif
    <form action="{{ route( 'front.login' ) }}" method="post">
        @csrf
        <div class="input-area">
            <h3>Email</h3>
            <input name="email" value="{{ old( 'email' ) }}">
            <h3>パスワード</h3>
            <input name="password" type="password">
        </div>
        
        <br>
        <div class="button-area">
            <button class="default-button">ログインする</button>
            <br>
            <a class="default-button" href="{{ route( 'user.index' ) }}">会員登録</a>
        </div>
    </form>
@endsection( 'contents' )