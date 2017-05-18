drop database if exists serials;

create database serials;

connect serials;

create table serial (
  id            int not null AUTO_INCREMENT,
  title         varchar(50) not null,
  poster        varchar(300) not null,
  description   text not null,
  constraint pk_serial primary key (id)
);

create table episode (
  id            int not null AUTO_INCREMENT,
  title         varchar(50) not null,
  description   text not null,
  date          datetime not null,
  serial_id     int not null,
  constraint pk_episode primary key (id),
  constraint fk_episode foreign key (serial_id) references serial(id) on DELETE CASCADE
);

commit;