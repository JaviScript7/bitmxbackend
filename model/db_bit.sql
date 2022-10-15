
/* Base de datos para el bit para realizar el scanner */

DROP TABLE IF EXISTS Profile;
DROP TABLE IF EXISTS Alumno;
DROP TABLE IF EXISTS ProfileAdmin;
DROP TABLE IF EXISTS Talleres;
DROP TABLE IF EXISTS AlumnoConnection





create table Profile(
	id int not null auto_increment,
	email varchar(60),
	hashpass varchar(60),
	primary key (id)
);

create table ProfileAdmin(
	id int not null auto_increment,
	email varchar(60),
	hashpass varchar(60),
	primary key (id)
);

create table ProfileAdminQR(
	id int not null auto_increment,
	email varchar(60),
	hashpass varchar(60),
	primary key (id)
);

create table Alumno(
	id int not null auto_increment,
	Nombre varchar(30),
	ApellidoM varchar(30),
	ApellidoP varchar(30),
	Carrera varchar(255),
	Matricula varchar(255),
	Celular varchar(30),
	Institucion varchar(30),
	aType varchar(30),
	foreign key (id) references Profile(id) on delete cascade,
	primary key (id)
);



create table Talleres(
	id int not null auto_increment,
	nomTaller varchar(30),
	horaTaller varchar(30),
	numAsiento varchar(30),
	foreign key (id) references Alumno(id) on delete cascade,
	primary key (id)
);

create table ALumnoAsistencia(
	id1 int,
	id2 int,
	since datetime,
	foreign key (id1) references Alumno(id) on delete cascade,
	foreign key (id2) references Talleres(id) on delete cascade,
	primary key (id1, id2)
);

