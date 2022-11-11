SHOW CREATE TABLE t_users;

SHOW CREATE TABLE t_stars;

-- SHOW CREATE TABLE t_favorites;

-- select * from t_usersusernamet_users
insert into t_stars ( name, r_ang, dec_ang, const, description) values ('test str',30, 30, 'uhh turtle', 'uhhhhhh');

create table  t_c_stars (
name varchar(256) not null primary key,
r_ang decimal(5,4) not null,
dec_ang decimal(5,4) not null,
const varchar(256),
description TEXT
);


select * from t_stars;
drop table t_stars;
drop table t_favorites;

CREATE TABLE t_users ( username varchar(50) NOT NULL, passwd varchar(256) NOT NULL, counter int, PRIMARY KEY (username));

truncate table t_favorites;
ALTER TABLE t_users
ADD counter int;

CREATE TABLE t_stars (name varchar(256) NOT NULL,
 r_ang decimal(8,4) NOT NULL,  
 dec_ang decimal(8,4) NOT NULL, 
 const varchar(256) DEFAULT NULL, 
 description text, 
 PRIMARY KEY (name));
 
 CREATE TABLE t_favorites (
  f_username varchar(50) NOT NULL,
  f_star varchar(256) NOT NULL,
  KEY f_username (f_username),
  KEY f_star (f_star),
  CONSTRAINT t_favorites_ibfk_1 FOREIGN KEY (f_username) REFERENCES t_users (username),
  CONSTRAINT t_favorites_ibfk_2 FOREIGN KEY (f_star) REFERENCES t_stars (name)
);

select * from t_users;
insert into t_stars values ('Bellatrix', 81.2825,95.2458,'orion', 'Named after a female warrior');
insert into t_stars values ('Mintaka A',83.0013 ,4.4875,'orion', 'An eclipsing binary and multiple system with B a very faint companion and C an easily seen pale blue companion.');
insert into t_stars values ('Mintaka B',83.0017 ,4.2667,'orion', 'An eclipsing binary and multiple system with B a very faint companion and C an easily seen pale blue companion.');
insert into t_stars values ('Alnilam',84.0529 ,18.0292,'orion', 'Also called the String of Pearls');
insert into t_stars values ('Alnitak A',85.1896 ,29.1417,'orion', 'A very nice triplet , A and B are quite close. C is nearly 60° away.');
insert into t_stars values ('Alnitak B', 85.1896,29.1417,'orion', 'A very nice triplet , A and B are quite close. C is nearly 60° away.');
insert into t_stars values ('Algiebba',81.1192 ,35.9542,'orion', 'A close and difficult binary');
insert into t_stars values ('Trapezium 1A',83.5642 ,80.8083,'orion', 'The most famous multiple star system in the heavens, the Trapezium. The very young stars that make up this quartet are generally considered by authorities to be about1300-1900 l.y. away.');