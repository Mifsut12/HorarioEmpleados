
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "{{asset('css/DashBoard.css')}}">

</head>
<body>

@if(Auth::check())
        <form class = "form-cerrarSesion"  method = "post" action = "/logout"> 
            <input id = ".div-inicioDeSesion-form-submit " value = "Cerrar sesión"type = "submit" > 
        </form>
@endif
    <div class = "div">
        <h2> Sección de los horarios de {{auth()->user()->local->Nombre}}</h2>
        <a class="enlaces" href="/horarios/">Gestión de los horarios del local {{auth()->user()->local->Nombre}}</a>
    </div>



</body>
</html>