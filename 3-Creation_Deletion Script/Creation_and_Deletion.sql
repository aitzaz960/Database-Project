-- Insertion and Deletion of tables script

-- Deleting all tables/entites
DROP TABLE Parent CASCADE CONSTRAINTS;
DROP TABLE Parent_History CASCADE CONSTRAINTS;
DROP TABLE Guardian CASCADE CONSTRAINTS;
DROP TABLE Guardian_History CASCADE CONSTRAINTS;
DROP TABLE Student CASCADE CONSTRAINTS;
DROP TABLE Student_History CASCADE CONSTRAINTS;
DROP TABLE Guardian_Relation CASCADE CONSTRAINTS;
DROP TABLE Accompanied_By CASCADE CONSTRAINTS;
DROP TABLE Course CASCADE CONSTRAINTS;
DROP TABLE Registers CASCADE CONSTRAINTS;
DROP TABLE Fee_Details CASCADE CONSTRAINTS;
DROP TABLE Class CASCADE CONSTRAINTS;
DROP TABLE Attends CASCADE CONSTRAINTS;
DROP TABLE Class_Chg_Hist CASCADE CONSTRAINTS;

-- Deleting all sequences
DROP SEQUENCE parent_id;
DROP SEQUENCE guardian_id;
DROP SEQUENCE accompanied_id;
DROP SEQUENCE student_id;
DROP SEQUENCE course_id;
DROP SEQUENCE class_id;
DROP SEQUENCE reg_num;

-- cleaning recycle bin
purge recyclebin;


-- Creation of Tables with Constraints
-- Parent Entity
CREATE TABLE Parent
(
    P_ID            NUMBER,
    P_Name          VARCHAR2(30),
    Gender          VARCHAR2(1),
    CNIC            VARCHAR2(20) UNIQUE NOT NULL,
    Email           VARCHAR2(30),
    Phone           VARCHAR2(20),
    P_Address       VARCHAR2(30),
    Spouse          NUMBER,
    S_Member        NUMBER,
    Alive           NUMBER
);

-- Parent: Primary Key
ALTER TABLE Parent
ADD CONSTRAINTS
parent_primary_key PRIMARY KEY(P_ID);

-- Auto Increment Primary Key: P_ID
-- Sequence for Auto Increment
CREATE SEQUENCE parent_id;

-- Trigger for Auto Increment
CREATE OR REPLACE TRIGGER parent_on_insert
    BEFORE INSERT ON Parent
    FOR EACH ROW
BEGIN
IF :new.P_ID IS NULL THEN
  SELECT parent_id.nextval
  INTO :new.P_ID
  FROM dual;
END IF;
END;
/


-- Parent History Entity
CREATE TABLE Parent_History
(
    P_ID            NUMBER,
    Hist_No         NUMBER,
    P_Name          VARCHAR2(30),
    Gender          VARCHAR2(1),
    CNIC            VARCHAR2(20),
    Email           VARCHAR2(30),
    Phone           VARCHAR2(20),
    P_Address       VARCHAR2(30),
    Spouse          NUMBER,
    S_Member        NUMBER,
    Alive           NUMBER
);

-- Parent History: Primary Key
ALTER TABLE Parent_History
ADD CONSTRAINTS
parent_hist_primary_key PRIMARY KEY(P_ID, Hist_No);

-- Auto Increment: P_Hist_ID
-- Trigger to Auto Increment P_Hist_No based on P_ID
CREATE OR REPLACE TRIGGER parent_on_update
BEFORE UPDATE ON Parent
FOR EACH ROW
DECLARE
    hist Parent_History.Hist_No%TYPE;
BEGIN
    BEGIN
        SELECT max( ph.Hist_No )
        INTO hist
        FROM Parent_History ph
        WHERE ph.P_ID = :new.P_ID;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            hist := NULL;
    END;
    IF hist IS NULL THEN
        hist := 1;
    ELSE
        hist := hist + 1;
    END IF;
    INSERT INTO Parent_History VALUES( :old.P_ID, hist, :old.P_Name, :old.Gender, :old.CNIC, :old.Email, :old.Phone, :old.P_Address, :old.Spouse, :old.S_Member, :old.Alive  );
END;
/


-- Guardian Entity
CREATE TABLE Guardian
(
    G_ID            NUMBER,
    G_Name          VARCHAR2(30),
    Gender          VARCHAR2(1),
    CNIC            VARCHAR2(20) UNIQUE NOT NULL,
    Phone           VARCHAR2(20)
);

-- Guardian: Primary Key
ALTER TABLE Guardian
ADD CONSTRAINTS
guardian_primary_key PRIMARY KEY(G_ID);

