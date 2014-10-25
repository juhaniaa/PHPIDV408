Requirement Specification ProjectPHP
====================================
Juhani Aavanen - ja222qm

Terms:
------

Show - A showing of a movie in a specific cinematics room on a specific date and time.

Actors:
-------

1. Customer
	- Quick access to available movies
	- Wants to book tickets to specific show

2. Salesperson
	- See how many seats are still open for relevant shows
	- Wants to confirm that customer has booked a ticket

3. Administrator
	- Wants to add movies to list of available movies
	- Wants to add shows to available movies
	
4. Anonymous User
	- Wants to login
	- See list of available movies
	- See list of available shows
	
Use-cases:
----------

1. Customer
	- UC 1.1 Customer views list of all availble movies
	- UC 1.2 Customer views list of all shows for todays date
		- UC 1.2b Customer views list of all shows on a specific date
	- UC 1.3 Customer views specific movie information
	- UC 1.4 Cusomter books tickets to specific show
	- UC 1.5 Customer views his/her tickets to upcoming shows
	
2. Salesperson
	- UC 2.1 Salesperson views list of shows on a specific date
	- UC 2.2 Salesperson views list of bookings to specific show
	- UC 2.3 Salesperson confirms booking
	- UC 2.4 Salesperson searches for specific booking by name or id
	- UC 2.5 Salesperson views list of all available movies
	- UC 2.6 Salesperson sells ticket on specific show for customer
	
3. Administrator
	- UC 3.1 Administrator adds cinema
	- UC 3.2 Administrator adds movie
	- UC 3.3 Administrator adds show
	- UC 3.4 Administrator views list of all movies
	- UC 3.5 Administrator views list of all shows on a specific date
	- UC 3.6 Administrator views list of all cinemas
	
4. Anonymous User
	- UC 4.1 User views start page
	- UC 4.2 User logs in as Customer
	- UC 4.3 User logs in as Salesperson
	- UC 4.4 User logs in as Administrator


