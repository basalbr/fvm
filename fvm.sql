/*
Navicat PGSQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 90405
Source Host           : localhost:5432
Source Database       : fvm
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90405
File Encoding         : 65001

Date: 2015-12-22 17:42:03
*/


-- ----------------------------
-- Sequence structure for cnae_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cnae_id_seq";
CREATE SEQUENCE "public"."cnae_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for natureza_juridica_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."natureza_juridica_id_seq";
CREATE SEQUENCE "public"."natureza_juridica_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for pessoa_cnae_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pessoa_cnae_id_seq";
CREATE SEQUENCE "public"."pessoa_cnae_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for pessoa_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pessoa_id_seq";
CREATE SEQUENCE "public"."pessoa_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for tabela_simples_nacional_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."tabela_simples_nacional_id_seq";
CREATE SEQUENCE "public"."tabela_simples_nacional_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 4
 CACHE 1;
SELECT setval('"public"."tabela_simples_nacional_id_seq"', 4, true);

-- ----------------------------
-- Sequence structure for tipo_tributacao_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."tipo_tributacao_id_seq";
CREATE SEQUENCE "public"."tipo_tributacao_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;
SELECT setval('"public"."tipo_tributacao_id_seq"', 1, true);

-- ----------------------------
-- Sequence structure for usuario_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."usuario_id_seq";
CREATE SEQUENCE "public"."usuario_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 2
 CACHE 1;
SELECT setval('"public"."usuario_id_seq"', 2, true);

