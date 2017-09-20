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
$mysqli = new mysqli('localhost', 'qa_user', 'Acc3557916!', 'qa_test_db');
    $uri = 'http://qa.esw.me';
}

if(($mysqli->connect_errno > 0)){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

    global $mysqli; 
    global $uri; 
    // $event_id = $_GET['event'];
    if(isset($_POST['name'])) {
        $id = $_POST['id'];
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
        $revenue  = $_POST['revenue'];
        $company_size  = $_POST['company_size'];
        $track = $_POST['track'];
        $industry  = $_POST['industry'];
        $scheduling  = $_POST['scheduling'];
        $erp  = $_POST['erp'];
        $geo  = $_POST['geo'];
        $warehouse  = $_POST['warehouse'];
        $number_facilities  = $_POST['number_facilities'];
        $facility_responsibilities  = $_POST['facility_responsibilities'];
        $facilities_size  = $_POST['facilities_size'];
        $facilities_equipment_interest  = $_POST['facilities_equipment_interest'];
        $facilities_software_interest  = $_POST['facilities_software_interest'];
        $facilities_projects  = $_POST['facilities_projects'];
        $transportation_responsibility  = $_POST['transportation_responsibility'];
        $ftl  = $_POST['ftl'];
        $ltl  = $_POST['ltl'];
        $intermodel  = $_POST['intermodel'];
        $parcel  = $_POST['parcel'];
        $modes_transporation  = $_POST['modes_transporation'];
        $tansportation_interest  = $_POST['tansportation_interest'];
        $transportation_projects  = $_POST['transportation_projects'];
        $threepls  = $_POST['threepls'];
        $footprint  = $_POST['footprint'];
        $threepl_interest  = $_POST['threepl_interest'];
        $threepl_projects  = $_POST['threepl_projects'];
        $supply_responsibility  = $_POST['supply_responsibility'];
        $supply_services  = $_POST['supply_services'];
        $supply_projects  = $_POST['supply_projects'];
        $procurement  = $_POST['procurement'];
        $procurement_projects  = $_POST['procurement_projects'];
        $procurement_interest  = $_POST['procurement_interest'];
        // $t_c  = $_POST['t_c'];
        $logo_use  = $_POST['logo_user'];
        
        if(isset($_POST['submit_form'])) {
            $finished = '1';
        } else {
            $finished = '0';
        }
        
        $result = $mysqli->query("INSERT INTO attendees(
            id,
            permission,
            event,
            name,   
            email,
            company,
            job_title,
            address,
            city,
            state,
            zip,
            country,
            alt_email,
            direct_phone,
            cell_phone,
            fax,
            website,
            track,
            revenue,
            company_size,
            industry,
            scheduling,
            erp,
            geo,
            warehouse,
            number_facilities,
            facility_responsibilities,
            facilities_size,
            facilities_equipment_interest,
            facilities_software_interest,
            facilities_projects,
            transportation_responsibility,
            ftl,
            ltl,
            intermodel,
            parcel,
            modes_transporation,
            tansportation_interest,
            transportation_projects,
            threepls,
            footprint,
            threepl_interest,
            threepl_projects,
            supply_responsibility,
            supply_services,
            supply_projects,
            procurement,
            procurement_projects,
            procurement_interest,
            t_c,
            logo_user,
            finished
        )VALUES(
            '$id',
            '3',
            '$event',
            '$name',   
            '$email',
            '$company',
            '$job_title',
            '$address',
            '$city',
            '$state',
            '$zip',
            '$country',
            '$alt_email',
            '$direct_phone',
            '$cell_phone',
            '$fax',
            '$website',
            '$track',
            '$revenue',
            '$company_size',
            '$industry',
            '$scheduling',
            '$erp',
            '$geo',
            '$warehouse',
            '$number_facilities',
            '$facility_responsibilities',
            '$facilities_size',
            '$facilities_equipment_interest',
            '$facilities_software_interest',
            '$facilities_projects',
            '$transportation_responsibility',
            '$ftl',
            '$ltl',
            '$intermodel',
            '$parcel',
            '$modes_transporation',
            '$tansportation_interest',
            '$transportation_projects',
            '$threepls',
            '$footprint',
            '$threepl_interest',
            '$threepl_projects',
            '$supply_responsibility',
            '$supply_services',
            '$supply_projects',
            '$procurement',
            '$procurement_projects',
            '$procurement_interest',
            '1',
            '$logo_use',
            '$finished'
        )");
        
        $last_id = $mysqli->insert_id;
        
        $result_2 = $mysqli->query("INSERT INTO exhibitors_meta(attendee_id) VALUES('$last_id')");
      
        // Send Custom Field Values into Form
        // Chimmy Help
        foreach($_POST["question_"] as $key => $value){
            echo $value;
            $result_3 = mysqli_query($mysqli, "INSERT INTO attendee_meta(attendee_id,question, answer) VALUES('$last_id','$key', '$value')");
        } 
                    
        ?>
        <?php
    }
