<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    public function index()
    {
        $statements = Statement::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('statements.index', compact('statements', 'mensagemSucesso'));
    }

    public function create()
    {
        return view('statements.create');
    }
}
