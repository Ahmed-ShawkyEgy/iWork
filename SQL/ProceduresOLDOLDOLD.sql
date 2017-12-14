
--“As an registered/unregistered user, I should be able to ...”
-- 1 Search for any company by its name or address or its type (national/international).
Go
create procedure search -- procedure takes 4 inputs name of the company or address of the company or the type of company and returns company record with satisfies the input
@name  varchar(255)=null, @address varchar(255)=null, @type  varchar(255)=null as
SELECT * 
FROM Companies c
WHERE c.name  = @name or c.address=@address or c.type=@type ;
exec search @address='the second Building above your glasses'
--2 View a list of all available companies on the system along with all information of the company.
go
create proc View_All_Companies as -- procedure view all the companies that offer a job
select c1.*,c2.phone 
from Companies c1 inner join Companies_Phones c2 
on c2.company=c1.email 

-- shows all companies ordered by type
go
create proc View_All_Companies_Type as 
select c1.*,c2.phone 
from Companies c1 inner join Companies_Phones c2 
on c2.company=c1.email
order by c1.type

--exec View_All_Companies_Type

-- 3 View the information of a certain company along with the departments in that company.
go
create procedure departments_of_company @name varchar(255) as -- procedure view departments in the company
select c.*,d.code, d.name
from Companies c inner join Departments d 
on d.company=c.email
where c.name=@name;

-- 4 View the information of a certain department in a certain company along with the jobs that have vacancies in it.
go
create procedure vacant_job -- procedure takes 2 inputs department name and comapany name and view records of vacancies jobs in that department which exists in that company
@name_departement varchar(255), @name_company varchar(255) 
as
select c.name, d.code, j.title
from Companies c inner join Departments d 
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
where c.name=@name_company and d.code=@name_departement and j.no_of_vacanies>0

--5 Register to the website to be able to apply for any job later on. Any user has to register in the website with a unique username and a password, along with all the needed information.
go 
create procedure Register_User -- procedure takes all requested and required user information and insert this users in User table
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


--exec Register_User @username='hi2', @password='234',@personal_email='hi12@gmail.com',@birth_date='19970523', @years_of_experince=5, @first_name='jfo', @middle_name='kgo' , @last_name='noh'

-- procedure let the user to insert pervious job if she/he had one
go 
create procedure Insert_Previous_Job 
@username varchar(255), @previousJobs varchar(255)
 as
 insert into Users_Jobs values(@username,@previousJobs)
 

 
--6 Search for jobs that have vacancies on the system and their short description or title contain a string of keywords entered by the user. All information of the job should be displayed along with the company name and the department it belongs to.
go
create procedure search_job -- procedure search for jobs based on short description or title of the job that the user enter as an input
@shortDescription varchar(255)=null, @title varchar(255)=null
as
select c.name, j.company ,d.code, j.title,j.short_description,j.detailed_description,j.min_experience,j.salary,j.deadline,j.no_of_vacanies,j.working_hours
from Companies c inner join Departments d 
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
where j.no_of_vacanies>0 and (j.title like ('%'+@title+'%') or j.short_description like ('%'+@shortDescription+'%'))


 --7 View companies in the order of having the highest average salaries.
go
create procedure companies_by_average_salary_order -- procedure views companies in the order of having the highest average salaris
as
select c.name,avg(j.salary)
from Companies c inner join Departments d 
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
group by c.name
order by avg(j.salary);

--Function that specify the type of the users
go 
create function Type_Idenitifer -- function takes username as an input and returns the user type (HR ,manager , job seeker or regular employees)
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

--Find_Type shows a table with one entry that is the type of the user that was input as an input for the procedure ;)
go
create proc Find_Type
@username varchar(255)
as
declare @temp table(
tmp varchar(255)
)
insert into @temp values(dbo.Type_Idenitifer(@username))
select * from @temp


--exec Find_Type @username='Betty'

--“As a registered user, I should be able to ...”
--1 Login to the website using my username and password which checks that i am an existing user, and whether i am job seeker, HR employee, Regular employee or manager.
go 
create procedure login_user -- procedure takes username and password and check for user existances in the user table and if exists it login the user and print a hello message !!
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

	--exec login_user @username='Trissy', @password='ReHead'
-- View all possible information about user
go 
create procedure all_possible_information -- procedure takes username and check if there is a user exists with that username in users table and if so it show all the user information
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
end


--3 Edit all of my personal information.
go 
create procedure edit_user_info -- procedure let the user to edit this/here information

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

--“As a job seeker, I should be able to ...”
-- Apply for any job as long as I have the needed years of experience for the job. Make sure that a job seeker can’t apply for a job, if he/she applied for it before and the application is still pending.
go 
create proc Apply_Job
@username varchar(255), @title varchar(255), @company varchar(255), @department varchar(255) 
as
if not exists  (select j.job_Seekers from Job_Seeker_apply_Jobs j 
where j.company=@company and j.department=@department and j.job=@title and j.job_Seekers=@username)
begin
insert into Job_Seeker_apply_Jobs (job, department, company,job_Seekers)
select j.title, j.department,j.company,u.username
from Jobs j, Users u inner join Job_Seekers k
on  u.username=k.username
where j.title=@title and j.company=@company and j.department=@department and u.username=@username 
and k.username=@username and u.years_of_experinece>=j.min_experience and j.no_of_vacanies>0
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
end

