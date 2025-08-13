# API Logs - Documentación Simple

## 📋 Endpoints para logs

### 1. Obtener todos los logs
**POST** `/api/logs`

**Descripción:** Obtiene todos los logs de errores del sistema

**Headers requeridos:**
```
Authorization: Bearer {tu_token}
Content-Type: application/json
Accept: application/json
```

**Body:** (vacío - no se necesita enviar datos)
```json
{}
```

**Respuesta exitosa (200):**
```json
{
    "exito": true,
    "codMensaje": 1,
    "mensajeUsuario": "Logs obtenidos exitosamente",
    "datoAdicional": {
        "logs": [
            {
                "id": 1,
                "user_id": 1,
                "action": "login_error",
                "description": "Error durante el login de usuario: Database connection failed",
                "data": {
                    "email": "user@test.com",
                    "error_message": "Database connection failed",
                    "error_file": "/path/to/file.php",
                    "error_line": 45
                },
                "created_at": "2025-08-09T10:30:00.000000Z",
                "updated_at": "2025-08-09T10:30:00.000000Z",
                "user": {
                    "id": 1,
                    "name": "Alessandro",
                    "email": "alessandro@test.com"
                }
            }
        ],
        "total": 25
    }
}
```

### 2. Obtener logs de un usuario específico
**POST** `/api/logs/{id}`

**Descripción:** Obtiene todos los logs de errores de un usuario específico

**Parámetros:**
- `id`: ID del usuario (número entero)

**Headers requeridos:**
```
Authorization: Bearer {tu_token}
Content-Type: application/json
Accept: application/json
```

**Body:** (vacío - no se necesita enviar datos)
```json
{}
```

**Respuesta exitosa (200):**
```json
{
    "exito": true,
    "codMensaje": 1,
    "mensajeUsuario": "Logs del usuario obtenidos exitosamente",
    "datoAdicional": {
        "user_id": 1,
        "logs": [
            {
                "id": 1,
                "user_id": 1,
                "action": "login_error",
                "description": "Error durante el login de usuario",
                "data": {...},
                "created_at": "2025-08-09T10:30:00.000000Z",
                "updated_at": "2025-08-09T10:30:00.000000Z",
                "user": {
                    "id": 1,
                    "name": "Alessandro",
                    "email": "alessandro@test.com"
                }
            }
        ],
        "total": 5
    }
}
```

**Respuesta cuando usuario no existe (200):**
```json
{
    "exito": false,
    "codMensaje": 0,
    "mensajeUsuario": "Usuario no encontrado",
    "datoAdicional": null
}
```

**Respuesta cuando ID es inválido (200):**
```json
{
    "exito": false,
    "codMensaje": 0,
    "mensajeUsuario": "ID de usuario inválido",
    "datoAdicional": null
}
```

**Respuesta de error (200):**
```json
{
    "exito": false,
    "codMensaje": 0,
    "mensajeUsuario": "Error interno del servidor",
    "datoAdicional": {
        "error": "Error message"
    }
}
```

## 🔍 Ejemplos con cURL

### Obtener todos los logs:
```bash
curl -X POST http://localhost:8000/api/logs \
  -H "Authorization: Bearer tu_token_aqui" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{}'
```

### Obtener logs de un usuario específico:
```bash
curl -X POST http://localhost:8000/api/logs/1 \
  -H "Authorization: Bearer tu_token_aqui" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{}'
```

## 🔒 Notas importantes

- **Autenticación requerida:** Debes estar autenticado con un token válido
- **Método POST:** Aunque sea para obtener datos, siempre usa POST
- **Validación de ID:** El endpoint `/logs/{id}` valida que el ID sea un número válido
- **Usuario no encontrado:** Si el usuario no existe, se retorna un mensaje específico
- **Información del usuario:** Incluye datos del usuario asociado a cada log
- **Datos seguros:** Las contraseñas y datos sensibles no se almacenan en los logs
