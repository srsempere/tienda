DROP TABLE IF EXISTS articulos CASCADE;

CREATE TABLE articulos (
        id              bigserial     PRIMARY KEY,
        codigo          varchar(13)   NOT NULL UNIQUE,
        denominacion    varchar(255)  NOT NULL,
        descripcion     varchar(255)  NOT NULL,
        precio          numeric(7, 2) NOT NULL
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
        id          bigserial     PRIMARY KEY,
        usuario     varchar(255)  NOT NULL UNIQUE,
        password    varchar(255)  NOT NULL
);


-- Carga inicial de datos de pruebas
INSERT INTO articulos (codigo, denominacion, descripcion, precio)
        VALUES ('10', 'Ordenador Portátil'   , 'Ordenador portátil de última generación con el S.O. Zorin Os instalador por defecto.', 200.50),
               ('20', 'Tablet escolar'       , 'Tablet ideal para uso escolar debido a su gran robustez y a su lápiz que será de gran utilidad para su hijo',50.10),
               ('30', 'Disco Duro SSD 500 GB', 'Discoduro interno de marca Toshiba pensado para uso doméstico con más de 900.000 horas de uso.' ,150.30),
               ('40', 'Pantalla de ordenador', 'Disfruta con PcCom Elysium de una experiencia más inversiva a través de su curvatura 1800 R, resolución Full HD (1920x1080), panel VA de 23.8" y un amplio ángulo de visión de 178 º.',70.00),
               ('50', 'Teclado y ratón'      , 'Cuenta con 105 teclas silenciosas y agradables al tacto por una pila AA. El ratón dispone de 1000 DPI con conexión inalámbrica 2,4 GHz, diseño ergonómico, 3 botones y rueda de desplazamiento.',  40.00),
               ('60', 'Amastrad'             , 'Ordenador clasico Amstrad CPC 464. Completo y en muy buen estado. Juego original Mad Mix Game incluido. Probado y funcionando.',500.00);

INSERT INTO usuarios (usuario, password)
        VALUES ('admin', crypt('admin', gen_salt('bf', 10))),
               ('samu' , crypt('samu' , gen_salt('bf', 10)));