-- Auto Increment for Primary Key: G_ID
-- Sequence for Auto Increment
CREATE SEQUENCE guardian_id;

-- Trigger for Auto Increment
CREATE OR REPLACE TRIGGER guardian_on_insert
  BEFORE INSERT ON Guardian
  FOR EACH ROW
BEGIN
    IF :new.G_ID IS NULL THEN
        SELECT guardian_id.nextval
        INTO :new.G_ID
        FROM dual;
    END IF;
END;
/


-- Guardian History Entity
CREATE TABLE Guardian_History
(
    G_ID            NUMBER,
    Hist_No         NUMBER,
    G_Name          VARCHAR2(30),
    Gender          VARCHAR2(1),
    CNIC            VARCHAR2(20),
    Phone           VARCHAR2(20)
);

-- Guardian History: Primary Key
ALTER TABLE Guardian_History
ADD CONSTRAINTS
guardian_hist_primary_key PRIMARY KEY(G_ID, Hist_No);

-- Auto Increment: Hist_No
-- Trigger to Auto Increment Hist_No based on G_ID
CREATE OR REPLACE TRIGGER guardian_on_update
BEFORE UPDATE ON Guardian
FOR EACH ROW
DECLARE
    hist Guardian_History.Hist_No%TYPE;
BEGIN
    BEGIN
        SELECT max( g.Hist_No )
        INTO hist
        FROM Guardian_History g
        WHERE g.G_ID = :new.G_ID;

    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            hist := NULL;
    END;

    IF hist IS NULL THEN
        hist := 1;
    ELSE
        hist := hist + 1;
    END IF;

    INSERT INTO Guardian_History VALUES( :old.G_ID, hist, :old.G_Name, :old.Gender, :old.CNIC, :old.Phone );
END;
/


-- Student Entity
CREATE TABLE Student
(
    S_ID                NUMBER,
    S_Name              VARCHAR2(30),
    Gender              VARCHAR2(1),
    DOB                 Date,
    B_Form              VARCHAR2(20) UNIQUE NOT NULL,      
    M_ID                NUMBER,
    F_ID                NUMBER,
    Admission_Date      Date,
    F_Aid               NUMBER,
    Photo               VARCHAR2(50)
);

-- Student Primary Key
ALTER TABLE Student
ADD CONSTRAINTS
student_primary_key PRIMARY KEY(S_ID);

-- Mother ID
-- Student: M_ID Foreign Key 
ALTER TABLE Student
ADD CONSTRAINTS
student_mother_foreign_key FOREIGN KEY (M_ID)
REFERENCES Parent(P_ID);

-- Father ID
-- Student: F_ID Foreign Key 
ALTER TABLE Student
ADD CONSTRAINTS
student_father_foreign_key FOREIGN KEY (F_ID)
REFERENCES Parent(P_ID);

-- Auto Increment Primary Key: S_ID
-- Sequence for Auto Increment
CREATE SEQUENCE student_id;

-- Trigger for Auto Increment
CREATE OR REPLACE TRIGGER student_on_insert
  BEFORE INSERT ON Student
  FOR EACH ROW
BEGIN
    IF :new.S_ID IS NULL THEN
        SELECT student_id.nextval
        INTO :new.S_ID
        FROM dual;
    END IF;
END;
/


-- Student History Entity
CREATE TABLE Student_History
(
    S_ID                NUMBER,
    Hist_No             NUMBER,
    S_Name              VARCHAR2(30),
    Gender              VARCHAR2(1),
    DOB                 Date,
    B_Form              VARCHAR2(20), 
    M_ID                NUMBER,
    F_ID                NUMBER,
    Admission_Date      Date,
    F_Aid               Number,
    Photo               VARCHAR2(50)
);

-- Student History: Primary Key
ALTER TABLE Student_History
ADD CONSTRAINTS
std_hist_primary_key PRIMARY KEY(S_ID, Hist_No);

-- Auto Increment: Hist_No
-- Trigger to Auto Increment Hist_No based upon S_ID
CREATE OR REPLACE TRIGGER student_on_update
BEFORE UPDATE ON Student
FOR EACH ROW
DECLARE
    hist Student_History.Hist_No%TYPE;
BEGIN
    BEGIN
        SELECT max( s.Hist_No )
        INTO hist
        FROM Student_History s
        WHERE s.S_ID = :new.S_ID;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            hist := NULL;
    END;
    IF hist IS NULL THEN
        hist := 1;
    ELSE
        hist := hist + 1;
    END IF;

    INSERT INTO Student_History VALUES( :old.S_ID, hist, :old.S_Name, :old.Gender, :old.DOB, :old.B_Form, :old.M_ID, :old.F_ID, :old.Admission_Date, :old.F_Aid, :old.Photo );
