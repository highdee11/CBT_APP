$(function(){
///--------loading doucments


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
	//------------------------------SUBMITTING A COURSE -------------------------------------------->

	$("#course-submit-btn").click(function(){
			var courseForm=document.getElementById("course_form");
			var title=$("#course_form div.form-group input.form-control");
				var description=$("#course_form div.form-group textarea.form-control");
			var form=new FormData(courseForm);
			if(title.val().trim()==0)
				{
					$("#course_form div.form-group .feedBack").removeClass("hidden");
				}
			else
			 {

					$("#course_form div.form-group .feedBack").addClass("hidden");
					loader();
					$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:form ,
						contentType:false,
						processData:false,
						success:function(responce){
							if(responce)
								{
									$(".course_feedback b").html(title.val()+" has been added to the course List");
									$(".course_feedback").removeClass('hidden');
									title.val('');
									description.val('');
									loaderOff();
								}
							// alert(responce);
						},
						error:function(data){
							//console.log(data)
						}
					});
			}
	});
//--------------------------------------------------------Publishing ,Unpublish delete course with BUTTON--------------------------------------------------------------------//
	function publishStart(button){
		//var button=selectedBtn[id];
		button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('hidden').addClass('start');
		button.parent("div").parent("td").prev().children('div').children('span.txt').html('Publishing..') ;
	}
	function publishDenied(button)
	{
		button.parent("div").parent("td").prev().children('div').children('div.load').addClass('hidden').removeClass('start');
		button.parent("div").parent("td").prev().children('div').children('span.txt').html('UnPublished') ;
	}
	function publishStop(button)
	{
		setTimeout(function(){
			button.parent("div").parent("td").prev().children('center').children('span').removeClass('glyphicon-remove').removeClass('text-danger').addClass('glyphicon-ok').addClass('text-success');
		  button.removeClass('btn-success');//.removeClass('publish');
			button.attr('data','unpublish');
			button.addClass("btn-warning").html('unpublish');
	 button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('start');
	 button.parent("div").parent("td").prev().children('div').children('span.txt').removeClass('text-danger').addClass('text-success').html('published')
	;},1000);

	}

	function publishError(button){
		button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('start');
		button.parent("div").parent("td").prev().children('div').children('span.txt').removeClass('text-success').addClass('text-danger').html('<b>Error! try again...</b>');
	}


	function unPublishStart(button){
		button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('hidden').addClass('start');
		button.parent("div").parent("td").prev().children('div').children('span.txt').html('Unpublishing..') ;
	}
