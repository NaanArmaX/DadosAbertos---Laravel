<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    header {
        background-color:rgb(255, 255, 255);
        padding: 10px 20px;
        color: white;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar-brand {
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
    }

   .search-bar {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative; /* Esse já está certo, mas vamos ajustar a lista em baixo */
}

    .search-bar input {
        padding: 10px;
        width: 100%;
        max-width: 500px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 16px;
        outline: none;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Estilo para os resultados da busca */
  .results {
    position: absolute;
    width: 100%;
    max-width: 500px;
    margin-top: 5px;
    padding: 10px;
    background-color: #ffffff;
    color: black;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 10;
    max-height: 300px;
    overflow-y: auto;
    display: none;
    top: 100%; /* Fica logo abaixo da barra de pesquisa */
    left: 50%; /* Centraliza horizontalmente */
    transform: translateX(-50%); /* Ajusta a posição para a verdadeira centralização */
}

    /* Estilo dos itens da lista de resultados */
    .results ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .results li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }

    .results li:hover {
        background-color: #f1f1f1;
    }

    .results p {
        color: #888;
        padding: 10px;
        text-align: center;
    }

    /* Navbar styling */
    .navbar-nav {
        display: flex;
        gap: 20px;
    }

    .nav-item {
        list-style: none;
    }

    .nav-link {
        color: black;
        text-decoration: none;
        font-size: 16px;
    }

    .nav-link:hover {
        text-decoration: underline;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .navbar-nav {
            flex-direction: column;
            align-items: center;
        }

        .search-bar input {
            width: 80%;
        }
    }
</style>

</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Dashboard de Deputados</a>
       
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
               
                <li class="nav-item">
                    <a class="nav-link" href="/deputados">Deputados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/partidos">Partidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/noticias">Noticias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary" href="{{ route('deputadosfic.teste') }}" style="color: black; padding: 8px 16px; border-radius: 5px;">Crie o seu Deputado</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Barra de pesquisa -->
    <div class="search-bar">
        <input type="text" id="search" placeholder="Buscar deputados..." autocomplete="off">
        <div id="search-results" class="results" style="display:none;"></div>
    </div>
</header>
<div class="container">
    <!-- Barra de pesquisa -->
    @yield('search-bar')

    <!-- Conteúdo específico da página -->
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let debounceTimer;

        // Evento ao digitar na barra de pesquisa
        $('#search').on('input', function() {
            var query = $(this).val(); // Captura o valor digitado

            // Limpar o timer anterior se houver (evitar muitas requisições)
            clearTimeout(debounceTimer);

            // Se a consulta não estiver vazia e tiver mais de 1 caracteres
            if (query.length > 1) {
                debounceTimer = setTimeout(function() {
                    // Enviar a requisição AJAX após o delay
                    $.ajax({
                        url: '{{ route('buscarDeputados') }}', // Rota da busca
                        method: 'GET',
                        data: { q: query }, // Envia o termo de busca como 'q'
                        success: function(response) {
                            if (response.length > 0) {
                                $('#search-results').html(''); // Limpa os resultados antigos
                                response.forEach(function(item) {
                                var estado = item.uf || item.naturalidade;
                                var url = '/deputados/' + item.id;
        
                                
                                if (estado === item.naturalidade) {
                                    url = '/deputados-fic/' + item.id; 
                                }
                                     $('#search-results').append('<li data-url="' + url + '">' + item.nome + ' - ' + estado + ' (' + item.partido + ')</li>');
                                });
                                $('#search-results').show();
                            } else {
                                $('#search-results').html('<p>Nenhum resultado encontrado</p>');
                                $('#search-results').show();
                            }
                        }
                    });
                }, 300); // Delay de 300ms para evitar múltiplas requisições
            } else {
                $('#search-results').hide(); // Esconde resultados se o campo estiver vazio
            }
        });

        // Evento ao clicar em um item da lista
         $(document).on('click', '#search-results li', function() {
            var url = $(this).data('url'); // Pega a URL do item
            window.location.href = url;  // Redireciona para a página do deputado
        });
    });
</script>

@stack('scripts')
</body>
</html>
