@extends('../layouts/plantilla')

@section('titulo_head', 'Gestion de Archivos')

@section('contenido')
    <h1 class="text-center">Gestion</h1>
    <div class="container my-5 mx-auto">
        <div class="d-flex flex-wrap justify-content-around">
            @foreach ($csvs as $csv)
                <div class="d-flex justify-content-around mb-3 p-3 border bg-light" style="width: 45%;">
                    <embed src="{{asset('storage/' . $csv->archivo)}}" type="application/pdf" width="60%" height="300px"/>
                    <div>
                        <h4 class="text-center">{{ $csv->nombre }}</h4>
                        <form action="{{ route('csv.destroy', $csv->id) }}" method="POST" enctype="multipart/form-data" class="row g-3 mt-3">
                        @csrf
                        @method('DELETE')
                            <button class="btn btn-danger" style="width: 50%;"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container my-5 mx-auto">
        {{ $csvs->links() }}
    </div>
@endsection