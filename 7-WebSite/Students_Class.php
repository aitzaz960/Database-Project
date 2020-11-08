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
        <title>Classes with Students</title>
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
                    <td><img src="/images/group_students.jpg" width="150px" height="150px"></td>
                    <td><h1>Students</h1></td>
                </tr>
            </table>
            <br>

            
            <form method="POST">
                <table>
                    <tr>
                        <td><input type="text" name="s_text"></td>
                        <td>
                            <select name="opt">
                                <option value="ID">ID</option>
                                <option value="sname">Name</option>
                            </select>
                        </td>
                        <td><input type="submit" name="search_btn" value="Search"></td>
                    </tr>
                </table>
            </form>

            <a href ="Admission.php" class="add">Add Student</a>
            
            <hr>
            <br>

            <?php

                if(  isset($_REQUEST["search_btn"])  )
                {
                }
                else
                {
                    echo "<h2>Classes</h2>";

                    $classes = array();
                    $all_classes = "SELECT * FROM Class";
                    $query_id_all_classes = oci_parse($con, $all_classes); 		
                    $all_classes_res = oci_execute($query_id_all_classes); 
                    while( $all_classes_row = oci_fetch_array($query_id_all_classes, OCI_BOTH+OCI_RETURN_NULLS) )
                        $classes[] = $all_classes_row;
                    if( count($classes) == 0 )
                        echo "Class not found"."<br>";
                    else
                    {
                        $my_data = "my_data";
                        foreach ($classes as $class) 
                        {
                            if( $class['CURR_STD'] != 0 )
                            {
                                echo "<table>
                                    <tr>
                                    <td><h4>CLass:".$class['CL_NUMBER']."</h4><td>
                                    <td><h4>Section:".$class['SECTION']."</h4></td>
                                    <td><h4>[".$class['CL_NAME']."]</h4></td>
                                    <td><h4>Total: ".$class['CURR_STD']."</h4></td>
                                    </tr>
                                    </table>
                                    <hr> ";
                                $students = array();

                                // display students    
                                $q_s = "SELECT S_ID ID, S_Name SNAME, Trunc( ((SYSDATE - DOB)/356.0) + 1 ) Age, Gender MF FROM Student WHERE S_ID IN (
                                        SELECT S_ID FROM Registers WHERE Reg_No IN ( 
                                        SELECT Reg_No FROM Attends WHERE A_Status = 0 AND CL_ID = ".$class['CL_ID']." ))";

                                $q_s_id = oci_parse($con, $q_s); 		
                                $q_s_res = oci_execute($q_s_id); 
                                while( $q_s_row = oci_fetch_array($q_s_id, OCI_BOTH+OCI_RETURN_NULLS) )
                                    $students[] = $q_s_row;
                                
                                if( count($students) == 0 )
                                    echo "<br>";
                                else
                                {
                                    $my_data = "my_data";
                                    echo "<table class = 'mydata'>";
                    
                                    foreach ($students as $student) 
                                    {
                                        echo " <tr>
                                                <form method='GET', action='Delete.php'>
                                                <td width='80px'>ID: ".$student['ID']."</td>
                                                <td width='250px'>Name: ".$student['SNAME']."</td>
                                                <td width='150px'>Age(years): ".$student['AGE']."</td>
                                                <td width='150px'>Gender: ".$student['MF']."</td>
                                                <input type='hidden' name='std_id' value='".$student['ID']."'>
                                                <td><input type='submit' value='Edit' class='edit_btn' name ='edit_btn'></td>
                                                <td><input type='submit' value='Delete' class='del_btn' name='del_btn'></td>
                                                </form>
                                                </tr>";                            
                                    }
                                    echo "</table>
                                        <br><br><br>";
                                }
                            }
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

    .edit_btn:hover
    {
        color: white;
        background-color: green;
        border-color: teal;
    }

    .del_btn:hover
    {
        color: white;
        background-color: red;
        border-color: red;
    }
    .add
    {
        background-color: orange;
        color: white;
        padding: 7px;
    }

</style>