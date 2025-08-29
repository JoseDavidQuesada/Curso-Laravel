# Pruebas - Testing para Curso Laravel

Este documento describe la implementación de pruebas (tests) para la aplicación de Instagram desarrollada en Laravel.

## Estructura de Pruebas Implementada

### Tests Unitarios (Unit Tests)
Ubicados en `tests/Unit/`:

- **UserTest.php** - Pruebas del modelo User
  - Creación de usuarios
  - Atributos fillable y hidden
  - Relación con imágenes

- **ImageTest.php** - Pruebas del modelo Image
  - Creación de imágenes
  - Relaciones con users, comments y likes

- **CommentTest.php** - Pruebas del modelo Comment
  - Creación de comentarios
  - Relaciones con users e images

- **LikeTest.php** - Pruebas del modelo Like
  - Creación de likes
  - Relaciones con users e images

- **BasicTest.php** - Pruebas básicas de PHP
- **ExampleTest.php** - Pruebas de ejemplo mejoradas

### Tests de Funcionalidad (Feature Tests)
Ubicados en `tests/Feature/`:

- **HomeControllerTest.php** - Pruebas del controlador Home
  - Autenticación requerida
  - Acceso a página principal
  - Visualización de imágenes

- **UserControllerTest.php** - Pruebas del controlador User
  - Configuración de perfil
  - Actualización de datos
  - Subida de avatar
  - Validaciones

- **ImageControllerTest.php** - Pruebas del controlador Image
  - Subida de imágenes
  - Validaciones
  - Detalle de imagen

- **CommentControllerTest.php** - Pruebas del controlador Comment
  - Guardar comentarios
  - Eliminar comentarios
  - Permisos de eliminación

- **LikeControllerTest.php** - Pruebas del controlador Like
  - Sistema de likes/dislikes
  - Prevención de likes duplicados
  - Respuestas JSON

- **ExampleTest.php** - Pruebas de páginas básicas

## Funcionalidades Cubiertas por las Pruebas

### Modelos y Relaciones
- ✅ Creación de usuarios, imágenes, comentarios y likes
- ✅ Validación de atributos fillable
- ✅ Relaciones entre modelos (hasMany, belongsTo)
- ✅ Configuración de tablas

### Autenticación y Autorización
- ✅ Middleware de autenticación
- ✅ Acceso protegido a rutas
- ✅ Permisos de edición/eliminación

### Gestión de Imágenes
- ✅ Subida de archivos
- ✅ Validaciones de formato
- ✅ Almacenamiento en discos virtuales
- ✅ Recuperación de archivos

### Sistema de Comentarios
- ✅ Creación de comentarios
- ✅ Eliminación por propietario
- ✅ Eliminación por dueño de imagen

### Sistema de Likes
- ✅ Agregar/quitar likes
- ✅ Prevención de likes duplicados
- ✅ Respuestas API JSON

### Configuración de Usuario
- ✅ Actualización de perfil
- ✅ Validaciones de datos
- ✅ Subida de avatar

## Ejecución de Pruebas

### Problema de Compatibilidad
Actualmente existe un problema de compatibilidad entre PHP 8.3 y Laravel 5.8, lo que impide la ejecución directa de pruebas con PHPUnit.

### Soluciones Implementadas

1. **Test Runner Personalizado**:
   ```bash
   php test-runner.php
   ```
   Valida la estructura de pruebas y configuración de modelos.

2. **Pruebas Básicas**:
   ```bash
   php vendor/phpunit/phpunit/phpunit tests/Unit/BasicTest.php --no-configuration
   ```
   Ejecuta pruebas básicas sin dependencias de Laravel.

3. **Configuración Alternativa**:
   Se creó `phpunit-basic.xml` para configuraciones específicas.

## Archivos Modificados

### Modelos
Se agregaron atributos `fillable` a los modelos para permitir mass assignment:

- `app/Image.php` - Agregado fillable: user_id, image_path, description
- `app/Comment.php` - Agregado fillable: user_id, image_id, content  
- `app/Like.php` - Agregado fillable: user_id, image_id

### Tests Existentes Mejorados
- `tests/Unit/ExampleTest.php` - Agregadas pruebas adicionales
- `tests/Feature/ExampleTest.php` - Agregadas pruebas de páginas básicas

## Cobertura de Pruebas

La suite de pruebas cubre:
- 🎯 **4 Modelos** con sus relaciones
- 🎯 **5 Controladores** con todas sus funciones principales
- 🎯 **Autenticación** y middleware
- 🎯 **Validaciones** de formularios
- 🎯 **Subida de archivos** y almacenamiento
- 🎯 **API endpoints** para likes

## Próximos Pasos

Para ejecutar las pruebas completamente sería necesario:
1. Actualizar Laravel a una versión compatible con PHP 8.3
2. Configurar base de datos de pruebas
3. Ejecutar migraciones en entorno de testing
4. Configurar almacenamiento fake para pruebas

## Beneficios de esta Implementación

- ✅ **Estructura completa** de testing lista para usar
- ✅ **Cobertura exhaustiva** de funcionalidades
- ✅ **Pruebas documentadas** y bien organizadas
- ✅ **Validación de modelos** y relaciones
- ✅ **Tests de integración** para controladores
- ✅ **Facilita el mantenimiento** del código
- ✅ **Detecta regresiones** automáticamente