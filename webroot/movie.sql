
DROP TABLE IF EXISTS Movie;
CREATE TABLE Movie (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
title VARCHAR(100) NOT NULL,
director VARCHAR(100),
LENGTH INT DEFAULT NULL,
YEAR INT NOT NULL DEFAULT 1900,
plot TEXT,
image VARCHAR(100) DEFAULT NULL,
subtitle CHAR(3) DEFAULT NULL,
speech CHAR(3) DEFAULT NULL,
qualtity CHAR(5) DEFAULT NULL,
format CHAR(5) DEFAULT NULL
) ENGINE INNODB CHARACTER SET utf8;


INSERT INTO Movie (title, director, LENGTH, YEAR, plot, image) VALUES
('Catch me if you can', 'Steven Spielberg', 135, 2002, 'Catch me if you can is inspired of a true story about a briliant young deceiver and an FBI-agent who is right behind him.', 'img/movie/catchme.jpg'),
('Snatch', 'Guy Ritchie', 99, 2000, 'Diomond thives dressed as rabbis and a unscrupulous boxing promotor who is also a pig farmer who feeds his pigs with corpses. Add Brad Pitt who plays a crazy boxer who knocks everyone out and you get this insane movie cocktail.', 'img/movie/snatch.jpg'),
('Notting Hill', 'Roger Michell', 119, 1999, 'In Notting Hill a district in London one of the worlds most famous actresses enters in William Thackers book shop.', 'img/movie/nottinghill.jpg'),
('The Interpreter', 'Sydney Pollack', 124, 2005, 'FN interpreter Silvia Broome overhears plans to murder an african head of state, Secrete Service starts to investigate it. The tough Tobin Keller suspecs that Silvia isnt telling them the whole story.', 'img/movie/tolken.jpg'),
('Enemy of the state', 'Tony Scott', 127, 1998, 'Rebert dean is a young successfull lawyer who by misstake got a important piece of evidence on a brutal murder of a politician on his hands.', 'img/movie/enemy.jpg'),
('Lost in Translation', 'Sofia Coppola', 99, 2000, 'Bob Harris is a american moviestar who is in Tokyo to do a whiskey comersial. At his hotel he meets Charlotte, a young american philosophy student. Gradually they become friends and they are equally lost in this strange enviroment.', 'img/movie/translation.jpg'),
('The Terminal', 'Steven Spielberg', 124, 2004, 'Viktor Navorski arrives at JFK airport for the first time and becomes a victim of a burocratic problem which results in that he cant enter into the US and he cant return home.', 'img/movie/terminal.jpg'),
('Goofy Movie', 'Walt Disney', 74, 1995, 'Goofy decides to take his teenage son Max and go on a fishing trip over the summer. The problem is that Max dosent feel so strongly about a father/son vacation as Goofy dose.', 'img/movie/goofy.jpg')
;

ALTER TABLE Movie ADD genre VARCHAR(100) DEFAULT NULL;

ALTER TABLE Movie MODIFY COLUMN image VARCHAR(100) DEFAULT 'img/movie/default.jpg';

UPDATE Movie SET genre='Animation Adventure Comedy' WHERE id=8;
UPDATE Movie SET genre='Comedy Drama' WHERE id=7;
UPDATE Movie SET genre='Drama' WHERE id=6;
UPDATE Movie SET genre='Crime Action Thriller' WHERE id=5;
UPDATE Movie SET genre='Mystery Thriller' WHERE id=4;
UPDATE Movie SET genre='Comedy Drama Romance' WHERE id=3;
UPDATE Movie SET genre='Crime Thriller' WHERE id=2;
UPDATE Movie SET genre='Biograpfy Crime Drama' WHERE id=1;

ALTER TABLE Movie ADD imdb VARCHAR(100) DEFAULT NULL;
ALTER TABLE Movie ADD trailer VARCHAR(100) DEFAULT NULL;

