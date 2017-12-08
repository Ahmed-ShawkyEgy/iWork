-- Below is Shawky's code

go
alter procedure Check_In
@username varchar(255),
@out int  output
as
declare @staff varchar(255)
select @staff=s.username
from Users u inner join Staff_Members s on u.username=s.username
where s.username=@username
declare @dayoff varchar(255)
select @dayoff=s.day_off
from Users u inner join Staff_Members s on u.username=s.username
where s.username=@username
if exists (select * from Attendance_Records where date = CONVERT (date, CURRENT_TIMESTAMP) and staff = @username and start_time = CONVERT(VARCHAR(5), GETDATE(), 108)+':00'+' ' + RIGHT(CONVERT(VARCHAR(30), GETDATE(), 9),2))
begin
set @out = 0;
return;
end
else if(@username=@staff and @dayoff<> DATENAME(weekday, current_timestamp) and 'Friday'<>DATENAME(weekday, current_timestamp))
begin

begin try
insert  into Attendance_Records (date, staff,start_time) values (CONVERT (date, CURRENT_TIMESTAMP),@username,CONVERT(VARCHAR(5), GETDATE(), 108)+':00'+' ' + RIGHT(CONVERT(VARCHAR(30), GETDATE(), 9),2))
set @out = 1 end try
begin catch
set @out = 0;
 end catch
end
else
	set @out = 0;





go
alter proc Check_Out
@username varchar(255),
@out int output
as
declare @staff varchar(255)
select @staff=s.username
from Users u inner join Staff_Members s on u.username=s.username
where s.username=@username

declare @dayoff varchar(255)
select @dayoff=s.day_off
from Users u inner join Staff_Members s on u.username=s.username
where s.username=@username
if(@username=@staff and @dayoff<> DATENAME(weekday, current_timestamp) and 'Friday'<>DATENAME(weekday, current_timestamp))
begin
begin try
if exists (select * from Attendance_Records where staff = @username and date = CONVERT (date, CURRENT_TIMESTAMP) and end_time is not null)
begin
set @out = 2;
return
end
if not exists (select * from Attendance_Records where staff = @username and date = CONVERT (date, CURRENT_TIMESTAMP))
begin
set @out = 0;
return;
end
Update  Attendance_Records
set  end_time= CONVERT(VARCHAR(5), GETDATE(), 108)+':00'+' ' + RIGHT(CONVERT(VARCHAR(30), GETDATE(), 9),2)
where date=CONVERT (date, CURRENT_TIMESTAMP) and @username=staff
set @out = 1;
end try begin catch
set @out = 0;
end catch
end


go
alter proc Apply_Request
@username varchar(255),@start_date datetime,@end_date datetime,@type varchar(255)=null,@destination varchar(255)=null,@purpose varchar(255)= null,
@usernameReplacement varchar(255) , @out int output
as
set @out = 0
declare @annual_leave int
declare @durationtmp int=Cast(@end_date-@start_date as int)
declare @ReplacementDepartment varchar(255), @ReplacementCompany varchar(255)
select @ReplacementDepartment=department, @ReplacementCompany=company
from Staff_Members
where @usernameReplacement=username
declare @duration int=0
declare @dateIncrementor datetime = @start_date

declare @offday varchar(255), @annual_leaves varchar(255)
		select @offday=day_off, @annual_leaves=annual_leaves
		from Staff_Members
		where @username=username
while (@durationtmp>0)
			begin
			if(DATENAME(weekday, @dateIncrementor)<>'Friday' and DATENAME(weekday, @dateIncrementor) <> @offday)
				begin
				set @duration=@duration+1
			end
				set @durationtmp=@durationtmp-1
				set @dateIncrementor=DATEADD(day, 1, @dateIncrementor)
		end

declare @usernameDepartment varchar(255), @usernameCompany varchar(255)
select @usernameDepartment=department, @usernameCompany=company
from Staff_Members
where @username=username

