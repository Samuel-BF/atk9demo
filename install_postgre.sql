--
-- DEMO INSTALLATION FOR POSTGRESQL DATABASES
-- Please read README.md before you start
-- And read install_mysql.sql for comments about these tables.
--

CREATE TABLE lesson1_employee
(
  id SERIAL,
  name varchar NOT NULL,
  hiredate date default NULL,
  notes text,
  salary decimal default NULL,
  PRIMARY KEY  (id)
) ;

INSERT INTO lesson1_employee (id, name, hiredate, notes, salary) VALUES (1, 'Jack', '2004-04-27', '', '1000.00');
INSERT INTO lesson1_employee (id, name, hiredate, notes, salary) VALUES (2, 'Bill', '2000-06-01', 'Test employee', '60.00');
INSERT INTO lesson1_employee (id, name, hiredate, notes, salary) VALUES (3, 'Simon', '2004-02-09', 'Simon the Sourceror', '500.00');

-- ATK will insert records based on a sequence.
CREATE SEQUENCE lesson1_employee_seq START WITH 4;

CREATE TABLE lesson2_department
(
  id SERIAL,
  name varchar NOT NULL,
  PRIMARY KEY  (id)
) ;

INSERT INTO lesson2_department (id, name) VALUES (1, 'Sales department');
INSERT INTO lesson2_department (id, name) VALUES (2, 'Support');

CREATE TABLE lesson2_employee
(
  id SERIAL,
  name varchar NOT NULL,
  department int default NULL,
  hiredate date default NULL,
  notes text,
  salary decimal default NULL,
  manager int default NULL,
  PRIMARY KEY  (id)
) ;

INSERT INTO lesson2_employee (id, name, department, hiredate, notes, salary, manager) VALUES (1, 'Jack', 1, '2004-05-03', 'test', '1000.00', NULL);
INSERT INTO lesson2_employee (id, name, department, hiredate, notes, salary, manager) VALUES (2, 'Joe', 2, '2004-05-03', 'test employee', '500.00', 1);

CREATE SEQUENCE lesson2_employee_seq START WITH 3;
CREATE SEQUENCE lesson2_department_seq START WITH 3;

CREATE TABLE lesson3_department
(
  id SERIAL,
  name varchar NOT NULL,
  is_hiring int NOT NULL default '1',
  PRIMARY KEY  (id)
) ;

INSERT INTO lesson3_department (id, name, is_hiring) VALUES (1, 'Sales', 1);
INSERT INTO lesson3_department (id, name, is_hiring) VALUES (2, 'Support', 0);


CREATE TABLE lesson3_employee
(
  id SERIAL,
  name varchar NOT NULL,
  department int default NULL,
  hiredate date default NULL,
  notes text,
  salary decimal default NULL,
  manager int default NULL,
  PRIMARY KEY  (id)
) ;

INSERT INTO lesson3_employee (id, name, department, hiredate, notes, salary, manager) VALUES (1, 'Jack The Manager', 1, '2004-05-03', '', '1000.00', NULL);
INSERT INTO lesson3_employee (id, name, department, hiredate, notes, salary, manager) VALUES (2, 'Joe The Employee', 1, '2004-05-03', '', '500.00', 1);
INSERT INTO lesson3_employee (id, name, department, hiredate, notes, salary, manager) VALUES (3, 'Jill The Rich Employee', 1, '2004-05-03', '', '2000.00', 1);

CREATE SEQUENCE lesson3_employee_seq START WITH 4;
CREATE SEQUENCE lesson3_department_seq START WITH 3;

CREATE TABLE lesson4_department
(
  id SERIAL,
  name varchar NOT NULL,
  is_hiring int NOT NULL default '1',
  PRIMARY KEY  (id)
) ;


INSERT INTO lesson4_department (id, name, is_hiring) VALUES (1, 'Sales', 1);
INSERT INTO lesson4_department (id, name, is_hiring) VALUES (2, 'Support', 0);


CREATE TABLE lesson4_employee
(
  id SERIAL,
  name varchar NOT NULL,
  email varchar default NULL,
  department int default NULL,
  hiredate date default NULL,
  notes text,
  salary decimal default NULL,
  manager int default NULL,
  PRIMARY KEY  (id)
) ;