UPDATE Movie SET imdb='http://www.imdb.com/title/tt0120660/?ref_=fn_al_tt_1' WHERE id=5;
UPDATE Movie SET imdb='http://www.imdb.com/title/tt0125439/?ref_=fn_al_tt_1' WHERE id=3;
UPDATE Movie SET imdb='http://www.imdb.com/title/tt0373926/?ref_=fn_al_tt_1' WHERE id=4;
UPDATE Movie SET imdb='http://www.imdb.com/title/tt0335266/?ref_=fn_al_tt_1' WHERE id=6;
UPDATE Movie SET imdb='http://www.imdb.com/title/tt0362227/?ref_=fn_al_tt_1' WHERE id=7;
UPDATE Movie SET imdb='http://www.imdb.com/title/tt0113198/?ref_=fn_al_tt_1' WHERE id=8;
UPDATE Movie SET imdb='http://www.imdb.com/title/tt0264464/?ref_=fn_al_tt_1' WHERE id=1;
UPDATE Movie SET imdb='http://www.imdb.com/title/tt0208092/?ref_=fn_al_tt_1' WHERE id=2;

UPDATE Movie SET trailer='http://www.youtube.com/watch?v=SosRcIMCr5g' WHERE id=1;
UPDATE Movie SET trailer='http://www.youtube.com/watch?v=lUloT3Dh3-E' WHERE id=2;
UPDATE Movie SET trailer='http://www.youtube.com/watch?v=4RI0QvaGoiI' WHERE id=3;
UPDATE Movie SET trailer='http://www.youtube.com/watch?v=uCuqGhfr5Ak' WHERE id=4;
UPDATE Movie SET trailer='http://www.youtube.com/watch?v=AoNT6u3mQew' WHERE id=5;
UPDATE Movie SET trailer='http://www.youtube.com/watch?v=W6iVPCRflQM' WHERE id=6;
UPDATE Movie SET trailer='http://www.youtube.com/watch?v=rkrNjGewyIk' WHERE id=7;
UPDATE Movie SET trailer='http://www.youtube.com/watch?v=I9Tkp-JBIwc' WHERE id=8;


SELECT * FROM Movie;

DROP TABLE IF EXISTS Genre;
CREATE TABLE Genre
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name CHAR(20) NOT NULL -- crime, svenskt, college, drama, etc
) ENGINE INNODB CHARACTER SET utf8;
 
INSERT INTO Genre (name) VALUES 
  (' Comedy'), (' Romance'), 
  (' Crime'), (' Drama'), (' Thriller'), 
  (' Animation'), (' Adventure'), (' Family'), (' Action'), (' Horror')
; 
 
DROP TABLE IF EXISTS Movie2Genre;
CREATE TABLE Movie2Genre
(
  idMovie INT NOT NULL,
  idGenre INT NOT NULL,
 
  FOREIGN KEY (idMovie) REFERENCES Movie (id),
  FOREIGN KEY (idGenre) REFERENCES Genre (id),
 
  PRIMARY KEY (idMovie, idGenre)
) ENGINE INNODB;
 
 
INSERT INTO Movie2Genre (idMovie, idGenre) VALUES
  (1, 3),
  (1, 4),
  (2, 3),
  (2, 5),
  (3, 4),
  (3, 1),
  (3, 2), 
  (4, 5), 
  (4, 9), 
  (5, 9),
  (5, 5),
  (5, 3),
  (6, 4),
  (7, 4),
  (7, 1),
  (8, 1),
  (8, 7),
  (8, 8),
  (8, 6)
;
 
DROP VIEW IF EXISTS VMovie;
 
CREATE VIEW VMovie
AS
SELECT 
  M.*,
  GROUP_CONCAT(G.name) AS genre
FROM Movie AS M
  LEFT OUTER JOIN Movie2Genre AS M2G
    ON M.id = M2G.idMovie
  LEFT OUTER JOIN Genre AS G
    ON M2G.idGenre = G.id
GROUP BY M.id
;

SELECT * FROM movie;

