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

    $(".script").each(function(){
        $(this).click(function(){
            var set=$(this).attr("set");
            var course=$(this).attr("course");

               $.ajax({
                   type:"POST",
                   url:"../db/connect.php",
                   data:{scriptSet:set ,scriptCourse:course},
                   success:function(responce){
                       window.location="../includes/script.php";
                   },
                   error:function(responce){}

               });

        });
    });


     $(".viewscript").each(function(){
        $(this).click(function(e){

            e.stopPropagation();
            var id=$(this).attr("data_id");

               $.ajax({
                   type:"POST",
                   url:"../db/connect.php",
                   data:{viewscript:id},
                   success:function(responce){
                       console.log(responce);
                     window.location="../includes/viewscript.php";
                   },
                   error:function(responce){}

               });

        });
    });

    $("#print").click(function(){
        window.print();
    });


    $(".mark").each(function(e){
        $(this).click(function(e){

                var id=$(this).attr("data_id");
                 screenLoader();
               $.ajax({
                   type:"POST",
                   url:"../db/connect.php",
                   data:{markscript:id},
                   success:function(responce){
                       screenLoaderOff();
                        window.location="../includes/script.php";
                   },
                   error:function(responce){}

               });
        });
    });


    $("#printAllScript").click(function(){
        window.print();
    });

    $("#excel").click(function(){
        screenLoader();
        $.ajax({
            async:false,
            type:"POST",
            url:"../db/connect.php",
            data:{export:1},
            success:function(responce){
                 screenLoaderOff();
            },
            error:function(responce){}
        });
    });
    
    $(".markall").each(function(){
        $(this).click(function(){
            screenLoader();
            var set=$(this).attr("set");
            var course=$(this).attr("course");
             $.ajax({
                   type:"POST",
                   url:"../db/connect.php",
                   data:{markAllscript:set ,markAllscriptCourse:course},
                   success:function(responce){
                       window.location="../includes/script.php";
                       console.log(responce);
                       screenLoaderOff();
                   },
                   error:function(responce){}

               });

        });
    });

});