END;
/


-- Guardian Relation Entity
CREATE TABLE Guardian_Relation
(
    S_ID            NUMBER,        
    G_ID            NUMBER,
    Relation        VARCHAR2(15)
);

-- Guardian_Relation: S_ID Foreign Key 
ALTER TABLE Guardian_Relation
ADD CONSTRAINTS
gr_student_foreign_key FOREIGN KEY (S_ID)
REFERENCES Student(S_ID);

-- Guardian_Relation: G_ID Foreign Key 
ALTER TABLE Guardian_Relation
ADD CONSTRAINTS
gr_guardian_foreign_key FOREIGN KEY (G_ID)
REFERENCES Guardian(G_ID);

-- Guardian Relation: Primary Key
ALTER TABLE Guardian_Relation
ADD CONSTRAINTS
gr_primary_key PRIMARY KEY(S_ID, G_ID);


-- Accompanied_By Entity
CREATE TABLE Accompanied_By
(
    Acc_No          Number,
    S_ID            NUMBER,
    G_ID            NUMBER,
    Reason          VARCHAR2(50) NOT NULL,
    Pregnant        NUMBER NOT NULL,
    Mother          NUMBER NOT NULL,
    Acc_Date        Date
);

-- Accompanied_By: S_ID Foreign Key 
ALTER TABLE Accompanied_By
ADD CONSTRAINTS
acc_sid_foreign_key FOREIGN KEY (S_ID)
REFERENCES Student(S_ID);

-- Accompanied By: Primary Key
ALTER TABLE Accompanied_By
ADD CONSTRAINTS
acc_primary_key PRIMARY KEY( Acc_No );

-- Auto Increment: Acc_No
-- Sequence for Auto Increment
CREATE SEQUENCE accompanied_id;

-- Trigger for Auto Increment
CREATE OR REPLACE TRIGGER accompanied_on_insert
    BEFORE INSERT ON Accompanied_By
    FOR EACH ROW
BEGIN
    IF :new.Acc_No IS NULL THEN
        SELECT accompanied_id.nextval
        INTO :new.Acc_No
        FROM dual;
    END IF;
END;
/


-- Course Entity
CREATE TABLE Course
(
    C_ID            NUMBER,
    C_Name          VARCHAR2(50),
    C_Detail        VARCHAR2(50),
    Fee             NUMBER,
    S_Date          Date,
    E_Date          Date,
    C_Status        NUMBER,
    C_Mode          NUMBER
);

-- Course: Primary Key
ALTER TABLE Course
ADD CONSTRAINTS
course_primary_key PRIMARY KEY( C_ID );

-- Auto Key for Course: C_ID
CREATE SEQUENCE course_id;
CREATE OR REPLACE TRIGGER course_on_insert
    BEFORE INSERT ON Course
    FOR EACH ROW
BEGIN
    IF :new.C_ID IS NULL THEN
        SELECT course_id.nextval
        INTO :new.C_ID
        FROM dual;
    END IF;
END;
/


-- Class Entity
CREATE TABLE Class
(
    CL_ID           NUMBER,
    CL_Number       NUMBER,
    CL_Name         VARCHAR2(15),
    Section         VARCHAR2(1),
    Min_Age         NUMBER,
    Max_Age         NUMBER,
    Total_Std       NUMBER,
    Curr_Std        NUMBER,
    Specific        VARCHAR2(1)
);

-- Class: Primary Key
ALTER TABLE Class
ADD CONSTRAINTS
class_primary_key PRIMARY KEY( CL_ID );

-- Auto Key for Course: C_ID
CREATE SEQUENCE class_id;
CREATE OR REPLACE TRIGGER class_on_insert
  BEFORE INSERT ON Class
  FOR EACH ROW
BEGIN
    IF :new.CL_ID IS NULL THEN
        SELECT class_id.nextval
        INTO :new.CL_ID
        FROM dual;
    END IF;
END;
/


-- Registers Entity
CREATE TABLE Registers
(
    Reg_No          NUMBER,
    S_ID            NUMBER,
    C_ID            NUMBER,
    Challan_No      VARCHAR2(15),
    Reg_Date        Date
);

-- Registers: Primary Key
ALTER TABLE Registers
ADD CONSTRAINTS
reg_primary_key PRIMARY KEY( Reg_No );

-- Registers: S_ID Foreign Key 
ALTER TABLE Registers
ADD CONSTRAINTS
reg_sid_foreign_key FOREIGN KEY (S_ID)
REFERENCES Student(S_ID);

