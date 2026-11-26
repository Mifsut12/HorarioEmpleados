<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
        <header class = "header-login">
        @if(Auth::check())
            <form class = "form-cerrarSesion"  method = "post" action = "/menuLogin/logout"> 
                <input id = ".div-inicioDeSesion-form-submit " value = "Cerrar sesión"type = "submit" > 
            </form>
        @endif


    </header>
    <h1> {{$mensaje}} </h1>
       @if(Auth::check())
            <a class = "navegacion" href = "/login"> Volver al perfil </a>
        @endif


    <footer class = "footer"> 
        <h2 class = "footer-h2">Creado por Mifsut12</h2>
    </footer>
</body>
</html>