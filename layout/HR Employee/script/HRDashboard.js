
$(document).ready(function() {
   
  let selectedId = "home";
  let editedJobId = null;
  let requestTypeBeforeCloning = null;
  let ARToggle = null;
  
/*$(document).on("click","td",function () { 
let OriginalContent = $(this).text(); 
$(this).addClass("cellEditing"); 
$(this).html("<input type='text' value='" + OriginalContent + "' />"); 
$(this).children().first().focus(); 
$(this).children().first().keypress(function (e) { 
 if (e.which == 13) { 
  let newContent = $(this).val(); 
  $(this).parent().text(newContent); 
  $(this).parent().removeClass("cellEditing"); 
} 
}); 
  $(this).children().first().blur(function(){ $(this).parent().text(OriginalContent); $(this).parent().removeClass("cellEditing"); 
   }); 
}); */
const assginField = function(){
	let myTab = document.getElementById('resultTable');
	let HeadersRow = myTab.rows.item(0).cells;
        for (i = 1; i < myTab.rows.length; i++) {
            let objCells = myTab.rows.item(i).cells;
            for (let j = 0; j < objCells.length; j++) {
			  if(HeadersRow.item(j).innerHTML == "working_hours"){
				   let timeArray = (objCells.item(j).innerHTML).split(":");
				    $("#hh").val(timeArray[0]);
					$("#mm").val(timeArray[1]);
					$("#ss").val(timeArray[2]);
			  }else{
				  if(HeadersRow.item(j).innerHTML == "title")
					  editedJobId = objCells.item(j).innerHTML;
				  $("#"+HeadersRow.item(j).innerHTML).val(objCells.item(j).innerHTML);
			  }
            }
        }
}
  String.prototype.firstUpper = function()
{
    return this.charAt(0).toUpperCase() + this.substr(1);
}
/*const assginFields = function(args){
	table = document.getElementById("#resultTable");
for (var i = 0, row; row = args.length ; i++) {
    var result = tableRow.find('td').filter(function(){
        if (table.find('th').eq($(this).index()).html() === args[0]){
			 $("#"+args[0]).val(($(this).index()).html());
		}
    });
   }
}*/
const viewApplicationFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");//Manager - Head of HIMSELF
         $("#viewApplicationPanel").append(result);
      }
const openHomePanelFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");//Manager - Head of HIMSELF
         $("#viewWorkHoursPanelForm").append(result);
      }
const openWorkingHoursFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");//Manager - Head of HIMSELF
         $("#viewWorkHoursPanel").append(result);
      }
const viewTopAchieversFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");//Manager - Head of HIMSELF
         $("#viewTopAchieversPanel").append(result);
      }
const openAttendanceFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");//Manager - Head of HIMSELF
         $("#viewAttendancePanelForm").append(result);
      }
const viewAttendanceFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");//Manager - Head of HIMSELF
         $("#viewAttendancePanel").append(result);
      }
const viewRequestFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");//Manager - Head of HIMSELF
         $("#viewRequestPanel").append(result);
      }
const ARFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");//Manager - Head of HIMSELF
		 if(message(result))
            $("#ARActive").remove();
      }

const searchFunc = function(result) {
	     result = result.replace(/&lt;br&gt;/g," ");
         $("#resultView").append(result);
		 if ($('#resultTable').length > 0) 
          { 
	        $("#createJobPanelForm").append("<input type='submit' value='Edit Job' id='editJobButton' class='formButton'>");
			assginField();
          }
      }
const printPass = function(result) {
		 console.log(result);
         message(result);
}
const printError = function(error){
		  console.log(error);
	  }

const post = function(url,data,successFunc,errorFunc){
	 $.ajax({
       type:"post",
       url: url,
       data: data,
       cache: false,
       success: successFunc ,
	   error: errorFunc
});
 }
 const checkForSpc = function(string){
   let splChars = "*|,\":<>[]{}`\';()@&$#%";
   for (var i = 0; i < string.length; i++) {
    if (splChars.indexOf(string.charAt(i)) != -1){
     return true;
   }
 }
  return false;
 }
  const checkDate = function(dateString) {
        let myDate = new Date(dateString);
        let today = new Date();
        if ( myDate > today ) { 
            return true;
        }
        return false;
    }
