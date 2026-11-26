<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1> Introducir los datos  </h1>

    <div class = "Login"> 
        <form action = "/empleados/{{$empleado->id}}"  method = "post">
            @csrf
            @method('patch')
            <label for ="Nombre"> Nombre completo</label>
            <input id ="Nombre" type = "text" name = "Nombre" required = "true" value = "{{$empleado->Nombre_Completo}}">
            
            <label for ="Password">Contraseña</label>
            <input id ="Password" type = "password" name = "Password" required = "true">

            <label for ="telefono">Teléfono</label>
            <input id ="telefono" type = "tel" name = "telefono" required = "true" maxlength = "9" minlength = "9" pattern = "^[6789]\d{8}$" oninput = "this.value = this.value.replace(/[^0-9]/g, '')" value = "{{$empleado->Telefono}}">

            <input type = "submit" value = "Modificar empleado"> 

        </form>
    </div>

    @if(Auth::check())
            <a class = "navegacion" href = "/login"> Volver al perfil </a>
    @endif
</body>
</html>
