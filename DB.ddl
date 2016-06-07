DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS news_items;
DROP TABLE IF EXISTS pictures;
DROP TABLE IF EXISTS shows;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS tickets;
CREATE TABLE users (
  id       BIGINT       NOT NULL AUTO_INCREMENT,
  name     VARCHAR(255) NOT NULL,
  surname  VARCHAR(255) NOT NULL,
  admin    BOOL                  DEFAULT FALSE,
  email    VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);
CREATE TABLE shows (
  id                 BIGINT        NOT NULL AUTO_INCREMENT,
  artist             VARCHAR(255)  NOT NULL,
  description        TEXT NOT NULL,
  time               TIMESTAMP     NOT NULL,
  day                VARCHAR(16)   NOT NULL,
  spotify_uri VARCHAR(255) DEFAULT NULL,
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
  time    TIMESTAMP DEFAULT NOW() NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE comments (
  id           BIGINT        NOT NULL AUTO_INCREMENT,
  content      TEXT NOT NULL,
  time         TIMESTAMP DEFAULT NOW() NOT NULL,
  user_id      BIGINT        NOT NULL,
  news_item_id BIGINT        NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE tickets (
  day               VARCHAR(16) NOT NULL,
  available_tickets INT DEFAULT 10000,
  price             DECIMAL NOT NULL DEFAULT 75,
  PRIMARY KEY (day)
);

CREATE TABLE reservations (
  user_id           BIGINT NOT NULL,
  day               VARCHAR(16) NOT NULL,
  amount            INT NOT NULL DEFAULT 0,
  PRIMARY KEY (day, user_id)
);

ALTER TABLE users ADD CONSTRAINT UK_users_1 UNIQUE (email);

ALTER TABLE pictures ADD CONSTRAINT FK_pictures_1 FOREIGN KEY (show_id) REFERENCES shows (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE comments ADD CONSTRAINT FK_comments_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE comments ADD CONSTRAINT FK_comments_2 FOREIGN KEY (news_item_id) REFERENCES news_items (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE reservations ADD CONSTRAINT FK_reservations_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE;

ALTER TABLE reservations ADD CONSTRAINT FK_reservations_2 FOREIGN KEY (day) REFERENCES tickets (day) ON UPDATE CASCADE;
INSERT INTO users (name, surname, admin, email, password) VALUES ('admin', 'admin', 1, 'admin@indiegent.be', '$2y$10$jjsWQ65DHIwPbtPyHdAuBeH0FcSD4StXuTbRWEg7YTZbxwV.LMbgS');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('Eels', 'Eels is an American indie rock band, formed in California in 1995 by singer/songwriter and multi-instrumentalist Mark Oliver Everett, known by the stage name E. Band members have changed across the years, both in the studio and on stage, making Everett the only official member for most of the band''s work. Eels'' music is often filled with themes about family, death and lost love. Since 1996, Eels has released eleven studio albums, seven of which charted in the Billboard 200.', '2016-06-24 20:00:00', 'Vrijdag', 'spotify:artist:3zunDAtRDg7kflREzWAhxl');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('Edward Sharpe and the Magnetic Zeros', 'Edward Sharpe and the Magnetic Zeros is an American indie folk band formed in Los Angeles, California in 2007. The group is led by lead singer Alex Ebert. The band''s name is based on a story Ebert wrote about a messianic figure named Edward Sharpe. Drawing from roots rock, folk, gospel, and psychedelic music, the band''s image and sound evoke the hippie movement of the 1960s and 1970s. The group''s first show was played July 18, 2007 at The Troubadour in West Hollywood, California. Their first studio album, Up from Below, was released on July 7, 2009 on Community Records and featured the popular single "Home". The group released their second full-length album, Here, on May 29, 2012, and third album, Edward Sharpe and the Magnetic Zeros, on July 23, 2013. Their fourth studio album, PersonA, was released in April 2016.<br />
  <br />
  Since its founding, the band has undergone several iterations. Most notably, singer Jade Castrinos left the band in 2014. The band''s current members are Mark Noseworthy, Orpheo McCord, Josh Collazo, Christian Letts, Nico Aglietti, Seth Ford-Young, Mitchell Yoshida, Christopher Richard, Stewart Cole, and Alex Ebert. The band also operates Big Sun, a non-profit focused on funding and developing co-ops and land trusts in urban areas around the world. Their first large-scale project, "Avalon Village," is in Highland Park (within Detroit), Michigan.', '2016-06-24 23:00:00', 'Vrijdag', 'spotify:artist:7giUHu5pv6YTZgSkxxCcgh');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('Death Cab for Cutie', 'Death Cab for Cutie is an American alternative rock band, formed in Bellingham, Washington in 1997. The band comprises Ben Gibbard (vocals, guitar, piano), Nick Harmer (bass) and Jason McGerr (drums). In 2014, founding guitarist and producer Chris Walla announced that he would be departing from the band after recording their eighth studio album, Kintsugi.<br />
   <br />
   The band was originally a solo project by Ben Gibbard, when he released the demo album, You Can Play These Songs with Chords, to positive reception. This led to a record deal with Barsuk Records. Gibbard decided to expand the project into a complete band, releasing their debut album Something About Airplanes in 1998, and their second album, We Have the Facts and We''re Voting Yes, in 2000; both records were positively received in the indie community. Their third album, 2001''s The Photo Album, gave the band their first charting single, and the release of the group''s fourth album Transatlanticism, in 2003, gained the band mainstream critical and commercial success. After signing with Atlantic Records, Death Cab For Cutie released their fifth album and major-label debut Plans in 2005, which received platinum certification from the Recording Industry Association of America. The band released their sixth album Narrow Stairs in 2008, which served as a stylistic departure for the group. Their seventh album, 2011''s Codes and Keys, featured the band''s first number one single, "You Are a Tourist". Their eighth studio album Kintsugi, the last to feature Walla, was released on March 31, 2015.<br />
   <br />
   Death Cab for Cutie''s music has been labeled as indie rock, indie pop, and alternative rock. It is noted for its use of unconventional instrumentation, as well as Gibbard''s distinctive voice and unique lyrical style. Since their formation, the band has released eight full-length studio albums, four EPs, two live EPs, one live album, and one demo album.', '2016-06-25 01:00:00', 'Vrijdag', 'spotify:artist:0YrtvWJMgSdVrk3SfNjTbx');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('Arctic Monkeys', 'Arctic Monkeys are an English rock band formed in 2002 in High Green, a suburb of Sheffield. The band consists of Alex Turner (lead vocals, rhythm guitar, lead guitar), Matt Helders (drums, vocals), Jamie Cook (lead guitar, rhythm guitar, backing vocals) and Nick O''Malley (bass, backing vocals). Former band member Andy Nicholson (bass guitar, backing vocals) left the band in 2006 shortly after their debut album was released.<br />
   <br />
   They have released five studio albums: Whatever People Say I Am, That''s What I''m Not (2006), Favourite Worst Nightmare (2007), Humbug (2009), Suck It and See (2011) and AM (2013), as well as one live album, At the Apollo (2008). Their debut album is the fastest-selling album by a band in British chart history, and in 2013, Rolling Stone ranked it the 30th-greatest debut album of all time.<br />
   <br />
   The band has won seven Brit Awards—winning both Best British Group and Best British Album three times, and have been nominated for three Grammy Awards. They also won the Mercury Prize in 2006 for their debut album, in addition to receiving nominations in 2007 and 2013. The band have headlined at the Glastonbury Festival twice, in 2007 and again in 2013.<br />
   <br />
   Arctic Monkeys were heralded as one of the first bands to come to public attention via the Internet, with commentators suggesting they represented the possibility of a change in the way in which new bands are promoted and marketed.', '2016-06-25 16:00:00', 'Zaterdag', 'spotify:artist:7Ln80lUS6He07XvHI8qqHH');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('Arcade Fire', 'Arcade Fire are a Canadian indie rock band based in Montreal, Quebec consisting of husband and wife Win Butler and Régine Chassagne, along with Win''s younger brother Will Butler, Richard Reed Parry, Tim Kingsbury and Jeremy Gara. The band''s current touring line-up also includes former core member Sarah Neufeld, frequent collaborator Owen Pallett, two additional percussionists, Diol Edmond and Tiwill Duprate, and saxophonists Matt Bauder and Stuart Bogie.<br />
   <br />
   Founded in 2001 by friends and classmates Win Butler and Josh Deu, the band came to prominence in 2004 with the release of their critically acclaimed debut album Funeral. Their second studio album, Neon Bible, won them the 2008 Meteor Music Award for Best International Album and the 2008 Juno Award for Alternative Album of the Year. Their third studio album, The Suburbs, was released in 2010 to critical acclaim and commercial success. It received many accolades, including the 2011 Grammy for Album of the Year, the 2011 Juno Award for Album of the Year, and the 2011 Brit Award for Best International Album. In 2013, Arcade Fire released their fourth album, Reflektor, and scored the feature film Her, for which band members William Butler and Owen Pallett were nominated in the Best Original Score category at the 86th Academy Awards. All four of their studio albums have received nominations for the Best Alternative Music Album Grammy; the band''s work has also been named three times as a shortlist nominee for the Polaris Music Prize: in 2007 for Neon Bible, in 2011 for The Suburbs and in 2014 for Reflektor, winning the award for The Suburbs.<br />
   <br />
   The band plays guitar, drums, bass guitar, piano, violin, viola, cello, double bass, xylophone, glockenspiel, keyboard, synthesizer, French horn, accordion, harp, mandolin, and hurdy-gurdy, and takes most of these instruments on tour; the multi-instrumentalist band members switch duties throughout shows.', '2016-06-25 20:00:00', 'Zaterdag', 'spotify:artist:3kjuyTCjPG1WMFCiyc5IuB');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('The Strokes', 'The Strokes are an American rock band formed in New York City in 1998, consisting of Julian Casablancas (lead vocals), Nick Valensi (guitar, keyboard, backing vocals), Albert Hammond, Jr. (rhythm guitar, keyboard, backing vocals), Nikolai Fraiture (bass) and Fabrizio Moretti (drums, percussion).<br />
   <br />
    Met with widespread critical acclaim, the Strokes'' 2001 debut, Is This It, helped usher in the garage rock revival movement of the early-21st century—and ranks number eight on Rolling Stone''s 100 Best Debut Albums of All Time, number two on Rolling Stone''s 100 Best Albums of the 2000s, 199 on Rolling Stone''s 500 Greatest Albums of All Time and number four in the NME top 500 albums of all time.<br />
   <br />
    After its members embarked on a variety of side projects, the band regrouped for a fifth album, Comedown Machine, released on March 26, 2013. The Strokes have sold over 5 million albums to date.', '2016-06-26 00:30:00', 'Zaterdag', 'spotify:artist:0epOFNiUfyON9EYx7Tpr6V');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('Bon Iver', 'Bon Iver is an American indie folk band founded in 2007 by singer-songwriter Justin Vernon. Vernon released Bon Iver''s debut album, For Emma, Forever Ago independently in July 2007. The majority of that album was recorded while Vernon spent three months in a cabin in northwestern Wisconsin. Bon Iver won the 2012 Grammy Awards for Best New Artist and Best Alternative Music Album for their album Bon Iver, Bon Iver. The name Bon Iver is derived from the French phrase bon hiver, meaning "good winter", taken from a greeting on Northern Exposure.', '2016-06-26 16:00:00', 'Zondag', 'spotify:artist:4LEiUm1SRbFMgfqnQTwUbQ');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('Franz Ferdinand', 'Franz Ferdinand are a Scottish rock band, formed in 2002 and based in Glasgow. The band is composed of Alex Kapranos (lead vocals and guitar, keyboard), Nick McCarthy (rhythm guitar, keyboards and backing vocals), Bob Hardy (bass guitar), and Paul Thomson (drums, percussion and backing vocals). The band has been known for being one of the most popular post-punk revival bands. They have been nominated for several Grammy Awards and have received two Brit Awards—winning one for Best British Group, as well as one NME Award.<br />
   <br />
    The band began by releasing their debut extended play, Darts of Pleasure, in 2003, under Domino Records. The band gained recognition in the United Kingdom after the EP''s title track peaked at number 44 on UK Singles Chart. In January 2004, the band released the song "Take Me Out". The song went on to achieve global recognition, charting in several countries, and earned a nomination for Best Rock Performance by a Duo or Group with Vocal at the 47th Annual Grammy Awards. It has since been noted as the band''s signature song and has received critical acclaim from critics. The band subsequently released their eponymous debut studio album on 9 February 2004 to critical acclaim. The album won the 2004 Mercury Prize and earned a nomination for Best Alternative Album at the same Grammy award show. In the following year, the band released their second studio album, You Could Have It So Much Better, which was produced by Rich Costey. The album went on to earn critical acclaim from critics as well as a positive commercial performance, peaking within the top-ten in multiple countries. The album earned a nomination for Best Alternative Album and one of the singles released from the album, "Do You Want To", earned a nomination for Best Rock Performance by a Duo or Group with Vocal at the 48th Annual Grammy Awards.<br />
   <br />
    The band''s third studio album, Tonight: Franz Ferdinand, was announced in late 2008 and released in January 2009. The album was notable for featuring a change in the band''s musical style, as the band had shifted from a post-punk-focused sound, which was featured on their first two albums, to a more dance-oriented sound. The album gained a positive commercial performance as well as positive reviews, but not as much acclaim as their first two albums. A remix album of Tonight, titled Blood, was subsequently released in July 2009. Later that year, it was announced that the band had sold over three million albums worldwide. Four years later, the band released their fourth studio album, Right Thoughts, Right Words, Right Action. In 2015, it was announced that Franz Ferdinand and American rock band Sparks had formed the supergroup FFS. The two released the album FFS in June 2015.', '2016-06-26 20:00:00', 'Zondag', 'spotify:artist:0XNa1vTidXlvJ2gHSsRi4A');
INSERT INTO shows (artist, description, time, day, spotify_uri) VALUES ('The Decemberists', 'The Decemberists are an American indie folk rock band from Portland, Oregon. The band consists of Colin Meloy (lead vocals, guitar, principal songwriter), Chris Funk (guitar, multi-instrumentalist), Jenny Conlee (keyboards, piano, Hammond organ, accordion), Nate Query (bass), and John Moen (drums).<br />
   <br />
    The band''s debut EP, 5 Songs, was self-released in 2001. Their seventh full-length album What a Terrible World, What a Beautiful World was released on January 20, 2015, by Capitol Records, and is the band''s fourth record with the label.<br />
   <br />
    In addition to their lyrics, which often focus on historical incidents and/or folklore, The Decemberists are also well known for their eclectic live shows. Audience participation is often a part of each performance, typically during encores. The band stages whimsical reenactments of sea battles and other centuries-old events, typically of regional interest, or acts out songs with members of the crowd.<br />
   <br />
    In 2011, the track "Down By the Water" from the album The King Is Dead was nominated for Best Rock Song at the 54th Grammy Awards.', '2016-06-26 16:00:00', 'Zondag', 'spotify:artist:7ITd48RbLVpUfheE7B86o2');
INSERT INTO pictures (show_id, extension) VALUES (1, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (1, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (1, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (1, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (1, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (2, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (2, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (2, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (2, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (2, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (3, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (3, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (3, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (3, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (3, 'JPG');
INSERT INTO pictures (show_id, extension) VALUES (4, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (4, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (4, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (4, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (4, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (5, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (5, 'jpeg');
INSERT INTO pictures (show_id, extension) VALUES (5, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (5, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (5, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (6, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (6, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (6, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (6, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (6, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (7, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (7, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (7, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (7, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (7, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (8, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (8, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (8, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (8, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (8, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (9, 'JPG');
INSERT INTO pictures (show_id, extension) VALUES (9, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (9, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (9, 'jpg');
INSERT INTO pictures (show_id, extension) VALUES (9, 'jpg');
INSERT INTO tickets (day, available_tickets, price) VALUES ('Vrijdag', 505, 70);
INSERT INTO tickets (day, available_tickets, price) VALUES ('Zaterdag', 4000, 75);
INSERT INTO tickets (day, available_tickets, price) VALUES ('Zondag', 6500, 60);
INSERT INTO news_items (title, content, time) VALUES ('Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', '<br />
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas et lacinia justo, quis ullamcorper dui. Ut eget laoreet urna, ac bibendum nisl. Vestibulum enim nisi, tincidunt eget placerat quis, hendrerit quis magna. Praesent eget pulvinar libero, sit amet luctus nibh. Aenean tincidunt pharetra ex consectetur laoreet. Nunc fermentum urna id lectus varius, ac maximus ligula porta. Etiam molestie leo at justo consectetur, eu pellentesque neque pharetra. Integer ornare id quam sit amet luctus. Ut finibus viverra nisl. Nam et sem varius, bibendum leo nec, mollis arcu. Curabitur egestas turpis mi, tempus facilisis velit aliquam at. Nullam vehicula at dui eget cursus. Phasellus feugiat quam in dolor maximus, vel dictum purus tincidunt. Morbi interdum placerat nunc, vitae mollis tellus hendrerit in.<br />
<br />
Praesent porta, tellus ac pellentesque commodo, est sapien rutrum elit, sed viverra massa ipsum ac est. Suspendisse potenti. Nam libero leo, rutrum quis lorem vel, imperdiet pharetra nisi. Nunc consequat tincidunt erat vitae imperdiet. Ut id viverra justo, et porttitor urna. Sed blandit orci ac arcu luctus consequat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque facilisis aliquet sapien, malesuada ultricies nunc tristique vitae. Donec feugiat lacus sit amet sollicitudin maximus. Duis erat eros, malesuada nec pellentesque quis, efficitur eget dolor. Phasellus pharetra vulputate consequat. Ut a porta est, sit amet consequat magna. Praesent tincidunt ultrices arcu non tincidunt. Mauris venenatis ut erat ut commodo.<br />
<br />
Nulla sed massa fermentum, ultrices odio quis, finibus est. Vestibulum eget enim pharetra, tincidunt libero vitae, fringilla odio. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet porttitor nisl. Ut tempus aliquet mauris ac vehicula. Pellentesque ultrices ornare nunc, eu pharetra sem pharetra nec. Praesent lobortis molestie metus, sed imperdiet est commodo vitae. Proin sed rhoncus orci, ut volutpat mi. Sed justo nisl, auctor venenatis nibh sed, fringilla fringilla leo. Aenean ultrices, enim non pulvinar pharetra, tellus tellus tincidunt arcu, a fringilla enim urna sit amet libero. Suspendisse non tellus vel sapien vulputate convallis. Curabitur dignissim non urna at interdum. Morbi porttitor hendrerit nisi, quis ultrices augue bibendum in.<br />
<br />
Aenean sollicitudin, nisl eget blandit condimentum, enim arcu sagittis urna, eu sollicitudin nulla orci in tortor. Vestibulum et lorem quis risus efficitur egestas dapibus at urna. Nunc rutrum laoreet sem, ut cursus metus. Mauris sed tempus augue. Proin vitae blandit urna. Praesent scelerisque enim id augue lacinia facilisis. Etiam aliquam, urna eu bibendum aliquet, eros purus fermentum diam, eu mattis massa enim non sapien. Cras consectetur ligula felis, vel vulputate dolor tincidunt ultrices. Suspendisse nec dui ac nibh posuere aliquet sit amet nec erat. Nam sagittis dictum magna, eget finibus magna maximus vel. Curabitur quis justo et ante vestibulum volutpat a non massa. Praesent et odio venenatis, feugiat sem non, ultricies risus.', '2016-06-07 21:09:46');
INSERT INTO news_items (title, content, time) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec nisi pulvinar, facilisis nibh vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis justo nec varius ornare. Phasellus varius massa sit amet justo lobortis, in tempor magna faucibus. Aenean iaculis, ante at fringilla faucibus, tortor leo ultrices leo, nec pellentesque turpis lorem eget ligula. Morbi ut ultricies enim, at volutpat orci. Etiam erat leo, faucibus id lorem et, ultricies rutrum urna. Ut vel risus sit amet est porttitor lacinia nec et eros. Vestibulum a odio ut enim iaculis imperdiet. Ut sit amet nunc lacus. Nunc in urna sollicitudin, dignissim augue nec, scelerisque urna.<br />
<br />
Aenean eu viverra turpis. Fusce id ultrices augue, vel finibus nunc. Sed maximus felis in sapien vulputate, eu venenatis est malesuada. Aenean fringilla felis ipsum, vitae hendrerit est laoreet fermentum. Proin condimentum mattis quam. Sed et tempor risus, nec pharetra velit. Integer laoreet ex id orci convallis venenatis. Maecenas pretium nec diam at mattis. Praesent finibus porttitor elit sed semper. Ut quam felis, tincidunt vitae nibh at, ornare egestas est.', '2016-06-07 21:14:23');
INSERT INTO news_items (title, content, time) VALUES ('Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut dui elit. Pellentesque laoreet sapien sit amet tortor efficitur ullamcorper et vel urna. Fusce sit amet consectetur eros. Phasellus rutrum, nisl a luctus auctor, ex dui sollicitudin justo, sit amet aliquam justo nisl dapibus ex. Quisque faucibus porttitor ante a iaculis. In bibendum in quam nec fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis eu nisl sit amet nulla tincidunt dictum. Proin sit amet fringilla neque. Vivamus eget egestas justo. Donec euismod metus cursus sem fermentum, sed vestibulum tortor suscipit. Nunc convallis metus semper risus dapibus, non fermentum nulla molestie. Suspendisse imperdiet, elit quis efficitur auctor, neque quam fringilla eros, eget tristique metus dui nec est. Fusce lacus mi, accumsan eu molestie a, hendrerit a nisl.<br />
<br />
Donec venenatis, felis sit amet ultrices faucibus, turpis nisl elementum enim, eu aliquam lacus sapien vel ante. Maecenas non lectus lacinia est finibus fermentum id eget augue. Nullam eu tristique massa. Quisque convallis ante sit amet finibus sodales. Nam turpis mi, scelerisque vel vehicula eget, faucibus sed sem. Morbi et nulla sit amet leo blandit placerat at in nibh. Aliquam quis lectus eget lectus viverra malesuada. Aenean quam dolor, aliquet vitae magna in, ultricies dapibus orci. In tempor leo ac leo iaculis, eu placerat mauris congue. Fusce at placerat mauris, vel ultrices dolor. In pulvinar magna sit amet mi congue lacinia. Nunc vel massa felis.<br />
<br />
Aenean efficitur lobortis mi volutpat molestie. Aenean pulvinar nulla a tincidunt lacinia. Fusce tellus tortor, hendrerit a diam eget, condimentum dapibus nulla. Proin at elementum nisl. Phasellus ac diam commodo, molestie sapien vitae, vulputate arcu. Quisque vitae euismod lacus, ut venenatis arcu. Maecenas viverra pulvinar purus, in maximus diam fermentum ut. Duis nulla velit, hendrerit ac justo a, rutrum pharetra tortor. Nullam tristique vel nibh ac iaculis. Donec dui mauris, efficitur eget lobortis sit amet, rhoncus porttitor erat. In pharetra lacus in urna dapibus, a sollicitudin nisl faucibus. Etiam eleifend maximus est, vel pretium urna viverra et. Sed ac magna egestas, sodales quam quis, ullamcorper leo.', '2016-06-07 21:14:49');
INSERT INTO comments (content, time, user_id, news_item_id) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ante mauris, aliquam eu dui eu, cursus luctus libero. In et sem arcu. Proin rhoncus tortor imperdiet est vulputate commodo. Nunc et elementum quam, id egestas urna. In hac habitasse platea dictumst. Sed sem purus, efficitur sit amet laoreet ac, faucibus quis ligula. Aenean pharetra convallis molestie. Suspendisse ullamcorper tristique erat id euismod. Mauris eget varius diam. Nam eget viverra tellus, eget aliquet risus.', '2016-06-07 21:10:18', 1, 1);
INSERT INTO comments (content, time, user_id, news_item_id) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed sem tellus. Curabitur scelerisque congue.', '2016-06-07 21:10:43', 1, 1);
INSERT INTO comments (content, time, user_id, news_item_id) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit. In porta, risus ut porta pretium, erat nisi pharetra nibh, et faucibus dui est id.', '2016-06-07 21:15:16', 1, 3);
INSERT INTO comments (content, time, user_id, news_item_id) VALUES ('Lorem ipsum dolor sit amet.', '2016-06-07 21:15:38', 1, 3);