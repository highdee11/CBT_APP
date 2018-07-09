<?php
    
    require("../db/connect.php");     if(!login()){  header("location:../"); }
    $courses=getCourses();
    $noCourse=getCourseCount();
	$noSet=getSetCount();
	$noQuestion=getQuestionCount();
    $admins=getAdmins();


    $adminCourses=$_SESSION['ADMIN']['courses'];
    $adminCourses=explode('#/',$adminCourses);

    if($adminCourses[0]!="All")
        {
            header("location:../");   
        }
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UI-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DashBoard</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/Dashboard.css" rel="stylesheet">
	<link href="../css/admin.css" rel="stylesheet">
	<script src='../js/jquery-3.1.0.min.js'></script>
	<script src='../js/jquery-ui.js'></script>
	<link  rel="stylesheet" href="../js/chosen_v1.4.0/chosen.min.css"> 
	 <script src='../js/chosen_v1.4.0/chosen.jquery.min.js'></script> 
	<script src='../js/bootstrap.min.js'></script>
	<script src='../js/admin.js'></script>
</head>
<body>

	<div class='container np'>
		<div class='row row1 '>

	<div class="col-lg-12 hidden" id="screenLoader">
			<div class='lod'></div>
			<div class='lodTxt'>Please wait....</div>
		</div>
	<!-- main content row-->
		<div class='row np display-table-row' id='inner-row2'>
		<!--side bar-->

				<div  class='sidebar col-lg-2 col-md-2 col-sm-3 col-xs-12 display-table-cell' id='side-bar' >

					<!-- admin details-->
				<div class='row' id='admin-details'>
					<div class='col-lg-12  admin-img   hidden-xs'>
						 <div class="col-lg-5 col-lg-offset-3 " id="iconUser" ><span class='glyphicon glyphicon-user'></span></div>
					</div>
					
					<div class='col-lg-12 col-md-12 col-md-12 'id='online-user'>
						<b class='col-lg-12'><?php echo $_SESSION['ADMIN']['name']?></b>

					</div>
                      <ul class='col-lg-12' id='topMenu'>
                         
                        <li class="col-lg-12 "><a class="col-lg-12 "   href="">Change Password</a></li>
                    </ul>
				</div>

				<!--sidebar menu-->
				<div class='row' id='menu'>
					<ul>
						<li  ><a href='Dashboard.php'><span class='glyphicon glyphicon-th'></span> DashBoard</a></li>
						<!--<li  >
							<a href='#board-drp'   data-toggle='collapse'>
								<span class='glyphicon glyphicon-folder-close'></span> Board
								<span class='caret pull-right'></span>
							</a>
							<div id='menu-drp'>
								<ul class='collapse collapseable'  id='board-drp'>
									<li><a href='Board.php?add-board'><span class='glyphicon glyphicon-plus'></span> Add New</a></li>
									<li><a href='Board.php?edit-board'><span class='glyphicon glyphicon-edit'>
									</span> Edit Board<span class='hidden-xs label label-success pull-right'>board_num</span></a></li>
								</ul>
							 </div>
						</li>
					-->

						<li>
							<a href='#course-drp' data-toggle='collapse'>
								<span class='glyphicon glyphicon-book'></span> Courses
								<span class='caret pull-right'></span>
							</a>
							<div id='menu-drp'>
								<ul class='collapse collapseable' id='course-drp'>
									<li><a href='Course.php?add-course'><span class='glyphicon glyphicon-plus'></span> Add New</a></li>
									<li><a href='Course.php?edit-course'><span class='glyphicon glyphicon-edit'>
									</span> Edit Course<span class='hidden-xs label label-success pull-right'><?php echo $noCourse[0]; ?></span></a></li>
								</ul>
							</div>
						</li>
						<li>
							<a href='#set-drp' data-toggle='collapse'>
								<span class='glyphicon glyphicon-list-alt'></span> Question Sets
								<span class='caret pull-right'></span>
							</a>
							<div id='menu-drp'>
								<ul class='collapse collapseable' id='set-drp'>
									<li><a href='Questionset.php?add-questionset'><span class='glyphicon glyphicon-plus'></span> Add New</a></li>
									<li><a href='Questionset.php?edit-questionset'><span class='glyphicon glyphicon-edit'>
									</span> Edit Set<span class='hidden-xs label label-success pull-right'><?php echo $noSet[0]; ?></span></a></li>
								</ul>
							</div>
						</li>
						<li>
							<a href='#question-drp' data-toggle='collapse'>
								<span class='glyphicon glyphicon-question-sign'></span> Questions
								<span class='caret pull-right'></span>
							</a>
							<div id='menu-drp'>
								<ul class='collapse collapseable' id='question-drp'>
									<li><a href='Question.php?add-question'><span class='glyphicon glyphicon-plus'></span> Add New</a></li>
									<li><a href='Question.php?edit-question'><span class='glyphicon glyphicon-edit'>
									</span> Edit question<span class='hidden-xs label label-success pull-right'><?php echo $noQuestion[0]; ?></span></a></li>
								</ul>
							</div>
						</li>
                <?php if($adminCourses[0]=="All") { ?> <li ><a href='admin.php'><span class="glyphicon glyphicon-user"></span> Admin</a></li> <?php } ?>