--2 View the interview questions related to the job I am applying for.
go
create proc View_Questions
@username varchar(255),@title varchar(255), @departement varchar(255), @company varchar(255)
as 
if exists (select * from Job_Seeker_apply_Jobs where @username=job_Seekers and @title=job and @company=company and @departement=department)
begin
select q.question
from Jobs_has_Questions j inner join Questions q
on q.number = j.question 
where @title = j.job and @departement=j.department and @company=j.company
end
--3 Save the score I got while applying for a certain job.
go 
create  proc Save_Score
@username varchar(255),@title varchar(255), @departement varchar(255), @company varchar(255), @score int
as
Update Job_Seeker_apply_Jobs 
set score =@score
where @username=job_Seekers and @title=job and @departement=department and @company= company 
--Shows Answers of the interview questions for a certain job
go
create proc Show_Answers
@JobTitle varchar(255), @company varchar(255),@department varchar(255)
as
select q.number, q.answer
from Jobs_has_Questions j inner join Questions q
on j.question=q.number
where j.job=@JobTitle and j.question=q.number and j.company=@company and j.department=@department

--4 View the status of all jobs I applied for before (whether it is finally accepted, rejected or still in the review process), along with the score of the interview questions.
go
create proc View_Jobs_Status 
@username varchar(255)
as
select jsaj.hr_response , jsaj.manager_response , jsaj.score
from Job_Seeker_apply_Jobs jsaj inner join Job_Seekers js
on jsaj.job_Seekers = js.username
where @username = js.username


--5 Choose a job from the jobs I was accepted in, which would make me a staﬀ member in the company and the department that oﬀered this job. Accordingly, my salary and company email are set, and I get 30 annual leaves. In addition, I should also choose one day-oﬀ other than Friday. The number of vacancies for the assigned job has to be updated too.
go 
create proc Select_Job
@username varchar(255),@title varchar(255), @departement varchar(255), @company varchar(255), @dayoff varchar(255), @managerType varchar(255)=null
as
declare @hr_response varchar(255), @manager_response varchar(255)
select @hr_response = hr_response , @manager_response = manager_response
from Job_Seeker_apply_Jobs
where job_Seekers = @username and company = @company and job = @title and department = @departement
if((@hr_response='Accepted' and @manager_response='Accepted' ))
begin
if((@title like 'Manager - %' and @managerType is not null) or(@title like 'HR_Employee - %')or (@title like 'Regular_Employee - %'))
begin
insert into Staff_Members (username, job, department, company)
select u.username, j.job,j.department,j.company
from Job_Seeker_apply_Jobs j inner join Users u
on j.job_Seekers= u.username
where hr_response='Accepted' and manager_response='Accepted' and @username=u.username and j.company=@company and j.job=@title 
and j.department=@departement
Update Staff_Members
set annual_leaves=30,  company_email= (@username+''+c.domain), day_off=@dayoff, salary=j.salary 
from Companies c, Jobs j inner join Job_Seeker_apply_Jobs js
on j.title=js.job
where c.email=@company and @dayoff <> 'Friday' and @dayoff <> 'friday' and j.title=@title and @username=username
insert into Users_Jobs
select s.username, s.job
from Staff_Members s
where s.username=@username
delete from Job_Seeker_apply_Jobs
where job_Seekers=@username
delete from Job_Seekers 
where username=@username 
update Jobs
set no_of_vacanies=no_of_vacanies-1
where title=@title and department=@departement and company=@company

if(@title like 'Manager - %' and @managerType is not null)
insert into Managers values (@username,@managerType)

if(@title like 'HR_Employee - %')
insert into HR_Employees values(@username)

if(@title like 'Regular_Employee - %')
insert into Regular_Employees values (@username)
end
end


--6 Delete any job application I applied for as long as it is still in the review process.
go 
create proc Delete_My_Applied_Job
@username varchar(255),@title varchar(255), @departement varchar(255), @company varchar(255)
as
delete from Job_Seeker_apply_Jobs
where job_Seekers = @username and job = @title and company = @company and department = @departement and (hr_response='Pending' or manager_response='Pending')

--“As a staﬀ member, I should be able to ...”
--1 Check-in once I arrive each day.
go 
create proc Check_In
@username varchar(255)
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
insert  into Attendance_Records (date, staff,start_time) values (CONVERT (date, CURRENT_TIMESTAMP),@username,CONVERT(VARCHAR(5), GETDATE(), 108)+':00'+' ' + RIGHT(CONVERT(VARCHAR(30), GETDATE(), 9),2))
end

--2 Check-out before I leave each day.
go 
create proc Check_Out
@username varchar(255)
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
Update  Attendance_Records
set  end_time= CONVERT(VARCHAR(5), GETDATE(), 108)+':00'+' ' + RIGHT(CONVERT(VARCHAR(30), GETDATE(), 9),2)
where date=CONVERT (date, CURRENT_TIMESTAMP) and @username=staff
end

--Function that calculates the time difference 
go
create function time_Diff
(@Time_Start time, @Time_End time)
returns time
as
begin
declare @t int
if(@Time_End>@Time_Start)
set @t =DateDiff(mi, @Time_Start,@Time_End)
else
set @t =DateDiff(mi,@Time_End,@Time_Start)
declare @t2 int= @t/60
declare @t3 int = @t%60
declare @result time=cast(( CONVERT(varchar(10), @t2)+':'+CONVERT(varchar(10), @t3)+':00') as time)
return @result
end


