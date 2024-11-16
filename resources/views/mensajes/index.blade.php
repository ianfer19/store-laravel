@extends('layouts.app')

@section('content')
<div class="row h-100">
    <!-- Barra lateral con usuarios, ahora anclada a la izquierda -->
    <div class="col-3 border-end p-0" style="max-height: 100vh; overflow-y: auto;">
        <h5 class="p-3">Conversaciones</h5>
        <ul class="list-group">
            @foreach ($usuariosConUltimosMensajes as $usuario)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $usuario['name'] }}</strong>
                    <p class="mb-0 text-muted" style="font-size: 0.9em;">
                        {{ Str::limit($usuario['ultimo_mensaje'], 30) }}
                    </p>
                    <small class="text-muted">
                        @if($usuario['fecha_ultimo_mensaje'])
                            {{ \Carbon\Carbon::parse($usuario['fecha_ultimo_mensaje'])->diffForHumans() }}
                        @else
                        @endif
                    </small>  <!-- Fecha relativa -->
                </div>
                <a href="{{ route('mensajes.conversacion', ['userId' => $usuario['id']]) }}" class="btn btn-sm btn-link text-secondary">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Panel principal de mensajes, con el formulario de entrada al final -->
    <div class="col-9 h-100 d-flex flex-column">
        @if($otroUsuario)
        <!-- Encabezado con el nombre del usuario -->
        <div class="bg-light p-3 border-bottom">
            <h4 class="mb-0">{{ $otroUsuario->name }}</h4>
        </div>

        <!-- Mensajes -->
        <div class="p-3 flex-grow-1 overflow-auto" style="min-height: 500px;max-height:500px;">
            @foreach ($mensajes as $mensaje)
                @if ($mensaje->id_usuario_emisor === auth()->id())
                <!-- Mensaje enviado -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="p-3 bg-info text-white rounded shadow-sm" style="max-width: 70%;">
                        <p>{{ $mensaje->contenido}}</p> <!-- Limitar a 20 caracteres -->
                        <p class="small text-muted mt-1">
                            {{ $mensaje->fecha_enviado ? $mensaje->fecha_enviado : '' }}
                        </p> <!-- Fecha del mensaje -->
                    </div>
                </div>
                @else
                <!-- Mensaje recibido -->
                <div class="d-flex justify-content-start mb-3">
                    <div class="p-3 bg-primary text-white rounded shadow-sm" style="max-width: 70%;">
                        <p>{{$mensaje->contenido}}</p> <!-- Limitar a 20 caracteres -->
                        <p class="small text-muted mt-1">
                            {{ $mensaje->fecha_enviado ? $mensaje->fecha_enviado : '' }}
                        </p> <!-- Fecha del mensaje -->
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <!-- Input para enviar nuevo mensaje -->
        <form action="{{ route('mensajes.enviar', ['userId' => $otroUsuario->id]) }}" method="POST" class="p-3 border-top mt-auto" style="background: white;">
            @csrf
            <div class="input-group">
                <input type="text" name="contenido" class="form-control" placeholder="Escribe un mensaje..." required>
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
        @else
        <p>No hay usuarios para mostrar mensajes.</p>
        @endif
    </div>
</div>
@endsection
