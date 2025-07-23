<?php

namespace App\Http\Controllers;

use App\Models\DeputadoFic;
use Illuminate\Http\Request;
use App\Models\Deputado;
use Illuminate\Support\Facades\Log;

class DeputadoFicController extends Controller
{

   
    public function criar()
    {
    $partidos = Deputado::select('partido')->distinct()->get();

    $naturalidades = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins'
    ];

    return view('deputadosCreate.index', compact('partidos', 'naturalidades'));
    }

    public function create(Request $request)
    {
       
        $request->validate([
            'nome' => 'required|string',
            'partido' => 'required|string',
            'naturalidade' => 'required|string',
            'email' => 'nullable|email',
            'data_nascimento' => 'nullable|date',
            'escolaridade' => 'nullable|string',
            'legislatura' => 'nullable|string',
        ]);

       
        $deputado = DeputadoFic::create([
            'nome' => $request->nome,
            'partido' => $request->partido,
            'naturalidade' => $request->naturalidade,
            'email' => $request->email,
            'data_nascimento' => $request->data_nascimento,
            'escolaridade' => $request->escolaridade,
            'legislatura' => $request->legislatura,
        ]);
        
        return redirect()->route('dashboard');
    }

  public function show($id)
{
    
    $deputadoFic = DeputadoFic::find($id);

    if ($deputadoFic) {
        
        $deputado = $deputadoFic;
        $email = $deputado->email;
        $nomeCivil = $deputado->nome;
        $foto = null;
        $escolaridade = $deputado->escolaridade;
        $nascimento = null;
        $naturalidade = $deputado->naturalidade; // Já está na tabela 'deputados_fic'

    }


    // Retorna a view com os dados do deputado
    return view('deputadosCreate.show', compact(
        'deputado', 'email', 'nomeCivil', 'foto', 'escolaridade', 'nascimento', 'naturalidade'
    ));
}

public function edit($id)
{
    // Encontra o deputado fictício com o ID fornecido
    $deputado = DeputadoFic::findOrFail($id);
    
    // Retorna a view de edição com os dados do deputado
    return view('deputadosCreate.edit', compact('deputado'));
}

public function update(Request $request, $id)
{
    try {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'nome' => 'required|string',
            'partido' => 'required|string',
            'naturalidade' => 'required|string',
            'email' => 'nullable|email',
            'data_nascimento' => 'nullable|date',
            'escolaridade' => 'nullable|string',
            'legislatura' => 'nullable|string',
        ]);

        // Encontra o deputado fictício pelo ID
        $deputadoFic = DeputadoFic::findOrFail($id);

        // Atualiza os dados do deputado fictício
        $deputadoFic->update($validatedData);

        // Log de sucesso
        Log::info('Deputado atualizado', ['deputado' => $deputadoFic]);

        // Retorna uma resposta com sucesso ou redireciona para a view desejada
        return redirect()->route('deputadosfic.show', $deputadoFic->id)->with('success', 'Deputado fictício atualizado com sucesso!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Log do erro
        Log::error('Erro ao atualizar deputado', ['error' => $e->errors()]);

        // Retorna os erros de validação
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        // Log do erro
        Log::error('Erro ao atualizar deputado', ['error' => $e->getMessage()]);

        // Retorna erro genérico ou detalhado
        return back()->with('error', 'Erro ao atualizar o deputado.');
    }
}

public function destroy($id)
{
    // Encontra o deputado fictício pelo ID
    $deputadoFic = DeputadoFic::findOrFail($id);

    // Deleta o deputado
    $deputadoFic->delete();

    // Retorna para a página anterior com uma mensagem de sucesso
    return redirect()->route('dashboard')->with('success', 'Deputado fictício excluído com sucesso!');
}


    
    public function read()
    {
        $deputados = DeputadoFic::all();
        return response()->json($deputados, 200);
    }
}
