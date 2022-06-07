@extends( 'layout' )

@section( 'head-option' )
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/trainning/register.css') }}">
@endsection( 'head-option' )

@section( 'page-title' )
    <h2>トレーニング種目登録</h2>
@endsection( 'page-section' )

@section( 'contents' )
    
    <div class="separator"></div>
    
    @if ( $errors->any() )
        <div>
            @foreach ( $errors->all() as $error )
            {{ $error }}<br>
            @endforeach
        </div>
    @endif
    
    <form action="{{ route( 'trainning.register.save' ) }}" method="post">
        @csrf
        @foreach ( $list as $muscle_category )
            <input type="radio" name="muscle_category_id" class="invisible" id="muscle_category{{ $muscle_category->id }}" value="{{ $muscle_category->id }}" @if ( $muscle_category->id == 1 ) checked @endif>
            <label for="muscle_category{{ $muscle_category->id }}"><span>{{ $muscle_category->name }}</sapn></label>
            @if ( $muscle_category->id == 4 ) <br> @endif
        @endforeach
        
        <div class="separator"></div>
        
        <h3>トレーニング種目名</h3>
        <input name="name" value="{{ old( 'name' ) }}"><br>
        <h3>クールタイム(日)</h3>
        <input type="number" min="0" name="cooltime" class="small-form" value="0"><br>
        
        <div class="separator"></div>
        
        <button class="default-button">登録する</button>
        
        <div class="separator"></div>
        
        <hr>
        
        <div class="separator"></div>
        
        <a class="default-button" href="{{ route( 'result.record' ) }}" method="get">戻る</a>
    </form>
    
    <div class="separator"></div>    
    
    <hr>
    
    <div class="separator"></div>
    
    <a class="default-button" href="{{ route( 'front.logout' ) }}" method="get">ログアウト</a>
@endsection( 'contents' )