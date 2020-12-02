# CapstoneProject - ALUMNI INFORMATION SYSTEM - https://10.96.60.212
IT7993 Kennesaw State University - Capstone Project

Access the application in KSU Migrated Linux Server - It can be accessed only using the KSU connnected network systems

A web-based system which allows admin to view, search, delete and update KSU alumni information. The system allows KSU administration to keep track of Master of Science in Information Technology graduates and their career paths. The system provides various functionalities which includes: User friendly GUI interface, Import New Graduate's data into database, Search functionality, Backup and Restore and allows system admin to update alumni's information (jobs, education, email and such). The application was developed using php and MySQL workbench. 

Major Functionalities 
Home Page -- The AIS system includes simple yet user friendly User Interface. It was crucial that the system had consistent layout throughout the pages. 
Search -- The search functionality offers quick way in viewing specific alumni information. The First name, last name, graduation year are the search filters applied to retrieve the results. 
About Page -- This page includes the information about the application AIS and functionalities achieved in it. The team members and sponsor details are included. 
Import -- The AIS system has import feature providing admin the facility to import data to all the three database tables from the UI: AlumniDetails, Jobs and Education. In the application, admin clicking on Import in home page redirects to Import Page UI. The admin can select the table name for which he wants to load the data. On selecting the table name, the admin is provided with the option to add csv file. Also, the admin can download the file template for the selected table by clicking the link provided. The next ID to be filled in the template file is also shown in the UI.If the file added in UI matches all condition it then successfully loads the data in database and shows the success message and loaded Table data in UI
Edit Alumni Details/Jobs/Education -- The edit/update functionalities help us to edit and update the data. Through this function, we can upload the data directly to the database. In this project, we can edit the personal details of that alumni and, we can add and edit the job and education details in the database through user interface. When clicked Add Row, additional row will be added where we can update the job and education details. When clicked update button, it updates the data to the database. If update process is successful, it shows a message saying that jobs/education is updated at the top of the page. If the row is left empty and gets updated, it will display a error message “Error updating Alumni/Jobs/Education Details” 
Backup/ Export -- The purpose of the backup is to create a copy of data that can be recovered in the event of a primary data failure. It is the Export button at the top. It will automatically back up the latest version on the Database and export into a SQL downloadable file when clicked on.
Restore -- The purpose of restore functionality is to restore the database with the backup file provided. In case of database crash or issues, the admin can restore the database with data using this functionality. It will delete the current table data and restore the database with the backup file being chosen and submitted in the application 

Migration Process
The system was completely developed and tested all functionalities in Windows Virtual machine named AlumniProject 
For migration of AIS system to KSU Web server we had discussion with IT team and a separate Linux Server (10.96.60.212) with login credentials are provided
The Linux server can be accessed only within KSU network connected systems with which application has restricted access
FileZilla, a powerful free cross platform software with Client and Server was installed in AlumniProject VM
The Linux Server credentials are used to connect in FileZilla Server and copied all the required project files (php, css) from FileZilla Client (Windows machine). 
The AIS system database (.sql) file was loaded in the Maria DB
The default configuration file and necessary php and sql artifactories are installed, modified using command prompt by connecting to server
With more hours of effort, team work, multiple resource links and code alteration the AIS system was successfully migrated to Linux Server https://10.96.60.212/index.php

Tools & Software
Development
  VMware Horizon Client - KSU Virtual Machine(AlumniProject)
  XAMPP Control Panel
  Apache Server
  phpMyAdmin
  MySQL Workbench
  GitHub

Migration
  FileZilla
  Linux – 10.96.60.212
  Apache Server (httpd)
  Maria DB






