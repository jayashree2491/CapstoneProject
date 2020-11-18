<?php session_start();
// Database Connection
//require 'index.php';
include 'dbConfig.php';
$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 
'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

if($_REQUEST['alumni'] == "alumnidetails"){
    $fn = 'file';
}elseif($_REQUEST['alumni'] == "jobs"){
    $fn = 'file1';
}else{
    $fn = 'file2';
}
if (isset($_POST['submit'])) {

   // Validate whether selected file is a CSV file
   if(!empty($_FILES[$fn]['name']) && in_array($_FILES[$fn]['type'], $csvMimes)){
       
    // If the file is uploaded
    if(is_uploaded_file($_FILES[$fn]['tmp_name'])){
        
        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($_FILES[$fn]['tmp_name'], 'r');
        
        // Skip the first line
        $data =   fgetcsv($csvFile,1000,',');
        $alumniHeader = array('AlumniID','FirstName', 'LastName');
        $jobHeader = array ('JobID','AlumniID','JobTitle');
        $educationHeader = array ('EducationID','AlumniID','EducationLevel');
        //if(!empty($_SESSION)){
            //echo "&&&&" .$_REQUEST['alumni'];
            //exit;

        if (in_array($data[0],$alumniHeader) && in_array ($data[1],$alumniHeader) 
        && in_array($data[2],$alumniHeader) && ($_REQUEST['alumni'] == "alumnidetails")) {
       
        //if($_FILES[$fn]['name'] == "AlumniDetails.csv"){
        // Parse data from CSV file line by line
        while(($line = fgetcsv($csvFile)) !== FALSE){
            // Get row data

            $alumniID = $line[0];
            $firstname = $line[1];
            $lastname   = $line[2];
            $linkedIn  = $line[3];
            $graduationyear  = $line[4];
            $phone = $line[5];
            $email = $line[6];
            $gender = $line[7];
            $degree = $line[8];
            $concentration = $line[9];
            $city = $line[10];
            $country = $line[11];
           
             // Check whether alumni already exists in the database 
             $prevQuery = "SELECT alumniID FROM AlumniDetails WHERE alumniID = '".$line[0]."'";
             $prevResult = $con->query($prevQuery);

             if($prevResult->num_rows == 0){
                // Insert alumni data in the database
                $con->query("INSERT INTO AlumniDetails (AlumniID, Firstname, Lastname, LinkedIn,GraduationYear,Phone,Email,Gender,Degree,Concentration,City,Country) 
                VALUES ('".$alumniID."','".$firstname."', '".$lastname."', '".$linkedIn."','".$graduationyear."','".$phone."','".$email."','".$gender."',
                '".$degree."','".$concentration."','".$city."','".$country."')");    
            }
        }
        fclose($csvFile);
            
        $qstring = '?status=succ';
        $_SESSION['displayAlumniDetails'] = true;
        $_SESSION['displayJobs'] = false;
        $_SESSION['displayEducation'] = false;
        }

   
        //else if($_FILES[$fn]['name'] == "Jobs.csv"){
        else if (in_array($data[0],$jobHeader) && in_array ($data[1],$jobHeader) 
            && in_array($data[2],$jobHeader)&& ($_REQUEST['alumni'] == "jobs")){
           
            while(($line = fgetcsv($csvFile)) !== FALSE){

            $jobId = $line[0];
            $alumniID = $line[1];
            $jobtitle   = $line[2];
            $jobdescription  = $line[3];
            $organizationName  = $line[4];
            $employmentType = $line[5];
            $startDate = $line[6];
            $endDate = $line[7];
         // Check whether job id already exists in the database 
            $prevQuery = "SELECT jobID FROM Jobs WHERE jobID = '".$line[0]."'";
            $prevResult = $con->query($prevQuery);

            if($prevResult->num_rows == 0){
                // Insert job data in the database
            $con->query("INSERT INTO Jobs (JobID, AlumniID, JobTitle, JobDescription,OrganizationName,EmploymentType,StartDate,EndDate) 
            VALUES ('".$jobId."','".$alumniID."', '".$jobtitle."', '".$jobdescription."','".$organizationName."','".$employmentType."','".$startDate."','".$endDate."'
            )");           
            }
            }
    
        fclose($csvFile);
            
        $qstring = '?status=succ';
        $_SESSION['displayJobs'] = true ;
        $_SESSION['displayAlumniDetails'] = false;
        $_SESSION['displayEducation'] = false;

        }   


        //else if($_FILES[$fn]['name'] == "Education.csv"){
        elseif (in_array($data[0],$educationHeader) && in_array ($data[1],$educationHeader) 
            && in_array($data[2],$educationHeader)&& ($_REQUEST['alumni'] == "education")){
           
            while(($line = fgetcsv($csvFile)) !== FALSE){

            $educationId = $line[0];
            $alumniID = $line[1];
            $educationlevel   = $line[2];
            $degree  = $line[3];
            $fieldofstudy  = $line[4];
            $schoolname = $line[5];
            $startyear = $line[6];
            $endyear = $line[7];
            $description = $line[8];
             // Check whether education id already exists in the database 
             $prevQuery = "SELECT educationID FROM Education WHERE educationID = '".$line[0]."'";
             $prevResult = $con->query($prevQuery);

				if($prevResult->num_rows == 0){
                // Insert education data in the database
                $con->query("INSERT INTO Education (EducationID, AlumniID, EducationLevel, Degree,FieldofStudy,SchoolName,StartYear,EndYear,Description) 
                VALUES ('".$educationId."','".$alumniID."', '".$educationlevel."', '".$degree."','".$fieldofstudy."','".$schoolname."','".$startyear."','".$endyear."','".$description."'
                )");
				}
            }
        
        fclose($csvFile);       
        $qstring = '?status=succ';
        $_SESSION['displayEducation'] = true ;
        $_SESSION['displayAlumniDetails'] = false;
        $_SESSION['displayJobs'] = false;
        }
        
		else{
        $qstring = '?status=err';
        }

    }
    else{
        $qstring = '?status=uploaderr'; 
    }
   }
    else{
    $qstring = '?status=invalid_file';
    }

}
header("Location: DisplayData.php".$qstring);
exit();
?>

           
        