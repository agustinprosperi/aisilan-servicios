---
name: aisilan-servicios
description: Agente especializado en el sistema AISILAN Servicios. Usar para tareas de desarrollo, mantenimiento, depuración, generación de código y consultas sobre la arquitectura del proyecto. Ideal para: crear nuevos módulos CRUD, modificar modelos/controladores/vistas, generar consultas SQL, implementar reportes, o resolver errores del sistema.
---

# Contexto del Proyecto: AISILAN Servicios

## Descripción General
Sistema de gestión de servicios profesionales denominado **"A.I.S.I.L.A.N."** (Sistema de administración de servicios). Permite gestionar clientes, centros de trabajo, proyectos, eventos/servicios, trabajadores y generar reportes de imputación de horas.

## Stack Tecnológico
- **Framework**: CodeIgniter 3 (PHP MVC)
- **PHP**: >= 5.3.7 (legacy)
- **Base de datos**: MySQL/MariaDB, driver `mysqli`
- **Timezone**: `Europe/Madrid`
- **URL local de desarrollo**: `http://agustin.test/aisilan-servicios`
- **BD nombre**: `aisilan_servicios`
- **BD host**: `localhost:3307`
- **Librerías Composer**: `mpdf/mpdf ^8.0` (generación PDF)

## Estructura del Proyecto
```
aisilan-servicios/
├── application/
│   ├── config/          # Configuración CI (config.php, database.php, routes.php, autoload.php)
│   ├── controllers/
│   │   ├── backend/     # Todos los controladores (solo backend, sin frontend activo)
│   │   └── frontend/    # Vacío actualmente
│   ├── models/          # Modelos con sufijo _modelo.php
│   ├── views/
│   │   ├── backend/     # Vistas organizadas por módulo
│   │   └── layouts/     # Plantillas (backend/, frontend/)
│   ├── libraries/       # Layout, Message, Myemail, Ciqrcode, OpenSpout
│   ├── helpers/         # miayuda_helper.php
│   ├── hooks/           # footer_hook.php
│   └── language/        # english/, spanish/
├── public/
│   ├── backend/         # Assets backend (css/, js/, img/, fonts/)
│   └── frontend/        # Assets frontend (css/, js/, img/)
├── vendor/              # Dependencias Composer
└── system/              # Core de CodeIgniter
```

## Routing
```php
// routes.php
$route['default_controller'] = 'backend/login';  // Raíz va al login
$route['backend']            = 'backend/index';
$route['backend/(:any)']     = 'backend/$1';
$route['(:any)']             = 'frontend/$1';
```

## Módulos / Controladores Backend

| Controlador         | Permiso base | Descripción                                      |
|---------------------|--------------|--------------------------------------------------|
| `Login`             | —            | Autenticación de usuarios                        |
| `Index`             | —            | Escritorio/Dashboard                             |
| `Admin`             | —            | Perfil del administrador logueado                |
| `Usuario`           | `usu`        | Gestión de trabajadores/usuarios                 |
| `Clientes`          | `cli`        | Gestión de clientes                              |
| `Centros`           | `cen`        | Centros de trabajo                               |
| `Proyectos`         | `pro`        | Gestión de proyectos                             |
| `Eventos`           | `eve`        | Eventos/servicios (Simple y Multiple)            |
| `Tareas`            | `tar`        | Tipos de tareas                                  |
| `Categorias`        | `cat`        | Categorías de tareas                             |
| `Horquillahoraria`  | `hor`        | Bandas horarias salariales                       |
| `Notificaciones`    | —            | Notificaciones del sistema                       |
| `Reportes`          | —            | Reportes con filtros y exportación Excel         |
| `Feriados`          | `fer`        | Gestión de días festivos                         |
| `Provincias`        | `prov`       | Datos geográficos (provincias)                   |
| `Localidades`       | `loc`        | Datos geográficos (localidades)                  |
| `Institucion`       | —            | Configuración de la institución/empresa          |

## Tablas de Base de Datos (prefijo `wfc_`)

### `usuario` (sin prefijo wfc_)
| Campo                   | Descripción                              |
|-------------------------|------------------------------------------|
| `usu_id`                | PK autoincrement                         |
| `usu_nombre`            | Nombre                                   |
| `usu_ap`                | Apellido paterno                         |
| `usu_am`                | Apellido materno                         |
| `usu_email`             | Email                                    |
| `usu_estado`            | 1=activo, 0=inactivo, 3=deshabilitado    |
| `usu_telefono`          | Teléfono                                 |
| `usu_celular`           | Celular                                  |
| `usu_dni`               | DNI/documento                            |
| `usu_sexo`              | m/f                                      |
| `usu_fecha_nac`         | Fecha de nacimiento                      |
| `usu_tipo`              | `Administrador`, `Coordinador`, `Trabajador`, `Estudiante` |
| `usu_username`          | Nombre de usuario para login             |
| `usu_password`          | MD5 de la contraseña (legacy)            |
| `usu_fecha_registro`    | Fecha de alta                            |
| `usu_fecha_modificacion`| Última modificación                      |

