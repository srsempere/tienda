DROP TABLE IF EXISTS articulos CASCADE;

CREATE TABLE articulos (
        id bigserial PRIMARY KEY,
        codigo varchar(13) NOT NULL UNIQUE,
        descripcion varchar(255) NOT NULL,
        precio numeric(7, 2) NOT NULL
);

-- Carga inicial de datos de pruebas

INSERT INTO articulos (codigo, descripcion, precio)
    VALUES ('10', 'Yogur piña', 200.50),
           ('20', 'Tigretón', 50.10),
           ('30', 'Disco Duro SSD 500 GB', 150.30),
           ('40', 'Pantalla de ordenador', 70.00);
