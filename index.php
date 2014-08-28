<?php
error_reporting(E_ALL);
require_once('app/models/Upload.php');
require_once('app/models/DB.php');
header('Content-Type: text/html; charset=utf-8');
?>

<html>


<head>
    <link rel="stylesheet" href="/css/bootstrap.css"/>
    <script src="/js/jquery-ui-1.8.23.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <title>Upload users from xml</title>
</head>


<body>

<div class="container">
    <div class="jumbotron" style="margin-top: 150px">
        <h1>Upload users from xml</h1>

        <div class="row">
            <form action="" method="post" enctype="multipart/form-data">

                <input name="Users[xml]" type="file" style="margin-bottom: 15px"/>

                <input type="submit" class="btn btn-lg btn-success" value="загрузить..."/>

            </form>
        </div>
    </div>
</div>


<?php

    if (!empty($_FILES['Users'])){

        if($_FILES['Users']['type']['xml'] == 'text/xml'){

            Upload::UploadFile($_FILES['Users']['tmp_name']['xml']);

            $xml_data = file_get_contents('data/xml_base/users.xml');
            $xml = new SimpleXMLElement($xml_data);

            $update_user_reporting = '';
            $delete_user_reporting = '';
            $insert_user_reporting = '';

            $users = array();
            foreach($xml as $item){
                $item = (array)$item;
                $users[$item['login']] = $item['password'];
            };

            $DB = new DB();
            $DB->connect();
            $db_users = $DB->findAll('users');

            foreach($users as $login=>$password){

                if(!array_key_exists($login,$db_users)){

                    $insert_user_reporting.="$login\r\n";
                    $DB->addUser($login,$password);
                }else{
                    if($password != $db_users[$login]){
                        $update_user_reporting.="$login\r\n";
                        $DB->updateByAttribute('password',$password,'users','password',$db_users[$login]);
                    }
                }
            }


            foreach($db_users as $login=>$password){

                if(!array_key_exists($login,$users)){

                    $delete_user_reporting.="$login\r\n";

                    $DB->deleteByAttribute('user_name',$login,'users');
                }
            }


            $DB->usersReporting($update_user_reporting,$delete_user_reporting,$insert_user_reporting);

        }else{
            echo "<script>alert('Неверный формат файла');</script>";
        }
    }
?>
</body>

</html>