ProjectPHP
==========
Project in course 1DV408 "Webbutveckling med PHP" by Juhani Aavanen - ja222qm

Info:
-----

Requiremetns and test-cases can be found in the docs folder.

Installation:
-------------

Three easy steps:
	1. Create Tables and Views in database
	2. Change connection info in Settings.php
	3. Upload all files in "ProjectPHP"-catalog

Database tables:

"CinUsers"
uniqueId - int(11) AI
name - varchar(30) - latin1_general_cs
password - varchar(40)
role - varchar(4)

"CinTempUsers"
name - varchar(30)
timestamp - int(10)

"CinMovies"
uniqueKey - int(11) AI
title - varchar(255)
description - varchar(255)

"CinShows"
uniqueShow - int(11) AI
sDate - date
sTime - time
movieKeyFK - int(11)

"CinTickets"
uniqueTicket - int(11) AI
uniqueShowFK - int(11)
uniqueUserFK - int(11)
amount - int(11)

Database views:

"movie_shows"
SQL CREATE VIEW `movie_shows` AS select `s`.`movieKeyFK` AS `uniqueKey`,
`s`.`uniqueShow` AS `uniqueShow`,`s`.`sTime` AS `sTime`,`s`.`sDate` AS `sDate`,
`m`.`title` AS `title`,`m`.`description` AS `description` from 
(`CinMovies` `m` left join `CinShows` `s` on((`s`.`movieKeyFK` = `m`.`uniqueKey`)))


