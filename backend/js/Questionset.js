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

//--------------------------------------------------------------------SUBMITTING A COURSE -------------------------------------------->

	$("#questionset-submit-btn").click(function(){
			var setForm=document.getElementById("set_form");
			var title=$("#set_form div.form-group input.form-control");
			var course=$("#set_form div.form-group select.form-control");
			var description=$("#set_form div.form-group textarea.form-control");
			var form=new FormData(setForm);
			if(title.val().trim()==0 || course.val().trim()==0)
				{
					$("#set_form .feedBack").removeClass("hidden");
				}
			else
			 {

					$("#set_form div.form-group .feedBack").addClass("hidden");
					loader();
					$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:form ,
						contentType:false,
						processData:false,
						success:function(responce){
							if(responce=='exit')
								{
									$(".set_feedback b").html(title.val()+" already exist in the course List");
									$(".set_feedback").removeClass('alert-success');
									$(".set_feedback").addClass('alert-danger');
									$(".set_feedback").removeClass('hidden');
									loaderOff();
								}
							else if(responce)
								{
									$(".set_feedback b").html(title.val()+" has been added to the course List");
									$(".set_feedback").removeClass('alert-danger');
									$(".set_feedback").addClass('alert-success');
									$(".set_feedback").removeClass('hidden');
									title.val('');
									description.val('');
									loaderOff();
									//console.log(responce);
								}
							 // alert(responce);
						},
						error:function(data){
							console.log(data)
						}
					});
			}


	});


	//--------------------------------------------------------Publishing ,Unpublish delete course with BUTTON--------------------------------------------------------------------//
	function publishStart(button){
		button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('hidden').addClass('start');
		//button.parent("div").parent("td").prev().children('div').children('span.txt').html('Publishing..') ;
	}

	function publishStop(button)
	{
		setTimeout(function(){
			button.parent("div").parent("td").prev().children('center').children('span').removeClass('glyphicon-remove').removeClass('text-danger').addClass('glyphicon-ok').addClass('text-success');
			button.removeClass('btn-success');//.removeClass('publish');
			button.attr('data','unpublish');
			button.addClass("btn-warning").html('unpublish');
	 button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('start');
	 //button.parent("div").parent("td").prev().children('div').children('span.txt').removeClass('text-danger').addClass('text-success').html('published')
	;},1000);

	}

	function publishError(button){
		button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('start');
		//button.parent("div").parent("td").prev().children('div').children('span.txt').removeClass('text-success').addClass('text-danger').html('<b>Error! try again...</b>');
	}


	function unPublishStart(button){
		button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('hidden').addClass('start');
		//button.parent("div").parent("td").prev().children('div').children('span.txt').html('Unpublishing..') ;
	}

	function unPublishStop(button)
	{
		setTimeout(function(){
		 button.parent("div").parent("td").prev().children('center').children('span').removeClass('glyphicon-ok').removeClass('text-success').addClass('glyphicon-remove').addClass('text-danger');
		 button.removeClass('btn-warning');
		 button.attr('data','publish');
		 button.addClass("btn-success").html('&nbsp; publish &nbsp;').addClass('publish');
	button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('start');
	//button.parent("div").parent("td").prev().children('div').children('span.txt').removeClass('text-success').addClass('text-danger').html('Not published') ;
},1000);
	}

	function unPublishError(button){
		button.parent("div").parent("td").prev().children('div').children('div.load').removeClass('start');
		//button.parent("div").parent("td").prev().children('div').children('span.txt').removeClass('text-success').addClass('text-danger').html('<b>Error! try again...</b>')  ;
	}
	function unPublishDenied(button)
	{
		button.parent("div").parent("td").prev().children('div').children('div.load').addClass('hidden').removeClass('start');
		button.parent("div").parent("td").prev().children('div').children('span.txt').html('published') ;
	}
	function publishDenied(button)
	{
		button.parent("div").parent("td").prev().children('div').children('div.load').addClass('hidden').removeClass('start');
		button.parent("div").parent("td").prev().children('div').children('span.txt').html('UnPublished') ;
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
	//---------------------------------------------------------------------SELECTING COURSE WITH CHECKBOX---------------------------------------------------------------------/
	var selected={};
	var selectedBtn={};
	var selectedDel={};
	var selectedCourse={};



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
												delete selectedCourse[key+id];
												delete selectedBtn[key+id];
										    delete selectedDel[key+id];
									});
									$(this).children('input').prop("checked",false);

								}
						else {
							$(".select").each(function(){
										$(this).prop("checked",true);
										var key=$(this).attr('data');
										var id=$(this).attr('course');
										selected[key+id] = $(this).attr('course');
										selectedCourse[key+id]=$(this).attr('setCourse');
										selectedBtn[key+id]=$(this).parent('td').next().next().next().next().next().next().next().children('div.btn-group').children('button.publish');
										selectedDel[key+id]=$(this).parent('td').parent('tr');
							});
							$(this).children('input').prop("checked",true);

						}
				}
			else if($(this).attr('option')=="publish" && Object.getOwnPropertyNames(selected).length >0)
				{

					Object.getOwnPropertyNames(selectedBtn).forEach(function(id,val,arry){
					 var button=selectedBtn[id];
					 publishStart(button);
					});
						//console.log(selectedCourse);
					$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:{Setpublish:selected , setCourse:selectedCourse},
						success:function(responce){
							 console.log(responce);
							Object.getOwnPropertyNames(selectedBtn).forEach(function(id,val,arry){
							 var button=selectedBtn[id];
								 publishStop(button);
							});

							if(responce=="Not Admin")
							 {

								 		alert("Warning! You are not granted access to make changes to one of this Sets.");
							 }
 							 else if(responce=="noq error")
 							 {
 								 alert("No of questions in this set is lesser than the no of question per attempt.");

 							 }
 							 else
 							 {

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
					Object.getOwnPropertyNames(selectedBtn).forEach(function(id,val,arry){
					 var button=selectedBtn[id];

							unPublishStart(button);
					});

					$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:{Setunpublish:selected},
						success:function(responce){
							Object.getOwnPropertyNames(selectedBtn).forEach(function(id,val,arry){
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

						console.log(selectedDel);
					if(confirm("Are you sure you wan to delete this course"))
					{
						$.ajax({
						type:'POST',
						url:'../db/connect.php',
						data:{Setdelete:selected},
						success:function(responce){
							Object.getOwnPropertyNames(selected).forEach(function(id,val,arry){
										selectedDel[id].addClass('hidden');
								});
							 if(responce==false)
							 {}
						},
						error:function(responce){

						}
						});
					}
				}

	});
	});


	function refresh()
	{


		$(".select").each(function(){
				$(this).click(function(e){

					var key=$(this).attr('data');
					var id=$(this).attr('course');
				if($(this).is(":checked"))
					{
						$(this).prop("checked",true);
							selected[key+id] = $(this).attr('course');
							selectedCourse[key+id]=$(this).attr('setCourse');
							selectedBtn[key+id]=$(this).parent('td').next().next().next().next().next().next().next().children('div.btn-group').children('button.publish');
							selectedDel[key+id]=$(this).parent('td').parent('tr');

					}
				else {
						delete selected[key+id];
						delete selectedCourse[key+id];
						delete selectedBtn[key+id];
					delete selectedDel[key+id];
						$(this).prop("checked",false);
				}
				});

		});

		////------------------------------publish----------------------////
		$(".publish").each(function(){
			$(this).click(function(){
				if($(this).attr('data')=="publish")
				{
					var id=$(this).attr('course');
					var button=$(this);
					var ids={};
					ids.Setpublish=id;
					ids.title=$(this).attr('title');
					ids.name=$(this).attr('name');
					ids.noq=$(this).attr('noq');
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
								 		alert("Warning! You are not granted access to make changes to this Set.");
							 }
							 else if(responce=="noq error")
							 {
								 alert("No of questions in this set is lesser than the no of question per attempt.");
								  publishDenied(button);
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
				else {////------------------------------Unpublish----------------------////
					var id=$(this).attr('course');
					var ids={};
						var button=$(this);
					ids.Setunpublish=id;
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
								 alert("Warning! You are not granted access to make changes to this set.");
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

			////---------------------------------------------------------------------------------Delete--------------------------------------------------------------------////
					$(".delete").each(function(){
						$(this).click(function(){
							var id=$(this).attr('course');
							var tr=$(this).parent('div.btn-group').parent('td').parent('tr');
							var ids={};
							ids.Setdelete=id;
							ids.title=$(this).attr('title');
								if(confirm("Are you sure you wan to delete this Set"))
								{
									$.ajax({
									type:'POST',
									url:'../db/connect.php',
									data:ids,
									success:function(responce){
										if(responce=="Not Admin")
										 {
											 alert("Warning! You are not granted access to make changes to this Set.");
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

	//------------------------------------------------------------EDITING set-----------------------------------------------------------------------------------------------//

	$(".edit").each(function(){
		$(this).click(function(e){
			screenLoader();
			var id=$(this).attr('course');
			var title=$(this).attr("title");
				$.ajax({
				type:'POST',
				url:'../db/connect.php',
				data:{getSets:id , title:title},
				success:function(responce){
					if(responce=="Not Admin")
					{
								screenLoaderOff();
								alert("Warning! You are not granted access to make changes to this Set.");
					}
					else
					{
						try {
								
								var responce=JSON.parse(responce);
								var time=responce['time'].split('/');
							$("#title").val(responce['title']);
							$("#setcos").val(responce['course']);
							$("#noq").val(responce['noq']);
							$("#level").val(responce['class']);
							$("#hour").val(time[0]);
							$("#min").val(time[1]);
							$("#sec").val(time[2]);
							$("#description").val(responce['description']);
							$("#edit_set_modal").modal();
							$("#edit_set_modal").removeClass('hidden');
							$("#courseId").val(responce['id']);
							//alert(responce['id']);
							screenLoaderOff();
						} catch (e) {
						//	console.log(responce);
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
					$("#edit_set_modal").addClass('hidden');
					$("#screenLoader .lod").removeClass("start");
					$("#screenLoader .lodTxt").html("<b >Server Error! try again</b>");
					setTimeout(function(){
						screenLoaderOff();
					},500);
				}
			});



		});
	});






	
}

refresh();
    
		function updateView(selected)
		{
			var key=$("#search_edit_set").val();
			$("#edit_set_modal").modal('hide');
					screenLoader();
							$.ajax({
							type:'POST',
							url:'../db/connect.php',
							data:{viewSets:key},
							success:function(responce){

								 $("#edit-set-table tbody").html(responce);
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

	//----------------------------------------------------------------------------UPDATING COURSES------------------------------------------------------------------------------------//
				 $("#update_set").click(function(){
								var form=new FormData(document.getElementById('edit_set'));
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
								     console.log(responce);
								},
								error:function(responce){

								}
							});
							});

		//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------------SEARCH COURSE-------------------------------------------------------------------------------------------//
		$("#search_edit_set").focusout(function(){

			//$(this).keypress();
		})
	$("#search_edit_set").keyup(function(){
		var key=$(this).val().trim();
		loader();
		$.ajax({
		type:'POST',
		url:'../db/connect.php',
		data:{searchSet:key},
		success:function(responce){
			$("#edit-set-table tbody").html(responce);
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

});
