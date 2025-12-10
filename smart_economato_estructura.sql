--
-- PostgreSQL database dump
--

\restrict d2NsmiH9KSyv3jOgpU3ZF6d6eKZEooEIVjCaW80yrYXncHqXXfhdFnxbKgL3sSV

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.6

-- Started on 2025-11-30 10:34:13

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 239 (class 1259 OID 16670)
-- Name: actividad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.actividad (
    id_actividad integer NOT NULL,
    id_usuario integer NOT NULL,
    fecha_hora time without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    accion character varying(100) NOT NULL,
    entidad character varying(100),
    entidad_id integer,
    detalle text
);


ALTER TABLE public.actividad OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 16673)
-- Name: actividad_id_actividad_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.actividad_id_actividad_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.actividad_id_actividad_seq OWNER TO postgres;

--
-- TOC entry 5042 (class 0 OID 0)
-- Dependencies: 240
-- Name: actividad_id_actividad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.actividad_id_actividad_seq OWNED BY public.actividad.id_actividad;


--
-- TOC entry 231 (class 1259 OID 16587)
-- Name: baja_inventario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.baja_inventario (
    id_baja integer NOT NULL,
    id_producto integer NOT NULL,
    usuario_id integer NOT NULL,
    fecha date NOT NULL,
    cantidad numeric NOT NULL,
    motivo text,
    coste_unitario numeric NOT NULL
);


ALTER TABLE public.baja_inventario OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 16590)
-- Name: baja_inventario_id_baja_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.baja_inventario_id_baja_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.baja_inventario_id_baja_seq OWNER TO postgres;

--
-- TOC entry 5043 (class 0 OID 0)
-- Dependencies: 232
-- Name: baja_inventario_id_baja_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.baja_inventario_id_baja_seq OWNED BY public.baja_inventario.id_baja;


--
-- TOC entry 235 (class 1259 OID 16624)
-- Name: ficha_ingrediente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ficha_ingrediente (
    id_ficha_ing integer NOT NULL,
    id_ficha integer NOT NULL,
    id_producto integer NOT NULL,
    cantidad numeric NOT NULL,
    rendimiento_pct numeric DEFAULT 100 NOT NULL
);


ALTER TABLE public.ficha_ingrediente OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 16627)
-- Name: ficha_ingrediente_id_ficha_ing_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ficha_ingrediente_id_ficha_ing_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ficha_ingrediente_id_ficha_ing_seq OWNER TO postgres;

--
-- TOC entry 5044 (class 0 OID 0)
-- Dependencies: 236
-- Name: ficha_ingrediente_id_ficha_ing_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ficha_ingrediente_id_ficha_ing_seq OWNED BY public.ficha_ingrediente.id_ficha_ing;


--
-- TOC entry 233 (class 1259 OID 16611)
-- Name: ficha_tecnica; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ficha_tecnica (
    id_ficha integer NOT NULL,
    producto_final character varying(200) NOT NULL,
    descripcion text NOT NULL,
    alergenos text,
    num_raciones numeric DEFAULT 1 NOT NULL,
    tamano_racion character varying(100),
    tiempo_preparacion character varying(50),
    equipo_necesario text
);


ALTER TABLE public.ficha_tecnica OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 16614)
-- Name: ficha_tecnica_id_ficha_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ficha_tecnica_id_ficha_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ficha_tecnica_id_ficha_seq OWNER TO postgres;

--
-- TOC entry 5045 (class 0 OID 0)
-- Dependencies: 234
-- Name: ficha_tecnica_id_ficha_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ficha_tecnica_id_ficha_seq OWNED BY public.ficha_tecnica.id_ficha;


--
-- TOC entry 227 (class 1259 OID 16536)
-- Name: pedido_interno; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedido_interno (
    id_pedido integer NOT NULL,
    solicitante integer NOT NULL,
    fecha_pedido date NOT NULL,
    fecha_entrega date,
    estado character varying(50) DEFAULT 'pendiente'::character varying NOT NULL,
    observaciones text
);


