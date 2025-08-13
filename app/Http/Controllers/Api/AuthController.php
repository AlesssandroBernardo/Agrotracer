<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @unauthenticated
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                Log::logError(
                    'registro_usuario_validacion',
                    'Error de validación en registro de usuario',
                    [
                        'errores_validacion' => $validator->errors()->toArray(),
                        'datos_enviados' => $request->except(['password', 'password_confirmation'])
                    ],
                    null 
                );

                return response()->json([
                    'exito' => false,
                    'codMensaje' => 0,
                    'mensajeUsuario' => 'Error en la validación',
                    'user' => null,
                    'datoAdicional' => [
                        'errores' => $validator->errors()
                    ]
                ], 200);
            }

            // Crear usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Crear token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'exito' => true,
                'codMensaje' => 1,
                'mensajeUsuario' => 'Usuario registrado exitosamente',
                'user' => [
                    'id' => $user->id
                ],
                'datoAdicional' => [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'correo' => $user->email,
                    'fechaCreacion' => $user->created_at,
                    'token' => [
                        'access_token' => $token,
                        'token_type' => 'Bearer'
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            // Log del error del servidor
            Log::logError(
                'registro_usuario_error',
                'Error interno en registro de usuario: ' . $e->getMessage(),
                [
                    'mensaje_error' => $e->getMessage(),
                    'archivo' => $e->getFile(),
                    'linea' => $e->getLine(),
                    'datos_enviados' => $request->except(['password', 'password_confirmation'])
                ],
                null // Sin usuario autenticado
            );

            return response()->json([
                'exito' => false,
                'codMensaje' => 0,
                'mensajeUsuario' => 'Error interno del servidor',
                'user' => null,
                'datoAdicional' => [
                    'error' => $e->getMessage()
                ]
            ], 200);
        }
    }

    /**
     * @unauthenticated
     */
    public function login(Request $request)
    {
        try {
            // Validación de datos
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                // Log del error de validación
                Log::logError(
                    'login_usuario_validacion',
                    'Error de validación en login de usuario',
                    [
                        'errores_validacion' => $validator->errors()->toArray(),
                        'email_enviado' => $request->email
                    ],
                    null // Sin usuario autenticado
                );

                return response()->json([
                    'exito' => false,
                    'codMensaje' => 0,
                    'mensajeUsuario' => 'Error en la validación',
                    'user' => null,
                    'datoAdicional' => [
                        'errores' => $validator->errors()
                    ]
                ], 200);
            }

            // Verificar credenciales
            if (!Auth::attempt($request->only('email', 'password'))) {
                // Log del intento de login fallido
                Log::logError(
                    'login_credenciales_invalidas',
                    'Intento de login con credenciales inválidas',
                    [
                        'email_intento' => $request->email,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent()
                    ],
                    null // Sin usuario autenticado
                );

                return response()->json([
                    'exito' => false,
                    'codMensaje' => 0,
                    'mensajeUsuario' => 'Credenciales inválidas',
                    'user' => null,
                    'datoAdicional' => null
                ], 200);
            }

            // Obtener usuario y crear token
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'exito' => true,
                'codMensaje' => 1,
                'mensajeUsuario' => 'Login exitoso',
                'user' => [
                    'id' => $user->id
                ],
                'datoAdicional' => [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'correo' => $user->email,
                    'fechaCreacion' => $user->created_at,
                    'token' => [
                        'access_token' => $token,
                        'token_type' => 'Bearer'
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            // Log del error del servidor
            Log::logError(
                'login_usuario_error',
                'Error interno en login de usuario: ' . $e->getMessage(),
                [
                    'mensaje_error' => $e->getMessage(),
                    'archivo' => $e->getFile(),
                    'linea' => $e->getLine(),
                    'email_enviado' => $request->email
                ],
                null // Sin usuario autenticado
            );

            return response()->json([
                'exito' => false,
                'codMensaje' => 0,
                'mensajeUsuario' => 'Error interno del servidor',
                'user' => null,
                'datoAdicional' => [
                    'error' => $e->getMessage()
                ]
            ], 200);
        }
    }


    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            
            // Eliminar token actual
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'exito' => true,
                'codMensaje' => 1,
                'mensajeUsuario' => 'Logout exitoso',
                'user' => [
                    'id' => $user->id
                ],
                'datoAdicional' => null
            ], 200);
        } catch (\Exception $e) {
            // Log del error del servidor
            Log::logError(
                'logout_usuario_error',
                'Error interno en logout de usuario: ' . $e->getMessage(),
                [
                    'mensaje_error' => $e->getMessage(),
                    'archivo' => $e->getFile(),
                    'linea' => $e->getLine(),
                    'user_id' => $request->user()->id ?? null
                ],
                $request->user()->id ?? null
            );

            return response()->json([
                'exito' => false,
                'codMensaje' => 0,
                'mensajeUsuario' => 'Error interno del servidor',
                'user' => $request->user() ? ['id' => $request->user()->id] : null,
                'datoAdicional' => [
                    'error' => $e->getMessage()
                ]
            ], 200);
        }
    }

    /**
     * Obtener información del usuario autenticado
     */
    public function me(Request $request)
    {
        try {
            $user = $request->user();
            return response()->json([
                'exito' => true,
                'codMensaje' => 1,
                'mensajeUsuario' => 'Información del usuario obtenida exitosamente',
                'user' => [
                    'id' => $user->id
                ],
                'datoAdicional' => [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'correo' => $user->email,
                    'fechaCreacion' => $user->created_at,
                    'fechaActualizacion' => $user->updated_at
                ]
            ], 200);
        } catch (\Exception $e) {
            // Log del error del servidor
            Log::logError(
                'me_usuario_error',
                'Error interno en obtener información de usuario: ' . $e->getMessage(),
                [
                    'mensaje_error' => $e->getMessage(),
                    'archivo' => $e->getFile(),
                    'linea' => $e->getLine(),
                    'user_id' => $request->user()->id ?? null
                ],
                $request->user()->id ?? null
            );

            return response()->json([
                'exito' => false,
                'codMensaje' => 0,
                'mensajeUsuario' => 'Error interno del servidor',
                'user' => $request->user() ? ['id' => $request->user()->id] : null,
                'datoAdicional' => [
                    'error' => $e->getMessage()
                ]
            ], 200);
        }
    }
}
