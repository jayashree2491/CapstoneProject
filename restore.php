<?php
include ('restore.css');
$conn = mysqli_connect("localhost", "root", "", "alumnidatabase");
if (! empty($_FILES)) {
    // Validating SQL file type by extensions
    
    if (! in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
        "sql"
    ))) {
        $response = array(
            "type" => "error",
            "message" => "Invalid file type. Please input .sql file to restore database"
        );
    } else {
        if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
			if(!is_dir(__DIR__."/restore")){
			mkdir(__DIR__."/restore");
			}
			$path = __DIR__."/restore/restoredatabase.sql";
			
			move_uploaded_file($_FILES["backup_file"]["tmp_name"], $path);
           $result = $conn->query("SHOW TABLES from alumnidatabase");
            if($result->num_rows > 0){
           $sql = 'DROP Table Education';
           $retval = mysqli_query( $conn, $sql );
           if(! $retval ) {
              die('Could not delete table Education: ' . mysql_error());
           }
           $sql = 'DROP Table Jobs';
           $retval = mysqli_query( $conn, $sql );
           if(! $retval ) {
              die('Could not delete table Jobs: ' . mysql_error());
           }
           $sql = 'DROP Table AlumniDetails';
           $retval = mysqli_query( $conn, $sql );
           if(! $retval ) {
              die('Could not delete table AlumniDetails: ' . mysql_error());
           }	   
        }   		
            $response = restoreMysqlDB($path, $conn);
        }
    }
}


function restoreMysqlDB($filePath, $conn)
{
    $sql = '';
    $error = '';
    
    
    if (file_exists($filePath)) {
        $lines = file($filePath);
        
        foreach ($lines as $line) {
            
            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            
            $sql .= $line;
            
            if (substr(trim($line), - 1, 1) == ';') {
                $result = mysqli_query($conn, $sql);
                if (! $result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach
        
        if ($error) {
            $response = array(
                "type" => "error",
                "message" => $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }
        exec('rm ' . $filePath);
    } // end if file exists
    
    return $response;
}

?>
<html>
<body>
<br/>
<?php
if (! empty($response)) {
    ?>
<div class="response <?php echo $response["type"]; ?>">
<?php echo nl2br($response["message"]); ?>
</div>
<?php
}
?>
    <form method="post" action="" enctype="multipart/form-data"
        id="frm-restore">
        <div class="form-row">
            <div>Choose Backup File</div>
            <div>
                <input type="file" name="backup_file" class="input-file" required/>
            </div>
        </div>
        <div>
            <input type="submit" name="restore" value="Restore"
                class="btn-action" />
        </div>
    </form>

</body>
</html>