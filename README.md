# sis004

**PHP-POO-MVC - Login y Usuarios**

## Descripción

`sis004` es un proyecto diseñado utilizando **PHP** para implementar un sistema de login y manejo de usuarios. Este repositorio sigue el paradigma de programación orientada a objetos (POO) y utiliza el patrón de arquitectura Model-View-Controller (MVC). 

El sistema tiene como objetivo proporcionar una base sólida para proyectos de aplicaciones web que necesiten funcionalidades de autenticación y gestión básica de usuarios.

---

## Funcionalidades

- **Autenticación de usuarios**:
  - Login seguro con validación de credenciales. 
  
- **Gestión de usuarios**:
  - Creación de usuarios nuevos.
  - Edición y eliminación de usuarios existentes.
  - Visualización de perfiles de usuario.

- **Seguridad**:
  - Protección contra inyecciones SQL.
  - Gestión segura de sesiones.

---

## Arquitectura del Proyecto

Este proyecto sigue el patrón de diseño **Model-View-Controller (MVC)**, que organiza el código en tres componentes principales:

1. **Modelo (Model)**:
   - Maneja la lógica de negocio y la interacción con la base de datos.
   - Ejemplo: Modelos para usuarios y autenticación.

2. **Vista (View)**:
   - Genera la interfaz de usuario.
   - Contiene archivos HTML/PHP para mostrar los datos al usuario de forma dinámica.

3. **Controlador (Controller)**:
   - Actúa como intermediario entre el Modelo y la Vista.
   - Procesa las solicitudes del usuario, actualiza los modelos y devuelve la respuesta adecuada a la vista.

---

## Estructura del Proyecto

```plaintext
sis004/
│
├── config/                # Archivos de configuración del proyecto
├── controllers/           # Controladores principales (Login, Usuarios, etc.)
├── models/                # Modelos que interactúan con la base de datos
├── views/                 # Vistas (HTML, plantillas PHP, etc.)
├── public/                # Archivos accesibles públicamente (CSS, JS, imágenes)
├── index.php              # Punto de entrada principal del proyecto
├── .env                   # Variables de entorno (configuración sensible)
├── README.md              # Documentación del proyecto
└── ...                    # Otros archivos y directorios relacionados
```

---

## Tecnologías Utilizadas

- **Lenguajes**: 
  - PHP (92.3%)
  - JavaScript (6.5%)
  - Otros (1.2%)
- **Base de Datos**: MySQL (puedes confirmar o ajustar esto si usas otra base de datos).
- **Frameworks/Bibliotecas**: 
  - No especificado explícitamente, pero el proyecto podría usar librerías comunes para validación o conexión a bases de datos.

---

## Cómo Ejecutar el Proyecto

1. Clona este repositorio:
   ```bash
   git clone https://github.com/pbon7477/sis004.git
   ```

2. Configura las variables de entorno en un archivo `.env`:
   - Credenciales de la base de datos.
   - Claves de configuración.

3. Ejecuta el proyecto en un servidor local (como XAMPP o WAMP):
   - Copia los archivos al directorio raíz de tu servidor local.
   - Asegúrate de que el servidor esté configurado para interpretar PHP.

4. Accede al proyecto desde tu navegador:
   ```
   http://localhost/sis004
   ```

---

## Contribuciones

¡Contribuciones son bienvenidas! Si deseas mejorar el proyecto, crea un **Pull Request** o abre un **Issue**.

---

## Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).

---

Si necesitas algún detalle adicional, puedo profundizar en alguna sección o incluir más información específica sobre el proyecto. ¿Te gustaría agregar algo más? 🚀
