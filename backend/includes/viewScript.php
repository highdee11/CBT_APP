<?php
    require("../db/connect.php");     if(!login()){  header("location:../"); }
    if(!isset( $_SESSION['viewscript']) ||  $_SESSION['viewscript']=="" ){ header("location:scripts.php");}
	$courses=getCourses();
 	$noCourse=getCourseCount();
	$noSet=getSetCount();
	$noQuestion=getQuestionCount();

  $adminCourses=$_SESSION['ADMIN']['courses'];
  $adminCourses=explode('#/',$adminCourses);
  $all_set=getScriptSet($adminCourses);
    $allScripts=json_decode(getScripts());
   $questions= getquestionsScript();
   $questionStudent= getStudentquestionAnsw();
    $details=getquestionPaperDet();

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
<body id="questionPaper">
	<div class='container'>

		<div class='row row1' id='body'>
	<!-- header row-->
             <div class="col-lg-12 col-xs-12 head">
              <div class="col-lg-3 logo">
                    <img class='col-lg-10 col-lg-offset-6 ' src="../../includes/images/images(35).jpg" />
                </div>
                <div class="col-lg-6 skulName">
                    <h1>DARTHOL INFOTECH SOLUTION</h1>
                    <p class='addr'><b>P.O BOX 132 </b> , Opposite Federal Housing Estate ,Afao Road , Ado ekiti </p>
                     <div class="col-lg-12 text-success cbt">Computer Based Test Facility</div>
                    <div class="col-lg-8 col-lg-offset-2 col-xs-offset-3 col-xs-9 ansBk"><span class='pull-left col-lg-12'>Examination Answer Booklet</span></div>
                </div>
                  
         </div>

		<div class="col-lg-12 hidden" id="screenLoader">
			<div class='lod'></div>
			<div class='lodTxt'>Please wait....</div>
		</div>

	<!-- main content row-->
		<div class='row' id='inner-row2'>

		<!-- main content-->
			<div  class=' col-lg-12 col-md-12 col-sm-12  col-xs-12' >
                    <a class='hidden-print' href="script.php">Go back</a>
                    <a   id="print" href="" class=" hidden-print pull-right"><span class="glyphicon glyphicon-print"></span> <b>PRINT</b> </a>
				<div class='row details-row'>
					<h4 class=' page_title text-success'><center><?php echo $details['set'];?></center></h4>

				</div>
                <div class="col-lg-12 " id="details">
                    <ul class='col-lg-12'>
                        <li>Name: <?php echo $details['name'];?></li>
                        <li>Course: <?php echo $details['course'];?></li>
                        <li>Score: <?php echo $details['perc'];?>%</li>

                    </ul>
                </div>
               <?php
                foreach($questions as $id=>$value)
                {  ?>
                <div class="col-lg-12" id='questions'>
                    <div class="col-lg-12 content">
                        <?php if($value['image']!="") { ?> <img src="<?php echo'../questionImg/'.$value['image'] ;?> "/> <?php } ?><br/>
                        <?php echo $value['content'];?>
                    </div>
                    <ul class="col-lg-12  options <?php if($value['structureOption']!=null){ echo "hidden"; } ?>">
                        <li> <?php echo $value['optionA']; ?>&nbsp;&nbsp;&nbsp;
                            <span class="<?php if((int)$questionStudent[$value['serial']]!=1){ echo "hidden";}?> glyphicon glyphicon-ok "></span>
                        </li>
                        <li> <?php echo $value['optionB']; ?>
                            &nbsp;&nbsp;&nbsp;
                            <span class="<?php if((int)$questionStudent[$value['serial']]!=2){ echo "hidden";}?> glyphicon glyphicon-ok "></span>
                        </li>
                        <li> <?php echo $value['optionC']; ?>
                            &nbsp;&nbsp;&nbsp;
                            <span class="<?php if((int)$questionStudent[$value['serial']]!=3){ echo "hidden";}?> glyphicon glyphicon-ok "></span>
                        </li>
                        <li> <?php echo $value['optionD']; ?>
                            &nbsp;&nbsp;&nbsp;
                            <span class="<?php if((int)$questionStudent[$value['serial']]!=4){ echo "hidden";}?> glyphicon glyphicon-ok "></span>
                        </li>
                        <?php if($value['optionE']!="") { ?> <li> <?php echo $value['optionE']; ?>
                            &nbsp;&nbsp;&nbsp;
                            <span class="<?php if((int)$questionStudent[$value['serial']]!=5){ echo "hidden";}?> glyphicon glyphicon-ok "></span>
                        </li> <?php } ?>
                    </ul>

                    <div class="form-group <?php if($value['structureOption']==null){ echo "hidden"; } ?>">
                        <h4>Answer</h4>
                        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $questionStudent[$value['serial']]; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </div>
                </div>
				<?php } ?>
            </div>
		</div>
	</div>
</div>
</body>
</html>
