<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if (!empty($empleados))  
            <h1> Empleados registrados en el sistema</h1>
            <table>
                <tr>
                    <th>Nombre completo</th>
                    <th>¿Administrador?</th>
                    <th>Local asignado</th>
                </tr>

                @foreach($empleados as $empleado)
                    <tr>
                        <td>{{$empleado->Nombre_Completo}}</td>

                        
                        @if($empleado->rol == 'admin')

                            <td> Si </td>
                            <td>{{$empleado->local->Nombre}}</td>
                            <td> 
                                <form action = "/empleados/deasignar/{{$empleado->id}}" method = "POST" style = "display: inline-block">
                                @csrf
                                @method('PATCH')
                                    <button type = "submit" class = "boton-peticion" title = "Deasignar"  > Deasignar rol de administrador </button>
                                </form>
                            </td>
                            
                        @else

                            <td> No </td>

                            <td>{{$empleado->local->Nombre}}</td>
                            <td> 
                                <form action = "/empleados/asignar/{{$empleado->id}}" method = "POST" style = "display: inline-block">
                                @csrf
                                @method('PATCH')
                                    <button type = "submit" class = "boton-peticion" title = "Asignar"  > Asignar rol de administrador </button>
                                </form>
                            </td>
                            
                        @endif


                        <td> 
                            <form action = "/empleados/{{$empleado->id}}" method = "POST" style = "display: inline-block" onsubmit="return confirm('¿Desea borrar a {{$empleado->Nombre_Completo}}?')>
                            @csrf
                            @method('DELETE')
                                <button type = "submit" class = "boton-peticion" title = "Borrar programa"  > X </button>
                            </form>
                        </td>

                        <td> 
                            <form action = "/empleados/{{$empleado->id}}" method = "post" style = "display: inline-block" >
                            @csrf

                            <button type = "submit" class = "boton-peticion" title = "Modificar empleado"> =C </button>
                            </form>
                        </td>



                    </tr>
                @endforeach
            </table>

    @else
        <h1> No hay empleados en el local </h1>
    @endif

    <a href = "/empleados/add"> Crear empleado </a>

    @if(Auth::check())
            <a class = "navegacion" href = "/login"> Volver al perfil </a>
    @endif
    
</body>
</html>
