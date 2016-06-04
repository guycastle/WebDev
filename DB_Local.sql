#DB CREATION LOCAL
DROP DATABASE IF EXISTS festival;

CREATE DATABASE festival;

USE festival;

CREATE TABLE users (
  id       BIGINT       NOT NULL AUTO_INCREMENT,
  name     VARCHAR(255) NOT NULL,
  surname  VARCHAR(255) NOT NULL,
  admin    BOOL                  DEFAULT FALSE,
  email    VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  tickets  INT                   DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE TABLE shows (
  id                 BIGINT        NOT NULL AUTO_INCREMENT,
  artist             VARCHAR(255)  NOT NULL,
  description        TEXT NOT NULL,
  time               TIMESTAMP     NOT NULL,
  day                VARCHAR(16)   NOT NULL,
  spotify_embed_code VARCHAR(255),
  PRIMARY KEY (id)
);

CREATE TABLE pictures (
  id          BIGINT                   NOT NULL AUTO_INCREMENT,
  show_id     BIGINT                   NOT NULL,
  extension   VARCHAR(4) DEFAULT 'jpg' NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE news_items (
  id      BIGINT        NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  time    TIMESTAMP     NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE comments (
  id           BIGINT        NOT NULL AUTO_INCREMENT,
  content      TEXT NOT NULL,
  time         TIMESTAMP     NOT NULL,
  user_id      BIGINT        NOT NULL,
  news_item_id BIGINT        NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE available_tickets (
  day               INT NOT NULL,
  available_tickets INT DEFAULT 10000,
  PRIMARY KEY (day)
);

ALTER TABLE users ADD CONSTRAINT UK_users_1 UNIQUE (email);

ALTER TABLE pictures ADD CONSTRAINT FK_pictures_1 FOREIGN KEY (show_id) REFERENCES shows (id) ON UPDATE CASCADE;

ALTER TABLE comments ADD CONSTRAINT FK_comments_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE;

ALTER TABLE comments ADD CONSTRAINT FK_comments_2 FOREIGN KEY (news_item_id) REFERENCES news_items (id) ON UPDATE CASCADE;

GRANT ALL ON festival.* TO 'owner'@'localhost'
IDENTIFIED BY 'owner';