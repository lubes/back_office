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
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=attendee-export.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
// output the column headings

global $mysqli; 
global $uri; 
$event = $_GET["event"];

$select_fields = mysqli_query($mysqli, "SELECT * FROM fields WHERE event='$event' ORDER BY page, order_no ASC");

$select_exhibitors = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE event='$event' AND active=1 ORDER BY name ASC");


$columns =array("Date","ID","Invite","Name","Email","Company", "Job Title", "Address", "City", "State", "Zip","Country", "Phone", "Cell Phone", "Website");

while($res = mysqli_fetch_array($select_fields)) {
    $fields[] =$res;
    if($res["type"] == 1) { 
        $text = trim($res['options']); 
        $textAr = explode("\n", $text);
        $textAr = array_filter($textAr, 'trim'); 
        foreach ($textAr as $list) {
            $list = trim(str_replace(array("\n", "\t", "\r"), '', $list));
            if($list){
                $columns[] = $res["title"] . " - " . $list;
                $options[$res["id"]][] = $list;
            }
        }
    } else {
        $columns[] = $res["title"];
    }

}

while($exhibitor = mysqli_fetch_array($select_exhibitors)) {
    $columns[] = $exhibitor["name"];
    $exhibitors[] = $exhibitor;
} 
fputcsv($output, $columns);

if($_GET["view"] == "unfinished"){
    $select = mysqli_query($mysqli, "SELECT * FROM attendees WHERE event=$event AND `approved` = 0");
} else  if($_GET["view"] == "set" ){ 
    $ids = $_GET["ids"];
    $select = mysqli_query($mysqli, "SELECT * FROM attendees WHERE event=$event AND id in ($ids)");

} else {
    $select = mysqli_query($mysqli, "SELECT * FROM attendees WHERE event=$event AND `approved` = 1");
}


while($attendee = mysqli_fetch_array($select)) {          
    // Get Standar Fields

    $row = array($attendee["registration_date"], $attendee["id"], $attendee["invitation_number"], $attendee["name"], $attendee["email"], $attendee["company"], $attendee["job_title"], $attendee["address"], $attendee["city"], $attendee["state"], $attendee["zip"], $attendee["country"], $attendee["direct_phone"], $attendee["cell_phone"], $attendee["website"] );

    // Get Meta Fields

    $metas = mysqli_query($mysqli, "SELECT * FROM attendee_meta WHERE attendee_id=$attendee[id]");

    while($meta = mysqli_fetch_array($metas)){
        $meta_data[$meta["field_id"]] = $meta;
    }
    foreach($fields as $key => $field){             
        switch ($field["type"]) {
            case 1:
                $listed = array_map('trim', explode('/,/',$meta_data[$field["id"]]["text_value"]));
                //var_dump($options);
                foreach($options[$field["id"]] as $key => $option){
                    if(in_array($option,$listed)){
                        $row[] = "x";
                    } else {
                        $row[] = "";
                    }
                }
                break;
            case 2:
                $row[] = $meta_data[$field["id"]]["string_value"];
                break;
            case 3:
                $row[] = $meta_data[$field["id"]]["string_value"];
                break;
            case 4:
                $row[] = $meta_data[$field["id"]]["text_value"];
                break;
            case 5:
                $row[] = $meta_data[$field["id"]]["int_value"];
                break;
        }
    }

    foreach($exhibitors as $key => $exhibitor){
        $listed = array_map('trim', explode('/,/',$attendee["exhibitors"]));


        if(in_array($exhibitor["name"],$listed)){
            $row[] = "x";
        } else {
            $row[] = "";
        } 


    }




    // var_dump($row);



    fputcsv($output, $row);



}




?>