-- Registers: C_ID Foreign Key 
ALTER TABLE Registers
ADD CONSTRAINTS
reg_cid_foreign_key FOREIGN KEY (C_ID)
REFERENCES Course(C_ID);

-- Auto Key for Registers: Reg_No
CREATE SEQUENCE reg_num;
CREATE OR REPLACE TRIGGER registers_on_insert
  BEFORE INSERT ON Registers
  FOR EACH ROW
BEGIN
    IF :new.Reg_No IS NULL THEN
        SELECT reg_num.nextval
        INTO :new.Reg_No
        FROM dual;
    END IF;
END;
/


-- Fee_Details
CREATE TABLE Fee_Details
(
    Reg_No          Number,
    Challan_No      VARCHAR2(15),
    Total_Fee       NUMBER,
    Amount_Paid     NUMBER,
    Discount        NUMBER
);

-- Fee_Details: Challan No foreign Key
ALTER TABLE Fee_Details
ADD CONSTRAINTS
reg_foreign_key FOREIGN KEY (Reg_no)
REFERENCES Registers(Reg_No);

-- Fee Details: Primary Key
ALTER TABLE Fee_Details
ADD CONSTRAINTS
fee_primary_key PRIMARY KEY( Reg_No );


-- Attends Entity
CREATE TABLE Attends
(
    Reg_No          NUMBER,
    CL_ID           NUMBER,
    Alloc_Date      Date,
    A_Status        NUMBER
);

-- Attends: Cl_ID Foreign Key 
ALTER TABLE Attends
ADD CONSTRAINTS
att_clid_foreign_key FOREIGN KEY (CL_ID)
REFERENCES Class(CL_ID);

-- Attends: Primary Key
ALTER TABLE Attends
ADD CONSTRAINTS
att_primary_key PRIMARY KEY( Reg_No ); 

-- Attends: Trigger to increment current number of students in the class when a new record is entered
CREATE OR REPLACE TRIGGER attends_on_insert
AFTER INSERT ON Attends
FOR EACH ROW
DECLARE
    Num Class.Curr_Std%TYPE;
BEGIN
    BEGIN
        SELECT c.Curr_Std
        INTO Num
        FROM Class c
        WHERE c.CL_ID = :new.CL_ID;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            Num := NULL;
    END;
    IF Num IS NULL THEN
        Num := 1;
    ELSE
        Num := Num + 1;
    END IF;

    IF NUM >= 0 THEN 
        UPDATE Class c
        SET c.Curr_Std = Num
        WHERE c.CL_ID = :new.CL_ID; 
    END IF;
END;
/

-- Attends: trigger to decrement the number of students in class when a student leaves or updates the record
CREATE OR REPLACE TRIGGER attends_on_update
AFTER UPDATE OR DELETE ON Attends
FOR EACH ROW
DECLARE
    Num Class.Curr_Std%TYPE;
BEGIN
    BEGIN
        SELECT c.Curr_Std
        INTO Num
        FROM Class c
        WHERE c.CL_ID = :old.CL_ID;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            Num := NULL;
    END;
    IF Num IS NULL THEN
        Num := 0;
    ELSE
        Num := Num - 1;

    IF Num >= 0 AND :old.A_Status = 0 THEN
        UPDATE Class c
        SET c.Curr_Std = Num
        WHERE c.CL_ID = :old.CL_ID; 
    END IF;

    END IF;
END;
/


-- Class_Chg_Hist Entity
CREATE TABLE Class_Chg_Hist
(
    Reg_No          NUMBER,
    Chg_No          NUMBER,
    Curr_Class      NUMBER,
    New_Class       NUMBER,
    Alloc_Date      Date,
    Reason          VARCHAR2(20),
    Approved_By     VARCHAR2(20)
);
  
-- Class_Chg_Hist: Primary Key
ALTER TABLE Class_Chg_Hist
ADD CONSTRAINTS
cch_primary_key PRIMARY KEY( Reg_No, Chg_No );

-- Class Change History: Trigger to increment change number 
CREATE OR REPLACE TRIGGER chg_on_insert
BEFORE INSERT ON Class_Chg_Hist
FOR EACH ROW
DECLARE
    hist Class_Chg_Hist.Chg_No%TYPE;
BEGIN
    BEGIN
        SELECT max( s.Chg_No )
        INTO hist
        FROM Class_Chg_Hist s
        WHERE s.Reg_No = :new.Reg_No;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            hist := NULL;
    END;
    IF hist IS NULL THEN
        hist := 1;
    ELSE
        hist := hist + 1;
    END IF;

    :new.Chg_No := hist;

END;
/

commit;