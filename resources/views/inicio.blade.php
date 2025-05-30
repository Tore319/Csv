@extends('./layouts/plantilla')

@section('titulo_head', 'Inicio')

@section('contenido')
    <main>
        @if (session()->has('mensaje'))
            <div class="container my-5 mx-auto alert alert-danger alert-dismissible " style="width: 75%;">{{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1 class="text-center">Codigo CSV</h1>
        <div class="container-fluid">
            <form action="{{ route('show') }}" method="POST" enctype="multipart/form-data" class="row g-3 mt-3">
            @csrf
                <p class="text-center">
                    <label for="csv">Inserte el Codigo CSV</label>
                </p>
                <p class="text-center">
                    <input type="text" id="csv" name="csv" required>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </p>
            </form>
        </div>
    </main>
@endsection