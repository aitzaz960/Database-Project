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
        <title>Admission Form</title>
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
                    <td><img src="/images/school2.jpg" width="150px" height="150px"></td>
                    <td><h1>Admission Form</h1></td>
                </tr>
            </table>
            
            <!-- Data Form -->
            <form method="POST" enctype ="multipart/form-data">
                
                <!-- Table for Student Information -->
                <table>
                    <h2>Student Information</h2>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="s_name"></td>
                        <td>Photo</td>
                        <td><input type="file" name="profile_img"></td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td><input type="date" name="s_dob"></td>
                        <td>B Form Number</td>
                        <td><input type="text" name="s_bform"></td>
                    </tr>

                    <tr>
                        <td>Gender</td>
                        <td>
                            <select name="s_gender">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <hr>
                <br>

                <!-- Table for Parents Information -->
                <h2>Parents Information</h2>
                <table>
                    <tr>
                        <td>Mother Name</td>
                        <td><input type="text" name="m_name"></td>
                        <td>Father Name</td>
                        <td><input type="text" name="f_name"></td>
                    </tr>
                    <tr>
                        <td>Mother Contact</td>
                        <td><input type="text" name="m_phone"></td>
                        <td>Father Contact</td>
                        <td><input type="text" name="f_phone"></td>
                    </tr>
                    <tr>
                        <td>Mother CNIC</td>
                        <td><input type="text" name="m_cnic"></td>
                        <td>Father CNIC</td>
                        <td><input type="text" name="f_cnic"></td>
                    </tr>
                    <tr>
                        <td>Mother Email</td>
                        <td><input type="text" name="m_email"></td>
                        <td>Father Email</td>
                        <td><input type="text" name="f_email"></td>
                    </tr>
                    <tr>
                        <td>Mother Address</td>
                        <td><input type="text" name="m_address"></td>
                        <td>Father Address</td>
                        <td><input type="text" name="f_address"></td>
                    </tr>

                    <tr>
                        <td>Alive</td>
                        <td><input type="checkbox" name="m_alive"></td>
                        <td>Alive</td>
                        <td><input type="checkbox" name="f_alive"></td>
                    </tr>

                    <tr>
                        <td>Staff Memebr</td>
                        <td><input type="checkbox" name="m_staff"></td>
                        <td>Staff Member</td>
                        <td><input type="checkbox" name="f_staff"></td>
                    </tr>

                </table>
                <hr>
                <br>

                <!-- Table for Guardian Information -->
                <h2>Guardian Information</h2>
                <table>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="g_name"></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <select name="g_gender">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </td>
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
                        <td>Relation</td>
                        <td><input type="text" name="g_relation"></td>
                    </tr>
                </table>
                <hr>
                <br>

                <!-- Accompanying Guardian Information -->
                <h2>Accompaning</h2>
                <table>
                    <tr>
                        <td>Is mother Accompaning child, if child is younger</td>
                        <td>Yes</td>
                        <td><input type="radio" value="1" name="mother_acc"></td>
                        <td>No</td>
                        <td><input type="radio" value="0" name="mother_acc"></td>
                    </tr>
                    <tr>
                        <td>If mother is not alive, then add the Information of a female guardian who will accompany the child</td>
                    </tr>
                </table>
                
                <!-- Table for Accompanying Guardian Information -->
                <table>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="a_name"></td>
                    </tr>
                    <tr>
                        <td>Contact</td>
                        <td><input type="text" name="a_phone"></td>
                    </tr>
                    <tr>
                        <td>CNIC</td>
                        <td><input type="text" name="a_cnic"></td>
                    </tr>
                    <tr>
                        <td>Relation</td>
                        <td><input type="text" name="a_relation"></td>
                    </tr>
                </table>
    
                <hr>
                <br>
                <br>
                <input type="submit" name="reg_btn" value="Register">
                <br>
                <br>
    
            </form>

            <?php
            if(  isset($_REQUEST["reg_btn"])  )
            {
                // getting data of father in variables
                $f_name = $_REQUEST['f_name'];
                $f_cnic = $_REQUEST['f_cnic'];
                if( $_REQUEST['f_email'] == NULL)
                    $f_email = "NULL";
                else
                    $f_email = $_REQUEST['f_email'];
                $f_phone = $_REQUEST['f_phone'];
                $f_address = $_REQUEST['f_address'];
                if( $_REQUEST['f_staff'] == NULL)
                    $f_staff = 0;
                else
                    $f_staff = 1;
                if( $_REQUEST['f_alive'] == NULL )
                    $f_alive = 0;
                else
                    $f_alive = 1;
                
                // getting data of mother in variables
                $m_name = $_REQUEST['m_name'];
                $m_cnic = $_REQUEST['m_cnic'];
                if( $_REQUEST['m_email'] == NULL)
                    $m_email = "NULL";
                else
                    $m_email = $_REQUEST['m_email']; 
                $m_phone = $_REQUEST['m_phone'];
                $m_address = $_REQUEST['m_address'];
                if( $_REQUEST['m_staff'] == NULL)
                    $m_staff = 0;
                else
                    $m_staff = 1;
                if( $_REQUEST['m_alive'] == NULL )
                    $m_alive = 0;
                else
                    $m_alive = 1;

                // getting data of student in variables
                $s_name = $_REQUEST['s_name'];
                $s_dob = $_REQUEST['s_dob'];
                $s_bform = $_REQUEST['s_bform'];
                $s_gender = $_REQUEST['s_gender'];
                $s_photo = $_FILES['profile_img']['name'];

                // getting data of guardian in variables
                $g_name = $_REQUEST['g_name'];
                $g_gender = $_REQUEST['g_gender'];
                $g_phone = $_REQUEST['g_phone'];
                $g_cnic = $_REQUEST['g_cnic'];
                $g_relation = $_REQUEST['g_relation'];

                // if any important data is missing then display the error message
                if( $s_name == NULL || $s_dob == NULL || $s_gender == NULL || $s_photo == NULL || $s_bform == NULL ||
                    $f_name == NULL || $f_cnic == NULL || $f_phone == NULL || $f_address == NULL ||
                    $m_name == NULL || $m_cnic == NULL || $m_phone == NULL || $m_address == NULL ||
                    $g_name == NULL || $g_gender == NULL || $g_cnic == NULL || $g_relation == NULL )
                {
                    echo "Fill all the necessary fields to register"."<br>";
                }
                else
                {
                    $s_id_query = "SELECT S_ID FROM STUDENT WHERE S_Name = '".$s_name."' AND B_Form = '".$s_bform."' AND Gender = '".$s_gender."' ";
                    $query_id_s = oci_parse($con, $s_id_query); 		
                    $s_res = oci_execute($query_id_s); 
                    $s_row = oci_fetch_array($query_id_s, OCI_BOTH+OCI_RETURN_NULLS);
                    $student_id = $s_row['S_ID']; 

                    if( $student_id == NULL )
                    {
                        // find if any of student, father, mother, guardian, acommpanying guardian data is already in the database
                        $f_id_query = "SELECT P_ID FROM PARENT WHERE P_Name = '".$f_name."' AND Gender = 'M' AND CNIC = '".$f_cnic."' AND Email = '".$f_email."'";
                        $m_id_query = "SELECT P_ID FROM PARENT WHERE P_Name = '".$m_name."' AND Gender = 'F' AND CNIC = '".$m_cnic."' AND Email = '".$m_email."'";
                        $g_id_query = "SELECT G_ID FROM Guardian WHERE G_Name = '".$g_name."' AND Gender = '".$g_gender."' AND CNIC = '".$g_cnic."'";

                        // checking if father data is already in database
                        $query_id_f = oci_parse($con, $f_id_query); 		
                        $f_res = oci_execute($query_id_f); 
                        $f_row = oci_fetch_array($query_id_f, OCI_BOTH+OCI_RETURN_NULLS);
                        $father_id = $f_row["P_ID"];

                        // checking if mother data is already in database
                        $query_id_m = oci_parse($con, $m_id_query); 		
                        $m_res = oci_execute($query_id_m); 
                        $m_row = oci_fetch_array($query_id_m, OCI_BOTH+OCI_RETURN_NULLS);
                        $mother_id = $m_row['P_ID']; 

                        // checking if guardian data is already in database
                        $query_id_g = oci_parse($con, $g_id_query); 		
                        $g_res = oci_execute($query_id_g); 
                        $g_row = oci_fetch_array($query_id_g, OCI_BOTH+OCI_RETURN_NULLS);
                        $guardian_id = $g_row['G_ID']; 

                        // if the father information was not entered before
                        if( $father_id == NULL )
                        {
                            $f_insert = "INSERT INTO Parent VALUES( NULL, '".$f_name."', 'M', '".$f_cnic."', '".$f_email."', '".$f_phone."', '".$f_address."', 0, ".$f_staff.", ".$f_alive." )";
                            $query_id_f_ins = oci_parse($con, $f_insert); 		
                            $f_ins_res = oci_execute($query_id_f_ins); 
                            
                            $query_id_f = oci_parse($con, $f_id_query); 		
                            $f_res = oci_execute($query_id_f); 
                            $f_row = oci_fetch_array($query_id_f, OCI_BOTH+OCI_RETURN_NULLS);
                            $father_id = $f_row["P_ID"];
                        }

                        // if the mother information was not entered before
                        if( $mother_id == NULL )
                        {
                            $m_insert = "INSERT INTO Parent VALUES( NULL, '".$m_name."', 'F', '".$m_cnic."', '".$m_email."', '".$m_phone."', '".$m_address."', ".$father_id.", ".$m_staff.", ".$m_alive." )";
                            $query_id_m_ins = oci_parse($con, $m_insert); 		
                            $m_ins_res = oci_execute($query_id_m_ins); 

                            $query_id_m = oci_parse($con, $m_id_query); 		
                            $m_res = oci_execute($query_id_m); 
                            $m_row = oci_fetch_array($query_id_m, OCI_BOTH+OCI_RETURN_NULLS);
                            $mother_id = $m_row['P_ID']; 
                        }

                        // saving Student Information in the database
                        $s_insert = "INSERT INTO Student VALUES( NULL, '".$s_name."', '".$s_gender."', to_date('".$s_dob."', 'YYYY-MM-DD'), '".$s_bform."', ".$mother_id." ,".$father_id." , SYSDATE, 0, '".$s_photo."')";
                        $query_id_s_ins = oci_parse($con, $s_insert); 		
                        $s_ins_res = oci_execute($query_id_s_ins); 
                    
                        // saving the profile picture of the Student    
                        move_uploaded_file($_FILES['profile_img']['tmp_name'], "profile_images/".$_FILES['profile_img']['name'] );

                        // if the guardian information was not entered before
                        if( $guardian_id == NULL )
                        {
                            $g_insert = "INSERT INTO Guardian VALUES( NULL, '".$g_name."', '".$g_gender."', '".$g_cnic."', '".$g_phone."')";
                            $query_id_g_ins = oci_parse($con, $g_insert); 		
                            $g_ins_res = oci_execute($query_id_g_ins); 
                            
                            $query_id_g = oci_parse($con, $g_id_query); 		
                            $g_res = oci_execute($query_id_g); 
                            $g_row = oci_fetch_array($query_id_g, OCI_BOTH+OCI_RETURN_NULLS);
                            $guardian_id = $g_row['G_ID']; 
                        }

                        // getting the id of the student whose data is entered
                        $s_id_query = "SELECT S_ID FROM STUDENT WHERE S_Name = '".$s_name."' AND B_Form = '".$s_bform."' AND Gender = '".$s_gender."' ";
                        $query_id_s = oci_parse($con, $s_id_query); 		
                        $s_res = oci_execute($query_id_s); 
                        $s_row = oci_fetch_array($query_id_s, OCI_BOTH+OCI_RETURN_NULLS);
                        $student_id = $s_row['S_ID']; 

                        // insert the record of the guardian and student in guardain student relation table
                        $s_g_insert = "INSERT INTO Guardian_Relation VALUES(".$student_id.", ".$guardian_id.",'".$g_relation."')";
                        $query_id_sg = oci_parse($con, $s_g_insert); 		
                        $sg_res = oci_execute($query_id_sg); 

                        // calculating the age of the child
                        $now = time();
                        $dob = strtotime($s_dob);
                        $difference = $now - $dob;
                        $age = floor($difference / 31556926);
                    
                        // if the student is younger then accompaning guardian information is needed
                        if( age < 4 )
                        {
                            $mother_acc = $_REQUEST['mother_acc'];

                            if( $mother_acc == NULL )
                                echo "Accompaning Guardian Information not filled correctly"."<br>";
                            else
                            {
                                // if mother will not come with child to school
                                if( $mother_acc == 0 )
                                {
                                    // getting data of accompaning guardian in variables
                                    $a_name = $_REQUEST['a_name'];
                                    $a_phone = $_REQUEST['a_phone'];
                                    $a_cnic = $_REQUEST['a_cnic'];
                                    $a_relation = $_REQUEST['a_cnic'];

                                    $a_id_query = "SELECT G_ID FROM Guardian WHERE G_Name = '".$a_name."' AND Gender = 'F' AND CNIC = '".$a_cnic."'";
                                    $query_id_a = oci_parse($con, $a_id_query); 		
                                    $a_res = oci_execute($query_id_a); 
                                    $a_row = oci_fetch_array($query_id_a, OCI_BOTH+OCI_RETURN_NULLS);
                                    $accompany_id = $a_row['G_ID'];

                                    // Female Guardian Information is not in the database
                                    if( $accompany_id == NULL )
                                    {
                                        $a_insert = "INSERT INTO Guardian VALUES( NULL, '".$a_name."', 'F', '".$a_cnic."', '".$a_phone."')";
                                        $query_id_a_ins = oci_parse($con, $a_insert); 		
                                        $a_ins_res = oci_execute($query_id_a_ins); 

                                        $a_id_query = "SELECT G_ID FROM Guardian WHERE G_Name = '".$a_name."' AND Gender = 'F' AND CNIC = '".$a_cnic."'";
                                        $query_id_a = oci_parse($con, $a_id_query); 		
                                        $a_res = oci_execute($query_id_a); 
                                        $a_row = oci_fetch_array($query_id_a, OCI_BOTH+OCI_RETURN_NULLS);
                                        $accompany_id = $a_row['G_ID'];
                                                    
                                        $acc_insert =  "INSERT INTO Accompanied_By VALUES(NULL, ".$student_id.", ".$accompany_id.", '-', 0, 0, NULL )";
                                        $query_id_acc_ins = oci_parse($con, $acc_insert); 		
                                        $acc_ins_res = oci_execute($query_id_acc_ins); 
                                    }
                                    // Female Guardian Information is already in the database
                                    else
                                    {
                                        $acc_insert =  "INSERT INTO Accompanied_By VALUES(NULL, ".$student_id.", ".$accompany_id.", '-', 0, 0, NULL )";
                                        $query_id_acc_ins = oci_parse($con, $acc_insert); 		
                                        $acc_ins_res = oci_execute($query_id_acc_ins); 
                                    }
                                }

                                // if mother will come with child to school
                                else
                                {
                                    $acc_insert =  "INSERT INTO Accompanied_By VALUES(NULL, ".$student_id.", ".$mother_id.", '-', 0, 1, NULL )";
                                    $query_id_acc_ins = oci_parse($con, $acc_insert); 		
                                    $acc_ins_res = oci_execute($query_id_acc_ins); 
                                }
                            }
                            
                        }
                    
                        oci_commit($con);
                    }
                    else
                    {
                        echo "Student Already Registered"."<br>";
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