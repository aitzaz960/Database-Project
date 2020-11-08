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
        <title>Parent Search</title>
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
                    <td><img src="/images/parents.jpg" width="150px" height="150px"></td>
                    <td><h1>Search By Parent</h1></td>
                </tr>
            </table>
            <br>

            
            <form method="POST">
                <table>
                    <tr>
                        <td><input type="text" name="p_text"></td>
                        <td>
                            <select name="opt">
                                <option value="ID">ID</option>
                                <option value="pname">Name</option>
                            </select>
                        </td>
                        <td><input type="submit" name="search_btn" value="Search"></td>
                    </tr>
                </table>
                <hr>
                <br>
            </form>

            <?php

                if(  isset($_REQUEST["search_btn"])  )
                {
                    $p_text = $_REQUEST['p_text'];
                    $opt = $_REQUEST['opt'];
                
                    if( $p_text == NULL )
                        echo "Fill the rquired fields before search"."<br>";
                    else
                    {
                        $parents = array();
                        if( $opt == "ID" )
                        {
                            // serach parents by id
                            $all_parents = "SELECT P_ID FROM Parent WHERE P_ID = ".$p_text;
                            $query_id_all_parents = oci_parse($con, $all_parents); 		
                            $all_parents_res = oci_execute($query_id_all_parents); 
                        }
                        else if( $opt == "pname")
                        {
                            // search parents by name
                            $all_parents = "SELECT P_ID FROM Parent WHERE P_Name = '".$p_text."'";
                            $query_id_all_parents = oci_parse($con, $all_parents); 		
                            $all_parents_res = oci_execute($query_id_all_parents); 
                        }
                        
                        while( $all_parents_row = oci_fetch_array($query_id_all_parents, OCI_BOTH+OCI_RETURN_NULLS) )
                        {
                            $parents[] = $all_parents_row['P_ID'];
                        }
                        if( count($parents) == 0 )
                            echo "Parent not found"."<br>";
                        else
                        {
                            foreach ($parents as $parent) 
                            {
                                $children = array();
                                $all_children = "SELECT S_ID, S_Name FROM Student WHERE M_ID = ".$parent. " OR F_ID = ".$parent;
                                $query_id_all_children = oci_parse($con, $all_children); 		
                                $all_children_res = oci_execute($query_id_all_children); 
        
                                while( $all_children_row = oci_fetch_array($query_id_all_children, OCI_BOTH+OCI_RETURN_NULLS) )
                                {
                                    $children[] = $all_children_row;
                                }
                                if( count($children) == 0 )
                                    echo "No Children Data"."<br>";
                                else
                                {
                                    $my_data = "my_data";
                                    echo "
        
                                        <table class = 'mydata'>
                                        <tr>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Gaurdian</th>
                                        </tr> ";
        
                                    foreach ($children as $child) 
                                    {
                                        $q_g = "SELECT g.G_Name GNAME FROM Guardian g, Guardian_Relation gr WHERE gr.S_ID = ".$child['S_ID']." AND g.G_ID = gr.G_ID"; 
                                        $q_g_id = oci_parse($con, $q_g); 		
                                        $q_g_res = oci_execute($q_g_id); 
                                        $q_g_row = oci_fetch_array($q_g_id, OCI_BOTH+OCI_RETURN_NULLS);
                                        $guardian = $q_g_row['GNAME'];
                                    
                                        $q_cl = "SELECT cl.CL_Number CL_Num, cl.Section CL_Section FROM Registers r, Attends a, Class cl WHERE r.S_ID = ".$child['S_ID']." AND a.Reg_No = r.Reg_No AND cl.CL_ID = a.CL_ID";
                                        $q_cl_id = oci_parse($con, $q_cl); 		
                                        $q_cl_res = oci_execute($q_cl_id); 
                                        $q_cl_row = oci_fetch_array($q_cl_id, OCI_BOTH+OCI_RETURN_NULLS);
                                        $class = $q_cl_row['CL_NUM'];
                                        $section = $q_cl_row['CL_SECTION'];
        
                                        echo "<tr>
                                            <td>".$child['S_NAME']."</td>
                                            <td>".$class."</td>
                                            <td>".$section."</td>
                                            <td>".$guardian."</td>
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