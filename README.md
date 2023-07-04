[![made-with-PHP](https://img.shields.io/badge/Made%20with-PHP-1f425f.svg)](https://www.php.net/)[![API](https://img.shields.io/badge/Made%20with-API-1f425f.svg)](https://en.wikipedia.org/wiki/Application_programming_interface)[![Database](https://img.shields.io/badge/Database-DB-1f425f.svg)](https://en.wikipedia.org/wiki/Database)
## API REST

### Índice

- [Descripcion del proyecto](#descripcion-del-proyecto)
- [Códigos de estado](#códigos-de-estado)
- [Endpoints Vuelos (Flight)](#endpoints-vuelos-flight)
    - [Obtener todos los vuelos disponibles](#obtener-todos-los-vuelos-disponibles)
        - [Ordenamiento](#ordenamiento)
        - [Paginación](#paginación)
        - [Filtrado](#filtrado)
        - [Combinado](#combinado)
    - [Obtener un vuelo por un ID específico](#obtener-un-vuelo-por-un-id-específico)
    - [Insertar un vuelo](#insertar-un-vuelo)
    - [Editar un vuelo existente](#editar-un-vuelo-existente)
    - [Borrar un vuelo existente](#borrar-un-vuelo-existente)
- [Endpoints Aeropuertos (Airport)](#endpoints-aeropuertos-airport)
    - [Obtener todos los aeropuertos disponibles](#obtener-todos-los-aeropuertos-disponibles)
        - [Ordenamiento](#ordenamiento-1)
        - [Paginación](#paginación-1)
        - [Filtrado](#filtrado-1)
        - [Combinado](#combinado-1)
    - [Obtener un aeropuerto por ID](#obtener-un-aeropuerto-por-id)
    - [Insertar un aeropuerto](#insertar-un-aeropuerto)
    - [Editar un aeropuerto existente](#editar-un-aeropuerto-existente)
    - [Borrar un aeropuerto](#borrar-un-aeropuerto)

---

### Descripcion del proyecto

La API de aerolínea permite gestionar y consultar información de vuelos y aeropuertos. Los usuarios pueden listar, filtrar, ordenar, agregar, editar y borrar vuelos y aeropuertos según sus necesidades.

- Listar vuelos o aeropuertos: Los usuarios pueden obtener una lista completa de vuelos o aeropuertos disponibles, con detalles exhaustivos de cada uno.

- Paginar vuelos o aeropuertos: La API permite paginar los resultados de vuelos o aeropuertos, dividiéndolos en páginas de tamaño limitado (3 objetos por página), lo cual facilita la navegación y mejora la experiencia de uso.

- Filtrar vuelos o aeropuertos: Los usuarios pueden aplicar filtros personalizados a la lista de vuelos o aeropuertos, permitiéndoles obtener resultados que se ajusten a criterios específicos y facilitando la búsqueda de información relevante.

- Ordenar vuelos o aeropuertos: Los resultados de la lista de vuelos o aeropuertos pueden ordenarse según múltiples criterios. Esto proporciona flexibilidad a los usuarios para obtener la información en el orden deseado.

- Agregar vuelos o aeropuertos: Los usuarios tienen la capacidad de agregar nuevos vuelos o aeropuertos a la base de datos de la aerolínea, proporcionando los detalles necesarios. Esto permite una actualización constante de la información disponible.

- Borrar vuelos o aeropuertos: Los vuelos o aeropuertos existentes pueden eliminarse de la base de datos utilizando la API. Esto se logra mediante el suministro del identificador único del vuelo o aeropuerto que se desea eliminar.

- Editar vuelos o aeropuertos: Los detalles de vuelos o aeropuertos existentes pueden actualizarse a través de la API. Los usuarios pueden modificar información. Lo que brinda flexibilidad en la gestión de la información.

---
### Códigos de estado

- 200 OK: La solicitud se ha procesado correctamente.
- 201 Created: La solicitud se ha completado y se ha creado un nuevo recurso como resultado.
- 400 Bad Request: La solicitud no se pudo entender o tenía parámetros inválidos.
- 404 Not Found: El recurso solicitado no se encontró en el servidor.
- 500 Internal Server Error: Se produjo un error interno en el servidor al procesar la solicitud.

---

### ENDPOINTS VUELOS (FLIGHT)
---

#### Obtener todos los vuelos disponibles
- Método: GET
- Ruta: `/flight`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de vuelo

---

#### Ordenamiento

Devuelve todos los vuelos, ordenados por el atributo que se desee:

- id_flight
- destination
- price
- duration

*Ejemplos:*

- GET `/flight?orderBy=price&direction=asc`
- GET `/flight?orderBy=destination&direction=desc`

---

#### Paginación

Devuelve todos los vuelos, en una página con un tamaño determinado y un límite predeterminado de 3 objetos por página.

- Método: GET
- Ruta: `/flight?page=2`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de vuelo de una página específica

---

#### Filtrado

Devuelve todos los vuelos, filtrados por destino.

- Método: GET
- Ruta: `/flight?destination=1`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de vuelo filtrados por destino

---

#### Combinado

Se permite cualquier combinación de ordenamiento y paginacion. Algunos ejemplos son:

- GET `/flight?orderBy=price&direction=asc&page=2`
- GET `/flight?orderBy=price&direction=desc&page=1`

----
#### Obtener un vuelo por un ID específico

- Método: GET
- Ruta: `/flight/:ID`

*Respuesta:*

- Código de estado: 200 (OK)
- Cuerpo de respuesta: Objeto de vuelo con el ID especificado

---

#### Insertar un vuelo

- Método: POST
- Ruta: `/flight`
- Cuerpo de solicitud: Objeto de vuelo a crear

```json
{
  "destination": "1",
  "price": "50000",
  "duration": "02:00:00"
}
```

*Respuesta:*

- Código de estado: 201 (Created)
- Cuerpo de respuesta: Objeto de vuelo recién creado

NOTA:
- El atributo "price" debe estar entre los rangos (10000>50000)
- El atributo "destination" debe coincidir con los aeropuertos disponibles

---

### Editar un vuelo existente

- Método: PUT
- Ruta: /flight/:ID
- Cuerpo de la solicitud: Objeto de vuelo actualizado

```json
{
  "destination": "1",
  "price": "50000",
  "duration": "02:00:00"
}
```

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Devuelve un texto, sobre el vuelo que se modifico

---

#### Borrar un vuelo existente

- Método: DELETE
- Ruta: `/flight/:ID`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Mensaje de éxito

---

### ENDPOINTS AEROPUERTOS (AIRPORT)
---
#### Obtener todos los aeropuertos disponibles

- Método: GET
- Ruta: `/airport`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de aeropuerto
---

#### Ordenamiento

Devuelve todos los aeropuertos, ordenados por el atributo que se desee:

- id_airport
- name
- ubication
- image

*Ejemplos:*

- GET `/airport?orderBy=name&direction=asc`
- GET `/airport?orderBy=ubication&direction=desc`

---

#### Paginación

Devuelve todos los aeropuertos, en una página con un tamaño determinado y un límite predeterminado de 3 objetos por página.

- Método: GET
- Ruta: `/airport?page=2`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de aeropuerto, de una página específica

---

#### Filtrado

Devuelve todos los aeropuertos, filtrados por nombre.

- Método: GET
- Ruta: `/airport?name=El Plumerillo`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de aeropuerto filtrados por nombre

---

#### Combinado

Se permite cualquier combinación de ordenamiento y paginacion posible. Algunos ejemplos son:

- GET `/airport?orderBy=name&direction=asc&page=2`
- GET `/airport?orderBy=ubication&direction=desc&page=1`
---

#### Obtener un aeropuerto por ID

- Método: GET
- Ruta: `/airport/:ID`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Objeto de aeropuerto con el ID especificado
---

#### Insertar un aeropuerto

- Método: POST
- Ruta: `/airport`
- Cuerpo de solicitud: Objeto de aeropuerto a agregar

```json
{
  "name": "Aeropuerto Necochea",
  "ubication": "Necochea, Buenos Aires",
  "image": "https://imagen-aeropuerto-necochea"
}
```

*Respuesta:*
- Código de estado: 201 (Created)
- Cuerpo de respuesta: Objeto de aeropuerto recién creado

---

### Editar un aeropuerto existente

- Método: PUT
- Ruta: /airport/:ID
- Cuerpo de la solicitud: Objeto de aeropuerto actualizado

```json
{
  "name": "Aeropuerto Necochea",
  "ubication": "Necochea, Buenos Aires",
  "image": "https://imagen-aeropuerto-necochea"
}
```

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Devuelve un texto, sobre el aeropuerto que se modifico

---

#### Borrar un aeropuerto

- Método: DELETE
- Ruta: `/airport/:ID`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Mensaje de éxito
---