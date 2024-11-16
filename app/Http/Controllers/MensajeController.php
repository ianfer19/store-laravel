<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    // Método para mostrar la vista de conversaciones
    public function index()
    {
        // Obtener todos los usuarios, excepto el usuario autenticado
        $usuarios = User::where('id', '!=', Auth::id())->get();  // Obtienes los usuarios con los que el usuario autenticado ha interactuado
        
        // Crear un array para almacenar los últimos mensajes
        $usuariosConUltimosMensajes = [];
    
        foreach ($usuarios as $usuario) {
            // Obtener el último mensaje entre el usuario autenticado y el otro usuario
            $ultimoMensaje = $this->obtenerUltimoMensaje($usuario->id);  // Método que ya tienes para obtener el último mensaje
            $usuariosConUltimosMensajes[] = [
                'id' => $usuario->id,
                'name' => $usuario->name,
                'ultimo_mensaje' => $ultimoMensaje['ultimo_mensaje'],
                'fecha_ultimo_mensaje' => $ultimoMensaje['fecha_ultimo_mensaje'],  // Asume que 'fecha' es la fecha del último mensaje
            ];
        }
    
        // Ordenar los usuarios por la fecha del último mensaje (más reciente primero)
        $usuariosConUltimosMensajes = collect($usuariosConUltimosMensajes)->sortByDesc('fecha_ultimo_mensaje');
    
        // Obtener los mensajes entre el usuario autenticado y el otro usuario
        $otroUsuario = null;
        $mensajes = [];
    
        // Si existe un usuario con el que se desea conversar (por ejemplo, un usuario en la lista de contactos)
        if ($usuarios->count() > 0) {
            $otroUsuario = $usuarios->first(); // Aquí seleccionamos al primer usuario de la lista como ejemplo, esto lo puedes modificar según tu lógica
            $mensajes = $this->obtenerMensajesEntre($otroUsuario->id);  // Obtener los mensajes con el primer usuario, por ejemplo
        }
    
        // Pasar los usuarios con últimos mensajes y la conversación actual a la vista
        return view('mensajes.index', compact('usuariosConUltimosMensajes', 'otroUsuario', 'mensajes'));
    }
    

    public function obtenerUltimoMensaje($userId)
    {
        // Obtener el último mensaje entre el usuario autenticado y el otro usuario
        $mensaje = Mensaje::where(function ($query) {
                $query->where('id_usuario_emisor', Auth::id())
                      ->orWhere('id_usuario_destino', Auth::id());
            })
            ->where(function ($query) use ($userId) {
                $query->where('id_usuario_emisor', $userId)
                      ->orWhere('id_usuario_destino', $userId);
            })
            ->latest('fecha_enviado')  // Ordenar por la fecha de envío, más reciente primero
            ->first();
    
        // Retornar tanto el contenido como la fecha del último mensaje
        return [
            'ultimo_mensaje' => $mensaje ? $mensaje->contenido : 'No hay mensajes aún',
            'fecha_ultimo_mensaje' => $mensaje ? $mensaje->fecha_enviado : null,  // Añadir la fecha del último mensaje
        ];
    }
    

    // Método para obtener todos los mensajes entre el usuario autenticado y otro usuario
    public function obtenerMensajesEntre($userId)
{
    $user = Auth::user();  // Manually fetch the authenticated user

    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    $mensajes = Mensaje::where(function ($query) use ($userId, $user) {
        $query->where(function ($query) use ($userId, $user) {
            $query->where('id_usuario_emisor', $user->id)
                  ->where('id_usuario_destino', $userId);
        })
        ->orWhere(function ($query) use ($userId, $user) {
            $query->where('id_usuario_emisor', $userId)
                  ->where('id_usuario_destino', $user->id);
        });
    })
    ->orderBy('fecha_enviado', 'asc')
    ->get(); // Asegúrate de que `get()` esté llamando a la colección de mensajes

    return $mensajes;
}


public function conversacion($userId)
{
    $user = Auth::user();  // Traemos el usuario autenticado

    // Obtener todos los usuarios, excepto el usuario autenticado
    $usuarios = User::where('id', '!=', Auth::id())->get();

    // Crear un array para almacenar los últimos mensajes
    $usuariosConUltimosMensajes = [];

    foreach ($usuarios as $usuario) {
        // Obtener el último mensaje entre el usuario autenticado y el otro usuario
        $ultimoMensaje = $this->obtenerUltimoMensaje($usuario->id);  // Método que ya tienes para obtener el último mensaje
        $usuariosConUltimosMensajes[] = [
            'id' => $usuario->id,
            'name' => $usuario->name,
            'ultimo_mensaje' => $ultimoMensaje['ultimo_mensaje'],
            'fecha_ultimo_mensaje' => $ultimoMensaje['fecha_ultimo_mensaje'],  // Asume que 'fecha' es la fecha del último mensaje
        ];
    }

    // Ordenar los usuarios por la fecha del último mensaje (más reciente primero)
    $usuariosConUltimosMensajes = collect($usuariosConUltimosMensajes)->sortByDesc('fecha_ultimo_mensaje');

    // Obtener los mensajes entre el usuario autenticado y el otro usuario (la conversación actual)
    $mensajes = $this->obtenerMensajesEntre($userId);  // Aquí obtienes los mensajes entre el usuario actual y el seleccionado

    // Obtener el usuario con el que se va a conversar
    $otroUsuario = User::findOrFail($userId);

    // Pasar los datos a la vista
    return view('mensajes.conversacion', compact('otroUsuario', 'mensajes', 'usuariosConUltimosMensajes'));
}

    

    // Método para enviar un mensaje
    public function enviarMensaje(Request $request, $userId)
    {
        // Validar el contenido del mensaje
        $request->validate([
            'contenido' => 'required|string|max:500',
        ]);
    
        // Obtener la fecha y hora actual para los campos de fecha
        $fechaActual = now();
    
        // Crear el mensaje
        Mensaje::create([
            'id_usuario_emisor' => Auth::id(),  // Usuario autenticado (emisor)
            'id_usuario_destino' => $userId,    // Usuario destino
            'contenido' => $request->input('contenido'),
            'estado_lectura' => false,  // Suponiendo que el mensaje no se ha leído al enviarlo
            'fecha_enviado' => $fechaActual, // Usamos la fecha actual
            'fecha_recibido' => $fechaActual, // Usamos la misma fecha para cuando el mensaje es recibido
        ]);
    
        // Redirigir de vuelta a la conversación
        return redirect()->route('mensajes.conversacion', ['userId' => $userId])
            ->with('success', 'Mensaje enviado correctamente.');
    }
    
}
