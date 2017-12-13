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
if exists (select * from Attendance_Records where date = CONVERT (date, CURRENT_TIMESTAMP) and staff = @username and start_time = CONVERT(VARCHAR(5), GETDATE(), 108)+':00' + RIGHT(CONVERT(VARCHAR(30), GETDATE(), 9),2))
begin
set @out = 0;
return;
end
else if(@username=@staff and @dayoff<> DATENAME(weekday, current_timestamp) and 'Friday'<>DATENAME(weekday, current_timestamp))
begin

begin try
insert  into Attendance_Records (date, staff,start_time) values (CONVERT (date, CURRENT_TIMESTAMP),@username,CONVERT(VARCHAR(5), GETDATE(), 108)+':00' + RIGHT(CONVERT(VARCHAR(30), GETDATE(), 9),2))
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



if (@durationtmp < 0)
begin
set @out = 3;
return;
end

if not exists ( select * from Staff_Members where username = @usernameReplacement)
begin
	set @out = 2;
	return;
end

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

if (@usernameCompany <> @ReplacementCompany or @usernameDepartment <> @ReplacementDepartment)
begin
	set @out = 4;
	return;
end

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




 go
 create proc View_Attendance_Between_Certain_Period_Staff
  @SMusername varchar(255), @start_date datetime, @end_date datetime
 as
 if exists(select * from Staff_Members h where h.username=@SMusername)
begin
declare @HRcompany varchar(255), @HRdepartment varchar(255)
select @HRcompany=s.company, @HRdepartment=s.department
from jobs j inner join Staff_Members s
on j.department= s.department and j.company = s.company
where s.username=@SMusername
if EXISTS(select * from Attendance_Records a inner join Staff_Members s
on a.staff = s.username
where a.staff = @SMusername and s.department=@HRdepartment and s.company=@HRcompany and
(@start_date<=a.date and @end_date>=a.date))
begin
	declare @time table
(
	date datetime,
    missing_hours time,
	duration time
)
insert into @time
select a.date,dbo.time_Diff(j.working_hours,dbo.time_Diff(a.end_time , a.start_time)),dbo.time_Diff(a.end_time , a.start_time)
from Users u inner join Staff_Members s on u.username=s.username
inner join Attendance_Records a on a.staff = s.username and u.username=a.staff
inner join Staff_Members uj on uj.username = a.staff and uj.username =u.username and uj.username = s.username
inner join Jobs j on uj.job = j.title and u.username= uj.username and s.company=j.company and s.department=j.department
where s.username = @SMusername

select  a.*, t.missing_hours, t.duration
from Attendance_Records a inner join @time t
on a.date=t.date
inner join Staff_Members s
on s.username=a.staff
where staff = @SMusername and s.department=@HRdepartment and s.company=@HRcompany and (@start_date<=a.date and @end_date>=a.date)
	end
	end




go
alter proc Send_Email
@username varchar(255),@recipient varchar(255),@subject varchar(255),@body varchar(255),@out int output
as
set @out = 0
declare @usernameCompany varchar(255)
select @usernameCompany = company
from Staff_Members
where @username = username
if exists(select * from Staff_Members where company = @usernameCompany and username = @recipient)
begin
set @out = 1
insert into Emails (subject,date,body) values(@subject,cast(CURRENT_TIMESTAMP as date),@body)
insert into Staff_send_Email_Staff
select IDENT_CURRENT('dbo.Emails') , @recipient ,@username
end




go
alter proc View_Email
@username varchar(255)
as
select e.serial_number, e.subject,e.date,sses.recipient,sses.sender,e.body
from Emails e inner join Staff_send_Email_Staff sses on e.serial_number = sses.email_number
where recipient = @username




