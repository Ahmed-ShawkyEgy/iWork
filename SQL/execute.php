<?php

// This file is to be executed every time once anybody pulls the project
// If you want to add any create proc commands then u should add a drop proc command first

// TODO fix the bug in this file

require($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");


$proc = array(
"go
alter procedure search 
@name  varchar(255)=null, @address varchar(255)=null, @type  varchar(255)=null as
SELECT * 
FROM Companies c
WHERE c.name  = @name or c.address=@address or c.type=@type ;",

    "
go
alter proc View_All_Companies as 
select c1.*,c2.phone 
from Companies c1 inner join Companies_Phones c2 
on c2.company=c1.email 
",
    
    "
go
create proc View_All_Companies_Type as 
select c1.*,c2.phone 
from Companies c1 inner join Companies_Phones c2 
on c2.company=c1.email
order by c1.type
",
    
"

go
alter procedure departments_of_company @name varchar(255) as 
select c.*,d.code, d.name
from Companies c inner join Departments d 
on d.company=c.email
where c.name=@name;",
    
    "go
alter procedure vacant_job 
@name_departement varchar(255), @name_company varchar(255) 
as
select c.name, d.code, j.title
from Companies c inner join Departments d 
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
where c.name=@name_company and d.code=@name_departement and j.no_of_vacanies>0",
    
    "go 
alter procedure Register_User
@username varchar(255), @password varchar(255),@personal_email varchar(255),@birth_date datetime, 
@years_of_experince int, @first_name varchar(255), @middle_name varchar(255) , @last_name varchar(255)
as
if exists (select * from Users where @username=username)
begin
declare @table table(tmp int)
select *
from @table
end
if not exists(select * from Users where @username=username)
begin
insert into Users values(@username,@password,@personal_email,@birth_date,@years_of_experince,@first_name,@middle_name,@last_name)
insert into Job_Seekers values(@username)
PRINT 'YAY!! WELCOME ENJOY YOUR STAY!!! AND FEEL FREE';
declare @tabltmp table(tmp int)
insert into @tabltmp values (1)
select *
from @tabltmp
end
",
    "go 
alter procedure Insert_Previous_Job 
@username varchar(255), @previousJobs varchar(255)
 as
 insert into Users_Jobs values(@username,@previousJobs)
 ",
    "go
alter procedure search_job 
@shortDescription varchar(255)=null, @title varchar(255)=null
as
select c.name, d.code, j.title
from Companies c inner join Departments d 
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
where j.no_of_vacanies>0 and (j.title like ('%'+@title+'%') or j.short_description like ('%'+@shortDescription+'%'))
",
    "go
alter procedure companies_by_average_salary_order 
as
select c.name,avg(j.salary)
from Companies c inner join Departments d 
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
group by c.name
order by avg(j.salary);
",
    
    "go 
alter function Type_Idenitifer 
(@username varchar(255))
returns varchar(255)
as
begin
IF EXISTS (SELECT  u.username, m.username FROM Users u , Managers m WHERE u.username = m.username and u.username=@username)
    BEGIN
       return 'manager'
    END
 IF EXISTS (SELECT  u.username, r.username FROM Users u , Regular_Employees r WHERE u.username = r.username and u.username=@username)
    BEGIN
      return 'regular_employee'
    END
 IF EXISTS (SELECT  u.username, j.username FROM Users u , Job_Seekers j WHERE u.username = j.username and u.username=@username)
    BEGIN
       return 'job_seeker'
    END
 IF EXISTS (SELECT  u.username, h.username FROM Users u , HR_Employees h WHERE u.username = h.username and u.username=@username)
    BEGIN
       return 'hr_employee'
    END
	
	return null
end
",
    
    "go
create proc Find_Type
@username varchar(255)
as
declare @temp table(
tmp varchar(255)
)
insert into @temp values(dbo.Type_Idenitifer(@username))
select * from @temp
",
    
    "go 
alter procedure login_user
@username varchar(255), @password varchar(255)
as
IF EXISTS (SELECT  u.username, u.password FROM Users u WHERE u.username = @username and u.password = @password)
    BEGIN
	SELECT  u.username FROM Users u WHERE u.username = @username and u.password = @password
 IF EXISTS (SELECT  u.username, m.username FROM Users u , Managers m WHERE u.username = m.username and u.username=@username)
    BEGIN
       print 'YA YOU ARE ONE OF US WELCOME BACK COMMANDER Manager'
    END
 IF EXISTS (SELECT  u.username, r.username FROM Users u , Regular_Employees r WHERE u.username = r.username and u.username=@username)
    BEGIN
       print 'YA YOU ARE ONE OF US WELCOME BACK JUNIOR REGULAR EMPLOYEE'
    END
 IF EXISTS (SELECT  u.username, j.username FROM Users u , Job_Seekers j WHERE u.username = j.username and u.username=@username)
    BEGIN
       print 'YA YOU ARE STILL NOT ONE OF US  BUT WELCOME BACK RECRUITER JOB SEEKER'
    END
 IF EXISTS (SELECT  u.username, h.username FROM Users u , HR_Employees h WHERE u.username = h.username and u.username=@username)
    BEGIN
       print 'YA YOU ARE ONE OF US WELCOME BACK SENIOR HR EMPLOYEES'
    END
END
IF not EXISTS (SELECT  u.username, u.password FROM Users u WHERE u.username = @username and u.password = @password)
    BEGIN
	raiserror('You are not registered',8,16)
	END",
    
    "go 
alter procedure all_possible_information 
@username varchar(255)
as
IF EXISTS (SELECT  u.username FROM Users u WHERE u.username=@username)
Begin
if exists (select * from Staff_Members where username=@username)
begin
select u.*,s.annual_leaves,s.company_email,s.day_off,s.salary,s.job,s.department,s.company
from Users u inner join Staff_Members s
on u.username = s.username
where u.username = @username and s.username=@username
end
if not exists (select * from Staff_Members where username=@username)
begin
select *
from Users
where username = @username 
end
end",
    
    
    "go 
alter procedure edit_user_info 
@username varchar(255),@password varchar(255)=null,@personal_email varchar(255)=null,@birth_date datetime=null, 
@years_of_experince int=null, @first_name varchar(255)=null, @middle_name varchar(255)=null , @last_name varchar(255)=null
as
IF EXISTS (SELECT  u.username FROM Users u WHERE u.username=@username)
Begin
Update Users
set password = @password
where username = @username and  @password IS NOT NULL
Update Users
set personal_email= @personal_email
where username = @username and @personal_email IS NOT NULL
Update Users
set birth_date = @birth_date
where username = @username and @birth_date IS NOT NULL
Update Users
set years_of_experinece = @years_of_experince
where username = @username and @years_of_experince IS NOT NULL
Update Users
set first_name = @first_name
where username = @username and @first_name IS NOT NULL
Update Users
set middle_name = @middle_name
where username = @username and @middle_name IS NOT NULL
Update Users
set last_name = @last_name
where username = @username and @last_name IS NOT NULL
end
"

);

sqlExec($proc[0]);

foreach($proc as $procedure)
{
    sqlExec($procedure);
}