INSERT INTO lesson4_employee (id, name, email, department, hiredate, notes, salary, manager) VALUES (1, 'Jack The Manager', NULL, 1, '2004-05-03', '', '1000.00', NULL);
INSERT INTO lesson4_employee (id, name, email, department, hiredate, notes, salary, manager) VALUES (2, 'Joe The Employee', NULL, 1, '2004-05-03', '', '500.00', 1);
INSERT INTO lesson4_employee (id, name, email, department, hiredate, notes, salary, manager) VALUES (3, 'Jill The Rich Employee', '', 1, '2004-05-03', '', '2100.00', 1);

CREATE SEQUENCE lesson4_employee_seq START WITH 4;
CREATE SEQUENCE lesson4_department_seq START WITH 3;

CREATE TABLE lesson5_accessright
(
  node varchar NOT NULL,
  action varchar(25) NOT NULL,
  profile_id varchar(10) NOT NULL,
  PRIMARY KEY  (node,action,profile_id)
) ;


INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.department', 'add', '1');
INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.department', 'admin', '1');
INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.department', 'delete', '1');
INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.department', 'edit', '1');
INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.employee', 'add', '1');
INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.employee', 'admin', '1');
INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.employee', 'delete', '1');
INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.employee', 'edit', '1');
INSERT INTO lesson5_accessright (node, action, profile_id) VALUES ('lesson5.profile', 'admin', '1');


CREATE TABLE lesson5_department
(
  id SERIAL,
  name varchar NOT NULL,
  is_hiring int NOT NULL default '1',
  PRIMARY KEY  (id)
) ;


INSERT INTO lesson5_department (id, name, is_hiring) VALUES (1, 'Sales', 1);
INSERT INTO lesson5_department (id, name, is_hiring) VALUES (2, 'Support', 0);


CREATE TABLE lesson5_employee
(
  id SERIAL,
  login varchar(25) NOT NULL,
  name varchar NOT NULL,
  password varchar(255) default NULL,
  email varchar default NULL,
  department int default NULL,
  hiredate date default NULL,
  notes text,
  salary decimal default NULL,
  manager int default NULL,
  profile_id int default NULL,
  PRIMARY KEY  (id)
) ;


INSERT INTO lesson5_employee (id, login, name, password, email, department, hiredate, notes, salary, manager, profile_id) VALUES (1, 'jack', 'Jack The Manager', '098f6bcd4621d373cade4e832627b4f6', '', 1, '2004-05-03', '', '1000.00', NULL, 1);
INSERT INTO lesson5_employee (id, login, name, password, email, department, hiredate, notes, salary, manager, profile_id) VALUES (2, 'joe', 'Joe The Employee', NULL, NULL, 1, '2004-05-03', '', '500.00', 1, NULL);
INSERT INTO lesson5_employee (id, login, name, password, email, department, hiredate, notes, salary, manager, profile_id) VALUES (3, 'jill', 'Jill The Rich Employee', NULL, NULL, 1, '2004-05-03', '', '2000.00', 1, NULL);


CREATE TABLE lesson5_profile
(
  id SERIAL,
  name varchar NOT NULL,
  PRIMARY KEY (id)
) ;


INSERT INTO lesson5_profile (id, name) VALUES (1, 'Projectmanagers');

CREATE SEQUENCE lesson5_department_seq START WITH 3;
CREATE SEQUENCE lesson5_employee_seq START WITH 4;
CREATE SEQUENCE lesson5_profile_seq START WITH 2;

CREATE TABLE lesson6_employee1
(
  id SERIAL,
  name varchar NOT NULL,
  hiredate date default NULL,
  notes text,
  salary float8 default NULL,
  PRIMARY KEY (id)
) ;


INSERT INTO lesson6_employee1 (id, name, hiredate, notes, salary) VALUES (1, 'Jack', '2004-04-27', '', '1000.00');
INSERT INTO lesson6_employee1 (id, name, hiredate, notes, salary) VALUES (2, 'Bill', '2000-06-01', 'Test employee', '60.00');
INSERT INTO lesson6_employee1 (id, name, hiredate, notes, salary) VALUES (3, 'Simon', '2004-02-09', 'Simon the Sourceror', '500.00');

