<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if ($local)  
            <h1> Datos del local {{ $local->Nombre}} </h1>
            <table>
                <tr>
                    <th>Telefono</th>
                    <th>Localización</th>
                </tr>

                
                    <tr>
                        <td>{{$local->Telefono}}</td>
                        <td>{{$local->Localizacion}}</td>
                    </tr>
               
            </table>

    @else
        <h1> El local especificado no existe </h1>
    @endif

    <a href = "/locales/"> Volver al listado de locales </a>

    @if(Auth::check())
            <a class = "navegacion" href = "/login"> Volver al perfil </a>
    @endif

    
</body>
</html>