ALTER TABLE public.pedido_interno OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 16544)
-- Name: pedido_interno_id_pedido_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_interno_id_pedido_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedido_interno_id_pedido_seq OWNER TO postgres;

--
-- TOC entry 5046 (class 0 OID 0)
-- Dependencies: 228
-- Name: pedido_interno_id_pedido_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedido_interno_id_pedido_seq OWNED BY public.pedido_interno.id_pedido;


--
-- TOC entry 229 (class 1259 OID 16562)
-- Name: pedido_interno_linea; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedido_interno_linea (
    id_linea integer NOT NULL,
    id_pedido integer NOT NULL,
    id_producto integer NOT NULL,
    cantidad numeric NOT NULL,
    coste_unitario numeric NOT NULL
);


ALTER TABLE public.pedido_interno_linea OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 16565)
-- Name: pedido_interno_linea_id_linea_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_interno_linea_id_linea_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedido_interno_linea_id_linea_seq OWNER TO postgres;

--
-- TOC entry 5047 (class 0 OID 0)
-- Dependencies: 230
-- Name: pedido_interno_linea_id_linea_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedido_interno_linea_id_linea_seq OWNED BY public.pedido_interno_linea.id_linea;


--
-- TOC entry 219 (class 1259 OID 16466)
-- Name: producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.producto (
    id_producto integer NOT NULL,
    nombre character varying(150) NOT NULL,
    categoria character varying(100) NOT NULL,
    unidad character varying(20),
    stock_minimo numeric NOT NULL,
    stock_actual numeric NOT NULL,
    url_imagen text
);


ALTER TABLE public.producto OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16469)
-- Name: producto_id_producto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.producto_id_producto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.producto_id_producto_seq OWNER TO postgres;

--
-- TOC entry 5048 (class 0 OID 0)
-- Dependencies: 220
-- Name: producto_id_producto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.producto_id_producto_seq OWNED BY public.producto.id_producto;


--
-- TOC entry 221 (class 1259 OID 16478)
-- Name: proveedor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.proveedor (
    id_proveedor integer NOT NULL,
    nombre character varying(150) NOT NULL
);


ALTER TABLE public.proveedor OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16481)
-- Name: proveedor_id_proveedor_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.proveedor_id_proveedor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.proveedor_id_proveedor_seq OWNER TO postgres;

--
-- TOC entry 5049 (class 0 OID 0)
-- Dependencies: 222
-- Name: proveedor_id_proveedor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.proveedor_id_proveedor_seq OWNED BY public.proveedor.id_proveedor;


--
-- TOC entry 223 (class 1259 OID 16488)
-- Name: recepcion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.recepcion (
    id_recepcion integer NOT NULL,
    id_proveedor integer NOT NULL,
    n_albaran character varying(100) NOT NULL,
    fecha date NOT NULL,
    observaciones text,
    recibido_por integer NOT NULL,
    concordancia boolean NOT NULL
);


ALTER TABLE public.recepcion OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16512)
-- Name: recepcion_detalle; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.recepcion_detalle (
    id_detalle integer NOT NULL,
    id_recepcion integer NOT NULL,
    id_producto integer NOT NULL,
    cantidad numeric NOT NULL,
    coste_unitario numeric NOT NULL,
    impuestos numeric NOT NULL,
    observaciones text
);


ALTER TABLE public.recepcion_detalle OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 16515)
-- Name: recepcion_detalle_id_detalle_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.recepcion_detalle_id_detalle_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.recepcion_detalle_id_detalle_seq OWNER TO postgres;

--
-- TOC entry 5050 (class 0 OID 0)
-- Dependencies: 226
-- Name: recepcion_detalle_id_detalle_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.recepcion_detalle_id_detalle_seq OWNED BY public.recepcion_detalle.id_detalle;


--
-- TOC entry 224 (class 1259 OID 16491)
-- Name: recepcion_id_recepcion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.recepcion_id_recepcion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.recepcion_id_recepcion_seq OWNER TO postgres;