CREATE SEQUENCE lesson6_employee1_seq START WITH 4;

CREATE TABLE lesson6_employee2
(
  id SERIAL,
  name varchar NOT NULL,
  hiredate date default NULL,
  notes text,
  salary float8 default NULL,
  lesson6_department int NOT NULL,
  PRIMARY KEY (id)
) ;


INSERT INTO lesson6_employee2 (id, name, hiredate, notes, salary, lesson6_department) VALUES (1, 'Jack', '2004-04-27', '', '1000.00',1);
INSERT INTO lesson6_employee2 (id, name, hiredate, notes, salary, lesson6_department) VALUES (2, 'Bill', '2000-06-01', 'Test employee', '60.00',2);
INSERT INTO lesson6_employee2 (id, name, hiredate, notes, salary, lesson6_department) VALUES (3, 'Simon', '2004-02-09', 'Simon the Sourceror', '500.00',1);

CREATE SEQUENCE lesson6_employee2_seq START WITH 4;

CREATE TABLE lesson6_employee3
(
  id SERIAL,
  name varchar NOT NULL,
  hiredate date default NULL,
  notes text,
  salary float8 default NULL,
  PRIMARY KEY (id)
) ;


INSERT INTO lesson6_employee3 (id, name, hiredate, notes, salary) VALUES (1, 'Jack', '2004-04-27', '', '1000.00');
INSERT INTO lesson6_employee3 (id, name, hiredate, notes, salary) VALUES (2, 'Bill', '2000-06-01', 'Test employee', '60.00');
INSERT INTO lesson6_employee3 (id, name, hiredate, notes, salary) VALUES (3, 'Simon', '2004-02-09', 'Simon the Sourceror', '500.00');

CREATE SEQUENCE lesson6_employee3_seq START WITH 4;

CREATE TABLE lesson6_employee4
(
  id SERIAL,
  name varchar NOT NULL,
  hiredate date default NULL,
  notes text,
  salary float8 default NULL,
  lesson6_department int NOT NULL,
  PRIMARY KEY (id)
) ;


INSERT INTO lesson6_employee4 (id, name, hiredate, notes, salary, lesson6_department) VALUES (1, 'Jack', '2004-04-27', '', '1000.00',1);
INSERT INTO lesson6_employee4 (id, name, hiredate, notes, salary, lesson6_department) VALUES (2, 'Bill', '2000-06-01', 'Test employee', '60.00',2);
INSERT INTO lesson6_employee4 (id, name, hiredate, notes, salary, lesson6_department) VALUES (3, 'Simon', '2004-02-09', 'Simon the Sourceror', '500.00',1);

CREATE SEQUENCE lesson6_employee4_seq START WITH 4;

CREATE TABLE lesson6_department
(
  id SERIAL,
  name varchar NOT NULL,
  is_hiring int NOT NULL default '1',
  PRIMARY KEY (id)
) ;


INSERT INTO lesson6_department (id, name) VALUES (1, 'Sales department');
INSERT INTO lesson6_department (id, name) VALUES (2, 'Support');

CREATE SEQUENCE lesson6_department_seq START WITH 3;

CREATE TABLE lesson7_category
(
  cat_id SERIAL,
  title varchar NOT NULL,
  parent_cat_id int,
  PRIMARY KEY (cat_id)
) ;


INSERT INTO lesson7_category (cat_id, title, parent_cat_id) VALUES (1, 'Test', NULL);
INSERT INTO lesson7_category (cat_id, title, parent_cat_id) VALUES (2, 'Test', 1);
INSERT INTO lesson7_category (cat_id, title, parent_cat_id) VALUES (4, 'Test2', NULL);
INSERT INTO lesson7_category (cat_id, title, parent_cat_id)VALUES (5, 'Test2 item', 4);
INSERT INTO lesson7_category (cat_id, title, parent_cat_id)VALUES (6, 'Test2 item', 4);

CREATE SEQUENCE lesson7_category_seq START WITH 5;

