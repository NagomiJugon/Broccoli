@extends( 'layout' )

@section( 'contents' )
    <h1>トレ種目登録</h1>
    <form action="{{ route( 'trainning.register' ) }}" method="post">
        @csrf
        @foreach ( $list as $muscle_category )
            <input type="radio" name="muscle_category_id" id="muscle_category{{ $muscle_category->id }}" value="{{ $muscle_category->id }}">
            <label for="muscle_category{{ $muscle_category->id }}">{{ $muscle_category->name }}</label>
        @endforeach
        <br>
        種目名: <input name="name" value="{{ old( 'name' ) }}"><br>
        クールタイム: <input type="number" min="0" name="cooltime" value="0"> 日<br>
        <button>登録する</button>
        <br>
        <a href="{{ route( 'result.record' ) }}" method="get">戻る</a>
    </form>
    <br>
    <hr>
    <a href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )