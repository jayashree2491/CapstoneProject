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
        "UPDATE alumnidatabase.alumni
    SET 
       LinkedIn = '$contactInfo[0]'"
        . ", Email = '$contactInfo[1]'"
        . ", GraduationYear = '$contactInfo[2]'"
        . " WHERE alumniID = $contactInfo[3]";
    if ($conn->query($query) == TRUE) {
        echo "Alumni Updated";
    } else {
        echo "Error updating Alumni.";
    }
}

if (!empty($_POST['titles'])) {
    $titles = $_POST['titles'];
    $jobCategories = $_POST['jobCategories'];
    $domains = $_POST['domains'];
    $levels = $_POST['levels'];
    $startDates = $_POST['startDates'];
    $endDates = $_POST['endDates'];
    $jobIDs = $_POST['jobIDs'];
    for ($i = 0; $i < count($titles); $i++) {
        $query = '';
        if ($jobIDs[$i] == '') {
            $query = "INSERT INTO alumnidatabase.jobs (
                JobID, AlumniID, Title, JobCategory, Domain, Level, StartDate, EndDate) VALUES (NULL, $alumniID"
                . ", '" . $titles[$i] . "'"
                . ", '" . $jobCategories[$i] . "'"
                . ", '" . $domains[$i] . "'"
                . ", '" . $levels[$i] . "'"
                . ", '" . $startDates[$i] . "'"
                . ", '" . $endDates[$i] . "')";
        } else {
            $query = "UPDATE alumnidatabase.jobs SET
                Title = '" . $titles[$i] . "'"
                . ", JobCategory = '" . $jobCategories[$i] . "'"
                . ", Domain = '" . $domains[$i] . "'"
                . ", Level = '" . $levels[$i] . "'"
                . ", StartDate = '" . $startDates[$i] . "'"
                . ", EndDate = '" . $endDates[$i] . "'"
                . " WHERE JobID = '" . $jobIDs[$i] . "'";
        }
        //echo "<br>" . $query;
        if ($conn->query($query) == TRUE) {
            echo "Jobs Updated";
        } else {
            echo "Error updating Jobs.";
        }
    }
}

if (!empty($_POST['educationNames'])) {
    $eduNames = $_POST['educationNames'];
    $degrees = $_POST['degrees'];
    $gradDates = $_POST['graduationDates'];
    $eduIDs = $_POST['educationIDs'];
    for ($i = 0; $i < count($eduNames); $i++) {
        $query = '';
        if ($eduIDs[$i] == '') {
            $query = "INSERT INTO alumnidatabase.education (
                EducationID, AlumniID, EducationName, Degree, GraduationDate) VALUES (NULL, $alumniID"
                . ", '" . $eduNames[$i] . "'"
                . ", '" . $degrees[$i] . "'"
                . ", '" . $gradDates[$i] . "')";
        } else {
            $query = "UPDATE alumnidatabase.education SET "
                . "EducationName = '" . $eduNames[$i] . "'"
                . ", Degree = '" . $degrees[$i] . "'"
                . ", GraduationDate = '" . $gradDates[$i] . "'"
                . " WHERE EducationID = '" . $eduIDs[$i] . "'";
        }
        //echo "<br>" . $query;
        if ($conn->query($query) == TRUE) {
            echo "Education Details Updated";
        } else {
            echo "Error updating Education Details.";
        }
    }
}

if ($alumniID > 0) {
    toDetails($alumniID);
}

function toContactEdit($alumnID)
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
<script type="text/javascript" src="index.js"></script>

<head>
<h1> Alumni Information System (AIS) </h1>
</head>