--3  View all my attendance records (check-in time, check-out time, duration, missing hours) within a certain period of time.
go
create proc View_Attendance 
@username varchar(255)
as
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
where s.username = @username
select  a.*, t.missing_hours, t.duration
from Attendance_Records a inner join @time t 
on a.date=t.date
where staff = @username

--4 Apply for requests of both types: leave requests or business trip requests, by supplying all the needed information for the request. As a staﬀ member, I can not apply for a leave if I exceeded the number of annual leaves allowed. If I am a manager applying for a request, the request does not need to be approved, but it only needs to be kept track of. Also, I can not apply for a request when it’s applied period overlaps with another request.
go
create proc Apply_Request
@username varchar(255),@start_date datetime,@end_date datetime,@type varchar(255)=null,@destination varchar(255)=null,@purpose varchar(255)= null,
@usernameReplacement varchar(255)
as
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

--5 View the status of all requests I applied for before (HR employee and manager responses).
go
create proc View_All_Status_Requests
@username varchar(255)
as
select *
from Requests
where @username=applicant and hr_response ='Pending' and manager_response ='Pending'

--6 Delete any request I applied for as long as it is still in the review process.
go
create proc Delete_Status_Requests
@username varchar(255),@request_date datetime
as
Delete from Requests
where @username=applicant and (hr_response ='Pending' or manager_response ='Pending') and @request_date=start_date

--7 Send emails to staﬀ members in my company.
go
create proc Send_Email
@username varchar(255),@recipient varchar(255),@subject varchar(255),@body varchar(255)
as
declare @usernameCompany varchar(255)
select @usernameCompany = company
from Staff_Members
where @username = username
if exists(select * from Staff_Members where company = @usernameCompany and username = @recipient)
begin
insert into Emails (subject,date,body) values(@subject,cast(CURRENT_TIMESTAMP as date),@body)
insert into Staff_send_Email_Staff
select IDENT_CURRENT('dbo.Emails') , @recipient ,@username
end

--8 View emails sent to me by other staﬀ members of my company.
go
create proc View_Email
@username varchar(255)
as
select e.subject,e.date,sses.recipient,sses.sender,e.body
from Emails e inner join Staff_send_Email_Staff sses on e.serial_number = sses.email_number
where recipient = @username

--9 Reply to an email sent to me, while the reply would be saved in the database as a new email record.
go
create proc Reply_Email
@username varchar(255),@emailId int, @subject varchar(255),@body varchar(255)
as
declare @sender varchar(255)
if exists(select * from Staff_send_Email_Staff e where  @emailId = e.email_number and e.recipient =  @username)
begin
select @sender = sender
from Staff_send_Email_Staff
where recipient = @username and email_number = @emailId
insert into Emails (subject,date,body) values(@subject,cast(CURRENT_TIMESTAMP as date),@body)
insert into Staff_send_Email_Staff
select IDENT_CURRENT('dbo.Emails') , @sender ,@username
end

--10 View announcements related to my company within the past 20 days.
go
create proc Check_Announcments
@username varchar(255)
as 
select a.*
from Staff_Members s,
Announcements a inner join HR_Employees h on a.hr_employee=h.username
inner join Staff_Members sh  on sh.username=h.username and a.hr_employee=sh.username
where @username=s.username and s.company=sh.company and 20>=Cast(DateDiff(day,a.date,CURRENT_TIMESTAMP )as int)

--“As an HR employee, I should be able to ...”
--1 Add a new job that belongs to my department, including all the information needed about the job and its interview questions along with their model answers. The title of the added job should contain at the beginning the role that will be assigned to the job seeker if he/she was accepted in this job; for example: “Manager - Junior Sales Manager”.
go 
create proc Creating_Job
@HRusername varchar(255),@title varchar(255), @short_description varchar(255),
@detailed_description varchar(255), @min_experience int,@salary DECIMAL (10, 2),@deadline DATETIME, @no_of_vacancies int, 
@working_hours time
as
if(@title like 'Manager - %' or @title like 'Regular_Employee - %' or @title like 'HR_Employee - %')
begin
if exists(select * from HR_Employees h where h.username=@HRusername)
	begin 
	insert into Jobs 
	select @title,u.department, u.company, @short_description, @detailed_description, @min_experience,
	@salary,@deadline,@no_of_vacancies,@working_hours
	from HR_Employees h inner join Staff_Members u 
	on h.username=u.username
	where @HRusername=h.username
	end
	end

--2 View information about a job in my department.
go
create proc View_Info
@HRusername varchar(255),@title varchar(255)
as
if exists(select * from HR_Employees h where h.username=@HRusername)
	begin
	select j.*
	from jobs j inner join Staff_Members s 
	on j.department= s.department and j.company = s.company
	where j.title=@title and s.username=@HRusername 
	end

