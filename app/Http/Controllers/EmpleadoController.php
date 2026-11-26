<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\formularioEmpleado;
use App\Models\empleado;
use App\Models\local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{

//Funcion dedicada al login
//Recibe: Datos del formulario de iniciar sesión
//Procesa: Verifica de que el usuario existe y tiene permisos de administrador o de super administrador
//Devuelve: Redirige al dashboard correspondiente de administrador, o a la pantalla de inicio en caso de no acreditar credenciales o de no tener permisos de administrador
    public function Login(Request $request){

        $nombre = trim($request->input('Nombre'));
        $password = $request->input('Password');
        $empleado = empleado::where('Nombre_Completo', $nombre)
        ->where(function ($query) {
            $query->where('rol', 'admin')
            ->orWhere('rol','super-Admin');
        })
        ->first();
        if($empleado != null && Hash::check($password, $empleado->password)){
            Auth::login($empleado);
            $request->session()->regenerate();
            if($empleado->rol != 'super-Admin'){
                return view('DashBoard');
            }
                return view('DashBoard-Super-Admin');
        }else{
            return view('mensajeError')->with('mensaje','Credenciales incorrectas');
        }
    }
//Función dedicada al redireccionamiento
//Recibe los datos del usuario logueado
//Procesa donde tiene que redirigir al usuario
//Devuelve: La vista que genera en base a los datos del usuario
    public function LoginActivo(Request $request){
        if(auth::check()){


            if(auth()->user()->rol == "super-Admin"){
                $request->session()->regenerate();
                return view('DashBoard-Super-Admin');
            }

            if(auth()->user()->rol == "admin"){
                $request->session()->regenerate();
                return view('DashBoard');
            }

            return view('Login');
        }
    }


//Función dedicada a la creación de un empleado
//Recibe: Los datos del formulario de creación de empleado
//Procesa: Los datos del formulario en busca de que si estos se repiten en algun empoleado(Nombre) y se encarga de rellenar el resto(rol) 
//Devuelve: Vista indicando el resultado de la operación, si todo ha salido correctamente un nuevo registro de empleado quedara reflejado en la base de datos.
    public function crearEmpleado(formularioEmpleado $request){
        $nombre = $request->input('Nombre');
        $password = $request->input('Password');
        $telefono = $request->input('telefono');
        $local = $request->input('local');
        $empleado = new empleado();
        $empleadoRepetido = empleado::where('Nombre_Completo', $nombre)->first();
        $existeLocal = local::where('id', $local);
        if($empleadoRepetido){
            return view('mensajeError')->with('mensaje','Error, ya existe un empleado con el nombre especificado');
        }
        if(!$existeLocal){
            return view('mensajeError')->with('mensaje','Error, no existe el local especificado');
        }
        $numeroEmpleados = empleado::where('ID_Local', $local)->count();
        if($numeroEmpleados == 0){
            $empleado->Nombre_Completo = $nombre;
            $empleado->password = Hash::make($password);
            $empleado->telefono = $telefono;
            $empleado->rol = 'admin';
            $empleado->ID_Local = $local;
            $empleado->save();
            return view('mensajeExito')->with('mensaje', 'Operacion realizada exitosamente');
        }else{
            $numeroEmpleadosAdmin = empleado::where('ID_Local', $local)->where('rol', 'admin')->count();
            if($numeroEmpleadosAdmin > 0){
                $empleado->Nombre_Completo = $nombre;
                $empleado->password = Hash::make($password);
                $empleado->telefono = $telefono;
                $empleado->rol = '';
                $empleado->ID_Local = $local;
                $empleado->save();
                return view('mensajeExito')->with('mensaje', 'Operacion realizada exitosamente');
            }else{
                $empleado->Nombre_Completo = $nombre;
                $empleado->password = Hash::make($password);
                $empleado->telefono = $telefono;
                $empleado->rol = 'admin';
                $empleado->ID_Local = $local;
                $empleado->save();
                return view('mensajeExito')->with('mensaje', 'Operacion realizada exitosamente');
            }
        } 
    }
//Función dedicada a la obtención de todos los empleados a excepción del super administrador.
//Recibe: Nada
//Procesa: Pide un listado de empleados que no tengan el rol de super-Admin.
//Devuelve: El listado de todos los empleados.
    public function listarEmpleados(){
        $empleados = empleado::where('rol','!=', 'super-Admin')->orderBy('ID_Local', 'asc')->get();
        return view('Empleados-SuperAdmin')->with('empleados', $empleados);
    }
//Función dedicada a la obtención de empleados de un local especifico
//Recibe: El id del local
//Procesa: Busca los empleados cuyo ID_Local corresponda con el introducido
//Devuelve: Listado de los empleados que trabajan en el local
    public function listarEmpleadosLocal(String $id_Local){
        $empleados = empleado::where('ID_Local', $id_Local)->get();
        return view('Empleados')->with('empleados', $empleados);
    }

//Función deidcada al borrado de un empleado
//Recibe: El id del empleado
//Procesa: Busca el id del empleado y en caso de encontrarlo, lo borra
//Devuelve: Vista indicando el resultado de la operación, si la operación es un exito, el empleado habra sido borrado de la base de datos.
    public function borrarEmpleado(String $id_Empleado){
        $empleado = empleado::where('id', $id_Empleado);
        if($empleado){
            $empleado->delete();
            return view('mensajeExito')->with('mensaje', 'Operación realizada existosamente');
        }else{
            return view('mensajeError')->with('mensaje','Ya hay otro empleado con ese nombre');
        }
    }

//Función dedicada a la modicación de un empleado.
// Recibe: Id del empleado a modificar y los datos nuevos
// Procesa: Busca al empleado a modificar, verifica que los datos son correctos y aplica los cambios en caso de que estos ultimos son correctos
// Devuelve: Vista indicando el resultado de la operación, si la operación es un exito, los cambios quedaran reflejados en la base de datos
//Nota:El campo del administrador no se toca en esta función, ya hay funciones destinadas a ello.
    public function modificarEmpleado(formularioEmpleado $request, $id){
        $empleado = empleado::where('id', $id)->first();

        $nombre = $request->input('Nombre');
        $password = $request->input('Password');
        $telefono = $request->input('telefono');
        $nombreRepetido = empleado::where('Nombre_Completo', $nombre)->where('id','!=', $id)->exists();

        if($nombreRepetido){
            return view('mensajeError')->with('mensaje','Ya hay otro empleado con ese nombre');
        }else{
            $empleado->Nombre_Completo = $nombre;
            $empleado->password = Hash::make($password);
            $empleado->telefono = $telefono;
            $empleado->save();
            return view('mensajeExito')->with('mensaje', 'Operación realizada existosamente');
        }
    }
//Función dedicada a asignar el rol de administrador a un empleado
//Recibe: El id del empleado que al que se le asigna el rol de administrador
//Procesa: Busca al empleado, verifica de que no es administrador y de que en el local donde trabaja dicho empleado, no hay ya un admnistrador.
// Devuelve: Vista indicando el resultado de la operación, si todo sale bien el campo del empleado sera 'admin'

    public function asignarAdmin(String $id){
        $empleado = empleado::where('id',$id)->first();
        if($empleado){
            $empleadoAdmin = empleado::where('ID_Local', $empleado->ID_Local)->where('id', '!=', $id)->where('rol', 'admin')->exists();
            if(!$empleadoAdmin){
                if($empleado->rol != 'admin'){
                    $empleado->rol = 'admin';
                    $empleado->save();
                    return view('mensajeExito')->with('mensaje', 'Operación realizada existosamente');
                }else{
                    return view('mensajeError')->with('mensaje','El empleado ya cuenta con permisos de administrador');
                }
            }else{
                return view('mensajeError')->with('mensaje','El local ' + $empleado->local->Nombre + ' ya tiene un administrador ' + $empleadoAdmin->Nombre_Completo);
            }
        }else{
            return view('mensajeError')->with('mensaje','El empleado especificado no existe');
        }
    }
//Función dedicada a deasignar el rol de administrador a un empleado
//Recibe: El id del empleado que al que se le deasigna el rol de administrador
//Procesa: Busca al empleado, verifica de que es administrador.
//Devuelve: Vista indicando el resultado de la operación, si todo sale bien el campo del empleado sera 'admin'
    public function deasignarAdmin(String $id){
        $empleado = empleado::where('id',$id)->first();
        if($empleado){    
            if($empleado->rol == 'admin'){
                $empleado->rol = '';
                $empleado->save();
                return view('mensajeExito')->with('mensaje', 'Operación realizada existosamente, recuerda de que el local carece de administrador');
            }else{
                return view('mensajeError')->with('mensaje','El empleado no tiene permisos de administrador');
                }
        }else{
            return view('mensajeError')->with('mensaje','El empleado especificado no existe');
        }        
    }


//Función dedicada a la creación de la vista del formulario de creación de un empleado
//Recibe: Nada
//Procesa: Obtiene un listado de locales para que el creador pueda asignar el local al empleado
//Devuelve: Vista que contiene el formulario de creación.    
    public function formularioCreacionEmpleado(){
        $locales = local::pluck('Nombre' , 'id');
        return view('crearEmpleado')->with('locales',$locales);
    }



//Función dedicada a la creación de la vista del formulario de modificación de un empleado
//Recibe: ID del empleado a modificar
//Procesa: Busca si el empleado existe y retorna sus datos para que solo se tenga que modificar lo necesario
//Devuelve: Vista que contiene el formulario de modificación.En caso de no encontrar al empleado, genera un mensaje de error.    
    public function formularioModificacionEmpleado(string $id){
        $empleado = empleado::find($id);
        if($empleado){
            return view('modificarEmpleado')->with('empleado',$empleado);
        }else{
            return view('MensajeError')->with('mensaje', 'Error, el empleado especificado no existe');
        }
    }

}