--
-- TOC entry 5051 (class 0 OID 0)
-- Dependencies: 224
-- Name: recepcion_id_recepcion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.recepcion_id_recepcion_seq OWNED BY public.recepcion.id_recepcion;


--
-- TOC entry 237 (class 1259 OID 16649)
-- Name: rendimiento_ingrediente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rendimiento_ingrediente (
    id_rendimiento integer NOT NULL,
    id_producto integer NOT NULL,
    peso_bruto numeric DEFAULT 0 NOT NULL,
    peso_neto numeric DEFAULT 0 NOT NULL,
    porcentaje_rendimiento numeric DEFAULT 100 NOT NULL
);


ALTER TABLE public.rendimiento_ingrediente OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 16652)
-- Name: rendimiento_ingrediente_id_rendimiento_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.rendimiento_ingrediente_id_rendimiento_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.rendimiento_ingrediente_id_rendimiento_seq OWNER TO postgres;

--
-- TOC entry 5052 (class 0 OID 0)
-- Dependencies: 238
-- Name: rendimiento_ingrediente_id_rendimiento_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.rendimiento_ingrediente_id_rendimiento_seq OWNED BY public.rendimiento_ingrediente.id_rendimiento;


--
-- TOC entry 217 (class 1259 OID 16452)
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario (
    id_usuario integer NOT NULL,
    nombre character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    password_hash character varying(255) NOT NULL,
    rol character varying(50) NOT NULL,
    activo boolean NOT NULL,
    ultimo_login timestamp without time zone
);


ALTER TABLE public.usuario OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16455)
-- Name: usuario_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuario_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuario_id_usuario_seq OWNER TO postgres;

--
-- TOC entry 5053 (class 0 OID 0)
-- Dependencies: 218
-- Name: usuario_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuario_id_usuario_seq OWNED BY public.usuario.id_usuario;


--
-- TOC entry 4814 (class 2604 OID 16674)
-- Name: actividad id_actividad; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.actividad ALTER COLUMN id_actividad SET DEFAULT nextval('public.actividad_id_actividad_seq'::regclass);


--
-- TOC entry 4805 (class 2604 OID 16591)
-- Name: baja_inventario id_baja; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baja_inventario ALTER COLUMN id_baja SET DEFAULT nextval('public.baja_inventario_id_baja_seq'::regclass);


--
-- TOC entry 4808 (class 2604 OID 16628)
-- Name: ficha_ingrediente id_ficha_ing; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ficha_ingrediente ALTER COLUMN id_ficha_ing SET DEFAULT nextval('public.ficha_ingrediente_id_ficha_ing_seq'::regclass);


--
-- TOC entry 4806 (class 2604 OID 16615)
-- Name: ficha_tecnica id_ficha; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ficha_tecnica ALTER COLUMN id_ficha SET DEFAULT nextval('public.ficha_tecnica_id_ficha_seq'::regclass);


--
-- TOC entry 4802 (class 2604 OID 16545)
-- Name: pedido_interno id_pedido; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_interno ALTER COLUMN id_pedido SET DEFAULT nextval('public.pedido_interno_id_pedido_seq'::regclass);


--
-- TOC entry 4804 (class 2604 OID 16566)
-- Name: pedido_interno_linea id_linea; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_interno_linea ALTER COLUMN id_linea SET DEFAULT nextval('public.pedido_interno_linea_id_linea_seq'::regclass);


--
-- TOC entry 4798 (class 2604 OID 16470)
-- Name: producto id_producto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto ALTER COLUMN id_producto SET DEFAULT nextval('public.producto_id_producto_seq'::regclass);


--
-- TOC entry 4799 (class 2604 OID 16482)
-- Name: proveedor id_proveedor; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proveedor ALTER COLUMN id_proveedor SET DEFAULT nextval('public.proveedor_id_proveedor_seq'::regclass);


--
-- TOC entry 4800 (class 2604 OID 16492)
-- Name: recepcion id_recepcion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recepcion ALTER COLUMN id_recepcion SET DEFAULT nextval('public.recepcion_id_recepcion_seq'::regclass);


