# Event Repository System
This is simple system to create event and keep it in central repository in mysql db. User from different organization can create event and keep record of their event in this system, these event can be viewed by all other users. 

### Workflow
*	superuser first create user with emailId, then email will be sent to user for password creation.   
*	user can follow the link in email and create password. And login to system. 
*	user can view and create event. user can edit and delete event if it was created by him.
*	if user role is admin, he can create new user.
*	option of change password.

### Getting up and running
* Unzip source code to a local folder. 
* import file inside db folder in sqllite.
* copy folder inside wamp64/www folder. 
* navigate to http://localhost/Event%20Management/Pages/User/login.php in any browser.
* default username and password for superadmin user is username: superadmin password:superadmin (you can check in database) 
* currently password is saved in plaintext. if you want to using MD5, remove comment in  line UserAction.php file in line 135.

### Can be used for
* Starting point for php project as it consists of user login, database CRUD operation, good files structure,master page concept, session and basic security. 
* Future possibilities: These events can be broadcasted to mobile devices through api call, or mobile app can show these events.

**Simple Coding!!!**
