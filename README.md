# 📋 API RESTful - Gestión de Tareas (PHP Vanilla)

Una API RESTful robusta y segura construida completamente desde cero utilizando **PHP Nativo (Vanilla)**, sin el uso de frameworks externos. 

Este proyecto demuestra un conocimiento profundo de los fundamentos del desarrollo Backend, la arquitectura de software, el modelado de bases de datos relacionales y los protocolos de seguridad web.

## 🚀 Tecnologías y Arquitectura

* **Lenguaje:** PHP 8+
* **Base de Datos:** MySQL
* **Arquitectura:** Patrón MVC (Modelo-Vista-Controlador) construido a mano y Front Controller.
* **Autenticación:** JWT (JSON Web Tokens) implementado de forma nativa sin librerías de terceros.
* **Seguridad:** Consultas preparadas con PDO (prevención de Inyección SQL) y cifrado de contraseñas con BCRYPT.

## ⚙️ Características Principales

1. **Enrutador Personalizado:** Todo el tráfico se gestiona a través de un único punto de entrada (`index.php`), dirigiendo las peticiones a los controladores correspondientes de forma dinámica.
2. **Middleware de Seguridad:** Interceptor que verifica la presencia y validez del token `Bearer` en las cabeceras HTTP antes de conceder acceso a rutas protegidas.
3. **Integridad Referencial:** Base de datos relacional vinculando la autoría de cada recurso a su usuario creador.

## 🛡️ Reglas de Negocio: Enfoque Colaborativo de Equipo

La API está diseñada bajo la lógica de un **tablón de tareas compartido para equipos de trabajo** (estilo Kanban/Jira), aplicando un modelo de permisos mixto:

* **Visibilidad Transparente (Lectura Pública):** Todo el equipo puede ver el listado global de tareas pendientes y completadas mediante `GET /tareas` para mantener la sincronización del proyecto. No se filtra por usuario de forma intencionada para permitir la supervisión colectiva.
* **Trazabilidad de Autoría (Escritura Privada):** Al crear una tarea, el sistema inyecta automáticamente el `usuario_id` extraído del token JWT, dejando registro de quién es el responsable de cada tarjeta.
* **Protección contra IDOR (Modificación Restringida):** Aunque la visualización es pública, los endpoints de borrado y actualización validan de forma estricta que el usuario que envía la petición sea el propietario real de la tarea, impidiendo que un miembro del equipo altere el trabajo de otro.

## 🗄️ Estructura de la Base de Datos

El sistema utiliza una base de datos con las siguientes entidades relacionadas:
* `usuarios` (id, nombre, email, password, created_at)
* `tareas` (id, usuario_id [FK], titulo, descripcion, estado, created_at)

## 🛠️ Instalación y Despliegue Local

1. Clona este repositorio:
   ```bash
   git clone [https://github.com/tu-usuario/api-tareas.git](https://github.com/tu-usuario/api-tareas.git)