<?php
include('index.css');
//Step1
$serverName = 'localhost';
$username = 'root';
//$password = 'Kennesaw123!';
$database = 'alumnidatabase';
$conn = mysqli_connect($serverName, $username, /*$password*/);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Variables
$alumniSearching = true;
$alumnSelected = false;
$contactEditSelected = false;
$jobAddSelected = false;
$eduAddSelected = false;
$alumniID = '';
$field = 'FirstName';
$sort = 'ASC';
$firstFilter = '';
$lastFilter = '';
$yearFilter = '';
$contactInfo = [];

//Functions

if (isset($_GET['alumniSearching'])) {
  $alumniSearching = $_GET['alumniSearching'];
}

if (isset($_GET['alumniID'])) {
    $alumniID = $_GET['alumniID'];
}

if (isset($_GET['firstFilter'])) {
   $firstFilter = $_GET['firstFilter'];
}

if (isset($_GET['lastFilter'])) {
	$lastFilter = $_GET['lastFilter'];
}

if (isset($_GET['yearFilter'])) {
	$yearFilter = $_GET['yearFilter'];
}

if (isset($_GET['sorting'])) {
    if ($_GET['sorting'] == "'ASC'") {
        $sort = 'DESC';
    } else {
        $sort = 'ASC';
    }
}

if (isset($_GET['field'])) {
    if ($_GET['field'] == 'FirstName') {
        $field = "FirstName";
    } elseif ($_GET['field'] == 'LastName') {
        $field = "LastName";
    } elseif ($_GET['field'] == 'GraduationYear') {
        $field = 'GraduationYear';
    }
}

if (isset($_GET['contactEditSelected'])) {
    $contactEditSelected = true;
    toContactEdit($alumniID);
}

if (!empty($_POST['contactInfo'])) {
    $contactInfo = $_POST['contactInfo'];
    $query =
        "UPDATE alumnidatabase.AlumniDetails
    SET 
		FirstName = '$contactInfo[0]'"
		. ", LastName = '$contactInfo[1]'"
		. ", LinkedIn = '$contactInfo[2]'"
        . ", GraduationYear = '$contactInfo[3]'"
        . ", Phone = '$contactInfo[4]'"
		. ", Email = '$contactInfo[5]'"
		. ", Gender = '$contactInfo[6]'"
		. ", Degree = '$contactInfo[7]'"
		. ", Concentration = '$contactInfo[8]'"
		. ", City = '$contactInfo[9]'"
		. ", Country = '$contactInfo[10]'"
        . " WHERE alumniID = $contactInfo[11]";
    if ($conn->query($query) == TRUE) {
        echo "Alumni Updated";
    } else {
        echo "Error updating Alumni.";
    }
}

if (!empty($_POST['JobTitle'])) {
    $JobTitle = $_POST['JobTitle'];
    $JobDescription = $_POST['JobDescription'];
    $OrganizationName = $_POST['OrganizationName'];
    $EmploymentType = $_POST['EmploymentType'];
    $StartDate = $_POST['StartDate'];
    $EndDate = $_POST['EndDate'];
    $JobID = $_POST['JobID'];
    for ($i = 0; $i < count($JobTitle); $i++) {
        $query = '';
        if ($JobID[$i] == '') {
            $query = "INSERT INTO alumnidatabase.jobs (
                JobID, AlumniID, JobTitle, JobDescription, OrganizationName, EmploymentType, StartDate, EndDate) VALUES (NULL, $alumniID"
                . ", '" . $JobTitle[$i] . "'"
                . ", '" . $JobDescription[$i] . "'"
                . ", '" . $OrganizationName[$i] . "'"
                . ", '" . $EmploymentType[$i] . "'"
                . ", '" . $StartDate[$i] . "'"
                . ", '" . $EndDate[$i] . "')";
        } else {
            $query = "UPDATE alumnidatabase.jobs SET
			 JobTitle = '" . $JobTitle[$i] . "'"

                . ", JobDescription = '" . $JobDescription[$i] . "'"
                . ", OrganizationName = '" .$OrganizationName [$i] . "'"
                . ", EmploymentType = '" .$EmploymentType [$i] . "'"
                . ", StartDate = '" . $StartDate[$i] . "'"
                . ", EndDate = '" . $EndDate[$i] . "'"
                . " WHERE JobID = '" . $JobID[$i] . "'";
        }
        //echo "<br>" . $query;
    }

	if ($conn->query($query) == TRUE) {
            echo "Jobs Updated";
        } else {
            echo "Error updating Jobs.";
		
    }
}

