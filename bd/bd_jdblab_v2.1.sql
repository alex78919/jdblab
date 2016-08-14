/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     3/8/2016 7:12:19 p. m.                       */
/*==============================================================*/


drop table if exists CARGO;

drop table if exists CATEGORIA;

drop table if exists CATEGORIA_PRODUCTO;

drop table if exists CIUDAD;

drop table if exists CLASIFICACION_PROVEEDOR;

drop table if exists CLIENTE;

drop table if exists COMPONENTE;

drop table if exists EMAIL;

drop table if exists INSTITUCION;

drop table if exists JERARQUIA_CATEGORIA;

drop table if exists PERSONA;

drop table if exists PERSONA_EMAIL;

drop table if exists PRACTICA_REALIZABLE;

drop table if exists PRODUCTO;

drop table if exists PROFESION;

drop table if exists PROFORMA;

drop table if exists PROFORMA_PRODUCTO;

drop table if exists PROVEEDOR;

drop table if exists PROVEEDOR_EMAIL;

drop table if exists PROVEEDOR_GRUPO;

drop table if exists TELEFONO;

drop table if exists TELEFONO_PERSONA;

drop table if exists TELEFONO_PROVEEDOR;

drop table if exists TIPO_TELEFONO;

drop table if exists USUARIO;

/*==============================================================*/
/* Table: CARGO                                                 */
/*==============================================================*/
create table CARGO
(
   ID_CARGO             int not null auto_increment,
   NOMBRE_CARGO         varchar(200) not null,
   DESCRIPCION_CARGO    varchar(200),
   primary key (ID_CARGO)
);

/*==============================================================*/
/* Table: CATEGORIA                                             */
/*==============================================================*/
create table CATEGORIA
(
   ID_CATEGORIA         int not null auto_increment,
   NOMBRE_CATEGORIA     varchar(50),
   DESCRIPCION_CATEGORIA varchar(200),
   primary key (ID_CATEGORIA)
);

/*==============================================================*/
/* Table: CATEGORIA_PRODUCTO                                    */
/*==============================================================*/
create table CATEGORIA_PRODUCTO
(
   ID_CATEGORIA         int not null,
   ID_PRODUCTO          int not null,
   primary key (ID_CATEGORIA, ID_PRODUCTO)
);

/*==============================================================*/
/* Table: CIUDAD                                                */
/*==============================================================*/
create table CIUDAD
(
   ID_CIUDAD            int not null auto_increment,
   NOMBRE_CIUDAD        varchar(200) not null,
   primary key (ID_CIUDAD)
);

/*==============================================================*/
/* Table: CLASIFICACION_PROVEEDOR                               */
/*==============================================================*/
create table CLASIFICACION_PROVEEDOR
(
   ID_CLASIFICACION     int not null auto_increment,
   NOMBRE_CLASIFICACION varchar(200) not null,
   DESCRIPCION_CLASIFICACION varchar(500),
   primary key (ID_CLASIFICACION)
);

/*==============================================================*/
/* Table: CLIENTE                                               */
/*==============================================================*/
create table CLIENTE
(
   ID_PERSONA           int not null,
   ID_INSTITUCION       int,
   ID_PROFESION         int,
   ID_CARGO             int,
   ID_CIUDAD            int,
   NIT_CI_CLIENTE       varchar(20),
   primary key (ID_PERSONA)
);

/*==============================================================*/
/* Table: COMPONENTE                                            */
/*==============================================================*/
create table COMPONENTE
(
   ID_COMPONENTE        int not null auto_increment,
   ID_PRODUCTO          int,
   ESPECIFICACION_COMPONENTE varchar(500) not null,
   NUMERO_COMPONENTES   smallint,
   primary key (ID_COMPONENTE)
);

/*==============================================================*/
/* Table: EMAIL                                                 */
/*==============================================================*/
create table EMAIL
(
   ID_EMAIL             int not null auto_increment,
   NOMBRE_EMAIL         varchar(100) not null,
   DESC_EMAIL           varchar(200),
   primary key (ID_EMAIL)
);

/*==============================================================*/
/* Table: INSTITUCION                                           */
/*==============================================================*/
create table INSTITUCION
(
   ID_INSTITUCION       int not null auto_increment,
   NOMBRE_INSTITUCION   varchar(200) not null,
   primary key (ID_INSTITUCION)
);

/*==============================================================*/
/* Table: JERARQUIA_CATEGORIA                                   */
/*==============================================================*/
create table JERARQUIA_CATEGORIA
(
   ID_CATEGORIA         int not null,
   CAT_ID_CATEGORIA     int not null,
   primary key (ID_CATEGORIA, CAT_ID_CATEGORIA)
);

/*==============================================================*/
/* Table: PERSONA                                               */
/*==============================================================*/
create table PERSONA
(
   ID_PERSONA           int not null auto_increment,
   ID_PROVEEDOR         int,
   NOMBRES_PERSONA      varchar(200) not null,
   APELLIDO_P_PERSONA   varchar(200),
   APELLIDO_M_PERSONA   varchar(200),
   DIRECCION_PERSONA    varchar(400),
   primary key (ID_PERSONA)
);

/*==============================================================*/
/* Table: PERSONA_EMAIL                                         */
/*==============================================================*/
create table PERSONA_EMAIL
(
   ID_EMAIL             int not null,
   ID_PERSONA           int not null,
   primary key (ID_EMAIL)
);

/*==============================================================*/
/* Table: PRACTICA_REALIZABLE                                   */
/*==============================================================*/
create table PRACTICA_REALIZABLE
(
   ID_PRACTICA          int not null auto_increment,
   ID_PRODUCTO          int,
   DESCRIPCION_PRACTICA varchar(500) not null,
   primary key (ID_PRACTICA)
);

/*==============================================================*/
/* Table: PRODUCTO                                              */
/*==============================================================*/
create table PRODUCTO
(
   ID_PRODUCTO          int not null auto_increment,
   CODIGO_PRODUCTO      varchar(10) not null,
   NOMBRE_PRODUCTO      varchar(200) not null,
   DESCRIPCION_PRODUCTO varchar(4000),
   PRECIO_PRODUCTO      decimal,
   RUTA_IMAGEN          varchar(50),
   primary key (ID_PRODUCTO)
);

/*==============================================================*/
/* Table: PROFESION                                             */
/*==============================================================*/
create table PROFESION
(
   ID_PROFESION         int not null auto_increment,
   NOMBRE_PROFESION     varchar(200) not null,
   primary key (ID_PROFESION)
);

/*==============================================================*/
/* Table: PROFORMA                                              */
/*==============================================================*/
create table PROFORMA
(
   ID_PROFORMA          int not null auto_increment,
   ID_PERSONA           int,
   NUMERO_PROFORMA      int,
   FECHA_PROFORMA       date,
   FECHA_VALIDEZ        date,
   primary key (ID_PROFORMA)
);

/*==============================================================*/
/* Table: PROFORMA_PRODUCTO                                     */
/*==============================================================*/
create table PROFORMA_PRODUCTO
(
   ID_PROFORMA          int not null,
   ID_PRODUCTO          int not null,
   CANTIDAD_PRODUCTO    smallint not null,
   PRECIO_VENTA         smallint,
   primary key (ID_PROFORMA, ID_PRODUCTO)
);

/*==============================================================*/
/* Table: PROVEEDOR                                             */
/*==============================================================*/
create table PROVEEDOR
(
   ID_PROVEEDOR         int not null auto_increment,
   NOMBRE_PROVEEDOR     varchar(100),
   DESCRIPCION_PROVEEDOR varchar(200),
   DIRECCION_PROVEEDOR  varchar(200),
   primary key (ID_PROVEEDOR)
);

/*==============================================================*/
/* Table: PROVEEDOR_EMAIL                                       */
/*==============================================================*/
create table PROVEEDOR_EMAIL
(
   ID_EMAIL             int not null,
   ID_PROVEEDOR         int not null,
   primary key (ID_EMAIL)
);

/*==============================================================*/
/* Table: PROVEEDOR_GRUPO                                       */
/*==============================================================*/
create table PROVEEDOR_GRUPO
(
   ID_CLASIFICACION     int not null,
   ID_PROVEEDOR         int not null,
   primary key (ID_CLASIFICACION, ID_PROVEEDOR)
);

/*==============================================================*/
/* Table: TELEFONO                                              */
/*==============================================================*/
create table TELEFONO
(
   ID_TELEFONO          int not null auto_increment,
   ID_TIPO_TELF         int,
   NUMERO_TELEFONO      int not null,
   DESCRIPCION_TELEFONO varchar(200),
   primary key (ID_TELEFONO)
);

/*==============================================================*/
/* Table: TELEFONO_PERSONA                                      */
/*==============================================================*/
create table TELEFONO_PERSONA
(
   ID_TELEFONO          int not null,
   ID_PERSONA           int not null,
   primary key (ID_TELEFONO)
);

/*==============================================================*/
/* Table: TELEFONO_PROVEEDOR                                    */
/*==============================================================*/
create table TELEFONO_PROVEEDOR
(
   ID_TELEFONO          int not null,
   ID_PROVEEDOR         int not null,
   primary key (ID_TELEFONO)
);

/*==============================================================*/
/* Table: TIPO_TELEFONO                                         */
/*==============================================================*/
create table TIPO_TELEFONO
(
   ID_TIPO_TELF         int not null auto_increment,
   NOMBRE_TIPO_TELF     varchar(30),
   primary key (ID_TIPO_TELF)
);

/*==============================================================*/
/* Table: USUARIO                                               */
/*==============================================================*/
create table USUARIO
(
   ID_USUARIO           int not null auto_increment,
   ALIAS_USUARIO        varchar(30),
   CLAVE_USUARIO        varchar(30),
   primary key (ID_USUARIO)
);

alter table CATEGORIA_PRODUCTO add constraint FK_CATEGORIA_PRODUCTO foreign key (ID_CATEGORIA)
      references CATEGORIA (ID_CATEGORIA) on delete restrict on update restrict;

alter table CATEGORIA_PRODUCTO add constraint FK_CATEGORIA_PRODUCTO2 foreign key (ID_PRODUCTO)
      references PRODUCTO (ID_PRODUCTO) on delete restrict on update restrict;

alter table CLIENTE add constraint FK_RELATIONSHIP_14 foreign key (ID_PERSONA)
      references PERSONA (ID_PERSONA) on delete restrict on update restrict;

alter table CLIENTE add constraint FK_RELATIONSHIP_2 foreign key (ID_CIUDAD)
      references CIUDAD (ID_CIUDAD) on delete restrict on update restrict;

alter table CLIENTE add constraint FK_RELATIONSHIP_3 foreign key (ID_CARGO)
      references CARGO (ID_CARGO) on delete restrict on update restrict;

alter table CLIENTE add constraint FK_RELATIONSHIP_4 foreign key (ID_PROFESION)
      references PROFESION (ID_PROFESION) on delete restrict on update restrict;

alter table CLIENTE add constraint FK_RELATIONSHIP_5 foreign key (ID_INSTITUCION)
      references INSTITUCION (ID_INSTITUCION) on delete restrict on update restrict;

alter table COMPONENTE add constraint FK_RELATIONSHIP_9 foreign key (ID_PRODUCTO)
      references PRODUCTO (ID_PRODUCTO) on delete restrict on update restrict;

alter table JERARQUIA_CATEGORIA add constraint FK_JERARQUIA_CATEGORIA foreign key (ID_CATEGORIA)
      references CATEGORIA (ID_CATEGORIA) on delete restrict on update restrict;

alter table JERARQUIA_CATEGORIA add constraint FK_JERARQUIA_CATEGORIA2 foreign key (CAT_ID_CATEGORIA)
      references CATEGORIA (ID_CATEGORIA) on delete restrict on update restrict;

alter table PERSONA add constraint FK_RELATIONSHIP_19 foreign key (ID_PROVEEDOR)
      references PROVEEDOR (ID_PROVEEDOR) on delete restrict on update restrict;

alter table PERSONA_EMAIL add constraint FK_RELATIONSHIP_15 foreign key (ID_EMAIL)
      references EMAIL (ID_EMAIL) on delete restrict on update restrict;

alter table PERSONA_EMAIL add constraint FK_RELATIONSHIP_18 foreign key (ID_PERSONA)
      references PERSONA (ID_PERSONA) on delete restrict on update restrict;

alter table PRACTICA_REALIZABLE add constraint FK_RELATIONSHIP_8 foreign key (ID_PRODUCTO)
      references PRODUCTO (ID_PRODUCTO) on delete restrict on update restrict;

alter table PROFORMA add constraint FK_RELATIONSHIP_6 foreign key (ID_PERSONA)
      references CLIENTE (ID_PERSONA) on delete restrict on update restrict;

alter table PROFORMA_PRODUCTO add constraint FK_PROFORMA_PRODUCTO foreign key (ID_PROFORMA)
      references PROFORMA (ID_PROFORMA) on delete restrict on update restrict;

alter table PROFORMA_PRODUCTO add constraint FK_PROFORMA_PRODUCTO2 foreign key (ID_PRODUCTO)
      references PRODUCTO (ID_PRODUCTO) on delete restrict on update restrict;

alter table PROVEEDOR_EMAIL add constraint FK_RELATIONSHIP_16 foreign key (ID_PROVEEDOR)
      references PROVEEDOR (ID_PROVEEDOR) on delete restrict on update restrict;

alter table PROVEEDOR_EMAIL add constraint FK_RELATIONSHIP_17 foreign key (ID_EMAIL)
      references EMAIL (ID_EMAIL) on delete restrict on update restrict;

alter table PROVEEDOR_GRUPO add constraint FK_PROVEEDOR_GRUPO foreign key (ID_CLASIFICACION)
      references CLASIFICACION_PROVEEDOR (ID_CLASIFICACION) on delete restrict on update restrict;

alter table PROVEEDOR_GRUPO add constraint FK_PROVEEDOR_GRUPO2 foreign key (ID_PROVEEDOR)
      references PROVEEDOR (ID_PROVEEDOR) on delete restrict on update restrict;

alter table TELEFONO add constraint FK_RELATIONSHIP_11 foreign key (ID_TIPO_TELF)
      references TIPO_TELEFONO (ID_TIPO_TELF) on delete restrict on update restrict;

alter table TELEFONO_PERSONA add constraint FK_RELATIONSHIP_20 foreign key (ID_PERSONA)
      references PERSONA (ID_PERSONA) on delete restrict on update restrict;

alter table TELEFONO_PERSONA add constraint FK_RELATIONSHIP_21 foreign key (ID_TELEFONO)
      references TELEFONO (ID_TELEFONO) on delete restrict on update restrict;

alter table TELEFONO_PROVEEDOR add constraint FK_RELATIONSHIP_22 foreign key (ID_PROVEEDOR)
      references PROVEEDOR (ID_PROVEEDOR) on delete restrict on update restrict;

alter table TELEFONO_PROVEEDOR add constraint FK_RELATIONSHIP_23 foreign key (ID_TELEFONO)
      references TELEFONO (ID_TELEFONO) on delete restrict on update restrict;