--
-- TOC entry 4801 (class 2604 OID 16516)
-- Name: recepcion_detalle id_detalle; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recepcion_detalle ALTER COLUMN id_detalle SET DEFAULT nextval('public.recepcion_detalle_id_detalle_seq'::regclass);


--
-- TOC entry 4810 (class 2604 OID 16653)
-- Name: rendimiento_ingrediente id_rendimiento; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rendimiento_ingrediente ALTER COLUMN id_rendimiento SET DEFAULT nextval('public.rendimiento_ingrediente_id_rendimiento_seq'::regclass);


--
-- TOC entry 4797 (class 2604 OID 16456)
-- Name: usuario id_usuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuario_id_usuario_seq'::regclass);


--
-- TOC entry 5035 (class 0 OID 16670)
-- Dependencies: 239
-- Data for Name: actividad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.actividad (id_actividad, id_usuario, fecha_hora, accion, entidad, entidad_id, detalle) FROM stdin;
\.


--
-- TOC entry 5027 (class 0 OID 16587)
-- Dependencies: 231
-- Data for Name: baja_inventario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.baja_inventario (id_baja, id_producto, usuario_id, fecha, cantidad, motivo, coste_unitario) FROM stdin;
\.


--
-- TOC entry 5031 (class 0 OID 16624)
-- Dependencies: 235
-- Data for Name: ficha_ingrediente; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ficha_ingrediente (id_ficha_ing, id_ficha, id_producto, cantidad, rendimiento_pct) FROM stdin;
\.


--
-- TOC entry 5029 (class 0 OID 16611)
-- Dependencies: 233
-- Data for Name: ficha_tecnica; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ficha_tecnica (id_ficha, producto_final, descripcion, alergenos, num_raciones, tamano_racion, tiempo_preparacion, equipo_necesario) FROM stdin;
\.


--
-- TOC entry 5023 (class 0 OID 16536)
-- Dependencies: 227
-- Data for Name: pedido_interno; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedido_interno (id_pedido, solicitante, fecha_pedido, fecha_entrega, estado, observaciones) FROM stdin;
\.


--
-- TOC entry 5025 (class 0 OID 16562)
-- Dependencies: 229
-- Data for Name: pedido_interno_linea; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedido_interno_linea (id_linea, id_pedido, id_producto, cantidad, coste_unitario) FROM stdin;
\.


--
-- TOC entry 5015 (class 0 OID 16466)
-- Dependencies: 219
-- Data for Name: producto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.producto (id_producto, nombre, categoria, unidad, stock_minimo, stock_actual, url_imagen) FROM stdin;
1	Harina de Trigo	Secos	kg	10	25	\N
\.


--
-- TOC entry 5017 (class 0 OID 16478)
-- Dependencies: 221
-- Data for Name: proveedor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.proveedor (id_proveedor, nombre) FROM stdin;
1	Distribuciones del Sur
\.


--
-- TOC entry 5019 (class 0 OID 16488)
-- Dependencies: 223
-- Data for Name: recepcion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.recepcion (id_recepcion, id_proveedor, n_albaran, fecha, observaciones, recibido_por, concordancia) FROM stdin;
3	1	ALB-001	2025-11-12	Primer pedido	2	f
\.


--
-- TOC entry 5021 (class 0 OID 16512)
-- Dependencies: 225
-- Data for Name: recepcion_detalle; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.recepcion_detalle (id_detalle, id_recepcion, id_producto, cantidad, coste_unitario, impuestos, observaciones) FROM stdin;
3	3	1	25	0.80	0	\N
\.


--
-- TOC entry 5033 (class 0 OID 16649)
-- Dependencies: 237
-- Data for Name: rendimiento_ingrediente; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rendimiento_ingrediente (id_rendimiento, id_producto, peso_bruto, peso_neto, porcentaje_rendimiento) FROM stdin;
\.


--
-- TOC entry 5013 (class 0 OID 16452)
-- Dependencies: 217
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuario (id_usuario, nombre, email, password_hash, rol, activo, ultimo_login) FROM stdin;
2	admin	a@b.es	admin123	admin	t	\N
\.


