<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Obtener todos los logs de errores
     */
    public function index(Request $request)
    {
        try {
            $logs = Log::with('user:id,name,email')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'exito' => true,
                'codMensaje' => 1,
                'mensajeUsuario' => 'Logs obtenidos exitosamente',
                'datoAdicional' => [
                    'logs' => $logs,
                    'total' => $logs->count()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'exito' => false,
                'codMensaje' => 0,
                'mensajeUsuario' => 'Error interno del servidor',
                'datoAdicional' => [
                    'error' => $e->getMessage()
                ]
            ], 200);
        }
    }

    /**
     * Obtener logs de un usuario específico por su ID
     */
    public function getLogsByUserId(Request $request, $id)
    {
        try {
            // Verificar que el ID sea válido
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'exito' => false,
                    'codMensaje' => 0,
                    'mensajeUsuario' => 'ID de usuario inválido',
                    'datoAdicional' => null
                ], 200);
            }

            $logs = Log::with('user:id,name,email')
                ->where('user_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Verificar si el usuario existe (si no hay logs, podría no existir)
            if ($logs->isEmpty()) {
                // Verificar si el usuario existe en la base de datos
                $userExists = \App\Models\User::find($id);
                if (!$userExists) {
                    return response()->json([
                        'exito' => false,
                        'codMensaje' => 0,
                        'mensajeUsuario' => 'Usuario no encontrado',
                        'datoAdicional' => null
                    ], 200);
                }
            }

            return response()->json([
                'exito' => true,
                'codMensaje' => 1,
                'mensajeUsuario' => 'Logs del usuario obtenidos exitosamente',
                'datoAdicional' => [
                    'user_id' => (int)$id,
                    'logs' => $logs,
                    'total' => $logs->count()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'exito' => false,
                'codMensaje' => 0,
                'mensajeUsuario' => 'Error interno del servidor',
                'datoAdicional' => [
                    'error' => $e->getMessage()
                ]
            ], 200);
        }
    }
}
