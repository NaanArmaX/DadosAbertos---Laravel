<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter - Deputados</title>
</head>
<body>
    <h1>Últimas Notícias sobre Deputados</h1>

    @foreach($news as $article)
        <div>
            <h2>{{ $article['title'] }}</h2>
            <p>{{ $article['description'] }}</p>
            <a href="{{ $article['url'] }}" target="_blank">Leia mais...</a>
        </div>
        <hr>
    @endforeach
</body>
</html>
