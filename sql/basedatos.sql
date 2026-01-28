drop table if exists equipos;

-- Tabla para la clase Equipo
CREATE TABLE equipos (
                         id INT PRIMARY KEY,
                         nombre VARCHAR(255) NOT NULL,
                         region VARCHAR(100) NOT NULL,
                         win_rate FLOAT DEFAULT 0
);

-- Tabla para la clase Jugador
CREATE TABLE jugadores (
                           id INT PRIMARY KEY,
                           nombre VARCHAR(255) NOT NULL,
                           email VARCHAR(255) NOT NULL UNIQUE,
                           nickname VARCHAR(100) NOT NULL,
                           nivel INT DEFAULT 1
);

-- Tabla para la clase Torneo
CREATE TABLE torneos (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         nombre VARCHAR(255) NOT NULL,
                         fecha DATE NOT NULL,
                         premio_total FLOAT DEFAULT 0
);

-- Tabla intermedia para la relación Jugador "tiene favoritos" Equipo (N:M)
CREATE TABLE jugador_favoritos (
                                   jugador_id INT NOT NULL,
                                   equipo_id INT NOT NULL,
                                   PRIMARY KEY (jugador_id, equipo_id),
                                   CONSTRAINT fk_jugador_fav FOREIGN KEY (jugador_id) REFERENCES jugadores(id) ON DELETE CASCADE,
                                   CONSTRAINT fk_equipo_fav FOREIGN KEY (equipo_id) REFERENCES equipos(id) ON DELETE CASCADE
);

-- Tabla intermedia para la relación Torneo "compuesto por" Equipo (N:M)
CREATE TABLE torneo_equipos (
                                torneo_id INT NOT NULL,
                                equipo_id INT NOT NULL,
                                PRIMARY KEY (torneo_id, equipo_id),
                                CONSTRAINT fk_torneo_part FOREIGN KEY (torneo_id) REFERENCES torneos(id) ON DELETE CASCADE,
                                CONSTRAINT fk_equipo_part FOREIGN KEY (equipo_id) REFERENCES equipos(id) ON DELETE CASCADE
);

-- Datos de ejemplo opcionales para pruebas
INSERT INTO equipos (id,nombre, region, win_rate) VALUES
                                                   (1,'T1', 'Korea', 75.5),
                                                   (2,'G2 Esports', 'Europe', 68.2),
                                                   (3,'Fnatic', 'Europe', 60.0),
                                                   (4,'Cloud9', 'North America', 55.4);

INSERT INTO jugadores (id,nombre, email, nickname, nivel) VALUES
                                                           (1,'Miguel Angel', 'miguel@example.com', 'MikePro', 10),
                                                           (2,'Ana Garcia', 'ana@example.com', 'AnitaG', 25);

INSERT INTO torneos (id, nombre, fecha, premio_total) VALUES
                                                      (1,'Worlds 2025', '2025-11-01', 2000000.00),
                                                      (2,'LEC Winter', '2025-01-20', 50000.00);

-- Asociaciones de ejemplo
INSERT INTO jugador_favoritos (jugador_id, equipo_id) VALUES (1, 1), (1, 2), (2, 3);
INSERT INTO torneo_equipos (torneo_id, equipo_id) VALUES (1, 1), (1, 2), (1, 3), (1, 4), (2, 2), (2, 3);

/*SELECT DATABASE();*/
/*Devolvera el nombre de la bbdd "examen"*/

/*SHOW TABLES;*/
/*SHOW GRANTS FOR 'alumno'@'%';*/
/*Devolverá
//GRANT ALL PRIVILEGES ON examen.* TO 'alumno'@'%';*/
/*SELECT * FROM torneos WHERE id = 1;*/
