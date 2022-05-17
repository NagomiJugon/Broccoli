@extends( 'layout' )

@section( 'contents' )
    <h1>会員登録</h1>
    <form action="/user/register" method="post">
        @csrf
        ユーザー名: <input name="name" value="{{ old( 'name' ) }}"><br>
        Email: <input name="email" value="{{ old( 'email' ) }}"><br>
        パスワード: <input name="password" type="password"><br>
        <button>登録する</button>
    </form>
@endsection( 'contents' )