go
alter proc Reply_Email
@username varchar(255),@emailId int, @subject varchar(255),@body varchar(255) , @out int output
as
set @out = 0
declare @sender varchar(255)
if exists(select * from Staff_send_Email_Staff e where  @emailId = e.email_number and e.recipient =  @username)
begin
select @sender = sender
from Staff_send_Email_Staff
where recipient = @username and email_number = @emailId
insert into Emails (subject,date,body) values(@subject,cast(CURRENT_TIMESTAMP as date),@body)
insert into Staff_send_Email_Staff
select IDENT_CURRENT('dbo.Emails') , @sender ,@username
set @out = 1
end

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
where j.company=@company and j.department=@department and j.job=@title and j.job_Seekers=@username and (j.hr_response = 'Pending' or j.manager_response ='Pending'))
begin
declare @table4 table(tmp int)
select * from @table4
end
if not exists(select * from Jobs j where j.title=@title and @company=j.company and @department=j.department)
begin
declare @table1 table(tmp int)
select * from @table1
return
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

go
alter proc View_Questions
@username varchar(255),@title varchar(255), @departement varchar(255), @company varchar(255)
as
if exists (select * from Job_Seeker_apply_Jobs where @username=job_Seekers and @title=job and @company=company and @departement=department)
begin
select q.question, q.answer
from Jobs_has_Questions j inner join Questions q
on q.number = j.question
where @title = j.job and @departement=j.department and @company=j.company
end


go
alter proc View_Jobs_Status
@username varchar(255)
as
select jsaj.job,jsaj.department,jsaj.company,jsaj.hr_response , jsaj.manager_response , jsaj.score
from Job_Seeker_apply_Jobs jsaj inner join Job_Seekers js
on jsaj.job_Seekers = js.username
where @username = js.username



go
create proc View_Jobs_Status_Accepted_Only
@username varchar(255)
as
select  jsaj.job,jsaj.department,jsaj.company
from Job_Seeker_apply_Jobs jsaj inner join Job_Seekers js
on jsaj.job_Seekers = js.username
where @username = js.username and hr_response='Accepted' and manager_response='Accepted'


go
alter proc Change_To_Fixed_Task
@username varchar(255), @task varchar(255),@project varchar(255)
as
if exists (select * from Tasks where name=@task and @username=regular_employee and cast(CURRENT_TIMESTAMP as date) < cast(deadline as date) and @project=project)
begin
Update Tasks
set status='Fixed'
where name=@task and @username=regular_employee and cast(CURRENT_TIMESTAMP as date) < cast(deadline as date) and @project=project
declare @table1 table(tmp int)
insert into @table1 values(1)
select *
from @table1
end
if not exists (select * from Tasks where name=@task and @username=regular_employee and cast(CURRENT_TIMESTAMP as date) < cast(deadline as date) and @project=project)
begin
declare @table2 table(tmp int)
select *
from @table2
end





go
alter proc Change_Status_To_Assigned_Again
@username varchar(255), @task varchar(255),@project varchar(255)
as
if exists (select * from Tasks where name=@task and @username=regular_employee and cast(CURRENT_TIMESTAMP as date) < cast(deadline as date) and status = 'Fixed' and @project=project)
begin
Update Tasks
set status='Assigned'
where name=@task and @username=regular_employee and cast(CURRENT_TIMESTAMP as date) < cast(deadline as date) and status = 'Fixed' and @project=project
declare @table1 table(tmp int)
insert into @table1 values(1)
select *
from @table1
end
if not exists (select * from Tasks where name=@task and @username=regular_employee and cast(CURRENT_TIMESTAMP as date) < cast(deadline as date) and status = 'Fixed' and @project=project)
begin
declare @table2 table(tmp int)
select *
from @table2
end




----------Ahmed Sherif

--------------9 in Managers
--9 Assign one regular employee (from those already assigned to the project) to work on an already defined task by me in this project.
go
alter proc Assign_Regular_Task_Manager
@MHRusername varchar(255), @regular_employee varchar(255),
@project_name varchar(255),@taskName varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
if exists(select * from Managers_assign_Regular_Employees_Projects where @project_name=project_name
and regular_employee=@regular_employee)
begin
update Tasks
set regular_employee=@regular_employee, status='Assigned'
where @MHRusername=manager and company=@MHRcompany and @project_name=project and @taskName=Tasks.name
and	Tasks.status='Open'
end