--3 Edit the information of a job in my department.
go
create proc Edit_Info
@HRusername varchar(255),@title varchar(255),@short_description varchar(255)=null,
@detailed_description varchar(255)=null, @min_experience int=null,@salary DECIMAL (10, 2)=null,@deadline DATETIME=null,
@no_of_vacancies int=null, @working_hours time=null
as
declare @company varchar(255), @department varchar(255)
select @company=s.company, @department=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
where j.title=@title and s.username=@HRusername 
if exists(select * from HR_Employees h where h.username=@HRusername)
begin
Update Jobs
set Jobs.short_description=@short_description
where @company=Jobs.company and @department=Jobs.department  and @title=Jobs.title and @short_description is not null 
Update Jobs
set Jobs.detailed_description=@detailed_description
where @company=Jobs.company and @department=Jobs.department  and @title=Jobs.title and @detailed_description is not null 
Update Jobs
set Jobs.min_experience=@min_experience
where @company=Jobs.company and @department=Jobs.department  and @title=Jobs.title and @min_experience is not null
Update Jobs
set Jobs.salary=@salary
where @company=Jobs.company and @department=Jobs.department  and @title=Jobs.title and @salary is not null
Update Jobs
set Jobs.deadline=@deadline
where @company=Jobs.company and @department=Jobs.department  and @title=Jobs.title and @deadline is not null
Update Jobs
set Jobs.no_of_vacanies=@no_of_vacancies
where @company=Jobs.company and @department=Jobs.department  and @title=Jobs.title and @no_of_vacancies is not null
Update Jobs
set Jobs.working_hours=@working_hours
where @company=Jobs.company and @department=Jobs.department  and @title=Jobs.title and @working_hours is not null
end

--4 View new applications for a specific job in my department. For each application, I should be able to check information about the job seeker, job, the score he/she got while applying.
go 
create proc View_New_Application
@HRusername varchar(255),@title varchar(255)
as
declare @company varchar(255), @department varchar(255)
select @company=s.company, @department=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
where s.username=@HRusername 
if exists(select * from HR_Employees h where h.username=@HRusername)
begin
select u.username,u.personal_email,u.birth_date,u.years_of_experinece,u.first_name,u.last_name,u.age,j.job,j.score
from Job_Seeker_apply_Jobs j inner join Users u
on j.job_Seekers=u.username
where j.company=@company and j.department=@department and @title=j.job and j.hr_response ='Pending' and j.manager_response ='Pending'
end

--5 Accept or reject applications for jobs in my department.
go
create proc Accept_Or_Reject
@HRusername varchar(255),@ApplicantUsername varchar(255), @title varchar(255), @response varchar(255)
as
declare @company varchar(255), @department varchar(255)
select @company=s.company, @department=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
where s.username=@HRusername 
if exists(select * from HR_Employees h where h.username=@HRusername)
begin
if(@response='Accepted')
Update Job_Seeker_apply_Jobs
set hr_response=@response
where @ApplicantUsername=job_Seekers and @title=job and @company=company and @department=department and (@response='Accepted' or @response='Rejected')
if(@response='Rejected')
begin
Update Job_Seeker_apply_Jobs
set hr_response=@response, manager_response=@response
where @ApplicantUsername=job_Seekers and @title=job and @company=company and @department=department and (@response='Accepted' or @response='Rejected')
end
end

--6 Post announcements related to my company to inform staﬀ members about new updates.
go 
create proc Post_Announcement
@HRusername varchar(255), @title varchar(255), @type varchar(255),@desciption varchar(255)
as
if exists(select * from HR_Employees h where h.username=@HRusername)
begin
insert into Announcements values(Cast(CURRENT_TIMESTAMP as date), @title, @HRusername, @type, @desciption)
end

--7 View requests (business or leave) of staﬀ members working with me in the same department that were approved by a manager only.
go 
create proc View_Requests
@HRusername varchar(255)
as
declare @company varchar(255), @department varchar(255)
select @company=s.company, @department=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
where s.username=@HRusername 
if exists(select * from HR_Employees h where h.username=@HRusername)
begin
if exists (select * from Requests r inner join Staff_Members sm on sm.username = r.applicant inner join Leave_Requests lr on  (r.start_date = lr.start_date and r.applicant = lr.applicant) where r.hr_response='Pending' and r.manager_response = 'Accepted' and sm.company = @company and sm.department = @department)
 select sm.username,sm.annual_leaves,sm.day_off,sm.job,r.start_date,r.end_date,r.request_date,r.manager_response,r.manager,r.total_days,lr.*
 from Requests r inner join Staff_Members sm 
 on sm.username = r.applicant
 inner join Leave_Requests lr 
 on  (r.start_date = lr.start_date and r.applicant = lr.applicant)
 where r.hr_response='Pending' and r.manager_response = 'Accepted' and sm.company = @company and sm.department = @department
	if exists (select * from Requests r inner join Staff_Members sm on sm.username = r.applicant inner join Business_Trip_Requests btr on  (r.start_date = btr.start_date and r.applicant = btr.applicant) where r.hr_response ='Pending' and r.manager_response = 'Accepted' and sm.company = @company and sm.department = @department)
	begin
	select sm.username,sm.annual_leaves,sm.day_off,sm.job,r.start_date,r.end_date,r.request_date,r.manager_response,r.manager,r.total_days,btr.*
	from Requests r inner join Staff_Members sm 
	on sm.username = r.applicant
	inner join Business_Trip_Requests btr
	on  (r.start_date = btr.start_date and r.applicant = btr.applicant) 
	where r.hr_response ='Pending' and r.manager_response = 'Accepted' and sm.company = @company and sm.department = @department
	end 
	end 

