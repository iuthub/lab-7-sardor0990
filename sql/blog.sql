CREATE TABLE Users (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    username varchar(250),
    email varchar(250),
    password varchar(250),
    fullname varchar(250),
    dob date);

CREATE TABLE Posts (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    title varchar(250),
    body text,
    publishDate date,
    userId INTEGER,
    FOREIGN KEY fkUser(userId),
    REFERENCES users(id));