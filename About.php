

<?php 


?>
<html>
<script type="text/javascript" src='index.js'></script>
<head>
<!--<h1> About </h1>-->
<style>

  
#header {
	height: auto;
	padding: 12px 0px;
	padding: 0.75rem 0rem;
	padding-top: 15.2px;
	padding-top: 0.95rem;
	background: black;
	width: 100%;
	position: relative;
}
ul {
	list-style-type: none;
	margin: 0;
	padding: 0;
	overflow: hidden;
	background-color: #febc11;
	
}

li {
float: left;
}

li a {
	display: block;
	color: black;
	text-align: center;
	padding: 14px 70px;
	text-decoration: none;
	
}

li a:hover:not(.active) {
	background-color: gold;

}

.active {
	background-color: gold;
}

h1 {
	font-size: 4rem;
	width: 99%;
	position: absolute;
	background: rgba(0, 0, 0, 0.5);
	color: white;
	margin: 0;
	bottom: 30%;
	margin-block-start: 0.67em;
	margin-block-end: 0.67em;
	margin-inline-start: 0px;
	margin-inline-end: 0px;
	text-align: center;
	font-family: 'Roboto Condensed', sans-serif;
	font-weight: 300;
}



.content {
	position: absolute;
	left: 50%;
	top: 100%;
	transform: translate(-50%, -50%);
	padding: 10px;
}

.names {
	position: absolute;
	left: 50%;
	top: 115%;
	transform: translate(-50%, -50%);
	text-align:center;

	font-family: 'Nunito', Arial, Helvetica, sans-serif;

    font-weight: 300;

    font-size: 18px;
}

h2 {
	text-align: center;
	font-family: 'Nunito', Arial, Helvetica, sans-serif;

    font-weight: 300;

    font-size: 19px;

	
}

p {
	font-family: 'Nunito', Arial, Helvetica, sans-serif;

    font-weight: 300;

    font-size: 18px;

  
}

  
</style>
</head>
<body>


<!---header--->

 <div id="header" role="logo"><a href ="https://ccse.kennesaw.edu/it/programs/msit.php">
	<img src="/img/logo.png" alt width="20%"></a>
	
</div>

	
<!---- Menu -----> 

<ul>
<li><a href="index.php">Home</a></li>
<li><a class="active" href="About.php">About</a></li>
<li><a href="DisplayData.php">Import</a></li>
<li><a href="dbbackup.php">Export</a></li>
<li><a href="restore.php">Restore</a></li>
</ul>
 
 <!----- picturebanner --->

<div id="picbanner" class="static">
<h1>About</h1>
<img src="/img/banner1.jpg" alt width=100% height=55%>
</div>

<!---- content---->

	<div class ="content">

       <h2>College of Computing and Software Engineering <br>
	     Department of Information Technology<br>
		 IT 7993 IT Capstone
		 <br>Fall 2020 </h2>
     <p> A web-based system which allows program coordinator to view, 
	 search, delete and update KSU alumni information. The system allows KSU administration to keep track of Master 
	 of Science in Information Technology graduates and their career paths. The project is sponsored by Professor, MSIT Coordinator & Asst. Dept. Chair Dr Lei Li for IT Capstone 7933 
	 Fall Semester 2020. The system provides various functionalities which includes:User friendly GUI interface,Import New Graduate's data into database, Search functionality, Backup and Restore 
	 and Allows system admin to update alumni's information (jobs, education, email and such).
	 Graduate students participant on this projects are: </p>
	 
	<div class ="names"> 
	<a href="https://www.linkedin.com/in/jayashree-pakkirisamy/">Jayashree Pakkirisamy</a></br>
<a href="https://www.linkedin.com/in/sangita-rai/">Sangita Rai</a></br>
<a href="https://www.linkedin.com/in/winston-kone/">Winston Kone</a></br>
<a href="https://www.linkedin.com/in/kalyani-vundavilli-a49360137/">Vara Kalyani Vundavalli</a></br></br>
	 </div>
</div>
<br/>
</body>
</html>

