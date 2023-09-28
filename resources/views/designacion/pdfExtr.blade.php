<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$designacion->carrera->programa}}</title>
    <link href="https://fonts.cdnfonts.com/css/american-typewriter" rel="stylesheet">
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

    @foreach($docentes as $docente)
    <div class="page_break">
        Potosí <?php
        $timestap = strtotime($designacion->gestion);
        setlocale(LC_TIME, "spanish");
        echo strftime("%d de %B de %Y", $timestap);     
        ?> 
        <br>
        CITE: UATF/DCE/CAR  <br><br>
        @if($docente->sexo == 'M')
            Señor {{$docente->abre_titulo}} <br>
        @else
            Señora {{$docente->abre_titulo}} <br>
        @endif  
        <text class="capitalize">{{ ucwords(strtolower($docente->nombres)) }} {{ ucwords(strtolower($docente->paterno)) }} {{ ucwords(strtolower($docente->materno)) }}</text> <br>
        Presente <br>
      
            De nuestra mayor considereación<br><br>
            Por Resolución del Honorable Consejo Facultativo de la Facultad de
            @foreach($facultad as $facu)
            <text class="capitalize">{{ ucwords(strtolower($facu->facultad)) }}</text>

          @endforeach 
                N°{{$designacion->resolucion}}/{{$designacion->anio}},
                nos permitimos comunicarle que como resultado de la <strong> {{$designacion->convocatoria}} Convocatoria </strong>a Concurso de Méritos Para la Provisión de 
                Docente Extraordinario para la Carrera de
                <strong class="capitalize">{{ ucwords(strtolower($designacion->carrera->programa)) }}</strong>,
                usted ha sido <strong> designado </strong> como 
            <strong class="capitalize">{{ ucwords(strtolower($docente->tipo_docente)) }}</strong>
            a  @if($docente->tiempo == 'TC')
            <strong>Tiempo Completo </strong>
                @else
               <strong> Tiempo horario </strong>
                @endif
            
            por
            @if($designacion->carrera->tipo == 'A')
            la gestion {{$designacion->anio}},
            @else
            @if($designacion->periodo == 'Gestión Académica')
            la gestión {{$designacion->anio}} (Semestre I/{{$designacion->anio}} y Semestre II/{{$designacion->anio}}),
            @else
            el ({{$designacion->periodo}}/{{$designacion->anio}}) de la gestión {{$designacion->anio}},
            @endif
            @endif
         
            con las siguientes asignaturas:<br>
            <br>
            <table style="margin: 0 auto;">
              <thead>
                  <tr>
                      <th style="text-align: left;">Sigla</th>
                      <th style="text-align: left;">Materia</th>
                      <th style="text-align: center;">Grupo</th>
                      <th style="text-align: center;">Horas</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                  $totalHoras = 0;
                  $materias = [];
                  @endphp
                  @foreach($docente->asignaciones as $asignacion)
                  @php
                  $horas = $asignacion->materia->hrs_teoricas + $asignacion->materia->hrs_practicas;
                  $totalHoras += $horas;
                  $sigla = $asignacion->materia->sigla;
                  $materia = $asignacion->materia->materia;
                  if (array_key_exists($sigla, $materias)) {
                      // si la materia ya existe en la lista, solo sumar las horas
                      $materias[$sigla]['horas'] += $horas;
                      array_push($materias[$sigla]['grupos'], $asignacion->grupo);
                  } else {
                      // si la materia no existe en la lista, agregarla como un nuevo elemento
                      $materias[$sigla] = [
                      'materia' => $materia,
                      'horas' => $horas,
                      'grupos' => [$asignacion->grupo]
                      ];
                  }
                  @endphp
                  @endforeach
                  @foreach($materias as $sigla => $materia)
                  <tr>
                      <td style="text-align: left;">{{ $sigla }}</td>
                      <td style="text-align: left;">{{ $materia['materia'] }}</td>
                      <td style="text-align: center;">{{ implode(', ', $materia['grupos']) }}</td>
                      <td style="text-align: right;">{{ $materia['horas'] }}Hrs.</td>
                  </tr>
                  @endforeach
                  <tr>
                      <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                      <td style="text-align: center;"><strong>{{ $totalHoras }}Hrs.</strong></td>
                  </tr>
              </tbody>
          </table>
          
            <br>
            Debiendo iniciar sus actividades a partir del 
            
            <?php
            $timestap = strtotime($designacion->fecha_desig);
            setlocale(LC_TIME, "spanish");
            echo strftime("%d de %B", $timestap);     
            ?> 

            Para coordinar los horarios y otros aspectos inherentes a sus funciones académicas, se le solicita pasar por la Dirección de Carrera. <br>
            Con este grato motivo, saludamos a usted con las consideraciones más distinguidas. <br>
            Atentamente, <br> <br> <br> <br>
       
      <div class="container">
        <div class="page">
          
          @foreach($facultad as $facu)
            <div class="left">
              @if($facu->autoridad == 'Titular')
              <text class="capitalize">{{$facu->decano->abre_titulo}} {{ucwords(strtolower($facu->decano->nombres))}} {{ucwords(strtolower($facu->decano->paterno))}} {{ucwords(strtolower($facu->decano->materno))}}</text> <br>
                Decano Titular de la Facultad de <text>{{ ucwords(strtolower($facu->facultad)) }}</text> <br>
              @else
              <text class="capitalize">{{$facu->decano->abre_titulo}} {{ucwords(strtolower($facu->decano->nombres))}} {{ucwords(strtolower($facu->decano->paterno))}} {{ucwords(strtolower($facu->decano->materno))}}</text> <br>
                Decano a.i. de la Facultad de <text>{{ ucwords(strtolower($facu->facultad)) }}</text>
                <br>
              @endif
            </div>
        <div class="right">
              @foreach($vicerrector as $vice)
                @if($vice->autoridad == 'Vicerrector')
                <text class="capitalize">{{ ucwords(strtolower($vice->decano->abre_titulo)) }} {{ ucwords(strtolower($vice->decano->nombres)) }} {{ ucwords(strtolower($vice->decano->paterno)) }} {{ ucwords(strtolower($vice->decano->materno)) }}</text> <br>
                  Vicerrector de la U.A.T.F. 
                @else
                <text class="capitalize">{{ ucwords(strtolower($vice->decano->abre_titulo)) }} {{ ucwords(strtolower($vice->decano->nombres)) }} {{ ucwords(strtolower($vice->decano->paterno)) }} {{ ucwords(strtolower($vice->decano->materno)) }}</text> <br>
                  Vicerrector Subrogante de la U.A.T.F. 
                @endif
              @endforeach
        </div>
           
          @endforeach
        
        </div>
    </div>
    </div>
    @endforeach
</body>
</html>

