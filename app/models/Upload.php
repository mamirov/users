<?php


class Upload{

    static function UploadFile($file){
        $dir = 'data/xml_base/users.xml';

        if (move_uploaded_file($file, $dir)) {
            echo "<script>alert('файл успешно загружен');</script>";


        } else {
            echo "<script>alert('что то пошло не так');</script>";
        }
    }



// text/xml


}