[![made-with-PHP](https://img.shields.io/badge/Made%20with-PHP-1f425f.svg)](https://www.php.net/)
## API REST

### Índice


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

Devuelve todos los vuelos (items) ordenados por el atributo que se desee:

- id_flight
- destination
- price
- duration

*Ejemplos:*

- GET `/flight?orderBy=price&direction=asc`
- GET `/flight?orderBy=destination&direction=desc`

---

#### Paginación

Devuelve todos los vuelos (items) en una página con un tamaño determinado y un límite predeterminado de 3 objetos por página.

- Método: GET
- Ruta: `/flight?page=2`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de vuelo de una página específica

---

#### Filtrado

Devuelve todos los vuelos (items) filtrados por destino.

- Método: GET
- Ruta: `/flight?destination=1`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de vuelo filtrados por destino

---

#### Combinado

Se permite cualquier combinación de paginación, ordenamiento y filtrado posible. Algunos ejemplos son:

- GET `/flight?orderBy=price&direction=asc&page=2`
- GET `/flight?destination=1&orderBy=duration&direction=desc`

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

  	{
  		destination: '1'
  		price: '50000'
  		duration: '02:00:00'
  	}

*Respuesta:*

- Código de estado: 201 (Created)
- Cuerpo de respuesta: Objeto de vuelo recién creado

---

### Editar un vuelo existente

- Método: PUT
- Ruta: /flight/:ID
- Cuerpo de la solicitud: Objeto de vuelo actualizado

  	{
  		destination: '1'
  		price: '50000'
  		duration: '02:00:00'
  	}

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

Devuelve todos los aeropuertos (items) ordenados por el atributo que se desee:

- id_airport
- name
- ubication
- image

*Ejemplos:*

- GET `/airport?orderBy=name&direction=asc`
- GET `/airport?orderBy=country&direction=desc`

---

#### Paginación

Devuelve todos los aeropuertos (items) en una página con un tamaño determinado y un límite predeterminado de 3 objetos por página.

- Método: GET
- Ruta: `/airport?page=2`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de aeropuerto de una página específica

---

#### Filtrado

Devuelve todos los aeropuertos (items) filtrados por nombre.

- Método: GET
- Ruta: `/airport?name=El Plumerillo`

*Respuesta:*
- Código de estado: 200 (OK)
- Cuerpo de respuesta: Array de objetos de aeropuerto filtrados por país

---

#### Combinado

Se permite cualquier combinación de paginación, ordenamiento y filtrado posible. Algunos ejemplos son:

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

  	{
  		name: 'Aeropuerto Necochea'
  		ubication: 'Necochea, Buenos Aires'
  		image: 'https://imagen-aeropuerto-necochea'
  	}

*Respuesta:*
- Código de estado: 201 (Created)
- Cuerpo de respuesta: Objeto de aeropuerto recién creado

---

### Editar un aeropuerto existente

- Método: PUT
- Ruta: /airport/:ID
- Cuerpo de la solicitud: Objeto de vuelo actualizado

  	{
  		name: 'Aeropuerto Necochea'
  		ubication: 'Necochea, Buenos Aires'
  		image: 'https://imagen-aeropuerto-necochea'
  	}

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