-- ----------------------------
-- Table structure for cnae
-- ----------------------------
DROP TABLE IF EXISTS "public"."cnae";
CREATE TABLE "public"."cnae" (
"id" int4 DEFAULT nextval('cnae_id_seq'::regclass) NOT NULL,
"id_tabela_simples_nacional" int4 NOT NULL,
"descricao" varchar(255) COLLATE "default" NOT NULL,
"codigo" int4 NOT NULL,
"created_at" timestamp NOT NULL,
"updated_at" timestamp NOT NULL,
"deleted_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of cnae
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS "public"."migrations";
CREATE TABLE "public"."migrations" (
"migration" varchar(255) COLLATE "default" NOT NULL,
"batch" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO "public"."migrations" VALUES ('2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO "public"."migrations" VALUES ('2015_11_25_114553_create_usuario_table', '1');
INSERT INTO "public"."migrations" VALUES ('2015_12_14_085031_create_natureza_juridica_table', '1');
INSERT INTO "public"."migrations" VALUES ('2015_12_14_085259_create_tabela_simples_nacional_table', '1');
INSERT INTO "public"."migrations" VALUES ('2015_12_14_085317_create_tabela_tipo_tributacao_table', '1');
INSERT INTO "public"."migrations" VALUES ('2015_12_14_085408_create_cnae_table', '1');
INSERT INTO "public"."migrations" VALUES ('2015_12_14_085414_create_pessoa_table', '1');
INSERT INTO "public"."migrations" VALUES ('2015_12_14_085434_create_pessoa_cnae_table', '1');

-- ----------------------------
-- Table structure for natureza_juridica
-- ----------------------------
DROP TABLE IF EXISTS "public"."natureza_juridica";
CREATE TABLE "public"."natureza_juridica" (
"id" int4 DEFAULT nextval('natureza_juridica_id_seq'::regclass) NOT NULL,
"descricao" varchar(255) COLLATE "default" NOT NULL,
"representante" varchar(255) COLLATE "default" NOT NULL,
"qualificacao" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp NOT NULL,
"updated_at" timestamp NOT NULL,
"deleted_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of natureza_juridica
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS "public"."password_resets";
CREATE TABLE "public"."password_resets" (
"email" varchar(255) COLLATE "default" NOT NULL,
"token" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for pessoa
-- ----------------------------
DROP TABLE IF EXISTS "public"."pessoa";
CREATE TABLE "public"."pessoa" (
"id" int4 DEFAULT nextval('pessoa_id_seq'::regclass) NOT NULL,
"id_usuario" int4 NOT NULL,
"id_natureza_juridica" int4 NOT NULL,
"tipo" varchar(255) COLLATE "default" NOT NULL,
"cpf_cnpj" int8 NOT NULL,
"inscricao_estadual" int8 NOT NULL,
"inscricao_municipal" int8 NOT NULL,
"iptu" int8 NOT NULL,
"rg" int4 NOT NULL,
"qtde_funcionarios" int4 NOT NULL,
"email" varchar(255) COLLATE "default" NOT NULL,
"telefone" int8 NOT NULL,
"responsavel" varchar(255) COLLATE "default" NOT NULL,
"nome" varchar(255) COLLATE "default" NOT NULL,
"nome_fantasia" varchar(255) COLLATE "default" NOT NULL,
"razao_social" varchar(255) COLLATE "default" NOT NULL,
"ramal" int4 NOT NULL,
"endereco" varchar(255) COLLATE "default" NOT NULL,
"bairro" varchar(255) COLLATE "default" NOT NULL,
"numero" int4 NOT NULL,
"cep" int4 NOT NULL,
"cidade" varchar(255) COLLATE "default" NOT NULL,
"estado" varchar(255) COLLATE "default" NOT NULL,
"nacionalidade" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp NOT NULL,
"updated_at" timestamp NOT NULL,
"deleted_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of pessoa
-- ----------------------------

-- ----------------------------
-- Table structure for pessoa_cnae
-- ----------------------------
DROP TABLE IF EXISTS "public"."pessoa_cnae";
CREATE TABLE "public"."pessoa_cnae" (
"id" int4 DEFAULT nextval('pessoa_cnae_id_seq'::regclass) NOT NULL,
"id_pessoa" int4 NOT NULL,
"id_cnae" int4 NOT NULL,
"created_at" timestamp NOT NULL,
"updated_at" timestamp NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of pessoa_cnae
-- ----------------------------

-- ----------------------------
-- Table structure for tabela_simples_nacional
-- ----------------------------
DROP TABLE IF EXISTS "public"."tabela_simples_nacional";
CREATE TABLE "public"."tabela_simples_nacional" (
"id" int4 DEFAULT nextval('tabela_simples_nacional_id_seq'::regclass) NOT NULL,
"descricao" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp NOT NULL,
"updated_at" timestamp NOT NULL,
"deleted_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of tabela_simples_nacional
-- ----------------------------
INSERT INTO "public"."tabela_simples_nacional" VALUES ('1', 'Teste', '2015-12-22 10:22:24', '2015-12-22 10:37:05', null);

-- ----------------------------
-- Table structure for tipo_tributacao
-- ----------------------------
DROP TABLE IF EXISTS "public"."tipo_tributacao";
CREATE TABLE "public"."tipo_tributacao" (
"id" int4 DEFAULT nextval('tipo_tributacao_id_seq'::regclass) NOT NULL,
"descricao" varchar(255) COLLATE "default" NOT NULL,
"has_tabela" bool NOT NULL,
"created_at" timestamp NOT NULL,
"updated_at" timestamp NOT NULL,
"deleted_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of tipo_tributacao
-- ----------------------------
INSERT INTO "public"."tipo_tributacao" VALUES ('1', 'teste', 't', '2015-12-22 11:00:43', '2015-12-22 11:01:35', null);

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS "public"."usuario";
CREATE TABLE "public"."usuario" (
"id" int4 DEFAULT nextval('usuario_id_seq'::regclass) NOT NULL,
"nome" varchar(255) COLLATE "default" NOT NULL,
"email" varchar(255) COLLATE "default" NOT NULL,
"senha" varchar(60) COLLATE "default" NOT NULL,
"admin" bool DEFAULT false NOT NULL,
"remember_token" varchar(100) COLLATE "default",
"created_at" timestamp NOT NULL,
"updated_at" timestamp NOT NULL,
"deleted_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO "public"."usuario" VALUES ('2', 'Aldir Baseggio Junior', 'basal_@hotmail.com', '$2y$10$4lh2C8jRBYJhOGPt7roilOEairB44uge0SQsK02mEc4ogwLRzej8O', 't', null, '2015-12-22 09:00:38', '2015-12-22 09:00:38', null);

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------
ALTER SEQUENCE "public"."cnae_id_seq" OWNED BY "cnae"."id";
ALTER SEQUENCE "public"."natureza_juridica_id_seq" OWNED BY "natureza_juridica"."id";
ALTER SEQUENCE "public"."pessoa_cnae_id_seq" OWNED BY "pessoa_cnae"."id";
ALTER SEQUENCE "public"."pessoa_id_seq" OWNED BY "pessoa"."id";
ALTER SEQUENCE "public"."tabela_simples_nacional_id_seq" OWNED BY "tabela_simples_nacional"."id";
ALTER SEQUENCE "public"."tipo_tributacao_id_seq" OWNED BY "tipo_tributacao"."id";
ALTER SEQUENCE "public"."usuario_id_seq" OWNED BY "usuario"."id";

-- ----------------------------
-- Primary Key structure for table cnae
-- ----------------------------
ALTER TABLE "public"."cnae" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table natureza_juridica
-- ----------------------------
ALTER TABLE "public"."natureza_juridica" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table password_resets
-- ----------------------------
CREATE INDEX "password_resets_email_index" ON "public"."password_resets" USING btree ("email");
CREATE INDEX "password_resets_token_index" ON "public"."password_resets" USING btree ("token");

-- ----------------------------
-- Checks structure for table pessoa
-- ----------------------------
ALTER TABLE "public"."pessoa" ADD CHECK ((tipo)::text = ANY ((ARRAY['F'::character varying, 'J'::character varying])::text[]));

-- ----------------------------
-- Primary Key structure for table pessoa
-- ----------------------------
ALTER TABLE "public"."pessoa" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table pessoa_cnae
-- ----------------------------
ALTER TABLE "public"."pessoa_cnae" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table tabela_simples_nacional
-- ----------------------------
ALTER TABLE "public"."tabela_simples_nacional" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table tipo_tributacao
-- ----------------------------
ALTER TABLE "public"."tipo_tributacao" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table usuario
-- ----------------------------
ALTER TABLE "public"."usuario" ADD UNIQUE ("email");

-- ----------------------------
-- Primary Key structure for table usuario
-- ----------------------------
ALTER TABLE "public"."usuario" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table "public"."cnae"
-- ----------------------------
ALTER TABLE "public"."cnae" ADD FOREIGN KEY ("id_tabela_simples_nacional") REFERENCES "public"."tabela_simples_nacional" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Key structure for table "public"."pessoa"
-- ----------------------------
ALTER TABLE "public"."pessoa" ADD FOREIGN KEY ("id_usuario") REFERENCES "public"."usuario" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."pessoa" ADD FOREIGN KEY ("id_natureza_juridica") REFERENCES "public"."natureza_juridica" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Key structure for table "public"."pessoa_cnae"
-- ----------------------------
ALTER TABLE "public"."pessoa_cnae" ADD FOREIGN KEY ("id_cnae") REFERENCES "public"."cnae" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."pessoa_cnae" ADD FOREIGN KEY ("id_pessoa") REFERENCES "public"."pessoa" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
