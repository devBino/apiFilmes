@extends('doc.index')

@section('formToken')

<div class="row">
    
    <div class="col-sm-5 form-token p-2 pt-0">

        <h3 class="text text-info p-0 mt-0 mb-0">Consultar Token</h3><hr>

        <form action="" method="GET">

            <div class="row">
                <div class="col-sm-3 d-flex justify-content-end">
                    <label>Usuario</label>
                </div>
                <div class="col-sm-5 form-group">
                    <input type="text" id="frTokenUsuario" name="usuario" class="form-control form-control-sm" required>
                </div>
                <div class="col-sm-4"></div>
            </div>        

            <div class="row">
                <div class="col-sm-3 d-flex justify-content-end">
                    <label>Email</label>
                </div>
                <div class="col-sm-5 form-group">
                    <input type="text" id="frTokenEmail" name="email" class="form-control form-control-sm" required>
                </div>
                <div class="col-sm-4">
                    <button id="frTokenBtn" class="btn btn-success btn-sm">Consultar Token</button>
                </div>
            </div>        

        </form>

    </div>

    <div class="col-sm-7 table-token p-2 pt-0">
        @if( isset($data['dadosToken']) && count($data['dadosToken']) )

            <h3 class="text text-info p-0 mt-0 mb-0">Dados</h3><hr>

            <table class="table table-sm table-bordered">
                <tr>
                    <td>Usuario</td>
                    <td colspan=2>{{$data['dadosToken']['usuario']}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td colspan=2>{{ base64_decode($data['dadosToken']['email']) }}</td>
                </tr>
                <tr>
                    <td>Token</td>
                    <td>
                        <input type="text" id="textToken" value="{{$data['dadosToken']['token']}}" readonly>
                        
                    </td>
                    <td><center><span class="btn btn-info btn-sm" onclick="copiarTexto('textToken')">Copiar</span></center></td>
                </tr>
            </table>

        @else
            <h3 class="text text-info p-0 mt-0 mb-0">Nenhum Token Pesquisado...</h3><hr>

        @endif
    </div>
</div>

@stop