const message = function(stringMessage){
	stringMessage = stringMessage.replace(/(\r\n|\n|\r)/gm," ");
	if(stringMessage.includes("Error")){
		$("#message").css({
			"background-color" : "red",
			"border": "7px solid red"
		});
		$("#message").text("Your request was not completed successfully");
		setTimeout(function(){
		$("#message").css({
			"background-color" : "#F8FAFC",
			"border": "7px solid #F8FAFC"
		});
		$("#message").text("");
	}, 4000);
		return 0;
	}
	else if(stringMessage.includes("Pass")){
		$("#message").css({
			"background-color" : "#23f323",
			"border": "7px solid #23f323"
		});
		$("#message").text("Your request was completed successfully");
		setTimeout(function(){
		$("#message").css({
			"background-color" : "#F8FAFC",
			"border": "7px solid #F8FAFC"
		});
		$("#message").text("");
	}, 4000);
		return 1;
	}
}
 /*@HRusername varchar(255),@title varchar(255), @short_description varchar(255),
@detailed_description varchar(255), @min_experience int,@salary DECIMAL (10, 2),@deadline DATETIME, @no_of_vacancies int, 
@working_hours time*/
 const createJobPanel = function(panelName){
	$("#mainViewWindow").append("<div id='"+panelName+"' class= 'submitPanel'></div>");
	$("#"+panelName).append("<form action='javascript:void(0);' id='"+(panelName+"Form")+"'></form>");
	//$("#"+(panelName+"Form")).append("</br></br><div id='message'></div></br>");
	$("#"+(panelName+"Form")).append("</br><input type='text' name='jobTitle' placeholder='Enter job title' id='title' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='text' name='short_description' placeholder='Enter short description' id='short_description' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='number' min='0' step='1' name='min_experience' placeholder='Enter min experience' id='min_experience' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='number' min='0' step='0.1' name='salary' placeholder='Enter salary' id='salary' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='date' name='deadline' placeholder='Enter deadline' id='deadline' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='number' min='0' step='1' name='no_of_vacancies' placeholder='Enter no of vacancies' id='no_of_vacanies' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='number' min= '0' name='hh' placeholder='working Hour' id='hh' class='formInput , timeFormat' required>");
	$("#"+(panelName+"Form")).append("<input type='number' min='0' name='mm' placeholder='working mins' id='mm' class='formInput , timeFormat' required>");
	$("#"+(panelName+"Form")).append("<input type='number' min='0' name='ss' placeholder='working secs' id='ss' class='formInput , timeFormat' required></br>");
	$("#"+(panelName+"Form")).append("</br><textarea rows='4' cols='50' placeholder='Enter detailed description' id='detailed_description' class='formInput'></textarea></br>");
	$("#"+(panelName+"Form")).append("<input type='submit' value='Create Job' id='createJobButton' class='formButton'>");
 }
