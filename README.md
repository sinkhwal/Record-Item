# Record Item
This is PHP project with login module and item module. This project can be used as starting point to create any php project. It already have code for login,
forgot password, password creation, session management, login/logout, email for new user creation and forgot password, item- insert update delete, user roles (superadmin, admin, user), and role based access, password is made more
secure by hasing password with id as salt (so each user must have unique password saved in db).

### Getting up and running
* Unzip source code to a local folder. 
* import file inside db folder in sqllite.
* copy folder inside wamp64/www folder. 
* navigate to http://localhost/Event%20Management/Pages/User/login.php in any browser.
* default email and password for superadmin user is username: super@gmail.com password:superadmin (password is MD5 of password+id encrypted in database) 

### Workflow
*	superuser first create user with emailId, then email will be sent to user for password creation.   
*	user can follow the link in email and create password. And login to system. 
*	user can view and create event. user can edit and delete event if it was created by him.
*	if user role is admin, he can create new user.
*	option of change password.


