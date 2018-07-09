<?php 
    require_once("server.php");
        if(!isset($_SESSION['setCourse']) || (trim($_SESSION['setCourse'])=="") || !isset($_SESSION['setnoq']) || trim($_SESSION['setnoq'])=="")
            {
                header("Location:../");
                exit();
            }

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
   
   
    <div class="col-lg-12 col-xs-12 n100 np" id="body">
         <div class="col-lg-12 col-xs-12" id="dark">
        <div class="col-lg-5 col-xs-12 col-lg-offset-3 logo">
            <img src="../includes/images/images(35).jpg" class='col-xs-offset-4 col-md-offset-5 col-lg-offset-5'/>
            <div class="col-lg-12 skulName">
                <div class="col-lg-12 col-xs-12 name text-success">DARTHOL INFOTECH SOLUTION</div>
                <div class="col-lg-12 cbt">Computer Based Test Facility</div>
            </div>
        </div>
        <div class="loader"></div>
        <div class="text">Please wait...</div>
        <div class='col-lg-5 col-lg-offset-3 col-xs-10 col-xs-offset-1 hidden' id="continue">
            <div class='col-lg-12' id='msg'>
                An attempt by <span class='name'>ALADESIUN IDOWU</span> was found .
                <b>Do you want to continue?</b>
            </div>
            <div class='col-lg-12' id='contBtns'>
                <button class='btn btn-test pull-left' id="contDismiss">Dismiss</button>
                <button class='btn btn-test pull-right' id="contAttmpt">Continue</button>
            </div>
        </div>
        
    </div>  
        
        
         <div class="row  head">
                <div class="col-lg-2 col-lg-offset-1 col-md-3 logo">
                    <img class='col-lg-10 col-xs-offset-4  col-lg-offset-6 pull-right ' src="../includes/images/images(35).jpg" />
                </div>
                <div class="col-lg-6 col-md-9 pull-left skulName">
                    <h1>DARTHOL INFOTECH SOLUTION</h1>
                    <p class='addr'>Beside alatide Comples , Pepsi cola area Osogbo , Osun Sate</p>
                    <div class="col-lg-12 cbt">Computer Based Test Facility</div>
                </div>
         </div>
        <div class="col-lg-12 col-xs-12 header"></div>
        <div class="col-lg-12 col-xs-12 body">
            
            <div class="col-lg-3 col-xs-12 col-md-3 pull-right col-lg-offset-1   bar">
                <div class="col-lg-12" id='time'>
                    <b class='col-lg-12'></b>
                </div>
                <div class="col-lg-12 " id='selector'>
                    <ul class='col-lg-12'>
                        
                    </ul>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <button class='btn btn-tst pull-right' id="finish">Finish attempt</button>
                </div>
            </div>
            
            <div class="col-lg-8 col-xs-12 col-md-8 pull-left content">
                 <!-- <div class="col-lg-12 Qcontent">
                    <img src="" class='col-lg-6' />
                    <b class='question col-lg-6'></b>
                </div>-->
                <div class="col-lg-12 col-xs-12  np bd">
                <div class="col-lg-12 Qcontent">
                        <div class="col-lg-12 col-xs-12 Qno pull-left"><span id="qNo"> </span></div>
                                <img src="" id="Qimg"  class='hidden' />
                                <b class='question col-lg-12' id="question"> </b>
                </div>
                
                <div class="option col-lg-12" >
                    <ul class='col-lg-12' id="options">
                        <li> <label>  <input type='radio' class='opt' value="1" name="answer" /> <span class='opt1'></span></label></li>
                        <li> <label>  <input type='radio' class='opt' value="2" name="answer" /> <span class='opt2'> </span> </label></li>
                        <li> <label>  <input type='radio' class='opt' value="3" name="answer" /> <span class='opt3'></span> </label></li>
                        <li> <label>  <input type='radio' class='opt' value="4" name="answer" /> <span class='opt4'> </span></label></li>
                        <li class='hidden' > <label>  <input type='radio' class='opt' value="5" name="answer" /> <span class='opt5'></span> </label></li>
                        
                    </ul>
                    <div class=" hidden" id="strAnsw">
                        <div class="form-group col-lg-6">
                            <input type="text" class='form-control' Placeholder="type your answer here" />
                           </div>
                    </div>
                </div> 
                   </div>
                <div class="col-lg-12 col-xs-12  controlls">
                    <button class='btn btn-default' id='prev' ><span class='glyphicon glyphicon-menu-left'></span> Previous</button>
                    <button class='btn btn-default pull-right' id='next' >Next  <span class='glyphicon glyphicon-menu-right '></span></button>
                </div>
                </div>
                
            
        </div>
    </div>
</body>
</html>