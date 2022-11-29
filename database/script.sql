CREATE TABLE departments(
	id_department int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL
);

CREATE TABLE roles(
	id_role int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    role_name varchar(15) NOT NULL
);

CREATE TABLE users(
	identification varchar(15) PRIMARY KEY NOT NULL, 
    firstname varchar(20) NOT NULL,
    lastname varchar(20) NOT NULL, 
    username varchar(20) NOT NULL,
    password varchar(250) NOT NULL,
    phone_number varchar(15) NULL,
    email varchar(30) NULL,
    state char(1) NOT NULL
);

ALTER TABLE users ADD department_id int NOT NULL;
ALTER TABLE users ADD FOREIGN KEY(department_id) 
  REFERENCES departments(id_department);
  
ALTER TABLE users ADD role_id int NOT NULL;
ALTER TABLE users ADD FOREIGN KEY(role_id) 
  REFERENCES roles(id_role);
  
CREATE TABLE records(
	id_record int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    access_date timestamp NOT NULL,
    id varchar(15) NOT NULL
);

INSERT INTO `roles` (`id_role`, `role_name`) VALUES (NULL, 'root'), (NULL, 'admin_room_911'), (NULL, 'employed');
INSERT INTO `departments` (`id_department`, `name`) VALUES (NULL, 'All'), (NULL, 'System department'), (NULL, 'marketing'), (NULL, 'commercial');

INSERT INTO `users` (`identification`, `firstname`, `lastname`, `username`, `password`, `phone_number`, `email`, `state`, `department_id`, `role_id`) VALUES ('root', 'root', 'root', 'root', '$2y$10$gtQ3cDpCfGNAP4/9ma6yX.NJ7B.34BEhhHOQpdp.tYwLiBXUl8GSS', NULL, NULL, '1', '1', '1');