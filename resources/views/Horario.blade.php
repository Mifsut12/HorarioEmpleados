<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "{{asset('css/horario.css')}}">
</head>
<nav class = "nav">
    <a href = "/horarios/{{$FechaAnterior}}"> Dia anterior </a>
    <a href = "/horarios/{{$FechaPosterior}}"> Dia siguiente </a>
</nav>

<body>

    <div class = div>
        @if($Horarios->isNotEmpty())
            <h1 class = "h1"> Horario para el dia {{$FechaActual}} </h1>
            <table>
                <thead>
                    <tr>
                        <td>
                            Hora
                        </td>
                        <td>
                            Empleado 
                        </td>
                    </tr>

                    @forEach($Horarios as $Horario)
                        <tr>
                            <td>
                                {{$Horario->horario->Hora}}
                            </td>
                            <td>
                                {{$Horario->empleado->Nombre_Completo}}
                            </td>
                        </tr>
                    @endforeach
            </table>
        @else
            <h1 class = "h1"> Para este dia, no hay horario asignado aún</h1>
        @endif
    </div>

    <a href = "/horarios/nuevo/{{$FechaActual}}"> Asignar horarios </a>
</body>
</html>
