<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if (!empty($locales))  
            <h1> Listado de locales </h1>
            <table>
                <tr>
                    <th>Nombre</th>
                </tr>

                @foreach($locales as $local)
                    <tr>
                        <td>{{$local->Nombre}}</td>
                        <td>
                            <a href ="/locales/{{$local->id}}" title= "Consultar"> -O </a> 
                        <td> 
                            <form action = '/locales/{{$local->id}}' method = "POST" style = "display: inline-block" onsubmit="return confirm('¿Desea borrar el local  {{$local->Nombre}}?')">
                            @csrf
                            @method('DELETE')
                                <button type = "submit" class = "boton-peticion" title = "Borrar local"  > X </button>
                            </form>
                        </td>

                        <td> 
                            <form action = "/locales/{{$local->id}}" method = "post" style = "display: inline-block" >
                            @csrf

                            <button type = "submit" class = "boton-peticion" title = "Modificar local"  > =C </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

    @else
        <h1> No hay locales en el sistema </h1>
    @endif

    <a href = "/locales/nuevo"> Crear local </a>

    @if(Auth::check())
            <a class = "navegacion" href = "/login"> Volver al perfil </a>
    @endif
    
    
</body>
</html>