if not EXISTS(select * from Requests where  hr_response<>'Rejected' and manager_response<>'Rejected' and applicant = @username and (
(@start_date>=Requests.start_date and @end_date<=Requests.end_date)or
(@start_date>=Requests.start_date and @end_date>=Requests.end_date and @start_date<=Requests.end_date)or
@start_date<=Requests.start_date and @end_date<=Requests.end_date and @end_date>=Requests.start_date)or(
@start_date<=Requests.start_date and @end_date>=Requests.end_date and @start_date>=Requests.end_date and @start_date<=Requests.end_date))
begin
if not EXISTS(select * from Requests where applicant = @usernameReplacement and (
(@start_date>=Requests.start_date and @end_date<=Requests.end_date)or
(@start_date>=Requests.start_date and @end_date>=Requests.end_date and @start_date<=Requests.end_date)or
@start_date<=Requests.start_date and @end_date<=Requests.end_date and @end_date>=Requests.start_date)or(
@start_date<=Requests.start_date and @end_date>=Requests.end_date and @start_date>=Requests.end_date and @start_date<=Requests.end_date))
begin
if exists (select * from Requests where  hr_response<>'Rejected' and manager_response<>'Rejected' and applicant = @username)
begin
delete from Requests where (hr_response='Rejected' or manager_response='Rejected') and applicant = @username
end
select @annual_leave = annual_leaves
from Staff_Members
where username = @username
if((dbo.Type_Idenitifer(@username)=dbo.Type_Idenitifer(@usernameReplacement))and(@ReplacementDepartment=@usernameDepartment)and (@ReplacementCompany=@usernameCompany))
begin
if(@annual_leave>0 and @annual_leave>=@duration)
	begin
	set @out = 1
	insert into Requests (start_date,applicant,end_date,request_date)
	values(@start_date, @username,@end_date, CURRENT_TIMESTAMP)
	if(dbo.Type_Idenitifer(@username)='manager')
		begin
		Update Requests
		set manager_response='Accepted', manager=@username, hr_response='Accepted'
		where applicant=@username
		end
	if (@type =  'sick_leave' or @type =  'accidential_leave' or  @type =  'annual_leave')
		begin
			insert into Leave_Requests values(@start_date, @username, @type)
		end
	else
		if(@purpose is not null and @destination is not null)
			begin
			insert into Business_Trip_Requests values(@start_date, @username, @destination,@purpose)
			end
	if(dbo.Type_Idenitifer(@usernameReplacement)='manager')
	begin
	insert into Managers_apply_replace_Requests values(@start_date,@username,@username,@usernameReplacement)
	end
	if(dbo.Type_Idenitifer(@usernameReplacement)='regular_employee')
	begin
	insert into Requests_apply_replace_Regular_Employees values(@start_date,@username,@username,@usernameReplacement)
	end
	if(dbo.Type_Idenitifer(@usernameReplacement)='hr_employee')
	begin
	insert into HR_Employees_apply_replace_Requests values(@start_date,@username,@username,@usernameReplacement)
	end
	end
	end
	end
	end




go
alter proc View_All_Status_Requests
@username varchar(255)
as
select *
from Requests
where @username=applicant


go
alter proc Delete_Status_Requests
@username varchar(255),@request_date datetime , @out int output
as
if exists (select * from Requests where @username=applicant and (hr_response ='Pending' or manager_response ='Pending') and @request_date=start_date)
set @out = 1
else
set @out = 0
Delete from Requests
where @username=applicant and (hr_response ='Pending' or manager_response ='Pending') and @request_date=start_date


-- ------------------------------------------------------------------------- Below is Morgan's code


go
alter procedure search
@name  varchar(255)=null, @address varchar(255)=null, @type  varchar(255)=null as
SELECT *
FROM Companies c
WHERE c.name  = @name or c.address=@address or c.type=@type ;



go
alter proc View_All_Companies as
select c1.*,c2.phone
from Companies c1 inner join Companies_Phones c2
on c2.company=c1.email



