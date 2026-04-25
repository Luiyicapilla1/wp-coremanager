# WP CoreManager

**Un plugin de WordPress modular y escalable para la gestión personalizada de contenidos.**

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.2.28-blue)](https://www.php.net/)
[![WordPress](https://img.shields.io/badge/WordPress-%3E%3D6.5-blue)](https://wordpress.org/)
[![License](https://img.shields.io/badge/License-Proprietary-red)](LICENSE)

---

## 📋 Tabla de Contenidos

- [Descripción General](#descripción-general)
- [Características](#características)
- [Requisitos del Sistema](#requisitos-del-sistema)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Uso](#uso)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Arquitectura](#arquitectura)
- [Dependencias](#dependencias)
- [Desarrollo](#desarrollo)
- [Control de Calidad](#control-de-calidad)
- [Contribución](#contribución)
- [Autor](#autor)
- [Licencia](#licencia)

---

## Descripción General

**WP CoreManager** es un plugin de WordPress profesional diseñado para proporcionar funcionalidades personalizadas avanzadas de gestión de contenidos. Implementa una arquitectura modular basada en clases que permite una fácil extensión y mantenimiento del código.

El plugin utiliza un sistema de módulos singleton que se inicializa automáticamente, permitiendo a los desarrolladores crear nuevas funcionalidades de forma estructurada siguiendo patrones de diseño estándar.

### Características Principales

- ✅ **Arquitectura Modular**: Sistema de módulos basado en clases abstractas
- ✅ **Autoloading PSR-4**: Carga automática de clases mediante Composer
- ✅ **Inicialización Automática**: Descubrimiento y carga automática de módulos
- ✅ **GraphQL Integration**: Cliente GraphQL integrado para consultas remotas
- ✅ **Post Types Personalizados**: Sistema flexible para crear tipos de contenido personalizados
- ✅ **Media Handler**: Manejo automático de imágenes y archivos desde URLs remotas
- ✅ **Sincronización de Contenidos**: Sistema de sincronización de componentes
- ✅ **Control de Calidad**: Integración con SonarQube y PHP CodeSniffer
- ✅ **Seguridad**: Protección contra ejecución directa del plugin

---

## Características

### Funcionalidades Principales

#### 1. Sistema Modular
El plugin utiliza un sistema modular donde todas las funcionalidades se organizan en clases que heredan de la clase abstracta `Module`. Esto permite:
- Separación de responsabilidades
- Fácil mantenimiento
- Escalabilidad
- Reutilización de código

#### 2. Inicialización Automática
El `ModuleInitialization` descubre y carga automáticamente todas las clases del namespace `wp_coremanager` que sean subclases de `Module`, permitiendo:
- Agregar nuevas funcionalidades sin modificar archivos de configuración
- Orden de carga configurable mediante `load_order`
- Validación automática de clases instanciables

#### 3. Integración GraphQL
Incluye un cliente GraphQL integrado para comunicación con servidores GraphQL remotos:
- Consultas y mutaciones
- Manejo de errores
- Soporte para variables

#### 4. Gestión de Media
Funcionalidades para descargar y gestionar archivos desde URLs remotas:
- Descarga de imágenes en WordPress Media
- Importación de archivos diversos
- Integración con `wp_media`

#### 5. Post Types Personalizados
Sistema flexible para crear tipos de contenido personalizados (ej: Componentes) con:
- Campos personalizados
- Sincronización automática
- Validación de datos

---

## Requisitos del Sistema

### Requisitos Mínimos

| Requisito | Versión | Notas |
|-----------|---------|-------|
| **PHP** | >= 8.2.28 | Se requiere PHP 8.2 o superior con soporte para typed properties |
| **WordPress** | >= 6.5 | Compatible con WordPress 6.5 y versiones posteriores |
| **Extension: intl** | - | Requerida para funciones de internacionalización |
| **Composer** | - | Para gestionar dependencias (desarrollo) |

### Extensiones PHP Requeridas

- `intl` - Internacionalización
- `json` - Manejo de JSON (generalmente incluido)
- `curl` - Para solicitudes HTTP (requerido por Guzzle)

---

## Instalación

### 1. Instalación Estándar de WordPress

```bash
# Descargar el plugin
git clone https://github.com/Luiyicapilla1/wp-coremanager.git /ruta/wp-content/plugins/wp-coremanager

# O manualmente, descomprimir en wp-content/plugins/
```

### 2. Instalar Dependencias

```bash
# Navegar al directorio del plugin
cd /ruta/wp-content/plugins/wp-coremanager

# Instalar dependencias con Composer
composer install
```

### 3. Activación

1. Ve a **WordPress Admin → Plugins**
2. Busca "WP CoreManager"
3. Haz clic en **Activar**

O activa mediante WP-CLI:

```bash
wp plugin activate wp-coremanager
```

### 4. Verificación

Después de la activación, verifica:
- No haya errores fatales en los logs
- El autoloader de Composer esté cargado correctamente
- Los módulos se inicialicen sin problemas

---

## Configuración

### Variables de Entorno

El plugin utiliza `phpdotenv` para la configuración mediante variables de entorno. Crea un archivo `.env` en la raíz del plugin:

```bash
# .env
# Configuración del entorno
WP_ENV=production
# development, staging, production

# Configuración GraphQL (si es necesario)
GRAPHQL_ENDPOINT=https://api.ejemplo.com/graphql
GRAPHQL_TIMEOUT=30

# Otro
DEBUG=false
```

### Constantes Globales

El plugin define las siguientes constantes en `wp-coremanager.php`:

```php
CM_PLUGIN_VERSION        = '1.0'                    // Versión del plugin
CM_PLUGIN_PATH           = plugin_dir_path(__FILE__) // Ruta absoluta
CM_PLUGIN_URL            = plugin_dir_url(__FILE__)  // URL del plugin
CM_PLUGIN_INC            = CM_PLUGIN_PATH . 'includes/' // Directorio includes
CM_PLUGIN_SLUG           = 'wp-coremanager'          // Slug único
CM_API_NAMESPACE         = 'ac/v1'                   // Namespace API REST
```

### Configuración de Hooks y Filtros

El plugin expone el siguiente filtro para personalizar la prioridad de inicialización:

```php
// Modificar la prioridad de la acción 'init'
add_filter('ac_init_priority', function() {
    return 7; // Menor número = más prioridad
});
```

---

## Uso

### Crear un Nuevo Módulo

Para crear una nueva funcionalidad, crea una clase que herede de `Module`:

#### 1. Crear el archivo de la clase

```php
<?php
// includes/classes/Modules/MiModulo.php

namespace wp_coremanager\Modules;

use wp_coremanager\Module;

class MiModulo extends Module {
    
    /**
     * Prioridad de carga
     * @var int
     */
    public $load_order = 15;
    
    /**
     * Determina si el módulo puede registrarse
     * @return bool
     */
    public function puede_registrar() {
        // Retorna true si el módulo debe activarse
        return true;
    }
    
    /**
     * Registra los hooks del módulo
     * @return void
     */
    public function registrar() {
        // Registrar hooks y filtros aquí
        add_action('init', array($this, 'mi_accion'));
        add_filter('the_content', array($this, 'mi_filtro'));
    }
    
    /**
     * Mi acción personalizada
     * @return void
     */
    public function mi_accion() {
        // Implementación
    }
    
    /**
     * Mi filtro personalizado
     * @param string $content
     * @return string
     */
    public function mi_filtro($content) {
        return $content;
    }
}
```

#### 2. El módulo se cargará automáticamente

No necesitas registrar el módulo manualmente. El `ModuleInitialization` lo descubrirá y cargará automáticamente.

### Descargar Imágenes desde URLs

```php
// En tu módulo
$image_url = 'https://ejemplo.com/imagen.jpg';
$post_id = 123;

$media_id = $this->set_image_from_wp_media($image_url, $post_id);

if (is_wp_error($media_id)) {
    echo 'Error: ' . $media_id->get_error_message();
} else {
    echo 'Imagen importada con ID: ' . $media_id;
}
```

### Descargar Otros Archivos

```php
// En tu módulo
$file_url = 'https://ejemplo.com/documento.pdf';
$post_id = 123;

$media_id = $this->set_file_from_wp_media($file_url, $post_id);

if (is_wp_error($media_id)) {
    echo 'Error: ' . $media_id->get_error_message();
} else {
    echo 'Archivo importado con ID: ' . $media_id;
}
```

### Usar el Cliente GraphQL

```php
// En tu módulo
use wp_coremanager\Services\GraphQLClient;

class MiModulo extends Module {
    public function registrar() {
        $client = new GraphQLClient('https://api.ejemplo.com/graphql');
        
        $query = '
            query {
                posts {
                    id
                    title
                }
            }
        ';
        
        $response = $client->query($query);
        
        if (is_wp_error($response)) {
            // Manejar error
        } else {
            // Usar $response
        }
    }
}
```

---

## Estructura del Proyecto

```
wp-coremanager/
├── wp-coremanager.php              # Archivo principal del plugin
├── index.php                        # Prevención de acceso directo
├── composer.json                    # Configuración de Composer
├── composer.lock                    # Lock file de dependencias
├── .env.example                     # Ejemplo de variables de entorno
├── README.md                        # Este archivo
├── sonar-project.properties         # Configuración de SonarQube
│
├── assets/                          # Archivos de frontend
│   ├── css/
│   │   └── admin/
│   │       └── style.css           # Estilos del admin
│   └── js/
│
├── includes/                        # Código del plugin
│   ├── index.php                   # Prevención de acceso directo
│   ├── core.php                    # Funciones principales
│   │
│   ├── classes/
│   │   ├── Module.php              # Clase abstracta para módulos
│   │   ├── ModuleInitialization.php # Sistema de inicialización
│   │   │
│   │   ├── Modules/
│   │   │   └── ComponenteSync.php   # Módulo de sincronización
│   │   │
│   │   ├── PostTypes/
│   │   │   └── Componente.php       # Post type personalizado
│   │   │
│   │   └── Services/
│   │       └── GraphQLClient.php    # Cliente GraphQL
│   │
│   └── queries/                     # Consultas GraphQL
│       └── queries.php
│
├── vendor/                          # Dependencias de Composer (no commitar)
│   ├── autoload.php
│   ├── composer/
│   ├── guzzlehttp/
│   ├── haydenpierce/
│   ├── vlucas/
│   └── ...
│
└── languages/                       # Archivos de traducción
    └── wp-coremanager.pot          # Archivo de traducción base
```

---

## Arquitectura

### Patrón Arquitectónico

WP CoreManager utiliza una arquitectura de **capas modular**:

```
┌─────────────────────────────────────┐
│  WordPress Core                      │
├─────────────────────────────────────┤
│  WP CoreManager Plugin               │
│  ┌─────────────────────────────────┐ │
│  │ ModuleInitialization (Singleton)│ │
│  │ (Carga automática de módulos)   │ │
│  ├─────────────────────────────────┤ │
│  │ Módulos (Clases)                 │ │
│  │ ├── PostTypes (Contenido)        │ │
│  │ ├── Services (GraphQL, Media)    │ │
│  │ └── Modules (Lógica negocio)     │ │
│  └─────────────────────────────────┘ │
└─────────────────────────────────────┘
```

### Flujo de Inicialización

```
1. wp-coremanager.php cargado
   ↓
2. Definición de constantes
   ↓
3. Carga de vendor/autoload.php
   ↓
4. Carga de includes/core.php
   ↓
5. setup() registra hook 'init'
   ↓
6. En 'init' → ModuleInitialization::instance()->init_classes()
   ↓
7. ClassFinder descubre clases en namespace 'wp_coremanager'
   ↓
8. Se filtran clases instanciables que heredan de Module
   ↓
9. Se ordena por load_order y se inicializa cada módulo
   ↓
10. Cada módulo ejecuta puede_registrar() y registrar()
```

### Patrones de Diseño

- **Singleton**: `ModuleInitialization`
- **Abstract Factory**: Clase `Module`
- **Autoloading**: PSR-4
- **Namespace**: Aislamiento de código con `wp_coremanager`

---

## Dependencias

### Dependencias de Producción

| Paquete | Versión | Propósito |
|---------|---------|-----------|
| `haydenpierce/class-finder` | ^0.5.3 | Descubrimiento automático de clases |
| `vlucas/phpdotenv` | v5.6.1 | Manejo de variables de entorno |
| `guzzlehttp/guzzle` | ^7.0 | Cliente HTTP para solicitudes |
| `ext-intl` | - | Extensión PHP para internacionalización |

### Dependencias de Desarrollo

| Paquete | Versión | Propósito |
|---------|---------|-----------|
| `squizlabs/php_codesniffer` | ^3.11.2 | Análisis estático de código |
| `wp-coding-standards/wpcs` | ^3.1.0 | Estándares de código WordPress |

### Cómo Actualizar Dependencias

```bash
# Ver paquetes desactualizados
composer outdated

# Actualizar todas las dependencias
composer update

# Actualizar un paquete específico
composer update guzzlehttp/guzzle

# Actualizar solo dependencias de desarrollo
composer update --dev
```

---

## Desarrollo

### Configuración del Entorno de Desarrollo

#### 1. Prerrequisitos

- PHP 8.2.28+
- Composer
- WordPress 6.5+
- Git (opcional)

#### 2. Instalación de Dependencias

```bash
cd wp-coremanager
composer install
```

#### 3. Configuración de Variables de Entorno

```bash
cp .env.example .env
# Editar .env con tus valores
```

### Estructura de Desarrollo

```
development (desarrollo local)
staging     (pruebas antes de producción)
local       (local machine)
production  (producción)
```

El plugin detecta el entorno mediante `wp_get_environment_type()`.

### Crear una Extensión

Ejemplo: Crear un módulo para sincronizar posts desde una API:

```php
<?php
// includes/classes/Modules/APISyncModule.php

namespace wp_coremanager\Modules;

use wp_coremanager\Module;
use wp_coremanager\Services\GraphQLClient;

class APISyncModule extends Module {
    
    private $client;
    
    public $load_order = 20;
    
    public function __construct() {
        $this->client = new GraphQLClient(getenv('GRAPHQL_ENDPOINT'));
    }
    
    public function puede_registrar() {
        // Solo en desarrollo y staging
        return in_array(wp_get_environment_type(), ['development', 'staging']);
    }
    
    public function registrar() {
        add_action('wp_loaded', array($this, 'sincronizar'));
    }
    
    public function sincronizar() {
        $query = 'query { posts { id title } }';
        $response = $this->client->query($query);
        
        if (!is_wp_error($response)) {
            // Procesar respuesta
        }
    }
}
```

---

## Control de Calidad

### SonarQube

El plugin está configurado para análisis de código mediante SonarQube.

#### Configuración

Ver `sonar-project.properties`:

```properties
sonar.projectKey=wp-coremanager
sonar.projectName=wp-coremanager
sonar.projectVersion=1.0
sonar.host.url=http://localhost:9000
sonar.language=php
sonar.sourceEncoding=UTF-8
sonar.exclusions=vendor/**,node_modules/**,tests/**,cache/**,logs/**
```

#### Ejecutar Análisis

```bash
# Instalar sonar-scanner (primera vez)
# https://docs.sonarqube.org/latest/analysis/scan/sonarscanner/

# Ejecutar análisis
sonar-scanner

# O con Composer (si está configurado)
composer sonarqube-analyze
```

### PHP CodeSniffer

Valida que el código siga los estándares de WordPress.

#### Verificar Código

```bash
# Buscar problemas
composer phpcs

# O manualmente
./vendor/bin/phpcs --standard=WordPress includes/

# Mostrar solo errores (no warnings)
./vendor/bin/phpcs --standard=WordPress includes/ -n
```

#### Corregir Automáticamente

```bash
# Corregir problemas automáticamente
composer phpcbf

# O manualmente
./vendor/bin/phpcbf --standard=WordPress includes/
```

#### Estándares Utilizados

- **WordPress**: Estándares de código de WordPress
- **PSR-4**: Autoloading
- **PSR-12**: Estilo de código extendido

### Best Practices

- ✅ Mantener el código limpio y bien documentado
- ✅ Usar tipos en funciones y propiedades (PHP 8.2)
- ✅ Escribir phpdoc completos
- ✅ Seguir los estándares de WordPress
- ✅ Usar namespaces apropiadamente
- ✅ Validar y sanitizar entrada
- ✅ Escapar salida
- ✅ Usar nonces para formularios

---

## Contribución

### Cómo Contribuir

1. **Fork** el repositorio
2. **Crea una rama** para tu feature (`git checkout -b feature/AmazingFeature`)
3. **Commit** tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. **Push** a la rama (`git push origin feature/AmazingFeature`)
5. **Abre un Pull Request**

### Estándares de Contribución

- Seguir los estándares de WordPress
- Pasar análisis de SonarQube
- Pasar validación de PHP CodeSniffer
- Incluir documentación en phpdoc
- Crear módulos cuando sea posible
- Escribir código limpio y mantenible

### Reportar Bugs

1. Abre un **Issue** describiendo el problema
2. Incluye pasos para reproducir
3. Versión de PHP y WordPress
4. Logs de errores relevantes

---

## Autor

**Luis García Capilla**
- Email: luisgarciacapilla1@gmail.com

---

## Licencia

Este plugin es software **propietario**. Todos los derechos reservados.

```
Copyright (c) 2024 WP CoreManager
Licencia: Propietaria
Prohibida la distribución, modificación o uso sin autorización.
```

Para información sobre la licencia, contacta con el autor.

---

## Información Adicional

### Constantes Globales

| Constante | Valor | Descripción |
|-----------|-------|-------------|
| `ABSPATH` | - | Ruta absoluta de WordPress (verificada) |
| `CM_PLUGIN_VERSION` | 1.0 | Versión actual del plugin |
| `CM_PLUGIN_PATH` | - | Ruta absoluta del plugin |
| `CM_PLUGIN_URL` | - | URL del plugin |
| `CM_PLUGIN_INC` | - | Ruta del directorio includes |
| `CM_PLUGIN_SLUG` | wp-coremanager | Identificador único |
| `CM_API_NAMESPACE` | ac/v1 | Namespace para REST API |

### Funciones Globales

#### `setup()`
Registra los hooks iniciales del plugin en el evento `wp_init`.

#### `init()`
Inicializa los módulos mediante `ModuleInitialization` durante `wp_init`.

#### `activate()`
Se ejecuta al activar el plugin. Limpia las reglas de reescritura.

#### `deactivate()`
Se ejecuta al desactivar el plugin. Limpia las reglas de reescritura.

### Troubleshooting

#### El plugin no se carga

**Problema**: "Fatal error: Class not found"

**Solución**:
1. Verifica que `composer install` se ejecutó correctamente
2. Comprueba que el archivo `vendor/autoload.php` existe
3. Verifica los permisos de archivo

#### Las clases no se descubren

**Problema**: Los módulos no se inicializan

**Solución**:
1. Asegúrate de que heredan de `Module`
2. Verifica que implementan `puede_registrar()` y `registrar()`
3. Comprueba el namespace (`wp_coremanager\...`)

#### Errores de SonarQube

**Problema**: Errores en análisis de código

**Solución**:
```bash
# Ejecutar PHP CodeSniffer para arreglar
composer phpcbf

# Luego ejecutar SonarQube de nuevo
sonar-scanner
```

### Cambios de Versión

#### v1.0 (Actual)
- Lanzamiento inicial
- Sistema modular
- Integración GraphQL
- Media handler
- SonarQube integration

---

## Recursos

- [Documentación de WordPress](https://developer.wordpress.org/)
- [PHP 8.2 Documentation](https://www.php.net/docs.php)
- [Composer Documentation](https://getcomposer.org/doc/)
- [SonarQube Documentation](https://docs.sonarqube.org/)
- [WordPress Coding Standards](https://developer.wordpress.org/plugins/security/)

---

**Última actualización**: 26 de abril de 2024

---

**¿Preguntas o problemas?** Abre un issue o contacta con el autor.
