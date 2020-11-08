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
        <title>Add Course</title>
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


        <div id="main">
            
            <table>
                <tr>
                    <td><img src="/images/std_lab.jpg" width="150px" height="150px"></td>
                    <td><h1>Add Course</h1></td>
                </tr>
            </table>
            
            <form method="POST">
                <table>

                    <h2>Course Information</h2>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="c_name"></td>
                    </tr>
                    <tr>
                        <td>Details</td>
                        <td><input type="text" name="c_details"></td>
                    </tr>  
                    <tr>
                        <td>Fee</td>
                        <td><input type="text" name="c_fee"></td>
                    </tr> 
                    <tr>
                        <td>Start Date</td>
                        <td><input type="date" name="c_start"></td>
                    </tr>  
                    <tr>
                        <td>End_Date</td>
                        <td><input type="date" name="c_end"></td>
                    </tr> 
                    <tr>
                        <td>Mode</td>
                        <td>
                            <select name="c_mode">
                                <option value="1">Join</option>
                                <option value="0">Seperate</option>
                            </select>
                        </td>
                    </tr>                     
                </table>
                <br>
                <input type="submit" name="add_btn" value="Add Course">
                
            </form>
            
            <hr>
            <br>
            
            <form method="POST">
                <table>
                    <tr>
                        <td>Update Status of Courses whose End Date has been passed</td>
                        <td><input type="submit" value="Update" name="update_btn"></td>
                    </tr>
                </table>
            </form>

            <hr>
            <br>
            
            <form method="POST">
                <table>
                    <tr>
                        <td>Update Status of Students who have passed the Course</td>
                        <td><input type="submit" value="Update" name="update_std_btn"></td>
                    </tr>
                </table>
            </form>

            <?php

                // Add Course
                if(  isset($_REQUEST["add_btn"])  )
                {
                    // run the query to get any course whose status = 0
                    $query_get_status = "SELECT C_ID FROM Course WHERE C_Status = 0";
                    $query_id_s = oci_parse($con, $query_get_status); 		
                    $s_res = oci_execute($query_id_s); 
                    $s_row = oci_fetch_array($query_id_s, OCI_BOTH+OCI_RETURN_NULLS);
                    $course_s = $s_row["C_ID"];
                    
                    // if course if found it means that the course is not been completed
                    if( $course_s != NULL )
                        echo "Another Course is already being offered or update the status of previous courses to add a new course"."<br>";
                    else
                    {
                        // get the entered course information in variables
                        $c_name = $_REQUEST['c_name'];
                        $c_details = $_REQUEST['c_details'];
                        $c_fee = $_REQUEST['c_fee'];
                        $c_start = $_REQUEST['c_start'];
                        $c_end = $_REQUEST['c_end'];
                        $c_mode = $_REQUEST['c_mode'];

                        // check if all the information is entered correctly
                        if( $c_name == NULL || $c_details == NULL || $c_fee == NULL || $c_start == NULL || $c_end == NULL || $c_mode == NULL )
                            echo "Fill all the required fields"."<br>";
                        else
                        {
                            // run the query to get the offer no of the course
                            $query_num = "SELECT max(Offer_No) Off_No from Course WHERE C_Name = '".$c_name."' ";
                            $query_id_n = oci_parse($con, $query_num); 		
                            $n_res = oci_execute($query_id_n); 
                            $n_row = oci_fetch_array($query_id_n, OCI_BOTH+OCI_RETURN_NULLS);
                            $course_n = $n_row["OFF_NO"];

                            // increment the offer number
                            if( $course_n == NULL )
                                $course_n = 1;
                            else
                                $course_n = $course_n + 1;
                            
                            // insert the course in the database
                            $query_ins = "INSERT INTO Course VALUES( NULL, ".$course_n." ,'".$c_name."', '".$c_details."', ".$c_fee.", to_date('".$c_start."', 'YYYY-MM-DD'), to_date('".$c_end."', 'YYYY-MM-DD'), 0, ".$c_mode." )";
                            $query_id_ins = oci_parse($con, $query_ins); 		
                            $ins_res = oci_execute($query_id_ins); 
                                  
                            oci_commit($con);
                        }
                    }
                }

                // Update Course Status
                if(  isset($_REQUEST["update_btn"])  )
                {
                    $query_update = "UPDATE Course SET C_Status = 1 WHERE E_Date < SYSDATE";
                    $query_id_u = oci_parse($con, $query_update); 		
                    $u_res = oci_execute($query_id_u); 

                    oci_commit($con);
                }


                // Update Student Status
                if(  isset($_REQUEST["update_std_btn"])  )
                {
                    $query_update_2 = "UPDATE Attends SET A_Status = 1 WHERE Reg_No IN (
                        SELECT r.Reg_No FROM Registers r, Course c where r.C_ID = c.C_ID and c.E_Date < SYSDATE )";
                    $query_id_u_2 = oci_parse($con, $query_update_2); 		
                    $u_2_res = oci_execute($query_id_u_2); 

                    oci_commit($con);
                }

            ?>


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