--5 Create a new project in my department with all of its information
go
alter proc Create_New_Project
@MHRusername varchar(255), @title varchar(255), @start_date datetime, @end_date date
as
declare @MHRcompany varchar(255)
if exists (select m.username from Managers m where m.username=@MHRusername )
begin
select @MHRcompany=s.company
from Staff_Members s where s.username=@MHRusername
insert into Projects values(@title,@MHRcompany,@start_date,@end_date,@MHRusername)
end

---------



---- 4 in manager
go
alter proc Manager_Accept_Reject_Applications_After_HR
@MHRusername varchar(255), @response varchar(255), @username varchar(255), @Job varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
if exists(select *
from Users u inner join Job_Seeker_apply_Jobs s
on u.username=s.job_Seekers
where s.department=@MHRdepartment and s.company=@MHRcompany and s.job_Seekers=@username)
------ remove le users if u want
begin

if(@response='Accepted' or @response='Rejected')
begin
Update Job_Seeker_apply_Jobs
set manager_response=@response
where @username=job_Seekers and hr_response='Accepted' and company=@MHRcompany and department=@MHRdepartment and @Job=job
end


end
---------------------


---------- 3 in manager tmam
go
alter proc Manager_View_Applications_Before_HR
@MHRusername varchar(255),@job varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s
where s.username=@MHRusername

select js.*, u.years_of_experinece,u.age,
j.no_of_vacanies,j.short_description,j.detailed_description,j.min_experience
from Job_Seeker_apply_Jobs js inner join Jobs j
on js.job=j.title and js.department= j.department and j.company=js.company
inner join Users u
on js.job_Seekers=u.username
where j.department=@MHRdepartment and js.company=@MHRcompany and hr_response='Accepted'


----2 in manager tmam
go
alter proc Accept_Reject_Request_Manager
@MHRusername varchar(255), @response varchar(255),@reason varchar(max)=null,
@username varchar(255), @start_date date
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255),@type varchar(255)

select @MHRcompany=s.company, @MHRdepartment=s.department, @type=m.type
from Staff_Members s inner join Managers m on s.username=m.username
where s.username=@MHRusername

if exists(select * from Staff_Members s
where s.department=@MHRdepartment and s.company=@MHRcompany and s.username=@username)
begin

if(@response='accepted' and @type='HR' )
begin
Update Requests
set manager_response=@response, manager=@MHRusername, hr_response=@response
where @username=applicant and @start_date=cast(start_date as date)  and hr_response ='Pending'
end

if(@response='rejected' and @type='HR' )
begin
Update Requests
set manager_response=@response, manager=@MHRusername,hr_response=@response,manager_reason=@reason
where @username=applicant and @start_date=cast(start_date as date) and hr_response ='Pending'
and @reason is not null

end

if(@response='rejected' and @type<>'HR' )
begin
Update Requests
set manager_response=@response, manager=@MHRusername, manager_reason=@reason
where @username=applicant and @start_date=cast(start_date as date) and hr_response ='Pending'
and @reason is not null
end


if(@response='Accepted' and @type<>'HR' )
begin
Update Requests
set manager_response=@response, manager=@MHRusername
where @username=applicant and @start_date=cast(start_date as date) and hr_response ='Pending'
end

end

-----1 REAGAIN updated one in manager
---------- created my own version
go
alter proc Final_Accept_Request
@MHRusername varchar(255)

as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255),@type varchar(255)
if exists (select m.username from Managers m  where m.username=@MHRusername)
begin

select @MHRcompany=s.company, @MHRdepartment=s.department from  Staff_Members s
where s.username=@MHRusername

if (@type='HR')
begin
select r.* from Requests r inner join Staff_Members s
on r.applicant = s.username where s.company=@MHRcompany and s.department=@MHRdepartment and
r.hr_response='Pending'
end

