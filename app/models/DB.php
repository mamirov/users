<?php
class DB{

    public $db_user = 'root';
    public $db_password = '';
    public $db_name = 'users';
    public $host = 'localhost';

    public $admin_email = 'root@example.com';


    public function connect(){

        $dbh = mysql_connect($this->host, $this->db_user, $this->db_password) or die("Не могу соединиться с MySQL.");
        mysql_select_db($this->db_name) or die("Не могу подключиться к базе.");

    }

    public function findAll($table_name){

        $all = mysql_query("select * from `$table_name`");
        $data_array = array();

        while($user = mysql_fetch_assoc($all)){
            $data_array[$user['user_name']] = $user['password'];
        }

        return $data_array;
    }


    public function deleteById($id,$table_name){
        $sql = "DELETE FROM `$table_name` where id='$id'";
            if(!mysql_query($sql)){echo "<script>alert('Ошибка удаления');</script>";}
    }

    public function deleteByAttribute($attribute,$param,$table_name){
        $sql = "DELETE FROM `$table_name` where $attribute='$param'";
            if(!mysql_query($sql)){echo "<script>alert('Ошибка удаления');</script>";}
    }


    public function addUser($login,$password){
        $sql = "INSERT INTO users (user_name, password, email) VALUES('$login','$password','$login@example.com')";

        if(!mysql_query($sql)){echo "<script>alert('Ошибка добавления');</script>";}
    }


    public function updateByAttribute($attribute,$param,$table_name,$find_attribute,$find_param){

        $sql = "UPDATE `$table_name` set $attribute = '$param' WHERE $find_attribute = '$find_param';";
            if(!mysql_query($sql)){echo "<script>alert('Ошибка изменения');</script>";}
    }



    public function usersReporting($update_users,$remove_users,$add_users){

        $message = "\nУдалены:\r";
        $message.=$remove_users;

        $message.= "\nОбновлены:\r";
        $message.=$update_users;

        $message.= "\nДобавлены:\r";
        $message.=$add_users;

        mail($this->admin_email, 'Отчет о пользователях', $message);
        echo"<div class='container';>
                <div class='row'>
                     <div class='col-sm-6 col-lg-offset-3'>
                        <pre>
                            $message
                        </pre>
                    </div>

                </div>
            </div>";

    }




}