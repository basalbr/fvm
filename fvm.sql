--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.2
-- Dumped by pg_dump version 9.5.2

-- Started on 2016-04-24 22:14:49

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET search_path = public, pg_catalog;

--
-- TOC entry 2235 (class 0 OID 24578)
-- Dependencies: 198
-- Data for Name: chamado; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO chamado VALUES (4, 2, 'Teste', 'teste', '2016-04-08 20:21:17', '2016-04-08 20:21:17', NULL);


--
-- TOC entry 2261 (class 0 OID 0)
-- Dependencies: 197
-- Name: chamado_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('chamado_id_seq', 4, true);


--
-- TOC entry 2237 (class 0 OID 24594)
-- Dependencies: 200
-- Data for Name: chamado_resposta; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO chamado_resposta VALUES (1, 2, 'teste', '2016-04-08 20:37:00', '2016-04-08 20:37:00', NULL, 4);
INSERT INTO chamado_resposta VALUES (2, 2, '123', '2016-04-08 20:42:57', '2016-04-08 20:42:57', NULL, 4);


--
-- TOC entry 2262 (class 0 OID 0)
-- Dependencies: 199
-- Name: chamado_resposta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('chamado_resposta_id_seq', 2, true);


--
-- TOC entry 2225 (class 0 OID 16514)
-- Dependencies: 188
-- Data for Name: cnae; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO cnae VALUES (1, 1, 'teste', '2016-04-02 15:31:35', '2016-04-02 15:32:19', NULL, '1234-5/64');


--
-- TOC entry 2263 (class 0 OID 0)
-- Dependencies: 181
-- Name: cnae_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('cnae_id_seq', 1, true);


--
-- TOC entry 2239 (class 0 OID 32770)
-- Dependencies: 202
-- Data for Name: imposto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO imposto VALUES (1, 'teste', 16, 'posterga', true, '2016-04-23 12:48:51', '2016-04-23 20:41:27', NULL);


--
-- TOC entry 2264 (class 0 OID 0)
-- Dependencies: 201
-- Name: imposto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('imposto_id_seq', 1, true);


--
-- TOC entry 2241 (class 0 OID 32778)
-- Dependencies: 204
-- Data for Name: imposto_mes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO imposto_mes VALUES (76, 1, 0, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (77, 1, 2, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (78, 1, 3, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (79, 1, 4, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (80, 1, 5, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (81, 1, 6, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (82, 1, 8, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (83, 1, 9, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (84, 1, 10, '2016-04-23 20:41:27', '2016-04-23 20:41:27');
INSERT INTO imposto_mes VALUES (85, 1, 11, '2016-04-23 20:41:27', '2016-04-23 20:41:27');


--
-- TOC entry 2265 (class 0 OID 0)
-- Dependencies: 203
-- Name: imposto_mes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('imposto_mes_id_seq', 85, true);


--
-- TOC entry 2226 (class 0 OID 16518)
-- Dependencies: 189
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO migrations VALUES ('2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO migrations VALUES ('2015_11_25_114553_create_usuario_table', 1);
INSERT INTO migrations VALUES ('2015_12_14_085031_create_natureza_juridica_table', 1);
INSERT INTO migrations VALUES ('2015_12_14_085259_create_tabela_simples_nacional_table', 1);
INSERT INTO migrations VALUES ('2015_12_14_085317_create_tabela_tipo_tributacao_table', 1);
INSERT INTO migrations VALUES ('2015_12_14_085408_create_cnae_table', 1);
INSERT INTO migrations VALUES ('2015_12_14_085414_create_pessoa_table', 1);
INSERT INTO migrations VALUES ('2015_12_14_085434_create_pessoa_cnae_table', 1);
INSERT INTO migrations VALUES ('2016_04_08_192632_create_chamado_table', 2);
INSERT INTO migrations VALUES ('2016_04_08_192840_create_chamado_resposta_table', 2);
INSERT INTO migrations VALUES ('2016_04_08_194400_add_id_chamado_chamado_resposta_table', 3);
INSERT INTO migrations VALUES ('2016_04_23_102958_create_imposto_table', 4);
INSERT INTO migrations VALUES ('2016_04_23_104103_create_imposto_mes_table', 4);


--
-- TOC entry 2227 (class 0 OID 16521)
-- Dependencies: 190
-- Data for Name: natureza_juridica; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO natureza_juridica VALUES (1, '12132123', '123123', '123132', '2016-04-09 17:38:25', '2016-04-09 17:38:25', NULL);


--
-- TOC entry 2266 (class 0 OID 0)
-- Dependencies: 182
-- Name: natureza_juridica_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('natureza_juridica_id_seq', 1, true);


--
-- TOC entry 2228 (class 0 OID 16528)
-- Dependencies: 191
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2229 (class 0 OID 16534)
-- Dependencies: 192
-- Data for Name: pessoa; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO pessoa VALUES (12, 2, 1, 'J', 1231321322311231, 321321321, 321321321, 321321, NULL, 23123132, '21321231', 3, '321321', NULL, '1231321', '23132132132', NULL, '1321231', '3213213', NULL, 2, '231321231', '321321321', NULL, '2016-04-09 18:01:15', '2016-04-09 18:01:15', NULL);


--
-- TOC entry 2230 (class 0 OID 16541)
-- Dependencies: 193
-- Data for Name: pessoa_cnae; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO pessoa_cnae VALUES (2, 12, 1, '2016-04-09 18:01:15', '2016-04-09 18:01:15');


--
-- TOC entry 2267 (class 0 OID 0)
-- Dependencies: 183
-- Name: pessoa_cnae_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('pessoa_cnae_id_seq', 3, true);


--
-- TOC entry 2268 (class 0 OID 0)
-- Dependencies: 184
-- Name: pessoa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('pessoa_id_seq', 13, true);


--
-- TOC entry 2231 (class 0 OID 16545)
-- Dependencies: 194
-- Data for Name: tabela_simples_nacional; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tabela_simples_nacional VALUES (1, 'Teste', '2015-12-22 10:22:24', '2015-12-22 10:37:05', NULL);


--
-- TOC entry 2269 (class 0 OID 0)
-- Dependencies: 185
-- Name: tabela_simples_nacional_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela_simples_nacional_id_seq', 4, true);


--
-- TOC entry 2232 (class 0 OID 16549)
-- Dependencies: 195
-- Data for Name: tipo_tributacao; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_tributacao VALUES (1, 'teste', true, '2015-12-22 11:00:43', '2015-12-22 11:01:35', NULL);


--
-- TOC entry 2270 (class 0 OID 0)
-- Dependencies: 186
-- Name: tipo_tributacao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_tributacao_id_seq', 1, true);


--
-- TOC entry 2233 (class 0 OID 16553)
-- Dependencies: 196
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO usuario VALUES (2, 'Aldir Baseggio Junior', 'basal_@hotmail.com', '$2y$10$CIJG3747Iw2OPjkyH2SmUeCJAgpDlZlH.b4rmavFDX8tEVp6z24P6', true, NULL, '2015-12-22 09:00:38', '2016-04-02 13:12:36', NULL);


--
-- TOC entry 2271 (class 0 OID 0)
-- Dependencies: 187
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuario_id_seq', 2, true);


-- Completed on 2016-04-24 22:14:49

--
-- PostgreSQL database dump complete
--

