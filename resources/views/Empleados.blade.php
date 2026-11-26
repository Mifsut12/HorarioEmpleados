<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if (!empty($empleados))  
            <h1> Empleados registrados en el sistema </h1>
            <table>
                <tr>
                    <th>Nombre completo</th>
                    <th>Teléfono</th>
                </tr>

                @foreach($empleados as $empleado)
                    <tr>
                        <td>{{$empleado->Nombre_Completo}}</td>
                        <td>{{$empleado->Telefono}}</td>
                        <td> 
                            <form action = "/empleados/{{$empleado->id}}" method = "POST" style = "display: inline-block" onsubmit="return confirm('¿Desea borrar a {{$empleado->Nombre_Completo}}?')>
                                @csrf
                            @method('DELETE')
                                <button type = "submit" class = "boton-peticion" title = "Borrar programa"  > X </button>
                            </form>
                        </td>

                        <td> 
                            <form action = "/empleados/{{$empleado->id}}" method = "Get" style = "display: inline-block" >
                            @csrf
                    
                            <button type = "submit" class = "boton-peticion" title = "Modificar programa"  > =C </button>
                        </form>
                    </td>
                    </tr>
                @endforeach
            </table>

    @else
        <h1> No hay empleados en el local </h1>
    @endif

    <a href = "/empleados/nuevo"> Crear empleado </a>

    @if(Auth::check())
            <a class = "navegacion" href = "/login"> Volver al perfil </a>
    @endif
    
</body>
</html>
