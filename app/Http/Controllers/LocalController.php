<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\local;
use App\Http\Requests\formularioLocal;

class LocalController extends Controller
{
//Función dedicada a la creación de un local
//Recibe: Los datos del local
//Procesa: Valida de que los datos son correctos.
//Devuelve: Vista indicando el resultado de la operación, si el proceso de validación es correcto, se añadira un nuevo registro en la tabla 'locales'
    public function crearLocal(formularioLocal $request){
        $nombre = $request->input('nombre');
        $telefono = $request->input('telefono');
        $localizacion = $request->input('localizacion');
        $localRepetido = local::where('Nombre', $nombre)
            ->orWhere('Localizacion', $localizacion)
            ->orWhere('Telefono', $telefono)
            ->exists();
        if($localRepetido){
            return view('MensajeError')->with('mensaje', 'Error, hay un local que ya comparte caracteristicas con el nuevo');
        }
        $local = new local();
        $local->Nombre = $nombre;
        $local->Telefono = $telefono;
        $local->Localizacion = $localizacion;
        $local->save();
        return view('MensajeExito')->with('mensaje', 'Opreacion realizada existosamente');
    }

//Función dedicada a la obtención de los datos de un local
//Recibe: El id del local a consultar.
//Procesa: Busca el local cuyo id coincida con el introducido.
// Devuelve: El local especificado o nada en caso de no encontrarlo
    public function consultarLocal(string $id){
        if(auth()->user()->rol != 'super-Admin'){
            return view('MensajeError')->with('mensaje', 'Usted no esta autorizado para esta función');
        }else{
            $local = local::where('id', $id)->first();
            if(!$local){
                return view('MensajeError')->with('mensaje', 'Usted no esta trabajando para ningun local' );
            }else{
                return view('Local')->with('local', $local);
            }
        }
    }

//Función dedicada a obtener todos los locales
//Recibe: Nada
//Procesa: Obtiene todos los locales
//Devuelve: Listado de todos los locales
    public function listarLocales(){
        if(auth()->user()->rol != 'super-Admin'){
            return view('MensajeError')->with('mensaje','Error, usted no tiene privilegios para esta funcion');
        }else{
            $locales = local::all();
            if(!$locales){
                return view('MensajeError', 'No hay locales en el sistema');
            }else{
                return view('Locales')->with('locales', $locales);

            }
        }
    }


//Función dedicada al borrado de un local
//Recibe: Id del local
//Procesa: Obtiene todos los locales
//Devuelve: Listado de todos los locales
    public function borrarLocal(string $id){
        if(auth()->user()->rol != 'super-Admin'){
            return view('MensajeError')->with('mensaje','Error, usted no tiene privilegios para esta funcion');
        }else{
            $local = local::where('id', $id);
            if(!$local){
                return view('MensajeError')->with('mensaje', 'El local especificado no existe' );
            }else{
                $local->delete();
                return view('MensajeExito')->with('mensaje', 'Opreacion realizada existosamente');
            }
        }
    }


//Función dedicada a la modificación de un local
//Recibe: id del local a modificar y los datos nuevos
//Procesa: Busca el local, valida los datos y aplica los cambios
//Devuelve: Vista indicando el resultado de la operación, si la operación es un exito los cambios quedaran reflejado en la base de datos
    public function modificarLocal(Request $request, string $id){
        if(auth()->user()->rol != 'super-Admin'){
            return view('MensajeError')->with('mensaje','Error, usted no tiene privilegios para esta funcion');
        }else{
            $local = local::find($id);
            if(!$local){
                return view('MensajeError')->with('mensaje', 'El local especificado no existe' );
            }else{
                $nombre = $request->input('nombre');
                $telefono = $request->input('telefono');
                $localizacion = $request->input('localizacion');
                $localRepetido = local::where('id', '!=', $id)
                    ->where(function ($query) use ($localizacion, $telefono){
                        $query->where('Localizacion' ,$localizacion)
                            ->orWhere('Telefono', $telefono);     
                    })                   
                    ->exists();
                
                if($localRepetido){
                    return view('MensajeError')->with('mensaje', 'Error, hay un local que ya comparte caracteristicas con las modificaciones');
                }else{
                    $local->Nombre = $nombre;
                    $local->Telefono = $telefono;
                    $local->Localizacion = $localizacion;
                    $local->save();
                    return view('MensajeExito')->with('mensaje', 'Opereacion realizada existosamente');
                }
            }
        }
    }


//Función dedicada a la creación de la vista del formulario de modificación de un local
//Recibe: ID del local a modificar
//Procesa: Obtiene un listado de locales para que el creador pueda asignar el local al empleado
//Devuelve: Vista que contiene el formulario de modificación.    
    public function formularioModificaciónLocal(string $id){
        $local = local::where('id', $id)->first();
        if($local){
            return view('modificarLocal')->with('local',$local);
        }else{
            return view('MensajeError')->with('mensaje', 'Error, el local especificado no existe');
        }
    }




}
