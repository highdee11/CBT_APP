$(function(){

  
    
    var config={
		'.chosen-select':{},
		'.chosen-select-deselect':{allow_single_deselect:true},
		'.chosen-select-no-single':{disable_search_threshold:10},
		'.chosen-select-no-result':{no_results_text:'Oops,nothing found!'},
		'.chosen-select-width':{width:'95%'}
	}
	for ( var selector in config)
	{
		$(selector).chosen(config[selector]);
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
    
    
    $("#autoG").click(function(){
        $("#Btnload").addClass('roll');
        $.post("../db/connect.php",{generate:1},function(data){
            var data=JSON.parse(data);
            $("#user").val(data[0]);
        $("#password").val(data[1]);
        });
        
        $("#Btnload").removeClass('roll');
        
    });
    
    
    $("#submitAdmin").click(function(){
            var check=false;
        $("#add_Admin div.form-group .form-control").each(function(){
            
                var val=$(this).val();
                if(val=="")
                    {
                        check=false;
                        alert("All fields are required.");
                        return false;
                    }
                else
                    {
                        check=true;
                    }
        });
        
        if(check==true)
            {
                screenLoader();
                $("#addAdmin").modal('hide');
                var form=new FormData(document.getElementById("add_Admin"));
                $.ajax({
                    type:'POST',
                    url:"../db/connect.php",
                    data:form,
                    contentType:false,
                    processData:false,
                    success:function(responce){
                        console.log(responce);
                        if(responce=="exists")
                            {
                                alert("Username already  exist ");
                                $("#addAdmin").modal('show');
                                screenLoaderOff();
                            }
                        else
                            {
                                updateView();
                                 $("#addAdmin").modal('hide');
                                screenLoaderOff();        
                            }
                        
                    },
                    errror:function(responce){}
                });        
            }
        
        
        
    });
    
    
//------------------------------------------------------------EDITING COURSES-----------------------------------------------------------------------------------------------//


	function refresh()
    {
        

            $(".block").each(function(){
                $(this).click(function(e){

                    var id=$(this).attr('data');
                        $.ajax({
                        type:'POST',
                        url:'../db/connect.php',
                        data:{blockAdmin:id},
                        success:function(responce){ 
                            
                        updateView(); 
                            loaderOff();
                        },
                        error:function(responce){

                        }
                    });



                });
            });



            $(".allow").each(function(){
                $(this).click(function(e){
                    
                    var id=$(this).attr('data');
                        $.ajax({
                        type:'POST',
                        url:'../db/connect.php',
                        data:{allowAdmin:id},
                        success:function(responce){
                        updateView();
                            //console.log(responce);
                            loaderOff();
                        },
                        error:function(responce){

                        }
                    });



                });
            });

        
    
      $(".remove").each(function(){
                $(this).click(function(e){
                    
                    var id=$(this).attr('data');
                        $.ajax({
                        type:'POST',
                        url:'../db/connect.php',
                        data:{deleteAdmin:id},
                        success:function(responce){
                        updateView();
                            //console.log(responce);
                            loaderOff();
                        },
                        error:function(responce){

                        }
                    });



                });
            });

        
    
    
//------------------------------------------------------------EDITING COURSES-----------------------------------------------------------------------------------------------//

$(".edit").each(function(){
	$(this).click(function(e){
		screenLoader();
		var id=$(this).attr('data');
			$.ajax({
			type:'POST',
			url:'../db/connect.php',
			data:{getAdmin:id},
			success:function(responce){
                
                //var responce=JSON.parse(responce);console.log(responce);
				if( responce!='')
				{
					try {
						var responce=JSON.parse(responce);
                            responce=responce[0];
                        var courses=responce['courses'].split('#/');
                        
                        $("#editName").val(responce['name']);
                        $("#editGender").val(responce['gender']);
                        $("#editUser").val(responce['username']);
                        $("#editPassword").val(responce['password']);
                        $("#editCourse").val(courses).trigger('chosen:updated');
                        $("#identity").val(responce['id']);
//                        
                        //console.log( $("#editCourse").val() );
						$("#editAdmin").modal();
						$("#editAdmin").removeClass('hidden');
						 
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


    
    }
    
    refresh();
    
    
    
function updateView( )
{
        loader(); 
					$.ajax({
					type:'POST',
					url:'../db/connect.php',
					data:{viewAdmins:1},
					success:function(responce){
						 $("#edit-Admin-table tbody").html(responce);
					 	     refresh();
                        loaderOff();
					},
					error:function(responce){

					}
				});

}

        $("#submitEditAdmin").click(function(){
                var form=new FormData(document.getElementById("edit_Admin"));
            
                $.ajax({
                    type:'POST',
                    url:'../db/connect.php',
                    data:form,
                    contentType:false,
                    processData:false,
                    success:function(responce){
                        
                        updateView();
                          $("#editAdmin").modal('hide');
                    },
                    error:function(responce){}
                
                });
        });
    
});