go
create proc View_All_Companies_Type as
select c1.*,c2.phone
from Companies c1 inner join Companies_Phones c2
on c2.company=c1.email
order by c1.type




go
alter procedure departments_of_company @name varchar(255) as
select c.*,d.code, d.name
from Companies c inner join Departments d
on d.company=c.email
where c.name=@name;


go
alter procedure vacant_job
@name_departement varchar(255), @name_company varchar(255)
as
select c.name, d.code, j.title
from Companies c inner join Departments d
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
where c.name=@name_company and d.code=@name_departement and j.no_of_vacanies>0


go
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



go
alter procedure Insert_Previous_Job
@username varchar(255), @previousJobs varchar(255)
 as
 insert into Users_Jobs values(@username,@previousJobs)


go
alter procedure search_job
@shortDescription varchar(255)=null, @title varchar(255)=null
as
select c.name, d.code, j.title
from Companies c inner join Departments d
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
where j.no_of_vacanies>0 and (j.title like ('%'+@title+'%') or j.short_description like ('%'+@shortDescription+'%'))



go
alter procedure companies_by_average_salary_order
as
select c.name,avg(j.salary)
from Companies c inner join Departments d
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
group by c.name
order by avg(j.salary);



go
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




go
create proc Find_Type
@username varchar(255)
as
declare @temp table(
tmp varchar(255)
)
insert into @temp values(dbo.Type_Idenitifer(@username))
select * from @temp




go
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
	END



  go
  alter proc View_All_Companies_Type as
  select c1.*
  from Companies c1
  order by c1.type


  go
alter procedure departments_of_company @name varchar(255) as -- procedure view departments in the company
select c.*,d.code, d.name as 'Dep'
from Companies c inner join Departments d
on d.company=c.email
where c.name=@name;

go
alter procedure vacant_job -- procedure takes 2 inputs department name and comapany name and view records of vacancies jobs in that department which exists in that company
@name_departement varchar(255), @name_company varchar(255)
as
select c.name, d.code,d.name as 'Dep', j.title
from Companies c inner join Departments d
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
where c.name=@name_company and d.code=@name_departement and j.no_of_vacanies>0


go
alter proc Apply_Job
@username varchar(255), @title varchar(255), @company varchar(255), @department varchar(255)
as
--
if exists  (select j.job_Seekers from Job_Seeker_apply_Jobs j
where j.company=@company and j.department=@department and j.job=@title and j.job_Seekers=@username and (j.hr_response <> 'Pending' or j.manager_response ='Pending'))
begin
declare @table1 table(tmp int)
select * from @table1
end
--
if not exists  (select j.job_Seekers from Job_Seeker_apply_Jobs j
where j.company=@company and j.department=@department and j.job=@title and j.job_Seekers=@username)
begin
insert into Job_Seeker_apply_Jobs (job, department, company,job_Seekers)
select j.title, j.department,j.company,u.username
from Jobs j, Users u inner join Job_Seekers k
on  u.username=k.username
where j.title=@title and j.company=@company and j.department=@department and u.username=@username
and k.username=@username and u.years_of_experinece>=j.min_experience and j.no_of_vacanies>0
declare @table2 table(tmp int)
insert into @table2 values(1)
select * from @table2
end
if exists  (select j.job_Seekers from Job_Seeker_apply_Jobs j
where j.company=@company and j.department=@department and j.job=@title and j.job_Seekers=@username and (j.hr_response = 'Rejected' or j.manager_response ='Rejected'))
begin
delete from Job_Seeker_apply_Jobs  where company=@company and department=@department and job=@title and job_Seekers=@username
insert into Job_Seeker_apply_Jobs (job, department, company,job_Seekers)
select j.title, j.department,j.company,u.username
from Jobs j, Users u inner join Job_Seekers k
on  u.username=k.username
where j.title=@title and j.company=@company and j.department=@department and u.username=@username
and k.username=@username and u.years_of_experinece>=j.min_experience and j.no_of_vacanies>0
declare @table3 table(tmp int)
insert into @table3 values(2)
select * from @table3
end
