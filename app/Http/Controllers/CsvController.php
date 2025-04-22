<?php

namespace App\Http\Controllers;

use App\Models\Csv;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser;

class CsvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = Auth::user();

        if(!$usuario || $usuario->rol !== 'admin') {
            return redirect()->route('inicio');
        }

        $csvs = Csv::orderBy('created_at', 'DESC')->paginate(6);
        return view('csv.index', compact('csvs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = Auth::user();

        if(!$usuario || $usuario->rol !== 'admin') {
            return redirect()->route('inicio');
        }

        return view('csv.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $csv = new Csv();
        $usuario = Auth::user();

        if(!$usuario || $usuario->rol !== 'admin') {
            return redirect()->route('inicio');
        }

        $csv->DNI = $request->get('dni');
        $csv->nombre = $request->get('nombre');
        $csv->apellidos = $request->get('apellidos');
        $csv->correo = $request->get('correo');
        if ($request->hasFile('archivo')) {
            $csv->archivo = $request->file('archivo')->store('csv', 'public');
        }
        $ruta = '/home/juanjo/Escritorio/laravel/CVC/storage/app/public/'.$csv->archivo;

        try {
            $contenido = file_get_contents($ruta);
            $csv->hash = sha1($contenido);
            $csv->csv = strtoupper(substr($csv->hash, 0, 16));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

        $csv->save();

        return redirect()->route('inicio');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {   
        if($request) {
            $csv = $request->get('csv');
            $sql = Csv::where('csv', $csv)->firstOrFail();
            //dd($sql);
        }

        return view('inicio',compact('sql'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Csv $cvc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Csv $cvc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Csv $cvc)
    {
        //
    }
}
