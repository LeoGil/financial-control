<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Controle Financeiro</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
</head>
<body class="d-flex bg-light">

  {{-- SIDEBAR --}}
  @auth
  <aside class="sidebar bg-white border-end d-flex flex-column p-3">
    <a href="/" class="d-flex align-items-center mb-4 text-decoration-none">
      <i class="fa-2x fa-regular fa-dollar-sign me-2 text-primary"></i>
      <span class="fs-4 fw-bold">Financial Control</span>
    </a>

    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item mb-1">
        <a href="{{ route('accounts.index') }}"
           class="nav-link text-dark {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
          <i class="fa fa-wallet me-2"></i>Contas
        </a>
      </li>
      <li class="nav-item mb-1">
        <a href="{{ route('categories.index') }}"
           class="nav-link text-dark {{ request()->routeIs('categories.*') ? 'active' : '' }}">
          <i class="fa fa-tags me-2"></i>Categorias
        </a>
      </li>
      <li class="nav-item mb-1">
        <a href="#"
           class="nav-link text-dark">
          <i class="fa fa-chart-line me-2"></i>Relatórios
        </a>
      </li>
      <li class="nav-item mb-1">
        <a href="{{ route('transactions.index') }}"
           class="nav-link text-dark {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
          <i class="fa fa-list-alt me-2"></i>Transações
        </a>
      </li>
    </ul>

    {{-- Logout fixo no fim --}}
    <div class="mt-auto pt-3 border-top">
      <form action="{{ route('login.logout') }}" method="POST" class="w-100">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100">
          <i class="fa fa-sign-out-alt me-2"></i>Logout
        </button>
      </form>
    </div>
  </aside>
  @endauth

  {{-- CONTEÚDO PRINCIPAL --}}
  <div class="flex-grow-1 p-4">
    <header class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="m-0">{{ $title ?? '' }}</h3>
      <div>
        @auth
          <span class="me-2"><i class="fa-regular fa-circle-user"></i> {{ auth()->user()->name }}</span>
        @endauth
      </div>
    </header>

    @if (session('mensagemSucesso'))
      <div class="alert alert-success">
        {{ session('mensagemSucesso') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{ $slot }}
  </div>
</body>
</html>