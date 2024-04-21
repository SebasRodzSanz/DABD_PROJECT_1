CREATE SCHEMA Coordinacion_web;
USE coordinacion_web
CREATE TABLE Alumno (
	Cuenta VARCHAR(15) NOT NULL,
	Nombre VARCHAR(40) NOT NULL,
	Correo_e VARCHAR(30) NOT NULL,
	Folio VARCHAR(15),
	Telefono VARCHAR(12) NOT NULL,
	PRIMARY KEY (Cuenta),
	FOREIGN KEY (Folio) REFERENCES Trabajo (Clave)
);
CREATE TABLE Docente(
	Num_trabajador VARCHAR(15)  NOT NULL,
	Nombre_docente VARCHAR(40) NOT NULL,
	Fecha_ingreso DATE NOT NULL,
	Rfc VARCHAR(25) NOT NULL,
	Titulo VARCHAR(30) NOT NULL,
	Especialidad VARCHAR(120) NOT NULL,
	Celular VARCHAR(12) NOT NULL,
	Correo_e VARCHAR(30) NOT NULL,
	Antiguedad VARCHAR(3) NOT NULL,
	Total_cargos VARCHAR(2) NOT NULL,
	Seccion VARCHAR(20) NOT NULL,
	PRIMARY KEY (Num_trabajador)
);
CREATE TABLE Trabajo(
	Clave VARCHAR(15) NOT NULL,
	Titulo VARCHAR(70) NOT NULL,
	Fecha_registro DATE NOT NULL,
	Encargado VARCHAR(40) NOT NULL,
	Activo VARCHAR(3) NOT NULL, 
	PRIMARY KEY (Clave)
);
CREATE TABLE Detalle (
	Num_trabajador VARCHAR(15) NOT NULL,
	Clave_trabajo VARCHAR(15) NOT NULL,
	Categoria VARCHAR(30) NOT NULL,
	FOREIGN KEY (Num_trabajador) REFERENCES Docente(Num_trabajador),
	FOREIGN KEY (Clave_trabajo) REFERENCES Trabajo(Clave)
);