if (!empty($_POST['EducationLevel'])) {
    $EducationLevel = $_POST['EducationLevel'];
    $Degree = $_POST['Degree'];
	$FieldofStudy = $_POST['FieldofStudy'];
    $SchoolName = $_POST['SchoolName'];
	$StartYear = $_POST['StartYear'];
	$EndYear = $_POST['EndYear'];
	$Description = $_POST['Description'];
    $EducationID = $_POST['EducationID'];
    for ($i = 0; $i < count($EducationLevel); $i++) {
        $query = '';
        if ($EducationID[$i] == '') {
            $query = "INSERT INTO alumnidatabase.education (
                EducationID, AlumniID, EducationLevel, Degree, FieldofStudy, SchoolName, StartYear, EndYear, Description) VALUES (NULL, $alumniID"
                . ", '" . $EducationLevel[$i] . "'"
                . ", '" . $Degree[$i] . "'"
				. ", '" . $FieldofStudy[$i] . "'"
				. ", '" . $SchoolName[$i] . "'"
				. ", '" . $StartYear[$i] . "'"
				. ", '" . $EndYear[$i] . "'"
                . ", '" . $Description[$i] . "')";
        } else {
            $query = "UPDATE alumnidatabase.education SET "
                . "EducationLevel = '" . $EducationLevel[$i] . "'"
                . ", Degree = '" . $Degree[$i] . "'"
                . ", FieldofStudy = '" . $FieldofStudy[$i] . "'"
				. ", SchoolName = '" . $SchoolName[$i] . "'"
				. ", StartYear = '" . $StartYear[$i] . "'"
				. ", EndYear = '" . $EndYear[$i] . "'"
				. ", Description = '" . $Description[$i] . "'"
                . " WHERE EducationID = '" . $EducationID[$i] . "'";
        }
        //echo "<br>" . $query;   
    }
	 if ($conn->query($query) == TRUE) {
            echo "Education Details Updated";
        } else {
            echo "Error updating Education Details";
    }
}

if ($alumniID > 0) {
    toDetails($alumniID);
}

function toContactEdit($alumniID)
{
    $GLOBALS['contactEditSelected'] = true;
    $GLOBALS['alumnSelected'] = false;
}

function toDetails($alumnID)
{
    $GLOBALS['alumniSearching'] = false;
    $GLOBALS['alumnSelected'] = true;
    drawAlumn($alumnID);
}
function toMain()
{
    $GLOBALS['alumniSearching'] = true;
    $GLOBALS['alumnSelected'] = false;
}
//Creating the document
?>
<html>
<script type="text/javascript" src='index.js'></script>

<head>

<!--<h1> Alumni Information System (AIS) </h1>-->
</head>

<body>




