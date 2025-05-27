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
    @elseif (auth()->user()->rol == 'admin')
        <div class="d-flex flex-wrap justify-content-around">
                <div class="d-flex justify-content-around mb-3 p-3 border bg-light" style="width: 45%;">
                    <embed src="{{asset('storage/' . $csv->archivo)}}" type="application/pdf" width="60%" height="300px"/>
                    <div>
                        <h4 class="text-center" style="margin-top: 20px;">{{ $csv->nombre }} {{ $csv->apellidos }}</h4>
                        <p class="text-center" style="margin-top: 20px;">{{ $csv->tipo_documento }}</p>
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
        </div>
    @endif
@endsection