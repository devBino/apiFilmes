<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8"/>
  </head>
  <body>
    <h2>Recado, Api Filmes Magic Design</h2>
    <hr>
    <p>{{ $data['message'] }}</p>
    
    <br>
    
    <p>Para confirmar seu cadastro clique no link abaixo</p>
    
    <br>

    <center><a href="{{$data['link']}}">Confirmar</a></center>
    <hr>
  </body>
</html>