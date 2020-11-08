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
        <title>Class Change</title>
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
            
            <!-- Form Title -->
            <table>
                <tr>
                    <td><img src="/images/corridor.jpg" width="150px" height="150px"></td>
                    <td><h1>Class Change</h1></td>
                </tr>
            </table>
            <br>

            <hr>
            <!-- Data Form -->
            <form method="POST">
                
                <!-- Table for Student Information -->
                <table>
                    <tr>
                        <td>ID</td>
                        <td><input type="text" name="s_id"></td>
                    </tr>
                    <tr>
                        <td>Course</td>
                        <td><input type="text" name="c_id"></td>
                    </tr>
                    <tr>
                        <td>Current Class</td>
                        <td><input type="text" name="o_cl_id"></td>
                    </tr>
                    <tr>    
                        <td>Section</td>
                        <td><input type="text" name="o_cl_sec"></td>
                    </tr>
                    <tr>
                        <td>New Class</td>
                        <td><input type="text" name="n_cl_id"></td>
                    </tr>
                    <tr>
                        <td>Section</td>
                        <td><input type="text" name="n_cl_sec"></td>
                    </tr>
                    <tr>
                        <td>Reason for Change</td>
                        <td><input type="text" name="reason"></td>
                    </tr>
                    <tr>
                        <td>Approved By</td>
                        <td><input type="text" name="approved"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="chg_btn" value="Change"></td>
                    </tr>
                </table>
            </form>

            <?php

                if(  isset($_REQUEST["chg_btn"])  )
                {
                    $q_r = "SELECT DISTINCT a.Reg_No Reg FROM Student s, Registers r, Attends a, Class cl WHERE r.S_ID = ".$_REQUEST['s_id']."  
                    and r.C_ID = ".$_REQUEST['c_id']." and a.Reg_No = r.Reg_No and cl.CL_ID = a.CL_ID and cl.CL_Number=".$_REQUEST['o_cl_id']." and
                    cl.Section = '".$_REQUEST['o_cl_sec']."'";
                    $query_id_r = oci_parse($con, $q_r); 		
                    $r_res = oci_execute($query_id_r); 
                    $r_row = oci_fetch_array($query_id_r, OCI_BOTH+OCI_RETURN_NULLS);
                    $Reg = $r_row['REG'];

                    if( $Reg == NULL )
                        echo "Data not found"."<br>";
                    else
                    {
                        $q_a = "SELECT Trunc( ((SYSDATE - DOB)/356.0) + 1 ) Age From Student Where S_ID =".$_REQUEST['s_id'];
                        $query_id_a = oci_parse($con, $q_a); 		
                        $a_res = oci_execute($query_id_a); 
                        $a_row = oci_fetch_array($query_id_a, OCI_BOTH+OCI_RETURN_NULLS);
                        $age = $a_row['AGE'];

                        $q_c = "SELECT C_Mode Nature From Course Where C_ID =".$_REQUEST['c_id'];
                        $query_id_c = oci_parse($con, $q_c); 		
                        $c_res = oci_execute($query_id_c); 
                        $c_row = oci_fetch_array($query_id_c, OCI_BOTH+OCI_RETURN_NULLS);
                        $c_type = $c_row['NATURE'];

                        if( $age > 14 and $c_type = 0 )
                            echo "Class Change not Possible"."<br>";
                        else
                        {
                            $q_cl1 = "SELECT CL_ID From Class WHERE CL_Number =".$_REQUEST['o_cl_id']." and Section ='".$_REQUEST['o_cl_sec']."'";
                            $query_id_cl1 = oci_parse($con, $q_cl1); 		
                            $cl1_res = oci_execute($query_id_cl1); 
                            $cl1_row = oci_fetch_array($query_id_cl1, OCI_BOTH+OCI_RETURN_NULLS);
                            $cl_id_old= $cl1_row['CL_ID'];

                            $q_cl = "SELECT CL_ID From Class WHERE CL_Number =".$_REQUEST['n_cl_id']." and Section ='".$_REQUEST['n_cl_sec']."'";
                            $query_id_cl = oci_parse($con, $q_cl); 		
                            $cl_res = oci_execute($query_id_cl); 
                            $cl_row = oci_fetch_array($query_id_cl, OCI_BOTH+OCI_RETURN_NULLS);
                            $cl_id_new= $cl_row['CL_ID'];

                            $q_u = "UPDATE Attends Set CL_ID = ".$cl_id_new.", Alloc_Date = SYSDATE WHERE Reg_No = ".$Reg;
                            $query_id_u = oci_parse($con, $q_u); 		
                            $u_res = oci_execute($query_id_u); 
            
                            $q_ins = "INSERT INTO Class_Chg_Hist VALUES( ".$Reg.", NULL, ".$cl_id_old.", ".$cl_id_new.", SYSDATE, '".$_REQUEST['reason']."', '".$_REQUEST['approved']."' )";
                            $query_id_ins = oci_parse($con, $q_ins); 		
                            $ins_res = oci_execute($query_id_ins); 
                            
                            oci_commit($con);
                        }
                    }
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
        background-color:orange;
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
        font-family: sans-serif;
        font-size: large;
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
        font-size: large;
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

    .mydata td,
    .mydata th
    {
        border-bottom: 1px solid lightgray;
    }
</style>