

<?php

require_once($_SERVER['DOCUMENT_ROOT']."/Database-Project/helper/sqlExec.php");
session_start();
$username = "'".$_SESSION['userid']."'";
$request = $_POST['request'];
$announcementTitle = post('announcementTitle');
$announcementType = post('announcementType');
$detailed_description = post("detailed_description");
$result = sqlExec("select * from Announcements where title= $announcementTitle");
if(empty($result)){
	$result = sqlExec("exec Post_Announcement @HRusername= $username , @title= $announcementTitle, @type= $announcementType ,@desciption= $detailed_description");
	$result = sqlExec("select * from Announcements where title= $announcementTitle");
	if(empty($result)){
		echo "Error: announcement is lost!!";
	}else{
		echo "Pass: announcement posed";
	}
}else{
	echo "Error: already exists";
}
?>