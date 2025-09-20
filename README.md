# Sistema de Gestión de Superhéroes

**Proyecto de Desarrollo Web - SENATI**  
**Estudiante:** Sandra De La Cruz 
**Curso** Seminario De Complementacion

---

## Descripción del Proyecto

Este proyecto es un sistema web completo para la gestión y consulta de información de superhéroes, desarrollado como parte de las tareas académicas del módulo de Programación Web. El sistema permite realizar búsquedas avanzadas, generar reportes en PDF y visualizar información detallada de personajes de cómic.

###  Objetivos Logrados

- Implementar un sistema CRUD básico con CodeIgniter 4
- Crear reportes dinámicos con filtros
- Generar documentos PDF 
- Implementar búsqueda con autocompletado AJAX
- Aplicar diseño responsivo con Bootstrap 5
- Manejar base de datos relacional con MySQL

---
##  Funcionalidades Principales

### **Reporte 4: Superhéroes por Editorial**
- **Descripción:** Lista de superhéroes filtrados por editorial/compañía
- **Funcionalidad:** 
  - Selección de editorial desde dropdown
  - Visualización de resultados en formato PDF
  - Información mostrada: Nombre, nombre real, editorial, alineación
- **Archivo:** `ReporteController::getReport4()`

### **Reporte 5: Buscador Avanzado con PDF**
- **Descripción:** Buscador inteligente con autocompletado y generación de PDF detallado
- **Funcionalidades:**
  - Búsqueda en tiempo real (autocomplete)
  - Búsqueda por nombre de superhéroe o nombre real
  - Generación de PDF completo con:
    - Información básica (altura, peso, editorial, alineación)
    - Atributos de poder con barras de progreso
    - Lista completa de superpoderes
    - Conversiones automáticas (cm a metros, kg a libras)
- **Archivos:** 
  - `ReporteController::SuperheroReport5()`
  - `ReporteController::autocompleteSuperhero()`
  - `ReporteController::Report5PDF()`

---

##  Tecnologías Utilizadas

### Backend
- **PHP 8.x** - Lenguaje de programación principal
- **CodeIgniter 4** - Framework MVC
- **MySQL** - Base de datos relacional
- **HTML2PDF (Spipu)** - Generación de documentos PDF

### Frontend
- **HTML5 + CSS3** - Estructura y estilos
- **Bootstrap 5.1.3** - Framework CSS responsivo
- **JavaScript ES6** - Interactividad y AJAX
- **Font Awesome 6.0.0** - Iconografía

### Herramientas de Desarrollo
- **Laragon** - Servidor local de desarrollo
- **VS Code** - Editor de código
- **Git** - Control de versiones

---

## Estructura de la Base de Datos

### Tablas Principales

#### `superhero`
- Información básica de los superhéroes
- Campos: id, superhero_name, full_name, height_cm, weight_kg, publisher_id, alignment_id

#### `hero_attribute` 
- Atributos de poder (Intelligence, Strength, Speed, etc.)
- Valores del 1 al 100 para cada atributo

#### `hero_power`
- Relación de superhéroes con sus poderes
- Tabla de relación muchos a muchos

#### Tablas de Referencia
- `publisher` - Editoriales (DC Comics, Marvel, etc.)
- `alignment` - Alineaciones (Good, Bad, Neutral)
- `attribute` - Tipos de atributos (Intelligence, Strength, etc.)
- `superpower` - Catálogo de superpoderes

---

## Desafíos y Soluciones

### **Problemas Técnicos Enfrentados**

#### 1. **Error "Undefined property '$db'"**
- **Problema:** Error en el controlador al acceder a la base de datos
- **Causa:** Falta de declaración de la propiedad $db
- **Solución:** Agregué `protected $db;` en el ReporteController
- **Lección:** Importancia de declarar propiedades en PHP

#### 2. **Conflictos de CSS en PDF**
- **Problema:** CSS inline causaba errores de sintaxis
- **Causa:** Comentarios PHP dentro de propiedades CSS
- **Solución:** Separé la lógica PHP del CSS 
- **Lección:** Mantener separación clara entre PHP y CSS

