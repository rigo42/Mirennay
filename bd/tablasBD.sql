CREATE TABLE estado(
	id_estado INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	estado VARCHAR(100) NOT NULL,
	abreviatura VARCHAR(10) NOT NULL,
	pais VARCHAR(10)
);

CREATE TABLE municipio(
    id_municipio INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_estado INT NOT NULL,
    municipio VARCHAR(100) NOT NULL,
    nom_cab VARCHAR(100),
    FOREIGN KEY(id_estado) REFERENCES estado(id_estado)
);

CREATE TABLE empresa(
	id_empresa INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	empresa VARCHAR(100) NOT NULL,
	direccion VARCHAR(100) NOT NULL,
	celular VARCHAR(15)  NULL,
	observacion TEXT NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL
);

CREATE TABLE usuario(
	id_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	usuario VARCHAR(150) NOT NULL,
	password VARCHAR(200) NOT NULL,
	correo VARCHAR(150) NOT NULL,
	rol VARCHAR(150) NOT NULL,
	fecha_inicio DATETIME NULL,
	fecha_fin DATETIME NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL
);

CREATE TABLE usuario_detalle(
	id_usuario_detalle INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_usuario INT NOT NULL,
	id_municipio INT NOT NULL,
	nombre_completo VARCHAR(250) NOT NULL,
	direccion VARCHAR(500) NOT NULL,
	observacion VARCHAR(500) NULL,
	codigo_postal VARCHAR(10) NOT NULL,
	celular VARCHAR(20) NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL,
	FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario),
	FOREIGN KEY(id_municipio) REFERENCES municipio(id_municipio)
);

CREATE TABLE proveedor(
	id_proveedor INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_empresa INT NOT NULL,
	id_municipio INT NOT NULL,
	proveedor VARCHAR(150) NOT NULL,
	direccion VARCHAR(150) NOT NULL,
	codigo_postal VARCHAR(10) NOT NULL,
	celular VARCHAR(20) NULL,
	observacion TEXT NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL,
	FOREIGN KEY(id_empresa) REFERENCES empresa(id_empresa),
	FOREIGN KEY(id_municipio) REFERENCES municipio(id_municipio)
);

CREATE TABLE categoria(
	id_categoria INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	categoria VARCHAR(150) NOT NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL
);

CREATE TABLE producto_genero(
	id_genero INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	genero VARCHAR(150) NOT NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL
);

CREATE TABLE producto_talla(
	id_talla INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	talla VARCHAR(150) NOT NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL
);

CREATE TABLE producto(
	id_producto INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_proveedor INT NOT NULL,
	id_categoria INT NOT NULL,
	id_genero INT  NULL,
	producto VARCHAR(200) NOT NULL,
	descripcion TEXT NOT NULL,
	observacion TEXT NOT NULL,
	precio FLOAT NOT NULL,
	imagen_principal VARCHAR(150) NOT NULL,
	activo_oferta BIT(1) NOT NULL,
	precio_oferta FLOAT NULL,
	titulo VARCHAR(50) NULL,
	sub_titulo VARCHAR(100) NULL,
	fecha_fin_oferta DATETIME NULL,
	imagen_oferta VARCHAR(100) NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL,
	FOREIGN KEY(id_proveedor) REFERENCES proveedor(id_proveedor),
	FOREIGN KEY(id_categoria) REFERENCES categoria(id_categoria),
	FOREIGN KEY(id_genero) REFERENCES producto_genero(id_genero)
);

CREATE TABLE producto_detalle(
	id_producto_detalle INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_producto INT NOT NULL,
	id_talla INT NULL,
	color VARCHAR(50) NULL,
	imagen1 VARCHAR(100) NULL,
	imagen2 VARCHAR(100) NULL,
	imagen3 VARCHAR(100) NULL,
	imagen4 VARCHAR(100) NULL,
	imagen5 VARCHAR(100) NULL,
	imagen6 VARCHAR(100) NULL,
	imagen7 VARCHAR(100) NULL,
	cantidad INT NOT NULL, 
	activo BIT(1) NOT NULL,
	FOREIGN KEY(id_producto) REFERENCES producto(id_producto),
	FOREIGN KEY(id_talla) REFERENCES producto_talla(id_talla)
);

CREATE TABLE producto_comentario(
	id_producto_comentario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_producto INT NOT NULL,
	id_usuario INT NOT NULL,
	comentario VARCHAR(200) NOT NULL,
	cantidad_estrella INT NOT NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL,
	FOREIGN KEY(id_producto) REFERENCES producto(id_producto),
	FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE producto_favorito(
	id_producto_favorito INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_producto INT NOT NULL,
	id_usuario INT NOT NULL,
	fecha_alta DATETIME NOT NULL,
	activo BIT(1) NOT NULL,
	FOREIGN KEY(id_producto) REFERENCES producto(id_producto),
	FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE pedido_usuario(
	id_pedido_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_producto_detalle INT NOT NULL,
	id_usuario_detalle INT NOT NULL,
	cantidad INT NOT NULL,
	subtotal FLOAT NOT NULL,
	folio VARCHAR(150) NOT NULL,
	fecha_pedido DATETIME NOT NULL,
	entregado BIT(1) NOT NULL,
	activo BIT(1) NOT NULL,
	FOREIGN KEY(id_producto_detalle) REFERENCES producto_detalle(id_producto_detalle),
	FOREIGN KEY(id_usuario_detalle) REFERENCES usuario_detalle(id_usuario_detalle)
);
