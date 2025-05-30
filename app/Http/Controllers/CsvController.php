<?php

namespace App\Http\Controllers;

use App\Mail\CreateMail;
use App\Models\Csv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        //$csvs = Csv::get();

        //Comprobacion Log In
        if(!$usuario || $usuario->rol !== 'admin') {
            return redirect()->route('inicio');
        }

        //Recojer parametros
        $csv->DNI = $request->get('dni');
        $csv->nombre = $request->get('nombre');
        $csv->apellidos = $request->get('apellidos');
        $csv->correo = $request->get('correo');
        $csv->tipo_documento = $request->get('tipoDocumento');
        if ($request->hasFile('archivo')) {
            $csv->archivo = $request->file('archivo')->store('csv', 'public');
        }
        $ruta = storage_path('app/public/');

        $contenido = file_get_contents($ruta.$csv->archivo);
        $csv->hash = sha1($contenido);
        $comp = Csv::get()->where('hash', $csv->hash);
        if(count($comp) != 0) {
            return redirect()->route('csv.create')->with('mensaje', 'Archivo Repetido');
        }

        $csv->save();

        $random = rand(1,9);
        $find = Csv::where('hash', $csv->hash)->first();
        $find->csv = 'IME'.$find->hash.$find->id.$random;

        //Modificacion PDF
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($ruta.$csv->archivo);

        for($i = 1; $i <= $pageCount; $i++) {
            $template = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($template);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($template);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(0, 0, 200);
            $pdf->SetXY(50, 250);
            $pdf->Write(0, "Codigo CSV: $find->csv");
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(0, 0, 255);
            $pdf->SetX(120);
            $pdf->Write(5, "http://juanjo-torres.es");
        }

        $pdf->Output('F', $ruta.$csv->archivo);

        Mail::to($csv->correo)->send(new CreateMail($find));
        $find->save();

        return redirect()->route('csv.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {   
        $sql = $request->get('csv');
        $csv = Csv::where('csv', $sql)->first();
        
        if(!$csv) return redirect('/')->with('mensaje', 'No existe CSV');

        return view('csv.show',compact('csv'));
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

    public function search(Request $request)
    {
        $usuario = Auth::user();
        if(!$usuario || $usuario->rol !== 'admin') return redirect('/');

        $csv = $request->get('search');
        $nomApe = explode(' ', $csv);
        $nombre = $nomApe[0] ?? '';
        $apellido = $nomApe[1] ?? '';
        $query = Csv::query();

        $query->where(function($q) use ($csv){
            $q->where('correo', 'like', '%' . $csv . '%')
            ->orwhere('nombre', 'like', '%' . $csv . '%')
            ->orwhere('apellidos', 'like', '%' . $csv . '%')
            ->orWhere('DNI', 'like', '%' . $csv . '%')
            ->orWhere('csv', 'like', '%' . $csv . '%')
            ->orWhere('tipo_documento', 'like', '%' . $csv . '%');
        });

        $csvs = $query->orderBy('created_at', 'DESC')->paginate(6);
        $query2 = Csv::where('nombre', 'like', '%' . $nombre . '%')
             ->where('apellidos', 'like', '%' . $apellido . '%')
             ->orderBy('created_at', 'DESC')
             ->paginate(6);

        if(count($csvs) < 1 && count($query2) < 1) return redirect()->route('csv.index')->with('mensaje', 'Archivo no encontrado');
        else if(count($query2) > 0) $csvs = $query2;

        return view('csv.search',compact('csvs'));
    }

    // public function download(Csv $csv)
    // {
    //     $path = storage_path('app/public/' . $csv->archivo);

    //     if (!file_exists($path)) {
    //         abort(404, 'Archivo no encontrado');
    //     }

    //     return response()->download($path, '', [
    //         'Content-Type' => 'application/pdf'
    //     ]);
    // }
}
