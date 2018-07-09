$(function(){

	function loader()
		{
			$("#loader div.loaderBlock div.loadercircle").addClass('start');
			$("#loader").removeClass('hidden');
		}
  function loaderOff()
		{
			setTimeout(function(){
				$("#loader .loaderBlock .loadercircle").removeClass('start');
				$("#loader").addClass('hidden');
			},500);
		}
	function screenLoader()
		{
			 $("#screenLoader .lodTxt").html("<b >please wait......</b>");
			$("#screenLoader").addClass('show');
			$("#screenLoader .lod").addClass('start');
            $("#screenLoader").removeClass('hidden');
		}
		function screenLoaderOff()
		{
			setTimeout(function(){
				$("#screenLoader").removeClass('show');
			$("#screenLoader .lod").removeClass('start');
                $("#screenLoader").addClass('hidden');
		},500);
		}

	//-------------------------------------------getting all sets--------------------------------------//
	var sets={};

	$.post('../db/connect.php',{getSet:1},function(data){
			sets=JSON.parse(data);
			//console.log(sets);
	});

//-------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------UPDATING SETS FIELD----------------------------------------------------------------------------//

	$("#question-select-course").change(function(){

		var course=$(this).val();

		var courseSet=[];
		courseSet.push("<option value=''> </option>");
			 sets.forEach(function(key){
					if(key['course']==course)
					{
						var set=key['title'];
							courseSet.push("<option value="+set+">"+set+"</option>");
					}
			});

			$("#question-select-sets").removeAttr('disabled').html(courseSet);
	});

//-----------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------UPDATING SETS FIELD----------------------------------------------------------------------------//

	$("#question_search_course").change(function(){

		var course=$(this).val();

		var courseSet=[];
		courseSet.push("<option value=''> </option>");
			 sets.forEach(function(key){
					if(key['course']==course)
					{
						var set=key['title'];
							courseSet.push("<option value="+set+">"+set+"</option>");
					}
			});

			$("#question_search_set").removeAttr('disabled').html(courseSet);

	});

	$("#question_search_set").change(function(){
		updateView();
	});
//-----------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------REVIEWING OPTION E------------------------------------------------------------//

		$(".option_add").click(function(){
				$("#option-group5").toggleClass('hidden');

		});

//---------------------------------------------------------------------------------------------------------------------------//
//-----------------------------------SUBMITTING QUESTIONS----------------------------------------------------//
$("#question-submit-bt").click(function(){
		$("#question-submit-btn").click();
});
$("#question-submit-btn").click(function(){
			var question_form=document.getElementById("question_form");
			var form=new FormData(question_form);
			var check=false;
			$("#question_form div.form-group .impor").each(function(){
				if($(this).attr('disabled')!='disabled')
					{
						if($(this).val().trim()==0)
							{
								$(this).parent('div').children('span.help-block').removeClass('hidden');
								check=false;
								return false;
							}
						else
							{
								check=true;
								$(this).parent('div').children('span.help-block').addClass('hidden');
							}
					}
			});
			if(check==true)
			{
				loader();
				$.ajax({
					type:'POST',
					url:'../db/connect.php',
					data:form,
					contentType:false,
					processData:false,
					success:function(responce){

							$(".set_feedback b").html("Question list updated");
							$(".set_feedback").removeClass('alert-danger');
							$(".set_feedback").addClass('alert-success');
							$(".set_feedback").removeClass('hidden');


							loaderOff();
								//console.log(responce);
					},
					error:function(responce){

							$(".set_feedback b").html("Ooops! An error occured while adding the question please try again");
							$(".set_feedback").removeClass('alert-success');
							$(".set_feedback").addClass('alert-danger');
							$(".set_feedback").removeClass('hidden');
							loaderOff();
						// alert(responce);
						// console.log(responce);
					}
				});
				loaderOff();
			}
});
//---------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------SELECTING QUESTIONS PATTERN-----------------------------//

	$("#strTrigger").click(function(){
		$("#objTrigger").children("label").children("input.Prad").removeAttr('checked');
		$(this).children("label").children("input.Prad").attr('checked','checked');
		$("#str div.form-group .form-control").removeAttr('disabled');
			$("#obj div.form-group .form-control").each(function(){
				$(this).attr('disabled','disabled');
			});
	});


		$("#objTrigger").click(function(){
			$("#strTrigger").children("label").children("input.Prad").removeAttr('checked');
			$(this).children("label").children("input.Prad").attr('checked','checked');
			$("#str div.form-group .form-control").attr('disabled','disabled');
				$("#obj div.form-group .form-control").each(function(){
					$(this).removeAttr('disabled');
				});
		});

//--------------------------------------------------------------------------------------------------------------//



var selected={};
var selectedBtn={};
var selectedDel={};

function refresh()
{
	//------------------------------------------------------------EDITING QUESTIONS-----------------------------------------------------------------------------------------------//

$(".edit").each(function(){
	$(this).click(function(e){
		screenLoader();
		var id=$(this).attr('course');
		var title=$(this).attr('title');

			$.ajax({
			type:'POST',
			url:'../db/connect.php',
			data:{getQuestion:id,title:title},
			success:function(responce){
		 if(responce=="Not Admin")
					 {
						 screenLoaderOff();
						 alert("Warning! You are not granted access to make changes to this QUESTION.");
					 }
			else
				{
					try {
						var responce=JSON.parse(responce);
						$("#question-select-course").val(responce['course']);
						$("#question-select-course").change();
						$("#question-select-sets").val(responce['Qset']);
						$("#questionId").val(responce['id']);
						$("#question-content").val(responce['content']);

						if(responce['image']!='')
						{
								$("#Qimg img").attr('src',"../questionImg/"+responce['image']);
						}
						else {
							$("#Qimg img").attr('src',"");
						}

							if(responce['structureOption']!=null && responce['structureOption']!='')
							{
								$("#structural").val(responce['structureOption']);
								$("#strTrigger").click();
							}else
							{
								$("#option1").val(responce['optionA']);
									$("#option2").val(responce['optionB']);
										$("#option3").val(responce['optionC']);
										$("#option4").val(responce['optionD']);
										$("#option5").val(responce['optionE']);
										$("#answ"+responce['optionBest']).prop('checked',true);
										$("#objTrigger").click();
							}
							 $("#question_search_course").val(responce['course']);
							 $("#question_search_course").change();
						 $("#question_search_set").val(responce['Qset']);
						$("#edit_question_modal").modal();
						$("#edit_question_modal").removeClass('hidden');
						$("#courseId").val(responce['id']);

						//alert(responce['id']);
						screenLoaderOff();
					} catch (e) {
						$("#edit_question_modal").addClass('hidden');
						$("#screenLoader .lod").removeClass("start");
						$("#screenLoader .lodTxt").html("<b >Server Error!</b>");
					} finally {

						setTimeout(function(){
							screenLoaderOff();
						},500);
					}
				}
			},
			error:function(responce){
				$("#edit_question_modal").addClass('hidden');
				$("#screenLoader .lod").removeClass("start");
				$("#screenLoader .lodTxt").html("<b >Server Error! try again</b>");
				setTimeout(function(){
					screenLoaderOff();
				},500);
			}
		});



	});
});


////------------------------------Delete----------------------////
		$(".delete").each(function(){
			$(this).click(function(){
				var id=$(this).attr('course');

				var ids={};
				ids.Qdelete=id;
				ids.title=$(this).attr('title');
					if(confirm("Are you sure you wan to delete this course"))
					{
						$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:ids,
						success:function(responce){

							 if(responce=="Not Admin")
 							 {

 								 alert("Warning! You are not granted access to make changes to this Course.");
 							 }
 							 else
 							 {
 								 updateView();
 							 }
						},
						error:function(responce){

						}
					});
				}
			});

		});
//---------------------------------------------------------------------------------------------------------------------------//

//---------------------------------------------------------------------SELECTING COURSE WITH CHECKBOX---------------------------------------------------------------------/

$(".select").each(function(){
		$(this).click(function(e){

			var key=$(this).attr('data');
			var id=$(this).attr('course');
		if($(this).is(":checked"))
			{
				$(this).prop("checked",true);
					selected[key+id] = $(this).attr('course');
					// selectedBtn[key+id]=$(this).parent('td').next().next().next().next().next().next().next().children('div.btn-group').children('button.publish');
					 selectedDel[key+id]=$(this).parent('td').parent('tr');

			}
		else {
				delete selected[key+id];
			// 	delete selectedBtn[key+id];
			delete selectedDel[key+id];
				$(this).prop("checked",false);
		}
		});

});

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

function updateView(selected)
{
	var key=$("#search_question_field").val();
	var courseQ=$("#question_search_course").val();
	var setQ=$("#question_search_set").val();
	$("#edit_question_modal").modal('hide');
			screenLoader();
					$.ajax({
					type:'POST',
					url:'../db/connect.php',
					data:{viewQuestions:[courseQ,setQ,key]},
					success:function(responce){
						 $("#edit_question_table tbody").html(responce);
						 	 $(".chkbx input").prop("checked",false);
					 	   refresh( );

					// var dynamicScript=document.createElement("script");
					// 	dynamicScript.src="../js/Course.js";
					// 	document.body.appendChild(dynamicScript);
						 screenLoaderOff();
					},
					error:function(responce){

					}
				});

}


refresh();


$(".chkbx").each(function(){
$(this).click(function(){// alert('ddd');

	if($(this).attr('option')=="select")
			{
				if($(this).children('input').is(":checked"))
							{
								$(".select").each(function(){
										$(this).prop("checked",false);
											var key=$(this).attr('data');
											var id=$(this).attr('course');
											delete selected[key+id];
											// delete selectedBtn[key+id];
											 delete selectedDel[key+id];
								});
								$(this).children('input').prop("checked",false);console.log(selected);

								//console.log(selected);
							}
					else {
						$(".select").each(function(){
									$(this).prop("checked",true);
									var key=$(this).attr('data');
									var id=$(this).attr('course');
									selected[key+id] = $(this).attr('course');
									// selectedBtn[key+id]=$(this).parent('td').next().next().next().next().next().next().next().children('div.btn-group').children('button.publish');
									selectedDel[key+id]=$(this).parent('td').parent('tr');
						});
						$(this).children('input').prop("checked",true);

					}
			}
		else if($(this).attr('option')=="delete" && Object.getOwnPropertyNames(selected).length >0)
			{


				if(confirm("Are you sure you wan to delete this course"))
				{
					$.ajax({
					type:'POST',
					url:'../db/connect.php',
					data:{Qdelete:selected},
					success:function(responce){
						Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
									selectedDel[id].addClass('hidden');
							});
						 if(responce==false)
						 {}console.log(responce);
					},
					error:function(responce){

					}
					});
				}
			}
			console.log(selected);
});
});


