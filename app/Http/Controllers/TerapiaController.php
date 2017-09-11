<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Terapia;
use App\Bitacora;

class TerapiaController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $terapias = DB::table('terapias')
        ->select('terapias.id', 'terapias.nombre', 'terapias.descripcion')->paginate(10);
        return view('system-mgmt/terapia/index', ['terapias' => $terapias]);
    }

    public function create() {
        return view('system-mgmt/terapia/create');
    }

    public function store(Request $request) {
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $user = $request->User()->username;
        $data = 'Nombre: ' . $request->nombre . ', Descripción: ' . $request->descripcion;

        //Validamos Campos del Formulario
        $this->validateInput($request);

        //Nuevo Forma de Inserta Datos
        $terapia = new Terapia();
        $terapia->nombre = $request["nombre"];
        $terapia->descripcion = $request["descripcion"];

        //Si la terapia se guarda, se crea un registro en la Bitacora
        if($terapia->save()) {
            $bitacora = new Bitacora();
            $bitacora->usuario = $user;
            $bitacora->nombre_tabla = 'TERAPIA';
            $bitacora->actividad = 'CREAR';
            $bitacora->anterior = '';
            $bitacora->nuevo = $data;
            $bitacora->fecha = $now;
            if($bitacora->save()){
                return redirect()->intended('system-management/terapia');
            }
        }
    }

    public function edit($id) { 
        //Capturamos el ID seleccionado para la Actualizacion     
        $terapia = Terapia::find($id);

        //Si la terapia seleccionada no tiene datos redireccionamos a la pagina principal de la Terapia
        if ($terapia == null || count($terapia) == 0) {
            return redirect()->intended('/system-management/terapia');
        }
        return view('system-mgmt/terapia/edit', ['terapia' => $terapia]);
    }

    public function update(Request $request, $id) {
        //Datos para la Bitacora
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'd/m/Y';
        $now = date($format);
        $user = $request->User()->username;
        $terapia1 = Terapia::findOrFail($id);

        //Nueva Forma de Insertar Datos
        $terapia = Terapia::findOrFail($id);
        //Validamos Datos del Formulario
        $this->validateUpdate($request);
        $terapia->descripcion = $request["descripcion"];
        //$terapia->save();
        //return redirect()->intended('system-management/terapia');
        if($terapia->save()){
            if ($terapia1->descripcion != $request["descripcion"]) {
                $bitacora = new Bitacora();
                $bitacora->usuario = $user;
                $bitacora->nombre_tabla = 'TERAPIA';
                $bitacora->actividad = 'ACTUALIZAR';
                $bitacora->anterior = 'Descripción: ' . $terapia1->descripcion;
                $bitacora->nuevo = 'Descripción: ' . $request["descripcion"];
                $bitacora->fecha = $now;
                if($bitacora->save()){
                    return redirect()->intended('system-management/terapia');
                }
            }   
        }   
    }

    public function search(Request $request) {
        $constraints = [
            'nombre' => $request['nombre']
            ];

       $terapias = $this->doSearchingQuery($constraints);
       return view('system-mgmt/terapia/index', ['terapias' => $terapias, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Terapia::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(10);
    }

    private function validateInput($request) {
        $this->validate($request, [
        'nombre' => 'required|max:30|unique:terapias',
        'descripcion' => 'max:500'
        ]);
    }

    private function validateUpdate($request) {
        $this->validate($request, [
        'descripcion' => 'max:500'
        ]);
    }
}