CREATE TABLE lesson7_translation
(
  id SERIAL,
  name_nl varchar(200) default NULL,
  name_de varchar(200) default NULL,
  name_en varchar(200) default NULL,
  number_nl int default NULL,
  number_de int default NULL,
  number_en int default NULL,
  notes_nl text,
  notes_de text,
  notes_en text,
  htmlnotes_nl text,
  htmlnotes_de text,
  htmlnotes_en text,
  PRIMARY KEY (id)
) ;

CREATE SEQUENCE lesson7_translation_seq START WITH 1;


CREATE TABLE lesson7_translation_mr
(
  id SERIAL,
  name varchar(200),
  numbervalue int default NULL,
  notes text,
  htmlnotes text,
  lng varchar(10) NOT NULL default 'EN',
  PRIMARY KEY (id, lng)
) ;

CREATE SEQUENCE lesson7_translation_mr_seq START WITH 1;

CREATE TABLE lesson8_employee
(
  id SERIAL,
  name varchar NOT NULL,
  hiredate date default NULL,
  notes text,
  salary decimal default NULL,
  PRIMARY KEY (id)
) ;


INSERT INTO lesson8_employee (id, name, hiredate, notes, salary) VALUES (1, 'Jack', '2004-04-27', '', '1000.00');
INSERT INTO lesson8_employee (id, name, hiredate, notes, salary) VALUES (2, 'Bill', '2000-06-01', 'Test employee', '60.00');
INSERT INTO lesson8_employee (id, name, hiredate, notes, salary) VALUES (3, 'Simon', '2004-02-09', 'Simon the Sourceror', '500.00');

CREATE SEQUENCE lesson8_employee_seq START WITH 4;

CREATE TABLE lesson9_employee
(
  id SERIAL,
  name varchar NOT NULL,
  hiredate date,
  notes text,
  salary decimal,
  PRIMARY KEY  (id)
) ;


INSERT INTO lesson9_employee (id, name, hiredate, notes, salary) VALUES (1, 'Jack', '2004-04-27', '', '1000.00');
INSERT INTO lesson9_employee (id, name, hiredate, notes, salary) VALUES (2, 'Bill', '2000-06-01', 'Test employee', '60.00');
INSERT INTO lesson9_employee (id, name, hiredate, notes, salary) VALUES (3, 'Simon', '2004-02-09', 'Simon the Sourceror', '500.00');

CREATE SEQUENCE lesson9_employee_seq START WITH 4;

CREATE TABLE lesson9_project
(
  id SERIAL,
  name varchar NOT NULL,
  PRIMARY KEY  (id)
) ;


INSERT INTO lesson9_project (id, name) VALUES (1, 'Major Project');
INSERT INTO lesson9_project (id, name) VALUES (2, 'Minor Undertaking');
INSERT INTO lesson9_project (id, name) VALUES (3, 'Super Glue');

CREATE SEQUENCE lesson9_project_seq START WITH 4;

CREATE TABLE lesson9_employeeproject
(
  employee_id int NOT NULL,
  project_id int NOT NULL,
  PRIMARY KEY  (employee_id, project_id)
) ;


CREATE TABLE lesson10_department
(
  id SERIAL,
  name varchar NOT NULL,
  PRIMARY KEY  (id)
) ;


INSERT INTO lesson10_department (id, name) VALUES (1, 'Sales');
INSERT INTO lesson10_department (id, name) VALUES (2, 'Support');


CREATE TABLE lesson10_employee
(
  id SERIAL,
  name varchar NOT NULL,
  department int default NULL,
  hiredate date default NULL,
  notes text,
  salary decimal default NULL,
  manager int default NULL,
  PRIMARY KEY  (id)
) ;


INSERT INTO lesson10_employee (id, name, department, hiredate, notes, salary, manager) VALUES (1, 'Jack The Manager', 1, '2004-05-03', '', '1000.00', NULL);
INSERT INTO lesson10_employee (id, name, department, hiredate, notes, salary, manager) VALUES (2, 'Joe The Employee', 1, '2004-05-03', '', '500.00', 1);
INSERT INTO lesson10_employee (id, name, department, hiredate, notes, salary, manager) VALUES (3, 'Jill The Rich Employee', 1, '2004-05-03', '', '2000.00', 1);

CREATE SEQUENCE lesson10_employee_seq START WITH 4;
CREATE SEQUENCE lesson10_department_seq START WITH 3;
