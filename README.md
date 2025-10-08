# Sistema de Gestión de Superhéroes

**Proyecto académico desarrollado con CodeIgniter 4**  
**Estudiante:** Sandra De La Cruz

---

## Descripción

Sistema web para gestionar y consultar información de superhéroes. Permite búsquedas avanzadas, generación de reportes PDF y visualización de detalles de personajes.

---

## Instalación Rápida

### Requisitos
- PHP 8.x
- MySQL
- Composer
- Servidor web local (ej: Laragon, XAMPP)

### Pasos

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/Sandra120704/Superhero.git
   cd superhero
   ```

2. **Instala dependencias**
   ```bash
   composer install
   ```

3. **Configura la base de datos**
   - Crea una base de datos llamada `superhero`.
   - Importa los archivos SQL en la carpeta `/database` (en orden si hay varios).

4. **Configura el entorno**
   - Copia `.env.example` a `.env` y ajusta tus credenciales de base de datos.

5. **Inicia el servidor**
   ```bash
   php spark serve
   ```
   Accede a [http://localhost:8080](http://localhost:8080)

---

## Credenciales de Prueba

| Usuario         | Email                   | Contraseña   |
|-----------------|------------------------|--------------|
| Administrador   | admin@superhero.com     | admin123     |
| Usuario 1       | usuario1@superhero.com  | password123  |

---

## Funcionalidades Principales

- CRUD de superhéroes
- Búsqueda avanzada con autocompletado
- Reportes PDF por editorial y búsqueda
- Visualización de atributos y poderes

---

## Contacto

**Sandra De La Cruz**  
Email: 1508386@senati.pe

---

*Proyecto académico SENATI. En desarrollo y mejora continua.*