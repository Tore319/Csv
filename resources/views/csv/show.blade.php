@extends('../layouts/plantilla')

@section('titulo_head', 'Archivo')

@section('contenido')
    @if (auth()->guest() || auth()->user()->rol != 'admin')
        <div class="mx-auto w-100">
            <div class="d-flex justify-content-around mb-3 p-3 border bg-light mx-auto w-75 w-sm-50">
                <embed src="{{asset('storage/' . $csv->archivo)}}" type="application/pdf" width="75%" height="500px"/>
            </div>
            <div class="d-flex justify-content-center align-items-center" style="height: 50px;">
                <a href="{{ asset('storage/' . $csv->archivo) }}" target="_blank" class="btn btn-success" style="margin-top: 20px; margin-left: 10px;">
                    <i class="bi bi-file-earmark"></i>
                </a>
            </div>
        </div>
    @elseif (auth()->user()->rol == 'admin')
        <div class="d-flex flex-wrap justify-content-around">
                <div class="d-flex justify-content-around mb-3 p-3 border bg-light" style="width: 45%;">
                    <embed class="d-none d-md-block" src="{{asset('storage/' . $csv->archivo)}}" type="application/pdf" width="60%" style="height: 20rem;"/>
                    <div>
                        <h4 class="fs-5 fs-md-4 fs-lg-3 mb-3 text-center mt-3" style="height: 2rem;">{{ $csv->nombre }} {{ $csv->apellidos }}</h4>
                        <p class="text-center fs-6 fs-md-5 fs-lg-4 mt-1" style="height: 2rem;">{{ $csv->tipo_documento }}</p>
                        <button class="btn btn-outline-secondary d-block mx-auto" data-clipboard-text="{{ $csv->csv }}" onclick="navigator.clipboard.writeText(this.dataset.clipboardText)" style="margin-top: 1rem;">
                            <i class="bi bi-clipboard"></i> Copiar CSV
                        </button>
                        <div class="d-flex justify-content-center mb-3 align-items-center">
                            <form action="{{ route('csv.destroy', $csv->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                                <button class="btn btn-danger" style="margin-top: 1.2rem; height: 2.2rem;"><i class="bi bi-trash"></i></button>
                                <a href="{{ asset('storage/' . $csv->archivo) }}" target="_blank" class="btn btn-success" style="margin-top: 1.2rem; margin-left: 1rem; height: 2.2rem;">
                                    <i class="bi bi-file-earmark"></i>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    @endif
@endsection