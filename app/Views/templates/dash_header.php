<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Task and Scheduling Management System</title>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"> -->
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css'>
	<!-- <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<script src = "https://kit.fontawesome.com/0df98348d7.js" crossorigin = "anonymous"></script>
   <link rel="stylesheet" href="<?= base_url('assets/css/dashboardstyle.css')?>">
   
   <link rel="stylesheet" href="<?= base_url('assets/css/style.css')?>">
   
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

</head>

<body>
	
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="<?= base_url('assets/image/iicon.png');?>">
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav_list">
        	<div class="admin">
	        	<hr>
                <?php if($_SESSION['user_img'] != NULL):?>
	        	  <img src="<?= base_url("uploads/".$_SESSION['user_img']);?>">
                <?php else:?>
                    <img src="<?= base_url("assets/image/profile.jpg");?>">
                <?php endif;?>
	        	<h3><?php echo $_SESSION['username'] ?></h3>
	        	<hr>
        	</div>
            <li>
                <a href="<?= base_url('/dashboard')?>">
                    <i class="fa fa-th" aria-hidden="true"></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
        <?php if($_SESSION['position'] == USER_ROLE_ADMIN):?>
            <li>
                <a href="<?= base_url('/calendar')?>">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <span class="links_name">Calendar</span>
                </a>
                <span class="tooltip">Calendar</span>
            </li>
            <li>
                <a href="<?= base_url('/serv')?>">
                    <i class="fa fa-server" aria-hidden="true"></i>
                    <span class="links_name">Services</span>
                </a>
                <span class="tooltip">Services</span>
            </li>
                <button class = "dropdown-btn">
									<i class = "fa-solid fa-user-pen"></i> <span class="links_name">&nbsp;&nbsp;Manage Profiles</span>
							    	<i class = "fa fa-caret-down down"></i>
							    	<span class="tooltip2">Profiles</span>
							  	</button>

							  	<div class = "dropdown-container">
								  	<li class="nav-item">
								    	<a href = "<?= base_url('/client')?>" ><i class = "fa-solid fa-user"></i> <span class="links_name">&nbsp;&nbsp;Clients</span> </a> 
								    	<span class="tooltip3">Clients</span>
								   </li>
								  
								   <li class="nav-item">
							    		<a href = "<?= base_url('/emp');?>" ><i class = "fa-solid fa-user"></i><span class="links_name">&nbsp;&nbsp;Employees</span></a>
							    		<span class="tooltip3">Employees</span>
							    	</li>
							    	
							    	<li class="nav-item">
							    		<a href = "<?= base_url('/user');?>" ><i class = "fa-solid fa-user"></i><span class="links_name"> &nbsp;&nbsp;Users</span></a>
                                        <span class="tooltip3">Users</span>
							    	</li>
							  	</div>
			<li>
                <a href="<?= base_url('/calllogs')?>">
                    <i class="fa-solid fa-square-phone"></i>
                    <span class="links_name">Call Logs</span>
                </a>
                <span class="tooltip">Call Logs</span>
            </li>
            <button class = "dropdown-btn">
                                    <i class="fa-solid fa-file-invoice"></i> <span class="links_name">&nbsp;&nbsp;Reports</span>
                                    <i class = "fa fa-caret-down down2"></i>
                                    <span class="tooltip4">Reports</span>
                                </button>

            <div class = "dropdown-container">
    			<li class="nav-item">
                    <a href="<?= base_url('/reports/accomplished')?>">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span class="links_name">Accomplished Reports</span>
                    </a>
                    <span class="tooltip3">Accomplished</span>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/reports/exception')?>">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span class="links_name">Exception Reports</span>
                    </a>
                    <span class="tooltip3">Exception</span>
                </li>
            </div>
            <li>
                <a href="<?= base_url('/service-reports')?>">
                    <i class="fa-solid fa-file-import"></i>
                    <span class="links_name">Upload Reports</span>
                </a>
                <span class="tooltip">Upload Reports</span>
            </li>
        <?php else:?>
            <li>
                <a href="<?= base_url('/calendar/emp')?>">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <span class="links_name">Calendar</span>
                </a>
                <span class="tooltip">Calendar</span>
            </li>
        <?php endif;?>
            <li>
              <a href="<?= base_url('/profile/'.$_SESSION['user_id'] )?>">
		            <i class="fa-solid fa-gear"></i>
		            <span class="links_name">Account Setting</span>
		          </a>
              <span class="tooltip">Account Setting</span>
            </li>
            <li>
	            <!-- <div class="logout_btn"> -->
	                <a href="<?= base_url('/logout')?>"><i class="fa fa-sign-out" id="log_out"></i><span class="links_name">Log Out</span></a>
	          <!--   </div> -->
        	<span class="tooltip">Log Out</span>
        	</li>
        	
        </ul>
    </div>
    <div class="sidebar-header">
    	<div class="text">Tasks and Schedule Monitoring System</div>
    
    	
    	
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function(){
            sidebar.classList.toggle("active");
        }
        
    </script>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;
for (i = 0; i < dropdown.length; i++) 
{
	dropdown[i].addEventListener("click", function() 
	{
		this.classList.toggle("active");
		var dropdownContent = this.nextElementSibling;
		if (dropdownContent.style.display === "block") 
		{
			dropdownContent.style.display = "none";
 		}
 		else
 		{
  			dropdownContent.style.display = "block";
  		}
  	});
}
</script>
<style type="text/css">

canvas {
  border: 1px dotted red;
}

.chart-container {
  position: relative;
  margin: auto;
  height: 80vh;
  width: 80vw;
}

</style>