--
-- TOC entry 5054 (class 0 OID 0)
-- Dependencies: 240
-- Name: actividad_id_actividad_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.actividad_id_actividad_seq', 1, false);


--
-- TOC entry 5055 (class 0 OID 0)
-- Dependencies: 232
-- Name: baja_inventario_id_baja_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.baja_inventario_id_baja_seq', 1, false);


--
-- TOC entry 5056 (class 0 OID 0)
-- Dependencies: 236
-- Name: ficha_ingrediente_id_ficha_ing_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ficha_ingrediente_id_ficha_ing_seq', 1, false);


--
-- TOC entry 5057 (class 0 OID 0)
-- Dependencies: 234
-- Name: ficha_tecnica_id_ficha_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ficha_tecnica_id_ficha_seq', 1, false);


--
-- TOC entry 5058 (class 0 OID 0)
-- Dependencies: 228
-- Name: pedido_interno_id_pedido_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedido_interno_id_pedido_seq', 1, false);


--
-- TOC entry 5059 (class 0 OID 0)
-- Dependencies: 230
-- Name: pedido_interno_linea_id_linea_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedido_interno_linea_id_linea_seq', 1, false);


--
-- TOC entry 5060 (class 0 OID 0)
-- Dependencies: 220
-- Name: producto_id_producto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.producto_id_producto_seq', 1, true);


--
-- TOC entry 5061 (class 0 OID 0)
-- Dependencies: 222
-- Name: proveedor_id_proveedor_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.proveedor_id_proveedor_seq', 1, true);


--
-- TOC entry 5062 (class 0 OID 0)
-- Dependencies: 226
-- Name: recepcion_detalle_id_detalle_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.recepcion_detalle_id_detalle_seq', 3, true);


--
-- TOC entry 5063 (class 0 OID 0)
-- Dependencies: 224
-- Name: recepcion_id_recepcion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.recepcion_id_recepcion_seq', 3, true);


--
-- TOC entry 5064 (class 0 OID 0)
-- Dependencies: 238
-- Name: rendimiento_ingrediente_id_rendimiento_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rendimiento_ingrediente_id_rendimiento_seq', 1, false);


--
-- TOC entry 5065 (class 0 OID 0)
-- Dependencies: 218
-- Name: usuario_id_usuario_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuario_id_usuario_seq', 2, true);


--
-- TOC entry 4853 (class 2606 OID 16682)
-- Name: actividad actividad_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.actividad
    ADD CONSTRAINT actividad_pkey PRIMARY KEY (id_actividad);


--
-- TOC entry 4840 (class 2606 OID 16598)
-- Name: baja_inventario baja_inventario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baja_inventario
    ADD CONSTRAINT baja_inventario_pkey PRIMARY KEY (id_baja);


--
-- TOC entry 4846 (class 2606 OID 16636)
-- Name: ficha_ingrediente ficha_ingrediente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ficha_ingrediente
    ADD CONSTRAINT ficha_ingrediente_pkey PRIMARY KEY (id_ficha_ing);


--
-- TOC entry 4844 (class 2606 OID 16623)
-- Name: ficha_tecnica ficha_tecnica_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ficha_tecnica
    ADD CONSTRAINT ficha_tecnica_pkey PRIMARY KEY (id_ficha);


--
-- TOC entry 4838 (class 2606 OID 16574)
-- Name: pedido_interno_linea pedido_interno_linea_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_interno_linea
    ADD CONSTRAINT pedido_interno_linea_pkey PRIMARY KEY (id_linea);


--
-- TOC entry 4834 (class 2606 OID 16555)
-- Name: pedido_interno pedido_interno_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_interno
    ADD CONSTRAINT pedido_interno_pkey PRIMARY KEY (id_pedido);


--
-- TOC entry 4821 (class 2606 OID 16477)
-- Name: producto producto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_pkey PRIMARY KEY (id_producto);


--
-- TOC entry 4823 (class 2606 OID 16487)
-- Name: proveedor proveedor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proveedor
    ADD CONSTRAINT proveedor_pkey PRIMARY KEY (id_proveedor);


