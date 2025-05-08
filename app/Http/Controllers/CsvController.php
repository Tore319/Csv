<?php

namespace App\Http\Controllers;

use App\Models\Csv;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser;
use setasign\Fpdi\Fpdi;

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

        //Comprobacion Log In
        if(!$usuario || $usuario->rol !== 'admin') {
            return redirect()->route('inicio');
        }

        //Recojer parametros
        $csv->DNI = $request->get('dni');
        $csv->nombre = $request->get('nombre');
        $csv->apellidos = $request->get('apellidos');
        $csv->correo = $request->get('correo');
        if ($request->hasFile('archivo')) {
            $csv->archivo = $request->file('archivo')->store('csv', 'public');
        }
        $ruta = '/home/juanjo/Escritorio/laravel/CVC/storage/app/public/';

        //Hash y CSV
        $contenido = file_get_contents($ruta.$csv->archivo);
        $csv->hash = sha1($contenido);
        $csv->csv = strtoupper(substr($csv->hash, 0, 16));

        //Modificacion PDF
        $pdf = new Fpdi();
        $pdf->AddPage();

        $pdf->setSourceFile($ruta.$csv->archivo);
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, 0, 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 200);
        $pdf->SetXY(120, 250);
        $pdf->Write(0, "Codigo CSV: $csv->csv");

        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetX(120);
        $pdf->Write(5, "http://juanjo-torres.es");
        $pdf->Output('F', $ruta.$csv->archivo);

        $csv->save();

        return redirect()->route('inicio');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {   
        if(!$request) {
            return redirect()->route('inicio');
        }

        $csv = $request->get('csv');
        $sql = Csv::where('csv', $csv)->firstOrFail();

        return view('csv.show',compact('sql'));
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
    public function destroy(string $id)
    {
        $csv = Csv::findOrFail($id);
        $csv->delete();

        return redirect()->route('csv.index');
    }
}
