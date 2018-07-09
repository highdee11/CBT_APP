<?php
    require("../db/connect.php");     if(!login()){  header("location:../"); }
    if(!isset( $_SESSION['scriptSet']) ||  $_SESSION['scriptSet']==""){ header("location:scripts.php");}
	$courses=getCourses();
 	$noCourse=getCourseCount();
	$noSet=getSetCount();
	$noQuestion=getQuestionCount();

  $adminCourses=$_SESSION['ADMIN']['courses'];
  $adminCourses=explode('#/',$adminCourses);
  $all_set=getScriptSet($adminCourses);
    $allScripts=json_decode(getScripts());
   // print_r($allScripts);
//  $countsUm= getScriptCountUm($all_set);
//  $countsM= getScriptCountM($all_set);
//  $counts=getAllSetScript($all_set);

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
	<div class='container hidden-print '>

		<div class='row row1'>
	<!-- header row-->

		<div class="col-lg-12 hidden" id="screenLoader">
			<div class='lod'></div>
			<div class='lodTxt'>Please wait....</div>
		</div>

	<!-- main content row-->
		<div class='row  ' id='inner-row2'>
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
						<div class=' info-details ' style='font-family:Arial;padding:20px;'>
              <a style='margin-left:20px;'  class='pull-right' id="printAllScript" href="#"><span class='glyphicon glyphicon-print'></span> Print</a>
              <a class='pull-right' id="excel" href="../files/<?php echo  str_replace('/','_',$_SESSION['scriptCourse']).'_'.str_replace('/','_',$_SESSION['scriptSet']) ;?>.csv"><span class='glyphicon glyphicon-print'></span> Download</a>
            </div>

				</div>

				<div class='col-lg-12 ' id="tableContent">
						<div class='table-responsive'>
							<table class='table table-striped'>
									<thead>
										<tr>
										<th></th>
										<th>NAME</th>
										<th>Login Id</th>
										<th>Status</th>
										<th>Time Left</th>
										<th>Score</th>
                    <th>Grade</th>
										<th>Date</th>
										<th>Time Submitted</th>
										<th></th>
                    <th></th>
									</tr>
								</thead>
								<tbody>
									 <?php
                      foreach($allScripts as $id=> $script)
                      {
                          $alert=gradeAlert($script->perc);
                          $time=json_decode($script->timeLeft);
                      ?>
                    <tr>
                        <td></td>
                        <td><?php echo $script->student; ?></td>
                        <td><?php echo $script->username; ?></td>
                        <td><?php echo $script->submitted;?> </td>
                        <td><?php echo $time[0].':'.$time[1].':'.$time[2] ;?> </td>
                        <td><div class="label <?php echo $alert ;?>"><?php if($script->marked=='N'){echo "Not marked";}else{echo $script->perc.'%' ;}?></div></td>
                            <td><div class="label <?php echo $alert ;?>"><?php if($script->marked=='N'){echo "Not marked";}else{echo $script->grade;}?></div></td>
                                                <td><?php echo $script->date ;?> </td>
                                                <td><?php echo $script->time ;?> </td>
                            <td><button  data_id="<?php echo $script->id;?> "   class="viewscript  btn btn-xs btn-danger <?php if($script->marked!='Y'){echo "hidden";} ?> " data_id="<?php echo $script->id;?> "  >View</button></td>
                        <td><button  data_id="<?php echo $script->id;?> "  class='mark btn btn-xs btn-primary  <?php if($script->marked!='N'){echo "hidden";} ?>' >mark</button></td>
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
<div class='col-lg-12 hidden visible-print' id="results">

    <div class="row  head">
           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 logo">
               <img class='col-lg-10 col-xs-12 col-lg-offset-6  ' src="../../includes/images/images(35).jpg" />
           </div>
           <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12 skulName">
               <h1>COVENANT SECONDARY ACADEMY</h1>
               <p class='addr'><b>P.O BOX 132 </b> , Opposite Federal Housing Estate ,Afao Road , Ado ekiti </p>
               <b><?php echo $_SESSION['scriptSet'];?></b>
           </div>
 <b class='col-lg-12'>COURSE: <?php echo $_SESSION['scriptCourse'];?></b>
  </div>
    <div class='col-lg-12 body '>
      <div class='table-responsive'>
          <table class='table  table-striped'>
            <thead>
              <tr>
              <th></th>
              <th>ID</th>
              <th>NAME</th>
              <th>SCORE</th>
              <th>GRADE</th>
            </tr>
          </thead>
          <tbody>
            <?php
               foreach($allScripts as $id=> $script)
               {?>
                  <tr>
                    <td><?php echo $id+1;?></td>
                    <td><?php echo $script->username;?></td>
                    <td><?php echo $script->student;?></td>
                    <td><?php echo $script->perc;?>%</td>
                    <td><?php echo $script->grade;?></td>
                  </tr>
          <?php }?>
          <tbody>
          </table>
      </div>
    </div>
</div>
</body>
</html>
