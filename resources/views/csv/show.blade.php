@extends('../layouts/plantilla')

@section('titulo_head', 'Archivo')

@section('contenido')
    <div class="mx-auto w-100">
        <div class="d-flex justify-content-around mb-3 p-3 border bg-light mx-auto" style="width: 45%;">
            <embed src="{{asset('storage/' . $sql->archivo)}}" type="application/pdf" width="75%" height="500px"/>
        </div>
    </div>
@endsection