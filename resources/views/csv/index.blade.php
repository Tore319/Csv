@extends('../layouts/plantilla')

@section('titulo_head', 'Gestion de Archivos')

@section('contenido')
    <div class="mb-3 justify-content-end d-flex w-25 ms-auto">
        <form class="input-group" method="GET" action="{{ route('ver') }}">
            <input type="text" class="form-control" placeholder="Buscar Csv" aria-label="Buscar CSV" name="search" value="{{ $search ?? '' }}" required>
            <button class="btn btn-primary" id="btn_buscar">Buscar</button>
        </form>
    </div>
    <h1 class="text-center">Gestion</h1>
    <div class="container my-5 mx-auto">
        <div class="d-flex flex-wrap justify-content-around">
            @foreach ($csvs as $csv)
                <div class="d-flex justify-content-around mb-3 p-3 border bg-light" style="width: 45%;">
                    <embed src="{{asset('storage/' . $csv->archivo)}}" type="application/pdf" width="60%" height="300px"/>
                    <div>
                        <h4 class="text-center" style="margin-top: 20px;">{{ $csv->nombre }} {{ $csv->apellidos }}</h4>
                        <button 
                            class="btn btn-outline-secondary d-block mx-auto" 
                            data-clipboard-text="{{ $csv->csv }}" 
                            onclick="navigator.clipboard.writeText(this.dataset.clipboardText)"
                            style="margin-top: 20px;">
                            <i class="bi bi-clipboard"></i> Copiar CSV
                        </button>
                        <form action="{{ route('csv.destroy', $csv->id) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column align-items-center">
                        @csrf
                        @method('DELETE')
                            <button class="btn btn-danger" style="margin-top: 20px;"><i class="bi bi-trash"></i></button>
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