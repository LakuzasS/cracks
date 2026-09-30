CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(200) NOT NULL UNIQUE,
    pwd VARCHAR(200) NOT NULL,
    isadmin BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE cracks (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    content TEXT NOT NULL,
    owner INT NOT NULL,
    datesend INT NOT NULL
);

CREATE TABLE votes (
    crack INT NOT NULL,
    voter INT NOT NULL,
    val INT NOT NULL
);

INSERT INTO users (login, pwd, isadmin)
VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 1);