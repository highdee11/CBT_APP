<?php
    require("../db/connect.php");     if(!login()){  header("location:../"); }
	$courses=getCourses();
 	$noCourse=getCourseCount();
	$noSet=getSetCount();
	$noQuestion=getQuestionCount();

  $adminCourses=$_SESSION['ADMIN']['courses'];
  $adminCourses=explode('#/',$adminCourses);
?>



<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UI-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/Dashboard.css" rel="stylesheet">
	<link href="../css/Board.css" rel="stylesheet">
	<link href="../css/Course.css" rel="stylesheet">
	<script src='../js/jquery-3.1.0.min.js'></script>
	<script src='../js/jquery-ui.js'></script>
	<link  rel="stylesheet" href="../js/chosen_v1.4.0/chosen.min.css">
	 <script src='../js/chosen_v1.4.0/chosen.jquery.min.js'></script>
	<script src='../js/bootstrap.min.js'></script>
	<script src='../js/Chart.min.js'></script>
	 <script src='../js/Course.js'></script>
</head>
<body>
	<div class='container'>

		<div class='row row1'>
	<!-- header row-->

		<div class="col-lg-12 hidden" id="screenLoader">
			<div class='lod'></div>
			<div class='lodTxt'>Please wait....</div>
		</div>

	<!-- main content row-->
		<div class='row' id='inner-row2'>
		<!--side bar-->
			<div  class='sidebar col-lg-2 col-md-2 col-sm-3 col-xs-12 display-table-cell' id='side-bar' >

					<!-- admin details-->
				<div class='row' id='admin-details'>
					<div class='col-lg-12 admin-img hidden-sm  hidden-xs'>
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
						<li ><a href='Dashboard.php'><span class='glyphicon glyphicon-th'></span> DashBoard</a></li>
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

						<li class='active'>
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
              <?php if($adminCourses[0]!="All") { ?> <li ><a href='scripts.php'><span class="glyphicon glyphicon-book"></span> Exam Scripts</a></li> <?php } ?>
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
			<div  class='maincontent col-lg-10 col-md-10 col-sm-9  col-xs-12'>

				<?php
				if(isset($_GET['add-course']))
				{
						// global $connection;
						//   mysqli_select_db($connection,"cbtonline_db");
						//  $result=mysqli_query($connection,"SELECT *FROM sets");
					 ?>
				<div id='add-board'>
				<div class='row details-row'>
					<h4 class=' page_title text-success'>Create New Courses</h4>
						<p class=' info-details ' style='font-family:Arial'>Create new courses and make changes to already created courses</p>
				</div>
				<div class="col-lg-12 alert alert-success hidden course_feedback">
					<center><b></b></center>
				</div>
				<div class='row'>
					 <div class='col-lg-9 board-form'>
						 <div class="col-lg-12 hidden loader" id="loader">
							 <div class='loaderBlock'>
								 <center>
									 <div class="loadercircle"></div>
							 			<p>Please wait.....</p>
									</center>
							</div>
						 </div>
						<form method="POST" id="course_form">
							<div class='form-group '>
								<label >Title </label>
								<input  name='course_title' type='text' placeholder='Name' class='form-control'>
								<span class='help-block fdbk1 hidden'>Invalid Course selected</span>
							</div>
							<div class='form-group' >
								<label for='board-addcrs-field'> Description </label><span class='help-block fdbk2 '><p class='text-danger'>(Optional)</p></span>
								<textarea  name='course_description' cols='4' rows='5' class='form-control'></textarea>
								<span class='glyphicon glyphicon-warning-sign fdbk2  form-control-feedback hidden'></span>
								<span class='feedBack text-danger hidden'>Please  enter a Course title</span>
							</div>
							<button type='button' name='submit_course' id='course-submit-btn' class='btn btn-success btn-block tn-lg '><span class='glyphicon glyphicon-plus'> Add</span></button>

						</form>
					 </div>
					 <div class='col-lg-3 board-qk-tl'>
						<div class='panel panel-primary	'>
							<div class='panel-heading'>
								<h4 class='panel-title'>Quick Tools</h4>
							</div>
							<ul class='list-group'>
								 <a class='list-group-item' data-target='#add-course-modal' data-toggle='modal'><span class='glyphicon glyphicon-plus'></span> Add New Set</a>
								 <a href='Course.php?edit-course' class='list-group-item'  ><span class='glyphicon glyphicon-edit'></span> Edit Courses</a>
								 <div class='modal' id='add-course-modal' tabindex='-1'>
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												<a href='' data-dismiss='modal' class='close'>&times;</a>
												<h4 class='modal-title'>Add New Set</h4>
											</div>
											<div class='modal-body'>
											<form >
												<div class='form-group' id='set-modal-name-group'>
													<label for='set-modal-name-field'>Title </label>
													<input id='set-modal-name-field' type='text' placeholder='Name' class='form-control'>
													<span class='glyphicon glyphicon-warning-sign m-fdbk1  form-control-feedback hidden'></span>
													<span class='help-block m-fdbk1  hidden'>Invalid Description</span>
												</div>

											</form>
											</div>
											<div class='modal-footer'>
												<button id='set-modal-submit-btn' class='btn btn-success' >Add</button>
												<button class='btn btn-warning' data-dismiss='modal' >Close</button>
											</div>
										</div>
									</div>
								 </div>
							</ul>
							<div class='panel-footer'>

							</div>
						</div>
					 </div>
				</div>
				</div>
				<?php } ?>

				<!---------------------------------------------------------------------- edit board----------------------------------------------------------------------->
				<?php
				 if(isset($_GET['edit-course']))
					  {
							?>
						 <div class="col-lg-12" id='edit-course' style='height:100%'>
						<div class='row details-row' >
							<h4 class=' text-success'>Manage Courses</h4>
								<p class=' info-details ' style='font-family:Arial'>Edit and Manage Courses.</p>
							<form>
							<div class='form-group col-lg-8'>
								<div class='input-group'>
									<input type='text' placeholder='Search couse name' id='search_edit_course' class='form-control'>
									<span class='input-group-btn'>
										<button type='button' class='btn btn-success'><span class='glyphicon glyphicon-search'></span></button>
									</span>
								</div>
							</div>

						</form>

						</div>
				<div class='row' style='height:100%'>

					<div class='col-lg-9 board-form board-form-edit'>
					<div id='edit_course_modal' class='modal fade hidden' tabindex='-1'>
						<div class='modal-dialog modal-lg'>
						<div class='modal-content'>
						 <div class='modal-header'>
							 <a  id='close_edit_form' class='close' data-dismiss='modal'>&times;</a>
							<h3 class='modal-title'>Edit Course Content</h3>
						 </div>
						<div class='modal-body'>
						<form action='' id='edit_board' method='post'>
								<input type='hidden' id="courseId" name="courseId" />
							<div class='form-group'>
								<label for='board_name_field'>Title </label>
								<input id='board_name_field' name='Updatecourse_title' type='text' placeholder='Name' class='form-control'>
							</div>
							<div class='form-group'>
								<label for='board_description_field'> Description </label>
								<textarea id='board_description_field' name='course_description' cols='4' rows='5' class='form-control'></textarea>
							</div>
							   	<button id='update_course' data="" type='button' name='update_course' class='btn btn-success btn-block add-board'> Update</span></button>

						</form>
					</div>
					</div>
					</div>
					</div>
					<!-------------------------------------modal trigerer----------------------->

					</div>

				<!-- quick tools-->
					<div class='col-lg-3 col-xs-12 board-qk-tl pull-right'>
						 <div class='panel panel-primary	'>
							<div class='panel-heading'>
								<h4 class='panel-title'>Quick Tools</h4>
							</div>
							<ul class='list-group'>
								 <a href='Course.php?add-course' class='list-group-item'  ><span class='glyphicon glyphicon-plus'></span> Add New Course</a>
								 <a class='list-group-item' data-target='#view-board-modal'><span class='glyphicon glyphicon-edit'></span> Edit Course</a>

							</ul>
							<div class='panel-footer'>

							</div>
						</div>
					 </div>

							<div class='col-lg-9 col-xs-12 edit-table pull-left'>
								<div class="col-lg-12 hidden loader" id="loader">
	 							 <div class='loaderBlock'>
	 								 <center>
	 									 <div class="loadercircle"></div>
	 							 			<p>Please wait.....</p>
	 									</center>
	 							</div>
	 						 </div>
								<table class='table table-striped table-hover table-condensed ' id='edit-course-table'>
									<thead>
										<tr>
											<th></th>
											<th></th>
											<th>Title</th>
											<th>Description</th>
											<th>Published</th>
											<th></th>

										</tr>
									</thead>
									<tbody>
										<?php foreach ($courses as $key => $value):
                      $title=$value['title'];
                       $id=$value['id'];
                        ?>
											<tr>
												<td><?php echo $key+1	;?></td>
												<td><input type='checkbox'   course="<?php echo $id; ?>" data="<?php echo $value['title']; ?>" class='select' /></td>
												<td><?php echo $value['title'] ;?></td>
												<td><?php echo $value['description'] ;?></td>
												<td ><div class="status col-lg-7 pull-left  "> <?php if( $value['publish']=='Y' ){ echo "<span class='txt text-success'> Published"; }
												else{echo "<span class='txt text-danger'>Not published"; } ?></span><div class='load '></div>   </div>
												<center class'col-lg-2'> <?php if($value['publish']=="Y"){ echo "<span class=' pull-left text-success glyphicon glyphicon-ok'></span>"; }
																												else{ echo" <span class=' pull-left text-danger glyphicon glyphicon-remove'></span> ";}?>
													</center></td>

												<td class='button'> <div class='btn-group btn-group-xs'> <?php if( $value['publish']=='Y' ){ echo "
																								<button class='btn btn-xs btn-warning  publish' data='unpublish' title='{$title}' course='{$id}'>Unpublish</button>
																								<button type='button'  class='btn-primary btn edit' title='{$title}' course='{$id}'>&nbsp; Edit &nbsp;</button>
																								<button course='{$id}' title='{$title}' class='btn btn-danger btn-xs delete' >Delete</button>
																																			"; }else{ echo"
																												 							<button class='btn btn-xs btn-success publish' data='publish' title='{$title}' course='{$id}'>&nbsp; Publish &nbsp;</button>
																																			<button data-toggle='modal' data-target='' title='{$title}' class='btn-primary btn edit' course='{$id}'>&nbsp; Edit &nbsp;</button>
																																			<button course='{$id}' title='{$title}' class='btn btn-danger btn-xs delete' >Delete</button>
																																			";} ?>
																			    </div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>


							</div>
							<div class='well edit-board-well col-lg-9'>
								<ul>
									<li><a option="select"  class='text-primary chkbx '> <input type='checkbox' class=" " /> SelectAll  </a></li>
									<li><a option="delete"  class='text-warning chkbx'><span class='glyphicon  glyphicon-trash '></span> Delete</a></li>
									<li><a option="unpublish" class='text-danger chkbx'><span class='glyphicon glyphicon-remove'></span> Unpublish</a></li>
									<li><a option="publish" class='text-success chkbx'><span class='glyphicon glyphicon-ok'></span> publish</a></li>
								</ul>

							</div>
						</div>


				<?php } ?>

				</div>
					</div>

			</div>
		</div>
		</div><!--1st row-->
	</div><!--container-->

</body>
</html>