--
-- TOC entry 4831 (class 2606 OID 16523)
-- Name: recepcion_detalle recepcion_detalle_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recepcion_detalle
    ADD CONSTRAINT recepcion_detalle_pkey PRIMARY KEY (id_detalle);


--
-- TOC entry 4827 (class 2606 OID 16499)
-- Name: recepcion recepcion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recepcion
    ADD CONSTRAINT recepcion_pkey PRIMARY KEY (id_recepcion);


--
-- TOC entry 4851 (class 2606 OID 16663)
-- Name: rendimiento_ingrediente rendimiento_ingrediente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rendimiento_ingrediente
    ADD CONSTRAINT rendimiento_ingrediente_pkey PRIMARY KEY (id_rendimiento);


--
-- TOC entry 4817 (class 2606 OID 16465)
-- Name: usuario usuario_email_unico; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_email_unico UNIQUE (email);


--
-- TOC entry 4819 (class 2606 OID 16463)
-- Name: usuario usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 4854 (class 1259 OID 16688)
-- Name: fki_actividad_id_usuario_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_actividad_id_usuario_fk ON public.actividad USING btree (id_usuario);


--
-- TOC entry 4841 (class 1259 OID 16604)
-- Name: fki_baja_inventario_id_producto_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_baja_inventario_id_producto_fk ON public.baja_inventario USING btree (id_producto);


--
-- TOC entry 4842 (class 1259 OID 16610)
-- Name: fki_baja_inventario_usuario_id_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_baja_inventario_usuario_id_fk ON public.baja_inventario USING btree (usuario_id);


--
-- TOC entry 4847 (class 1259 OID 16642)
-- Name: fki_ficha_ingrediente_id_ficha_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_ficha_ingrediente_id_ficha_fk ON public.ficha_ingrediente USING btree (id_ficha);


--
-- TOC entry 4848 (class 1259 OID 16648)
-- Name: fki_ficha_ingrediente_id_producto_f; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_ficha_ingrediente_id_producto_f ON public.ficha_ingrediente USING btree (id_producto);


--
-- TOC entry 4835 (class 1259 OID 16580)
-- Name: fki_pedido_interno_linea_id_pedido_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_pedido_interno_linea_id_pedido_fk ON public.pedido_interno_linea USING btree (id_pedido);


--
-- TOC entry 4836 (class 1259 OID 16586)
-- Name: fki_pedido_interno_linea_id_producto_f; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_pedido_interno_linea_id_producto_f ON public.pedido_interno_linea USING btree (id_producto);


--
-- TOC entry 4832 (class 1259 OID 16561)
-- Name: fki_pedido_interno_solicitante_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_pedido_interno_solicitante_fk ON public.pedido_interno USING btree (solicitante);


--
-- TOC entry 4828 (class 1259 OID 16535)
-- Name: fki_recepcion_detalle_id_producto_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_recepcion_detalle_id_producto_fk ON public.recepcion_detalle USING btree (id_producto);


--
-- TOC entry 4829 (class 1259 OID 16529)
-- Name: fki_recepcion_detalle_id_recepcion_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_recepcion_detalle_id_recepcion_fk ON public.recepcion_detalle USING btree (id_recepcion);


--
-- TOC entry 4824 (class 1259 OID 16511)
-- Name: fki_recepcion_id_proveedor_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_recepcion_id_proveedor_fk ON public.recepcion USING btree (id_proveedor);


--
-- TOC entry 4825 (class 1259 OID 16505)
-- Name: fki_recepcion_recibido_por_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_recepcion_recibido_por_fk ON public.recepcion USING btree (recibido_por);


--
-- TOC entry 4849 (class 1259 OID 16669)
-- Name: fki_rendimiento_ingrediente_id_producto_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_rendimiento_ingrediente_id_producto_fk ON public.rendimiento_ingrediente USING btree (id_producto);


