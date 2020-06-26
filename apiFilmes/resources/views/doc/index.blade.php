<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Documentação</title>
  
  @include('templates.head')

</head>
<body>

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
            <a href="{{$data['url']}}" target="_blank" class="nav-link">Ver Documentação</a>
          </li>
          <li class="nav-item">
            <a href="/" target="_blank" class="nav-link">API</a>
          </li>
          <li class="nav-item">
            <a href="https://github.com/devBino" target="_blank" class="nav-link">GITHUB</a>
          </li>
        </ul>
    </div>
</nav>

</body>
</html>