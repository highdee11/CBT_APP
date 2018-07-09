<?php
        require("../db/connect.php");     if(!login()){  header("location:../"); }
    $noCourse=getCourseCount();
  	$noSet=getSetCount();
  	$noQuestion=getQuestionCount();

  $adminCourses=$_SESSION['ADMIN']['courses'];
  $adminCourses=explode('#/',$adminCourses);
  $bestResults=json_decode(getHighestScores());
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
	<script src='../js/jquery-3.1.0.min.js'></script>
	<script src='../js/jquery-ui.js'></script>
	<script src='../js/Chart.min.js'></script>
	<script src='../js/bootstrap.min.js'></script>
	 <script src='../js/Dashboard.js'></script>


</head>
<body>

	<div class='container '>
		<div class='row row1 '>


	<!-- main content row-->
		<div class='row  display-table-row' id='inner-row2'>
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
						<li  class='active' ><a href='Dashboard.php'><span class='glyphicon glyphicon-th'></span> DashBoard</a></li>
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

			<div  class='maincontent col-lg-10 col-md-10 col-sm-9  col-xs-12 display-table-cell'>
				<div class='alert alert-success'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Welcome! <?php echo $_SESSION['ADMIN']['name'];  ?></strong>   <br/>Note:Any changes you make here will have effect on the main Page.
				</div>

				<div class='row'>
					<div id='stats1' class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
							<ul>

								<li class='col-lg-3   col-md-4 col-sm-6 col-xs-12' style='padding:0px'>
								<div class='row'>
									<div class='col-lg-5 col-md-3 col-sm-4 col-xs-7 hidden-xs' >
									<span class='glyphicon glyphicon-user'></span>
									</div>
									<div class='col-lg-7  col-md-9 col-sm-8 col-xs-12'   >
										<div class='row'>
											<div class='col-lg-12'>
											<h1 class='pull-right'>0000</h1>
											</div>
											<div class='col-lg-12'>
											<p class='pull-right'>Population of Student</p>
											</div>
										</div>
									</div>
									</div>
								</li>

								<li class='col-lg-3  col-lg-offset-1 col-md-4 col-sm-6 col-xs-12' style='padding:0px'>
								<div class='row'>
									<div class='col-lg-5 col-md-3 col-sm-4 col-xs-7 hidden-xs' >
									<span class='glyphicon glyphicon-user'></span>
									</div>
									<div class='col-lg-7  col-md-9 col-sm-8 col-xs-12'   >
										<div class='row'>
											<div class='col-lg-12'>
											<h1 class='pull-right'>0000</h1>
											</div>
											<div class='col-lg-12'>
											<p class='pull-right'>Population of Student</p>
											</div>
										</div>
									</div>
									</div>
								</li>

								<li class='col-lg-3  col-lg-offset-1 col-md-4 col-sm-6 col-xs-12' style='padding:0px'>
								<div class='row'>
									<div class='col-lg-4 col-md-3 col-sm-4 col-xs-7 hidden-xs' >
									<span class='glyphicon glyphicon-question-sign'></span>
									</div>
									<div class='col-lg-8  col-md-9 col-sm-8 col-xs-12'   >
										<div class='row'>
											<div class='col-lg-12'>
											<h1 class='pull-right'><?php echo $noQuestion[0]; ?></h1>
											</div>
											<div class='col-lg-12 '>
											<p class='' style='padding-left:10px'>Number of Questions</p>
											</div>
										</div>
									</div>
									</div>
								</li>




							</ul>
					</div>
				</div>
				<div class='row'>
				<div id='bar-graph' class=' col-lg-4 col-md-4 col-sm-6 col-xs-12'>
					<canvas id='mycanvas' width='600px' height='600px'></canvas>
				</div>
				<div id='line-graph' class=' col-lg-4 col-md-3 col-sm-5 col-xs-12'>
					<canvas id='mycanvas2' width='600px' height='600px'></canvas>
				</div>
				<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12'>
				<div id='dash-panel' class='panel panel-primary'>
					 <div class='panel-heading'>
						<h4 class='panel-title'> Best Student Score On Board </h4>
					 </div>
					 <div class='panel-body'></div>
						<table class='table table-striped'>
							<thead>
								<tr>
									<th>Reg NO</th>
									<th>Name</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>
                                <?php 
                                foreach($bestResults as $key=>$value)
                                    {?>
                                        <tr>
                                            <td><?php echo $key+1;?></td>
                                            <td><?php echo $value->student ; ?></td>
                                            <td><?php echo $value->mx ; ?></td>
                                        </tr>
                              <?php } ?>

							</tbody>


						</table>
					 <div class='panel-footer'>
						<a href='viewScript.php'>View All</a>
					 </div>
				</div>
				</div>
				</div>
			</div>

		</div>

		</div><!--1st row-->

	</div><!--container-->

</body>
</html>
