<!-- resources/views/noticias/index.blade.php -->

@extends('layouts.app')

@section('title', 'Notícias sobre Deputados')

@section('header', 'Últimas Notícias sobre Deputados')

@section('content')
    <div class="news-container">
        @foreach($news as $article)
            <div class="news-item">
                <h2>{{ $article['title'] }}</h2>
                <p>{{ $article['description'] }}</p>
                <a href="{{ $article['url'] }}" target="_blank">Leia mais...</a>
            </div>
            <hr>
        @endforeach
    </div>
@endsection

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color:rgb(255, 255, 255);
            padding: 15px;
            color: white;
            text-align: center;
        }

        h1 {
            margin-top: 20px;
            text-align: center;
            color: #333;
        }

        .news-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }

        .news-item {
            margin-bottom: 20px;
        }

        .news-item h2 {
            font-size: 20px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .news-item p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        .news-item a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .news-item a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background-color: #007bff;
            color: white;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .news-container {
                padding: 15px;
            }

            .news-item h2 {
                font-size: 18px;
            }

            .news-item p {
                font-size: 14px;
            }
        }
    </style>
@endsection
