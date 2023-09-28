@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p id="texto-intro" style="font-size: 18px; font-family: 'Open Sans', sans-serif; color: #666;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var texto = "Bienvenido al sistema de designación de docentes, donde podrás gestionar la designación de Docentes para las distintas Carreas de la Universidad."; // Aquí puedes poner tu propio texto
            var velocidad = 30; 
            function escribirTexto(i) {
                if (i < texto.length) {
                    $("#texto-intro").append(texto.charAt(i));
                    i++;
                    setTimeout(function() { escribirTexto(i); }, velocidad);
                }
            }
            escribirTexto(0);
        });
    </script>
@endsection
