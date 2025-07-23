<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Mail\NewsletterMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\NewsletterConfirmation;

class NewsController extends Controller
{
    public function getNews()
    {
        // Sua chave de API obtida no site da News API
        $apiKey = env('NEWS_API_KEY');

        // Nome do deputado ou pessoa
        $nomeDeputado = 'Deputados';  // Pode ser qualquer nome

        // Realizando a requisição para a News API
        $response = Http::get("https://newsapi.org/v2/everything", [
            'q' => $nomeDeputado,  // Busca pelo nome do deputado
            'apiKey' => $apiKey,
            'language' => 'pt',  // Limitar para notícias em português
            'sortBy' => 'publishedAt',  // Ordenar por data de publicação
        ]);

        // Verifique se a requisição foi bem-sucedida
        if ($response->successful()) {
            // Decodificar o JSON da resposta
            $news = $response->json();

            // Retornar as notícias para uma view ou API
            return view('noticias.index', ['news' => $news['articles']]);
        } else {
            // Caso ocorra algum erro, trate-o aqui
            return response()->json(['error' => 'Não foi possível buscar as notícias.'], 500);
        }
    }

 public function sendNewsletter(Request $request)
    {
        
       // Validação e criação do assinante
    $subscriber = Subscriber::create([
        'email' => $request->email,
        // outros campos se houver
    ]);

    // Enviar email de confirmação só para esse assinante
    Mail::to($subscriber->email)->send(new NewsletterConfirmation($subscriber->email));

    return redirect()->back()->with('success', 'Inscrição realizada! Um email de confirmação foi enviado.');
    }
}
