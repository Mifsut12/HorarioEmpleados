<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel = "stylesheet" href = "{{asset('css/login.css')}}">
</head>
<body>
    <h1> Introducir las credenciales de acceso </h1>

    <div class = "Login"> 
        <form action = "/login"  method = "post">
            @csrf
            <label for ="Nombre"> Nombre completo</label>
            <input id ="Nombre" type = "text" name = "Nombre" required = "true" placeholder = "Tu nombre">
            

            <label for ="Password">Contraseña</label>
            <input id ="Password" type = "password" name = "Password" required = "true" placeholder ="Tu Contraseña">


            <input type = "submit" value = "Iniciar sesión"> 
        </form>
    </div>
</body>
</html>
