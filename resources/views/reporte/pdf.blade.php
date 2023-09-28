<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 5px;
        }
        th {
            background-color: #f0f0f0;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>{{ $carrera->programa }}</h2>
        <h2>{{ $periodo }}/{{ $gestion }}</h2>
    </div>

    <div>
        @php
            $fechaActual = date('d/m/Y');
        @endphp
        <h3>Fecha: {{ $fechaActual }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>CI</th>
                <th>Nombres</th>
                <th>Dedicación</th>
                <th>Materia</th>
                <th>Sigla</th>
                <th>Grupo</th>
                <th>Horas</th>
                <th>Según</th>
            </tr>
        </thead>
        <tbody>
            @php
                $docente = null;
                $num = 0;
                $sum_horas = 0;
            @endphp
            @foreach ($asignaciones as $asignacion)
                @if ($docente != $asignacion->docente->id_docente)
                    @if ($docente != null)
                        <tr>
                            <td colspan="7"></td>
                            <td> <strong> {{ $sum_horas }}</strong></td>
                            <td><strong></strong></td>
                        </tr>
                        @php
                            $sum_horas = 0;
                        @endphp
                    @endif
                    @php
                        $docente = $asignacion->docente->id_docente;
                    @endphp
                @endif
                <tr>
                    <td>{{ ++$num }}</td>
                    <td>{{ $asignacion->docente->ci }}</td>
                    <td>{{ $asignacion->docente->nombres }} {{ $asignacion->docente->paterno }} {{ $asignacion->docente->materno }}</td>
                    <td>{{ $asignacion->docente->tipo_docente }}</td>
                    <td>{{ $asignacion->materia->materia }}</td>
                    <td>{{ $asignacion->materia->sigla }}</td>
                    <td>{{ $asignacion->grupo }}</td>
                    <td>{{ $asignacion->materia->hrs_teoricas + $asignacion->materia->hrs_practicas }}</td>
                    <td>
                        Resol: {{ $asignacion->designacion->resolucion }} Dict: {{ $asignacion->designacion->dictamen }}
                    </td>
                </tr>
                @php
                    $sum_horas += $asignacion->materia->hrs_teoricas + $asignacion->materia->hrs_practicas;
                @endphp
            @endforeach
            @if ($docente != null)
                <tr>
                    <td colspan="7"></td>
                    <td> <strong>{{ $sum_horas }} </strong></td>
                    <td><strong></strong></td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
