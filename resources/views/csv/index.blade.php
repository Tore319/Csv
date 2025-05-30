@extends('../layouts/plantilla')

@section('titulo_head', 'Gestion de Archivos')
<style>
  .form-wrapper {
    width: 75%;
    margin: 0 auto;
  }

  @media (min-width: 768px) {
    .form-wrapper {
      width: 25%;
    }
  }
</style>

@section('contenido')
    @if (session()->has('mensaje'))
        <div class="container my-5 mx-auto alert alert-danger alert-dismissible " style="width: 75%;">{{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="form-wrapper mb-3 d-flex justify-content-center justify-content-md-end ms-md-auto me-3">
        <form class="input-group" method="GET" action="{{ route('search') }}">
            <input type="text" class="form-control" placeholder="Buscar Csv" aria-label="Buscar CSV" name="search" value="{{ $search ?? '' }}" required>
            <button class="btn btn-primary" id="btn_buscar">Buscar</button>
        </form>
    </div>
    <h1 class="text-center">Gestion</h1>
    <div class="container my-5 mx-auto">
        <div class="d-flex flex-wrap justify-content-around">
            @foreach ($csvs as $csv)
                <div class="d-flex justify-content-around mb-3 p-3 border bg-light" style="width: 45%;">
                    <embed class="d-none d-md-block" src="{{asset('storage/' . $csv->archivo)}}" type="application/pdf" width="60%" height="300px"/>
                    <div>
                        <h4 class="fs-5 fs-md-4 fs-lg-3 mb-3 text-center mt-1">{{ $csv->nombre }} {{ $csv->apellidos }}</h4>
                        <p class="text-center fs-6 fs-md-5 fs-lg-4 mt-1">{{ $csv->tipo_documento }}</p>
                        <button 
                            class="btn btn-outline-secondary d-block mx-auto" 
                            data-clipboard-text="{{ $csv->csv }}" 
                            onclick="navigator.clipboard.writeText(this.dataset.clipboardText)"
                            style="margin-top: 20px;">
                            <i class="bi bi-clipboard"></i> Copiar CSV
                        </button>
                        <div class="d-flex justify-content-center mb-3 align-items-center">
                            <form action="{{ route('csv.destroy', $csv->id) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column align-items-center">
                            @csrf
                            @method('DELETE')
                                <button class="btn btn-danger" style="margin-top: 20px;"><i class="bi bi-trash"></i></button>
                            </form>
                            <a href="{{ asset('storage/' . $csv->archivo) }}" target="_blank" class="btn btn-success" style="margin-top: 20px; margin-left: 10px;">
                                <i class="bi bi-file-earmark"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container my-5 mx-auto">
        {{ $csvs->links() }}
    </div>
@endsection