<!--
						 <li ><a href='Student.php'><img src='images/student_male-24.png' class='img pull-left tutor1-img img-responsive'> Student</a></li>
						<li ><a href='Tutor.php'><img src='images/tutor_sm_icon.jpg' class='img pull-left tutor1-img img-responsive'> Tutor</a></li>
-->
					</ul>
                    
				</div>
                    <ul class='col-lg-12' id='bottomMenu'>
                        <li class="col-lg-6" ><a href='#' class="col-lg-12" id="logout"><span class='glyphicon glyphicon-log-out'></span> Logout </a></li>
                       
                    </ul>
			</div>

		<!-- main content-->

			<div  class='maincontent col-lg-10 col-md-10 col-sm-9  col-xs-12 display-table-cell np'>
				    <div class="col-lg-12 headerAdmin">
                        <h1>Admin Reserver Area</h1>
                    </div>
                <div class="col-lg-12 bodyAdmin"> 
                    <div class="col-lg-12 top">
                         <div id='addAdmin' class='modal fade col-lg-12  ' tabindex='-1'>
						<div class='modal-dialog modal-lg  '>
						<div class='modal-content col-lg-12 '>
						 <div class='modal-header col-lg-12 '>
							 <a  id='close_edit_form' class='close' data-dismiss='modal'>&times;</a>
							<h3 class='modal-title'>Add New Admin</h3>
						 </div>
						<div class='modal-body col-lg-12 '>
						<form action='' id='add_Admin'  method='post'>
                            <div class='alert alert-success col-lg-12'>
                            <ul>
                                  <li>Admins will only have access to any course to assign to thems.</li> 
                                <li>You can automatically generate username and password and you can also add them yourself.</li>
                                 
                            </ul>
                                </div>
                            <div class='col-lg-6'>
                            <div class='col-lg-12 form-group'>
								<label >Full-Name </label>
                                <input type="text" class='form-control' name="adminName"  /> 
							</div>
                            <div class="form-group col-lg-12">
                            <label>Assign Courses to admin</label>
                            <select class='form-control chosen-select' name='courses[]' multiple >
                                <option></option>
                                <option value="All">All Courses</option>
                           <?php
                                foreach ($courses  as $key => $value) {  ?>
                                        <option value="<?php echo $value['title']; ?>" > <?php echo $value['title']; ?></option>
                                <?php }
                            ?>
                            </select>
                        </div>
                            
                            <div class="form-group col-lg-12">
                                <label>Gender</label>
                                <select class='form-control' name='gender'>
                                    <option></option>
                                    <option value='male'>Male</option>
                                    <option value='female'>Female</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-lg-5 col-lg-offset-1" id='generateModule'>
                                
                                <div class='col-lg-12 form-group'>
								<label >Username </label>
                                <input id='user' type="text" class='form-control' name="username"  /> 
							</div>
                                <div class='col-lg-12 form-group'>
								<label >Password </label>
                                <input id='password' type="text" class='form-control' name="password"  /> 
							</div>
                                <button type='button' id="autoG" class="btn btn-primary col-xs-6 col-xs-offset-3 col-lg-6 col-lg-offset-3 "><div id="Btnload"></div>Auto-Generate</button>
                            </div>
                            
						</form>
                        
					</div>
                            <div class="modal-footer">
                                <button id="submitAdmin" class='btn btn-success'>Add</button>
                            </div>
					</div>
					</div>
					</div>
                    </div>
                    <ul class='topMenu'>
                        <li class='text-success'><a href='' data-toggle="modal" data-target="#addAdmin" ><span class='glyphicon glyphicon-plus'></span> Add New Admin</a></li>    
                    </ul>
                    </div>
                    
                    <div class="col-lg-12 content  np2">
                        <div class='col-lg-12 col-xs-12 edit-table pull-left'>
								<div class="col-lg-12 hidden loader" id="loader">
	 							 <div class='loaderBlock'>
	 								 <center>
	 									 <div class="loadercircle"></div>
	 							 			<p>Please wait.....</p>
	 									</center>
	 							</div>
	 						 </div>
								<table class='table table-striped table-hover table-condensed ' id='edit-Admin-table'>
									<thead>
										<tr>
											<th></th>
											 
											<th>Name</th>
											<th>Gender</th>
											<th>Username</th>
                                            <th>Course</th>
											<th>Access</th>
                                            <th></th>
										</tr>
									</thead>
									<tbody>
                                        <?php foreach($admins as $key=> $value) { 
                                                 
                                            ?>
                                            <tr>
                                                <td><?php echo $key +1 ; ?></td>
                                                
                                                <td><?php echo $value['name'];  ?></td>
                                                <td><?php echo $value['gender'];  ?></td>
                                                <td><?php echo $value['username'];  ?></td>
                                                <td><?php echo str_replace('#/',',',$value['courses'])  ?></td>
                                                <td><span class="label <?php if($value['access']=='Y'){ echo 'label-success' ;}else {echo "label-danger" ;} ?>" > <?php if($value['access']=='Y'){  echo "allowed"; }else{ echo "Denied"; } ?> </span></td>
                                                <td><div class='btn-group btn-group-xs'> 
                                                    <button class='btn btn-default edit' data="<?php echo $value['id']; ?>" >Edit</button>
                                                    <button data="<?php echo $value['id']; ?>" class="btn 
                                                   <?php if($value['access']=='Y'){ echo 'btn-warning block  ';}else{ echo 'btn-success allow'; } ?>">
                                                   <?php if($value['access']=='Y'){ echo 'Block';}else{ echo 'Allow'; } ?>     
                                                    </button>
                                              
                                                <button class='btn btn-danger remove' data="<?php echo $value['id']; ?>">Remove</button>
                                            
                                                    </div></td>
                                            </tr>
                                        
                                        <?php } ?>
                                    </tbody>
            <!--------------------------------------------editting admin-------------------------------------------------->                  
            <div id='editAdmin' class='modal fade col-lg-12 hidden ' tabindex='-1'>
						<div class='modal-dialog modal-lg  '>
						<div class='modal-content col-lg-12 '>
						 <div class='modal-header col-lg-12 '>
							 <a  id='close_edit_form' class='close' data-dismiss='modal'>&times;</a>
							<h3 class='modal-title'>Edit Course Content</h3>
						 </div>
						<div class='modal-body col-lg-12 '>
						<form action='' id='edit_Admin'  method='post'>
                                <input type='hidden' name='id' id="identity"/>
                            <div class='alert alert-success col-lg-12'>
                            <ul>
                                  <li>Admins will only have access to any course to assign to thems.</li> 
                                <li>You can automatically generate username and password and you can also add them yourself.</li>
                                 
                            </ul>
                                </div>
                            <div class='col-lg-6'>
                            <div class='col-lg-12 form-group'>
								<label >Full-Name </label>
                                <input type="text" class='form-control' id='editName' name="editAdminName"  /> 
							</div>
                            <div class="form-group col-lg-12">
                            <label>Assign Courses to admin</label>
                            <select class='form-control chosen-select' id='editCourse' name='editCourses[]'  multiple >
                                <option></option>
                                <option value="All">All Courses</option>
                           <?php
                                foreach ($courses  as $key => $value) {  ?>
                                        <option value="<?php echo $value['title']; ?>" > <?php echo $value['title']; ?></option>
                                <?php }
                            ?>
                            </select>
                        </div>
                            
                            <div class="form-group col-lg-12">
                                <label>Gender</label>
                                <select class='form-control' name='gender' id='editGender'>
                                    <option></option>
                                    <option value='male'>Male</option>
                                    <option value='female'>Female</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-lg-5 col-lg-offset-1" id='generateModule'>
                                
                                <div class='col-lg-12 form-group'>
								<label >Username </label>
                                <input   type="text" class='form-control' id='editUser' name="username"  /> 
							</div>
                                <div class='col-lg-12 form-group'>
								<label >Password </label>
                                <input   type="text" class='form-control' name="password" id='editPassword'  /> 
							</div>
                                <button type='button' id="autoG" class="btn btn-primary col-xs-6 col-xs-offset-3 col-lg-6 col-lg-offset-3 "><div id="Btnload"></div>Auto-Generate</button>
                            </div>
                            
						</form>
                        
					</div>
                            <div class="modal-footer">
                                <button id="submitEditAdmin" class='btn btn-success'>Update</button>
                            </div>
					</div>
					</div>
					</div>
                            </table>
                        </div>
                    </div>
                </div>
                
                
			</div>
 
		</div><!--1st row-->

	</div><!--container-->

</body>
</html>
