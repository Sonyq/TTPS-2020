-- SQL Manager for PostgreSQL 6.1.2.53864
-- ---------------------------------------
-- Host      : localhost
-- Database  : segco
-- Version   : PostgreSQL 13.0, compiled by Visual C++ build 1914, 64-bit



SET check_function_bodies = false;
--
-- Structure for table user (OID = 40986) : 
--
SET search_path = public, pg_catalog;
CREATE TABLE public."user" (
    id integer NOT NULL,
    sistema_id integer,
    email varchar(191) NOT NULL,
    username varchar(191) NOT NULL,
    password varchar(191) NOT NULL,
    roles json NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    first_name varchar(191) NOT NULL,
    last_name varchar(191) NOT NULL,
    activo boolean NOT NULL
)
WITH (oids = false);
--
-- Structure for table cama (OID = 40997) : 
--
CREATE TABLE public.cama (
    id integer NOT NULL,
    sala_id integer,
    numero integer NOT NULL,
    estado varchar(255) NOT NULL
)
WITH (oids = false);
--
-- Structure for table evolucion (OID = 41003) : 
--
CREATE TABLE public.evolucion (
    id integer NOT NULL,
    internacion_id integer NOT NULL,
    fecha_carga timestamp(0) without time zone NOT NULL,
    temperatura double precision NOT NULL,
    tension_arterial_sistolica integer NOT NULL,
    tension_arterial_diastolica integer NOT NULL,
    frecuencia_cardiaca integer NOT NULL,
    frecuencia_respiratoria integer NOT NULL,
    mecanica_ventilatoria varchar(255) NOT NULL,
    canula_nasal_oxigeno double precision,
    mascara_con_reservorio double precision,
    saturacion_oxigeno integer,
    pafi integer,
    prono_vigil boolean,
    tos boolean,
    disnea integer,
    estabilidad_desaparicion_sintomas_resp boolean,
    somnolencia boolean NOT NULL,
    anosmia boolean NOT NULL,
    disgeusia boolean NOT NULL,
    radiografia_tipo varchar(255) DEFAULT NULL::character varying,
    radiografia_descrip varchar(255) DEFAULT NULL::character varying,
    tomografia_torax_tipo varchar(255) DEFAULT NULL::character varying,
    tomografia_torax_descrip varchar(255) DEFAULT NULL::character varying,
    electrocardiograma_tipo varchar(255) DEFAULT NULL::character varying,
    electrocardiograma_descrip varchar(255) DEFAULT NULL::character varying,
    pcr_covid_tipo varchar(255) DEFAULT NULL::character varying,
    pcr_covid_descrip varchar(255) DEFAULT NULL::character varying,
    observacion varchar(255) DEFAULT NULL::character varying
)
WITH (oids = false);
--
-- Structure for table internacion (OID = 41021) : 
--
CREATE TABLE public.internacion (
    id integer NOT NULL,
    paciente_id integer NOT NULL,
    sintomas varchar(255) NOT NULL,
    fecha_inicio_sintomas timestamp(0) without time zone NOT NULL,
    fecha_diagnostico timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    fecha_carga timestamp(0) without time zone NOT NULL,
    fecha_egreso timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    fecha_obito timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
)
WITH (oids = false);
--
-- Structure for table internacion_cama (OID = 41030) : 
--
CREATE TABLE public.internacion_cama (
    id integer NOT NULL,
    internacion_id integer NOT NULL,
    cama_id integer NOT NULL,
    fecha_desde timestamp(0) without time zone NOT NULL,
    fecha_hasta timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
)
WITH (oids = false);
--
-- Structure for table paciente (OID = 41038) : 
--
CREATE TABLE public.paciente (
    id integer NOT NULL,
    dni integer NOT NULL,
    apellido varchar(255) NOT NULL,
    nombre varchar(255) NOT NULL,
    direccion varchar(255) NOT NULL,
    telefono varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    fecha_nacimiento timestamp(0) without time zone NOT NULL,
    obra_social varchar(255) DEFAULT NULL::character varying,
    antecedentes text,
    contacto_nombre varchar(255) DEFAULT NULL::character varying,
    contacto_apellido varchar(255) DEFAULT NULL::character varying,
    contacto_telefono varchar(255) DEFAULT NULL::character varying,
    contacto_parentesco varchar(255) DEFAULT NULL::character varying
)
WITH (oids = false);
--
-- Structure for table sala (OID = 41051) : 
--
CREATE TABLE public.sala (
    id integer NOT NULL,
    sistema_id integer,
    nombre varchar(255) NOT NULL
)
WITH (oids = false);
--
-- Structure for table sistema (OID = 41057) : 
--
CREATE TABLE public.sistema (
    id integer NOT NULL,
    nombre varchar(255) NOT NULL,
    descrip varchar(255) DEFAULT NULL::character varying,
    camas_total integer NOT NULL,
    camas_disponibles integer NOT NULL,
    camas_ocupadas integer NOT NULL
)
WITH (oids = false);
--
-- Structure for table user_paciente (OID = 41066) : 
--
CREATE TABLE public.user_paciente (
    id integer NOT NULL,
    user_id integer NOT NULL,
    paciente_id integer NOT NULL,
    fecha_desde timestamp(0) without time zone NOT NULL,
    fecha_hasta timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
)
WITH (oids = false);
--
-- Definition for sequence user_id_seq (OID = 41074) : 
--
CREATE SEQUENCE public.user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Definition for sequence cama_id_seq (OID = 41076) : 
--
CREATE SEQUENCE public.cama_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Definition for sequence evolucion_id_seq (OID = 41078) : 
--
CREATE SEQUENCE public.evolucion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Definition for sequence internacion_id_seq (OID = 41080) : 
--
CREATE SEQUENCE public.internacion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Definition for sequence internacion_cama_id_seq (OID = 41082) : 
--
CREATE SEQUENCE public.internacion_cama_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Definition for sequence paciente_id_seq (OID = 41084) : 
--
CREATE SEQUENCE public.paciente_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Definition for sequence sala_id_seq (OID = 41086) : 
--
CREATE SEQUENCE public.sala_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Definition for sequence sistema_id_seq (OID = 41088) : 
--
CREATE SEQUENCE public.sistema_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Definition for sequence user_paciente_id_seq (OID = 41090) : 
--
CREATE SEQUENCE public.user_paciente_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Data for table public."user" (OID = 40986) (LIMIT 0,1)
--
INSERT INTO "user" (id, sistema_id, email, username, password, roles, created_at, updated_at, first_name, last_name, activo)
VALUES (2, 1, 'usuario@gmail.com', 'usuario', 'qsC2oCD92vaaJETg2sF4XE0/8neDLDYUCJhyva17RZ2TV2ayDVQmos3rrI4Ru5T3KAk7XJQ8g3KqZ75bGUsz+A==', '[]', '2020-11-06 00:36:28', '2020-11-06 00:36:28', 'raul', 'taibo', true);

