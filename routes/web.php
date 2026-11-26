<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\LoggedUserController;
use App\Http\Controllers\HorarioController;

Route::get('/', function () {
    return view('login');
});


Route::post("/login", [EmpleadoController::class, 'Login']);

Route::post("/logout", [LoggedUserController::class, 'cerrarSesion']);

Route::get("/login", [EmpleadoController::class, 'LoginActivo'])->name('login');

Route::middleware(['auth', 'can:acceder-super-admin'])->group(function (){
   Route::get('/empleados/', [EmpleadoController::class, 'listarEmpleados']);

   Route::get('/empleados/nuevo', [EmpleadoController::class, 'formularioCreacionEmpleado']);

   Route::post('/empleados/', [EmpleadoController::class, 'crearEmpleadoCrudo']);

   Route::get('/locales/nuevo', function () {
        return view('crearLocal');
    });

    Route::get('/locales/', [LocalController::class, 'listarLocales']);
    
    Route::get('/locales/{id}',[LocalController::class, 'consultarLocal']);
    
    Route::post('/locales', [LocalController::class, 'crearLocal']);

    Route::post('/locales/{id}', [LocalController::class, 'formularioModificaciónLocal']);
    
    Route::delete('/locales/{id}', [LocalController::class, 'borrarLocal']);

    Route::patch('/locales/{id}', [LocalController::class, 'modificarLocal']);


     //Empleados
    
    Route::get('/empleados/{id}', [EmpleadoController::class, 'listarEmpleadosLocal']);

    Route::post('/empleados', [EmpleadoController::class, 'crearEmpleado']);

    Route::post('/empleados/{id}', [EmpleadoController::class, 'formularioModificacionEmpleado']);

    Route::delete('/empleados/{id}', [EmpleadoController::class, 'borrarEmpleado']);

    Route::patch('/empleados/{id}',[EmpleadoController::class, 'modificarEmpleado']);

    Route::patch('/empleados/deasignar/{id}', [EmpleadoController::class,'deasignarAdmin']);

    Route::patch('/empleados/asignar/{id}', [EmpleadoController::class,'asignarAdmin']);


});

Route::middleware(['auth', 'can:acceder-admin'])->group(function (){
   
    //Horarios

    Route::get('/horarios/nuevo/{fecha?}', [HorarioController::class, 'formularioCreacionHorario'])
    ->where('fecha', '[0-9]{4}-[0-9]{2}-[0-9]{2}');

    Route::get('/horarios/{fecha?}', [HorarioController::class, 'listarHorario'])
    ->where('fecha', '[0-9]{4}-[0-9]{2}-[0-9]{2}');

    Route::post('/horarios/', [HorarioController::class, 'crearHorario']);

    Route::delete('/horarios/{id}', function () {
        return view('welcome');
    });

    Route::patch('/horarios/{id}', function () {
        return view('welcome');
    });
});



    

