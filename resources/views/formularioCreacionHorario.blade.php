<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario</title>
    <link rel="stylesheet" href="{{asset('css/asignarHorario.css')}}">
    <script src="{{asset('js/formularioHorario.js')}}" defer></script>
</head>
<body>
    <header class = "header">
        <h1 class = "h1" id = "h1">  </h1>
    </header>
    <h2> Horario para {{ $FechaActual }} </h2>
    

        <form method = "post" action = "/horarios">
            @csrf
            <input type = "hidden" name = "dia" value = "{{ $FechaActual }}">
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
                </thead>
                @foreach($bloquesHora as $hora)
                    <tr>
                        <td>
                            <label>{{ $hora }}</label>
                        </td>
                        <td>
                            <select name="horarios[{{ $hora }}]" class="Empleado1">
                                <option value="" @disabled(!$editable)>-- Sin asignar --</option>
                                @foreach($empleadosLocal as $empleadoLocal)
                                    <option value="{{ $empleadoLocal->id }}" @disabled(!$editable)>
                                        {{ $empleadoLocal->Nombre_Completo }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
            </table>
                <input type="submit" name="Registrar cambios" class = "submit" @disabled(!($editable))>
        </form>
</body>
</html>
