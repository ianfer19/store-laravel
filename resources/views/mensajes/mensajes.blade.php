@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Barra lateral con usuarios -->
    <div class="col-3 border-end" style="max-height: 80vh; overflow-y: auto;">
        <h5 class="p-3">Conversaciones</h5>
        <ul class="list-group">
            @foreach ($usuarios as $usuario)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $usuario['name'] }}</strong>
                    <p class="mb-0 text-muted" style="font-size: 0.9em;">{{ $usuario['ultimo_mensaje'] }}</p>
                </div>
                <a href="{{ route('mensajes.conversacion', ['userId' => $usuario['id']]) }}" class="btn btn-sm btn-link text-secondary">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Panel principal de mensajes -->
    <div class="col-9">
        <!-- Encabezado con el nombre del usuario -->
        <div class="bg-light p-3 border-bottom">
            <h4 class="mb-0">{{ $otroUsuario->name }}</h4>
        </div>

        <!-- Mensajes -->
        <div class="p-3" style="max-height: 60vh; overflow-y: auto;" id="mensajes">
            @foreach ($mensajes as $mensaje)
                @if ($mensaje->id_usuario_emisor === auth()->id())
                <!-- Mensaje enviado -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="p-3 bg-info text-white rounded shadow-sm" style="max-width: 70%;">
                        {{ $mensaje->contenido }}
                    </div>
                </div>
                @else
                <!-- Mensaje recibido -->
                <div class="d-flex justify-content-start mb-3">
                    <div class="p-3 bg-primary text-white rounded shadow-sm" style="max-width: 70%;">
                        {{ $mensaje->contenido }}
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <!-- Input para enviar nuevo mensaje -->
        <form action="{{ route('mensajes.enviar', ['userId' => $otroUsuario->id]) }}" method="POST" class="p-3 border-top">
            @csrf
            <div class="input-group">
                <input type="text" name="contenido" class="form-control" placeholder="Escribe un mensaje..." required>
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
