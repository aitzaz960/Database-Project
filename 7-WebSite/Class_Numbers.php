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
        <title>Class Statistics</title>
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
                    <td><img src="/images/graph.jpg" width="150px" height="150px"></td>
                    <td><h1>Class Statistics</h1></td>
                </tr>
            </table>
            <br>

            
            <!-- Data Form -->
            <form method="POST">
                
                <!-- Table for Student Information -->
                <table>
                    <tr>
                        <td><input type="text" placeholder ="search class by name" name="cl_name"></td>
                        <td><input type="submit" value ="Search" name="search_btn"></td>
                    </tr>
                </table>
                <hr>
                <br>
            </form>

            <?php

                if(  isset($_REQUEST["search_btn"])  )
                {
                    $cl_name = $_REQUEST['cl_name'];
                    echo "<h2>Classes</h2>";

                    $classes = array();
                    $all_classes = "SELECT * FROM Class WHERE CL_Name = '".$cl_name."'";
                    $query_id_all_classes = oci_parse($con, $all_classes); 		
                    $all_classes_res = oci_execute($query_id_all_classes); 
                    while( $all_classes_row = oci_fetch_array($query_id_all_classes, OCI_BOTH+OCI_RETURN_NULLS) )
                    {
                        $classes[] = $all_classes_row;
                    }
                    if( count($classes) == 0 )
                        echo "Class not found"."<br>";
                    else
                    {
                        $my_data = "my_data";
                        echo "

                            <table class = 'mydata'>
                            <tr>
                            <th>Class Name</th>
                            <th>Class Number</th>
                            <th>Section</th>
                            <th>Total Students</th>
                            <th>Current Students</th>
                            <th>Male Students</th>
                            <th>Female Students</th>
                            </tr> ";

                        foreach ($classes as $class) 
                        {
                            $q_m = "SELECT COUNT(a.Reg_No) MCount FROM Attends a, Registers r, Student s WHERE a.CL_ID = ".$class['CL_ID']." AND a.A_Status = 0 AND a.Reg_No = r.Reg_No AND r.S_ID = s.S_ID AND s.Gender = 'M' "; 
                            $q_m_id = oci_parse($con, $q_m); 		
                            $q_m_res = oci_execute($q_m_id); 
                            $q_m_row = oci_fetch_array($q_m_id, OCI_BOTH+OCI_RETURN_NULLS);
                            $m_count = $q_m_row['MCOUNT'];
                        
                            $q_f = "SELECT COUNT(a.Reg_No) FCount FROM Attends a, Registers r, Student s WHERE a.CL_ID = ".$class['CL_ID']." AND a.A_Status = 0 AND a.Reg_No = r.Reg_No AND r.S_ID = s.S_ID AND s.Gender = 'F' "; 
                            $q_f_id = oci_parse($con, $q_f); 		
                            $q_f_res = oci_execute($q_f_id); 
                            $q_f_row = oci_fetch_array($q_f_id, OCI_BOTH+OCI_RETURN_NULLS);
                            $f_count = $q_f_row['FCOUNT'];
                        
                            echo "<tr>
                                <td>".$class['CL_NAME']."</td>
                                <td>".$class['CL_NUMBER']."</td>
                                <td>".$class['SECTION']."</td>
                                <td>".$class['TOTAL_STD']."</td>
                                <td>".$class['CURR_STD']."</td>
                                <td>".$m_count."</td>
                                <td>".$f_count."</td>
                                </tr>";
                        }
            
                        echo "
                            <tr>
                            </tr>
                            </table>
                            <br>
                            <br> ";
                    }
                }
                else
                {
                    echo "<h2>Classes</h2>";

                    $classes = array();
                    $all_classes = "SELECT * FROM Class";
                    $query_id_all_classes = oci_parse($con, $all_classes); 		
                    $all_classes_res = oci_execute($query_id_all_classes); 
                    while( $all_classes_row = oci_fetch_array($query_id_all_classes, OCI_BOTH+OCI_RETURN_NULLS) )
                    {
                        $classes[] = $all_classes_row;
                    }
                    $my_data = "my_data";
                    echo "

                        <table class = 'mydata'>
                        <tr>
                        <th>Class Name</th>
                        <th>Class Number</th>
                        <th>Section</th>
                        <th>Total Students</th>
                        <th>Current Students</th>
                        <th>Male Students</th>
                        <th>Female Students</th>
                        </tr> ";

                    foreach ($classes as $class) 
                    {
                        $q_m = "SELECT COUNT(a.Reg_No) MCount FROM Attends a, Registers r, Student s WHERE a.CL_ID = ".$class['CL_ID']." AND a.A_Status = 0 AND a.Reg_No = r.Reg_No AND r.S_ID = s.S_ID AND s.Gender = 'M' "; 
                        $q_m_id = oci_parse($con, $q_m); 		
                        $q_m_res = oci_execute($q_m_id); 
                        $q_m_row = oci_fetch_array($q_m_id, OCI_BOTH+OCI_RETURN_NULLS);
                        $m_count = $q_m_row['MCOUNT'];
                    
                        $q_f = "SELECT COUNT(a.Reg_No) FCount FROM Attends a, Registers r, Student s WHERE a.CL_ID = ".$class['CL_ID']." AND a.A_Status = 0 AND a.Reg_No = r.Reg_No AND r.S_ID = s.S_ID AND s.Gender = 'F' "; 
                        $q_f_id = oci_parse($con, $q_f); 		
                        $q_f_res = oci_execute($q_f_id); 
                        $q_f_row = oci_fetch_array($q_f_id, OCI_BOTH+OCI_RETURN_NULLS);
                        $f_count = $q_f_row['FCOUNT'];
                    
                        echo "<tr>
                            <td>".$class['CL_NAME']."</td>
                            <td>".$class['CL_NUMBER']."</td>
                            <td>".$class['SECTION']."</td>
                            <td>".$class['TOTAL_STD']."</td>
                            <td>".$class['CURR_STD']."</td>
                            <td>".$m_count."</td>
                            <td>".$f_count."</td>
                            </tr>";
                    }
        
                    echo "
                        <tr>
                        </tr>
                        </table>
                        <br>
                        <br> ";
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