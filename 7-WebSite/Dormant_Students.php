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
        <title>Dormant Students</title>
    </head>
    
    <body>
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
            
             <!-- Form Title -->
             <table>
                <tr>
                    <td><img src="/images/sleeping_kid.jpg" width="150px" height="150px"></td>
                    <td><h1>Dormant Students</h1></td>
                </tr>
            </table>
            <br>
            
            <form method="POST">
                <table>
                    <tr>
                        <td><input type="text" name="time"></td>
                        <td>
                            <select name="opt">
                                <option value="Months">Months</option>
                                <option value="Years">Years</option>
                            </select>
                        </td>
                        <td><input type="submit" value="Search" name="search_btn"></td>
                    </tr>
                </table>
                <hr>
                <br>
            </form>
            
            <?php 
                if(  isset($_REQUEST["search_btn"])  )
                {
                    if( $_REQUEST['time'] == NULL )
                        echo "Enter months or years to continue"."<br>";
                    else
                    {
                        $students = array();
                        if( $_REQUEST['opt'] == "Months" )
                        {
                            $q_s = "SELECT * FROM Student WHERE S_ID IN (
                                SELECT S_ID FROM Registers
                                HAVING Trunc(MONTHS_BETWEEN(SYSDATE, max(Reg_Date)) ) >= ".$_REQUEST['time']." GROUP BY S_ID
                                )";
                            $q_s_id = oci_parse($con, $q_s); 		
                            $q_s_res = oci_execute($q_s_id); 
                            while( $q_s_row = oci_fetch_array($q_s_id, OCI_BOTH+OCI_RETURN_NULLS) )
                                $students[] = $q_s_row;
                        }
                        else if( $_REQUEST['opt'] == "Years" )
                        {
                            $q_s = "SELECT * FROM Student WHERE S_ID IN (
                                SELECT S_ID FROM Registers HAVING Trunc((SYSDATE - max(Reg_Date))/365 ) >= ".$_REQUEST['time']." GROUP BY S_ID
                                )";
                            $q_s_id = oci_parse($con, $q_s); 		
                            $q_s_res = oci_execute($q_s_id); 
                            while( $q_s_row = oci_fetch_array($q_s_id, OCI_BOTH+OCI_RETURN_NULLS) )
                                $students[] = $q_s_row;
                        }

                        if( count($students) == 0 )
                            echo "No Student found"."<br>";
                        else
                        {
                            $my_data = "my_data";
                            echo "<table class = 'mydata'>";

                            echo "
                                <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Photo</th>
                                </tr>";  

                            foreach ($students as $student) 
                            {
                                echo "  <tr>
                                        <td>".$student['S_ID']."</td>
                                        <td>".$student['S_NAME']."</td>
                                        <td>".$student['GENDER']."</td>
                                        <td>".$student['DOB']."</td>
                                        <td><img width='100px' height='100px' src='/profile_images/".$student['PHOTO']."'></td>
                                        </tr>";                            
                            }
                            echo "</table>
                                <br><br><br>";
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