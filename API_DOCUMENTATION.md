# API Documentation - Agrotracer

## Autenticación

La API utiliza Laravel Sanctum para la autenticación mediante tokens Bearer.

### Base URL
```
http://localhost:8000/api
```

## Endpoints de Autenticación

### 1. Registro de Usuario
**POST** `/api/auth/register`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body:**
```json
{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Respuesta exitosa (201):**
```json
{
    "exito": true,
    "codMensaje": 1,
    "mensajeUsuario": "Usuario registrado exitosamente",
    "datoAdicional": {
        "id": 1,
        "nombre": "Juan Pérez",
        "correo": "juan@example.com",
        "fechaCreacion": "2025-08-09T02:45:00.000000Z",
        "token": {
            "access_token": "1|abcdef123456...",
            "token_type": "Bearer"
        }
    }
}
```

### 2. Login de Usuario
**POST** `/api/auth/login`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body:**
```json
{
    "email": "juan@example.com",
    "password": "password123"
}
```

**Respuesta exitosa (200):**
```json
{
    "exito": true,
    "codMensaje": 1,
    "mensajeUsuario": "Login exitoso",
    "datoAdicional": {
        "id": 1,
        "nombre": "Juan Pérez",
        "correo": "juan@example.com",
        "fechaCreacion": "2025-08-09T02:45:00.000000Z",
        "token": {
            "access_token": "2|xyz789...",
            "token_type": "Bearer"
        }
    }
}
```

### 3. Información del Usuario Autenticado
**GET** `/api/auth/me`

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {tu_token_aqui}
```

**Respuesta exitosa (200):**
```json
{
    "exito": true,
    "codMensaje": 1,
    "mensajeUsuario": "Información del usuario obtenida exitosamente",
    "datoAdicional": {
        "id": 1,
        "nombre": "Juan Pérez",
        "correo": "juan@example.com",
        "fechaCreacion": "2025-08-09T02:45:00.000000Z",
        "fechaActualizacion": "2025-08-09T02:45:00.000000Z"
    }
}
```

### 4. Logout de Usuario
**POST** `/api/auth/logout`

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {tu_token_aqui}
```

**Respuesta exitosa (200):**
```json
{
    "exito": true,
    "codMensaje": 1,
    "mensajeUsuario": "Logout exitoso",
    "datoAdicional": null
}
```

## Respuestas de Error

### Error de Validación (422):
```json
{
    "exito": false,
    "codMensaje": 0,
    "mensajeUsuario": "Error en la validación",
    "datoAdicional": {
        "errores": {
            "email": ["El campo email es requerido"],
            "password": ["El campo password debe tener al menos 8 caracteres"]
        }
    }
}
```

### Error de Autenticación (401):
```json
{
    "exito": false,
    "codMensaje": 0,
    "mensajeUsuario": "Credenciales inválidas",
    "datoAdicional": null
}
```

### Error Interno del Servidor (500):
```json
{
    "exito": false,
    "codMensaje": 0,
    "mensajeUsuario": "Error interno del servidor",
    "datoAdicional": {
        "error": "Mensaje de error detallado"
    }
}
```

## Códigos de Mensaje

- **codMensaje: 1** = Operación exitosa
- **codMensaje: 0** = Error en la operación

## Cómo usar el token

Una vez que obtengas el token de acceso del login o registro, debes incluirlo en el header `Authorization` de todas las peticiones a endpoints protegidos:

```
Authorization: Bearer tu_token_aqui
```

## Ejemplos con cURL

### Registro:
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login:
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "juan@example.com",
    "password": "password123"
  }'
```

### Obtener información del usuario:
```bash
curl -X GET http://localhost:8000/api/auth/me \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer tu_token_aqui"
```

### Logout:
```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer tu_token_aqui"
```