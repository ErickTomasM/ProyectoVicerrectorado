<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.cdnfonts.com/css/american-typewriter" rel="stylesheet">
    <title> Proveido</title>
    <style>
        body {
            font-size: 14px;
            font-family: Arial, sans-serif;
            text-align: justify;
            line-height: 1.5;
            margin: 1cm;
        }
        .capitalize {
      text-transform: capitalize;
      }

        td {
          padding: 5px;
          }
      .page_break {
        page-break-after: always;
         }
        .page {
          display: flex;
          }

          .left {
          max-width: 50%;
          text-align: center;
          float: left;
        }
        .right {
          max-width: 50%;
          text-align: center;
          float: right;
          margin: 45 auto;
          }
    </style>
</head>
<body>
    <div class="page_break">
        Potosí  @php
        $fechaActual = date('d/m/Y');
        $timestap = strtotime($fechaActual);
        setlocale(LC_TIME, "spanish");
        echo strftime("%d de %B de %Y", $timestap); 
        @endphp
        
        <br>
        <p>Pase al Departamento de Personal y
            @if($facultad->id_facultad == '23' || $facultad->id_facultad == '40')
            a la Carrera de <text class="capitalize">{{ ucwords(strtolower($carrera->programa)) }}</text>
        @else
            a la Facultad de
            <text class="capitalize">{{ ucwords(strtolower($facultad->facultad)) }}</text> 
        @endif
        
        las designaciones firmadas correspondientes a la Planta Docente {{$designacion->periodo}},
        de la Carrera de 
        <strong class="capitalize">{{ ucwords(strtolower($carrera->programa)) }}</strong>
        para conocimiento y fines consiguientes, de acuerdo al siguiente detalle:</p> <br>

        @if($designacion->resolucion == null)
    <strong> D.D.C.C. N°{{$designacion->dictamen}}/{{$designacion->anio}} </strong><br> <br>
@else
    <strong> R.C.F. N°{{$designacion->resolucion}}/{{$designacion->anio}} </strong> <br>
@endif

    
        @if(isset($designacion) && !empty($designacion))
        @php
            $docenteAnterior = null;
            $contador = 0;
        @endphp
    
        @foreach($designacion->asignaciones as $asignacion)
            @if($asignacion->docente->id_docente != $docenteAnterior)
                @php
                    $contador++;
                    $docenteAnterior = $asignacion->docente->id_docente;
                @endphp
                {{$contador}}. 
                
                <text class="capitalize">{{ ucwords(strtolower($asignacion->docente->abre_titulo))}} 
                    {{ ucwords(strtolower($asignacion->docente->nombres))}} 
                    {{ucwords(strtolower($asignacion->docente->paterno))}} 
                    {{ucwords(strtolower($asignacion->docente->materno))}} </text><br>
            @endif
        @endforeach
    @endif
    <br> <br> <br> <br> <br>
    
     <div class="left">
              @foreach($autoridad as $vice)
                @if($vice->autoridad == 'Vicerrector')
                <text class="capitalize">{{ ucwords(strtolower($vice->decano->abre_titulo)) }} {{ ucwords(strtolower($vice->decano->nombres)) }} {{ ucwords(strtolower($vice->decano->paterno)) }} {{ ucwords(strtolower($vice->decano->materno)) }}</text> <br>
                  Vicerrector de la U.A.T.F. 
                @else
                <text class="capitalize">{{ ucwords(strtolower($vice->decano->abre_titulo)) }} {{ ucwords(strtolower($vice->decano->nombres)) }} {{ ucwords(strtolower($vice->decano->paterno)) }} {{ ucwords(strtolower($vice->decano->materno)) }}</text> <br>
                  Vicerrector Subrogante de la U.A.T.F. 
                @endif
              @endforeach
    </div>

</body>

</html>