--
-- Data for table public.cama (OID = 40997) (LIMIT 0,2)
--
INSERT INTO cama (id, sala_id, numero, estado)
VALUES (1, 1, 1, 'ocupada');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (2, 1, 2, 'ocupada');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (3, 1, 3, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (4, 1, 4, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (5, 1, 5, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (6, 2, 6, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (7, 2, 7, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (8, 2, 8, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (9, 2, 9, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (10, 3, 10, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (11, 3, 11, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (12, 3, 12, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (13, 3, 13, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (14, 3, 14, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (15, 3, 15, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (16, 4, 16, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (17, 4, 17, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (18, 4, 18, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (19, 4, 19, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (20, 4, 20, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (21, 5, 21, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (22, 5, 22, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (23, 5, 23, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (24, 5, 24, 'libre');

INSERT INTO cama (id, sala_id, numero, estado)
VALUES (25, 5, 25, 'libre');


--
-- Data for table public.internacion (OID = 41021) (LIMIT 0,2)
--
INSERT INTO internacion (id, paciente_id, sintomas, fecha_inicio_sintomas, fecha_diagnostico, fecha_carga, fecha_egreso, fecha_obito)
VALUES (12, 2, 'mareos, vomitos', '2020-11-30 03:00:00', '2020-11-30 03:00:00', '2020-11-08 01:42:20', NULL, NULL);

INSERT INTO internacion (id, paciente_id, sintomas, fecha_inicio_sintomas, fecha_diagnostico, fecha_carga, fecha_egreso, fecha_obito)
VALUES (3, 2, 'Está mal', '2020-09-28 00:00:00', '2020-09-30 00:00:00', '2020-09-30 00:00:00', '2020-11-07 00:00:00', NULL);

--
-- Data for table public.internacion_cama (OID = 41030) (LIMIT 0,2)
--
INSERT INTO internacion_cama (id, internacion_id, cama_id, fecha_desde, fecha_hasta)
VALUES (8, 12, 1, '2020-11-08 01:42:20', NULL);

INSERT INTO internacion_cama (id, internacion_id, cama_id, fecha_desde, fecha_hasta)
VALUES (3, 3, 2, '2020-11-07 21:49:42', '2020-11-07 00:00:00');

--
-- Data for table public.paciente (OID = 41038) (LIMIT 0,12)
--
INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (1, 24844469, 'Gutierrez', 'Laura', '12 1159', '2214123122', 'laura@gmail.com', '1999-10-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (2, 39597615, 'Rizzo', 'Leandro', '528', '2214207932', 'leandro@gmail.com', '1996-04-17 00:00:00', 'IOMA', 'neumonia desde los 20 años.', NULL, NULL, NULL, NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (3, 41140079, 'Bozo', 'Camila', '528', '2214207932', 'camila@gmail.com', '1998-05-12 00:00:00', 'IOMA', 'neumonia desde los 20 años.', NULL, NULL, NULL, NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (4, 13678999, 'Gerardo', 'Roman', '528 n 4241', '2343333', 'gerardo@gmail.com', '2020-11-19 03:00:00', 'OSDE', 'neumonia', NULL, NULL, NULL, NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (5, 213423432, 'Radi', 'Monica', '43534', '4353453', 'monica@gmail.com', '2020-08-11 03:00:00', 'OSDE', 'neumonia', 'Manciagli', 'Leandro', '22154875523', NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (6, 34534543, 'Gines', 'Maria', '23432', '22154875523', 'maria@gmail.com', '2020-09-15 03:00:00', 'IOMA', 'neumonia', NULL, NULL, NULL, NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (7, 353453, 'Pardo', 'Marcelo', '32534', '22154875523', 'marcelo@gmail.com', '2020-09-15 03:00:00', 'IOMA', 'neumonia', 'Manciagli', 'Leandro', '22154875523', NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (8, 1233333, 'Gar', 'Ines', '12312', '22154875523', 'ines@gmail.com', '2020-11-09 03:00:00', 'IOMA', 'neumonia', 'Manciagli', 'Leandro', '22154875523', NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (9, 234234, 'Chasi', 'Raul', '23423', '22154875523', 'raul@gmail.com', '2020-11-16 03:00:00', 'IOMA', 'neumonia', NULL, NULL, NULL, NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (10, 2342342, 'Medero', 'Jonatan', '34534', '22154875523', 'jon@gmail.com', '2020-11-17 03:00:00', 'IOMA', 'neumonia', NULL, NULL, NULL, NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (11, 234444, 'Raletti', 'Gustavo', '23434', '22154875523', 'gus@gmail.com', '2020-11-17 03:00:00', 'IOMA', 'neumonia', NULL, NULL, NULL, NULL);

INSERT INTO paciente (id, dni, apellido, nombre, direccion, telefono, email, fecha_nacimiento, obra_social, antecedentes, contacto_nombre, contacto_apellido, contacto_telefono, contacto_parentesco)
VALUES (12, 23423423, 'Roca', 'Martin', '324324', '22154875523', 'martin@gmail.com', '2020-11-16 03:00:00', 'IOMA', 'neumonia', NULL, NULL, NULL, NULL);

--
-- Data for table public.sala (OID = 41051) (LIMIT 0,1)
--
INSERT INTO sala (id, sistema_id, nombre)
VALUES (1, 1, 'Sala 1');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (2, 1, 'Sala 2');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (3, 2, 'Sala 1');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (4, 2, 'Sala 2');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (5, 3, 'Sala 1');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (6, 3, 'Sala 2');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (7, 4, 'Sala 1');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (8, 4, 'Sala 2');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (9, 5, 'Sala 1');

INSERT INTO sala (id, sistema_id, nombre)
VALUES (10, 5, 'Sala 2');


--
-- Data for table public.sistema (OID = 41057) (LIMIT 0,5)
--
INSERT INTO sistema (id, nombre, descrip, camas_total, camas_disponibles, camas_ocupadas)
VALUES (1, 'GUARDIA', 'Guardia', 5, 3, 2);

INSERT INTO sistema (id, nombre, descrip, camas_total, camas_disponibles, camas_ocupadas)
VALUES (2, 'PISOCOVID', 'Piso Covid', 5, 5, 0);

INSERT INTO sistema (id, nombre, descrip, camas_total, camas_disponibles, camas_ocupadas)
VALUES (3, 'UTI', 'UTI', 5, 5, 0);

INSERT INTO sistema (id, nombre, descrip, camas_total, camas_disponibles, camas_ocupadas)
VALUES (4, 'HOTEL', 'Hotel', 5, 5, 0);

INSERT INTO sistema (id, nombre, descrip, camas_total, camas_disponibles, camas_ocupadas)
VALUES (5, 'DOMICILIO', 'Domicilio', 5, 5, 0);

--
-- Definition for index uniq_8d93d649e7927c74 (OID = 40994) : 
--
CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON public."user" USING btree (email);
--
-- Definition for index uniq_8d93d649f85e0677 (OID = 40995) : 
--
CREATE UNIQUE INDEX uniq_8d93d649f85e0677 ON public."user" USING btree (username);
--
-- Definition for index idx_8d93d64917cda208 (OID = 40996) : 
--
CREATE INDEX idx_8d93d64917cda208 ON public."user" USING btree (sistema_id);
--
-- Definition for index idx_ab2462c2c51cdf3f (OID = 41002) : 
--
CREATE INDEX idx_ab2462c2c51cdf3f ON public.cama USING btree (sala_id);
--
-- Definition for index idx_8fc247b5b7888463 (OID = 41020) : 
--
CREATE INDEX idx_8fc247b5b7888463 ON public.evolucion USING btree (internacion_id);
--
-- Definition for index idx_71d573347310dad4 (OID = 41029) : 
--
CREATE INDEX idx_71d573347310dad4 ON public.internacion USING btree (paciente_id);
--
-- Definition for index idx_664cbc81b7888463 (OID = 41036) : 
--
CREATE INDEX idx_664cbc81b7888463 ON public.internacion_cama USING btree (internacion_id);
--
-- Definition for index idx_664cbc819fa26a41 (OID = 41037) : 
--
CREATE INDEX idx_664cbc819fa26a41 ON public.internacion_cama USING btree (cama_id);
--
-- Definition for index idx_e226041c17cda208 (OID = 41056) : 
--
CREATE INDEX idx_e226041c17cda208 ON public.sala USING btree (sistema_id);
--
-- Definition for index idx_26464d5ea76ed395 (OID = 41072) : 
--
CREATE INDEX idx_26464d5ea76ed395 ON public.user_paciente USING btree (user_id);
--
-- Definition for index idx_26464d5e7310dad4 (OID = 41073) : 
--
CREATE INDEX idx_26464d5e7310dad4 ON public.user_paciente USING btree (paciente_id);
--
-- Definition for index user_pkey (OID = 40992) : 
--
ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey
    PRIMARY KEY (id);
--
-- Definition for index cama_pkey (OID = 41000) : 
--
ALTER TABLE ONLY cama
    ADD CONSTRAINT cama_pkey
    PRIMARY KEY (id);
--
-- Definition for index evolucion_pkey (OID = 41018) : 
--
ALTER TABLE ONLY evolucion
    ADD CONSTRAINT evolucion_pkey
    PRIMARY KEY (id);
--
-- Definition for index internacion_pkey (OID = 41027) : 
--
ALTER TABLE ONLY internacion
    ADD CONSTRAINT internacion_pkey
    PRIMARY KEY (id);
--
-- Definition for index internacion_cama_pkey (OID = 41034) : 
--
ALTER TABLE ONLY internacion_cama
    ADD CONSTRAINT internacion_cama_pkey
    PRIMARY KEY (id);
--
-- Definition for index paciente_pkey (OID = 41049) : 
--
ALTER TABLE ONLY paciente
    ADD CONSTRAINT paciente_pkey
    PRIMARY KEY (id);
--
-- Definition for index sala_pkey (OID = 41054) : 
--
ALTER TABLE ONLY sala
    ADD CONSTRAINT sala_pkey
    PRIMARY KEY (id);
--
-- Definition for index sistema_pkey (OID = 41064) : 
--
ALTER TABLE ONLY sistema
    ADD CONSTRAINT sistema_pkey
    PRIMARY KEY (id);
--
-- Definition for index user_paciente_pkey (OID = 41070) : 
--
ALTER TABLE ONLY user_paciente
    ADD CONSTRAINT user_paciente_pkey
    PRIMARY KEY (id);
--
-- Definition for index fk_8d93d64917cda208 (OID = 41092) : 
--
ALTER TABLE ONLY "user"
    ADD CONSTRAINT fk_8d93d64917cda208
    FOREIGN KEY (sistema_id) REFERENCES sistema(id);
--
-- Definition for index fk_ab2462c2c51cdf3f (OID = 41097) : 
--
ALTER TABLE ONLY cama
    ADD CONSTRAINT fk_ab2462c2c51cdf3f
    FOREIGN KEY (sala_id) REFERENCES sala(id);
--
-- Definition for index fk_8fc247b5b7888463 (OID = 41102) : 
--
ALTER TABLE ONLY evolucion
    ADD CONSTRAINT fk_8fc247b5b7888463
    FOREIGN KEY (internacion_id) REFERENCES internacion(id);
--
-- Definition for index fk_71d573347310dad4 (OID = 41107) : 
--
ALTER TABLE ONLY internacion
    ADD CONSTRAINT fk_71d573347310dad4
    FOREIGN KEY (paciente_id) REFERENCES paciente(id);
--
-- Definition for index fk_664cbc81b7888463 (OID = 41112) : 
--
ALTER TABLE ONLY internacion_cama
    ADD CONSTRAINT fk_664cbc81b7888463
    FOREIGN KEY (internacion_id) REFERENCES internacion(id);
--
-- Definition for index fk_664cbc819fa26a41 (OID = 41117) : 
--
ALTER TABLE ONLY internacion_cama
    ADD CONSTRAINT fk_664cbc819fa26a41
    FOREIGN KEY (cama_id) REFERENCES cama(id);
--
-- Definition for index fk_e226041c17cda208 (OID = 41122) : 
--
ALTER TABLE ONLY sala
    ADD CONSTRAINT fk_e226041c17cda208
    FOREIGN KEY (sistema_id) REFERENCES sistema(id);
--
-- Definition for index fk_26464d5ea76ed395 (OID = 41127) : 
--
ALTER TABLE ONLY user_paciente
    ADD CONSTRAINT fk_26464d5ea76ed395
    FOREIGN KEY (user_id) REFERENCES "user"(id);
--
-- Definition for index fk_26464d5e7310dad4 (OID = 41132) : 
--
ALTER TABLE ONLY user_paciente
    ADD CONSTRAINT fk_26464d5e7310dad4
    FOREIGN KEY (paciente_id) REFERENCES paciente(id);
--
-- Data for sequence public.user_id_seq (OID = 41074)
--
SELECT pg_catalog.setval('user_id_seq', 2, true);
--
-- Data for sequence public.cama_id_seq (OID = 41076)
--
SELECT pg_catalog.setval('cama_id_seq', 1, false);
--
-- Data for sequence public.evolucion_id_seq (OID = 41078)
--
SELECT pg_catalog.setval('evolucion_id_seq', 1, false);
--
-- Data for sequence public.internacion_id_seq (OID = 41080)
--
SELECT pg_catalog.setval('internacion_id_seq', 17, true);
--
-- Data for sequence public.internacion_cama_id_seq (OID = 41082)
--
SELECT pg_catalog.setval('internacion_cama_id_seq', 13, true);
--
-- Data for sequence public.paciente_id_seq (OID = 41084)
--
SELECT pg_catalog.setval('paciente_id_seq', 12, true);
--
-- Data for sequence public.sala_id_seq (OID = 41086)
--
SELECT pg_catalog.setval('sala_id_seq', 1, false);
--
-- Data for sequence public.sistema_id_seq (OID = 41088)
--
SELECT pg_catalog.setval('sistema_id_seq', 1, false);
--
-- Data for sequence public.user_paciente_id_seq (OID = 41090)
--
SELECT pg_catalog.setval('user_paciente_id_seq', 1, false);
--
-- Comments
--
COMMENT ON SCHEMA public IS 'standard public schema';
COMMENT ON COLUMN public."user".roles IS '(DC2Type:json_array)';
