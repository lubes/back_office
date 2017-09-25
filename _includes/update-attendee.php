<?php
ob_start();

ini_set('session.gc_maxlifetime', 36000);
if (!isset($_SESSION)) {
  session_start();
}

setlocale(LC_MONETARY,"en_US");

$host = $_SERVER['HTTP_HOST'];
if ($host == 'localhost:8888') {
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);
$mysqli = new mysqli('localhost', 'root', 'root', 'a_quartz');
    $uri = 'http://localhost:8888/a_quartz';

} else {
$mysqli = new mysqli('683aa0db9a05d4e8950d0af751acc5344e9df3c3.rackspaceclouddb.com', 'esw_admin', 'Acc3557916!', 'backoffice');
    $uri = 'https://quartzevents.com/dashboard';

}

if(($mysqli->connect_errno > 0)){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

    global $mysqli; 

    if(isset($_POST['name'])) {
        
        if(isset($_POST['submit_form'])) { 
            $finished = '1';
        } else {
            $finished = '0';
        }
        $event = $_POST["event"];
        $result = mysqli_query($mysqli, "SELECT * FROM fields WHERE event='$event' ORDER BY page, order_no ASC");
         while($res = mysqli_fetch_array($result)) {
            $fields[] = $res;
        }// end while
        
        
        foreach($fields as $field){
            $a_id = trim($_POST['id']);
            $f_id = $field["id"];
            $type_id = $field["type"];
            $i_v = "";
            $s_v = "";
            $t_v = "";
            
            switch ($type_id) {
                case 1:
                    $t_v = implode(',',$_POST[$field["slug"]]);
                    break;
                case 2:
                    $s_v = $_POST[$field["slug"]];
                    break;
                case 3:
                    $s_v = $_POST[$field["slug"]];
                    break;
                case 4:
                    $t_v = $_POST[$field["slug"]];
                    break;
                case 5:
                    if($_POST[$field["slug"]] == "yes"){
                        $i_v = 1;
                    } else {
                        $i_v = 0;
                    }
                    break;
            }

            $insert = $mysqli->prepare("INSERT INTO attendee_meta(attendee_id, field_id, type, int_value, string_value, text_value) VALUES(?,?,?,?,?,?)");
            $insert->bind_param("iiiiss",$a_id, $f_id, $type_id, $i_v, $s_v, $t_v);
            $insert->execute();

        }
      var_dump($fields);       
    } 
?>