INSERT INTO Movie (title, director, LENGTH, YEAR, plot, image, imdb, trailer) VALUES
('The Grinch', 'Dr. Seuss', 104, 2000, 'All the Whos love Christmas, yet just outside of their beloved Whoville lives the Grinch. The Grinch is a nasty creature that hates Christmas, and plots to steal it away from the Whos which he equally abhors. Yet a small child, Cindy Lou Who, decides to try befriend the Grinch.', 'img/movie/grinch.jpg', 'http://www.imdb.com/title/tt0170016/', 'http://www.youtube.com/watch?v=Pl12cnQxAaU'),
('Treasure planet', 'Ron Clements & John Musker', 95, 2002, 'A futuristic twist on Robert Louis Stevensons Treasure Island, Treasure Planet follows restless teen Jim Hawkins on a fantastic journey across the universe as cabin boy aboard a majestic space galleon. Befriended by the ships charismatic cyborg cook, John Silver, Jim blossoms under his guidance and shows the makings of a fine shipmate as he and the alien crew battle a supernova, a black hole, and a ferocious space storm. But even greater dangers lie ahead when Jim discovers that his trusted friend Silver is actually a scheming pirate with mutiny on his mind.', 'img/movie/treasure.jpg', 'http://www.imdb.com/title/tt0133240/?ref_=nv_sr_5', 'http://www.youtube.com/watch?v=swIfJRpOyPs'),
('The Dark Knight', 'Christopher Nolan', 152, 2008, 'With the help of Lieutenant Jim Gordon and District Attorney Harvey Dent, Batman sets out to dismantle the remaining criminal organizations that plague the city streets. The partnership proves to be effective, but they soon find themselves prey to a reign of chaos unleashed by a rising criminal mastermind known to the terrified citizens of Gotham as The Joker.', 'img/movie/batman.jpg', 'http://www.imdb.com/title/tt0468569/?ref_=nv_sr_2', 'http://www.youtube.com/watch?v=yQ5U8suTUw0'),
('We bought a zoo', 'Cameron Crowe', 124, 2011, 'In a bid to start his life over, he purchases a large house that has a zoo. This is welcome news for his daughter, but his son is not happy about it. The zoo is need of renovation and Benjamin sets about the work with the head keeper, Kelly, and the rest of the zoo staff. But, the zoo soon runs into financial trouble. The staff must get the zoo back to its former glory, pass a zoo inspection, and get it back open to the public.', 'img/movie/zoo.jpg', 'http://www.imdb.com/title/tt1389137/?ref_=nv_sr_1', 'http://www.youtube.com/watch?v=ZU2wU4f3kfc'),
('The Intouchables', 'Olivier Nakache & Eric Toledano', 112, 2011, 'In Paris, the aristocratic and intellectual Philippe is a quadriplegic millionaire who is interviewing candidates for the position of his carer, with his red-haired secretary Magalie. Out of the blue, the rude African Driss cuts the line of candidates and brings a document from the Social Security and asks Phillipe to sign it to prove that he is seeking a job position so he can receive his unemployment benefit.', 'img/movie/intouchables.jpg', 'http://www.imdb.com/title/tt1675434/?ref_=nv_sr_2', 'http://www.youtube.com/watch?v=dvdJ--DV0Uo'),
('Silver Linings Playbook', 'David O. Russell', 122, 2012, 'After a stint in a mental institution, former teacher Pat Solitano moves back in with his parents and tries to reconcile with his ex-wife. Things get more challenging when Pat meets Tiffany, a mysterious girl with problems of her own.', 'img/movie/silver.jpg', 'http://www.imdb.com/title/tt1045658/?ref_=nv_sr_1', 'http://www.youtube.com/watch?v=Lj5_FhLaaQQ'),
('Thor', 'Kenneth Branagh, Joss Whedon', 115, 2011, 'The warrior Thor is cast out of the fantastic realm of Asgard by his father Odin for his arrogance and sent to Earth to live among humans. Falling in love with scientist Jane Foster teaches Thor much-needed lessons, and his new-found strength comes into play as a villain from his homeland sends dark forces toward Earth.', 'img/movie/thor.jpg', 'http://www.imdb.com/title/tt0800369/?ref_=nv_sr_3', 'http://www.youtube.com/watch?v=JOddp-nlNvQ'),
('Pirates of the Caribbean - The curse of the Black Pearl', 'Gore Verbinski', 143, 2003, 'This swash-buckling tale follows the quest of Captain Jack Sparrow, a savvy pirate, and Will Turner, a resourceful blacksmith, as they search for Elizabeth Swann. Elizabeth, the daughter of the governor and the love of Wills life, has been kidnapped by the feared Captain Barbossa. Little do they know, but the fierce and clever Barbossa has been cursed.', 'img/movie/pirates.jpg', 'http://www.imdb.com/title/tt0325980/?ref_=nv_sr_2', 'http://www.youtube.com/watch?v=ZFCno8e-KuI')
;

