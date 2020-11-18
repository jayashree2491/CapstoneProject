# CapstoneProject - ALUMNI INFORMATION SYSTEM
IT7993 Kennesaw State University - Capstone Project

A web-based system which allows admin to view, search, delete and update KSU alumni information. The system allows KSU administration to keep track of Master of Science in Information Technology graduates and their career paths. The system provides various functionalities which includes: User friendly GUI interface, Import New Graduate's data into database, Search functionality, Backup and Restore and allows system admin to update alumni's information (jobs, education, email and such). The application was developed using php and MySQL workbench. 

Database
The MYSQL workbench was used to structure the database with the tables and corresponding columns. The database includes three tables – Alumni Details, Jobs, Education. The Alumni Details table saves the alumni’s basic details like FirstName, LastName, LinkedIn, Gender, City, Country etc. The Jobs table saves the Job history of each Alumni. The Education table saves the education details of each Alumni. The main source table is Alumni Details where Jobs and Education tables are linked using AlumniID. The Jobs table contain columns that saves the Job title, Start date, End date etc. The Education table contain columns that saves the Education Level, Degree, School Name, Start year etc. The database can also be accessed and viewed in localhost/phpMyAdmin 

E-R Diagram
The screen shot below represents our ER diagram. Creation of a new ER diagram based on pre-existing ER diagram we were provided. The ERD was generated using erdplus.com. Several changes were made on the previous ERD such as adding new column to a table, creating new tables, removing and renaming of columns and such. ERD approved by our advisor.

https://github.com/jayashree2491/CapstoneProject/issues/1#issue-745383359


