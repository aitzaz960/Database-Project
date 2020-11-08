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
        <title>Course Registration</title>
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
                    <td><img src="/images/class.jpg" width="150px" height="150px"></td>
                    <td><h1>Course Registration</h1></td>
                </tr>
            </table>


            <?php
                // run the query to get any course whose status = 0
                $query_get_status = "SELECT * FROM Course WHERE C_Status = 0";
                $query_id_s = oci_parse($con, $query_get_status); 		
                $s_res = oci_execute($query_id_s); 
                $course = oci_fetch_array($query_id_s, OCI_BOTH+OCI_RETURN_NULLS);
                
                if( $course == NULL )
                    echo "Sorry Registrations are closed"."<br>";
                else
                {
                    echo"<h2 id='c_head'>Course Offered</h2>";
                    echo "                    
                    <table id='c_table'>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Fee</th>
                        <th>Start Date</th>
                        <th>End Date</th>

                    </tr>
                    <tr>";
                        echo"<td>".$course['C_ID']."</td>";
                        echo"<td>".$course['C_NAME']."</td>";
                        echo"<td>".$course['FEE']."</td>";
                        echo"<td>".$course['S_DATE']."</td>";
                        echo"<td>".$course['E_DATE']."</td>";
                    echo "
                    </tr>
                    </table>";
                }
            ?>

            
            <!-- Data Form -->
            <form method="POST">
                
                <!-- Table for Student Information -->
                <h2>Basic Information</h2>
                <table>
                    <tr>
                        <td>Student ID</td>
                        <td><input type="text" name="s_id"></td>
                    </tr>
                    <tr>
                        <td>Course ID</td>
                        <td><input type="text" name="c_id"></td>
                    </tr>
                    <tr>
                        <td>Challan No</td>
                        <td><input type="text" name="f_challan"></td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td><input type="text" name="f_paid"></td>
                    </tr>
                </table>
                <p><i>Note: No fee for childern of staff members. 20% off for parents with 3 or more childs. 50% off for students on finanial aid</i></p>
                <hr>
                <br>
                <input type="submit" name="reg_btn" value="Register">
                <br>
                <br>


            </form>

            <?php
                if(  isset($_REQUEST["reg_btn"])  )
                {
                    $std_id_query = "SELECT * FROM STUDENT WHERE S_ID =".$_REQUEST['s_id'];
                    $query_id_std = oci_parse($con, $std_id_query); 		
                    $std_res = oci_execute($query_id_std); 
                    $std = oci_fetch_array($query_id_std, OCI_BOTH+OCI_RETURN_NULLS);
                    $std_id = $std['S_ID']; 

                    if( $std_id == NULL )
                        echo "Student not found"."<br>";
                    else
                    {
                 
                        $query_get_course = "SELECT * FROM Course WHERE C_ID = ".$_REQUEST['c_id'];
                        $query_id_c = oci_parse($con, $query_get_course); 		
                        $c_res = oci_execute($query_id_c); 
                        $course = oci_fetch_array($query_id_c, OCI_BOTH+OCI_RETURN_NULLS);  


                        // fee check start
                        $query_f = "SELECT S_Member FROM Parent p WHERE p.P_ID = ".$std['F_ID'];
                        $query_id_f = oci_parse($con, $query_f); 		
                        $f_res = oci_execute($query_id_f); 
                        $f_row = oci_fetch_array($query_id_f, OCI_BOTH+OCI_RETURN_NULLS);  
                        $f_staff = $f_row['S_MEMBER'];

                        $query_m = "SELECT S_Member FROM Parent p WHERE p.P_ID = ".$std['M_ID'];
                        $query_id_m = oci_parse($con, $query_m); 		
                        $m_res = oci_execute($query_id_m); 
                        $m_row = oci_fetch_array($query_id_m, OCI_BOTH+OCI_RETURN_NULLS);  
                        $m_staff = $m_row['S_MEMBER'];

                        $fee = $course['FEE'];
                        $fee_issue = 0;
                        $std_case = -1;
                        if( $f_staff == 0 && $m_staff == 0 )
                        {
                            if( $_REQUEST['f_paid'] < $fee )
                            {
                                $finanial_aid = $std['F_AID'];
                                
                                $query_count = "SELECT count(S_ID) Num FROM Student WHERE M_ID = ".$std_row['M_ID'];
                                $query_id_count = oci_parse($con, $query_count); 		
                                $count_res = oci_execute($query_id_count); 
                                $count_row = oci_fetch_array($query_id_count, OCI_BOTH+OCI_RETURN_NULLS);  
                                $child_count = $count_row['NUM'];

                                if( $finanial_aid == 0 && $child_count < 3 )
                                    $fee_issue = 1;
                                else
                                {
                                    if( $finanial_aid == 1)
                                    {
                                        // 50% fee
                                        if( $_REQUEST['f_paid'] < round( $fee / 2.0) )
                                            $fee_issue = 1;
                                        else
                                            $std_case = 2;
                                    }
                                    else if( $child_count >= 3)
                                    {
                                        // 80% fee
                                        if( $_REQUEST['f_paid'] < round( 0.8 * $fee) )
                                            $fee_issue = 1;
                                        else
                                            $std_case = 3;
                                    }
                                }  
                            }
                        }
                        // fee check end
                        else
                            $std_case = 1;
                        

                        if( $fee_issue == 1)
                            echo "Fee Issue"."<br>";
                        else
                        {
                            // calculating the age of the child
                            $now = time();
                            $dob = strtotime($std['DOB']);
                            $difference = $now - $dob;
                            $age = floor($difference / 31556926);

                            $class_query = "SELECT * FROM Class WHERE Min_Age >= ".$age." AND Max_Age >= ".$age;
                            $query_id_class = oci_parse($con, $class_query); 		
                            $class_res = oci_execute($query_id_class); 
                            $c1 = oci_fetch_array($query_id_class, OCI_BOTH+OCI_RETURN_NULLS);
                            $c2 = oci_fetch_array($query_id_class, OCI_BOTH+OCI_RETURN_NULLS);
                            
                            $assigned_class = -1;
                            if( $c1['CURR_STD'] >= $c1['TOTAL_STD'] && $c1['CURR_STD'] >= $c1['TOTAL_STD'] )
                            {   }
                            else
                            { 
                                if( $course['C_MODE'] == 1)
                                {
                                    // join
                                    if( $c1['CURR_STD'] < $c1['TOTAL_STD'] )
                                        $assigned_class = $c1['CL_ID'];
                                    else if( $c2['CURR_STD'] < $c2['TOTAL_STD'] )
                                        $assigned_class = $c2['CL_ID'];                
                                }
                                else if( $course['C_MODE'] == 0)
                                {
                                    // seperate
                                    if( $std['GENDER'] == 'M')
                                    {
                                        if( $c1['CURR_STD'] < $c1['TOTAL_STD'] )
                                            $assigned_class = $c1['CL_ID'];
                                    }
                                    else
                                    {
                                        if( $c2['CURR_STD'] < $c2['TOTAL_STD'] )
                                            $assigned_class = $c2['CL_ID'];
                                    }
                                }
                            }
                            if( $assigned_class == -1 )
                                echo "No Seat Available"."<br>";
                            else
                            {
                                if( $_REQUEST['f_challan'] == NULL )
                                    $_REQUEST['f_challan'] = "NULL";
                            
                                // inserting data into Registers entity
                                $reg_query = "INSERT INTO Registers VALUES( NULL, ".$std['S_ID'].", ".$course['C_ID'].", '".$_REQUEST['f_challan']."', SYSDATE )";
                                $reg_q_id = oci_parse($con, $reg_query); 		
                                $reg_q_res = oci_execute($reg_q_id); 
                            
                                // getting the Reg_No of the newly data entered in the Registers entity
                                $get_reg = "SELECT Reg_No FROM Registers WHERE S_ID = ".$std['S_ID']." AND C_ID = ".$course['C_ID']." AND Challan_No = '".$_REQUEST['f_challan']."' AND Reg_Date = SYSDATE ";
                                $get_reg_id = oci_parse($con, $get_reg); 		
                                $get_reg_res = oci_execute($get_reg_id); 
                                $get_reg_row = oci_fetch_array($get_reg_id, OCI_BOTH+OCI_RETURN_NULLS);  
                                $reg_num = $get_reg_row['REG_NO'];

                                // inserting the values in the Fee entity
                                $discount = 0;
                                if( $std_case == 1)
                                    $discount = $fee;
                                else if( $std_case == 2 )
                                    $discount = $fee - round( $fee / 2.0 );
                                else if( $std_case == 3 )
                                    $discount = $fee - round( 0.8 * $fee);
                                
                                $fee_query = "INSERT INTO Fee_Details VALUES( ".$reg_num.", '".$_REQUEST['f_challan']."', ".$fee.", ".$_REQUEST['f_paid'].", ".$discount."  )";
                                $fee_ins = oci_parse($con, $fee_query); 		
                                $fee_ins_res = oci_execute($fee_ins); 
                        
                                // inserting the values in the Attends table
                                $class_ins_query ="INSERT INTO Attends VALUES( ".$reg_num.", ".$assigned_class.", SYSDATE, 0 )";
                                $class_ins = oci_parse($con, $class_ins_query); 		
                                $class_ins_res = oci_execute($class_ins); 

                                oci_commit($con);
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

    th
    {
        border-bottom: 1px solid lightgray;
    }



</style>