<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Cierre;
use App\Models\Empleado;
use App\Models\Entrada;
use App\Models\Gasto;
use App\Models\Tienda;
use App\Models\TipoGasto;
use App\Models\Usuario;
use App\Models\Venta;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    /**
     * Creamos una instancia de controller y se colocan los middlewares que se van a utilizar para este controlador
     *
     */

    public function __construct()
    {
        // Revisa si hay un usuario loggeado
        $this->middleware('auth');
        // Comprueba si el correo del usuario actual está verificado
        $this->middleware('verified');
        // Verifica que una tienda esté iniciada, si no está iniciada te regresa a '/tiendas'
        $this->middleware('tiendaOpen');
        // Verifica que el usuario sea empleado o administrador de la tienda
        $this->middleware('belongsToTienda');
        // Verifica que el usuario loggeado sea un administrador
        $this->middleware('isAdmin');
    }

    public function showAdmin()
    {
        $tienda = Tienda::find(session('idTienda'));

        return view('tienda.admin.inicio')
            ->with('tiendaLog', $tienda);
    }

    public function showEmpleados()
    {
        $tienda = Tienda::find(session('idTienda'));
        $empleados = $tienda->empleados()->get();

        return view('tienda.admin.empleados.inicio')
            ->with('tiendaLog', $tienda)
            ->with('empleados', $empleados);
    }

    public function fetchEmpleados(Request $request)
    {
        if ($request->ajax()) {
            $tienda = Tienda::find(session('idTienda'));
            $empleados = Usuario::where('idRol', 3)->get();

            $empleados = $empleados->sortByDesc(function ($empleado, $key) {
                return $empleado->trabajaEn->contains(session('idTienda'));
            });

            return view('tienda.admin.empleados.empleados')
                ->with('tienda', $tienda)
                ->with('empleados', $empleados)
                ->render();
        }
    }

    public function tiendaAsociarEmpleados(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();

            $tienda = Tienda::find(session('idTienda'));

            $tienda->empleados()->sync($data['empleados']);

            return response()->json([
                'ok' => true,
            ]);
        }
    }

    public function showEmpleado($id)
    {
        $tienda = Tienda::find(session('idTienda'));
        $empleado = Empleado::find($id);
        $hoy = new DateTime('NOW');
        $from = new DateTime($hoy->format('01-m-Y'));
        $to = new DateTime($hoy->format('t-m-Y'));
        $asistencias = Asistencia::where('idEmpleado', $id)
            ->whereBetween('entrada', [$from, $to])
            ->get();
        $anios = [];
        for ($i = $empleado->inicio->format('Y'); $i <= $hoy->format('Y'); $i++) {
            array_push($anios, $i);
        }

        return view('tienda.admin.empleados.empleado')
            ->with('mes', $hoy->format('m'))
            ->with('anios', $anios)
            ->with('anio', $hoy->format('Y'))
            ->with('tiendaLog', $tienda)
            ->with('empleado', $empleado)
            ->with('asistencias', $asistencias);
    }

    public function showEmpleadoAsistencias($id, Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $hoy = new DateTime('NOW');
            $from = new DateTime($hoy->format('01-' . $data['mes'] . '-' . $data['anio']));
            $to = new DateTime($hoy->format('t-' . $data['mes'] . '-' . $data['anio']));
            $asistencias = Asistencia::where('idEmpleado', $id)
                ->whereBetween('entrada', [$from, $to])
                ->get();

            return view('tienda.admin.empleados.asistencias')
                ->with('asistencias', $asistencias)
                ->render();
        }
    }

    public function editarEmpleado($id, Request $request)
    {
        $data = $request->all();

        $empleado = Empleado::find($id);

        $empleado->formaPago = $data['formapago'];
        $empleado->sueldo = $data['sueldo'];

        if ($empleado->isDirty()) {
            if ($empleado->save())
                return redirect()->back()->with('message', "El empleado se ha editado correctamente.");
        } else {
            return redirect()->back()->with('message', "El empleado no ha cambiado.");
        }
    }

    public function showGastos()
    {
        $tienda = Tienda::find(session('idTienda'));
        $hoy = new DateTime('NOW');
        $from = new DateTime($hoy->format('01-m-Y'));
        $to = new DateTime($hoy->format('t-m-Y'));
        $gastos = Gasto::where('idTienda', session('idTienda'))
            ->whereBetween('fecha', [$from, $to])
            ->get();
        for ($i = $tienda->created_at->format('Y'); $i <= $hoy->format('Y'); $i++) {
            array_push($anios, $i);
        }

        return view('tienda.admin.gastos.inicio')
            ->with('mes', $hoy->format('m'))
            ->with('anios', $anios)
            ->with('anio', $hoy->format('Y'))
            ->with('tiendaLog', $tienda)
            ->with('gastos', $gastos)
            ->with('tiposGasto', $tienda->tiposGasto);
    }

    public function showGastosFetch(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $hoy = new DateTime('NOW');
            $from = new DateTime($hoy->format('01-' . $data['mes'] . '-' . $data['anio']));
            $to = new DateTime($hoy->format('t-' . $data['mes'] . '-' . $data['anio']));
            $gastos = Gasto::where('idTienda', session('idTienda'))
                ->whereBetween('fecha', [$from, $to])
                ->get();

            return view('tienda.admin.gastos.gastos')
                ->with('gastos', $gastos)
                ->render();
        }
    }

    public function nuevoGasto(Request $request)
    {

        $data = $request->all();
        $this->gastoValidator($data)->validate();

        $gasto = Gasto::create([
            'idUsuario' => Auth::user()->id,
            'idTienda' => session('idTienda'),
            'idTipoGasto' => $data['idtipogasto'],
            'importe' => $data['importe'],
            'descripcion' => $data['descripcion'],
            'fecha' => new DateTime('NOW')
        ]);

        if ($gasto != null) {
            return redirect()->back()->with('message', 'El gasto fue creado correctamente.');
        } else {
            return redirect()->back()->with('messageError', 'Hubo un error al crear el gasto, inténtalo nuevamente.');
        }
    }

    public function editarGasto($id, Request $request)
    {
        $data = $request->all();

        $this->gastoValidator($data)->validate();

        $gasto = Gasto::find($id);

        $gasto->fill([
            'idTipoGasto' => $data['idtipogasto'],
            'importe' => $data['descripcion'],
            'descripcion' => $data['descripcion']
        ]);

        if ($gasto->isDirty()) {
            if ($gasto->save())
                return redirect()->back()->with('message', 'El gasto fue editado correctamente.');
            else
                return redirect()->back()->with('messageError', 'El gasto no fue editado, inténtalo más tarde.');
        } else {
            return redirect()->back()->with('message', 'El gasto no ha cambiado.');
        }
    }

    private function gastoValidator($data)
    {
        return Validator::make($data, [
            'idtipogasto' => 'required|string',
            'descripcion' => 'required|string',
            'importe' => 'required|numeric'
        ]);
    }

    public function showTiposGasto()
    {
        $tienda = Tienda::find(session('idTienda'));

        return view('tienda.admin.gastos.tiposGasto')
            ->with('tiendaLog', $tienda)
            ->with('tiposGasto', $tienda->tiposGasto);
    }

    public function nuevoTipoGasto(Request $request)
    {
        $data = $request->all();

        $this->tipoGastoValidator($data)->validate();

        $tipoGasto = TipoGasto::create([
            'idTienda' => session('idTienda'),
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'color' => $data['color']
        ]);

        if ($tipoGasto != null) {
            return redirect()->back()->with('message', 'El tipo de gasto fue creado correctamente.');
        } else {
            return redirect()->back()->with('messageError', 'Hubo un error al crear el tipo de gasto, inténtalo nuevamente.');
        }
    }

    public function editarTipoGasto($id, Request $request)
    {
        $data = $request->all();

        $this->tipoGastoValidator($data)->validate();

        $tipoGasto = TipoGasto::find($id);

        $tipoGasto->fill([
            'idTienda' => session('idTienda'),
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'color' => $data['color']
        ]);

        if ($tipoGasto->isDirty()) {
            if ($tipoGasto->save())
                return redirect()->back()->with('message', 'El tipo de gasto fue editado correctamente.');
            else
                return redirect()->back()->with('messageError', 'El tipo de gasto no fue editado, inténtalo más tarde.');
        } else {
            return redirect()->back()->with('message', 'El tipo gasto no ha cambiado.');
        }
    }

    private function tipoGastoValidator($data)
    {
        return Validator::make($data, [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'color' => 'string|max:7|min:7|nullable'
        ]);
    }

    public function showCierres()
    {
        $tienda = Tienda::find(session('idTienda'));
        $hoy = new DateTime('NOW');
        $manana = (new DateTime('NOW'))->add(new DateInterval('P1D'));
        $from = new DateTime($hoy->format('d-m-Y'));
        $to = new DateTime($manana->format('d-m-Y'));
        $cierres = Cierre::where('idTienda', session('idTienda'))
            ->whereBetween('fecha', [$from, $to])
            ->get();

        $totalVentas = Venta::where('idTienda', 1)
            ->whereBetween('fecha', [
                new DateTime('2020-07-13 21:47:49'),
                new DateTime('2020-07-13 21:55:42')
            ])
            ->selectRaw('SUM(importe) as total')
            ->first();

        return view('tienda.admin.cierres.inicio')
            ->with('tiendaLog', $tienda)
            ->with('hoy', $hoy->format('Y-m-d'))
            ->with('minDia', $tienda->created_at->format('Y-m-d'))
            ->with('cierres', $cierres);
    }

    public function showCierresFetch(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $dia = new DateTime($data['dia']);
            $despues = (new DateTime($data['dia']))->add(new DateInterval('P1D'));
            $from = new DateTime($dia->format('d-m-Y'));
            $to = new DateTime($despues->format('d-m-Y'));
            $cierres = Cierre::where('idTienda', session('idTienda'))
                ->whereBetween('fecha', [$from, $to])
                ->get();

            return view('tienda.admin.cierres.cierres')
                ->with('cierres', $cierres)
                ->render();
        }
    }

    public function showCierre($id)
    {
        $tienda = Tienda::find(session('idTienda'));
        $cierre = Cierre::find($id);
        //dd($cierre);
        return view('tienda.admin.cierres.cierre')
            ->with('ventas', $cierre->ventas)
            ->with('gastos', $cierre->gastos)
            ->with('entradas', $cierre->entradas)
            ->with('cierre', $cierre)
            ->with('tiendaLog', $tienda);
    }

    public function showCierreVenta($id, $idVenta)
    {
        $tienda = Tienda::find(session('idTienda'));
        $venta = Venta::find($idVenta);
        //dd($cierre);
        return view('tienda.caja.ventas.venta')
            ->with('cierre',$id)
            ->with('venta', $venta)
            ->with('tiendaLog', $tienda);
    }

    public function showCierreEntrada($id, $idEntrada)
    {
        $tienda = Tienda::find(session('idTienda'));
        $entrada = Entrada::find($idEntrada);
        //dd($cierre);
        return view('tienda.stock.entradas.entrada')
            ->with('cierre',$id)
            ->with('entrada', $entrada)
            ->with('tiendaLog', $tienda);
    }
}
