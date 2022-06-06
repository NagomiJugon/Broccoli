<!DOCTYPE html>
<html lang="ja">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      @yield( 'head-option' )
      <title>Broccoli</title>
    </head>
    <body>
      <head>
        <div class="head">
          @yield( 'page-title' )
          <div class="header-under-bar"></div>
        </div>
      </head>
      <main>
        <div class="main">
          @yield( 'contents' )
        </div>
      </main>
    </body>
</html>