-- Dataset Script


-- Total Class Records: 14
-- Class 1
INSERT INTO Class VALUES(NULL, 1, 'Unbeatable', 'A', 3, 4, 5, 0, 'N');
INSERT INTO Class VALUES(NULL, 1, 'Players', 'B', 3, 4, 5, 0, 'N');
-- Class 2
INSERT INTO Class VALUES(NULL, 2, 'Tigers', 'A', 5, 6, 5, 0, 'N');
INSERT INTO Class VALUES(NULL, 2, 'Minion', 'B', 5, 6, 5, 0, 'N');
-- Class 3
INSERT INTO Class VALUES(NULL, 3, 'Friends', 'A', 7, 8, 5, 0, 'N');
INSERT INTO Class VALUES(NULL, 3, 'Bosses', 'B', 7, 8, 5, 0, 'N');
-- Class 4
INSERT INTO Class VALUES(NULL, 4, 'A_Team', 'A', 9, 10, 5, 0, 'N');
INSERT INTO Class VALUES(NULL, 4, 'Dolphins', 'B', 9, 10, 5, 0, 'N');
-- Class 5
INSERT INTO Class VALUES(NULL, 5, 'Players', 'A', 11, 12, 5, 0, 'N');
INSERT INTO Class VALUES(NULL, 5, 'Kings', 'B', 11, 12, 5, 0, 'N');
-- Class 6
INSERT INTO Class VALUES(NULL, 6, 'Fantastic', 'A', 13, 14, 5, 0, 'N');
INSERT INTO Class VALUES(NULL, 6, 'Shield', 'B', 13, 14, 5, 0, 'N');
-- Class 7
INSERT INTO Class VALUES(NULL, 7, 'Champions', 'A', 15, 16, 5, 0, 'N');
INSERT INTO Class VALUES(NULL, 7, 'Royals', 'B', 15, 16, 5, 0, 'N');


-- Total Parent Record: 8
-- F1
INSERT INTO Parent VALUES( 50, 'Asad', 'M', '23433-8712973-8', 'asad653@gmail.com', '03578123452', 'Islamabad', 0, 0, 1 );
INSERT INTO Parent VALUES( 51, 'Maham', 'F', '67541-8972831-0', 'maham294@gmail.com', '03878757218', 'Islamabad', 50, 1, 1 );
-- F2
INSERT INTO Parent VALUES( 52, 'Umair', 'M', '45342-9189231-9', 'umair101@gmail.com', '03234257612', 'Lahore', 0, 0, 1);
INSERT INTO Parent VALUES( 53, 'Zoha', 'F', '98712-1232451-2', 'zoha1006@gmail.com', '03273541985', 'Lahore', 52, 0, 1);
-- F3
INSERT INTO Parent VALUES( 54, 'Usman', 'M', '65556-7871253-4', 'usman1676@gmail.com', '03441278542', 'Islamabad', 0, 0, 1 );
INSERT INTO Parent VALUES( 55, 'Neha', 'F', '83279-6724172-8', NULL, NULL, 'Islamabad', 54, 0, 0 );
-- F4
INSERT INTO Parent VALUES( 56, 'Arslan', 'M', '14432-7769234-8', 'arslan88@gmail.com', '03554128761', 'Karachi', 0, 1, 1);
INSERT INTO Parent VALUES( 57, 'Sadaf', 'F', '98120-9808642-3', 'sadafarslan282@gmail.com', '03452576541', 'Karachi', 56, 0, 1);


-- Update Commands to generate Parent History
UPDATE Parent SET Email = 'arslan7878@gmail.com' WHERE P_ID = 56;
UPDATE Parent SET Phone = '03558711288' WHERE P_ID = 51;