-- 8 Accept or reject requests of staﬀ members working with me in the same department that were approved by a manager. My response decides the final status of the request, therefore the annual leaves of the applying staﬀ member should be updated in case the request was accepted. Take into consideration that if the duration of the request includes the staﬀ member’s weekly day-oﬀ and/or Friday, they should not be counted as annual leaves.
go 
create proc Accept_Or_Reject_Manager_Accepted
@HRusername varchar(255), @response varchar(255), @applicant varchar(255), @start_date date
as
declare @HRcompany varchar(255), @HRdepartment varchar(255)
select @HRcompany=s.company, @HRdepartment=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
where s.username=@HRusername 
declare @HRresponse varchar(255)
select @HRresponse=r.hr_response
from Requests r 
where r.applicant=@applicant and r.start_date=@start_date
declare @company varchar(255), @department varchar(255)
select @company=s.company, @department=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
if exists (select * from Requests where @applicant=applicant and cast(@start_date as date)=start_date)
begin
declare @manager_response varchar(255)
select @manager_response=manager_response
from Requests
where @applicant=applicant and @start_date=start_date
if((@response = 'accepted' or @response='rejected' ) and @HRcompany=@company and @HRdepartment=@department and @manager_response='Accepted')
	begin
	if exists(select * from HR_Employees h where h.username=@HRusername)
		begin
		declare @end_date date
		select @end_date=end_date
		from Requests
		where @applicant=applicant and  @start_date=start_date

		declare @offday varchar(255), @annual_leaves varchar(255)
		select @offday=day_off, @annual_leaves=annual_leaves
		from Staff_Members
		where @applicant=username

		declare @totalAmount int=0
		declare @duration int=Cast(DateDiff(day,@end_date,@start_date) as int)
		declare @dateIncrementor datetime = @start_date
		while (@duration>0)
			begin
			if(DATENAME(weekday, @dateIncrementor)<>'Friday' and DATENAME(weekday, @dateIncrementor) <> @offday)
				begin
				set @totalAmount=@totalAmount+1
			end
				set @duration=@duration-1
				set @dateIncrementor=DATEADD(day, 1, @dateIncrementor)
		end
		if((@annual_leaves-@totalAmount)>=0 and @response = 'accepted')
			begin
			update Staff_Members
			set annual_leaves=(annual_leaves-@totalAmount)
			where username = @applicant
			

			update Requests
			set hr_employee=@HRusername, hr_response=@response
			where applicant=@applicant and @start_date=start_date
			end
		else 
		begin
			update Requests
			set hr_employee=@HRusername, hr_response=@response
			where applicant=@applicant and @start_date=start_date
		end
		end
	end
	end

--9 View the attendance records of any staﬀ member in my department (check-in time, check-out time, duration, missing hours) within a certain period of time.
go
 create proc View_Attendance_Between_Certain_Period
 @HRusername varchaR(255), @SMusername varchar(255), @start_date datetime, @end_date datetime
 as
 if exists(select * from HR_Employees h where h.username=@HRusername)
begin
declare @HRcompany varchar(255), @HRdepartment varchar(255)
select @HRcompany=s.company, @HRdepartment=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
where s.username=@HRusername 
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

--10 View the total number of hours for any staﬀ member in my department in each month of a certain year.
go
 create proc Total_Number_Hours
 @HRusername varchaR(255), @SMusername varchar(255),  @year int
 as
 if exists(select * from HR_Employees h where h.username=@HRusername)
begin
declare @HRcompany varchar(255), @HRdepartment varchar(255)
select @HRcompany=s.company, @HRdepartment=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
where s.username=@HRusername 
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
declare @counter int=1

declare @monthTable table(
	month int,
	monthTime varchar(255)
)
while(@counter<=12)
begin
insert into @monthTable
select @counter, (cast(SUM(DATEDIFF(mi,0,duration)/60)as varchar)+':'+cast(SUM(DATEDIFF(mi,0,duration)%60)as varchar)+':00') 
from @time
where year(date)=@year and MONTH(date)=@counter
set @counter=@counter+1
end
select * from @monthTable
end

--11 View names of the top 3 high achievers in my department. A high achiever is a regular employee who stayed the longest hours in the company for a certain month and all tasks assigned to him/her with deadline within this month are fixed.
go
create proc Highest_Achievers
@HRusername varchar(255), @month int
as 
if exists(select * from HR_Employees h where h.username=@HRusername)
begin
declare @HRcompany varchar(255), @HRdepartment varchar(255)
select @HRcompany=s.company, @HRdepartment=s.department
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
where s.username=@HRusername 
declare @time table
(
	date datetime,
	staff varchar(255),
	company varchar(255),
	department varchar(255),
    missing_hours time,
	duration time
)
insert into @time
select a.date,a.staff,s.company, s.department,dbo.time_Diff(j.working_hours,dbo.time_Diff(a.end_time , a.start_time)),dbo.time_Diff(a.end_time , a.start_time)
from Users u inner join Staff_Members s on u.username=s.username
inner join Attendance_Records a on a.staff = s.username and u.username=a.staff
inner join Staff_Members uj on uj.username = a.staff and uj.username =u.username and uj.username = s.username
inner join Jobs j on uj.job = j.title and u.username= uj.username and s.company=j.company and s.department=j.department 
where @HRcompany= s.company and @HRdepartment=s.department

