DROP TABLE IF EXISTS articulos CASCADE;

CREATE TABLE articulos (
        id bigserial PRIMARY KEY,
        codigo varchar(13) NOT NULL UNIQUE,
        descripcion varchar(255) NOT NULL,
        precio numeric(7, 2) NOT NULL
);

-- Carga inicial de datos de pruebas

INSERT INTO articulos (codigo, descripcion, precio)
    VALUES ('12312335435', 'Yogur piña', 200.50),
           ('56465465464',  'Tigretón', 50.10),
           ('35435743574',  'Disco Duro SSD 500 GB', 150.30);
