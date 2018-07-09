<?php 
    require_once("../question/server.php");
    
    $examSet=getExamSet();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UI-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Question</title>
	<link href="../includes/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<script src='../includes/js/jquery-3.1.0.min.js'></script>
	<script src='../includes/js/jquery-ui.js'></script>
	<script src='../includes/js/bootstrap.min.js'></script>
	<script src='jquery.js'></script>
</head>
    <body>
       
        <div id="bkWhite"></div>
        <div class="row" id="body">
            <div class="row  head">
                <div class="col-lg-3 col-xs-12 col-md-2 logo">
                    <img class='col-lg-10 col-xs-offset-4 col-lg-offset-6 ' src="../includes/images/images(35).jpg" />
                </div>
                <div class="col-lg-6 col-md-10 skulName">
                    <h1>DARTHOL INFOTECH SOLUTION</h1>
                    <p class='addr'>Beside alatide Comples , Pepsi cola area Osogbo , Osun Sate</p>
                     <p><b class='text-success'> Computer Base Test Facility</b></p>
                </div>
            </div>
            <div class="row  body">
                <div class='col-lg-12 col-xs-12 welcome'><b class='col-lg-10'>Welcome  ALADESIUN IDOWU ADEDAMOLA </b> 
                    <div class='col-lg-offset col-lg-1 col-xs-12 '><a class='col-lg-4 pull-right' href=""><button class='btn btn-test btn-bd btn-xs' >Logout</button></a></div>
                </div>
                <div class="col-lg-12 col-xs-12" id="content">
                    <div class="col-lg-5 col-xs-12  instruction   alert  alert-success">
                       
                        <div class='col-lg-12' id="instr">
                            <center> <h2 class='header'>Exam Selection</h2> </center> 
                        <ul class="col-lg-12">
                            <li>Select from the following list of Available Exams.</li> 
                            <li>Every testyhas its own time limit. </li>
                            <li>Ensure you submit your answer before you leave the examination hall. </li>
                        </ul> 
                        </div>
                        
                        <div class='col-lg-12  hidden' id="setDetails">
                            <div class='col-lg-12 loadBack'><div class='load'></div><br/><p>Fetching required Information</p>
                            <div class="col-lg-12" id="backLoader">
                            <button id="backloader"   class='btn btn-test pull-left' >Go Back</button>
                            </div></div>
                                <center> <h2 class='header ' ><span class='title'></span> </h2></center> 
                        <ul class="col-lg-12">
                            <li class='col-lg-12'><b class='col-lg-3'>Course:</b><span class='col-lg-3 cos'></span>  </li>
                            <li class=' col-lg-12'><b class='col-lg-3'>Class:</b><span class='col-lg-3 class'></span>  </li>
                            <li class=' col-lg-12'><b  class='col-lg-3'>Questions:</b><span class=' col-lg-3 noq'></span></li>
                            <li class=' col-lg-12'><b class='col-lg-3'>Time:</b><span class='col-lg-3 time'></span></li>
                        </ul>
                        
                        <div class="col-lg-12" id="controlls">
                            <button id="back"   class='btn btn-test pull-left' >Go Back</button>
                            <button id="start"  class='btn btn-test pull-right' >Start</button>
                        </div>
                        </div>
                    </div>
                    <div class='col-lg-6 col-xs-12 col-lg-offset-1 start pull-right ' id="courses">
                    <ul class='col-lg-12 col-lg-offset-1 inner' >
                      <?php 
                        foreach($examSet as $key=>$value): ?>
                            <li class='col-lg-11 col-xs-12 col-md-5 examSet' noq="<?php echo $value['noq']; ?>" course="<?php echo $value['course']; ?>"  data_id="<?php echo $value['id']; ?>"  SetTitle="<?php echo $value['title']; ?>">
                                <span class='set col-lg-12 pull-left'><b>Exam: </b><?php echo $value['title'] ?></span>
                                <span class='course col-lg-12 pull-left'><b>Course: </b><?php echo $value['course'] ?></span> 
                                <span class='level col-lg-12 pull-left'><b>Class: </b><?php echo $value['class'] ?></span>
                            </li >
                        <?php endForeach; ?>
                    </ul>
                </div>
                </div>
            </div>
        </div>  
        <div class="col-lg-12 col-xs-12" id="footer">
            <b class='col-lg-2 pull-right'>Powered by <span class='text-success'>Darthol</span></b>
        </div>
    </body>
</html>