#### 3. **Autocompletado muy lento**
- **Problema:** Búsquedas instantáneas saturaban el servidor
- **Solución:** Implementé timeout de 500ms y búsqueda mínima de 2 caracteres
- **Lección:** Optimización de experiencia de usuario

#### 4. **Estructura HTML desbalanceada**
- **Problema:** Errores "Unexpected EndOfFile" 
- **Causa:** Etiquetas `<div>` sin cerrar correctamente
- **Solución:** Revisión completa de estructura HTML y eliminación de código duplicado
- **Lección:** Importancia de validar estructura HTML

### 💡 **Mejoras Implementadas**

1. **Búsqueda Inteligente:** Autocompletado que busca tanto en nombre de superhéroe como nombre real
2. **PDF Completo:** Documento con toda la información (básica + atributos + poderes)
3. **Conversiones Automáticas:** Altura en metros y peso en libras automáticamente
4. **Diseño Responsivo:** Interface que funciona en mobile y desktop

---

## Capturas de Pantalla

### Buscador Principal
- Interface limpia con autocompletado
- Búsqueda en tiempo real
- Diseño responsive con Bootstrap

### PDF Generado
- Información completa del superhéroe
- Atributos con barras de progreso
- Lista organizada de superpoderes
- Conversiones automáticas de unidades

---

## Instalación y Configuración

### Rrequisitos
- PHP 
- Heidi
- Composer html2pdf
- Servidor web 

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/Sandra120704/Superhero.git
   cd superhero
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar base de datos**
   - Crear base de datos `superhero`
   - Importar archivos SQL en orden:
     - `01_reference_data.sql`
     - `02_hero_attribute.sql` 
     - `03_hero_power.sql`

4. **Configurar CodeIgniter**
   - Copiar `.env.example` a `.env`
   - Configurar credenciales de base de datos
   - Establecer `baseURL`

---

## Casos de Prueba

### Pruebas Realizadas

#### Reporte 4
- Filtrado por DC Comics
- Filtrado por Marvel Comics  
- Generación correcta de PDF
- Manejo de editoriales sin superhéroes

#### Reporte 5
- Búsqueda de "Superman" - resultados correctos
- Búsqueda de "Superboy" - PDF completo generado
- Búsqueda de "Krypto" - atributos y poderes mostrados
- Autocompletado funcional con timeout
- Conversiones de unidades correctas

---

## Conocimientos Aplicados

### Conceptos
- **MVC (Model-View-Controller)** - Arquitectura del proyecto
- **CRUD Operations** - Consultas a base de datos
- **AJAX** - Comunicación asíncrona
- **JSON** - Intercambio de datos
- **SQL Joins** - Consultas relacionales complejas

### Frontend Development
- **Responsive Design** - Bootstrap Grid System
- **CSS3** - Gradients, animations, flexbox
- **JavaScript** - Fetch API, async/await
- **UX/UI** - Experiencia de usuario intuitiva

### Backend Development
- **PHP OOP** - Clases, métodos, propiedades
- **CodeIgniter 4** - Framework MVC moderno
- **Database Design** - Relaciones, normalización
- **Error Handling** - Try-catch, validaciones

---

## Resultados del Proyecto

### Objetivos Académicos Cumplidos
-  Implementación completa de sistema web con CodeIgniter 4
-  Manejo avanzado de base de datos relacional
-  Generación dinámica de reportes PDF
-  Interface moderna y responsiva
-  Funcionalidades interactivas con JavaScript

### Competencias Desarrolladas
- **Investigación técnica** - Búsqueda de soluciones en documentación
- **Código limpio** - Comentarios y estructura organizada
- **Testing** - Pruebas de funcionalidad

---

## Contacto

**Sandra De La Cruz**  
 Email: [1508386@senati.pe]  
 Institución: SENATI - Desarrollo de Software  
 Fecha: Septiembre 2025

---
### Este Proyecto a un seguira en crecimiento..

---

*Este proyecto fue desarrollado con dedicación y esfuerzo como parte de mi formación en SENATI. Cada línea de código representa aprendizaje y crecimiento profesional.*