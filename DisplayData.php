<?php session_start();
include_once 'dbConfig.php'; 
include ('importfunction.css');
// Get status message
if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Alumni data has been imported successfully.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Some problem occurred, the uploaded file template and table selected should match.';
            break;
        case 'uploaderr':
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload the file.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}
?>
<html>  
    <head>
    <link rel="stylesheet" href="test.css?v=<?php echo time(); ?>">
    </head>
<br/>
<div class="row">
    <div style = "text-align: center">
        <label> <b> Import Data to Database tables </b></label> &nbsp; &nbsp; &nbsp; 
        <!--<input type = "button" class ="buttonValue" value = "Home" onclick = "window.location.href='index.php'"> -->
    </div>
    <!--<div class="col-md-12" id="importFrm">-->
    <form action="import.php" method="post" enctype="multipart/form-data">
		<div class = "radiodiv">
		 <h3>Select the table you want to import data</h3>
        <input type="radio" name="alumni" value="alumnidetails" onclick="showAlumniImport();"/>
        AlumniDetails
        <input type="radio" name="alumni" value="jobs" onclick="showJobImport();"/>
        Jobs
        <input type="radio" name="alumni" value="education" onclick="showEducationImport();"/>
        Education
		</div>
	<br/>
        <div id="alumniDiv" class="hide"> 
            <input type="file" name="file" value ="alumnifile"/>
            <input type="submit" class="btn btn-primary" name="submit" value="Submit"> <br/><br/>
            To download the file template of import for table selected, Click the link! 
            <a href="AlumniTemplate.csv" download>Import File template</a>    
            <br/>
			<br/>
            <!--</form> -->
            <?php 
            //$con=mysqli_connect("host","user","pass","MY_DB");
            $result = mysqli_query($con,"SELECT MAX(AlumniID) FROM AlumniDetails");
            $row1 = mysqli_fetch_array($result);
            $highest_id = $row1[0];
            echo " The ID for the last Alumni is " .$highest_id;
            ?>      
        </div>
        <div id="jobDiv" class="hide">    
            <!--<form action="import.php" method="post" enctype="multipart/form-data"> -->
            <input type="file" name="file1" value ="jobfile"/>
            <input type="submit" class="btn btn-primary" name="submit" value="Submit"> <br/><br/>
            To download the file template of import for table selected, Click the link!
            <a href="JobsTemplate.csv" download>Import File template</a> 
            <br/>
			<br/>
            <!--</form> -->
            <?php 
            //$con=mysqli_connect("host","user","pass","MY_DB");
            $result = mysqli_query($con,"SELECT MAX(JobID) FROM Jobs");
            $row1 = mysqli_fetch_array($result);
            $highest_id = $row1[0];
            echo " The ID of last Alumni's Job details is " .$highest_id;
            ?>
        </div>
        <div id="educationDiv" class="hide">    
            <!--<form action="import.php" method="post" enctype="multipart/form-data"> -->
            <input type="file" name="file2" value="educfile"/>
            <input type="submit" class="btn btn-primary" name="submit" value="Submit"> <br/><br/>
            To download the file template of import for table selected, Click the link!
            <a href="EducationTemplate.csv" download>Import File template</a>    
            <br/>
			<br/>
            <!--</form> -->
            <?php 
            //$con=mysqli_connect("host","user","pass","MY_DB");
            $result = mysqli_query($con,"SELECT MAX(EducationID) FROM Education");
            $row1 = mysqli_fetch_array($result);
            $highest_id = $row1[0];
            echo " The ID of last Alumni's Education details is " .$highest_id;
            ?>
        </div> 
    </form>
    <!-- Display status message -->
    <?php 
    if(!empty($statusMsg)){ ?>
    <div class="col-xs-12">
    <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>   
    </div>
	<br/>
    <?php } ?>
    <?php unset($statusMsg);
   ?>
   
    
    <!-- Data list table for Alumni Details --> 
	<?php if (!empty ($_SESSION)) { ?>
        <?php
          if($_SESSION['displayAlumniDetails']==1){ 
       // Get member rows
        $result = $con->query("SELECT * FROM AlumniDetails");
        if($result->num_rows > 0){
            ?>
           
            <h2>Alumni Details Table </h2>
              <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>AlumniID</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>LinkedIn</th>
                    <th>GraduationYear</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Degree</th>
                    <th>Concentration</th>
                    <th>City</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($row = $result->fetch_assoc()){
        ?>
            <tr>
                <td><?php echo $row['AlumniID']; ?></td>
                <td><?php echo $row['FirstName']; ?></td>
                <td><?php echo $row['LastName']; ?></td>
                <td><?php echo $row['LinkedIn']; ?></td>
                <td><?php echo $row['GraduationYear']; ?></td>
                <td><?php echo $row['Phone']; ?></td>
                <td><?php echo $row['Email']; ?></td>
                <td><?php echo $row['Gender']; ?></td>
                <td><?php echo $row['Degree']; ?></td>
                <td><?php echo $row['Concentration']; ?></td>
                <td><?php echo $row['City']; ?></td>
                <td><?php echo $row['Country']; ?></td>
            </tr>
        <?php } }
        else{ ?>
            <tr><td colspan="5">No Data(s) found...</td></tr>
        <?php } ?>
        </tbody>
    </table>

        <?php } ?>
         <!-- Data list table for Job Details --> 

        <?php  if($_SESSION['displayJobs']==1){ 
        $result = $con->query("select AD.FirstName,AD.LastName,AD.LinkedIn,J.* from Jobs J right join AlumniDetails AD on J.AlumniID  = AD.AlumniID");
        if($result->num_rows > 0){
         ?>
    
    <h2>Job Details  Table </h2>
      <table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>FirstName</th>
            <th>LastName</th>
            <th>LinkedIn</th>
            <th>JobID</th>
            <th>AlumniID</th>
            <th>JobTitle</th>
            <th>JobDescription</th>
            <th>OrganizationName</th>
            <th>EmploymentType</th>
            <th>StartDate</th>
            <th>EndDate</th>
        </tr>
    </thead>
    <tbody>
    <?php
            while($row = $result->fetch_assoc()){
        ?>
            <tr>
                <td><?php echo $row['FirstName']; ?></td>
                <td><?php echo $row['LastName']; ?></td>
                <td><?php echo $row['LinkedIn']; ?></td>
                <td><?php echo $row['JobID']; ?></td>
                <td><?php echo $row['AlumniID']; ?></td>
                <td><?php echo $row['JobTitle']; ?></td>
                <td><?php echo $row['JobDescription']; ?></td>
                <td><?php echo $row['OrganizationName']; ?></td>
                <td><?php echo $row['EmploymentType']; ?></td>
                <td><?php echo $row['StartDate']; ?></td>
                <td><?php echo $row['EndDate']; ?></td>
            </tr>
        <?php } }
        else{ ?>
            <tr><td colspan="5">No Data(s) found...</td></tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>
     <!-- Data list table for Education Details --> 

    <?php  if($_SESSION['displayEducation']==1){ 
 $result = $con->query("select AD.FirstName,AD.LastName,AD.LinkedIn,Ed.* from Education Ed right join AlumniDetails AD on Ed.AlumniID  = AD.AlumniID");
 if($result->num_rows > 0){
    ?>
    
    <h2>Education Details Table </h2>
      <table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>FirstName</th>
            <th>LastName</th>
            <th>LinkedIn</th>
            <th>EducationID</th>
            <th>AlumniID</th>
            <th>EducationLevel</th>
            <th>Degree</th>
            <th>FieldofStudy</th>
            <th>SchoolName</th>
            <th>StartYear</th>
            <th>EndYear</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
    <?php
            while($row = $result->fetch_assoc()){
        ?>
            <tr>
                <td><?php echo $row['FirstName']; ?></td>
                <td><?php echo $row['LastName']; ?></td>
                <td><?php echo $row['LinkedIn']; ?></td>
                <td><?php echo $row['EducationID']; ?></td>
                <td><?php echo $row['AlumniID']; ?></td>
                <td><?php echo $row['EducationLevel']; ?></td>
                <td><?php echo $row['Degree']; ?></td>
                <td><?php echo $row['FieldofStudy']; ?></td>
                <td><?php echo $row['SchoolName']; ?></td>
                <td><?php echo $row['StartYear']; ?></td>
                <td><?php echo $row['EndYear']; ?></td>
                <td><?php echo $row['Description']; ?></td>
            </tr>
        <?php } }
        else{ ?>
            <tr><td colspan="5">No Data(s) found...</td></tr>
        <?php }
		  } ?>
        </tbody>
    </table>

    <?php } ?>

</div>
<script>
function showAlumniImport(){
  document.getElementById('alumniDiv').style.display ='block';
  document.getElementById('jobDiv').style.display ='none';
  document.getElementById('educationDiv').style.display ='none';

}
function showJobImport(){
  document.getElementById('alumniDiv').style.display ='none';
  document.getElementById('jobDiv').style.display ='block';
  document.getElementById('educationDiv').style.display ='none';
}
function showEducationImport(){
  document.getElementById('alumniDiv').style.display ='none';
  document.getElementById('jobDiv').style.display ='none';
  document.getElementById('educationDiv').style.display ='block';
  
}
</script>
</html>