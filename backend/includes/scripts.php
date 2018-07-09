<?php
    require("../db/connect.php");     if(!login()){  header("location:../"); }
	$courses=getCourses();
 	$noCourse=getCourseCount();
	$noSet=getSetCount();
	$noQuestion=getQuestionCount();

  $adminCourses=$_SESSION['ADMIN']['courses'];
  $adminCourses=explode('#/',$adminCourses);
  $all_set=getScriptSet($adminCourses);
  $countsUm= getScriptCountUm($all_set);
  $countsM= getScriptCountM($all_set);
  $counts=getAllSetScript($all_set);

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
	<link href="../css/scripts.css" rel="stylesheet">
	<script src='../js/jquery-3.1.0.min.js'></script>
	<script src='../js/jquery-ui.js'></script>
	<link  rel="stylesheet" href="../js/chosen_v1.4.0/chosen.min.css">
	 <script src='../js/chosen_v1.4.0/chosen.jquery.min.js'></script>
	<script src='../js/bootstrap.min.js'></script>
	<script src='../js/Chart.min.js'></script>
	 <script src='../js/script.js'></script>
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
												<li >
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
              <?php if($adminCourses[0]!="All") { ?> <li class='active'><a href='scripts.php'><span class="glyphicon glyphicon-book"></span> Exam Scripts</a></li> <?php } ?>
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
				<div class='row details-row'>
					<h4 class=' page_title text-success'>Script Making</h4>
						<p class=' info-details ' style='font-family:Arial'></p>
				</div>

				<div class='col-lg-12' id="tableContent">
						<div class='table-responsive'>
							<table class='table table-striped'>
									<thead>
										<tr>
										<th></th>
										<th>Course</th>
										<th>Set</th>
										<th>Attempts</th>
										<th>Unmarked</th>
										<th>Marked</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									 <?php
                                        foreach($all_set as $id=> $set)
                                        { ?>
                                         <tr>
										<td></td>
										<td><?php echo $set['course']; ?></td>
										<td><?php echo $set['title']; ?></td>
										<td><div class='label label-warning '><?php echo $counts[$set['course'].$id][$set['title']] ;?></div></td>
										<td><div class='label label-danger '><?php echo $countsUm[$set['course'].$id][$set['title']] ;?></div></td>
										<td><div class='label label-success '><?php echo $countsM[$set['course'].$id][$set['title']] ;?></div></td>
										<td><div class="btn-group btn-group-xs">
                                            <button set="<?php  echo $set['title']; ?>" course="<?php echo $set['course']; ?>" class='script btn btn-xs btn-primary  '><span class="script glyphicon glyphicon-eyes"></span> View</button>

                                            <button set="<?php  echo $set['title']; ?>" course="<?php echo $set['course']; ?>" 
                                                class='<?php if($countsUm[$set['course'].$id][$set['title']]==0){ echo "hidden" ;}?> btn btn-xs btn-success markall'>MarkAll</button>
                                            </div>
                                            </td>
									</tr>
                                    <?php }  ?>

								</tbody>
							</table>
						</div>
				</div>
      </div>
		</div>
	</div>
</div>
</body>
</html>
