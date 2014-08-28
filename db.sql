CREATE TABLE users.users (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(50) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 2054
AVG_ROW_LENGTH = 125
CHARACTER SET utf8
COLLATE utf8_general_ci;