-- Total Child Record: 12
-- C1
INSERT INTO Student VALUES( 80, 'Mubashir', 'M', to_timestamp('28-JAN-04','DD-MON-RR HH.MI.SSXFF AM'), '56743-2346198-4', 51, 50, to_timestamp('13-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child1.jpg' );
INSERT INTO Student VALUES( 81, 'Afan', 'M', to_timestamp('21-JUN-05','DD-MON-RR HH.MI.SSXFF AM'), '87564-3423412-1', 51, 50, to_timestamp('13-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child2.jpg');
INSERT INTO Student VALUES( 82, 'Sana', 'F', to_timestamp('10-FEB-04','DD-MON-RR HH.MI.SSXFF AM'), '76512-9728192-2', 51, 50, to_timestamp('13-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child3.jpg');
INSERT INTO Student VALUES( 83, 'Zubair', 'M', to_timestamp('12-MAY-16','DD-MON-RR HH.MI.SSXFF AM'), '64523-8976512-9', 51, 50, to_timestamp('03-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child4.jpg');
-- C2
INSERT INTO Student VALUES( 84, 'Madiha', 'F', to_timestamp('02-APR-04','DD-MON-RR HH.MI.SSXFF AM'), '56398-9182310-6', 53, 52, to_timestamp('10-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child5.jpg');
INSERT INTO Student VALUES( 85, 'Daniel', 'M', to_timestamp('09-JUN-17','DD-MON-RR HH.MI.SSXFF AM'), '86542-8471920-2', 53, 52, to_timestamp('3-MAY-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child6.jpg');
INSERT INTO Student VALUES( 86, 'Hassan', 'M', to_timestamp('15-JAN-16','DD-MON-RR HH.MI.SSXFF AM'), '62735-7182372-8', 53, 52, to_timestamp('10-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child7.jpg');
-- C3
INSERT INTO Student VALUES( 87, 'Hanan', 'M', to_timestamp('07-MAR-17','DD-MON-RR HH.MI.SSXFF AM'), '98374-2873826-7', 55, 54, to_timestamp('21-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 1, 'child8.jpg' );
INSERT INTO Student VALUES( 88, 'Sohaib', 'M', to_timestamp('13-DEC-16','DD-MON-RR HH.MI.SSXFF AM'), '35214-8378672-2', 55, 54, to_timestamp('21-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 1, 'child9.jpg');
-- C4
INSERT INTO Student VALUES( 89, 'Sahil', 'M', to_timestamp('17-JUN-05','DD-MON-RR HH.MI.SSXFF AM'), '98653-9127638-4', 57, 56, to_timestamp('11-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child10.jpg');
INSERT INTO Student VALUES( 90, 'Amina', 'F', to_timestamp('22-MAY-17','DD-MON-RR HH.MI.SSXFF AM'), '12437-8965238-3', 57, 56, to_timestamp('11-JAN-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child11.jpg');
INSERT INTO Student VALUES( 91, 'Noor', 'F', to_timestamp('27-SEP-16','DD-MON-RR HH.MI.SSXFF AM'), '71232-8513243-6', 57, 56, to_timestamp('1-MAY-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 'child12.jpg' );


-- Update Command to generate Student History
UPDATE Student SET Photo = 'child13.jpg' WHERE S_ID = 89;


-- Guardians whose names were given in Admission
INSERT INTO Guardian VALUES( 201, 'Saad', 'M', '87654-6745320-8', '03452637516');
INSERT INTO Guardian VALUES( 202, 'Junaid', 'M', '67345-7812453-9', '03755342911');
INSERT INTO Guardian VALUES( 203, 'Usman', 'M', '65556-7871253-4', '03441278542');
INSERT INTO Guardian VALUES( 204, 'Qasim', 'M', '65342-7867510-2', '03986285401');
-- Guradian who record was inserted at the time of Admission as Accompanying Guardian
INSERT INTO Guardian VALUES( 205, 'Khadija', 'F', '66753-7645341-2', '03764592123');


-- Update Record to generate Guardian History
UPDATE Guardian SET Phone = '03675365712' WHERE G_ID = 204;


-- Guardian Relation Records: 12
INSERT INTO Guardian_Relation VALUES(80, 201, 'Grand Father' );
INSERT INTO Guardian_Relation VALUES(81, 201, 'Grand Father' );
INSERT INTO Guardian_Relation VALUES(82, 201, 'Grand Father' );
INSERT INTO Guardian_Relation VALUES(83, 201, 'Grand Father' );
INSERT INTO Guardian_Relation VALUES(84, 202, 'Uncle' );
INSERT INTO Guardian_Relation VALUES(85, 202, 'Uncle' );
INSERT INTO Guardian_Relation VALUES(86, 202, 'Uncle' );
INSERT INTO Guardian_Relation VALUES(87, 203, 'Father' );
INSERT INTO Guardian_Relation VALUES(88, 203, 'Father' );
INSERT INTO Guardian_Relation VALUES(89, 204, 'Grand Father' );
INSERT INTO Guardian_Relation VALUES(90, 204, 'Grand Father' );
INSERT INTO Guardian_Relation VALUES(91, 204, 'Grand Father' );


-- Total Accompanied By Records For kids: 7
INSERT INTO Accompanied_By VALUES( 240, 83, 51, '-', 0, 1, NULL);
INSERT INTO Accompanied_By VALUES( 241, 85, 53, '-', 0, 1, NULL);
INSERT INTO Accompanied_By VALUES( 242, 86, 53, '-', 0, 1, NULL);
INSERT INTO Accompanied_By VALUES( 243, 87, 205, '-', 0, 0, NULL);
INSERT INTO Accompanied_By VALUES( 244, 88, 205, '-', 0, 0, NULL);
INSERT INTO Accompanied_By VALUES( 245, 90, 57, '-', 0, 1, NULL);
INSERT INTO Accompanied_By VALUES( 246, 91, 57, '-', 0, 1, NULL);


-- Total Courses Records: 5
INSERT INTO Course VALUES( 130, 'Astronomy', 'Stars Satellites Space Galaxies information', 2000, to_timestamp('10-APR-20','DD-MON-RR HH.MI.SSXFF AM'), to_timestamp('1-MAY-20','DD-MON-RR HH.MI.SSXFF AM'), 1, 1);
INSERT INTO Course VALUES( 131, 'Art and Craft', 'Art using household things', 3000, to_timestamp('27-SEP-20','DD-MON-RR HH.MI.SSXFF AM'), to_timestamp('27-SEP-20','DD-MON-RR HH.MI.SSXFF AM'), 1, 1 );
INSERT INTO Course VALUES( 132, 'Robotics', 'making small robots', 3000, to_timestamp('27-SEP-21','DD-MON-RR HH.MI.SSXFF AM'), to_timestamp('27-SEP-21','DD-MON-RR HH.MI.SSXFF AM'), 1, 1);
INSERT INTO Course VALUES( 133, 'Art and Craft', 'Art on computer', 3000, to_timestamp('27-NOV-20','DD-MON-RR HH.MI.SSXFF AM'), to_timestamp('27-NOV-20','DD-MON-RR HH.MI.SSXFF AM'), 1, 1);
INSERT INTO Course VALUES( 134, 'Biology', 'brain, heart, bones related information', 2000, to_timestamp('10-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), to_timestamp('10-JUL-20','DD-MON-RR HH.MI.SSXFF AM'), 0, 0);


-- Total Registrations: 
-- Registratios for Course 1: 10
INSERT INTO Registers VALUES( 150, 80, 130, 'J67564', to_timestamp('10-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 151, 81, 130, 'G56432', to_timestamp('3-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 152, 82, 130, 'Z76423', to_timestamp('4-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 153, 83, 130, 'S52372', to_timestamp('5-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 154, 84, 130, 'A67125', to_timestamp('5-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 155, 86, 130, 'F97442', to_timestamp('8-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 156, 87, 130, 'K98766', to_timestamp('7-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 157, 88, 130, 'P71524', to_timestamp('4-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 158, 89, 130, 'W32736', to_timestamp('4-APR-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 159, 90, 130, 'D23876', to_timestamp('9-APR-20','DD-MON-RR HH.MI.SSXFF AM') );


-- Total Fee_Details Records for Course 1: 10
INSERT INTO Fee_Details VALUES( 150, 'J67564', 2000, 0, 2000);
INSERT INTO Fee_Details VALUES( 151, 'G56432', 2000, 0, 2000);
INSERT INTO Fee_Details VALUES( 152, 'Z76423', 2000, 0, 2000);
INSERT INTO Fee_Details VALUES( 153, 'S52372', 2000, 0, 2000);
INSERT INTO Fee_Details VALUES( 154, 'A67125', 2000, 1600, 400);
INSERT INTO Fee_Details VALUES( 155, 'F97442', 2000, 1600, 400);
INSERT INTO Fee_Details VALUES( 156, 'K98766', 2000, 1000, 1000);
INSERT INTO Fee_Details VALUES( 157, 'P71524', 2000, 1000, 1000);
INSERT INTO Fee_Details VALUES( 158, 'W32736', 2000, 0, 2000);
INSERT INTO Fee_Details VALUES( 159, 'D23876', 2000, 0, 2000);


-- Total Attends Records for Course 1: 10
INSERT INTO Attends VALUES( 150, 13, to_timestamp('10-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 151, 13, to_timestamp('3-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 152, 13, to_timestamp('4-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 153, 1, to_timestamp('5-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 154, 13, to_timestamp('5-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 155, 1, to_timestamp('8-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 156, 1, to_timestamp('7-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 157, 1, to_timestamp('4-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 158, 14, to_timestamp('4-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);
INSERT INTO Attends VALUES( 159, 2, to_timestamp('9-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 1);


-- Generating Change Class History Record
UPDATE Attends SET CL_ID = 2 WHERE Reg_No = 156;
INSERT INTO Class_Chg_Hist VALUES(156, 1, 1, 2, to_timestamp('15-APR-20','DD-MON-RR HH.MI.SSXFF AM'), 'Misbehave', 'Azhar' );


-- Setting Current No. of Students = 0 for new Course
UPDATE Class
SET CURR_STD = 0;


-- Setting status of Courses Completed to 1 for new Course
UPDATE Attends a
SET A_Status = 1
WHERE Reg_No IN ( SELECT r.Reg_No FROM  Registers r, Course c WHERE r.C_ID = c.C_ID AND c.E_Date < SYSDATE);


-- Total Registrations Records for Course 2: 11
INSERT INTO Registers VALUES( 166, 80, 134, 'E23878', to_timestamp('1-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 167, 82, 134, 'Q28367', to_timestamp('2-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 168, 83, 134, 'L29733', to_timestamp('2-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 169, 84, 134, 'E32487', to_timestamp('5-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 170, 85, 134, 'I23763', to_timestamp('5-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 171, 86, 134, 'M28733', to_timestamp('3-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 172, 87, 134, 'R32867', to_timestamp('31-MAY-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 173, 88, 134, 'U23873', to_timestamp('6-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 174, 89, 134, 'F78734', to_timestamp('5-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 175, 90, 134, 'N37287', to_timestamp('2-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );
INSERT INTO Registers VALUES( 176, 91, 134, 'W23878', to_timestamp('4-JUN-20','DD-MON-RR HH.MI.SSXFF AM') );


-- Total Fee_Details Records for Course 2: 11
INSERT INTO Fee_Details VALUES( 166, 'E23878', 3000, 0, 3000);
INSERT INTO Fee_Details VALUES( 167, 'Q28367', 3000, 0, 3000);
INSERT INTO Fee_Details VALUES( 168, 'L29733', 3000, 0, 3000);
INSERT INTO Fee_Details VALUES( 169, 'E32487', 3000, 2400, 600);
INSERT INTO Fee_Details VALUES( 170, 'I23763', 3000, 2400, 600);
INSERT INTO Fee_Details VALUES( 171, 'M28733', 3000, 2400, 600);
INSERT INTO Fee_Details VALUES( 172, 'R32867', 3000, 1500, 1500);
INSERT INTO Fee_Details VALUES( 173, 'U23873', 3000, 1500, 1500);
INSERT INTO Fee_Details VALUES( 174, 'F78734', 3000, 0, 3000);
INSERT INTO Fee_Details VALUES( 175, 'N37287', 3000, 0, 3000);
INSERT INTO Fee_Details VALUES( 176, 'W23878', 3000, 0, 3000);


-- Total Attends Records for Course 2: 11
INSERT INTO Attends VALUES( 166, 13, to_timestamp('1-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 167, 14, to_timestamp('2-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 168, 1, to_timestamp('2-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 169, 14, to_timestamp('5-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 170, 1, to_timestamp('5-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 171, 1, to_timestamp('3-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 172, 1, to_timestamp('31-MAY-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 173, 2, to_timestamp('6-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 174, 13, to_timestamp('5-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 175, 2, to_timestamp('2-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);
INSERT INTO Attends VALUES( 176, 2, to_timestamp('4-JUN-20','DD-MON-RR HH.MI.SSXFF AM'), 0);

commit;