# 🐖 TrackPoint - Sistema de control de producción

Aplicación web para el control de producción en una industria faenadora de porcinos. Desarrollado en PHP siguiendo el patrón MVC, con interfaz moderna usando Bootstrap 5.

---

## 🚀 Requisitos

- PHP >= 7.4
- Servidor Apache o Nginx
- Extensiones SQL Server (`pdo_sqlsrv`, `sqlsrv`) habilitadas en PHP

---

## 📁 Estructura de carpetas

```
app/
  auth/
    controllers/
    models/
    views/
      login.view.php
  dashboard/
    controllers/
    models/
    views/
      home.view.php
  layouts/
    layout.scripts.php
    layout.view.php
  modules/
    configuracion/
    produccion/
    recepcion/
    sistema/
    ventas/
    module.controller.php
    module.view.php
core/
  config/
  helpers/
  logs/
  middleware/
  router.php
public/
  assets/
    css/
      style.css
    fonts/
    icons/
    images/
    js/
  index.php

```

---

## 🔒 Middleware de autenticación

Para proteger vistas privadas, incluir en la parte superior del archivo `.php`:

```php
require_once __DIR__ . '/../../core/middleware/auth.middleware.php';
```

Este middleware redirige al login si no hay sesión iniciada.

---

## 🧪 Login de prueba

Credenciales configuradas en la base de datos (hasheadas con `password_hash()`).

---

## 📌 Notas para los desarrolladores

- Usá `public/index.php` como punto de entrada del sistema.
- Todo nuevo módulo debe seguir la estructura de carpetas MVC.
- Usar siempre `session_start();` al inicio de controladores o middleware.

---

## 🛠️ En desarrollo

- [x] Login
- [x] Middleware de sesión
- [x] Dashboard estático
- [x] Conexión dinámica con base de datos
- [ ] Módulo de producción
- [ ] Módulo de expedición
- [ ] Panel de configuración

---

## 📸 Logo

El logo debe estar en:  
`/public/assets/images/logo_fondo_transparente.png`

---

## 👥 Créditos

Desarrollado por:

- María Belén De Franchi
- Juan Herrera

---
