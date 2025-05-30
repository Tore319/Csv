@extends('../layouts/plantilla')

@section('titulo_head', 'Subir archivos')

@section('contenido')
    @if (session()->has('mensaje'))
        <div class="container my-5 mx-auto alert alert-danger alert-dismissible " style="width: 75%;">{{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="text-center">Subir Archivos</h1>
    <div class="container my-5 mx-auto">
        <form action="{{ route('csv.store') }}" method="POST" enctype="multipart/form-data" class="row g-3 mt-3">
        @csrf
            <div class="col-md-6">
                <label for="dni" class="form-label">DNI: </label>
                <input type="text" class="form-control" id="dni" name="dni" value="{{old('dni')}}" required>
            </div>
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre: </label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{old('nombre')}}" required>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos: </label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{old('apellidos')}}">
            </div>
            <div class="col-md-6">
                <label for="correo" class="form-label">Correo electronico: </label>
                <input type="email" class="form-control" id="correo" name="correo" value="{{old('correo')}}" 
                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                required>
            </div>
            <div class="col-md-6">
                <label for="archivo" class="form-label">Archivo: </label>
                <input type="file" class="form-control" id="archivo" name="archivo" accept="application/pdf" required>
            </div>
            <div class="col-md-6">
                <label for="tipoDocumento" class="form-label">Tipo Archivo: </label>
                <p>
                    <select name="tipoDocumento" id="tipoDocumento" style="margin-top: 10px;" required>
                        <option value="Certificado matricula">Certificado matricula</option>
                        <option value="Titulo academico">Titulo academico</option>
                        <option value="Certificado Digital empresa">Certificado Digital empresa</option>
                        <option value="Certificado Digital gobierno">Certificado Digital gobierno</option>
                    </select>
                </p>
            </div>
            <button type="submit">Enviar</button>
        </form>
    </div>
@endsection