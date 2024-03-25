Connecting to MySQL database using PHP
This tutorial provides instructions for connecting to a MySQL database using PHP; it assumes you have 
already installed PHP on your computer. If you have not or run into any problems with the installation 
please contact post a question at piazza. He will be more than happy to help you out.
Here is a link that provides instruction on PHP installation: 
http://www.janetvalade.com/installation/xampp_install.html
However, we recommend using NetBeans or Eclipse for your development work, as the IDEs will
automatically configure and start the server for you.
PLEASE NOTE: YOU DO NOT NEED TO INSTALL ANY OTHER VERSION OF MySQL WHILE INSTALLING PHP 
COMPONENTS (uncheck the install MySQL box during xampp installation).
The MySQL server you installed when the course started is the server you should use for the project. 
More than one instance of MySQL will cause port conflict and you will end up with no stable working 
version.
Assuming that your PHP is set up and the MySQL process is running on the server, please follow the 
steps below:
1. Create a new PHP file that will contain the code to connect to the database.
2. You should establish a connection to the MySQL database. This is an extremely important step 
because if your script cannot connect to its database, your queries to the database will fail.
A good practice when using databases is to set the username, the password and the database 
name values at the beginning of the script code. If you need to change them later, it will be an 
easy task.
You should replace "your_username", "your_password" and "your_database" with the MySQL 
username, password and database that will be used by your script. At this point you may be 
wondering if it is a security risk to keep your password in the file. You don't need to worry 
because the PHP source code is processed by the server before being sent to the browser. So 
the visitor will not see the script's code in the page source.
3. Next you should connect your PHP script to the database. This can be done with the 
mysql_connect PHP function:
This line instructs PHP to connect to the MySQL database server at 'localhost' (localhost is the 
MySQL server which usually runs on the same physical server as your script).
4. After the connection is established you should select the database you wish to use. This should 
be a database that your username has access to. This can be completed through the following 
command:
This command instructs PHP to select the database stored in the variable $database (in our case 
it will select the database "your_database"). If the script cannot connect it will stop executing 
and will show the error message: Unable to select database. The 'or die' part is useful as it 
provides debugging functionality. However, it is not essential.
Below lists example login code, it should work on any OS as there is no platform dependent 
code for database connectivity in PHP.
<?php
// Inialize session
session_start();
// All the data entered by user stored in variables below
$user = $_REQUEST["name"];
$pass = $_REQUEST["pass"];
// connection variable initialization
$connection = mysql_connect("localhost", "Username", "Password")
 or die("Could not connect to the server");
// connecting to database
$db = mysql_select_db("DBNAME", $connection)
 or die("Could not select the database");
$forlogin = "select * from user";
$result = mysql_query($forlogin);
$flag = true;
while ($row = mysql_fetch_array($result)) {
 if ($user == $row['username'] && $pass == $row['password']) {
 $_SESSION['currentuser'] = $user;
 header('Location: /folder1/page-to-goto-if-login-successful.php');
 $flag = false;
 }
}
if ($flag == true)
// echo "Login Un-Successful!!";
header('Location: /folder1/page-to-goto-if-loginunsuccessful.php'?myerror=mismatch');
?>
Running the database_connectivity.php file
Copy paste the above code, modify it according to your requirements and save it. Please make 
sure that you save your work in a folder created inside htdocs. 
Path for Windows:
You will finc htdocs inside directory C://Program Files/xampp/htdocs
Path for MAC
You will finc htdocs inside directory /usr/htdocs.
These are the default paths unless you overrode them manually during your PHP installation. 
Run the file the way you typically run your PHP files from a browser. To run the PHP code from a 
development environment IDE, select the file by right-clicking on it and select run. The IDE will 
complete the tasks necessary to start the server.
