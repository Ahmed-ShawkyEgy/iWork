<?php

// This file is to be executed every time once anybody pulls the project
// If you want to add any create proc commands then u should add a drop proc command first

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

);
