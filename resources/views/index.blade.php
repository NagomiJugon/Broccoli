@extends( 'layout' )

@section( 'contents' )
    <h1>ログイン</h1>
    @if ( session( 'front.user_register_success' ) == true  )
        ユーザーの登録が完了しました<br>
    @endif
    @if ( session( 'front.user_register_failure' ) ==true  )
        ユーザーの登録に失敗しました<br>
    @endif
    @if ( $errors->any() )
        <div>
        @foreach ( $errors->all() as $error )
            {{ $error }}
        @endforeach
        </div>
    @endif
    <form action="/login" method="post">
        @csrf
        Email: <input name="email" value="{{ old( 'email' ) }}"><br>
        パスワード: <input name="password" type="password"><br>
        <button>ログインする</button>
        <br>
        <a href="/user/index">会員登録</a>
    </form>
@endsection( 'contents' )