--
-- TOC entry 4867 (class 2606 OID 16683)
-- Name: actividad actividad_id_usuario_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.actividad
    ADD CONSTRAINT actividad_id_usuario_fk FOREIGN KEY (id_usuario) REFERENCES public.usuario(id_usuario) NOT VALID;


--
-- TOC entry 4862 (class 2606 OID 16599)
-- Name: baja_inventario baja_inventario_id_producto_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baja_inventario
    ADD CONSTRAINT baja_inventario_id_producto_fk FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto) NOT VALID;


--
-- TOC entry 4863 (class 2606 OID 16605)
-- Name: baja_inventario baja_inventario_usuario_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baja_inventario
    ADD CONSTRAINT baja_inventario_usuario_id_fk FOREIGN KEY (usuario_id) REFERENCES public.usuario(id_usuario) NOT VALID;


--
-- TOC entry 4864 (class 2606 OID 16637)
-- Name: ficha_ingrediente ficha_ingrediente_id_ficha_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ficha_ingrediente
    ADD CONSTRAINT ficha_ingrediente_id_ficha_fk FOREIGN KEY (id_ficha) REFERENCES public.ficha_tecnica(id_ficha) NOT VALID;


--
-- TOC entry 4865 (class 2606 OID 16643)
-- Name: ficha_ingrediente ficha_ingrediente_id_producto_f; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ficha_ingrediente
    ADD CONSTRAINT ficha_ingrediente_id_producto_f FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto) NOT VALID;


--
-- TOC entry 4860 (class 2606 OID 16575)
-- Name: pedido_interno_linea pedido_interno_linea_id_pedido_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_interno_linea
    ADD CONSTRAINT pedido_interno_linea_id_pedido_fk FOREIGN KEY (id_pedido) REFERENCES public.pedido_interno(id_pedido) NOT VALID;


--
-- TOC entry 4861 (class 2606 OID 16581)
-- Name: pedido_interno_linea pedido_interno_linea_id_producto_f; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_interno_linea
    ADD CONSTRAINT pedido_interno_linea_id_producto_f FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto) NOT VALID;


--
-- TOC entry 4859 (class 2606 OID 16556)
-- Name: pedido_interno pedido_interno_solicitante_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_interno
    ADD CONSTRAINT pedido_interno_solicitante_fk FOREIGN KEY (solicitante) REFERENCES public.usuario(id_usuario) NOT VALID;


--
-- TOC entry 4857 (class 2606 OID 16530)
-- Name: recepcion_detalle recepcion_detalle_id_producto_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recepcion_detalle
    ADD CONSTRAINT recepcion_detalle_id_producto_fk FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto) NOT VALID;


--
-- TOC entry 4858 (class 2606 OID 16524)
-- Name: recepcion_detalle recepcion_detalle_id_recepcion_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recepcion_detalle
    ADD CONSTRAINT recepcion_detalle_id_recepcion_fk FOREIGN KEY (id_recepcion) REFERENCES public.recepcion(id_recepcion) NOT VALID;


--
-- TOC entry 4855 (class 2606 OID 16506)
-- Name: recepcion recepcion_id_proveedor_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recepcion
    ADD CONSTRAINT recepcion_id_proveedor_fk FOREIGN KEY (id_proveedor) REFERENCES public.proveedor(id_proveedor) NOT VALID;


--
-- TOC entry 4856 (class 2606 OID 16500)
-- Name: recepcion recepcion_recibido_por_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recepcion
    ADD CONSTRAINT recepcion_recibido_por_fk FOREIGN KEY (recibido_por) REFERENCES public.usuario(id_usuario) NOT VALID;


--
-- TOC entry 4866 (class 2606 OID 16664)
-- Name: rendimiento_ingrediente rendimiento_ingrediente_id_producto_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rendimiento_ingrediente
    ADD CONSTRAINT rendimiento_ingrediente_id_producto_fk FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto) NOT VALID;


-- Completed on 2025-11-30 10:34:15

--
-- PostgreSQL database dump complete
--

\unrestrict d2NsmiH9KSyv3jOgpU3ZF6d6eKZEooEIVjCaW80yrYXncHqXXfhdFnxbKgL3sSV

