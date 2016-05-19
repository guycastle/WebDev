DROP DATABASE IF EXISTS festival;

CREATE DATABASE festival;

USE festival;

CREATE TABLE users (id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, admin BOOL DEFAULT FALSE, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, tickets INT DEFAULT 0);

CREATE TABLE shows (
  id                 BIGINT        NOT NULL,
  artist             VARCHAR(255)  NOT NULL,
  description        VARCHAR(4096) NOT NULL,
  time               TIMESTAMP     NOT NULL,
  spotify_embed_code VARCHAR(255)
);

CREATE TABLE pictures (id BIGINT NOT NULL, show_id BIGINT NOT NULL);

CREATE TABLE news_items (id BIGINT NOT NULL, content VARCHAR(4096) NOT NULL, time TIMESTAMP NOT NULL);

CREATE TABLE comments (id BIGINT NOT NULL, content VARCHAR(4096) NOT NULL, time TIMESTAMP NOT NULL, user_id BIGINT NOT NULL, news_item_id BIGINT NOT NULL);

CREATE TABLE available_tickets (available_tickets INT DEFAULT 10000);

ALTER TABLE users ADD PRIMARY KEY (id);

ALTER TABLE shows ADD PRIMARY KEY (id);

ALTER TABLE pictures ADD PRIMARY KEY (id);

ALTER TABLE news_items ADD PRIMARY KEY (id);

ALTER TABLE comments ADD PRIMARY KEY (id);

ALTER TABLE users ADD CONSTRAINT UK_users_1 UNIQUE (email);

ALTER TABLE pictures ADD CONSTRAINT FK_pictures_1 FOREIGN KEY (show_id) REFERENCES shows (id) ON UPDATE CASCADE;

ALTER TABLE comments ADD CONSTRAINT FK_comments_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE;

ALTER TABLE comments ADD CONSTRAINT FK_comments_2 FOREIGN KEY (news_item_id) REFERENCES news_items (id) ON UPDATE CASCADE;

GRANT ALL ON festival.* TO 'owner'@'localhost'
IDENTIFIED BY 'owner';