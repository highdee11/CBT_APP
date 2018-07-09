$(function(){
      $("#Adminuser").focus();
     
    
    function loader()
    {
         $(".loaderTxt").html("verifying logins....");
        $(".loader").addClass('spin');
        $(".status").removeClass('hidden');
    }
    
    function loaderOff()
    {
         setTimeout(function(){
             $(".loader").removeClass('spin');
            $(".status").addClass('hidden');
         },500);
    }
    
    function success()
        {
            setTimeout(function(){
            $(".loader").removeClass('spin'); 
            $(".loaderTxt").html("<b class='text-success '>Access Granted!</b>");
                 window.location="../backend/includes/Dashboard.php";
                },500);
        }

    function failure()
        {
            setTimeout(function(){
              $(".loader").removeClass('spin');
                
            $("#loaderTxt").html("<b class='text-danger col-lg-12 '>Access Denied!</b><p class='col-lg-12 pull-left'>invalid username and passsword Please check and try again.</p>");
                },500);
        }
    
    
$("#loginForm").submit(function(e){
    e.preventDefault();
     $("#login").click();
});
    $("#login").click(function(){
         
        loader();
        var check=false;
        $("#loginForm div.form-group input").each(function(){
            var val=$(this).val();
            if(val.trim()=="")
                {
                    check=false;
                    failure();
                    return false;
                }
            else 
                {
                    check=true;
                }
        });
        
        if(check==true)
            {
                var form=new FormData(document.getElementById("loginForm"));    
                $.ajax({
                    type:'POST',
                    url:"db/connect.php",
                    data:form,
                    contentType:false,
                    processData:false,
                    success:function(responce){
                        if(responce==1)
                            {
                               success();
                              
                            }
                        else
                            {
                                failure();
                            }
                    },
                    error:function(responce){
                        console.log(responce);
                    }
                });
            }
        else
            {
               failure();
            }
       
        
    });
    
});