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
        <title>Student Search</title>
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
            
            <table>
                <tr>
                    <td><img src="/images/student1.jpg" width="150px" height="150px"></td>
                    <td><h1>Search By Student</h1></td>
                </tr>
            </table>
            
            <form method="POST">
                <table>
                    <tr>
                        <td><input type="text" name="std"></td>
                        <td>
                            <select name="opt">
                                <option value="ID">ID</option>
                                <option value="name">Name</option>
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
                    if( $_REQUEST['std'] == NULL )
                        echo "Enter a student ID or name"."<br>";
                    else
                    {
                        $students = array();
                        if( $_REQUEST['opt'] == "ID" )
                        {
                            $q_s = "SELECT * FROM Student WHERE S_ID = ".$_REQUEST['std'];
                            $q_s_id = oci_parse($con, $q_s); 		
                            $q_s_res = oci_execute($q_s_id); 
                            while( $q_s_row = oci_fetch_array($q_s_id, OCI_BOTH+OCI_RETURN_NULLS) )
                                $students[] = $q_s_row;
                        }
                        else if( $_REQUEST['opt'] == "name" )
                        {
                            $q_s = "SELECT * FROM Student WHERE S_Name = '".$_REQUEST['std']."'";
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
                            foreach ($students as $student) 
                            {
                                // getting mother name
                                $q_m = "SELECT P_Name mother FROM Parent WHERE P_ID = ".$student['M_ID'];
                                $query_id_m = oci_parse($con, $q_m); 		
                                $m_res = oci_execute($query_id_m); 
                                $m_row = oci_fetch_array($query_id_m, OCI_BOTH+OCI_RETURN_NULLS);
                                $mother = $m_row['MOTHER'];

                                // getting father name
                                $q_f = "SELECT P_Name father FROM Parent WHERE P_ID = ".$student['F_ID'];
                                $query_id_f = oci_parse($con, $q_f); 		
                                $f_res = oci_execute($query_id_f); 
                                $f_row = oci_fetch_array($query_id_f, OCI_BOTH+OCI_RETURN_NULLS);
                                $father = $f_row['FATHER'];

                                $q_g = "SELECT g.G_Name guard FROM Guardian g, Guardian_Relation gr WHERE gr.S_ID = ".$student['S_ID']." AND g.G_ID = gr.G_ID";
                                $query_id_g = oci_parse($con, $q_g); 		
                                $g_res = oci_execute($query_id_g); 
                                $g_row = oci_fetch_array($query_id_g, OCI_BOTH+OCI_RETURN_NULLS);
                                $guardian = $g_row['GUARD'];

                                echo "  <table class = 'mydata'>
                                            <tr>
                                                <th>ID:</th>
                                                <td>".$student['S_ID']."</td>
                                                <th>Name:</th>
                                                <td>".$student['S_NAME']."</td>
                                            </tr>
                                        </table>";

                                echo "  <table class = 'mydata'>
                                            <tr>
                                                <th>Father:</th>
                                                <td>".$father."</td>
                                                <th>Mother:</th>
                                                <td>".$mother."</td>
                                                <th>Guardian:</th>
                                                <td>".$guardian."</td>
                                            </tr>
                                        </table><br>";

                                $siblings = array();
                                $q_sb ="SELECT * FROM Student WHERE S_ID != ".$student['S_ID']." AND M_ID = ".$student['M_ID']." AND F_ID = ".$student['F_ID'];
                                $q_sb_id = oci_parse($con, $q_sb); 		
                                $q_sb_res = oci_execute($q_sb_id); 
                                while( $q_s_row = oci_fetch_array($q_sb_id, OCI_BOTH+OCI_RETURN_NULLS) )
                                    $siblings[] = $q_s_row;

                                if( count($siblings) == 0 )
                                    echo "<table class = 'mydata'>
                                            <tr>
                                                <td>No Siblings</td>
                                            </tr>
                                            ";
                                else
                                {
                                    echo "<table class = 'mydata'>
                                            <tr>
                                                <th>ID</th>
                                                <th>Siblings</th>
                                            </tr>
                                            ";
                                    foreach ($siblings as $sibling) 
                                    {   
                                        echo "<tr>
                                                <td>".$sibling['S_ID']."</td>
                                                <td>".$sibling['S_NAME']."</td>
                                            </tr>";
                                    }
                                    echo "</table>";
                                    echo "<br>";
                                }

                                $changes = array();
                                $q_ch = "SELECT DISTINCT r.Reg_No Reg, c.C_Name CName, r.Reg_Date RDate, r.Challan_No Challan FROM Student s, Course c, Registers r WHERE r.S_ID = ".$student['S_ID']." AND c.C_ID = r.C_ID";
                                $q_ch_id = oci_parse($con, $q_ch); 		
                                $q_ch_res = oci_execute($q_ch_id); 
                                while( $q_ch_row = oci_fetch_array($q_ch_id, OCI_BOTH+OCI_RETURN_NULLS) )
                                    $changes[] = $q_ch_row;

                                if( count($changes) == 0 )
                                    echo "No Course"."<br>";
                                else
                                {
                                    echo   "<table class = 'mydata'>
                                            <tr>
                                                <th>Reg No</th>
                                                <th>Course</th>
                                                <th>Reg Date</th>
                                                <th>Challan No</th>
                                            </tr>
                                            ";
                                    foreach ($changes as $change) 
                                    {   
                                        echo "<tr>
                                                <td>".$change['REG']."</td>
                                                <td>".$change['CNAME']."</td>
                                                <td>".$change['RDATE']."</td>
                                                <td>".$change['CHALLAN']."</td>
                                            </tr>";
                                    }
                                    echo "</table>";
                                    echo "<br><br>";
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

</style>