declare @timeTotal table
(
	staff varchar(255),
	company varchar(255),
	department varchar(255),
    totalHours int
	)
insert into @timeTotal
select distinct a.staff , a.company, a.department,SUM(DATEDIFF(hh,0,a.duration))
from @time a
where month(date)=@month
group by a.staff, a.company, a.department
order by SUM(DATEDIFF(hh,0,a.duration)) desc

SELECT TOP 3 s.staff
FROM  @timeTotal s
WHERE @HRcompany= s.company and @HRdepartment=s.department
ORDER BY s.totalHours 
end

--“As a regular employee, I should be able to ...”
--1 View a list of projects assigned to me along with all of their information.
go
create proc View_Projects
@username varchar(255)
as
select  p.*
from Managers_assign_Regular_Employees_Projects mare inner join Projects p 
on mare.project_name=p.name
where @username=mare.regular_employee and mare.company=p.company

--2 View a list of tasks in a certain project assigned to me along with all of their information and status.
go
create proc View_Task
@username varchar(255),@project varchar(255)
as
select t.*
from Projects p inner join Tasks t 
on p.name=t.project 
inner join Staff_Members s
on s.username= t.regular_employee
where @username=s.username and t.company=p.company and s.company=t.company and @project=p.name

--3 After finalizing a task, I can change the status of this task to ‘Fixed’ as long as it did not pass the deadline.
go
create proc Change_To_Fixed_Task
@username varchar(255), @task varchar(255),@project varchar(255)
as 
Update Tasks
set status='Fixed'
where name=@task and @username=regular_employee and cast(CURRENT_TIMESTAMP as date) < cast(deadline as date) and @project=project

--4 Work on the task again (a task that was assigned to me before). I can change the status of this task from ‘Fixed’ to ‘Assigned’ as long as the deadline did not pass and it was not reviewed by the manager yet.
go
create proc Change_Status_To_Assigned_Again
@username varchar(255), @task varchar(255),@project varchar(255)
as 
Update Tasks
set status='Assigned'
where name=@task and @username=regular_employee and cast(CURRENT_TIMESTAMP as date) < cast(deadline as date) and status = 'Fixed' and @project=project

--“As a manager, I should be able to ...”
--1 View new requests from staﬀ members working in my department. Note that only managers with type = ‘HR’ are allowed to review requests applied for by HR employees, and this manager’s review is considered the final decision taken for this request, i.e. it does not pass by an HR employee afterwards.
go
create proc Final_Accept_Request
@MHRusername varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255),@type varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department, @type=m.type
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
inner join Managers m
on s.username=m.username
where s.username=@MHRusername 
if (@type='HR')
begin
select r.*
from Requests r inner join Staff_Members s
on r.applicant = s.username
where s.company=@MHRcompany and s.department=@MHRdepartment and r.manager is null and @type='HR'
end
else 
begin
select r.*
from Requests r inner join Staff_Members s
on r.applicant = s.username
where s.company=@MHRcompany and s.department=@MHRdepartment and r.manager is null and 
not exists(select * from HR_Employees h where s.username=h.username)
end

--2 Accept or reject requests from staﬀ members working in my department before being reviewed by the HR employee. In case of disapproval, I should provide a reason to be saved.
go
create proc Accept_Reject_Request_Manager
@MHRusername varchar(255), @response varchar(255),@reason varchar(max)=null, @username varchar(255), @start_date datetime
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255),@type varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department, @type=m.type
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
inner join Managers m
on s.username=m.username
where s.username=@MHRusername
if exists(select * from Staff_Members s where s.department=@MHRdepartment and s.company=@MHRcompany and s.username=@username)
begin
if(@response='accepted')
begin
Update Requests
set manager_response=@response, manager=@MHRusername, hr_response=@response
where @username=applicant and @start_date=cast(start_date as date)  and hr_response ='Pending'
end
else
begin
if(@response='rejected')
begin
Update Requests
set manager_response=@response, manager=@MHRusername, manager_reason=@reason
where @username=applicant and @start_date=cast(start_date as date) and hr_response ='Pending' and @reason is not null
end
end
end

--3 View applications for a specific job in my department that were approved by an HR employee. For each application, I should be able to check information about the job seeker, job, and the score he/she got while applying.
go
create proc Manager_View_Applications_Before_HR
@MHRusername varchar(255),@job varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
select js.*, u.personal_email, u.years_of_experinece,u.first_name,u.middle_name,u.last_name,u.age,
j.no_of_vacanies,j.short_description,j.detailed_description,j.min_experience
from Job_Seeker_apply_Jobs js inner join Jobs j 
on js.job=j.title and js.department= j.department and j.company=js.company
inner join Users u 
on js.job_Seekers=u.username
where j.department=@MHRdepartment and js.company=@MHRcompany and hr_response='Pending' 

--4 Accept or reject job applications to jobs related to my department after being approved by an HR employee.
go
create proc Manager_Accept_Reject_Applications_After_HR
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
begin
if(@response='Accepted' or @response='Rejected')
begin
Update Job_Seeker_apply_Jobs 
set manager_response=@response, hr_response=@response
where @username=job_Seekers and hr_response is not null and company=@MHRcompany and department=@MHRdepartment and @Job=job
end
end