INSERT INTO Movie2Genre (idMovie, idGenre) VALUES
  (11, 8),
  (11, 1),
  (11, 4),
  (12, 8),
  (12, 7),
  (12, 6),
  (13, 9), 
  (13, 3), 
  (14, 4), 
  (14, 8),
  (15, 4),
  (15, 1),
  (16, 1),
  (16, 4),
  (16, 2),
  (17, 9),
  (17, 7),
  (18, 9),
  (18, 7)
;

Select * FROM Movie;

ALTER TABLE Movie ADD price INT DEFAULT 35;

UPDATE Movie SET price=29 WHERE id=1;
UPDATE Movie SET price=35 WHERE id=2;
UPDATE Movie SET price=42 WHERE id=3;
UPDATE Movie SET price=29 WHERE id=4;
UPDATE Movie SET price=36 WHERE id=5;
UPDATE Movie SET price=20 WHERE id=6;
UPDATE Movie SET price=30 WHERE id=7;
UPDATE Movie SET price=36 WHERE id=8;
UPDATE Movie SET price=25 WHERE id=11;
UPDATE Movie SET price=32 WHERE id=12;
UPDATE Movie SET price=40 WHERE id=13;
UPDATE Movie SET price=37 WHERE id=14;
UPDATE Movie SET price=35 WHERE id=15;
UPDATE Movie SET price=35 WHERE id=16;
UPDATE Movie SET price=26 WHERE id=17;
UPDATE Movie SET price=25 WHERE id=18;

DELETE FROM Movie WHERE id=19;

SELECT * FROM USER;

ALTER TABLE Movie DROP image;

ALTER TABLE Movie ADD image CHAR(80);

UPDATE Movie SET image='img/movie/catchme.jpg' WHERE id=1;
UPDATE Movie SET image='img/movie/snatch.jpg' WHERE id=2;
UPDATE Movie SET image='img/movie/nottinghill.jpg' WHERE id=3;
UPDATE Movie SET image='img/movie/tolken.jpg' WHERE id=4;
UPDATE Movie SET image='img/movie/enemy.jpg' WHERE id=5;
UPDATE Movie SET image='img/movie/translation.jpg' WHERE id=6;
UPDATE Movie SET image='img/movie/terminal.jpg' WHERE id=7;
UPDATE Movie SET image='img/movie/goofy.jpg' WHERE id=8;
UPDATE Movie SET image='img/movie/grinch.jpg' WHERE id=11;
UPDATE Movie SET image='img/movie/treasure.jpg' WHERE id=12;
UPDATE Movie SET image='img/movie/batman.jpg' WHERE id=13;
UPDATE Movie SET image='img/movie/zoo.jpg' WHERE id=14;
UPDATE Movie SET image='img/movie/intouchables.jpg' WHERE id=15;
UPDATE Movie SET image='img/movie/silver.jpg' WHERE id=16;
UPDATE Movie SET image='img/movie/thor.jpg' WHERE id=17;
UPDATE Movie SET image='img/movie/pirates.jpg' WHERE id=18;

SELECT DISTINCT G.name FROM Genre AS G INNER JOIN Movie2Genre AS M2G ON G.id = M2G.idGenre WHERE M2G.idMovie=4;

