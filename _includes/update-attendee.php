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

    if(isset($_POST['name'])) {
        $id = $_POST['id'];
        $event = $_POST['event'];
        $name = $_POST['name'];
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
        $logo_use  = $_POST['logo_user'];
        if(isset($_POST['submit_form'])) { 
            $finished = '1';
        } else {
            $finished = '0';
        }
        $result = mysqli_query($mysqli, "UPDATE attendees SET
            name='$name',
            email='$email',
            company='$company',
            job_title='$job_title',
            address='$address',
            city='$city',
            state='$state',
            zip='$zip',
            country='$country',
            alt_email='$alt_email',
            direct_phone='$direct_phone',
            cell_phone='$cell_phone',
            fax='$fax',
            website='$website',
            track='$track',
            revenue='$revenue',
            company_size='$company_size',
            industry='$industry',
            scheduling='$schedule',
            erp='$erp',
            geo='$geo',
            warehouse='$warehouse',
            number_facilities='$number_facilities',
            facility_responsibilities='$facility_responsibilities',
            facilities_size='$facilities_size',
            facilities_equipment_interest='$facilities_equipment_interest',
            facilities_software_interest='$facilities_software_interest',
            facilities_projects='$facilities_projects',
            transportation_responsibility='$transportation_responsibility',
            ftl='$ftl',
            ltl='$ltl',
            intermodel='$intermodel',
            parcel='$parcel',
            modes_transporation='$modes_transporation',
            tansportation_interest='$tansportation_interest',
            transportation_projects='$transportation_projects',
            threepls='$threepls',
            footprint='$footprint',
            threepl_interest='$threepl_interest',
            threepl_projects='$threepl_projects',
            supply_responsibility='$supply_responsibility',
            supply_services='$supply_services',
            supply_projects='$supply_projects',
            procurement='$procurement',
            procurement_projects='$procurement_projects',
            procurement_interest='$procurement_interest',
            t_c='$t_c',
            logo_user='$logo_user',
            finished='$finished'
            WHERE id='$id'
        ");   
    } 
?>