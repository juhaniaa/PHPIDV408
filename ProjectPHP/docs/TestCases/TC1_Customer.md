Test Cases for UC 1 Customer ProjectPHP ja222qm
===============================================

TC 1.1.1 Show list of all available movies
------------------------------------------
1 TC 4.2.1 Log in as Customer
2 Choose Movies in main menu

Output
	* List of movies is shown with main menu

TC 1.2.1 Show list of all shows for todays date
-----------------------------------------------
1 TC 4.2.1 Log in as Customer
2 Choose Shows in main menu

Output
	* Todays date is shown in date-input
	* List of shows is shown with title and time
	* Button to book tickets is shown for each show
		
TC 1.2b.1 List shows for a specific date with calendar
------------------------------------------------------
1 TC 4.2.1 Log in as Customer
2 Choose Shows in main menu
3 Click date-input field
4 Choose the day after today
5 Press Go to date

Output
	* Tomorrows date is shown in date-input
	* List of shows is shown with title and time
	* Button to book tickets is shown for each show
	
TC 1.2b.2 List shows for a specific date with date
--------------------------------------------------
1 TC 4.2.1 Log in as Customer
2 Choose Shows in main menu
3 Change the date in input field to next day with numbers
4 Press Go to date

Output
	See TC 1.2b.1 output
	
TC 1.2b.3 List shows for a specific date with invalid date-input
----------------------------------------------------------------
1 TC 4.2.1 Log in as Customer
2 Choose Shows in main menu
3 Input in date-field: 2016-54-79
4 Press Go to date

Output
	See TC 1.2.1 output
	
TC 1.3.1 Show specific movie information
----------------------------------------
1 TC 1.1.1 Show list of all available movies
2 Choose a movie in the movie list

Output
	* Movie information is shown with title, description and picture
	* A list of all upcoming shows with this movie is shown with button to book tickets for each show
	
TC 1.4.1 Book ticket to show by movie
-------------------------------------
1 TC 1.1.1 Show list of all available movies
2 Choose a movie in the movie list
3 Choose tickets on a show in list of shows
4 Input 1
5 Choose book ticket

Output
	* Sucess message is shown with information about booking
	
TC 1.4.2 Book ticket to show by shows list
------------------------------------------
1 TC 1.2.1 Show list of all shows for todays date
2 Choose tickets on a show in list of shows
3 Input 1
4 Choose book ticket

Output
	* Sucess message is shown with information about booking
	
TC 1.4.3 Book multiple tickets to show
--------------------------------------
1 Follow steps 1 and 2 in TC 1.4.2 Book ticket to show by shows list
2 Input 3
3 Choose book ticket

Output
	* Sucess message is shown with information about booking (3 tickets)
	
TC 1.4.4 Failed booking with invalid amount
-------------------------------------------
1 Follow steps 1 and 2 in TC 1.4.2 Book ticket to show by shows list
2 Input 900
3 Choose book ticket

Output
	* Error message is shown

TC 1.4.4 Failed booking with invalid number
-------------------------------------------
1 Follow steps 1 and 2 in TC 1.4.2 Book ticket to show by shows list
2 Input: ten
3 Choose book ticket

Output
	* Error message is shown