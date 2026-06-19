Note: Samples used to be customized to the project your started: 
BIT3208: Advanced Web Design and Development
Week 6: Database Integration and CRUD Operations
Learning Objectives
By the end of this week, students should be able to:
1.	Define database integration in web applications.
2.	Explain the purpose of CRUD operations.
3.	Connect a web application to a database.
4.	Create, Read, Update, and Delete records using PHP and MySQL.
5.	Design user-friendly forms for data entry.
6.	Test and debug database-driven applications.

Introduction
Most modern websites are dynamic, meaning they store and retrieve information from databases. Examples include:
•	Student Management Systems
•	Hospital Management Systems
•	Online Shops
•	Banking Systems
•	Social Media Platforms
A database allows information to be stored permanently and accessed whenever needed.
This week focuses on integrating a website with a database and performing CRUD operations.

Key Definitions
Database
A structured collection of related data stored electronically.
Examples:
•	Student records
•	Employee information
•	Product inventories

Database Management System (DBMS)
Software used to create, manage, and manipulate databases.
Examples:
•	MySQL
•	PostgreSQL
•	MongoDB
•	SQL Server

CRUD Operations
CRUD stands for:
Operation	Meaning
Create	Add new data
Read	Retrieve data
Update	Modify existing data
Delete	Remove data
These four operations form the foundation of most web applications.

Database Integration
Database integration refers to connecting a website or web application to a database so that information can be stored and retrieved automatically.
Example
Student Registration System:
1.	Student fills registration form.
2.	Data is submitted to server.
3.	PHP processes data.
4.	MySQL stores data.
5.	Records can later be viewed, edited, or deleted.

Creating a Database
SQL Command
CREATE DATABASE studentdb;

Creating a Table
CREATE TABLE students(
id INT AUTO_INCREMENT PRIMARY KEY,
fullname VARCHAR(100),
email VARCHAR(100),
course VARCHAR(50)
);

Connecting PHP to MySQL
<?php

$conn = mysqli_connect(
"localhost",
"root",
"",
"studentdb"
);

if(!$conn){
    die("Connection Failed");
}

echo "Connected Successfully";

?>
Explanation
Component	Purpose
localhost	Database server
root	Username
""	Password
studentdb	Database name

CREATE Operation
Adding New Records
HTML Form
<form method="POST">
<input type="text" name="fullname" placeholder="Full Name">

<input type="email" name="email" placeholder="Email">

<input type="text" name="course" placeholder="Course">

<button type="submit">Save</button>
</form>
PHP Processing
<?php

if(isset($_POST['fullname'])){

$name=$_POST['fullname'];
$email=$_POST['email'];
$course=$_POST['course'];

$sql="INSERT INTO students(fullname,email,course)
VALUES('$name','$email','$course')";

mysqli_query($conn,$sql);

echo "Record Saved";
}

?>

READ Operation
Displaying Records
<?php

$result=mysqli_query($conn,
"SELECT * FROM students");

while($row=mysqli_fetch_assoc($result)){

echo $row['fullname']."<br>";
echo $row['email']."<br>";
echo $row['course']."<hr>";
}

?>

UPDATE Operation
Editing Existing Records
<?php

$sql="UPDATE students
SET course='Computer Science'
WHERE id=1";

mysqli_query($conn,$sql);

echo "Record Updated";

?>

DELETE Operation
Removing Records
<?php

$sql="DELETE FROM students
WHERE id=1";

mysqli_query($conn,$sql);

echo "Record Deleted";

?>

Importance of CRUD Operations
CRUD operations allow users to:
•	Register accounts
•	Edit profiles
•	View information
•	Remove unwanted records
•	Manage organizational data
Without CRUD functionality, most modern web systems would not work.

Best Practices
Input Validation
Always validate user input.
Example:
if(empty($_POST['fullname'])){
echo "Name Required";
}

Prevent SQL Injection
Use prepared statements.
$stmt = $conn->prepare(
"INSERT INTO students(fullname,email,course)
VALUES(?,?,?)"
);

$stmt->bind_param(
"sss",
$name,
$email,
$course
);

User-Friendly Feedback
Always notify users when:
•	Data is saved
•	Data is updated
•	Data is deleted
•	Errors occur

Real-World Applications
School Management System
CRUD Operations:
•	Add student
•	View students
•	Update student details
•	Delete student records

Online Shop
CRUD Operations:
•	Add products
•	Display products
•	Edit products
•	Remove products

Hospital System
CRUD Operations:
•	Register patients
•	View records
•	Update treatment details
•	Delete duplicate records

Class Demonstration
Demonstration 1: Creating a Database
Students create:
•	Database
•	Table
•	Sample records
using phpMyAdmin.

Demonstration 2: PHP Database Connection
Students connect PHP to MySQL and verify successful connection.

Demonstration 3: Student Registration Form
Students create a form and save records into the database.

Demonstration 4: Display Records
Students retrieve and display records from the database.

Demonstration 5: Update and Delete Records
Students modify and remove records from the database.

Class Activity 1
Build a Student Registration Form
Requirements:
•	Full Name
•	Email
•	Course
Store information in MySQL.
Expected Skills
•	Form creation
•	Database connection
•	Data insertion

Class Activity 2
Display Student Records
Requirements:
•	Retrieve all records
•	Display in a table
Expected Skills
•	SQL queries
•	Data retrieval
•	Table formatting

Class Activity 3
Edit and Delete Records
Requirements:
•	Update student course
•	Delete selected student
Expected Skills
•	Record management
•	CRUD operations

Practical Task 1
Student Management System
Develop a mini Student Management System that can:
1.	Add students
2.	View students
3.	Edit student information
4.	Delete students
Deliverables
•	Source Code
•	Screenshots
•	Database Export File

Practical Task 2
Library Book Management System
Create a system that stores:
•	Book ID
•	Book Title
•	Author
•	Category
Implement complete CRUD operations.

Practical Task 3 (Challenge Task)
Employee Records Management System
Create a complete system that allows:
•	Employee registration
•	Viewing records
•	Updating details
•	Deleting records
Bonus Features
•	Search functionality
•	User login
•	Responsive design
•	Form validation

GitHub Portfolio Task
Students should:
1.	Push all code to GitHub.
2.	Create a repository named:
BIT3208-Week6-CRUD
3.	Upload:
o	Source code
o	Database script
o	Screenshots
o	README documentation

Weekly Reflection Questions
1.	Why are databases important in web applications?
2.	What is the difference between static and dynamic websites?
3.	Explain CRUD operations with examples.
4.	How does PHP communicate with MySQL?
5.	Why should developers validate user input?
6.	What security risks can arise from poor database design?

CAT Preparation Challenge
Proceed with weekly documentation. 
