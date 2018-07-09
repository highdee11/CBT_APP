<?php
session_start( );
  require_once("logins.php");
  global $connection;
  $connection=new PDO("mysql:host=$DB_SERVER; dbname=$DB_NAME",$DB_USER,$DB_PASSWORD);
  if($connection)
    {

    }
  else {
    print_r($connection->errorInfo() );
}


  function checkAccess($courseCh)
  { 
    if(isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']!="")
      {
          $adminCourses=$_SESSION['ADMIN']['courses'];
          $adminCourses=explode('#/',$adminCourses);
          if(in_array($courseCh,$adminCourses) || $adminCourses[0]=="All")
            {
              return true;
            }
          else
            {
              return false;
            }
      }

  }
    function getHighestScores()
        {
            global $connection;
            $adminCourse=$_SESSION['ADMIN']['courses']; 
            $adminCourse=explode('#/',$adminCourse);
            $courses='';
            
                 foreach($adminCourse as $id=> $value)
                            {
                                $courses="'". $value."',".$courses;
                            }
                            $courses=str_split($courses,strrpos($courses,','));
                        $courses=$courses[0];
                   
                $result=$connection->prepare("select MAX(perc) AS mx ,student from result where course in ('yoruba') ");
                $result->execute();
                $perc1=$result->fetchAll();
                $perc1=$perc1[0];
                $result=$connection->prepare("select MAX(perc) AS mx ,student from result where perc != {$perc1[0]} and course in ('yoruba') ");
                $result->execute();
                $perc2=$result->fetchAll();
                $perc2=$perc2[0];
                return  json_encode(array($perc1,$perc2));
        }
        if(isset($_POST['scriptSet']))
            {
                $set=$_POST['scriptSet'];
                $course=$_POST['scriptCourse'];
                $_SESSION['scriptSet']=$set;
                $_SESSION['scriptCourse']=$course;
 
            }
        else if(isset($_POST['viewscript']))
            {
                $script=$_POST['viewscript'];
                $_SESSION['viewscript']=$script;
                $result=$connection->prepare("select *from result where id=$script limit 1");
                $result->execute();
                $result=$result->fetchAll();
                $_SESSION['scriptname']=$result[0]['student'];
                $_SESSION['scriptId']=$result[0]['id'];
                $_SESSION['scriptSet']=$result[0]['Qset'];
                $_SESSION['scriptCourse']=$result[0]['course'];
                $_SESSION['scriptscore']=$result[0]['score'];
                $_SESSION['scriptperc']=$result[0]['perc'];
                $_SESSION['scriptansw']=$result[0]['answ'];
                $_SESSION['scriptgrade']=$result[0]['grade'];
             
            }
          else if(isset($_POST['markscript']))
            {
                $script=$_POST['markscript'];
                $_SESSION['markScript']=$script;
                $result=$connection->prepare("select *from result where id=$script limit 1");
                $result->execute();
                $result=$result->fetchAll();
                $_SESSION['scriptname']=$result[0]['student'];
                $_SESSION['scriptId']=$result[0]['id'];
                $_SESSION['scriptSet']=$result[0]['Qset'];
                $_SESSION['scriptCourse']=$result[0]['course'];
                $_SESSION['scriptscore']=$result[0]['score'];
                $_SESSION['scriptansw']=$result[0]['answ'];
                $rawresult=markScript();
                $percentageScore=percentage($rawresult);
               recordResult($rawresult,$percentageScore);
               
            }
        else if(isset($_POST['markAllscript']))
            {
                $set=$_POST['markAllscript'];
                $course=$_POST['markAllscriptCourse'];
                $res=$connection->prepare("select *from result where (Qset='{$set}' and course='{$course}') and marked='N' ");
                $res->execute();
                $res=$res->fetchAll();
                
                foreach ($res as $key => $value)
                 {
                    $script=$value['id'];
                    $result=$connection->prepare("select *from result where id=$script limit 1");
                    $result->execute();
                    $result=$result->fetchAll();
                    $_SESSION['scriptname']=$result[0]['student'];
                    $_SESSION['scriptId']=$result[0]['id'];
                    $_SESSION['scriptSet']=$result[0]['Qset'];
                    $_SESSION['scriptCourse']=$result[0]['course'];
                    $_SESSION['scriptscore']=$result[0]['score'];
                    $_SESSION['scriptansw']=$result[0]['answ'];
                    $rawresult=markScript();
                    $percentageScore=percentage($rawresult);
                   recordResult($rawresult,$percentageScore);
                 }
            }
          else if(isset($_POST['export']))
            {
              $set=$_SESSION['scriptSet'];
              $course=$_SESSION['scriptCourse'];
              $file=fopen("../files/".str_replace('/','<_></_>',$course)."_".str_replace('/','_',$set).'.csv','w');
              fwrite($file,"S/N , ID , NAME , SCORE , GRADE \n");
              
              $result=$connection->prepare("select student,username,perc,grade from result where Qset='{$set}' and course='{$course}' ");
              $result->execute();
              $result=$result->fetchAll();
              
              foreach ($result as $key => $value) {
                  $key+=1;
                fwrite($file,$key.','.$value['username'].','.$value['student'].','.$value['perc'].','.$value['grade']." \n");
              }
              fclose($file);
            }
         
           
          
            function grade($score)
              { 
                  $grades=array("A"=>array(100,70),"B"=>array(69,60),"C"=>array(59,50),"D"=>array(49,40),"E"=>array(39,30),"F"=>array(29,0));
                 $grade='';
                  foreach($grades as $id=> $value)
                    {
                        if($score <= $value[0] && $score>=$value[1])
                            {
                              $grade=$id;
                              break;
                            }
                            
                    }
                    
                    return $grade;
              }
              
              function gradeAlert($score)
              { 
                  $grades=array("A"=>array(100,70,"label-success"),"B"=>array(69,60,"label-primary"),
                  "C"=>array(59,50,"label-warning"),"D"=>array(49,40,"label-warning"),"E"=>array(39,30,"label-danger"),"F"=>array(29,0,"label-danger"));
                 $alert='';
                  foreach($grades as $id=> $value)
                    {
                        if($score <= $value[0] && $score>=$value[1])
                            {
                              $alert=$value[2];
                              break;
                            }
                            
                    }
                    
                    return $alert;
              }
            function recordResult($raw,$perc)
              {
                global $connection;
                $id=$_SESSION['scriptId'];
                $grd= grade($perc);
                $result=$connection->prepare("update result set marked='Y' , score='{$raw}' , perc='{$perc}' ,grade='{$grd}' where  id=$id "); 
                $result->execute(); 
                
              }
                 
            function percentage($score)
              {
                $noq=(int)$_SESSION['setnoq'];
                $perc=(($score/$noq) * 100);
                return $perc;
              }
          function markScript()
            {
                $questionsAnswered=getquestionsScript();
                $studentSerials=json_decode($_SESSION['scriptansw']);
                 $serialsStudent=array();
                 $serialsQuestion=array();
                 foreach($questionsAnswered as $id=>$value)
                    {
                        if($value['structureOption']==null)
                          {
                            $serialsQuestion[$value['serial']]=$value['optionBest'];
                          }
                          else
                          {
                               $serialsQuestion[$value['serial']]=$value['structureOption'];              
                          }
                    }
                  foreach($studentSerials as $id=>$value)
                    {
                        $serialsStudent[$value->serial]=$value->answer;
                    }
                   $score=0;
                  foreach($serialsQuestion as $id=>$value)
                    {
                        if($serialsQuestion[$id]==$serialsStudent[$id])
                            {
                              $score+=1;
                            }
                         else
                            {
                              $score=$score;
                            }
                        
                    }
                  return $score;
            }
            
         function getquestionPaperDet()
          {
            return array("grade"=>$_SESSION['scriptgrade'],"perc"=>$_SESSION['scriptperc'],"set"=>$_SESSION['scriptSet'],"course"=>$_SESSION['scriptCourse'],"name"=>$_SESSION['scriptname'],"score"=>$_SESSION['scriptscore']);  
          }
          
         
        function getStudentquestionAnsw()
            {
               $result=json_decode($_SESSION['scriptansw']);
               
                $answers=array();
               foreach($result as $id=>$value)
                {
                    $answer[$value->serial]=$value->answer;
                }
                return $answer;
            }
        function getquestionsScript()
            {
                global $connection;
                $set=$_SESSION['scriptSet'];
                $course= $_SESSION['scriptCourse'];
                $scriptansw=json_decode($_SESSION['scriptansw']);
                $serials="";
                $res=$connection->prepare("select noq from sets where title='{$set}' and course='{$course}' limit 1 ");
                $res->execute();
                $res=$res->fetch();
                $_SESSION['setnoq']=$res['noq'];
                foreach($scriptansw as $id=> $value)
                    {
                        $serials="'". $value->serial."',".$serials;
                    }
                    $serials=str_split($serials,strrpos($serials,','));
                    $serials=$serials[0];
              
                $result=$connection->prepare("select *from questions where serial in ($serials)  and (Qset='{$set}' and course='{$course}')     ");
                $result->execute();
                $result=$result->fetchAll();
                       return $result;
            }
        function getScripts()
            {
            global  $connection;
                 $_SESSION['scriptCourse'];
                $set=$_SESSION['scriptSet'];
                $course= $_SESSION['scriptCourse'];
                $result=$connection->prepare("select *from result where course='{$course}' and Qset='{$set}' ");
                $result->execute();
                $result=$result->fetchAll(2);
                return json_encode($result);
            }
        function getAllSetScript($set)
            {
                global $connection;
            $counts;
            if(is_array($set))
                {
                    foreach($set as $id=>  $st)
                        {
                            $result=$connection->prepare("select COUNT(id)  from result where Qset='{$st['title']}' and course ='{$st['course']}' ");
                            $result->execute();
                            $result=$result->fetch();
                            $counts[$st['course'].$id]=array($st['title']=>$result[0]);
                        }
                }
            else
                {
                   $result=$connection->prepare("select COUNT(id)  from result where Qset='{$st['title']}' and course ='{$st['course']}' ");
                            $result->execute();
                            $result=$result->fetch();
                            $counts[$set['course']]=array($set['title']=>$result[0]);
                }
            return $counts;
           }
    function getScriptCountUm($set)
        {
            global $connection;
            $counts;
            if(is_array($set))
                {
                    foreach($set as $id=>  $st)
                        {
                            $result=$connection->prepare("select COUNT(id)  from result where marked='N' and (Qset='{$st['title']}' and course ='{$st['course']}') ");
                            $result->execute();
                            $result=$result->fetch();
                            $counts[$st['course'].$id]=array($st['title']=>$result[0]);
                        }
                }
            else
                {
                   $result=$connection->prepare("select COUNT(id)  from result where marked='N' and (Qset='{$st['title']}' and course ='{$st['course']}') ");
                            $result->execute();
                            $result=$result->fetch();
                            $counts[$set['course']]=array($set['title']=>$result[0]);
                }
            return $counts;
        }
    function getScriptCountM($set)
        {
            global $connection;
            $counts;
            if(is_array($set))
                {
                    foreach($set as $id=>  $st)
                        {
                            $result=$connection->prepare("select COUNT(id)  from result where marked='Y' and (Qset='{$st['title']}' and course ='{$st['course']}') ");
                            $result->execute();
                            $result=$result->fetch();
                            $counts[$st['course'].$id]=array($st['title']=>$result[0]);
                        }
                }
            else
                {
                   $result=$connection->prepare("select COUNT(id)  from result where marked='Y' and (Qset='{$st['title']}' and course ='{$st['course']}') ");
                            $result->execute();
                            $result=$result->fetch();
                            $counts[$set['course']]=array($set['title']=>$result[0]);
                }
            return $counts;
        }

    function getScriptSet($courses)
        {
            $all_set;
              if(is_array($courses))
              {
                  foreach($courses as $cos)
                    {
                        $set=getSetByCourse($cos);
                        foreach($set as $st)
                        {
                            $all_set[]=$st;
                        }
                    }
              }
            else
                {
                    $all_set=getSetByCourse($courses);
            }
            
            return $all_set;
        }

    function getSetByCourse($course)
        {
            global $connection;
            $result=$connection->prepare("select title ,course from sets where course='{$course}' ");
            $result->execute();
            $result=$result->fetchAll(2);
            return $result;
                 
        }

    function getAdmins()
        {
            global $connection;
            $result=$connection->query("select *from admins");
            $result=$result->fetchAll();
            return $result;
        }
        function login()
            {
                if(isset($_SESSION['ADMIN']) && count($_SESSION['ADMIN'])!=0)
                    {
                    return true;
                }
                else
                {
                    return false;
                }

            }username();
    function username()
        {
            $str="FUOITAEUANORLMBEIOUA";//"0000000123456789104U55845ABCDEFGHIJKLMNOPQRSTUVWXYZREFHKHKRHG9HGI3B34JBJ34HJ3HJ3H46JH6GJH78G738RCG783GR28CRG32G8GCY32RVYQVASVHVSXCSAX";
          return substr(str_shuffle($str),rand(7,strlen($str)-7),7);
        }
    function password()
        {
            $str="0000000123456789104U55845ABCDEFGHIJKLMNOPQRSTUVWXYZREFHKHKRHHGI3B34JBJ34HJ3HJ3H46JH6GJH78G738RCG783GR28CRG32G8GCY32RVYQVASVHVSXCSAX";
          return substr(str_shuffle($str),rand(7,strlen($str)-7),7);
        }

    if(isset($_POST['generate']))
        {
            $user=str_replace(' ','',username());
            $password=str_replace(' ','',password());
            echo json_encode(array($user,$password));
        }
    else if(isset($_POST['adminName']))
        {

            $name=$_POST['adminName'];
            $courses=$_POST['courses'];
            $gender=$_POST['gender'];
            $username=$_POST['username'];
            $password=$_POST['password'];
            $passwordhash=md5($_POST['password']);
            $courseStr="";
            foreach($courses as $val)
                {
                    $courseStr=$val.'#/'.$courseStr;
                }
            $res=$connection->query("select  *from admins where username='{$username}' ");
            $res=$res->rowCount();
            if($res>0)
                {
                    echo "exists";
                }
            else
                {
                      $result=$connection->prepare("insert into admins (name,courses,gender,username,password,passwordhas,access)
                              values ('{$name}','{$courseStr}','{$gender}','{$username}','{$password}','{$passwordhash}','Y') ");
                          $result->execute();
                  }
        }
  else if(isset($_POST['editAdminName']))
          {
            $name=$_POST['editAdminName'];
            $id=$_POST['id'];
            $courses=$_POST['editCourses'];
            $gender=$_POST['gender'];
            $username=$_POST['username'];
            $password=$_POST['password'];
            $passwordhash=md5($_POST['password']);
            $courseStr="";
            foreach($courses as $val)
              {
                  $courseStr=$val.'#/'.$courseStr;
              }
            $res=$connection->query("select  *from admins where username='{$username}' ");
            $res=$res->rowCount();
            if($res<0)
                {
                    echo "exists";
                }
            else
                {
                            $result=$connection->prepare("update admins set name='{$name}',courses='{$courseStr}',gender='{$gender}',username='{$username}',password='{$password}',
                                      passwordhas='{$passwordhash}', access='Y'  where id=$id ");
                                $result->execute();
                                print_r($result->errorInfo());
                }
          }

    if(isset($_POST['Adminuser']))
        {
            $user=$_POST['Adminuser'];
            $pass=md5($_POST['Adminpassw']);
            if(trim($user) && trim($pass))
                {
                    $result=$connection->prepare("select *from admins where username=:user and passwordhas=:pass limit 1");
                    $result->bindParam(":user",$user);
                    $result->bindParam(":pass",$pass);
                    if($result->execute())
                        {
                            $count=$result->rowCount();
                            $result=$result->fetch();

                            if($count>0)
                                {
                                   $_SESSION['ADMIN']=$result;
                                    echo true;
                                }
                            else
                                {

                                    session_destroy();
                                }
                    }
                }
        }
    else if(isset($_POST['logout']))
        {
        session_destroy();
        echo true;
    }

  function getCourses()
    {
      global $connection;
      $result=$connection->query("select *from courses");
      return $result->fetchAll();
    }
  function  getsets()
    {
      global $connection;
      $result=$connection->query("select  *from sets");
      return $result->fetchAll();
    }

    function  getQuestions()
      {
        global $connection;
        $course=$_SESSION['ADMIN']['courses'];
        $course=explode('#/',$course);
        $courses="";
        //print_r($course);
         foreach($course as $id=> $value)
                    {
                        $courses="'". $value."',".$courses;
                    }
            $courses=str_split($courses,strrpos($courses,','));
            $courses=$courses[0];
            $result=$connection->prepare("select *from questions where course in($courses) ");
            $result->execute();
            return $result->fetchAll();
        
      }


    function getSetCount()
    {
      global $connection;
      $result=$connection->query("select  count(id) from sets");
      return $result->fetch();
    }

    function getCourseCount()
    {
      global $connection;
      $result=$connection->query("select  count(id) from courses");
      return $result->fetch();
    }

    function getQuestionCount()
    {
      global $connection;
      $result=$connection->query("select  count(id) from questions");
      return $result->fetch();
    }

    function searchCourses($title)
      {
        global $connection;
        $result=$connection->query("select *from courses where title like '%".$title."%' ");
        return $result->fetchAll();
      }

    function searchSets($title)
        {
          global $connection;
          $result=$connection->query("select *from sets where title like '%".$title."%' ");
          return $result->fetchAll();
        }
    function searchQuestions($det)
        {
          global $connection;
          $key=$det[2];
          $cos=$det[0];
          $set=$det[1];
          $result=$connection->query("select *from questions where (course='{$cos}' and Qset='{$set}' ) and content like '%".$key."%' ");
          return $result->fetchAll();
        }
//-----------------------------------------SUBMITTING COURSE --------------------------------------//

if(isset($_POST['course_title']))
  {

    $courseTitle=$_POST['course_title'];
    $courseDescription=$_POST['course_description'];
    $result=$connection->prepare("insert into courses (title,description,publish) values('{$courseTitle}','{$courseDescription}','Y') ");
    if($result->execute())
      {
        echo true;
      }
    else {
      print_r($result->errorInfo());
    }
  }
//-------------------------------------------------------------------------------------------------//
//-----------------------------------------SUBMITTING SET --------------------------------------//
elseif(isset($_POST['questionset_title']))
  {

    $setTitle=$_POST['questionset_title'];
    $course=$_POST['course'];
    $setDescription=$_POST['questionset_description'];
    $noq=$_POST['noq'];
    $level=$_POST['level'];
    $time=$_POST['hour'].'/'.$_POST['min'].'/'.$_POST['sec'];
    $check=$connection->prepare("select *from sets where title='{$setTitle}' and course='{$course}'");
    if($check->execute())
    {
      if(count($check->fetch())>1)
      {
        echo "exit";
      }
      else {

        $result=$connection->prepare("insert into sets (title,course,class,description,noq,time,publish) values('{$setTitle}','{$course}','{$level}','{$setDescription}','{$noq}','{$time}','N') ");
        if($result->execute())
          {
            echo true;
          }
        else {
          print_r($result->errorInfo());
        }
      }
    }
  }
//-------------------------------------------------------------------------------------------------//
//----------------------------------------------------SUBMITTING QUESTIONS--------------------------------------------------//
 $imageTypes=array("image/jpeg","image/png");



  if(isset($_POST['quest_cont']))
  {
    // print_r($_FILES);
    // print_r($_POST);
//---------------------------------------------OBJECTIVES--------------------------------------------------------------------------///
      if(isset($_POST['quest_opt1']))
      {

        $course=$_POST['quest_course'];
        $set=$_POST['quest_set'];
        $content=$_POST['quest_cont'];
        $opt1=$_POST['quest_opt1'];
        $opt2=$_POST['quest_opt2'];
        $opt3=$_POST['quest_opt3'];
        $opt4=$_POST['quest_opt4'];
        $opt5=$_POST['quest_opt5'];
        $answer=$_POST['quest_answ'];
        $serial=sprintf('%04x%04x%',mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff));
        if($_FILES['quest_img']['name']=='')
        {
          $result=$connection->prepare( "insert into questions (course,Qset,content,optionA,optionB,optionC,optionD,optionE,optionBest,serial)
                    values ('{$course}','{$set}','{$content}','{$opt1}','{$opt2}','{$opt3}','{$opt4}','{$opt5}','{$answer}','{$serial}') ");
          $result->execute();
        }
        else
        {

          if(in_array($_FILES['quest_img']['type'],$imageTypes))
          {
             $filename=sprintf('%04x%04x%04x%04x%',mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff));
             $name=$_FILES['quest_img']['name'];
             $format=explode('.',$name);
             $filename=$filename.'.'.$format[1];
             move_uploaded_file($_FILES['quest_img']['tmp_name'],"../questionImg/".$filename);
             $result=$connection->prepare("insert into questions (course,Qset,content,optionA,optionB,optionC,optionD,optionE,optionBest,image,serial)
              values( '{$course}','{$set}','{$content}','{$opt1}','{$opt2}','{$opt3}','{$opt4}','{$opt5}','{$answer}','{$filename}','{$serial}' )  ");

                $result->execute();
          }
          else {
            echo 5;
          }
        }
      }
  //---------------------------------------------STRUCTURAL--------------------------------------------------------------------------///
      else {
        $course=$_POST['quest_course'];
        $set=$_POST['quest_set'];
        $content=$_POST['quest_cont'];
        $strAnsw=$_POST['strAnsw'];
        $serial=sprintf('%04x%04x%',mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff));
        if($_FILES['quest_img']['name']=='')
          {
            $result=$connection->prepare("insert into questions (course,Qset,content,structureOption,serial)
                      values('{$course}','{$set}','{$content}','{$strAnsw}','{$serial}')
                ");
                $result->execute();
                  //  print_r($result->errorInfo());
            }
        else
        {
          if(in_array($_FILES['quest_img']['type'],$imageTypes))
            {
              $filename=sprintf('%04x%04x%04x%04x%',mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff));
             $name=$_FILES['quest_img']['name'];
             $format=explode('.',$name);
             $filename=$filename.'.'.$format[1];
             move_uploaded_file($_FILES['quest_img']['tmp_name'],"../questionImg/".$filename);
                 $result=$connection->prepare("insert into questions (course,Qset,content,structureOption,image,serial)
                           values('{$course}','{$set}','{$content}','{$strAnsw}','{$filename}','{$serial}')
                           ");
                $result->execute();
              }
            else
             {
              echo 4;
            }
        }
      }
  //    print_r($_POST);
  }
//----------------------------------------------------------------------------------------------------------------------//
if(isset($_POST['getSet']))
//--------------------------------------------getting set for question page------------------------------------------??
  {
    $result=$connection->query("select *from sets");
    if($result->execute())
    {
      echo json_encode($result->fetchAll());

    }
  else {
    print_r($result->errorInfo());

    }
  }

//------------------------------------------------------------------------------------------------------------------------------------??

//----------------------------------------------------------UPDATING PUBLISH FEATURE OF COURSE-------------------------------------------------------------------------------------------------//

   if(isset($_POST['publish']))
      {
        $course=$_POST['publish'];
          global $connection;
              if(is_array($course))
                {
                    $courseName=$_POST['CourseName'];//print_r($courseName);
                    foreach ($course as $key => $value) {
                      if(checkAccess($courseName[$key]))
                        {
                          $result=$connection->prepare("UPDATE courses SET publish='Y' WHERE id={$value} ");
                          $result->execute();
                        }
                        else
                        {
                          echo "Not Admin";
                          break;
                        }
                    }
                }
              else
              {
                //  $title=$_POST['title'];
                  if(checkAccess($_POST['title']))
                    {
                      $result=$connection->prepare("UPDATE courses SET publish='Y' WHERE id={$course} ");
                      $result->execute();
                    }else
                    {
                      echo "Not Admin";
                    }
              }


      }
    elseif(isset($_POST['unpublish']))
         {
           $course=$_POST['unpublish'];
             $title=$_POST['title'];
           if(checkAccess($title))
             {
                 global $connection;
                 if(is_array($course))
                   {
                       foreach ($course as $key => $value) {
                           $result=$connection->prepare("UPDATE courses SET publish='N' WHERE id={$value} ");
                           $result->execute();
                       }
                   }
                 else
                 {
                   $result=$connection->prepare("UPDATE courses SET publish='N' WHERE id={$course} ");
                   if($result->execute())
                     {

                     }
                   else {
                         echo false;

                     }
                   }
              }
              else
              {
                echo "Not Admin";
              }
         }
     elseif(isset($_POST['delete']))
          {
            $course=$_POST['delete'];
              $title=$_POST['title'];
            if(checkAccess($title))
               {
                     global $connection;
                  if(is_array($course))
                    {
                        foreach ($course as $key => $value) {
                          $result=$connection->prepare("Delete from courses WHERE id={$value} ");
                            $result->execute();
                        }
                    }
                  else
                  {
                    $result=$connection->prepare("Delete from courses WHERE id={$course} ");
                    if($result->execute())
                      {

                      }
                    else {
                          echo false;

                      }
                    }
              }
              else
              {
                echo "Not Admin";
              }
          }

   //----------------------------------------------------------UPDATING PUBLISH FEATURE OF SETS-------------------------------------------------------------------------------------------------//

             if(isset($_POST['Setpublish']))
                {
                  $set=$_POST['Setpublish'];



                        global $connection;
                            if(is_array($set))
                                {
                                    $courses=$_POST['setCourse'];
                                          foreach ($set as $key => $value) {

                                            if(checkAccess($courses[$key]))
                                               {
                                                  $res=$connection->prepare("select noq,course,title from sets where id={$value} limit 1");
                                                  $res->execute();// print_r($res->errorInfo());
                                                  $res=$res->fetch();
                                                  $noq=$res['noq'];
                                                  $titu=$res['title'];
                                                  $cos=$res['course'];

                                                    $res=$connection->prepare("select id from questions where course='{$cos}' and Qset='{$titu}' ");
                                                  if($res->execute())
                                                  {
                                                    $resNo=$res->rowCount();
                                                    if($noq <= $resNo)
                                                      {
                                                          $result=$connection->prepare("UPDATE sets SET publish='Y' WHERE id={$value} ");
                                                          $result->execute();
                                                      }
                                                      else {
                                                        echo "noq error";
                                                        break;
                                                }
                                          }
                                        }
                                          else
                                          {
                                            echo "Not Admin";
                                          }
                                      }

                              }
                              else
                              {
                                $course=$_POST['title'];
                                $setname=$_POST['name'];
                                if(checkAccess($course))
                                   {
                                    $noq=$_POST['noq'];
                                    $res=$connection->prepare("select id from questions where course='{$course}' and Qset='{$setname}' ");
                                    $res->execute();
                                    //echo $noq.'/'.$res->rowCount();
                                    //echo $course.'/'.$setname;
                                     $name=$_POST['name'];
                                    if( $noq <= $res->rowCount())
                                      {
                                        $result=$connection->prepare("UPDATE sets SET publish='Y' WHERE id={$set} ");
                                        $result->execute();
                                      }
                                      else {
                                        echo "noq error";
                                      }
                                    }
                                    else
                                    {
                                      echo "Not Admin";
                                    }
                              }
                           }



              elseif(isset($_POST['Setunpublish']))
                   {
                     $course=$_POST['Setunpublish'];
                      $title=$_POST['title'];
                     if(checkAccess($title))
                        {
                             global $connection;
                             if(is_array($course))
                               {
                                   foreach ($course as $key => $value) {
                                       $result=$connection->prepare("UPDATE sets SET publish='N' WHERE id={$value} ");
                                       $result->execute();
                                   }
                               }
                             else
                             {
                               $result=$connection->prepare("UPDATE sets SET publish='N' WHERE id={$course} ");
                               if($result->execute())
                                 {

                                 }
                               else {
                                     echo false;

                                 }
                               }
                          }
                          else
                          {
                            echo "Not Admin";
                          }
                   }
               elseif(isset($_POST['Setdelete']))
                    {
                      $course=$_POST['Setdelete'];
                       $title=$_POST['title'];
                      if(checkAccess($title))
                         {
                              global $connection;
                                  if(is_array($course))
                                    {
                                        foreach ($course as $key => $value) {
                                          $result=$connection->prepare("Delete from sets WHERE id={$value} ");
                                            $result->execute();
                                        }
                                    }
                                  else
                                  {
                                    $result=$connection->prepare("Delete from sets WHERE id={$course} ");
                                    if($result->execute())
                                      {

                                      }
                                    else {
                                          echo false;

                                      }
                                    }
                              }
                            else
                            {
                              echo "Not Admin";
                            }
                    }

//--------------------------------------------------------------------DELETING  QUESTIONS------------------------------------------------//
        if(isset($_POST['Qdelete']))
             {
               $course=$_POST['Qdelete'];
               $title=$_POST['title'];
               if(checkAccess($title))
                  {
                      global $connection;
                     if(is_array($course))
                       {
                           foreach ($course as $key => $value) {
                              $res=$connection->query("select image from questions where id={$value} limit 1");
                              if($res['image']!="")
                               $res=$res->fetch();
                              {
                                unlink("../questionImg/".$res['image']);
                              }

                               $result=$connection->prepare("Delete from questions WHERE id={$value} ");
                               $result->execute();

                             }

                       }
                       else
                           {
                             $res=$connection->query("select image from questions where id={$course} limit 1");
                             $res=$res->fetch();
                             if($res['image']!="")
                             {
                               unlink("../questionImg/".$res['image']);
                             }
                                 $result=$connection->prepare("Delete from questions WHERE id={$course} ");
                                 if($result->execute())
                                   {

                                   }
                                 else {
                                       echo false;

                                   }

                             }
                           }
                         else
                         {
                           echo "Not Admin";
                         }
                    }

//---------------------------------------------------------------------------EDITTING COURSE----------------------------------------------------------------//

  if(isset($_POST['getCourse']))
    {
      $id=$_POST['getCourse'];
      $title=$_POST['title'];
      if(checkAccess($title))
          {
              $result=$connection->query("select *from courses where id='{$id}' limit 1");
              $result=$result->fetch();
              if(count($result)>0)
                {
                   echo json_encode($result);
                }
                else {
                    echo "false";
                }
            }
          else {
                 echo "Not Admin";
            }
    }
  else if(isset($_POST['Updatecourse_title'])){
    $key=$_POST['courseId'];
    $title=$_POST['Updatecourse_title'];
    if(checkAccess($title))
        {
            $description=$_POST['course_description'];
              $result=$connection->query("update courses set title='{$title}' , description='{$description}' where id=$key");
        }
    else
      {
           echo "Not Admin";
      }
    }
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------------------------UPDATING Course view-----------------------------------------------------------------------------------------//

    if(isset($_POST['viewCourses']))
    {
        $result=searchCourses($_POST['viewCourses']);
        ?> <?php foreach ($result as $key => $value):  $id=$value['id'];
        $title=$value['title'];
        $description=$value['description'];
        $publish=$value['publish'];
        $key++;
        if($publish=='Y')
        {
          echo
          " <tr>
            <td>". $key. "</td>
            <td> <input  type='checkbox' course='$id' data='$title' class='select' /> </td>
            <td>{$title}</td>
            <td>{$description}</td>
            <td ><div class='status col-lg-7 pull-left'><span class='txt text-success'> Published </span><div class='load '></div>   </div>
            <center class'col-lg-2'><span class=' pull-left text-success glyphicon glyphicon-ok'></span>
              </center></td>

            <td class='button'> <div class='btn-group btn-group-xs'>
                                  <button class='btn btn-xs btn-warning  title='{$title}' publish' data='unpublish' course='{$id}'>Unpublish</button>
                                    <button type='button'  title='{$title}' class='btn-primary btn edit' course='{$id}'>&nbsp; Edit &nbsp;</button>
                                    <button  title='{$title}' course='{$id}' class='btn btn-danger btn-xs delete' >Delete</button>


                              </div>
            </td>
          </tr>";
        }
        else {
          echo
          " <tr>
            <td>". $key. "</td>
            <td><input type='checkbox' course='$id' data='$title' class='select' /></td>
            <td>{$title}</td>
            <td>{$description}</td>
            <td ><div class='status col-lg-7 pull-left'><span class='txt text-danger'>Not published </span><div class='load '></div>   </div>
            <center class'col-lg-2'><span class=' pull-left text-danger glyphicon glyphicon-remove'></span>
              </center></td>

            <td class='button'> <div class='btn-group btn-group-xs'>
            <button class='btn btn-xs btn-success publish' data='publish'  title='{$title}' course='{$id}'>&nbsp; Publish &nbsp;</button>
            <button data-toggle='modal' data-target='' class='btn-primary btn edit'  title='{$title}' course='{$id}'>&nbsp; Edit &nbsp;</button>
            <button  title='{$title}' course='{$id}' class='btn btn-danger btn-xs delete' >Delete</button>
                              </div>
            </td>
          </tr>";
        }
        endforeach;
    }
    else if(isset($_POST['searchCourse']))
    {
        $key=$_POST['searchCourse'];
        $result=searchCourses($key);
      //  print_r($result);
        foreach ($result as $key => $value){  $id=$value['id'];
        $title=$value['title'];
        $description=$value['description'];
        $publish=$value['publish'];
        $key++;
        if($publish=='Y')
        {
          echo
          " <tr>
            <td>". $key. "</td>
            <td> <input  type='checkbox' course='$id' data='$title' class='select' /> </td>
            <td>{$title}</td>
            <td>{$description}</td>
            <td ><div class='status col-lg-7 pull-left'><span class='txt text-success'> Published </span><div class='load '></div>   </div>
            <center class'col-lg-2'><span class=' pull-left text-success glyphicon glyphicon-ok'></span>
              </center></td>

            <td class='button'> <div class='btn-group btn-group-xs'>
                                  <button class='btn btn-xs btn-warning  publish'  title='{$title}' data='unpublish' course='{$id}'>Unpublish</button>
                                    <button type='button'  class='btn-primary btn edit'  title='{$title}' course='{$id}'>&nbsp; Edit &nbsp;</button>
                                    <button course='{$id}' class='btn btn-danger btn-xs delete'  title='{$title}' >Delete</button>


                              </div>
            </td>
          </tr>";
        }
        else {
          echo
          " <tr>
            <td>". $key. "</td>
            <td><input type='checkbox' course='$id' data='$title' class='select' /></td>
            <td>{$title}</td>
            <td>{$description}</td>
            <td ><div class='status col-lg-7 pull-left'><span class='txt text-danger'>Not published </span><div class='load '></div>   </div>
            <center class'col-lg-2'><span class=' pull-left text-danger glyphicon glyphicon-remove'></span>
              </center></td>

            <td class='button'> <div class='btn-group btn-group-xs'>
            <button class='btn btn-xs btn-success publish' data='publish'  title='{$title}' course='{$id}'>&nbsp; Publish &nbsp;</button>
            <button data-toggle='modal' data-target='' class='btn-primary btn edit'  title='{$title}' course='{$id}'>&nbsp; Edit &nbsp;</button>
            <button course='{$id}' class='btn btn-danger btn-xs delete'  title='{$title}' >Delete</button>
                              </div>
            </td>
          </tr>";

      } }
    }

?>
<?php

//----------------------------------------------------------------------------------------------------------------------------------------------------------------//
//-----------------------------------------------------------------------UPDATING Set view-----------------------------------------------------------------------------------------//

    if(isset($_POST['viewSets']))
    {
        $result=searchSets($_POST['viewSets']);
        foreach ($result as $key => $value):  $id=$value['id'];
        $title=$value['course'];
        $description=$value['description'];
        $publish=$value['publish'];
        $course=$value['course'];
        $noq=$value['noq'];
        $class=$value['class'];
        $name=$value['title'];
        $time=preg_replace("/\//",":",$value['time']) ;

        $key++;
        if($publish=='Y')
        {
          echo
          "  <tr>
              <td> $key</td>
              <td><input type='checkbox' course={$id} data={$name} class='select' /></td>
              <td>{$name}</td>
              <td>{$description}</td>
              <td>{$noq}</td>
              <td>{$course}</td>
              <td>{$class}</td>
              <td>{$time}</td>

              <td ><div class='status col-lg-7 pull-left '> <div class='load '></div>   </div>
              <center class'col-lg-2'><span class=' pull-left text-success glyphicon glyphicon-ok'></span></center></td>

              <td class='button'> <div class='btn-group btn-group-xs'><button class='btn btn-xs btn-warning  publish' name='{$name}' noq='{$noq}' title='{$title}' data='unpublish' course={$id}>Unpublish</button>
                                          <button type='button'  class='btn-primary btn edit'  title='{$title}' course={$id}>&nbsp; Edit &nbsp;</button>
                                            <button course={$id} class='btn btn-danger btn-xs delete'  title='{$title}' >Delete</button>

                            </div>
              </td>
            </tr>
          <?php endforeach; ?>


          ";
        }
        else {
          echo
          "  <tr>
              <td> $key</td>
              <td><input type='checkbox' course={$id} data={$title} class='select' /></td>
              <td>{$name}</td>
              <td>{$description}</td>
              <td>{$noq}</td>
              <td>{$course}</td>
              <td>{$class}</td>
              <td>{$time}</td>

              <td ><div class='status col-lg-7 pull-left '> <div class='load '></div>   </div>
              <center class'col-lg-2'><span class=' pull-left text-danger glyphicon glyphicon-remove'></span></center></td>

              <td class='button'> <div class='btn-group btn-group-xs'><button class='btn btn-xs btn-success publish' noq='{$noq}' name='{$name}' title='{$title}' data='publish' course='{$id}'>&nbsp; Publish &nbsp;</button>
               <button type='button'  class='btn-primary btn edit' course='{$id}'  title='{$title}' >&nbsp; Edit &nbsp;</button>
               <button course='{$id}' class='btn btn-danger btn-xs delete'  title='{$title}' >Delete</button>

                            </div>
              </td>
            </tr>
          <?php endforeach; ?>


          ";
        }
        endforeach;
    }
    else if(isset($_POST['searchSet']))
    {
        $key=$_POST['searchSet'];
        $result=searchSets($key);
        foreach ($result as $key => $value){  $id=$value['id'];
          $title=$value['course'];
          $description=$value['description'];
          $publish=$value['publish'];
          $course=$value['course'];
          $noq=$value['noq'];
          $name=$value['title'];
          $time=preg_replace("/\//",":",$value['time']) ;
            $class=$value['class'];
        $key++;
        if($publish=='Y')
        {
          echo
          "  <tr>
              <td> $key</td>
              <td><input type='checkbox' setCourse='{$title}'  course={$id} data={$name} class='select' /></td>
              <td>{$name}</td>
              <td>{$description}</td>
              <td>{$noq}</td>
              <td>{$course}</td>
              <td>{$class}</td>
              <td>{$time}</td>

              <td ><div class='status col-lg-7 pull-left '> <div class='load '></div>   </div>
              <center class'col-lg-2'><span class=' pull-left text-success glyphicon glyphicon-ok'></span></center></td>

              <td class='button'> <div class='btn-group btn-group-xs'><button class='btn btn-xs btn-warning publish' title='{$title}'  noq='{$noq}' name='{$name}' data='unpublish' course={$id}>Unpublish</button>
                                          <button type='button' title='{$title}' class='btn-primary btn edit' course={$id}>&nbsp; Edit &nbsp;</button>
                                            <button course={$id} class='btn btn-danger btn-xs delete' >Delete</button>

                            </div>
              </td>
            </tr>
          <?php endforeach; ?>


          ";
        }
        else {
          echo
          "  <tr>
              <td> $key</td>
              <td><input type='checkbox' setCourse='{$title}' course={$id} data={$title} class='select' /></td>
              <td>{$name}</td>
              <td>{$description}</td>
              <td>{$noq}</td>
              <td>{$course}</td>
                <td>{$class}</td>
              <td>{$time}</td>

              <td ><div class='status col-lg-7 pull-left '> <div class='load '></div>   </div>
              <center class'col-lg-2'><span class=' pull-left text-danger glyphicon glyphicon-remove'></span></center></td>

              <td class='button'> <div class='btn-group btn-group-xs'><button class='btn btn-xs btn-success publish' title='{$title}' noq='{$noq}' name='{$name}' data='publish' course='{$id}'>&nbsp; Publish &nbsp;</button>
               <button type='button' title='{$title}' class='btn-primary btn edit' course='{$id}'>&nbsp; Edit &nbsp;</button>
               <button course='{$id}' class='btn btn-danger btn-xs delete' >Delete</button>

                            </div>
              </td>
            </tr>
          <?php endforeach; ?>


          ";
        }
        }

    }


    //---------------------------------------------------------------------------EDITTING SET----------------------------------------------------------------//

      if(isset($_POST['getSets']))
        {
          $id=$_POST['getSets'];
          $title=$_POST['title'];
          if(checkAccess($title))
              {
                  $result=$connection->query("select *from sets where id='{$id}' limit 1");
                  $result=$result->fetch();
                  if(count($result)>0)
                    {
                       echo json_encode($result);
                    }
                    else {
                        echo "false";
                    }
              }
              else {
                echo "Not Admin";
              }
        }
      else if(isset($_POST['UpdateSet_title'])){
        $key=$_POST['setId'];
        $title=$_POST['UpdateSet_title'];
        $course=$_POST['setcos'];
        $level=$_POST['Editlevel'];
        $noq=$_POST['noq'];
        $time=$_POST['hour'].'/'.$_POST['min'].'/'.$_POST['sec'];
        $description=$_POST['questionset_description'];
        $res=$connection->prepare("select id from sets where (title='{$title}' and course='{$course}') and id!=$key limit 1");
        $res->execute();
        if($res->rowCount()==0)
          {
            if(checkAccess($course))
              {
                  $result=$connection->prepare("update sets set title='{$title}' ,course='{$course}' , noq='{$noq}' , class='{$level}', time='{$time}', description='{$description}' where id=$key ");
                  $result->execute();
              }
            else
              {
                echo "Not Admin";
              }
          }
          else if($res->rowCount()>0)
          {
            echo "exist".$res->rowCount();
          }  
        }
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------//


    //---------------------------------------------------------------------------EDITTING SET----------------------------------------------------------------//

      if(isset($_POST['getQuestion']))
        {
          $id=$_POST['getQuestion'];
          $title=$_POST['title'];
          if(checkAccess($title))
              {
                  $result=$connection->query("select *from questions where id='{$id}' limit 1");
                $result=$result->fetch();
                if(count($result)>0)
                  {
                     echo json_encode($result);
                  }
                  else {
                      echo "false";
                  }
                }
                else {
                  echo "Not Admin";
                }
        }
      else if(isset($_POST['Updatecourse_title'])){
        $key=$_POST['courseId'];
        $title=$_POST['Updatecourse_title'];
        $description=$_POST['course_description'];
          $result=$connection->query("update courses set title='{$title}' , description='{$description}' where id=$key");
                }

    //----------------------------------------------------------------------------------------------------------------------------------------------------------------//


    //----------------------------------------------------UPDATING QUESTIONS--------------------------------------------------//
     $imageTypes=array("image/jpeg","image/png");



      if(isset($_POST['update_quest_cont']))
      {
        $id=$_POST['questionId'];
    //---------------------------------------------OBJECTIVES--------------------------------------------------------------------------///
          if(isset($_POST['quest_opt1']))
          {

            $course=$_POST['quest_course'];
            $set=$_POST['quest_set'];
            $content=$_POST['update_quest_cont'];
            $opt1=$_POST['quest_opt1'];
            $opt2=$_POST['quest_opt2'];
            $opt3=$_POST['quest_opt3'];
            $opt4=$_POST['quest_opt4'];
            $opt5=$_POST['quest_opt5'];
            $answer=$_POST['quest_answ'];
            $serial=sprintf('%04x%04x%',mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff));
            if($_FILES['quest_img']['name']=='')
            {
              $result=$connection->prepare("update questions set course='{$course}' ,  Qset='{$set}' , content='{$content}' , optionA='{$opt1}' , optionB='{$opt2}' ,
                                          optionC='{$opt3}' , optionD='{$opt4}'  ,optionE='{$opt5}'  , optionBest='{$answer}' , serial='{$serial}',structureOption='' where id=$id");
              $result->execute();
              print_r($result->errorInfo());
            }
            else
            {

              if(in_array($_FILES['quest_img']['type'],$imageTypes))
              {
                 $filename=sprintf('%04x%04x%04x%04x%',mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff));
                 $name=$_FILES['quest_img']['name'];
                 $format=explode('.',$name);
                 $filename=$filename.'.'.$format[1];
                 move_uploaded_file($_FILES['quest_img']['tmp_name'],"../questionImg/".$filename);
                //  $result=$connection->prepare("insert into questions (course,Qset,content,optionA,optionB,optionC,optionD,optionE,optionBest,image,serial)
                //   values( '{$course}','{$set}','{$content}','{$opt1}','{$opt2}','{$opt3}','{$opt4}','{$opt5}','{$answer}','{$filename}','{$serial}' )  ");

                  $result=$connection->prepare( "update questions set course='{$course}' ,Qset='{$set}',content='{$content}',optionA='{$opt1}',optionB='{$opt2}',optionC='{$opt3}',optionD='{$opt4}',optionE='{$opt5}'
                                          ,optionBest='{$answer}',serial='{$serial}' ,image='{$filename}',structureOption=''    where id=$id  ");
                    $result->execute();
                      print_r($result->errorInfo());
              }
              else {
                echo 5;
              }
            }
          }
      //---------------------------------------------STRUCTURAL--------------------------------------------------------------------------///
          else {
            $course=$_POST['quest_course'];
            $set=$_POST['quest_set'];
            $content=$_POST['update_quest_cont'];
            $strAnsw=$_POST['strAnsw'];
            $serial=sprintf('%04x%04x%',mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff));
            if($_FILES['quest_img']['name']=='')
              {
                // $result=$connection->prepare("insert into questions (course,Qset,content,structureOption,serial)
                //           values('{$course}','{$set}','{$content}','{$strAnsw}','{$serial}')
                //     ");

                    $result=$connection->prepare( "update questions set course='{$course}' ,Qset='{$set}',content='{$content}',optionA='',optionB='',optionC='',optionD='',optionE=''
                                            ,optionBest='',serial='{$serial}',structureOption='{$strAnsw}'    where id=$id  ");

                    $result->execute();
                      print_r($result->errorInfo());
                }
            else
            {
              if(in_array($_FILES['quest_img']['type'],$imageTypes))
                {
                  $filename=sprintf('%04x%04x%04x%04x%',mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff),mt_rand(0,0xfff));
                 $name=$_FILES['quest_img']['name'];
                 $format=explode('.',$name);
                 $filename=$filename.'.'.$format[1];
                 move_uploaded_file($_FILES['quest_img']['tmp_name'],"../questionImg/".$filename);
                    //  $result=$connection->prepare("insert into questions (course,Qset,content,structureOption,image,serial)
                    //            values('{$course}','{$set}','{$content}','{$strAnsw}','{$filename}','{$serial}')
                    //            ");

                  $result=$connection->prepare( "update questions set course='{$course}' ,Qset='{$set}',content='{$content}',serial='{$serial}',structureOption='{$strAnsw}' ,image='{$filename}'   where id=$id  ");

                    $result->execute(); print_r($result->errorInfo());
                  }
                else
                 {
                  echo 4;
                }
            }
          }
      //    print_r($_POST);
      }

      //-----------------------------------------------------------------------UPDATING Course view-----------------------------------------------------------------------------------------//

          if(isset($_POST['viewQuestions']))
          {
              $result=searchQuestions($_POST['viewQuestions']);
               //print_r($result->errorInfo());
              foreach ($result as $key => $value):  $id=$value['id'];
              $content=$value['content'];
              $str=$value['structureOption'];
              $opt1=$value['optionA'];
              $opt2=$value['optionB'];
              $opt3=$value['optionC'];
              $opt4=$value['optionD'];
              $opt5=$value['optionE'];
              $course=$value['course'];
              $set=$value['Qset'];
              $serial=$value['serial'];
              $key++;

                echo
                "
                    <tr>
                      <td> $key </td>
                      <td><input type='checkbox' course=' $id' data='$serial' class='select' /></td>
                      <td>$course</td>
                      <td>$set</td>
                      <td>  $content</td>
                      <td>  $opt1</td>
                      <td>  $opt2</td>
                      <td>  $opt3</td>
                      <td>  $opt4</td>
                      <td>  $opt5</td>
                      <td>  $str</td>
                      <td class='button'> <div class='btn-group btn-group-xs'>
                                            <button type='button'  title='{$course}'  class='btn-primary btn edit' course='$id'>&nbsp; Edit &nbsp;</button>
                                           <button course='$id'  title='{$course}' class='btn btn-danger btn-xs delete' >Delete</button>
                                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                ";

              endforeach;
          }


    if(isset($_POST['editAdmin']))
        {
            //print_r($_POST['editAdmin']);
        }
    else if(isset($_POST['getAdmin']))
        {
            $id=$_POST['getAdmin'];
                $result=$connection->prepare("select *from admins where id={$id} limit 1");
            if($result->execute())
                {
                    $result=$result->fetchAll();
                    echo json_encode($result);
            }
        }
    else if(isset($_POST['blockAdmin']))
        {
            $id=$_POST['blockAdmin'];
            $result=$connection->prepare("update admins set access='N' where id={$id}");
            $result->execute();
            print_r($result->errorInfo());
        }
    else if(isset($_POST['allowAdmin']))
        {
            $id=$_POST['allowAdmin'];
            $result=$connection->prepare("update admins set access='Y' where id={$id}");
            $result->execute();
            print_r($result->errorInfo());
        }
else if(isset($_POST['deleteAdmin']))
        {
            $id=$_POST['deleteAdmin'];
            $result=$connection->prepare("delete from admins  where id={$id} ");
            $result->execute();
            print_r($result->errorInfo());
        }
    else if(isset($_POST['viewAdmins']))
        {
            $result=$connection->prepare("select *from admins");
            $result->execute();
            $result=$result->fetchAll();

                foreach($result as $key =>$value)
                    { $key++;
                     $name=$value['name'];
                     $gender= $value['gender'];
                     $user=$value['username'];
                     $access=$value['access'];
                     $id=$value['id'];
                     $courses=str_replace('#/',',',$value['courses']);
                    if($access=='Y')
                        {
                            echo "
                          <tr>
                            <td>$key</td>

                            <td>$name</td>
                            <td>$gender</td>
                            <td>$user</td>
                            <td>$courses</td>
                            <td><span class='label label-success'> allowed </span></td>
                            <td><div class='btn-group btn-group-xs'>
                                <button class='btn btn-default edit' data='{$id}' >Edit</button>
                                <button data='{$id}' class='btn btn-warning block '> Block </button>

                            <button class='btn btn-danger remove' data='{$id}'>Remove</button>

                                </div></td>
                        </tr>
                         ";
                        }
                     else
                     {
                         echo "
                          <tr>
                            <td>$key</td>

                            <td>$name</td>
                            <td>$gender</td>
                            <td>$user</td>
                            <td>$courses</td>
                            <td><span class='label label-danger'> Denied </span></td>
                            <td><div class='btn-group btn-group-xs'>
                                <button class='btn btn-default edit' data='{$id}' >Edit</button>
                                <button data='{$id}' class='btn btn-success allow '> Allow </button>

                            <button class='btn btn-danger remove' data='{$id}'>Remove</button>

                                </div></td>
                        </tr>
                         ";
                     }

              }

        }



?>
