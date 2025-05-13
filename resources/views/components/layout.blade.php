<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Financeiro</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light mb-5">
  <header class="p-3 text-bg-dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start fw-bold">
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li>
            <a href="/" class="nav-link px-0 text-white"><i>Financial Control</i></a>
          </li>
        </ul>
        <div class="d-flex gap-2 text-end">
          @auth
          <div class="dropdown">
            <a href="#" class="d-block text-decoration-none dropdown-toggle text-light hover:text-light" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="fw-bold">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu text-small">
              <li>
                <a class="dropdown-item" href="{{ route('credit_cards.index') }}">Cartões</a>
              </li>
              {{-- <li>
                <a class="dropdown-item" href="#">Settings</a>
              </li>
              <li>
                <a class="dropdown-item" href="#">Profile</a>
              </li> --}}
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form action="{{ route('login.logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item border-0 w-100 text-start">
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
          @endauth
        </div>
      </div>
    </div>
  </header>
  <div class="container">
      <h3 class="my-3">
        @isset($title)
          {{ $title }}
        @endisset
      </h3>
      @isset($mensagemSucesso)
          <div class="alert alert-success" role="alert">
              {{ $mensagemSucesso }}
          </div>
      @endisset
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
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