### `wfc_client`
| Campo            | Descripción           |
|------------------|-----------------------|
| `cli_id`         | PK                    |
| `cli_name`       | Nombre del cliente    |
| `cli_cif`        | CIF/NIF               |
| `cli_contact`    | Persona de contacto   |
| `cli_phone`      | Teléfono              |
| `cli_mail`       | Email                 |
| `cli_description`| Descripción           |
| `cli_state`      | 1=activo, 0=inactivo  |

### `wfc_centers`
| Campo            | Descripción           |
|------------------|-----------------------|
| `cen_id`         | PK                    |
| `cen_name`       | Nombre del centro     |
| `cen_state`      | 1=activo, 0=inactivo  |
| `cen_description`| Descripción           |
| `prov_id`        | FK provincia          |
| `loc_id`         | FK localidad          |
| `hor_id`         | FK horquilla horaria  |

### `wfc_client_center`
Relación muchos-a-muchos entre clientes y centros: `(cli_id, cen_id)`

### `wfc_projects`
| Campo              | Descripción                          |
|--------------------|--------------------------------------|
| `pro_id`           | PK                                   |
| `pro_name`         | Nombre del proyecto                  |
| `pro_state`        | 1=activo, 0=inactivo, 2=cerrado      |
| `pro_description`  | Descripción                          |
| `pro_tipo_horario` | `Partido`, etc.                      |
| `cli_id`           | FK cliente                           |
| `coo_id`           | FK coordinador (usuario)             |

### `wfc_events`
| Campo          | Descripción                                          |
|----------------|------------------------------------------------------|
| `eve_id`       | PK                                                   |
| `eve_state`    | 1=activo, 0=inactivo, 2=cerrado                      |
| `eve_tipo`     | `Simple` o `Multiple`                                |
| `eve_date`     | Fecha del evento                                     |
| `eve_id_padre` | 0 para simples raíz; ID del evento Multiple padre    |
| `coo_id`       | FK coordinador                                       |
| `tra_id`       | FK trabajador asignado                               |
| `eve_imputacion`| Tipo de imputación                                  |

### `wfc_tareas`
| Campo            | Descripción            |
|------------------|------------------------|
| `tar_id`         | PK                     |
| `tar_name`       | Nombre de la tarea     |
| `tar_state`      | 1=activo, 0=inactivo   |
| `tar_description`| Descripción            |
| `tar_sigla`      | Sigla/abreviatura      |

### `wfc_categoria_tarea`
Relación entre categorías y tareas: `(tar_id, cat_id)`

### `wfc_horquilla_horaria`
| Campo                      | Descripción                      |
|----------------------------|----------------------------------|
| `hor_id`                   | PK                               |
| `hor_name`                 | Nombre de la banda               |
| `hor_laborable`            | Tarifa hora laborable diurna     |
| `hor_laborable_nocturno`   | Tarifa hora laborable nocturna   |
| `hor_festivo`              | Tarifa hora festiva diurna       |
| `hor_festivo_nocturno`     | Tarifa hora festiva nocturna     |
| `hor_state`                | 1=activo, 0=inactivo             |

### `wfc_notification`
| Campo        | Descripción                           |
|--------------|---------------------------------------|
| `not_id`     | PK                                    |
| `tra_id`     | FK trabajador (usuario)               |
| `eve_id`     | FK evento relacionado                 |
| `coo_id`     | FK coordinador                        |
| `not_state`  | 0=no leída, 1=leída                   |
| `created_at` | Timestamp de creación                 |

## Roles de Usuario y Permisos

### Tipos de usuario (`usu_tipo`)
- **Administrador**: acceso total al sistema
- **Coordinador**: ve solo sus propios proyectos (`pro.coo_id`) y eventos (`eve.coo_id`)
- **Trabajador**: ve solo sus propios eventos; las notificaciones se filtran por su `usu_id`
- **Estudiante**: acceso limitado (tipo legacy)

### Sistema de permisos
Se verifica con la función helper `verificarPermiso($permiso)` de `miayuda_helper.php`.  
Prefijos de permisos por módulo:
- `cli` / `cli_lista` / `cli_nuevo` — Clientes
- `pro` / `pro_lista` / `pro_nuevo` — Proyectos
- `eve` / `eve_lista` / `eve_nuevo` — Eventos
- `tar` / `tar_lista` / `tar_nuevo` — Tareas
- `usu` / `usu_lista` / `usu_nuevo` — Usuarios
- `cen` — Centros, `prov` — Provincias, `loc` — Localidades, `fer` — Feriados, `hor` — Horquilla horaria

## Librerías y Helpers Propios

