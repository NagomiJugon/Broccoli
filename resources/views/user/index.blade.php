@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/common.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>会員登録</h2>
@endsection( 'page-section' )

@section( 'contents' )
    @if ( $errors->any() )
        <div>
        @foreach ( $errors->all() as $error )
            {{ $error }}<br>
        @endforeach
        </div>
    @endif

    <form action="{{ route( 'user.register' ) }}" method="post">
        @csrf
        <div class="input-area">
            <h3>ユーザー名</h3>
            <input name="name" value="{{ old( 'name' ) }}">
            <h3>Email</h3>
            <input name="email" value="{{ old( 'email' ) }}">
            <h3>パスワード</h3>
            <input name="password" type="password">
        </div>
        
        <br>
        
        <div class="button-area">
            <button class="default-button">登録する</button>
            <br>
            <a class="default-button" href="{{ route( 'front.index' ) }}" method="get">戻る</a>
        </div>
        
    </form>
@endsection( 'contents' )