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
        <form action = "/locales"  method = "post">
            @csrf
            <label for ="nombre"> Nombre</label>
            <input id ="nombre" type = "text" name = "nombre" required = "true">
            

            <label for ="localizacion">Localizacion</label>
            <input id ="localizacion" type = "text" name = "localizacion" required = "true">

            <label for ="telefono">Teléfono</label>
            <input id ="telefono" type = "tel" name = "telefono" required = "true" maxlength = "9" minlength = "9" pattern = "^[6789]\d{8}$" oninput = "this.value = this.value.replace(/[^0-9]/g, '')">


            <input type = "submit" value = "Crear local"> 
        </form>
    </div>

    @if(Auth::check())
            <a class = "navegacion" href = "/login"> Volver al perfil </a>
    @endif
</body>
</html>
