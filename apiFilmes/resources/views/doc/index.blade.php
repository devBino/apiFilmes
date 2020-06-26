<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Documentação</title>
  
  @include('templates.head')

</head>
<body class="p-3">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a href="" class="navbar-brand">
          API FILMES
      </a>

      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSide">
          <span class="navbar-toggler-icon"><i></i></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSide">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="{{ env('API_DOC') }}" target="_blank" class="nav-link">Ver Documentação</a>
            </li>
            <li class="nav-item">
              <a href="/" target="_blank" class="nav-link">API</a>
            </li>
            <li class="nav-item">
              <a href="https://github.com/devBino" target="_blank" class="nav-link">GITHUB</a>
            </li>
            <li class="nav-item">
              <a href="/documentacao/token" class="nav-link">Token</a>
            </li>
          </ul>
      </div>
  </nav>  

  <div class="row mt-2">

    <div class="col-sm-12">

      <div class="container">
      
        @if(  isset($data['confirmacaoEmailUsuario']) )
          <div id="divMsg" class="alert-success">
            <h3>Parabéns!!</h3>
            <p align="justified">{{$data['confirmacaoEmailUsuario']}}</p>
          </div>
        @endif

        @yield('formToken')
      
      </div>      

    </div>

  </div>

</body>
</html>