function unPublishDenied(button)
{
	button.parent("div").parent("td").prev().children('div').children('div.load').addClass('hidden').removeClass('start');
	button.parent("div").parent("td").prev().children('div').children('span.txt').html('published') ;
}
	function unPublishStop(button)
	{
		setTimeout(function(){
 		 button.parent("div").parent("td").prev().children('center').children('span').removeClass('glyphicon-ok').removeClass('text-success').addClass('glyphicon-remove').addClass('text-danger');
 		 button.removeClass('btn-warning');
 		 button.attr('data','publish');
 		 button.addClass("btn-success").html('&nbsp; publish &nbsp;').addClass('publish');
 	button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('start');
 	button.parent("div").parent("td").prev().children('div').children('span.txt').removeClass('text-success').addClass('text-danger').html('Not published') ;},1000);
	}

	function unPublishError(button){
		button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('start');
		button.parent("div").parent("td").prev().children('div').children('span.txt').removeClass('text-success').addClass('text-danger').html('<b>Error! try again...</b>')  ;
	}
	var selected={};
	var selectedBtn={};
	var selectedDel={};
	var selectedCourse={};


	function refresh()
	{

////------------------------------publish----------------------////
	$(".publish").each(function(){
		$(this).click(function(){
			if($(this).attr('data')=="publish")
			{
				var id=$(this).attr('course');
				var button=$(this);
				var ids={};
				ids.publish=id;
				ids.title=$(this).attr('title');

					publishStart(button);
				$.ajax({
					type:'POST',
					url:'../db/connect.php',
					data:ids,
					success:function(responce){
					//	console.log(responce);
					 if(responce=="Not Admin")
						 	{
								publishDenied(button);
								alert("Warning! You are not granted access to make changes to this Course.");
							}
							else
 						 {
	 								publishStop(button);
 						 }
					},
					error:function(responce){
						publishError(button);
					}
				});
			}
			else {
				////------------------------------Unpublish----------------------////
				var id=$(this).attr('course');
				var ids={};
					var button=$(this);
				ids.unpublish=id;
				ids.title=$(this).attr('title');

				unPublishStart(button);
				$.ajax({
					type:'POST',
					url:'../db/connect.php',
					data:ids,
					success:function(responce){
						if(responce=="Not Admin")
						 {
								unPublishDenied(button);
							 alert("Warning! You are not granted access to make changes to this Course.");
						 }
						 else
						 {
							 unPublishStop(button);
						 }
					},
					error:function(responce){
						unPublishError(button);

					}
				});
			}
		});

	});

		////------------------------------Delete----------------------////
				$(".delete").each(function(){
					$(this).click(function(){
						var id=$(this).attr('course');
						var ids={};
						ids.delete=id;
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

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------/

//------------------------------------------------------------EDITING COURSES-----------------------------------------------------------------------------------------------//

$(".edit").each(function(){
	$(this).click(function(e){
		screenLoader();
		var id=$(this).attr('course');
		var title=$(this).attr('title');
 			$.ajax({
			type:'POST',
			url:'../db/connect.php',
			data:{getCourse:id,title:title},
			success:function(responce){
				if(responce=="Not Admin")
				{
						screenLoaderOff();
							alert("Warning! You are not granted access to make changes to this Course.");
				}
				else
				{
					try {
						var responce=JSON.parse(responce);
						$("#board_name_field").val(responce['title']);
						$("#board_description_field").val(responce['description']);
						//$("#triggerModal").click();
						$("#edit_course_modal").modal();
						$("#edit_course_modal").removeClass('hidden');
						$("#courseId").val(responce['id']);
						//alert(responce['id']);
						screenLoaderOff();
					} catch (e) {
						$("#edit_course_modal").addClass('hidden');
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
				$("#edit_course_modal").addClass('hidden');
				$("#screenLoader .lod").removeClass("start");
				$("#screenLoader .lodTxt").html("<b >Server Error! try again</b>");
				setTimeout(function(){
					screenLoaderOff();
				},500);
			}
		});



	});
});


//---------------------------------------------------------------------SELECTING COURSE WITH CHECKBOX---------------------------------------------------------------------/

	$(".select").each(function(){
			$(this).click(function(e){

				var key=$(this).attr('data');
				var id=$(this).attr('course');
			if($(this).is(":checked"))
				{
					$(this).prop("checked",true);
						selected[key+id] = $(this).attr('course');
							selectedCourse[key+id]=$(this).attr('data');
						selectedBtn[key+id]=$(this).parent('td').next().next().next().next().children('div.btn-group').children('button.publish');
						selectedDel[key+id]=$(this).parent('td').parent('tr');
				}
			else {
					delete selected[key+id];
					delete 	selectedCourse[key+id];
					delete selectedBtn[key+id];
					delete selectedDel[key+id];
					$(this).prop("checked",false);
			}
		//console.log(selected);
			});

	});




//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	var resp=[];
	resp.push(selected);
	resp.push(selectedBtn);
				return resp;

}

refresh();


//selectedBtn=refresh

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------UPDATING COURSES------------------------------------------------------------------------------------//
		 $("#update_course").click(function(){
						var form=new FormData(document.getElementById('edit_board'));
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

							//console.log(selected);
						},
						error:function(responce){

						}
					});
					});

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

function updateView(selected)
{
	var key=$("#search_edit_course").val();
	$("#edit_course_modal").modal('hide');
			screenLoader();
					$.ajax({
					type:'POST',
					url:'../db/connect.php',
					data:{viewCourses:key},
					success:function(responce){
						 $("#edit-course-table tbody").html(responce);
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











$(".chkbx").each(function(){
	$(this).click(function(){

		var responce=refresh();
		selected=responce[0];
		selectedBtn=responce[1];
		if($(this).attr('option')=="select")
				{

						if($(this).children('input').is(":checked"))
								{
									//alert('checked');
									$(".select").each(function(){
											$(this).prop("checked",false);
												var key=$(this).attr('data');
												var id=$(this).attr('course');
												delete selected[key+id];
												delete selectedBtn[key+id];
												delete 	selectedCourse[key+id];
												delete selectedDel[key+id];
									});
									 $(this).children('input').prop("checked",false);
									//
								}
						else {
							$(".select").each(function(){
										$(this).prop("checked",true);
										var key=$(this).attr('data');
										var id=$(this).attr('course');
										selected[key+id] = $(this).attr('course');
										 selectedCourse[key+id]=$(this).attr('data');
										selectedBtn[key+id]=$(this).parent('td').next().next().next().next().children('div.btn-group').children('button.publish');
										selectedDel[key+id]=$(this).parent('td').parent('tr');
							});
						 	$(this).children('input').prop("checked",true);
								//	console.log(selected);
						}
				}
			else if($(this).attr('option')=="publish" && Object.getOwnPropertyNames(selected).length >0)
				{

					Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
					 var button=selectedBtn[id];
					 publishStart(button);
					});

					$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:{publish:selected,CourseName:selectedCourse},
						success:function(responce){	  console.log(responce);
							if(responce=="Not Admin")
								 {
									 alert("Warning! You are not granted access to make changes to this Course.");

									 Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
													var button=selectedBtn[id];
											publishDenied(button)
										});
								 }
								 else {

												Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
															 var button=selectedBtn[id];
					 		 							   publishStop(button);

												});
											}

						},
						error:function(responce){
							Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
							 var button=selectedBtn[id];
							 publishError(button);
							});

						}
					});
				}
			else if($(this).attr('option')=="unpublish" && Object.getOwnPropertyNames(selected).length >0)
				{
					Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
					 var button=selectedBtn[id];
							unPublishStart(button);
					});

					$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:{unpublish:selected},
						success:function(responce){
							Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
							 var button=selectedBtn[id];
							 unPublishStop(button);
							});

							 if(responce==false)
							 {}
						},
						error:function(responce){
							Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
							 var button=selectedBtn[id];
							 unPublishError(button);
							});

						}
					});
				}
			else if($(this).attr('option')=="delete" && Object.getOwnPropertyNames(selected).length >0)
				{

						//console.log(selectedDel);
					if(confirm("Are you sure you wan to delete this course"))
					{
						$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:{delete:selected},
						success:function(responce){

							 if(responce==false)
							 {}
							 updateView();

						},
						error:function(responce){

						}
						});
					}
				}
				//console.log(selected);
	});
});
//-----------------------------------------------------------SEARCH COURSE-------------------------------------------------------------------------------------------//

	$("#search_edit_course").keyup(function(){
		var key=$(this).val().trim();
		loader();
		$.ajax({
		type:'POST',
		url:'../db/connect.php',
		data:{searchCourse:key},
		success:function(responce){
			$("#edit-course-table tbody").html(responce);
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

//--------------start function---------
});