const searchJobPanel = function(panelName){
	$("#mainViewWindow").append("<div id='"+panelName+"' class= 'submitPanel'></div>");
	$("#"+panelName).append("<form action='javascript:void(0);' id='"+(panelName+"Form")+"'></form>");
	//$("#"+(panelName+"Form")).append("</br></br><div id='message'></div></br>");
	$("#"+(panelName+"Form")).append("</br><input type='text' name='jobTitle' placeholder='Enter job title' id='searchJobText' class='formInput' required>");
	$("#"+(panelName+"Form")).append("<input type='submit' value='Search' id='searchJobButton' class='formButton'>");
	$("#"+panelName).append("<div id='resultView'></div>");
 }
 const viewApplicationPanel = function(panelName){
	$("#mainViewWindow").append("<div id='"+panelName+"' class= 'submitPanel'></div>");
	$("#"+panelName).append("<form action='javascript:void(0);' id='"+(panelName+"Form")+"'></form>");
	//$("#"+(panelName+"Form")).append("</br></br><div id='message'></div></br>");
	$("#"+(panelName+"Form")).append("</br><input type='text' name='jobTitle' placeholder='Enter job title' id='searchAppText' class='formInput' required>");
	$("#"+(panelName+"Form")).append("<input type='submit' value='Search' id='searchAppButton' class='formButton'>");
	$("#"+panelName).append("<div id='resultView'></div>");
 }
 const viewRequestPanel = function(panelName){
	$("#mainViewWindow").append("<div id='"+panelName+"' class= 'submitPanel'></div>");
	$("#"+panelName).append("<form action='javascript:void(0);' id='"+(panelName+"Form")+"'></form>");
	//$("#"+(panelName+"Form")).append("</br></br><div id='message'></div></br>");
	$("#"+(panelName+"Form")).append("</br><select name='requestType' id='requestType' class='formInput' ><option value='leave'>leave request</option><option value='business'>business request</option></select>");
	$("#"+(panelName+"Form")).append("<input type='submit' value='Search' id='viewRequestButton' class='formButton'>");
	$("#"+panelName).append("<div id='resultView'></div>");
 }
 const viewAttendancePanel = function(panelName){
	$("#mainViewWindow").append("<div id='"+panelName+"' class= 'submitPanel'></div>");
	$("#"+panelName).append("<form action='javascript:void(0);' id='"+(panelName+"Form")+"'></form>");
	$("#"+(panelName+"Form")).append("</br><input type='date' name='start_date' placeholder='Enter start date' id='start_date' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='date' name='end_date' placeholder='Enter end date' id='end_date' class='formInput' required></br>");
 }
 const viewWorkHoursPanel = function(panelName){
	$("#mainViewWindow").append("<div id='"+panelName+"' class= 'submitPanel'></div>");
	$("#"+panelName).append("<form action='javascript:void(0);' id='"+(panelName+"Form")+"'></form>");
	$("#"+(panelName+"Form")).append("</br><input type='text' name='year' placeholder='Enter year' id='workingHourYear' class='formInput' required></br>");
 }
 const viewTopAchieversPanel = function(panelName){
	$("#mainViewWindow").append("<div id='"+panelName+"' class= 'submitPanel'></div>");
	$("#"+panelName).append("<form action='javascript:void(0);' id='"+(panelName+"Form")+"'></form>");
	$("#"+(panelName+"Form")).append("</br><input type='text' name='month' placeholder='Enter month' id='selectedMonth' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='submit' value='View Top Achievers' id='viewTopAchievers' class='formButton'>");
 }
 /*Post_Announcement
@HRusername varchar(255), @title varchar(255), @type varchar(255),@desciption varchar(255)*/
 const postAnnouncementPanel = function(panelName){
	$("#mainViewWindow").append("<div id='"+panelName+"' class= 'submitPanel'></div>");
	$("#"+panelName).append("<form action='javascript:void(0);' id='"+(panelName+"Form")+"'></form>");
	//$("#"+(panelName+"Form")).append("</br></br><div id='message'></div></br>");
	$("#"+(panelName+"Form")).append("</br><input type='text' name='announcementTitle' placeholder='Enter announcement title' id='announcementTitle' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("<input type='text' name='announcementType' placeholder='Enter announcement type' id='announcementType' class='formInput' required></br>");
	$("#"+(panelName+"Form")).append("</br><textarea rows='4' cols='50' placeholder='Enter detailed description' id='detailed_description' class='formInput'></textarea></br>");
	$("#"+(panelName+"Form")).append("<input type='submit' value='Post Announcement' id='postAnnouncementButton' class='formButton'>");
 }
 $(document).on("click","#searchAppButton",function(){
	ARToggle = "application";
	let formClone = $("#viewApplicationPanelForm").clone();
	$("#viewApplicationPanel").empty();
	$("#viewApplicationPanel").append(formClone);
	let jobTitle = $("#searchAppText").val();
	if(checkForSpc(jobTitle) == false && jobTitle != ''){
		post("php/application.php", { request:"view application",title: jobTitle},viewApplicationFunc,printError);
	}else{
		message("Error: Please check your inputs again");
	}
});
 $(document).on("click","#viewRequestButton",function(){
	ARToggle = "request";
	let requestType = $("#requestType").val();
	requestTypeBeforeCloning = requestType;
	let formClone = $("#viewRequestPanelForm").clone();
	$("#viewRequestPanel").empty();
	$("#viewRequestPanel").append(formClone);
	$("#requestType").val(requestTypeBeforeCloning);
	post("php/request.php", { request:"view request",requestType: requestType},viewRequestFunc,printError);
});
$(document).on("click","#viewWorkingHours",function(){
	let workingHourYear = $("#workingHourYear").val();
	if(workingHourYear.length == 4 && isNaN(workingHourYear) == false && workingHourYear != ''){
	let staffMembersSelection = $("#staffMembersSelection").val();
	let formClone = $("#viewWorkHoursPanel1Form").clone();
	$("#viewWorkHoursPanel1").empty();
	$("#viewWorkHoursPanel1").append(formClone);
	$("#workingHourYear").val(workingHourYear);
	$("#staffMembersSelection").val(staffMembersSelection);
	post("php/home.php", { request:"view working hours",year: workingHourYear,smUsername: staffMembersSelection},openWorkingHoursFunc,printError);
	}
	else{
		message("Error: Please check your inputs again");
	}
});
$(document).on("click","#viewTopAchievers",function(){
	ARToggle = "sendEmail";
	let month = $("#selectedMonth").val();
	if((month.length == 2 ||month.length == 1) && isNaN(month) == false && month != ''){
	let formClone = $("#viewTopAchieversPanelForm").clone();
	$("#viewTopAchieversPanel").empty();
	$("#viewTopAchieversPanel").append(formClone);
	$("#selectedMonth").val(month);
	post("php/home.php", { request:"view top achievers",month: month},viewTopAchieversFunc,printError);
	}
	else{
		message("Error: Please check your inputs again");
	}
});
$(document).on("click","#viewAttendanceButton",function(){
	let startDate = new Date($("#start_date").val());
	let endDate = new Date($("#end_date").val());
	if(endDate > startDate){
	 let staffMembersSelection = $("#staffMembersSelection").val();
	 let start_date = $("#start_date").val();
	 let end_date = $("#end_date").val();
	 staffMembersSelectionBeforeCloning = staffMembersSelection;
	 let formClone = $("#viewAttendancePanelForm").clone();
	 $("#viewAttendancePanel").empty();
	 $("#viewAttendancePanel").append(formClone);
	 $("#staffMembersSelection").val(staffMembersSelectionBeforeCloning);
	 $("#start_date").val(start_date);
	 $("#end_date").val(end_date);
	 post("php/attendance.php", { request:"view attendance",SMusername:staffMembersSelection ,start_date:start_date,end_date:end_date},viewAttendanceFunc,printError);
	}else{
		message("Error: check you inputs");
	}
});
/*Accept_Or_Reject
@HRusername varchar(255),@ApplicantUsername varchar(255), @title varchar(255), @response varchar(255)*/
$(document).on("click",".ARButton",function(){
	let ARForm = $(this).parent();
 if(ARToggle == "application"){
	let jobTitle = null;
	let applicantUsername = null;
 }
 if(ARToggle == "request"){
	let start_date = null;
	let applicantUsername = null;
 }
 if(ARToggle == "sendEmail"){
	 let staff = null;
 }
	$(this).closest("#resultTable").attr("id", "ARActive");
	let myTab = document.getElementById('ARActive');
	let HeadersRow = myTab.rows.item(0).cells;
        for (i = 1; i < myTab.rows.length; i++) {
            let objCells = myTab.rows.item(i).cells;
            for (let j = 0; j < objCells.length; j++) {
			if(ARToggle == "application"){
			  if(HeadersRow.item(j).innerHTML == "job")
					  jobTitle = objCells.item(j).innerHTML;
			  else if(HeadersRow.item(j).innerHTML == "username")
					  applicantUsername = objCells.item(j).innerHTML;
			  }
			if(ARToggle == "request"){
			  if(HeadersRow.item(j).innerHTML == "start_date")
					  start_date = objCells.item(j).innerHTML;
			  else if(HeadersRow.item(j).innerHTML == "username")
					  applicantUsername = objCells.item(j).innerHTML;
			  }
		    if(ARToggle == "sendEmail"){
			  if(HeadersRow.item(j).innerHTML == "staff")
					  staff = objCells.item(j).innerHTML;
            }
        }
   }
if(ARToggle == "application"){
   if(jobTitle == null && applicantUsername == null &&jobTitle == applicantUsername)
	    message("Error: fatal!!");
   else{
	  if($(this).attr("id") == "acceptAppButton"){
	   post("php/application.php", { request:"AR application",title: jobTitle,applicantUsername : applicantUsername,response : "Accepted"},ARFunc,printError);
	  }
    else if($(this).attr("id") == "rejectAppButton")
       post("php/application.php", { request:"AR application",title: jobTitle,applicantUsername : applicantUsername,response : "Rejected"},ARFunc,printError);
   }
}
if(ARToggle == "request"){
    if(start_date == null && applicantUsername == null && start_date == applicantUsername)
	    message("Error: fatal!!");
   else{
	  if($(this).attr("id") == "acceptAppButton"){
	   post("php/request.php", { request:"AR request",start_date: start_date,applicantUsername : applicantUsername,response : "Accepted"},ARFunc,printError);
	  }
    else if($(this).attr("id") == "rejectAppButton")
       post("php/request.php", { request:"AR request",start_date: start_date,applicantUsername : applicantUsername,response : "Rejected"},ARFunc,printError);
   }
}
if(ARToggle == "sendEmail"){
    if(staff == null)
	    message("Error: fatal!!");
   else{
	  if($(this).attr("id") == "sendEmail"){
	   post("php/home.php", { request:"send mail",staff: staff},ARFunc,printError);
	  }
   }
}
});
$(document).on("click","#createJobButton",function(){
	let jobTitle = $("#title").val();
	let shortDescription = $("#short_description").val();
	let minExp = $("#min_experience").val();
	let jobSalary = $("#salary").val();
	let jobDeadline = $("#deadline").val();
	let noOfVacancies = $("#no_of_vacanies").val();
	let jobWorking_hours = $("#hh").val()+":"+$("#mm").val()+":"+$("#ss").val();
	let detailedDescription = $("#detailed_description").val();
	if((jobTitle.search("Manager - ") == 0 
	|| jobTitle.search("Regular_Employee - ") == 0 
	|| jobTitle.search("HR_Employee - ") == 0)
	&& (jobTitle.split("-").length - 1) == 1 
	&& checkForSpc(jobTitle) == false
	&& shortDescription != ''
	&& minExp != ''
	&& jobSalary != ''
	&& jobDeadline != ''
	&& noOfVacancies != ''
	&& jobWorking_hours != ''
	&& detailedDescription != ''
	&& checkDate(jobDeadline) == true
	){
		post("php/job.php", { request:"create job",
		title: jobTitle,
		short_description : shortDescription,
		min_experience:minExp,
		salary:jobSalary,
		deadline:jobDeadline,
		no_of_vacancies:noOfVacancies,
		working_hours:jobWorking_hours,
		detailed_description:detailedDescription},printPass,printError);
		
	}else{
		message("Error: Please check your inputs again");
	}
});
$(document).on("click","#postAnnouncementButton",function(){
	let announcementTitle = $("#announcementTitle").val();
	let announcementType = $("#announcementType").val();
	let detailedDescription = $("#detailed_description").val();
	if(checkForSpc(announcementType) == false && announcementTitle != '' && announcementType != '' && detailedDescription != ''){
		post("php/announcement.php", { request:"post announcement",
		announcementTitle: announcementTitle,
		announcementType : announcementType,
		detailed_description:detailedDescription},printPass,printError);
		
	}else{
		message("Error: Please check your inputs again");
	}
});
$(document).on("click","#searchJobButton",function(){
	$("#resultView").empty();
	let jobTitle = $("#searchJobText").val();
	if(checkForSpc(jobTitle) == false && jobTitle != ''){
		post("php/job.php", { request:"search job",title: jobTitle},searchFunc,printError);
	}else{
		message("Error: Please check your inputs again");
	}
});
$(document).on("click","#editJobButton",function(){
	let jobTitle = $("#title").val();
	let shortDescription = $("#short_description").val();
	let minExp = $("#min_experience").val();
	let jobSalary = $("#salary").val();
	let jobDeadline = $("#deadline").val();
	let noOfVacancies = $("#no_of_vacanies").val();
	let jobWorking_hours = $("#hh").val()+":"+$("#mm").val()+":"+$("#ss").val();
	let detailedDescription = $("#detailed_description").val();
	if((jobTitle.search("Manager - ") == 0 
	|| jobTitle.search("Regular_Employee - ") == 0 
	|| jobTitle.search("HR_Employee - ") == 0)
	&& (jobTitle.split("-").length - 1) == 1 
	&& checkForSpc(jobTitle) == false
	&& shortDescription != ''
	&& minExp != ''
	&& jobSalary != ''
	&& jobDeadline != ''
	&& noOfVacancies != ''
	&& jobWorking_hours != ''
	&& detailedDescription != ''
	&& checkDate(jobDeadline) == true
	&& jobTitle == editedJobId
	){
		post("php/job.php", { request:"edit job",
		title: jobTitle,
		short_description : shortDescription,
		min_experience:minExp,
		salary:jobSalary,
		deadline:jobDeadline,
		no_of_vacancies:noOfVacancies,
		working_hours:jobWorking_hours,
		detailed_description:detailedDescription},printPass,printError);
		
	}else{
		message("Error: Please check your inputs again");
	}
});
$('.navSelectDiv').on("mouseover",function(){
	
	let divId = $(this).attr("id");
	let selectedImgPath = "img/"+divId+"Selected.png";
	let divImg = $(this).children("img");
    let divSpan = $(this).children("span");
	$(this).css("border-left","5px solid #0ae8cf");
    divImg.attr("src",selectedImgPath);
if(divId != selectedId){
	if(divId == "home")
		divSpan.css("color","#ff5b5e");
	else if(divId == "request")
		divSpan.css("color","#6dff94");
	else if(divId == "attendance")
		divSpan.css("color","#b0cbff");
	else if(divId == "job")
		divSpan.css("color","#bb6be1");
	else if(divId == "announcment")
		divSpan.css("color","#ed5bab");
	else if(divId == "application")
		divSpan.css("color","#ffc107");
}
});

$('.navSelectDiv').on("mouseleave",function(){
	
    let divId = $(this).attr("id");
	let selectedImgPath = "img/"+divId+"Unselected.png";
	let divImg = $(this).children("img");
    let divSpan = $(this).children("span");
if(divId != selectedId){
	$(this).css("border-left","5px solid white");
    divImg.attr("src",selectedImgPath);
	divSpan.css("color","#c4c7c0");
}
});
const homeStart = function(){
    $("#mainViewWindow").append("<div id='message'></div>");
	viewWorkHoursPanel("viewWorkHoursPanel");
	viewTopAchieversPanel("viewTopAchieversPanel");
	//viewWorkHoursPanel("viewWorkHoursPanel2");
	post("php/home.php", { request:"open home panel1"},openHomePanelFunc,printError);
	//post("php/home.php", { request:"open home"},openAttendanceFunc,printError);
}
$('.navSelectDiv').on("click",function(){
	//reset
	$('.navSelectDiv').each(function(i, obj) {
		 let divId = $(this).attr("id");
	     let selectedImgPath = "img/"+divId+"Unselected.png";
	     let divImg = $(this).children("img");
         let divSpan = $(this).children("span");
         divSpan.css("color","#c4c7c0");
	     divImg.attr("src",selectedImgPath);
	     $(this).css("border-left","5px solid white");
    });
         let divId = $(this).attr("id");
	     let selectedImgPath = "img/"+divId+"Selected.png";
	     let divImg = $(this).children("img");
         let divSpan = $(this).children("span");
        if(divId == "home")
		 divSpan.css("color","#ff5b5e");
	    else if(divId == "request")
		 divSpan.css("color","#6dff94");
	    else if(divId == "attendance")
		 divSpan.css("color","#b0cbff");
	    else if(divId == "job")
		 divSpan.css("color","#bb6be1");
	    else if(divId == "announcment")
		 divSpan.css("color","#ed5bab");
	    else if(divId == "application")
		 divSpan.css("color","#ffc107");
	    divImg.attr("src",selectedImgPath);
	    $(this).css("border-left","5px solid #0ae8cf");
		selectedId = divId;
		$("#mainViewWindow").empty();
		$("#mainViewWindow").append("<div id='message'></div>");
		
	if(divId == "job"){
		createJobPanel("createJobPanel");
		searchJobPanel("searchJobPanel");
    }
	else if(divId == "application"){
		viewApplicationPanel("viewApplicationPanel");
    } 
	else if(divId == "announcment"){
		postAnnouncementPanel("postAnnouncementPanel");
    }
	else if(divId == "request"){
		viewRequestPanel("viewRequestPanel");
    }else if(divId == "attendance"){
		viewAttendancePanel("viewAttendancePanel");
		post("php/attendance.php", { request:"open attendance"},openAttendanceFunc,printError);
	}else if(divId == "home"){
		homeStart();
	}
});
 homeStart();
$(document).on("keydown , keyup",'input:text',function(){
    let firstUpperText = ($(this).val()).firstUpper(); 
    $(this).val(firstUpperText);
   });
 $(document).on("keydown , keyup",'input',function(){
    let number = $(this).val();
    if(number < 0)
		$(this).val(number * -1);
   });
  $(document).on("keydown , keyup , change",'.timeFormat',function(){
    let number = parseInt($(this).val());
    if(number < 10 && $(this).val().length == 1 && number != 0 )
		$(this).val(0 + $(this).val());
   });
});