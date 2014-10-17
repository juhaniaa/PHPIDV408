Test Cases for UC 4 Anonymous User ProjectPHP ja222qm
=====================================================

TC 4.1.1 Navigate to start page
-------------------------------
1 remove all cookies
2 go to: http://aavanenprogramming.com/ProjectPHP/index.php

Output
	* Start-page is shown with main menu
	* No user is logged in
	* Form for login is shown

TC 4.1.2 Failed log in with no credentials
TC 4.1.3 Failed log in without username
TC 4.1.3 Failed log in without password
TC 4.1.4 Failed log in with wrong credentials

TC 4.2.1 Log in as Customer
---------------------------
1 TC 4.1.1 Navigate to start page
2 Input Username:
3 Input Password:
4 Press Log in

Output
	* Start-page is shown with main menu
	* Username is logged in

TC 4.3.1 Log in as Salesperson
------------------------------
1 TC 4.1.1 Navigate to start page
2 Input Username:
3 Input Password:
4 Press Log in

Output
	* Start-page is shown with main menu
	* Salesperson is logged in

TC 4.4.1 Log in as Administrator
--------------------------------
1 TC 4.1.1 Navigate to start page
2 Input Username:
3 Input Password:
4 Press Log in

Output
	* Start-page is shown with main menu
	* Admin is logged in