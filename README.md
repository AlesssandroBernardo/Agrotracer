# Agrotracer API

Sistema de trazabilidad agrícola desarrollado con Laravel para el manejo y seguimiento de productos agrícolas.

## 🚀 Características

- **API RESTful** completa para gestión de datos agrícolas
- **Autenticación segura** con Laravel Sanctum (tokens Bearer)
- **Sistema de usuarios** con registro, login y logout
- **Base de datos** SQLite para desarrollo
- **Documentación completa** de la API

## 📋 Requisitos

- PHP >= 8.2
- Composer
- SQLite (incluido con PHP)
- Git

## 🛠️ Instalación

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/AlesssandroBernardo/Agrotracer.git
   cd agrotracer
   ```

2. **Instalar dependencias:**
   ```bash
   composer install
   ```

3. **Configurar el entorno:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Ejecutar migraciones:**
   ```bash
   php artisan migrate
   ```

5. **Iniciar servidor de desarrollo:**
   ```bash
   php artisan serve
   ```

## 📖 Documentación de la API

La documentación completa de la API se encuentra en: [API_DOCUMENTATION.md](./API_DOCUMENTATION.md)

### Endpoints principales:

- `POST /api/auth/register` - Registro de usuarios
- `POST /api/auth/login` - Inicio de sesión
- `GET /api/auth/me` - Información del usuario autenticado
- `POST /api/auth/logout` - Cerrar sesión

### Ejemplo de uso:

```bash
# Registro de usuario
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Alessandro Bernardo",
    "email": "alessandro@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "alessandro@example.com",
    "password": "password123"
  }'
```

## 🏗️ Arquitectura

- **Framework:** Laravel 11
- **Autenticación:** Laravel Sanctum
- **Base de datos:** SQLite (desarrollo)
- **API:** RESTful con respuestas JSON
- **Control de versiones:** Git con GitHub

## 🔧 Tecnologías utilizadas

- **Backend:** PHP 8.2+ con Laravel 11
- **Autenticación:** Laravel Sanctum (tokens Bearer)
- **Base de datos:** SQLite
- **Control de versiones:** Git/GitHub
- **Servidor web:** Apache (XAMPP) / Artisan serve

## 📁 Estructura del proyecto

```
agrotracer/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       └── AuthController.php
│   │   └── Requests/
│   │       └── Auth/
│   └── Models/
│       └── User.php
├── config/
│   ├── auth.php
│   └── sanctum.php
├── database/
│   ├── migrations/
│   └── database.sqlite
├── routes/
│   ├── api.php
│   └── web.php
└── API_DOCUMENTATION.md
```

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

## 📞 Contacto

Alessandro Bernardo - ABernardoE@hotmail.com

Enlace del proyecto: [https://github.com/AlesssandroBernardo/Agrotracer](https://github.com/AlesssandroBernardo/Agrotracer)

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
