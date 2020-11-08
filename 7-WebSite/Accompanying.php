<?php 
    // Database Connection
	$sid = "(DESCRIPTION =
			(ADDRESS = (PROTOCOL = TCP)(HOST = DESKTOP-05HNRKE)(PORT = 1521))
			(CONNECT_DATA =
			(SERVER = DEDICATED)
			(SERVICE_NAME = orcl)
			)
			)";
	$user = "scott";
	$pass = "plmqaz12";
    $con = oci_connect($user,$pass,$sid); 
?>

<html>

    <head>
        <title>Accompanying Form</title>
    </head>

    
    <body>

        <!-- Side Navigation -->
        <div id="side_nav">
            <h1 class="title">HAMAREY BACHCHEY</h1>
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="Admission.php">Admission Form</a></li>
                <li><a href="Registration.php">Course Registration</a></li>
                <li><a href="Accompanying.php">Student Accompaning</a></li>
                <li><a href="Course.php">Course Enroll</a></li>
                <li><a href="Class_Change.php">Class Change</a></li>
                <li><a href="Students_Class.php">Students By Class</a></li>
                <li><a href="Class_Numbers.php">Students By Number</a></li>
                <li><a href="Dormant_Students.php">Dormant Students</a></li>
                <li><a href="Student_Search.php">Student Information</a></li>
                <li><a href="Parent_Search.php">Parent Information</a></li>
            </ul>
            <br>
        </div>

        <!-- Main Block -->
        <div id="main">
            
            <table>
                <tr>
                    <td><img src="/images/acc.jpg" width="150px" height="150px"></td>
                    <td><h1>Student Accompanying Form</h1></td>
                </tr>
            </table>
            
            <form method="POST">
                <table>

                    <h2>Student Information</h2>
                    <tr>
                        <td>ID</td>
                        <td><input type="text" name="s_id"></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="s_name"></td>
                    </tr>
                    <tr>
                        <td>Class</td>
                        <td>
                            <select>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Section</td>
                        <td>
                            <select>
                                <option>A</option>
                                <option>B</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <hr>
                <br>

                <h2>Accompanying Gaurdian Information</h2>
                <table>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="g_name"></td>
                    </tr>
                    <tr>
                        <td>Contact</td>
                        <td><input type="text" name="g_phone"></td>
                    </tr>
                    <tr>
                        <td>CNIC</td>
                        <td><input type="text" name="g_cnic"></td>
                    </tr>
                    <tr>
                        <td>Pregnant</td>
                        <td><input type="checkbox" name="g_pregnant"></td>
                    </tr>
                    <tr>
                        <td>Reason for Parent Absence</td>
                        <td><input type="text" name="g_reason"></td>
                    </tr>            
                </table>
        
                <hr>
                <br>
                <br>
                <input type="submit" name="sub_btn" value="Submit">
                <br>
                <br>

                <?php
                    if(  isset($_REQUEST["sub_btn"])  )
                    {
                        // getting student information
                        $s_id = $_REQUEST['s_id'];
                        $s_name = $_REQUEST['s_name'];

                        $s_id_query = "SELECT S_ID, DOB FROM Student WHERE S_ID = ".$s_id." AND S_Name = '".$s_name."'";
                        $query_id_s = oci_parse($con, $s_id_query); 		
                        $s_res = oci_execute($query_id_s); 
                        $s_row = oci_fetch_array($query_id_s, OCI_BOTH+OCI_RETURN_NULLS);
                        $student_id = $s_row['S_ID']; 
                        $s_dob = $s_row['DOB'];

                        if( $student_id == NULL )
                            echo "Student not found"."<br>";
                        else
                        {
                            // calculating the age of the child
                            $now = time();
                            $dob = strtotime($s_dob);
                            $difference = $now - $dob;
                            $age = floor($difference / 31556926);

                            if( age >= 4)
                                echo "Student is not younger so no need to be accompanied"."<br>";
                            else
                            {
                                $g_name = $_REQUEST['g_name'];
                                $g_cnic = $_REQUEST['g_cnic'];
                                $g_phone = $_REQUEST['g_phone'];
                                if ( $_REQUEST['g_pregnant'] == NULL)
                                    $g_pregnant = 0;
                                else
                                    $g_pregnant = 1;
                                $g_reason = $_REQUEST['g_reason'];

                                if( $g_name == NULL || $g_cnic == NULL || $g_phone == NULL || $g_reason == NULL )
                                    echo "Incomplete Information. Fill all fields"."<br>";
                                else
                                {
                                    $g_id_query = "SELECT G_ID FROM Guardian WHERE G_Name = '".$g_name."' AND Gender = 'F' AND CNIC = '".$g_cnic."'";
                                    // checking if guardian data is already in database
                                    $query_id_g = oci_parse($con, $g_id_query); 		
                                    $g_res = oci_execute($query_id_g); 
                                    $g_row = oci_fetch_array($query_id_g, OCI_BOTH+OCI_RETURN_NULLS);
                                    $guardian_id = $g_row['G_ID'];

                                    // if the guardian information was not entered before
                                    if( $guardian_id == NULL )
                                    {
                                        $g_insert = "INSERT INTO Guardian VALUES( NULL, '".$g_name."', 'F', '".$g_cnic."', '".$g_phone."')";
                                        $query_id_g_ins = oci_parse($con, $g_insert); 		
                                        $g_ins_res = oci_execute($query_id_g_ins); 
                                        
                                        $query_id_g = oci_parse($con, $g_id_query); 		
                                        $g_res = oci_execute($query_id_g); 
                                        $g_row = oci_fetch_array($query_id_g, OCI_BOTH+OCI_RETURN_NULLS);
                                        $guardian_id = $g_row['G_ID']; 
                                    }

                                    $acc_insert =  "INSERT INTO Accompanied_By VALUES(NULL, ".$student_id.", ".$guardian_id.", '".$g_reason."', ".$g_pregnant.", 0, SYSDATE )";
                                    $query_id_acc_ins = oci_parse($con, $acc_insert); 		
                                    $acc_ins_res = oci_execute($query_id_acc_ins); 

                                    oci_commit($con);
                                }
                            }
                        }
                    }
                ?>
    
            </form>

        </div>
    </body>
