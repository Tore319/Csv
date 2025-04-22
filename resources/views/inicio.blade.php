@extends('./layouts/plantilla')

@section('titulo_head', 'Inicio')

@section('contenido')
    <main>
        <h1 class="text-center">Codigo CSV</h1>
        <div class="container-fluid">
            <form action="{{ route('ver') }}" method="POST" enctype="multipart/form-data" class="row g-3 mt-3">
            @csrf
                <p class="text-center">
                    <label for="csv">Inserte el Codigo CSV</label>
                </p>
                <p class="text-center">
                    <input type="text" id="csv" name="csv">
                </p>
                <p class="text-center">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </p>
            </form>
        </div>
    </main>
@endsection