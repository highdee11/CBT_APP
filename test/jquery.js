$(function(){
    //--------------------------------------------SLIDDING IN THE SETS--------------------------------------------------------//
      $("#courses").removeClass("start");
    
//---------------------------------------CLICKING AN EXAM------------------------------------//    
    $(".examSet").each(function(){
        $(this).click(function(){
             $("#courses").addClass('hidden');//.addClass("hidden");
                $("#setDetails").removeClass("hidden");
                $("#instr").addClass("hidden");
                $(".instruction").addClass("start").addClass("col-lg-offset-3");
            loader();
            var title=$(this).attr('SetTitle');
            var id=$(this).attr('data_id');
            sessionStorage.set=title;
            sessionStorage.id=id;
            sessionStorage.noq=$(this).attr("noq");
            sessionStorage.course=$(this).attr("course");
            
            $.ajax({
                type:"POST",
                url:"../question/server.php",
                data:{getsetDet:id},
                success:function(responce){
                  
                    try
                    {
                        var  responce=JSON.parse(responce);
                      $(".title").html(responce['title']);
                      $(".cos").html(responce['course']);
                      $(".class").html(responce['class']);
                      $(".noq").html(responce['noq']);
                      $(".time").html(responce['time']);
                        sessionStorage.time=responce['time'];
                    
                        loaderOff();
                    }
                    catch(e){
                        alert("Documents not ready");
                    }
                    finally{}
                },
                error:function(responce){}
            });
            

//            $(".instruction").addClass("start").addClass("col-lg-offset-3");
        });
    });
    
    
    $("#backloader").click(function(){ $("#back").click(); });
    $("#back").click(function(){
      
        $("#setDetails").addClass("hidden");
        $("#instr").removeClass("hidden");
        $(".instruction").removeClass("start").removeClass("col-lg-offset-3");
        setTimeout(function(){
            $("#courses").removeClass("hidden");
        },500);
           sessionStorage.removeItem("set");
           sessionStorage.removeItem("id");
            
    });
    
    
    $("#start").click(function(){
       
        $.ajax({
            type:"POST",
            url:"../question/server.php",
            data:{prepare:sessionStorage.set , setid :sessionStorage.id ,course : sessionStorage.course,noq:sessionStorage.noq,time:sessionStorage.time},
            success:function(responce){  
               if(responce==1)
                   {
                       window.location="../question/";
                   }
            },
            error:function(respoonce){}
        });
        
    });
    
    function loader()
        {
            $(".loadBack").removeClass("hidden");
        }
    function loaderOff()
        {
            $(".loadBack").addClass("hidden");
        }
    
});