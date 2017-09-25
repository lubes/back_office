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
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);
$mysqli = new mysqli('683aa0db9a05d4e8950d0af751acc5344e9df3c3.rackspaceclouddb.com', 'esw_admin', 'Acc3557916!', 'backoffice');
    $uri = 'https://quartzevents.com/dashboard';

}

if(($mysqli->connect_errno > 0)){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

    global $mysqli; 

    if(isset($_POST['name'])) {
    $a_id = trim($_POST['id']);
    $event = $_POST["event"];
    $permission = 3;
    $name = $_POST['name'];
    $event = $_POST['event'];
    $email = $_POST['email'];
    $company= $_POST['company'];
    $job_title= $_POST['job_title'];
    $address= $_POST['address'];
    $city= $_POST['city'];
    $state= $_POST['state'];
    $zip= $_POST['zip'];
    $country= $_POST['country'];
    $alt_email  = $_POST['alt_email'];
    $direct_phone  = $_POST['direct_phone'];
    $cell_phone  = $_POST['cell_phone'];
    $fax  = $_POST['fax'];
    $website  = $_POST['website'];
    $logo_use  = $_POST['logo_user'];
    $exhibitors = implode("/,/", $_POST["exhibitors"]);
    $t_c = "yes";
    if(isset($_POST['submit_form'])) {
        $finished = '1';
    } else {
        $finished = '0';
    }
        
        
    $update = $mysqli->prepare("UPDATE attendees SET permission=?, event=?, name=?, email=?, company=?, job_title=?, address=?, city=?, state=?, zip=?, country=?, alt_email=?, direct_phone=?, cell_phone=?, fax=?, website=?, exhibitors=?, t_c=?, logo_user=?, finished=? WHERE id=?");
    $update->bind_param("iisssssssssssssssssii",$permission, $event, $name, $email, $company, $job_title, $address, $city, $state, $zip, $country, $alt_email, $direct_phone, $cell_phone, $fax, $website,  $exhibitors, $t_c, $logo_use, $finished,$a_id);
    $update->execute();
        
            //printf("Error: %s.\n", $update->error);

        
        
        $result = mysqli_query($mysqli, "SELECT * FROM fields WHERE event='$event' ORDER BY page, order_no ASC");
         while($res = mysqli_fetch_array($result)) {
            $fields[] = $res;
        }// end while
        
        foreach($fields as $field){
            $f_id = $field["id"];
            $type_id = $field["type"];
            $i_v = "";
            $s_v = "";
            $t_v = "";
            
            switch ($type_id) {
                case 1:
                    $t_v = implode('/,/',$_POST[$field["slug"]]);
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

            $meta_update = $mysqli->prepare("UPDATE attendee_meta SET 
            type=?, 
            int_value=?, 
            string_value=?, 
            text_value=? 
            WHERE attendee_id=? AND field_id=?");
                        $meta_update->bind_param("iissii", $type_id, $i_v, $s_v, $t_v, $a_id, $f_id);
            $meta_update->execute();
           // printf("Error: %s.\n", $meta_update->error);

        }
    }
?>