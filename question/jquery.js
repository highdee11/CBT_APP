$(function(){     
//localStorage.removeItem('question');
//    localStorage.removeItem('time');
//    localStorage.removeItem('details');
    var question={};
    var current=0;
    var noq=0;
    var time={};
    var student;
    
    
    if(localStorage.question=="" || localStorage.question==undefined)
        {
            
             $.ajax({
                 async:false,
                 type:"POST",
                 url:"server.php",
                 data:{start:1},
                 success:function(data){  
                var data=JSON.parse(data);
                 data=addAns(data);
                localStorage.setItem("question",JSON.stringify(data));
                question=JSON.parse(localStorage.question);
                 qq=question;
                noq=question.length;
                setSelector(noq);     
                loaderOff();    
                },
                error:function(data){}
             });
          
            $.post({
                async:false,
                type:"POST",
                url:"server.php",
                data:{getime:1},
                success:function(data){  
                    localStorage.time=(JSON.stringify(JSON.parse(data).split("/")));   
                        },
                error:function(data){}
            });  
            $.post({
                async:false,
                type:"POST",
                url:"server.php",
                data:{getStudent:1},
                success:function(data){  
                    localStorage.setItem("details",data);   
                            
                        },
                error:function(data){}
            });  
           
             controll('');
               timer();
        }
    else
        {
             
            question=JSON.parse(localStorage.question);
            question= addAns(question);
            noq=question.length;
            setSelector(noq);  
            time=JSON.parse(localStorage.time);
            student=JSON.parse(localStorage.details);
            controll();
            loaderUp();
            
        }
     $("#contAttmpt").click(function(){
         loaderOffQ();
         timer();
         
     });
    
    $("#contDismiss").click(function(){
         saveDismiss("dismissed");
    localStorage.removeItem('question');
    localStorage.removeItem('time');
    localStorage.removeItem('details');
    localStorage.removeItem('current');
        window.location="../question";
     });
    function setSelector(num)
        {
            var selectors="";
            for(var c=0;c<num;c++)
                {
                     selectors+="<li data='"+(c)+"'>"+(c+1)+"</li>";
                   
                }
             $("#selector ul").html(selectors);
            $("#selector ul li").css("margin-right","5px");
            //console.log(selectors);
            
        }
    
    function loaderOff()
        {
            setTimeout(function(){
            $(".loader").removeClass('roll');
            $("#dark").addClass("hidden");
            },1000);
        }
    function loader()
        {
             
            $("#msg").html(" Your answer has being submitted successfully <b>GOODLUCK!</b>");
            $(".loader").addClass('hidden');
            $("#contBtns").addClass('hidden');
            $("#continue").removeClass("hidden");
            $("#dark").removeClass("hidden");
            $(".text").addClass('hidden');
        }
    function loaderOffQ()
        {
            
            $(".loader").removeClass('roll');
            $("#dark").addClass("hidden");
            
        }
    function loaderUp()
        {
            $(".loader").removeClass('roll');
            $(".loader").addClass('hidden');
            $(".text").addClass('hidden');
            $("#dark .logo").addClass("moveup");
            setTimeout(function(){
                $("#continue").removeClass("hidden");
            },200);
        }
    function loaderDown()
        {
            $("#dark .logo").removeClass("moveup");
        }
    
//-----------------------------------------ADDING ANSWER KEY TO QUESTION OBJECT--------------------------------------------------------------------//
    function addAns(object)
        {
            Object.getOwnPropertyNames(object).forEach(function(val , id ,aray){
                object[val]['answer']="";
            });
            
            return object;
        }
    
//-----------------------------------------------------------------------------------------------------------------------------------------//
    
    $(".opt").each(function(){
        $(this).click(function(){
            question[current]['answer']=$(this).attr('value');
            localStorage.setItem("question",JSON.stringify(question)); 
        });
    });
    
//----------------------------------------------------EMPTING ANSWER------------------------------------------------------------------------//
    
    function empty()
        {
            $(".option ul li label input").each(function(){
              $(this).prop("checked",false);
               
            });
        }
//----------------------------------------------------------------------QUESTION CONTROLLER---------------------------------------------------------------//
      //-------------------------getting structural if set--------------------------------------------------------//
    function structure()
        {
             if(!$("#strAnsw").hasClass("hidden"))
                    { 
                        question[current]['answer']=$("#strAnsw div.form-group input.form-control").val();    
                         localStorage.setItem("question",JSON.stringify(question));
                    }
        }
    //---------------------------------------------------------------------------------------------------------------------//
        function disableBtnNext(current)
            {
                if(current>=noq-1)
                    {
                        $("#next").attr("disabled","disabled");
                    }
                else
                    {
                          $("#next").removeAttr("disabled");
                    }
            }
        function disableBtnPrev(current)
            {
                if(current<noq-1)
                    {
                        $("#prev").attr("disabled","disabled");
                    }
                else
                    {
                          $("#prev").removeAttr("disabled");
                    }
            }
        function controll(direction )
            {  
                 
                current=parseInt(localStorage.current);
               
                   empty();
                 var disnext=$("#next").prop("disabled"); 
                var disprev=$("#prev").prop("disabled"); 

                structure();

                if(direction=="next")
                    {
                       
                        if((current<noq))
                            {
                                  current+=1;
                                disableBtnNext(current);
                                setQ(current);
                            }
 
                       

                    }
                else if(direction=="previous")
                    {
                        if((current>0))
                            {
                                current-=1;
                                disableBtnPrev(current);
                                setQ(current);   
                            } 
                    }
                else{
                        current=0;
                        setQ(current);
                    }
                return question;
            }
//----------------------------------------------------------------------------------------------------------------------------------------------//
    
    function setQ(index)
        {
             
             question=JSON.parse(localStorage.question);
            
            $("#qNo").html("Q ."+ (parseInt(index)+1) );
            $("#question").html(question[index]['content']);
            if(question[index]['image'].trim()!="")
                {   $("#Qimg").attr('src',"../backend/questionImg/"+question[index]['image']).removeClass("hidden"); }
            else {  $("#Qimg").attr('src',"").addClass("hidden");           }
            if(question[index]['structureOption']==null)
               {    
                   $("#strAnsw div.form-group input.form-control").val("");
                    $(".opt1").html(question[index]['optionA']);
                    $(".opt2").html(question[index]['optionB']);
                    $(".opt3").html(question[index]['optionC']);
                    $(".opt4").html(question[index]['optionD']);
                    if(question[index]['optionE'].trim()!="")
                        {
                             $(".opt5").html(question[index]['optionD']);
                             $(".opt5").parent('label').parent('li').removeClass("hidden");
                        }
                    else    
                        {
                            $(".opt5").parent('label').parent('li').addClass("hidden");
                        }
                   $("#options").removeClass("hidden");
                   $("#strAnsw").addClass("hidden")
                   $(".opt[value='"+question[index]['answer']+"']").prop("checked",true);
                }
            else if(question[index]['structureOption']!=null)
                {
                    $("#strAnsw div.form-group input.form-control").val(question[index]['answer']);
                    $("#options").addClass("hidden");
                    $("#strAnsw").removeClass("hidden")
                }
            localStorage.current=index;
                
        }
    
//-------------------------------------------------------------------------------------------------------------------------------------------//
    
  

$("#next").click(function(){
      
    question=controll('next');
  
});
   
 $("#prev").click(function(){
    question=controll('previous');
        
});  
    
 $("#finish").click(function(){
    submitScript("submitted");
    localStorage.removeItem('question');
    localStorage.removeItem('time');
    localStorage.removeItem('details');
    localStorage.removeItem('current');
     loader();
     stopTime();
   window.location="../";
});
    
   $("#selector ul li").each(function(){
       $(this).click(function(){
               empty();  
           current=$(this).attr("data");
           disableBtnPrev(current);
           disableBtnNext(current);
           localStorage.current=current;
           setQ($(this).attr("data"));
       });
   }); 
   
    
//-----------------------------------------------------------TIMMING---------------------------------------------------------------------------------------//
    
   
    function times()
    {
        this.value=0;
        Object.defineProperty(this, "req",{
            get:function(){
                return this.value;
            },
            set:function(responce){
                if(responce<0)
                    {
                        throw new Error("negative cant be set");
                    }
                else{
                    this.value=responce;
                }
            }
        });
    }
    
  
    
    var sec=new times();
    var min=new times();
    var hour=new times(); 
    var interval='';
    var Display=$("#time b");
     
    var time=JSON.parse(localStorage.time);
    hour.req=parseInt(time[0]);
    min.req=parseInt(time[1]);
    sec.req=parseInt(time[2]); 
    
    
        var interval=0;
    function startTime( )
    {
      interval=setTimeout(function(){ timer(); },1000);
       
    }
    function stopTime()
    {
          
         clearTimeout(interval);
    }
    
   
    function display(time)
        {
            $("#time b").html(time);
            localStorage.time=JSON.stringify(time.split(":"));
        }
    function timer()
        {
              
            try{
                 sec.req=sec.req-1;
                display(hour.req+' : '+min.req+' : '+sec.req);
            }
            catch(e){
                  try
                       {
                         min.req-=1;
                           sec.req=59;
                          display(hour.req+' : '+min.req+' : '+sec.req);
                       }
                catch(e){
                    try{
                        hour.req-=1;
                        min.req=59;
                        display(hour.req+' : '+min.req+' : '+sec.req);
                    }
                    catch(e){ 
                        stopTime();
                        $("#finish").click();
                    }
                    finally{}
                }
                finally{}
            }
            finally{
             
            }
           
             startTime();
            
        }
    
    
    
    
//--------------------------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------SUBMITTING THE SCRIPTS-----------------------------------------------------------------------//
    
    function submitScript(stat)
        {
            var script={};
            var details=JSON.parse(localStorage.details);
            script.student=details['student'];
            script.set=details['set'];
            script.course=details['setCourse'];
            script.status=stat;
            script.timeLeft=localStorage.time;
            structure();
            question=JSON.parse(localStorage.question);
            script.answers=[];
            for(var quest in question)
                {
                   script.answers.push({"serial":question[quest]['serial'] , "answer":question[quest]['answer']});
 
                }
            
            $.ajax({
                async:false,
                type:"POST",
                url:"server.php",
                data:{submit:script},
                success:function(responce){
                    //console.log(responce);
                },
                error:function(responce){}
            });
            
        }
    
//--------------------------------------------------------------------------------------------------------------------------------------------------////----------------------------------------------saving THE SCRIPTS-----------------------------------------------------------------------//
    
    function saveDismiss(stat)
        {
            var script={};
            var details=JSON.parse(localStorage.details);
            script.student=details['student'];
            script.set=details['set'];
            script.course=details['setCourse'];
            script.status=stat;
            script.timeLeft=localStorage.time;
            structure();
            question=JSON.parse(localStorage.question);
            script.answers=[];
            for(var quest in question)
                {
                   script.answers.push({"serial":question[quest]['serial'] , "answer":question[quest]['answer']});
 
                }
            
            $.ajax({
                async:false,
                type:"POST",
                url:"server.php",
                data:{save:script},
                success:function(responce){
                    //console.log(responce);
                },
                error:function(responce){}
            });
            
        }
    
//--------------------------------------------------------------------------------------------------------------------------------------------------//
});