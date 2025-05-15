@extends('../layouts/plantilla')

@section('titulo_head', 'Archivo')

@section('contenido')
    @if (auth()->guest() || auth()->user()->rol != 'admin')
        <div class="mx-auto w-100">
            <div class="d-flex justify-content-around mb-3 p-3 border bg-light mx-auto" style="width: 45%;">
                <embed src="{{asset('storage/' . $sql->archivo)}}" type="application/pdf" width="75%" height="500px"/>
            </div>
        </div>
    @else
        <div class="container my-5 mx-auto">
            <div class="d-flex flex-wrap justify-content-around">
                <div class="d-flex justify-content-around mb-3 p-3 border bg-light" style="width: 45%;">
                    <embed src="{{asset('storage/' . $sql->archivo)}}" type="application/pdf" width="60%" height="300px"/>
                    <div>
                        <h4 class="text-center">{{ $sql->nombre }} {{ $sql->apellidos }}</h4>
                        <p class="text-center"><b>{{ $sql->csv }}</b></p>
                        <form action="{{ route('csv.destroy', $sql->id) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column align-items-center">
                        @csrf
                        @method('DELETE')
                            <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection