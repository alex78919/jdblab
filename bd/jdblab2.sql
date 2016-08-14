/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     17/06/2016 09:16:13 a.m.                     */
/*==============================================================*/


drop table if exists CARGO;

drop table if exists CATEGORIA;

drop table if exists CATEGORIA_PRODUCTO;

drop table if exists CIUDAD;

drop table if exists CLIENTE;

drop table if exists COMPONENTE;

drop table if exists INSTITUCION;

drop table if exists JERARQUIA_CATEGORIA;

drop table if exists PRACTICA_REALIZABLE;

drop table if exists PRODUCTO;

drop table if exists PROFESION;

drop table if exists PROFORMA;

drop table if exists PROFORMA_PRODUCTO;

drop table if exists TELEFONO;

drop table if exists USUARIO;

/*==============================================================*/
/* Table: CARGO                                                 */
/*==============================================================*/
create table CARGO
(
   ID_CARGO             int not null auto_increment,
   NOMBRE_CARGO         varchar(50),
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
   NOMBRE_CIUDAD        varchar(30),
   primary key (ID_CIUDAD)
);

/*==============================================================*/
/* Table: CLIENTE                                               */
/*==============================================================*/
create table CLIENTE
(
   ID_CLIENTE           int not null auto_increment,
   ID_INSTITUCION       int,
   ID_PROFESION         int,
   ID_CARGO             int,
   ID_CIUDAD            int,
   NOMBRES_CLIENTE      varchar(30),
   APELLIDO_P_CLIENTE   varchar(30),
   APELLIDO_M_CLIENTE   varchar(30),
   EMAIL_CLIENTE        varchar(30),
   DIRECCION_CLIENTE    varchar(200),
   primary key (ID_CLIENTE)
);

/*==============================================================*/
/* Table: COMPONENTE                                            */
/*==============================================================*/
create table COMPONENTE
(
   ID_COMPONENTE        int not null auto_increment,
   ID_PRODUCTO          int not null,
   ESPECIFICACION_COMPONENTE varchar(200),
   NUMERO_COMPONENTES   smallint,
   primary key (ID_COMPONENTE)
);

/*==============================================================*/
/* Table: INSTITUCION                                           */
/*==============================================================*/
create table INSTITUCION
(
   ID_INSTITUCION       int not null auto_increment,
   NOMBRE_INSTITUCION   varchar(30),
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
/* Table: PRACTICA_REALIZABLE                                   */
/*==============================================================*/
create table PRACTICA_REALIZABLE
(
   ID_PRACTICA          int not null auto_increment,
   ID_PRODUCTO          int,
   DESCRIPCION_PRACTICA varchar(200),
   primary key (ID_PRACTICA)
);

/*==============================================================*/
/* Table: PRODUCTO                                              */
/*==============================================================*/
create table PRODUCTO
(
   ID_PRODUCTO          int not null auto_increment,
   CODIGO_PRODUCTO      varchar(10),
   NOMBRE_PRODUCTO      varchar(30),
   DESCRIPCION_PRODUCTO varchar(200),
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
   NOMBRE_PROFESION     varchar(30),
   primary key (ID_PROFESION)
);

/*==============================================================*/
/* Table: PROFORMA                                              */
/*==============================================================*/
create table PROFORMA
(
   ID_PROFORMA          int not null auto_increment,
   ID_CLIENTE           int,
   NUMERO_PROFORMA      int,
   FECHA_PROFORMA       date,
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
   primary key (ID_PROFORMA, ID_PRODUCTO)
);

/*==============================================================*/
/* Table: TELEFONO                                              */
/*==============================================================*/
create table TELEFONO
(
   ID_TELEFONO          int not null auto_increment,
   ID_CLIENTE           int,
   NUMERO_TELEFONO      int,
   primary key (ID_TELEFONO)
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

alter table PRACTICA_REALIZABLE add constraint FK_RELATIONSHIP_8 foreign key (ID_PRODUCTO)
      references PRODUCTO (ID_PRODUCTO) on delete restrict on update restrict;

alter table PROFORMA add constraint FK_RELATIONSHIP_6 foreign key (ID_CLIENTE)
      references CLIENTE (ID_CLIENTE) on delete restrict on update restrict;

alter table PROFORMA_PRODUCTO add constraint FK_PROFORMA_PRODUCTO foreign key (ID_PROFORMA)
      references PROFORMA (ID_PROFORMA) on delete restrict on update restrict;

alter table PROFORMA_PRODUCTO add constraint FK_PROFORMA_PRODUCTO2 foreign key (ID_PRODUCTO)
      references PRODUCTO (ID_PRODUCTO) on delete restrict on update restrict;

alter table TELEFONO add constraint FK_RELATIONSHIP_1 foreign key (ID_CLIENTE)
      references CLIENTE (ID_CLIENTE) on delete restrict on update restrict;