--5 Create a new project in my department with all of its information
go
create proc Create_New_Project
@MHRusername varchar(255), @title varchar(255), @start_date datetime, @end_date datetime 
as
declare @MHRcompany varchar(255)
select @MHRcompany=s.company
from jobs j inner join Staff_Members s 
on j.department= s.department and j.company = s.company
inner join Managers m
on s.username=m.username
where s.username=@MHRusername
insert into Projects values(@title,@MHRcompany,@start_date,@end_date,@MHRusername)

--6 Assign regular employees to work on any project in my department. Regular employees should be working in the same department. Make sure that the regular employee is not working on more than two projects at the same time.
go
create proc Assign_Regular_To_Project
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
where a.company=@MHRcompany and a.regular_employee=regular_employee and  a.regular_employee=@username
if(@ProjectsCount<2)
begin 
insert into Managers_assign_Regular_Employees_Projects values(@titleOfProject,@MHRcompany,@username,@MHRusername)
end 

--7 Remove regular employees assigned to a project as long as they don’t have tasks assigned to him/her in this project.
go
create proc Remove_Regular_To_Project
@MHRusername varchar(255), @titleOfProject varchar(255), @username varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
delete from Managers_assign_Regular_Employees_Projects
where @username=regular_employee and @titleOfProject=project_name and company=@MHRcompany and
not exists
(select t.* 
from Tasks t inner join Projects p 
on t.project=p.name and t.company=p.company 
where p.name=@titleOfProject and t.regular_employee=@username)

--8 Define a task in a project in my department which will have status ‘Open’.
go
create proc Create_Task_Manager
@MHRusername varchar(255), @taskName varchar(255),@project_name varchar(255), @deadline datetime, @status varchar(255)='Open',
@description varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
declare @start_date datetime, @end_date datetime
select @start_date=start_date, @end_date=end_date
from Projects p
where p.name=@project_name and p.company=@MHRcompany
if(@start_date<=@deadline and @deadline<=@end_date)
insert into Tasks (name,project,company,deadline,status,description,manager)
values (@taskName,@project_name,@MHRcompany,@deadline,@status,@description,@MHRusername)

--9 Assign one regular employee (from those already assigned to the project) to work on an already defined task by me in this project.
go
create proc Assign_Regular_Task_Manager
@MHRusername varchar(255), @regular_employee varchar(255),@project_name varchar(255),@taskName varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
if exists(select * from Managers_assign_Regular_Employees_Projects where @project_name=project_name and regular_employee=@regular_employee)
begin
update Tasks 
set regular_employee=@regular_employee, status='Assigned'
where @MHRusername=manager and company=@MHRcompany and @project_name=project and @taskName=Tasks.name 
end 

--10 Change the regular employee working on a task on the condition that its state is ‘Assigned’
go 
create proc Change_Regular_Task_Manager
@MHRusername varchar(255), @regular_employee varchar(255),@project_name varchar(255),@taskName varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
update Tasks 
set regular_employee=@regular_employee
where @MHRusername=manager and company=@MHRcompany and @project_name=project and @taskName=Tasks.name  and status='Assigned'

--11 View a list of tasks in a certain project that have a certain status.
go
create proc View_Tasks_Manager_With_Certain_Conditions
@MHRusername varchar(255),@project_name varchar(255),@status varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
select *
from Tasks
where @project_name=project and @status=status and company=@MHRcompany

--12 Review a task that I created in a certain project which has a state ‘Fixed’, and either accept or reject it. If I accept it, then its state would be ‘Closed’, otherwise it will be re-assigned to the same regular employee with state ‘Assigned’. The task should have now a new deadline.
go
create proc Review_Assign_Regular_Task_Manager
@MHRusername varchar(255),@project_name varchar(255),@taskName varchar(255), @response varchar(255), @deadline datetime=null
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername
if(@response='rejected' and @deadline is not null)
update Tasks 
set  status='Assigned', deadline=@deadline
where @MHRusername=manager and company=@MHRcompany and @project_name=project and @taskName=Tasks.name and status='Fixed'
else 
if(@response='accepted')
begin
declare @start_date datetime, @end_date datetime
select @start_date=start_date, @end_date=end_date
from Projects p
where p.name=@project_name and p.company=@MHRcompany
if(@start_date<=@deadline and @deadline<=@end_date)
begin
update Tasks 
set  status='Closed'
where @MHRusername=manager and company=@MHRcompany and @project_name=project and @taskName=Tasks.name and status='Fixed'
end
end
----------------------------------------------new M3 part--------------------------------------------------------

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
alter proc View_All_Companies_Type as
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
alter proc Find_Type
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
-------------
if exists  (select * from Jobs j where j.company=@company and j.department=@department and j.title=@title and j.no_of_vacanies=0)
begin
declare @table5 table(tmp int)
select * from @table5
return
end
----------------
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