//----------------------------------------------------------------------------UPDATING COURSES------------------------------------------------------------------------------------//
		 $("#update_question").click(function(){
						var form=new FormData(document.getElementById('question_form'));
						Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
							delete selected[id];
 	 						delete selectedBtn[id];
						});
						$.ajax({
						type:'POST',
						url:'../db/connect.php',
						contentType:false,
						processData:false,
						data:form,
						success:function(responce){
							 updateView( );
 
						},
						error:function(responce){

						}
					});
					});

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------//




//-----------------------------------------------------------SEARCH COURSE-------------------------------------------------------------------------------------------//
		$("#search_question_field").focusout(function(){
			var key=$("#search_question_field").val().trim();
				if(key=='')
					{
							$(this).keypress();
						var key=$("#search_question_field").val().trim();
					}
		})
	$("#search_question_field").keyup(function(){
		//var key=$(this).val().trim();
		var key=$("#search_question_field").val().trim();
		var courseQ=$("#question_search_course").val();
		var setQ=$("#question_search_set").val();
		loader();
		$.ajax({
		type:'POST',
		url:'../db/connect.php',
		data:{viewQuestions:[courseQ,setQ,key]},
		success:function(responce){console.log(responce);
			updateView();//$("#edit-course-table tbody").html(responce);
				$(".chkbx input").prop("checked",false);
			 if(responce==false)
			 {}
					refresh();
			 loaderOff();
		},
		error:function(responce){

		}
		});
	});









})
