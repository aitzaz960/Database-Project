-- SQL Queries

-- 1
-- A list of all students
SELECT * FROM Student;

-- 2
--A list of all mothers and their spouses
SELECT p1.p_Name "Mother", p2.p_Name "Husband"
FROM Parent p1, Parent p2
WHERE p1.Spouse = p2.P_ID;

-- 3
-- A list of all guardians, grouped by relation to students (show students as well)
Select gr.Relation "Relation", g.G_Name Guardian, s.S_Name Student
From Guardian_Relation gr, Guardian g, Student s
Where gr.S_ID = s.S_ID and g.G_ID = gr.G_ID
order by  gr.Relation, g.G_Name;

-- 4
--A list of parents and their children
SELECT p1.P_Name "Father Name", p2.P_Name "Mother Name", s.S_Name "Child Name"
From Student s, Parent p1, Parent p2
Where s.F_ID = p1.P_ID and s.M_ID = p2.P_ID
order by p1.P_Name, p2.P_Name;

-- 5
-- A list of all students with siblings taking classes, grouped by class
Select cl.CL_Number "Class", cl.Section "Section", s1.S_Name "Student", s2.S_Name "Sibling"
From Student s1, Student s2, Registers r1, Registers r2, Attends a1, Attends a2, Class cl  
Where (s1.F_ID = s2.F_ID and s1.M_ID = s2.M_ID and s1.S_ID != s2.S_ID)
and ( r1.S_ID = s1.S_ID and r2.S_ID = s2.S_ID )
and ( a1.Reg_No = r1.Reg_No and a2.Reg_No = r2.Reg_No )
and ( a1.CL_ID = a2.CL_ID )
and ( a1.A_Status = 0 and a1.CL_ID = cl.CL_ID )
order by cl.CL_Number, cl.Section;

-- 6
-- A list of all students who have been assigned to a new class in the given time span (use check for including or ignoring new admissions)
-- ignoring new admission
Select s.S_Name "Student_Name"
from Student s, Registers r, Attends a
where r.S_ID = s.S_ID and a.Reg_No = r.Reg_No
and a.Alloc_Date >= to_date( '&Start_Date' ,'DD-MM-YYYY')
and a.Alloc_Date <= to_date( '&End_Date' ,'DD-MM-YYYY');

-- including new admission
Select s.S_Name "Student_Name"
from Student s, Registers r, Attends a
where r.S_ID = s.S_ID and a.Reg_No = r.Reg_No
and a.Alloc_Date >= to_date('&Start_Date','DD-MM-YYYY')
and a.Alloc_Date >= to_date('&End_Date','DD-MM-YYYY')
and s.Admission_Date >= to_date('&Admission_Date', 'DD-MM-YYYY');

--7
-- A list of all new students in given time span grouped by class
Select cl.CL_Number "Class", cl.Section "Section", s.S_Name "Student"
From Student s, Registers r, Attends a, Class cl
Where r.S_ID = s.S_ID and a.Reg_No = r.Reg_No and cl.CL_ID = a.CL_ID
and s.Admission_Date >= to_date('&Admission_Date', 'DD-MM-YYYY')
order by cl.CL_Number, cl.Section;

-- 8
-- A list of all new parents in given time span (include children info)
select p1.P_Name"Father", p2.P_Name"Mother", s.S_Name "Student Name"
from Parent p1, Parent p2, Student s
where s.F_ID = p1.P_ID and s.M_ID = p2.P_ID
and s.Admission_Date >= to_date('&Min_Date', 'DD-MM-YYYY')
and s.Admission_Date <= to_date('&Max_Date', 'DD-MM-YYYY');

-- 9
-- A list of all parents who are early introducers (enroll their children into courses as soon as the children are old enough)
select DISTINCT p1.P_Name "Father", p2.P_Name "Mother", s.S_Name "Student Name"
from Parent p1, Parent p2, Student s, Registers r
where s.F_ID = p1.P_ID and s.M_ID = p2.P_ID
and r.S_ID = s.S_ID
and trunc((r.Reg_Date - s.DOB)/365) In (3,4);

-- 10
-- Class change history of given student
Select DISTINCT r.Reg_No "Reg_Number", c.C_Name "Course", h.Chg_No "#", 
cl1.CL_Number "Old Class", cl1.Section "Old Section", cl2.CL_Number "New Class", cl2.Section "New Section", h.Alloc_Date "Change Date"
From Registers r, Course c, Class cl1, Class cl2, Class_Chg_Hist h
Where r.S_ID = &Student_ID and h.Reg_No = r.Reg_No and c.C_ID = r.C_ID and cl1.CL_ID = h.Curr_Class and cl2.CL_ID = h.New_Class;