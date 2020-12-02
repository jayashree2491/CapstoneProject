# CapstoneProject - ALUMNI INFORMATION SYSTEM - https://10.96.60.212
IT7993 Kennesaw State University - Capstone Project

Access the application in KSU Migrated Linux Server - It can be accessed only using the KSU connnected network systems

A web-based system which allows admin to view, search, delete and update KSU alumni information. The system allows KSU administration to keep track of Master of Science in Information Technology graduates and their career paths. The system provides various functionalities which includes: User friendly GUI interface, Import New Graduate's data into database, Search functionality, Backup and Restore and allows system admin to update alumni's information (jobs, education, email and such). The application was developed using php and MySQL workbench. 

Major Functionalities 
  Search
  Import
  Edit Alumni Details/Jobs/Education
  Backup/ Export
  Restore

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






