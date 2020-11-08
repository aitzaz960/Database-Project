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
        <title>Editing</title>
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
                    <td><img src="/images/setting.jpg" width="150px" height="150px"></td>
                    <td><h1>Edit Record</h1></td>
                </tr>
            </table>

            <?php       
            
                if( isset($_REQUEST['edit_btn'] ))
                {            
                    $q_s = "SELECT * FROM Student WHERE S_ID=".$_REQUEST['std_id'];
                    $q_s_id = oci_parse($con, $q_s); 		
                    $q_s_res = oci_execute($q_s_id); 
                    $q_s_row = oci_fetch_array($q_s_id, OCI_BOTH+OCI_RETURN_NULLS);
                    $student = $q_s_row;

                    echo " <form>
                            <input type='hidden' name='std' value='".$student['S_ID']."'>
                            <table>
                                <tr>
                                    <td>Name</td>
                                    <td><input type='text' value='".$student['S_NAME']."' name='sname' ></td>
                                </tr>
                                <tr>
                                    <td>B Form</td>
                                    <td><input type='text' value='".$student['B_FORM']."' name='sbform' ></td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td><input type='text' value='".$student['GENDER']."' name='sgender' ></td>
                                </tr>
                                <tr>
                                    <td><input type='submit' name='chg_btn' value='Change' ></td>
                                </tr>
                            </table>
                        </form>";

                }

                if( isset($_REQUEST['del_btn'] ))
                {    
                    // deleting data of student from Class Change History table
                    $q_cch = "DELETE FROM Class_Chg_Hist WHERE Reg_No IN ( SELECT Reg_No FROM Registers WHERE S_ID = ".$_REQUEST['std_id']." )";
                    $query_id_cch = oci_parse($con, $q_cch); 		
                    $cch_res = oci_execute($query_id_cch); 

                    // deleting data of student from Attends
                    $q_a ="DELETE FROM Attends WHERE Reg_No IN ( SELECT Reg_No FROM Registers WHERE S_ID = ".$_REQUEST['std_id']." )";
                    $query_id_a = oci_parse($con, $q_a); 		
                    $a_res = oci_execute($query_id_a); 

                    // deleting data of student from Fee
                    $q_fee ="DELETE FROM Fee_Details WHERE Reg_No IN ( SELECT Reg_No FROM Registers WHERE S_ID = ".$_REQUEST['std_id']." )";
                    $query_id_fee = oci_parse($con, $q_fee); 		
                    $fee_res = oci_execute($query_id_fee); 

                    // deleting data of student from Registers
                    $q_r ="DELETE FROM Registers WHERE S_ID = ".$_REQUEST['std_id'];
                    $query_id_r = oci_parse($con, $q_r); 		
                    $r_res = oci_execute($query_id_r); 

                    // deleting Student data 
                    $q_sh = "DELETE FROM Student_History WHERE S_ID = ".$_REQUEST['std_id'];
                    $query_id_sh = oci_parse($con, $q_sh); 		
                    $sh_res = oci_execute($query_id_sh); 
        
                    // getting the student information for mother, father etc
                    $q_st = "SELECT * FROM Student WHERE S_ID =  ".$_REQUEST['std_id'];
                    $query_id_st = oci_parse($con, $q_st); 		
                    $st_res = oci_execute($query_id_st); 
                    $st_row = oci_fetch_array($query_id_st, OCI_BOTH+OCI_RETURN_NULLS);
                    $std = $st_row;

                    // check if there are siblings                    
                    $q_sb = "SELECT * FROM Student WHERE S_ID != ".$std['S_ID']." and M_ID = ".$std['M_ID']." and F_ID = ".$std['F_ID'];
                    $query_id_sb = oci_parse($con, $q_sb); 		
                    $sb_res = oci_execute($query_id_sb); 
                    $sb_row = oci_fetch_array($query_id_sb, OCI_BOTH+OCI_RETURN_NULLS);
                    $sb = $sb_row['CL_ID'];

                    // delete parents information if no siblings
                    if( $sb == NULL )
                    {
                        $q_phd ="DELETE FROM Parent_History WHERE P_ID IN ( ".$std['F_ID'].", ".$std['M_ID'].")";
                        $query_id_phd = oci_parse($con, $q_phd); 		
                        $phd_res = oci_execute($query_id_phd); 

                        $q_pd ="DELETE FROM Parent WHERE P_ID IN ( ".$std['F_ID'].", ".$std['M_ID'].")";
                        $query_id_pd = oci_parse($con, $q_pd); 		
                        $pd_res = oci_execute($query_id_pd); 
                    }

                    // getting guardian information
                    $q_g = "SELECT G_ID FROM Guardian_Relation WHERE S_ID = ".$std['S_ID'];
                    $query_id_g = oci_parse($con, $q_g); 		
                    $g_res = oci_execute($query_id_g); 
                    $g_row = oci_fetch_array($query_id_g, OCI_BOTH+OCI_RETURN_NULLS);
                    $guardian = $g_row['G_ID'];

                    // check if guardian is guardian of others
                    $q_rec = "SELECT S_ID FROM Guardian_Relation WHERE S_ID != ".$std['S_ID']." and G_ID = ".$guardian;
                    $query_id_rec = oci_parse($con, $q_rec); 		
                    $rec_res = oci_execute($query_id_rec); 
                    $rec_row = oci_fetch_array($query_id_rec, OCI_BOTH+OCI_RETURN_NULLS);
                    $nrec = $rec_row['S_ID'];

                    // deleting guardian data
                    if( $nrec == NULL )
                    {
                        $q_gh = "DELETE FROM Guardian_History WHERE G_ID = ".$guardian;
                        $query_id_gh = oci_parse($con, $q_gh); 		
                        $gh_res = oci_execute($query_id_gh); 

                        $q_gu = "DELETE FROM Guardian WHERE G_ID = ".$guardian;
                        $query_id_gu = oci_parse($con, $q_gu); 		
                        $gu_res = oci_execute($query_id_gu); 
                    }

                    $q_gr = "DELETE FROM Guardian_Relation WHERE S_ID = ".$std['S_ID'];
                    $query_id_gr = oci_parse($con, $q_gr); 		
                    $gr_res = oci_execute($query_id_gr); 

                    // deleting Accompanied By data
                    $q_ag = "DELETE FROM Guardian WHERE G_ID IN ( SELECT G_ID FROM Accompanied_By WHERE S_ID = ".$std['S_ID'].") ";
                    $query_id_ag = oci_parse($con, $q_ag); 		
                    $ag_res = oci_execute($query_id_ag); 

                    $q_acc ="DELETE FROM Accompanied_By WHERE S_ID = ".$std['S_ID'];
                    $query_id_acc = oci_parse($con, $q_acc); 		
                    $acc_res = oci_execute($query_id_acc); 

                    // delete student information
                    $q_dst = "DELETE FROM Student WHERE S_ID = ".$std['S_ID'];
                    $query_id_dst = oci_parse($con, $q_dst); 		
                    $dst_res = oci_execute($query_id_dst); 
                
                    echo "Record Deleted"."<br>";
                    oci_commit($con);
                
                } 
            ?>

            <?php

                if( isset($_REQUEST['chg_btn'] ))
                {
                    $q_s = "SELECT * FROM Student WHERE S_ID=".$_REQUEST['std'];
                    $q_s_id = oci_parse($con, $q_s); 		
                    $q_s_res = oci_execute($q_s_id); 
                    $q_s_row = oci_fetch_array($q_s_id, OCI_BOTH+OCI_RETURN_NULLS);
                    $student = $q_s_row;

                    if( $student['S_NAME'] != $_REQUEST['sname'] || $student['B_FORM'] != $_REQUEST['sbform'] || $student['GENDER'] != $_REQUEST['sgender']  )
                    {
                        $q_u = "UPDATE Student SET S_Name = '".$_REQUEST['sname']."', B_Form = ".$_REQUEST['sbform'].", Gender = '".$_REQUEST['sgender']."' WHERE S_ID = ".$student['S_ID'];
                        $query_id_u = oci_parse($con, $q_u); 		
                        $u_res = oci_execute($query_id_u); 

                        echo "Changes Made"."<br>";

                        oci_commit($con);
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