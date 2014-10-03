Fick du igång din tilldelade källkod lokalt?

- Ja

Följde det med någon sorts instruktioner?

- Ja, databas namn med fält

Gick den publika applikationen du fick tilldelad igenom testfallen?

- Ja

Vad gjorde att den gick igenom testfallen?

- Applikationen uppfyllde alla testfall

Vad gjorde att den inte gick igenom testfallen?

- Ingenting

Vad var tydligt respektive otydligt i källkoden? Tänk på att det alltid går att hitta något åt båda hållen.

- Tydligt:
	* Funktionsnamn
	* Kommentarer

- Otydligt:
	* Flödet i controller
	
Fanns det ett genomgående “tänk” i källkoden?

- Ja, tydlig mvc struktur, dock var controllern endast en lång if else

Fanns det fördelar med detta tänk? Vilka?

- Det var lättare att hitta i vyn och modellen då deras respektive ansvar var bra uppdelade med 
tex vyn som genererar output och modellen som validerar och sköter kopplingen med databasen

Fanns det nackdelar med detta tänk? Vilka?

- Svårt att följa med i controllern och veta vad som sker när

Fanns det något du upplevde som “fulhack”i källkoden du fick tilldelad?

- Lagrandet av lösenord i klartext i databasen
- Olika funktioner för varje typ av meddelande istället för lagring i cookie


/* SEMINARIE Uppgifter */

- 10 saker gör kod lätt att förstå
	* Kommentarer
	* Indentering
	* Tydlig namngivning
	* Tydligt flöde
	* Inte för stora/långa funktioner
	* Inte så långa if/else satser
	* Bra struktur med tydlig indelning för vad som ansvarar för vad tex mvc
	* 
	
- 10 saker som gör kod svår att förstå
	* Redirects fram o tillbaka på många ställen
	* Inga kommentarer
	* Otydliga namngivningar
	* All kod på samma rad
	* Dålig indentering
	* Inga måsvingar!
	
- Exempel på fulhack
	* returnerar tex true utan att göra någon check
	* lösenord i klartext
	* 
	
- PHP gör svårt att undvika fulhack? Sätt att komma runt det?
	* 
	
Var ska måsvingen sitta? Samma rad, under eller inte alls?
	* samma rad med mellanrum!!