### `Layout` (`application/libraries/Layout.php`)
Gestiona el sistema de plantillas/layouts.
```php
$this->layout->setLayout("backend/template_backend");
$this->layout->setTitle("Título de la página");
$this->layout->view("nombre_vista", $data);
```

### `Message` (`application/libraries/Message.php`)
Flash messages para feedback al usuario.
```php
$this->message->set("success", "Mensaje de éxito", true); // true = redirect
$this->message->set("error", "Mensaje de error");
```

### `Myemail` (`application/libraries/Myemail.php`)
Envío de emails del sistema.

### `OpenSpout` (`application/libraries/OpenSpout/`)
Exportación a Excel (XLS/XLSX).

### `miayuda_helper.php` (autoloaded)
Funciones globales disponibles en todos los controladores:
- `formato_fecha($date)` — formatea fecha en español
- `horaMinuto($fecha)` — retorna HH:MM
- `uri_current($controller, $sw, $model, ...)` — genera links de filtro activo/inactivo/todos con contadores
- `uri_current_user(...)` — variante para usuarios
- `verificarPermiso($permiso)` — verifica si el usuario logueado tiene el permiso dado
- `helperGetNotificacionesMenu($limit)` — obtiene notificaciones para el menú

## Autoload (application/config/autoload.php)
```php
$autoload['libraries'] = array("database", "session", "layout", "message");
// helpers y models se cargan manualmente en cada controlador
```

## Convenciones de Código

### Modelos
- Archivo: `application/models/Nombre_modelo.php`
- Clase: `class Nombre_modelo extends CI_Model`
- Métodos estándar: `getLista($sw='')`, `getCount($sw='')`, `insert()`, `edit()`, `delete($id)`, `getById($id)`
- `$sw` filtra por estado: `''`=todos, `'1'`=activos, `'0'`=inactivos, `'2'`=cerrados, `'all'`=todos

### Controladores
- Archivo: `application/controllers/backend/Nombre.php`
- Clase: `class Nombre extends CI_Controller`
- Siempre verificar sesión: `if(!@$this->session->userdata('username')) redirect(base_url().'backend/login');`
- Siempre verificar permisos: `if(!verificarPermiso("prefijo")) redirect(base_url().'backend/');`
- Variables de menú activo: `$this->current_*_lista`, `$this->current_*_insertar`, etc.

### Vistas
- Directorio: `application/views/backend/modulo/`
- Nomenclatura: `modulo_list_view.php`, `modulo_form_view.php`, `modulo_formver_view.php` (ver detalle)

### Sesión (datos disponibles)
```php
$this->session->userdata('username')        // nombre de usuario
$this->session->userdata('usu_id_actual')   // ID del usuario
$this->session->userdata('usu_tipo_actual') // tipo: Administrador/Coordinador/Trabajador
$this->session->userdata('usu_nombre')      // nombre
$this->session->userdata('usu_ap')          // apellido paterno
$this->session->userdata('usu_am')          // apellido materno
```

## Módulo de Reportes
El módulo de reportes (`Reportes.php` + `Reporte_modelo.php`) permite filtrar por:
- Rango de fechas (`date_range` en formato `Y-m-d - Y-m-d`)
- Trabajador (`tra_id`)
- Cliente (`cli_id`)
- Centro (`cen_id`)
- Proyecto (`pro_id`)
- Evento (`eve_id`)
- Tarea (`tar_id`)
- Imputación (`eve_imputacion`)
- Estado evento (`eve_state`)

Exporta a Excel mediante enlace con parámetros GET a `backend/reportes/export_xls/`.

## Módulo de Eventos
Los eventos tienen dos tipos:
- **Simple**: evento estándar, `eve_id_padre = 0`
- **Multiple**: evento contenedor con sub-eventos Simple; los hijos tienen `eve_id_padre = ID_del_multiple`

El listado de eventos soporta:
- Filtro por rango de fechas (guardado en sesión con `eve_date_filter`)
- Búsqueda por texto (GET `search_text`)
- Paginación
- Filtro por tipo (`Simple`/`Multiple`)

## Notas de Seguridad Importantes
- Las contraseñas están hasheadas con **MD5** (obsoleto e inseguro). Si se implementa nueva autenticación, usar `password_hash()` / `password_verify()`.
- Algunos modelos usan interpolación directa de variables en queries SQL (legacy). Usar `$this->db->escape_str()` en nuevas queries o el Query Builder de CI.
- La verificación de sesión usa `@` para suprimir errores (legacy). Evitar en nuevo código.

## Entorno de Desarrollo
- **OS de desarrollo**: Windows
- **Servidor local**: Laravel Valet / laragon / XAMPP en puerto 3307
- **Dominio local**: `agustin.test`
- **IDE**: VS Code
- **SFTP configurado**: sí (`sftp-config.json` presente — no commitear credenciales)
