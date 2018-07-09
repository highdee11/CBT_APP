<?php

 	require("../db/connect.php");     if(!login()){  header("location:../"); }
 	$courseTitles=getCourses();
  $setTitles=getsets();
  $questions=getQuestions();
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
	<link href="../css/Question.css" rel="stylesheet">
	<script src='../js/jquery-3.1.0.min.js'></script>
	<script src='../js/jquery-ui.js'></script>
	<script src='../js/bootstrap.min.js'></script>
	<script src='../js/Chart.min.js'></script>
	  <link  rel="stylesheet" href="../js/chosen_v1.4.0/chosen.min.css">
	 <script src='../js/chosen_v1.4.0/chosen.jquery.min.js'></script>
	 <script src='../js/Question.js'></script>
</head>
<body>
	<div class='container'>
		<div class='row row1'>

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
						<li class='active'>
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
        if(isset($_GET['add-question']))
        {
            ?>
			<div class='row'>
					<h3 class='text-success'>Create Question</h3>
					<p class='text-warning'>Create and Add New questions to their respective set</p>
				</div>
        <div class="col-lg-12 alert alert-success hidden set_feedback">
					<center><b></b></center>
				</div>
				<div class='row'>
          <div class="col-lg-12 hidden loader" id="loader">
           <div class='loaderBlock'>
             <center>
               <div class="loadercircle"></div>
                <p>Please wait.....</p>
              </center>
          </div>
         </div>
					 <div class='col-lg-12 question-col'>
						<form id="question_form" method='post' enctype='multipart/form-data'>
						<div class='row'>
									<div class='form-group col-lg-3 col-xs-6' id='question-course-group'>
										<label for='question-set'>Add question to a course</label>
										<select id='question-select-course' name='quest_course'  class='form-control impor'   placeholder='select set' >
                                            <option></option>
  										<?php
  											foreach ($courseTitles as $key => $value) {  ?>
  													<option value="<?php echo $value['title']; ?>" > <?php echo $value['title']; ?></option>
  											<?php }
  										?>
										</select>
										<span class='glyphicon glyphicon-warning-sign fdbks1  form-control-feedback hidden'></span>
										<span class='help-block fdbks1  hidden'>Invalid Set selected</span>

									</div>
									<div class='form-group col-lg-3 col-xs-6' id='question-set-group'>
										<label for='question-set'>Add question to a Set</label>
										<select id='question-select-sets' name='quest_set'  class='form-control impor' disabled  placeholder='select set'>
										</select>
										<span class='glyphicon glyphicon-warning-sign fdbks3  form-control-feedback hidden'></span>
										<span class='help-block fdbks3  hidden'>Invalid Set selected</span>

									</div>

									<div class='col-lg-3 col-xs-6'>
										<label for='question_img'>Upload question image</label>
										<input type='file' name='quest_img' class='form-control ' />
										<span class='help-block'>(Optional)</span>
									</div>
									</div>


							<div class='form-group' id='question-content-group'>
								<label for='question-content'></label>
								<textarea id='question-content' cols='4' rows='5' name='quest_cont' class='form-control impor' placeholder='Question Content'></textarea>
								<span class='glyphicon glyphicon-warning-sign fdbk0  form-control-feedback hidden'></span>
								<span class='help-block fdbk0 hidden'>Invalid content </span>
							</div>
              <ul class='nav nav-tabs'>
                <li class='active qPattern'> <a id='objTrigger' href='#obj' data-toggle="tab"><label> <input type='radio' class='Prad' name='' checked/> Objective </label></a> </li>
                <li class="qPattern"><a id='strTrigger' href='#str' data-toggle="tab"><label > <input type='radio' class='Prad' name=''/> Structural</label></a></li>
              </ul>
              <div class='col-lg-12 tab-content'>
              <div class="col-lg-12 tab-pane" id='str'>
                <div class="col-lg-12 headInstr">
                  <div class='alert alert-success'>
                    Type the answer in the field below and if the answer can be written in more than one way kindly
                     type them in the field by separating each answer pattern by a hash "#" symbol .
                  </div >
                </div>
                <div class='form-group col-lg-8'>
                  <label>Answer</label>
                  <textarea name='strAnsw' class='form-control impor' cols='4' rows='5' disabled></textarea>
                  	<span class='help-block fdbks3  hidden'>Invalid Set selected</span>
                </div>
                <button id='question-submit-bt' type='button' name='submit_question' class='btn btn-block btn-success'><span class='glyphicon glyphicon-plus'></span> Add</button>
              </div>
              <div class="col-lg-12 tab-pane active" id='obj'>
							<div class='row ' >
							<div class='form-group col-lg-6 col-xs-12' id='option-group1'>
								<label for='option1'>Option A</label>
								<input id='option1' name='quest_opt1' type='text' class='form-control impor' >
								<span class='glyphicon glyphicon-warning-sign fdbk1 form-control-feedback hidden'></span>
								<span class='help-block fdbk1 hidden'>Invalid option</span>
							</div>
							<div class='form-group col-lg-6 col-xs-12' id='option-group2'>

								<label for='option2'>Option B</label>
								<input id='option2' name='quest_opt2' type='text' class='form-control impor' >
								<span class='glyphicon glyphicon-warning-sign fdbk2  form-control-feedback hidden'></span>
								<span class='help-block fdbk2 hidden'>Invalid option</span>

							</div>
							</div>
							<div class='row'>
							<div class='form-group col-lg-6 col-xs-12' id='option-group3'>
								<label for='option3'>Option C</label>
								<input id='option3' type='text' name='quest_opt3' class='form-control impor' >
								<span class='glyphicon glyphicon-warning-sign fdbk3  form-control-feedback hidden'></span>
								<span class='help-block fdbk3 hidden'>Invalid option</span>
							</div>
							<div class='form-group col-lg-6 col-xs-12' id='option-group4'>
	                <label for='option4'>Option D</label>
								<input id='option4' type='text' name='quest_opt4' class='form-control impor' >
								<span class='glyphicon glyphicon-warning-sign fdbk4  form-control-feedback hidden'></span>
								<span class='help-block fdbk4 hidden'>Invalid option</span>
                                </div>
                                <div class='form-group hidden'  id='option-group5'>
								<label for='option5'>Option E</label>
								<input id='option5' type='text' name='quest_opt5' class='form-control' />
								<span class='glyphicon glyphicon-warning-sign fdbk5  form-control-feedback hidden'></span>
								<span class='help-block fdbk5 hidden'>Invalid option</span>
							</div>
							<a href='#' class='option_add'><span class='glyphicon glyphicon-plus'></span> Add one option field</a>
							</div>


							<div class='radio col-lg-6 col-xs-12 ' id='answer'>
								<label for='answ1'><input id='answ1' type='radio' name='quest_answ' value='1' class=' ' > OptionA </label>
								<label for='answ2'><input id='answ2' type='radio' name='quest_answ' value='2' class=' ' > OptionB </label>
								<label for='answ3'><input id='answ3' type='radio' name='quest_answ' value='3' class=' ' > OptionC </label>
								<label for='answ4'><input id='answ4' type='radio' name='quest_answ' value='4' class=' ' > OptionD </label>
	              <span class='help-block fdbksa hidden'>Answer not set</span>
							</div>
							<button id='question-submit-btn' type='button' name='submit_question' class='btn btn-block btn-success'><span class='glyphicon glyphicon-plus'></span> Add</button>
            </div>
              </div>
						</form>

					 </div>
				</div></div>
		<?php  } ?>

				<?php
        if(isset($_GET['edit-question']))
				{
					 	?>
          <div class='col-lg-12'>
            <div id='edit_question_modal' class='modal fade hidden col-lg-12' tabindex='-1'>
              <div class='modal-dialog modal-lg  ol-lg-12'>
              <div class='modal-content  col-lg-12'>
               <div class='modal-header  col-lg-12'>
                 <a  id='close_edit_form' class='close' data-dismiss='modal'>&times;</a>
                <h3 class='modal-title'>Edit Course Content</h3>
               </div>
              <div class='modal-body  col-lg-12'>
                <form id="question_form" method='post' enctype='multipart/form-data'>
                  <input type='hidden' id="questionId" name="questionId" />
                <div class='row'>
                      <div class='form-group col-lg-3 col-xs-6' id='question-course-group'>
                        <label for='question-set'>Add question to a course</label>
                        <select id='question-select-course' name='quest_course'  class='form-control impor'   placeholder='select set' >
                          <option></option>
                          <?php
                            foreach ($courseTitles as $key => $value) {  ?>
                                <option value="<?php echo $value['title']; ?>" > <?php echo $value['title']; ?></option>
                            <?php }
                          ?>
                        </select>
                        <span class='glyphicon glyphicon-warning-sign fdbks1  form-control-feedback hidden'></span>
                        <span class='help-block fdbks1  hidden'>Invalid Set selected</span>

                      </div>
                      <div class='form-group col-lg-3 col-xs-6' id='question-set-group'>
                        <label for='question-set'>Add question to a Set</label>
                        <select id='question-select-sets' name='quest_set'  class='form-control impor'    placeholder='select set'>
                          <?php
                            foreach ($setTitles as $key => $value) {  ?>
                                <option value="<?php echo $value['title']; ?>" > <?php echo $value['title']; ?></option>
                            <?php }
                          ?>
                        </select>
                        <span class='glyphicon glyphicon-warning-sign fdbks3  form-control-feedback hidden'></span>
                        <span class='help-block fdbks3  hidden'>Invalid Set selected</span>

                      </div>

                      <div class='col-lg-3 col-xs-6'>
                        <label for='question_img'>Upload question image</label>
                        <input type='file' name='quest_img' class='form-control ' />
                        <span class='help-block'>(Optional)</span>
                      </div>
                      </div>
                        <div class='col-lg-12 ' id='Qimg'>
                          <center> <img src=''  class='col-lg-10 col-lg-offset-1'/></center>
                        </div>

                  <div class='form-group  ' id='question-content-group'>
                    <label for='question-content'></label>
                    <textarea id='question-content' cols='4' rows='5' name='update_quest_cont' class='form-control impor' placeholder='Question Content'></textarea>
                    <span class='glyphicon glyphicon-warning-sign fdbk0  form-control-feedback hidden'></span>
                    <span class='help-block fdbk0 hidden'>Invalid content </span>
                  </div>
                  <ul class='nav nav-tabs'>
                    <li class='active qPattern'> <a id='objTrigger' href='#obj' data-toggle="tab"><label> <input type='radio' class='Prad' name='' checked/> Objective </label></a> </li>
                    <li class="qPattern"><a id='strTrigger' href='#str' data-toggle="tab"><label > <input type='radio' class='Prad' name=''/> Structural</label></a></li>
                  </ul>
                  <div class='col-lg-12  tab-content'>
                  <div class="col-lg-12 tab-pane" id='str'>
                    <div class="col-lg-12 headInstr">
                        <br/>
                        <br/>
                      <div class='alert alert-success'>
                        Type the answer in the field below and if the answer can be written in more than one way kindly
                         type them in the field by separating each answer pattern by a hash "#" symbol .
                      </div >
                    </div>
                    <div class='form-group col-lg-8'>
                      <label>Answer</label>
                      <textarea id="structural" name='strAnsw' class='form-control impor' cols='4' rows='5' disabled></textarea>
                        <span class='help-block fdbks3  hidden'>Invalid Set selected</span>
                    </div>

                  </div>
                  <div class="col-lg-12 tab-pane active" id='obj'>
                  <div class='row ' >
                  <div class='form-group col-lg-6 col-xs-12' id='option-group1'>
                    <label for='option1'>Option A</label>
                    <input id='option1' name='quest_opt1' type='text' class='form-control impor' >
                    <span class='glyphicon glyphicon-warning-sign fdbk1 form-control-feedback hidden'></span>
                    <span class='help-block fdbk1 hidden'>Invalid option</span>
                  </div>
                  <div class='form-group col-lg-6 col-xs-12' id='option-group2'>

                    <label for='option2'>Option B</label>
                    <input id='option2' name='quest_opt2' type='text' class='form-control impor' >
                    <span class='glyphicon glyphicon-warning-sign fdbk2  form-control-feedback hidden'></span>
                    <span class='help-block fdbk2 hidden'>Invalid option</span>

                  </div>
                  </div>
                  <div class='row'>
                  <div class='form-group col-lg-6 col-xs-12' id='option-group3'>
                    <label for='option3'>Option C</label>
                    <input id='option3' type='text' name='quest_opt3' class='form-control impor' >
                    <span class='glyphicon glyphicon-warning-sign fdbk3  form-control-feedback hidden'></span>
                    <span class='help-block fdbk3 hidden'>Invalid option</span>
                  </div>
                  <div class='form-group col-lg-6 col-xs-12' id='option-group4'>
                      <label for='option4'>Option D</label>
                    <input id='option4' type='text' name='quest_opt4' class='form-control impor' >
                    <span class='glyphicon glyphicon-warning-sign fdbk4  form-control-feedback hidden'></span>
                    <span class='help-block fdbk4 hidden'>Invalid option</span>
                  </div>
                  <div class='form-group hidden'  id='option-group5'>
                    <label for='option5'>Option E</label>
                    <input id='option5' type='text' name='quest_opt5' class='form-control' />
                    <span class='glyphicon glyphicon-warning-sign fdbk5  form-control-feedback hidden'></span>
                    <span class='help-block fdbk5 hidden'>Invalid option</span>
                  </div>
                  <a href='#' class='option_add'><span class='glyphicon glyphicon-plus'></span> Add one option field</a>
                  </div>


                  <div class='radio col-lg-6 col-xs-12 ' id='answer'>
                    <label for='answ1'><input id='answ1' type='radio' name='quest_answ' value='1' class=' ' > OptionA </label>
                    <label for='answ2'><input id='answ2' type='radio' name='quest_answ' value='2' class=' ' > OptionB </label>
                    <label for='answ3'><input id='answ3' type='radio' name='quest_answ' value='3' class=' ' > OptionC </label>
                    <label for='answ4'><input id='answ4' type='radio' name='quest_answ' value='4' class=' ' > OptionD </label>
                    <span class='help-block fdbksa hidden'>Answer not set</span>
                  </div>

                </div>	<button id='update_question' data="" type='button' name='update_question' class='btn btn-success btn-block add-board'> Update                </button>
                  </div>
                </form>
            </div>
            </div>
            </div>
            </div>
			<div class='col-lg-12  '>
        <div class='row'>
					<h3 class='text-success'>Manage Questions</h3>

					<form>
					<div class='row'>
            <div class='col-lg-2 form-group'>
              <label>Select Course</label>
              <select id='question_search_course' name='quest_course'  class='form-control impor'   placeholder='select set' >
                
                <?php
                  foreach ($adminCourses as $key => $value) {  ?>
                      <option value="<?php echo $value; ?>" > <?php echo $value; ?></option>
                  <?php }
                ?>
              </select>
            </div>
						<div class='form-group col-lg-2'>
              <label>Select Set</label>
              <select id='question_search_set' name='quest_set'  class='form-control impor'    placeholder='select set'>

              </select>
						</div>
						<div class='form-group col-lg-6'>
              <label>Search Question</label>
							<div class='input-group'>
							<input type='text' class='form-control' id='search_question_field' placeholder='Search Questions'>
							<span class='input-group-btn'>
								<button class='btn btn-primary' type='button'><span class='glyphicon glyphicon-search'></span></button>
							</span>
							</div>
						</div>
					</div>
					</form>

			</div>


            </div>
             <div class='col-lg-12 col-xs-12 edit-table pll-left'>
              <div class="col-lg-12 hidden loader" id="loader">
               <div class='loaderBlock'>
                 <center>
                   <div class="loadercircle"></div>
                    <p>Please wait.....</p>
                  </center>
              </div>
             </div>
  								<div class='table-responsive'>
  								<table id='edit_question_table' class='table table-striped table-hover table-condensed '>
  									<thead>
  										<tr>
  											<th>Id</th>
  											<th></th>
                                            <th>Course</th>
                                            <th>Set</th>
                                            <th>Question</th>
  											<th>Option A</th>
  											<th>Option B</th>
  											<th>Option C</th>
  											<th>Option D</th>
  											<th>Option E</th>
  											<th>Structural</th>

  											<th></th>
  										</tr>
  									</thead>
  									<tbody>
                      <?php foreach ($questions as $key => $value):
                        $title=$value['course'];
                          $id=$value['id']; ?>
                        <tr>
                          <td><?php echo $key+1	;?></td>
                          <td><input type='checkbox' course="<?php echo $id; ?>" data="<?php echo $value['serial']; ?>" class='select' /></td>
                          <td><?php echo $value['course'] ;?></td>
                          <td><?php echo $value['Qset'] ;?></td>
                          <td><?php echo $value['content'] ;?></td>
                          <td><?php echo $value['optionA'] ;?></td>
                          <td><?php echo $value['optionB'] ;?></td>
                          <td><?php echo $value['optionC'] ;?></td>
                          <td><?php echo $value['optionD'] ;?></td>
                          <td><?php echo $value['optionE'] ;?></td>
                          <td><?php echo $value['structureOption'] ;?></td>
                          <td class='button'> <div class='btn-group btn-group-xs'>
                                                <button type='button'  class='btn-primary btn edit'  title='<?php echo $title; ?>' course='<?php echo $id; ?>'>&nbsp; Edit &nbsp;</button>
                                               <button  title='<?php echo $title; ?>' course='<?php echo $id; ?>' class='btn btn-danger btn-xs delete' >Delete</button>
                                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
  									</tbody>
  								</table>

  								</div>
  							</div>
                <div class='well edit-board-well col-lg-9'>
  								<ul>
  									<li><a option="select"  class='text-primary chkbx '> <input type='checkbox' class=" " /> SelectAll  </a></li>
  									<li><a option="delete"  class='text-warning chkbx'><span class='glyphicon  glyphicon-trash '></span> Delete</a></li>

  								</ul>

  							</div>
              </div>
				<?php } ?>



		</div>
		</div><!--1st row-->
	</div><!--container-->

</body>
</html>
