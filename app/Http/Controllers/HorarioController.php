<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\formularioHorario;
use App\Models\local;
use App\Models\empleado;
use App\Models\Empleado_Horario;
use App\Models\horario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class HorarioController extends Controller
{
    //Funcion dedicada a la creación de una tabla con los horarios a asignar
    //Recibe: Nada
    //Procesa: Se comprueba el local del solicitante, se obtiene todos los empleados del local
    //Devuelve: Todos los empleados del local.
    public function formularioCreacionHorario($fecha = null){
        try {
            $fechaGenerada = $fecha ? Carbon::parse($fecha) : Carbon::today();
        }catch(\Exception $e){
            $fechaGenerada = Carbon::today();
        }

        $horarioEditable = true;
        if($fechaGenerada < Carbon::today()){
            $horarioEditable = false;
        }

        $empleadosLocal = empleado::where('ID_Local', auth()->user()->ID_Local)->select('Nombre_Completo', 'id')->get();
        
        $bloquesHora = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30', '16:00', '16:30', '17:00', '17:30',
            '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00'
        ];
        return view('formularioCreacionHorario')->with('empleadosLocal',$empleadosLocal)
        ->with('FechaActual', $fechaGenerada->toDateString())
        ->with('editable', $horarioEditable)
        ->with('bloquesHora', $bloquesHora);
    }


    //Funcion dedicada a mostrar el horario de la semana.
    //Recibe: Nada
    //Procesa: Se comprueba el local del solicitante, se obtiene todos el horario de la semana actual y de la próxima.
    //Devuelve: El horario del local en la semana actual.
    public function listarHorario($fecha = null){
        try {
            $fechaGenerada = $fecha ? Carbon::parse($fecha) : Carbon::today();
        }catch(\Exception $e){
            $fechaGenerada = Carbon::today();
        }

        $fechaAnterior = $fechaGenerada->copy()->subDay()->toDateString();
        $fechaPosterior = $fechaGenerada->copy()->addDay()->toDateString();
        $fechaActual = $fechaGenerada->copy()->toDateString();
        
        
        $empleadosLocal = empleado::where('ID_Local', auth()->user()->ID_Local)->select('id');
        $horarioEmpleado = Empleado_Horario::whereIn('ID_Empleado', $empleadosLocal)
            ->wherehas('Horario', function($query) use ($fechaActual){
                $query->where('Dia', $fechaActual);
            })
            ->with(['empleado', 'horario' => function($query){
                $query->orderBy('Hora', 'asc');
            }])
            ->get()
            ->sortBy(function($registroSinOrdenar){
                return $registroSinOrdenar->horario->Hora;
            });
        return view('Horario')->with('Horarios', $horarioEmpleado)
            ->with('FechaActual', $fechaActual)
            ->with('FechaPosterior',$fechaPosterior)
            ->with('FechaAnterior', $fechaAnterior);
    }       

    //Funcion dedicada a registrar/modficar los horarios en la base de datos
    //Recibe: Formulario con todos los horarios del dia
    //Procesa: Se comprueba que los datos son correctos.
    //Devuelve: Nada, los datos quedan registrados en caso de superar la validación.
    public function crearHorario(formularioHorario $request){
        $localUsuario = auth()->user()->ID_Local;
                    $empleadosLocal = empleado::where('ID_Local', auth()->user()->ID_Local)->pluck('id');

        $datos = $request->validated();

        foreach($datos['horarios'] as $hora => $idEmpleado) {

            $horarioEmpleado = null;
            $horario = horario::where('Dia', $datos['dia'])
                ->where('Hora',$hora)
                ->first();

            if($horario){
                $horarioEmpleado = Empleado_Horario::where('ID_Horario', $horario->id)->whereIn('ID_Empleado', $empleadosLocal)->first();
            }

            //Se crea
            if(empty($horarioEmpleado)){
                if(empty($idEmpleado)){
                    continue;
                }
                $horario = horario::firstOrCreate([
                    'Dia' => $datos['dia'],
                    'Hora' => $hora
                ]);
                Empleado_Horario::firstOrCreate([
                    'ID_Empleado' => $idEmpleado,
                    'ID_Horario' => $horario->id,
                ]);
                //Se modifica
            }else{
                if(empty($idEmpleado)){
                    $horarioEmpleado->delete();
                    continue;
                }
                $horarioEmpleado->update([
                    'ID_Empleado' => $idEmpleado,
                ]);
            }
        }
        return view('mensajeExito')->with('mensaje', 'Operacion realizada exitosamente');
    }


    
}