<!--Begin Table Search Bar-->


    <div id='ajax'></div>
	
    <div id='main' <?php if (!$alumniSearching) echo " style='display: none';"; ?>>
	  <div class ='search'>  
	
	<form action="" method="get">
            <input type="text" name='firstFilter' placeholder="First Name"></input>
            <input type="text" name='lastFilter' placeholder='Last Name'></input>
		 <select name='yearFilter'>
                <option value=''></option>
      
				
             
                <?php
                $query = "SELECT DISTINCT GraduationYear FROM alumnidatabase.alumnidetails";
                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $year = $row['GraduationYear'];
                        echo "<option value='" . $year . "'>" . $year . "</option>";
                    }
                }
				// (button to back up database, move it outside the php code if needed)<input type="button" value="Export Database" onclick="window.location.href='dbbackup.php'" />
                ?>
				
            </select>
            <button type='submit'>Submit</button>
			
		 
			
        </form>
		</div>
		
		
		<table>
		
            <thead>
                <tr>
				 <th>
				 <a title="Sort by Alumni ID" href="index.php?sorting='<?php echo $sort ?>'&field=AlumniID">AlumniID</a>
				 </th>
                    <th>
                        <a title="Sort by First Name" href="index.php?sorting='<?php echo $sort ?>'&field=FirstName">First Name</a>
                    </th>
                    <th>
                        <a title="Sort by Last Name" href="index.php?sorting='<?php echo $sort ?>'&field=LastName">Last Name</a>
                    </th>
                    <th>LinkedIn</th>
					 <th>
                        <a title="Sort by Graduation Year" href="index.php?sorting='<?php echo $sort ?>'&field=GraduationYear">Graduation Year</a>
                    </th>
					<th>
					
					 <a title="Sort by Phone" href="index.php?sorting='<?php echo $sort ?>'&field=Phone">Phone</a>
					 </th>
                    <th>
					 <a title="Sort by Email" href="index.php?sorting='<?php echo $sort ?>'&field=Email">Email</a>
					 </th>
					 <th>
					 
                    <a title="Sort by Gender" href="index.php?sorting='<?php echo $sort ?>'&field=Gender">Gender</a>
                    </th>
					 <th>
                        <a title="Sort by Degree" href="index.php?sorting='<?php echo $sort ?>'&field=Degree">Degree</a>
                    </th>
					 <th>
                        <a title="Sort by Concentration" href="index.php?sorting='<?php echo $sort ?>'&field=Concentration">Concentration</a>
                    </th>
					 <th>
                        <a title="Sort by City" href="index.php?sorting='<?php echo $sort ?>'&field=City">City</a>
                    </th>
					 <th>
                        <a title="Sort by Country" href="index.php?sorting='<?php echo $sort ?>'&field=Country">Country</a>
                    </th>
                </tr>
            </thead>
            <tbody name='alumniBody'>
		
                <?php
                $query = "SELECT * FROM alumnidatabase.alumnidetails  WHERE FirstName LIKE '$firstFilter%' AND LastName like '$lastFilter%' AND GraduationYear like '$yearFilter%' ORDER BY $field $sort";
				
                //echo $query;
                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
						echo "<td>" . $row['AlumniID'] . "</td>";
                        echo "<td>" . $row['FirstName'] . "</td>";
                        echo "<td>" . $row['LastName'] . "</td>";
                        echo "<td><a href='" . $row['LinkedIn'] . "' target='_blank'>Link</a></td>";
                        echo "<td>" . $row['GraduationYear'] . "</td>";
                        echo "<td>" . $row['Phone'] . "</td>";
						echo "<td>" . $row['Email'] . "</td>";
						echo "<td>" . $row['Gender'] . "</td>";
						echo "<td>" . $row['Degree'] . "</td>";
						echo "<td>" . $row['Concentration'] . "</td>";
						echo "<td>" . $row['City'] . "</td>";
						echo "<td>" . $row['Country'] . "</td>";
                        echo "<td><form action='' method='get'>";
                        echo "<input style='display: none' type='text' name='alumniID' value='" . $row['AlumniID'] . "'></input>";
                        echo "<button type='submit'>Edit</button></form></td></tr>";
                    }
                }

                ?>
            </tbody>
        </table>
    </div>
	
    <div id='alumnDetails' <?php if (!$alumnSelected) echo " style='display: none';"; ?>>

        <?php

        function drawAlumn($alumnID)
        { ?>
            <h3>Alumni Details Information
                <!--<a href="contactform.php?contactEditSelected=true&alumniSearching=false&alumniID='<?php echo $GLOBALS['alumniID']; ?>'">Edit</a>"-->
            </h3>
            <form method=post>
                <table>
                    <?php
                    $GLOBALS['alumnSelected'] = true;
                    $query = "SELECT * FROM alumnidatabase.AlumniDetails WHERE alumnidatabase.AlumniDetails.AlumniID = '$alumnID'";
                    if ($result = $GLOBALS['conn']->query($query)) {
                        while ($row = $result->fetch_assoc()) {
                          
							
							echo "<tr><th>First Name</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='firstName' value='" . $row['FirstName'] . "'</input></td></tr>";
							echo "<tr><th>Last Name</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='LastName' value='" . $row['LastName'] . "'</input></td></tr>";
							
                            echo "<tr><th>LinkedIn</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='linkedIn' value='" . $row['LinkedIn'] . "'></input>&nbsp&nbsp";
                            echo "<a href='" . $row['LinkedIn'] . "' target='_blank'>Link</a></td></tr>";
                            
                            echo "<tr><th>Graduation Year</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='graduationYear' value='" . $row['GraduationYear'] . "'</input></td></tr>";
							echo "<tr><th>Phone</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='phone' value='" . $row['Phone'] . "'</input></td></tr>";
							echo "<tr><th>Email</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='email' value='" . $row['Email'] . "'</input></td></tr>";
							echo "<tr><th>Gender</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='gender' value='" . $row['Gender'] . "'</input></td></tr>";
							echo "<tr><th>Degree</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='degree' value='" . $row['Degree'] . "'</input></td></tr>";
							echo "<tr><th>Concentration</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='concentration' value='" . $row['Concentration'] . "'</input></td></tr>";
							echo "<tr><th>City</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='city' value='" . $row['City'] . "'</input></td></tr>";
							echo "<tr><th>Country</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='country' value='" . $row['Country'] . "'</input></td></tr>";
							echo "<td><input type='text' style='display: none' name='contactInfo[]' id='AlumniID' value='" . $row['AlumniID'] . "'</td></tr>";	
                            echo "<tr><td><button type='submit'>Update</button></td>";
							
                            
                        }
                    }
                    ?>
					
			


					
                </table>
            </form>
		
            <script>
                function addRow(tableID, colGroups) {
                    var table = document.getElementById(tableID);
                    var rowCount = table.rows.length;
                    var row = table.insertRow(rowCount);
                    for (i = 0; i < colGroups.length; i++) {
                        cell = row.insertCell(i);
                        cell.innerHTML = "<td><input type='text' value='' name='" + colGroups[i] + "[]' id='" + (rowCount + 1) + "'></input></td>"
                        if (i == colGroups.length - 1) {
                            cell.style.display = "none";
                        }
                    }
                }
            </script>
            <h3>Jobs
            </h3>
            <script>
                alumnArrays = ['JobTitle', 'JobDescription', 'OrganizationName', 'EmploymentType','StartDate', 'EndDate', 'JobID'];
                eduArrays = ['EducationLevel', 'Degree', 'FieldofStudy', 'SchoolName', 'StartYear', 'EndYear', 'Description','EducationID'];
            </script>
            	<button onclick="addRow('jobtable', alumnArrays)">ADD ROW</button>
            <form method='post'>
                <button type='submit'>UPDATE</button> 
				
                <table>
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Job Description</th>
                            <th>Organization Name</th>
                            <th>Employment Type</th>
                            
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th style='display: none'></th>
                            <th style='display: none'></th>
                        </tr>
                    </thead>
                    <tbody id='jobtable'>
                        <tr>
                            <?php
                            //$query = "SELECT * FROM alumnidatabase.jobs WHERE 'Alumni ID' ='$alumnID' ORDER BY 'Job ID' DESC";
                            $query = "SELECT * FROM alumnidatabase.jobs WHERE AlumniID = '$alumnID'
                    ORDER BY StartDate ASC";
                            if ($result = $GLOBALS['conn']->query($query)) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><input type='text' value='" . $row['JobTitle'] . "' name='JobTitle[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['JobDescription'] . "' name='JobDescription[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['OrganizationName'] . "' name='OrganizationName[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['EmploymentType'] . "' name='EmploymentType[]' id='" . $count . "'></input></td>";
                             
                                    echo "<td><input type='text' value='" . $row['StartDate'] . "' name='StartDate[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['EndDate'] . "' name='EndDate[]' id=" . $count . "'></input></td></tr>";
                                    echo "<td><input type='text' value='" . $row['JobID'] . "' name='JobID[]' id='" . $count . "' style='display: none'></input></td>";
                                    echo "<td><input type='text' value='" . $row['AlumniID'] . "' name='alumniID' style='display: none'></input></td>";
                                    $count += 1;
                                }
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
				
            </form>
			
            <h3>Education
            </h3>
			 <button onclick="addRow('edutable', eduArrays)">ADD ROW</button>
            <form method='post'> 
                <button type='submit'>UPDATE</button> 
           
                <table>
                    <tr>
                        <th>Education Level</th>
                        <th>Degree</th>
                        <!--<th>Graduation Date</th> -->
						<th>Field of Study</th>
						<th>School Name </th>
						<th>Start Year</th>
						<th>End Year</th>
						<th>Description</th>
                        <th style='display: none'></th>
                        <th style='display: none'></th>
                    </tr>
                    <tbody id='edutable'>
                        <tr>
					
                            <?php 
                            //$query = "SELECT * FROM alumnidatabase.jobs WHERE 'Alumni ID' ='$alumnID' ORDER BY 'Job ID' DESC";
                            $query = "SELECT * FROM alumnidatabase.education WHERE AlumniID = '$alumnID'
                    ORDER BY StartYear DESC";
                            if ($result = $GLOBALS['conn']->query($query)) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><input type='text' name='EducationLevel[]' value='" . $row['EducationLevel'] . "' id='" . $count . "'</input></td>";
                                    echo "<td><input type='text' name='Degree[]' value='" . $row['Degree'] . "' id ='" . $count . "'</input></td>";
                                    echo "<td><input type='text' name='FieldofStudy[]' value='" . $row['FieldofStudy'] . "' id='" . $count . "'</input></td>";
									echo "<td><input type='text' name='SchoolName[]' value='" . $row['SchoolName'] . "' id='" . $count . "'</input></td>";
									echo "<td><input type='text' name='StartYear[]' value='" . $row['StartYear'] . "' id='" . $count . "'</input></td>";
									echo "<td><input type='text' name='EndYear[]' value='" . $row['EndYear'] . "' id='" . $count . "'</input></td>";
									echo "<td><input type='text' name='Description[]' value='" . $row['Description'] . "' id='" . $count . "'</input></td></tr>";
                                    echo "<td><input type='text' name='EducationID[]' value='" . $row['EducationID'] . "' id='" . $count . "' style='display: none'></input></td>";
                                    echo "<td><input type='text' name='AlumniID' value='" . $row['AlumniID'] . "' style='display: none'></input></td></tr>";
                                    $count += 1;
                                }
                            }
                            ?>
                        </tr>
                    </tbody>
            </form>
            </table>

			
	
        <?php

        }
        ?>
	
		
    </div>
</body>

</html>