<body>

    <!--Begin Table-->
    <div id='ajax'></div>
    <div id='main' <?php if (!$alumniSearching) echo " style='display: none';"; ?>>
        <form action="" method="get">
            <input type="text" name='firstFilter' placeholder="First Name"></input>
            <input type="text" name='lastFilter' placeholder='Last Name'></input>
            <select name='yearFilter'>
                <option value=''></option>
                <?php
                $query = "SELECT DISTINCT GraduationYear FROM alumnidatabase.alumni";
                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $year = $row['GraduationYear'];
                        echo "<option value='" . $year . "'>" . $year . "</option>";
                    }
                }
                ?>
            </select>
            <button type='submit'>Submit</button>
        </form>
        <table>
		
            <thead>
                <tr>
				 <th>
				 <a title="Sort by Alumni ID" href="loop.php?sorting='<?php echo $sort ?>'&field=AlumniID">AlumniID</a>
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
                //$query = "SELECT * FROM alumnidatabase.alumni WHERE FirstName LIKE '$firstFilter%' AND LastName like '$lastFilter%' AND GraduationYear like '$yearFilter%' ORDER BY $field $sort";
				
				$query = "SELECT * FROM alumnidatabase.alumnidetails";
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
            <h3>Alumni Detail Information
                <a href="contactform.php?contactEditSelected=true&alumniSearching=false&alumniID='<?php echo $GLOBALS['alumniID']; ?>'">Edit</a>
            </h3>
            <form method=post>
                <table>
                    <?php
                    $GLOBALS['alumnSelected'] = true;
                    $query = "SELECT * FROM alumnidatabase.AlumniDetails WHERE alumnidatabase.alumnidetails.AlumniID = '$alumnID'";
                    if ($result = $GLOBALS['conn']->query($query)) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><th>Name</th>";
                            echo "<td><input type='text' value='" . $row['FirstName'] . " " . $row['LastName'] . "'></input></td></tr>";
                            echo "<tr><th>LinkedIn</th>";
							 echo "<td><a href='" . $row['LinkedIn'] . "' target='_blank'>Link</a></td>";
                           // echo "<td><input type='text' name='contactInfo[]' id='linkedIn' value='" . $row['LinkedIn'] . "'></input></td>";
                            echo "<td><a href='" . $row['LinkedIn'] . "' target='_blank'>Link</a></td></tr>";
                            echo "<tr><th>Email</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='email' value='" . $row['Email'] . "'</input></td></tr>";
                            echo "<tr><th>Graduation Year</th>";
                            echo "<td><input type='text' name='contactInfo[]' id='graduationYear' value='" . $row['GraduationYear'] . "'</input></td></tr>";
                            echo "<tr><td><button type='submit'>Update</button></td>";
                            echo "<td><input type='text' style='display: none' name='contactInfo[]' id='AlumniID' value='" . $row['AlumniID'] . "'</td></tr>";
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
                alumnArrays = ['titles', 'jobCategories', 'domains', 'levels', 'companies', 'startDates', 'endDates', 'jobIDs'];
                eduArrays = ['educationNames', 'degrees', 'graduationDates', 'educationIDs'];
            </script>
            <button onclick="addRow('jobtable', alumnArrays)">ADD ROW</button>
            <form method='post'>
                <button type='submit'>SUBMIT</button>
                <table>
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Job Category</th>
                            <th>Domain</th>
                            <th>Level</th>
                            <th>Company</th>
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
                                    echo "<td><input type='text' value='" . $row['Title'] . "' name='titles[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['JobCategory'] . "' name='jobCategories[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['Domain'] . "' name='domains[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['Level'] . "' name='levels[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['Company'] . "' name='companies[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['StartDate'] . "' name='startDates[]' id='" . $count . "'></input></td>";
                                    echo "<td><input type='text' value='" . $row['EndDate'] . "' name='endDates[]' id=" . $count . "'></input></td></tr>";
                                    echo "<td><input type='text' value='" . $row['JobID'] . "' name='jobIDs[]' id='" . $count . "' style='display: none'></input></td>";
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
                        <th>Education Name</th>
                        <th>Degree</th>
                        <th>Graduation Date</th>
                        <th style='display: none'></th>
                        <th style='display: none'></th>
                    </tr>
                    <tbody id='edutable'>
                        <tr>
					
                            <?php 
                            //$query = "SELECT * FROM alumnidatabase.jobs WHERE 'Alumni ID' ='$alumnID' ORDER BY 'Job ID' DESC";
                            $query = "SELECT * FROM alumnidatabase.education WHERE AlumniID = '$alumnID'
                    ORDER BY GraduationDate DESC";
                            if ($result = $GLOBALS['conn']->query($query)) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><input type='text' name='educationNames[]' value='" . $row['EducationName'] . "' id='" . $count . "'</input></td>";
                                    echo "<td><input type='text' name='degrees[]' value='" . $row['Degree'] . "' id ='" . $count . "'</input></td>";
                                    echo "<td><input type='text' name='graduationDates[]' value='" . $row['GraduationDate'] . "' id='" . $count . "'</input></td></tr>";
                                    echo "<td><input type='text' name='educationIDs[]' value='" . $row['EducationID'] . "' id='" . $count . "' style='display: none'></input></td>";
                                    echo "<td><input type='text' name='alumniID' value='" . $row['AlumniID'] . "' style='display: none'></input></td></tr>";
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