else
begin
select r.* from Requests r inner join Staff_Members s
on r.applicant = s.username where s.company=@MHRcompany and s.department=@MHRdepartment
and not exists(select * from HR_Employees h where s.username=h.username) and r.hr_response='Pending'
end

end

-----7 Remove regular employees assigned to a project as long as they don’t have tasks assigned to him/her in this project.
go
alter proc Remove_Regular_To_Project
@MHRusername varchar(255), @titleOfProject varchar(255), @username varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername

select project_name from Managers_assign_Regular_Employees_Projects
where @username=regular_employee and @titleOfProject=project_name and company=@MHRcompany and
not exists
(select t.*
from Tasks t inner join Projects p
on t.project=p.name and t.company=p.company
where p.name=@titleOfProject and t.regular_employee=@username)


delete from Managers_assign_Regular_Employees_Projects
where @username=regular_employee and @titleOfProject=project_name and company=@MHRcompany and
not exists
(select t.*
from Tasks t inner join Projects p
on t.project=p.name and t.company=p.company
where p.name=@titleOfProject and t.regular_employee=@username)


------------------created new procedure
-------------------------------

go
create proc get_project_name
@Manager varchar(255)
as
declare @dep varchar(255),@comp varchar(255)
select @dep=s.department,@comp=s.company from Staff_Members s where s.username=@Manager
select distinct p.name from Projects p inner join Staff_Members sm on p.manager=sm.username
where  sm.department=@dep and sm.company=@comp

--12 Review a task that I created in a certain project which has a state ‘Fixed’, and either accept or reject it. If I accept it, then its state would be ‘Closed’, otherwise it will be re-assigned to the same regular employee with state ‘Assigned’. The task should have now a new deadline.
go
alter proc Review_Assign_Regular_Task_Manager
@MHRusername varchar(255),@project_name varchar(255),@taskName varchar(255),
@response varchar(255), @deadline datetime=null
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department from Staff_Members s inner join Managers m
on s.username=m.username where s.username=@MHRusername

	if(@response='rejected' and @deadline is not null)
	begin
	    declare @start_date datetime, @end_date datetime
	    select @start_date=start_date, @end_date=end_date from Projects p
	    where p.name=@project_name and p.company=@MHRcompany
		if(@start_date<=@deadline and @deadline<=@end_date)
		begin
		select t.name from Tasks t where t.company=@MHRcompany
		and t.project=@project_name and t.manager=@MHRusername and t.name=@taskName
		update Tasks
		set  status='Assigned', deadline=@deadline
		where @MHRusername=manager and company=@MHRcompany and @project_name=project and @taskName=Tasks.name and status='Fixed'
		end
    end
	else
    begin
    if(@response='accepted')
	begin

	update Tasks
	set  status='Closed'
	where @MHRusername=manager and company=@MHRcompany and @project_name=project and @taskName=Tasks.name and status='Fixed'

	end
	end


--6 Assign regular employees to work on any project in my department. Regular employees should be working in the same department. Make sure that the regular employee is not working on more than two projects at the same time.
go
alter proc Assign_Regular_To_Project
@MHRusername varchar(255), @titleOfProject varchar(255), @username varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername

declare @ProjectsCount int
select @ProjectsCount=count(project_name)
from Managers_assign_Regular_Employees_Projects a
where a.company=@MHRcompany  and  a.regular_employee=@username
if(@ProjectsCount<2)
begin
insert into Managers_assign_Regular_Employees_Projects values(@titleOfProject,@MHRcompany,@username,@MHRusername)
end

go
alter proc Manager_View_Applications_Before_HR
@MHRusername varchar(255),@job varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s
where s.username=@MHRusername

select js.*, u.years_of_experinece,u.age,
j.no_of_vacanies,j.short_description,j.detailed_description,j.min_experience
from Job_Seeker_apply_Jobs js inner join Jobs j
on js.job=j.title and js.department= j.department and j.company=js.company
inner join Users u
on js.job_Seekers=u.username
where j.department=@MHRdepartment and js.company=@MHRcompany and hr_response='Accepted' and js.job=@job
