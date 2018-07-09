<?php
  //  require_once("../backend/db/connect.php");
  session_start( );
    require_once("../backend/db/logins.php");
    global $connection;
    $connection=new PDO("mysql:host=$DB_SERVER; dbname=$DB_NAME",$DB_USER,$DB_PASSWORD);
    if($connection)
      {

      }
    else {
      print_r($connection->errorInfo() );
  }


    global $connection;


        function getExamSet()
            {
                global $connection;
                $result=$connection->prepare("select *from sets where publish ='Y' ");
                $result->execute();
                $result=$result->fetchAll();
                return $result;
            }

            $_SESSION['student']=array("name"=>"ALADESIUN IDOWU ADEDAMOLA" , "username"=>"highdee");


    if(isset($_POST['getsetDet']))
        {
            global $connection;
            $id=$_POST['getsetDet'];
                $result=$connection->prepare("select *from sets where publish ='Y' and id= $id limit 1");
                $result->execute();

                $result=$result->fetch();
                echo json_encode($result);
        }

    if(isset($_POST['prepare']))
        {
            $_SESSION['examSet']=$_POST['prepare'];
            $_SESSION['setid']=$_POST['setid'];
            $_SESSION['setnoq']=$_POST['noq'];
            $_SESSION['setCourse']=$_POST['course'];
            $_SESSION['setTime']=$_POST['time'];
            echo true;  
        }

    if(isset($_POST['start']))
        {
            $set=$_SESSION['examSet'];
            $setid=$_SESSION['setid'];
            $setnoq=$_SESSION['setnoq'];
            $setcourse=$_SESSION['setCourse'];

            $result=$connection->prepare("select  serial , content , optionA ,optionB,optionC,optionD,optionE,image , structureOption from
                questions where Qset='{$set}' and course='{$setcourse}' order by RAND() limit $setnoq ");
            $result->execute();
            $result=$result->fetchAll();
            echo json_encode($result);
        }
   else if(isset($_POST['getime']))
        {
            echo json_encode($_SESSION['setTime']);
        }
    else if(isset($_POST['getStudent']))
    {
        echo json_encode(array("student"=>$_SESSION['student'],"set"=>$_SESSION['examSet'], "setCourse"=>$_SESSION['setCourse']));
    }




    //----------------------------------------------------SUBMMTTING ANSWERS-------------------------------------------------------------------------//

    if(isset($_POST['submit']))
      {
        $script=$_POST['submit'];
        $answer=json_encode($script['answers']);
        $course= $script['course'];
        $set= $script['set'];
        $timeleft=$script['timeLeft'];
        $status=$script['status'];
        $timeSubmitted=date("h:i:s");
        $date=date("Y:M:d:D");
        $name=$script['student']['name'];
        $username=$script['student']['username'];
        $result=$connection->prepare("insert into result (answ,student,username,date,time,submitted,timeLeft,Qset,course,marked)
                values(:answers,:student,:username,:date,:time,:submitted,:timeleft,:set,:course,'N')");
                $result->bindParam(':answers',$answer);
                $result->bindParam(':student',$name);
                $result->bindParam(':username',$username);
                $result->bindParam(':date',$date);
                $result->bindParam(':time',$timeSubmitted);
                $result->bindParam(':submitted',$status);
                $result->bindParam(':timeleft',$timeleft);
                $result->bindParam(':set',$set);
                $result->bindParam(':course',$course);
          if($result->execute())
            {
              echo "submmitted";
            }
          else {
                print_r($result->errorInfo());
          }
      }

//----------------------------------------------------save ANSWERS-------------------------------------------------------------------------//

    if(isset($_POST['save']))
      {
        $script=$_POST['save'];
        $answer=json_encode($script['answers']);
        $course= $script['course'];
        $set= $script['set'];
        $timeleft=$script['timeLeft'];
        $status=$script['status'];
        $timeSubmitted=date("h:i:s");
        $date=date("Y:M:d:D");
        $name=$script['student']['name'];
        $username=$script['student']['username'];
        $result=$connection->prepare("insert into result_dump (answ,student,username,date,time,submitted,timeLeft,Qset,course,marked)
                values(:answers,:student,:username,:date,:time,:submitted,:timeleft,:set,:course,'N')");
                $result->bindParam(':answers',$answer);
                $result->bindParam(':student',$name);
                $result->bindParam(':username',$username);
                $result->bindParam(':date',$date);
                $result->bindParam(':time',$timeSubmitted);
                $result->bindParam(':submitted',$status);
                $result->bindParam(':timeleft',$timeleft);
                $result->bindParam(':set',$set);
                $result->bindParam(':course',$course);
          if($result->execute())
            {
              echo "submmitted";
            }
          else {
                print_r($result->errorInfo());
          }
      }


?>
