<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1> Introducir las credenciales de acceso </h1>

    <div class = "Login"> 
        <form action = "/empleados/"  method = "post">
            @csrf
            <label for ="Nombre"> Nombre completo</label>
            <input id ="Nombre" type = "text" name = "Nombre" required = "true">
            
            <label for ="Password">Contraseña</label>
            <input id ="Password" type = "password" name = "Password" required = "true">

            <label for ="telefono">Teléfono</label>
            <input id ="telefono" type = "tel" name = "telefono" required = "true" maxlength = "9" minlength = "9" pattern = "^[6789]\d{8}$" oninput = "this.value = this.value.replace(/[^0-9]/g, '')">

            <label for ="local">Local a asignar</label>
            <select name = "local" id = "local">
                    @foreach($locales as $id => $nombre)
                        <option value = "{{$id}}" {{ $loop->first ? 'Seleccionado' : ''}} >
                                {{ $nombre }}
                        </option>
                    @endforeach
            </select>
            <input type = "submit" value = "Crear empleado"> 
        </form>
    </div>

    @if(Auth::check())
            <a class = "navegacion" href = "/login"> Volver al perfil </a>
    @endif
</body>
</html>
