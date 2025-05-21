<?php

namespace App\Http\Controllers;

use App\Models\Csv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;

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
        $csvs = Csv::get();

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
        $ruta = storage_path('app/public/');

        //Hash y CSV
        $contenido = file_get_contents($ruta.$csv->archivo);
        $csv->hash = sha1($contenido);
        $comp = Csv::get()->where('hash', $csv->hash);
        if(count($comp) != 0) {
            return redirect()->route('csv.create')->with('mensaje', 'Archivo Repetido');
        }
        $random = rand(1,9);

        $csv->save();

        $csvId = Csv::where('hash', $csv->hash)->first();
        //dd($csvId[0]->id);
        $find = Csv::findOrFail($csvId->id);
        $find->csv = 'IME'.$csv->hash.$find->id.$random;
        //dd($find->csv);

        //Modificacion PDF
        $pdf = new Fpdi();
        $pdf->AddPage();

        $pdf->setSourceFile($ruta.$csv->archivo);
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, 0, 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 200);
        $pdf->SetXY(50, 250);
        $pdf->Write(0, "Codigo CSV: $find->csv");

        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetX(120);
        $pdf->Write(5, "http://juanjo-torres.es");
        $pdf->Output('F', $ruta.$csv->archivo);

        $find->save();

        return redirect()->route('csv.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {   
        $usuario = Auth::user();

        if(!$usuario || $usuario->rol !== 'admin') {
            $csvs = $request->get('csv');
            $sql = Csv::where('csv', $csvs)->firstOrFail();
    
            return view('csv.show',compact('sql'));  
        }else {
            $csv = $request->get('csv');
            $query = Csv::query();

            $query->where(function($q) use ($csv){
                $q->where('correo', 'like', '%' . $csv . '%')
                ->orWhere('nombre', 'like', '%' . $csv . '%')
                ->orWhere('DNI', 'like', '%' . $csv . '%')
                ->orWhere('csv', 'like', '%' . $csv . '%')
                ->orWhere('tipo_documento', 'like', '%' . $csv . '%');
            });

            $csvs = $query->orderBy('created_at', 'desc')->orderBy('created_at', 'DESC')->paginate(1);

            if(count($csvs) < 1) {
                return view('inicio');
            }

            return view('csv.index',compact('csvs'));
        }
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
        Storage::disk('public')->delete($csv->archivo);
        $csv->delete();

        return redirect()->route('csv.index');
    }
}
