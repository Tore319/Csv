@extends('../layouts/plantilla')

@section('titulo_head', 'Archivo')

@section('contenido')
    @if (auth()->guest() || auth()->user()->rol != 'admin')
        <div class="mx-auto w-100">
            <div class="d-flex justify-content-around mb-3 p-3 border bg-light mx-auto" style="width: 45%;">
                <embed src="{{asset('storage/' . $sql->archivo)}}" type="application/pdf" width="75%" height="500px"/>
            </div>
            <div class="d-flex justify-content-center align-items-center" style="height: 50px;">
                <a href="{{ asset('storage/' . $sql->archivo) }}" target="_blank" class="btn btn-success" style="margin-top: 20px; margin-left: 10px;">
                    <i class="bi bi-file-earmark"></i>
                </a>
            </div>
        </div>
    @endif
@endsection