go
alter proc Select_Job
@username varchar(255),@title varchar(255), @departement varchar(255), @company varchar(255), @dayoff varchar(255), @managerType varchar(255)=null
as
declare @hr_response varchar(255), @manager_response varchar(255)
select @hr_response = hr_response , @manager_response = manager_response
from Job_Seeker_apply_Jobs
where job_Seekers = @username and company = @company and job = @title and department = @departement
if((@hr_response='Accepted' and @manager_response='Accepted' ))
begin
if((@title like 'Manager - %' and @managerType is not null) or(@title like 'HR_Employee - %')or (@title like 'Regular_Employee - %'))
begin
insert into Staff_Members (username, job, department, company)
select u.username, j.job,j.department,j.company
from Job_Seeker_apply_Jobs j inner join Users u
on j.job_Seekers= u.username
where hr_response='Accepted' and manager_response='Accepted' and @username=u.username and j.company=@company and j.job=@title
and j.department=@departement
Update Staff_Members
set annual_leaves=30,  company_email= (@username+''+c.domain), day_off=@dayoff, salary=j.salary
from Companies c, Jobs j inner join Job_Seeker_apply_Jobs js
on j.title=js.job
where c.email=@company and @dayoff <> 'Friday' and @dayoff <> 'friday' and j.title=@title and @username=username
insert into Users_Jobs
select s.username, s.job
from Staff_Members s
where s.username=@username
delete from Job_Seeker_apply_Jobs
where job_Seekers=@username and @title=job and @departement=department and @company=company
update Jobs
set no_of_vacanies=no_of_vacanies-1
where title=@title and department=@departement and company=@company

if(@title like 'Manager - %' and @managerType is not null)
insert into Managers values (@username,@managerType)

if(@title like 'HR_Employee - %')
insert into HR_Employees values(@username)

if(@title like 'Regular_Employee - %')
insert into Regular_Employees values (@username)
end
end

go
alter function Type_Idenitifer -- function takes username as an input and returns the user type (HR ,manager , job seeker or regular employees)
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
	IF EXISTS (SELECT  u.username, h.username FROM Users u , HR_Employees h WHERE u.username = h.username and u.username=@username)
    BEGIN
       return 'hr_employee'
    END
 IF EXISTS (SELECT  u.username, j.username FROM Users u , Job_Seekers j WHERE u.username = j.username and u.username=@username)
    BEGIN
       return 'job_seeker'
    END
	return null
end


go
alter procedure companies_by_average_salary_order -- procedure views companies in the order of having the highest average salaris
as
select c.name,avg(j.salary) as 'Salary'
from Companies c inner join Departments d
on d.company=c.email
inner join Jobs j
on j.department= d.code and j.company=c.email
group by c.name
order by avg(j.salary) desc;




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

if(@response='Accepted' or @response='Rejected')
begin
Update Job_Seeker_apply_Jobs 
set manager_response=@response
where @username=job_Seekers and hr_response='Accepted' and company=@MHRcompany and department=@MHRdepartment and @Job=job
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
and js.job=@job


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

select r.* from Requests r inner join Staff_Members s
on r.applicant = s.username where s.company=@MHRcompany and s.department=@MHRdepartment 
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
where @username=regular_employee and @titleOfProject=project_name and company=@MHRcompany  and
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


--exec Remove_Regular_To_Project @MHRusername='Trissy', @titleOfProject='mostafatrialdate2', @username='Shawaky' 

------------------created new procedure
-------------------------------

go
alter proc get_project_name
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
		and t.project=@project_name and t.manager=@MHRusername and t.name=@taskName and status='Fixed'
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
select @ProjectsCount=count(a.project_name)
from Managers_assign_Regular_Employees_Projects a
where a.company=@MHRcompany  and  a.regular_employee=@username 
and 
cast(CURRENT_TIMESTAMP as date)> 
(select sp.end_date from Projects sp 
where sp.name=a.project_name and sp.company=@MHRcompany )

--in (select 
--ast.project_name from Managers_assign_Regular_Employees_Projects ast 
--where ast.regular_employee=@username and ast.company=@MHRcompany))

---cast(CURRENT_TIMESTAMP as date)

if(@ProjectsCount<2)
begin 
insert into Managers_assign_Regular_Employees_Projects values(@titleOfProject,@MHRcompany,@username,@MHRusername)
select mare.regular_employee from Managers_assign_Regular_Employees_Projects mare where mare.company= @MHRcompany and 
mare.project_name=@titleOfProject and mare.regular_employee=@username


end 



--8 Define a task in a project in my department which will have status ‘Open’.
go
alter proc Create_Task_Manager
@MHRusername varchar(255), @taskName varchar(255),@project_name varchar(255), 
@deadline datetime, @status varchar(255)='Open',
@description varchar(255)
as
declare @MHRcompany varchar(255), @MHRdepartment varchar(255)
select @MHRcompany=s.company, @MHRdepartment=s.department
from Staff_Members s inner join Managers m
on s.username=m.username
where s.username=@MHRusername

declare @start_date datetime, @end_date datetime
select @start_date=start_date, @end_date=end_date
from Projects p
where p.name=@project_name and p.company=@MHRcompany
if(@start_date<=@deadline and @deadline<=@end_date)
begin
 
insert into Tasks (name,project,company,deadline,status,description,manager)
values (@taskName,@project_name,@MHRcompany,@deadline,@status,@description,@MHRusername)

select t.name from Tasks t where t.name=@taskName and t.company=@MHRcompany and t.project=@project_name

end


---this is the end