</html>






<style>
    #side_nav
    {
        height: 100%;
        width: 230px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: teal;
        overflow-x: hidden;
        padding-top: 20px;
    }
    
    a
    {
        text-decoration: none;
        color: white;
    }
    ul
    {
        list-style: none;
        display: inline;
    }
    li:hover
    {
        background-color: orange;
    }
    li
    {
        border-bottom-style: solid;
        border-bottom-width: 1px;
        border-bottom-color: lightgray;
        height:28px;
        color: white;
        font-size: large;
        font-family: sans-serif;
        padding: 8px;
    }
    #main
    {
        margin-left: 230px;
        padding-left: 50px;
        padding-top: 20px;
    }
    #Form_Search
    {
        font-family: sans-serif;
    }
    .search_bar
    {
        width: 300px;
        font-size: large;
    }
    .sub_btn
    {
        font-size: large;
    }
    .sel_menu
    {
        font-size: large;
    }

    form
    {
        font-family: sans-serif;
        font-size: large;
    }

    table
    {
        border-collapse:collapse;
        border-spacing: 0px;
    }

    th, td
    {
        border-bottom: 1px hidden lightgray;
        padding: 5px 10px;
    }
    .title
    {
        background-color: white;
        color: teal;
        text-align: center;
        font-family: sans-serif;
    }
    input[type="text"]
    {
        border-radius: 5px;
        border-color: lightgray;
        border-style: solid;
        background-color: lightgray;
        padding: 5px;
    }
    input[type="submit"], input[type="date"], select
    {
        font-size: large;
    }
    h1
    {
        font-family: sans-serif;
    }


</style>