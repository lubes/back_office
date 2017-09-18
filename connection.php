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

/******* LOGIN **********/

// Login Admin
function login_admin() {
    global $mysqli;
    global $uri;
    $user = mysqli_real_escape_string($mysqli, $_POST['email']);
    $pass = mysqli_real_escape_string($mysqli, $_POST['password']);
    if($user == "" || $pass == "") {
        echo "Either username or password field is empty.";
    } else {
        $result = mysqli_query($mysqli, "SELECT * FROM admin WHERE email='$user' AND password=md5('$pass')")
   or die("Could not execute the select query.");
        $row = mysqli_fetch_assoc($result);
        if(is_array($row) && !empty($row)) {
            $validuser = $row['email'];
            $_SESSION['valid'] = $validuser;
            $_SESSION['id'] = $row['id'];
            $_SESSION['permission'] = $row['permission'];
        } else {
            echo "Invalid username or password.";
        }
        if(isset($_SESSION['valid'])) { 
            header('Location: ./admin');
        }
    }   
}

// Login Exhibitor
function login_exhibitor() {
    global $mysqli;
    global $uri;
    $user = mysqli_real_escape_string($mysqli, $_POST['username']);
    $pass = mysqli_real_escape_string($mysqli, $_POST['password']);

    if($user == "" || $pass == "") {
        echo "Either username or password field is empty.";
    } else {
        $result = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE username='$user' AND password=md5('$pass')")
   or die("Could not execute the select query.");
        $row = mysqli_fetch_assoc($result);
        if(is_array($row) && !empty($row)) {
            $validuser = $row['username'];
            $_SESSION['valid'] = $validuser;
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['event'] = $row['Event'];
            $_SESSION['brand'] = $row['brand'];
            $_SESSION['permission'] = $row['permission'];
        } else {
            echo "Invalid username or password.";
        }
        if(isset($_SESSION['valid'])) { 
            header('Location: ./exhibitor/?id='.$_SESSION['id'].'');
        }
    }   
}

// Login Attendee
function login_attendee() {
    global $mysqli;
    global $uri;
    $user = mysqli_real_escape_string($mysqli, $_POST['email']);
    $pass = mysqli_real_escape_string($mysqli, $_POST['password']);
    if($user == "" || $pass == "") {
        echo "Either username or password field is empty.";
    } else {
        $result = mysqli_query($mysqli, "SELECT * FROM attendees WHERE email='$user' AND password='$pass'")
   or die("Could not execute the select query.");
        $row = mysqli_fetch_assoc($result);
        if(is_array($row) && !empty($row)) {
            $validuser = $row['email'];
            $_SESSION['valid'] = $validuser;
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['event'] = $row['Event'];
            $_SESSION['brand'] = $row['brand'];
            $_SESSION['permission'] = $row['permission'];
            
        } else {
            echo "Invalid username or password.";
        }
        if(isset($_SESSION['valid'])) { 
            header('Location: ./attendee/?id='.$_SESSION['id'].'');
        }
    }   
}

// Permissions
function admin_access() {
    $_SESSION['permission']==1;
}

function exhibitor_access() {
    $_SESSION['permission']==2;
}

function attendee_access() {
    $_SESSION['permission']==3;
}

function user_name($user,$plural) {
    global $mysqli; 
    global $uri;
    // 
    
    if($_SESSION['permission']==1) {
        $user = $_GET['id'];
    } else {
        $user = $_SESSION['id'];
    }
    
    $result = mysqli_query($mysqli, "SELECT name FROM $plural WHERE id=$user");
    while($res = mysqli_fetch_array($result)) {  ?>
    <?php echo $res['name'];?>
    <?php }
}

/******* Navbar **********/

function user_welcome() {
    global $mysqli; 
    global $uri;
    $user = $_SESSION['id'];
    $result = mysqli_query($mysqli, "
    SELECT uploads.exhibitor_id, uploads.file AS upload_logo, exhibitors.id, exhibitors.name AS name FROM exhibitors  
    LEFT JOIN uploads ON exhibitors.id = uploads.exhibitor_id 
    WHERE exhibitors.id='$user'
    ");?>
    <div class="welcome">
        <?php while($res = mysqli_fetch_array($result)) {?>
        <?php if($res['upload_logo']) { ?>
            <div class="brand-icon" style="background: #f7f7f7 url('<?php echo $uri;?>/uploads/<?php echo $res['upload_logo'];?>') no-repeat center;background-size: cover;"></div>
        <?php } else { ?>
            <div class="brand-icon" style="background: #f7f7f7 url('<?php echo $uri;?>/uploads/user-logo.png') no-repeat center;background-size: cover;"></div>
        <?php } ?>
        <p><?php echo $res['name'];?></p>
    </div> 
    <?php } 
}

function user_welcome_attendee() {
    global $mysqli; 
    global $uri;
    $user = $_SESSION['id'];
    $result = mysqli_query($mysqli, "
    SELECT uploads.attendee_id, uploads.file AS upload_logo, attendees.id, attendees.name AS name FROM attendees  
    LEFT JOIN uploads ON attendees.id = uploads.attendee_id 
    WHERE attendees.id='$user'
    ");?>
    <div class="welcome">
        <?php while($res = mysqli_fetch_array($result)) {?>
        <?php if($res['upload_logo']) { ?>
            <div class="brand-icon" style="background: #f7f7f7 url('<?php echo $uri;?>/uploads/<?php echo $res['upload_logo'];?>') no-repeat center;background-size: cover;"></div>
        <?php } else { ?>
            <div class="brand-icon" style="background: #f7f7f7 url('<?php echo $uri;?>/uploads/user-logo.png') no-repeat center;background-size: cover;"></div>
        <?php } ?>
        <p><?php echo $res['name'];?></p>
    </div> 
    <?php } 
}

// All Events/Brands for Navigation
function events_nav() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "
    SELECT quartz_event.*, quartz_event.id AS q_ev_id, quartz_event.status AS status, quartz_event.ranking AS ranking, events.id, events.name AS event_name, brands.id, brands.name AS brand_name, brands.name 
    FROM quartz_event, events, brands
    WHERE quartz_event.Event = events.id AND quartz_event.brand = brands.id   
    ");?>
    <a class="nav-link"  href="#" data-toggle="modal" data-target="#newEvent">Add New</a>
    <?php while($res = mysqli_fetch_array($result)) { ?>
        <a class="nav-link" href="<?php echo $uri;?>/events/?event=<?php echo $res['q_ev_id'];?>"><?php echo $res['brand_name'];?> <?php echo $res['event_name'];?></a>
    <?php } ?>
    <?php
}

// All Brands for Navigation
function brands_nav() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "
    SELECT * FROM brands   
    ");?>
    <a class="nav-link"  href="#" data-toggle="modal" data-target="#newBrand">Add New</a>
    <?php while($res = mysqli_fetch_array($result)) { ?>
        <a class="nav-link" href="<?php echo $uri;?>/admin/brand/?brand=<?php echo $res['id'];?>"><?php echo $res['name'];?></a>
    <?php } 
}

// All Brands for Navigation
function events_cat_nav() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "
    SELECT * FROM events  
    ");?>
    <a class="nav-link"  href="#" data-toggle="modal" data-target="#newSeason">Add New</a>
    <?php while($res = mysqli_fetch_array($result)) { ?>
        <a class="nav-link" href="<?php echo $uri;?>/admin/event/?event=<?php echo $res['id'];?>"><?php echo $res['name'];?></a>
    <?php } 
}

/******* Quarts Events **********/

function count_attendees() {
    global $mysqli; 
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "
    SELECT event FROM attendees WHERE event='$event'");
    $num_rows = mysqli_num_rows($result);?>
    <p class="count"><?php echo $num_rows;?> Attendees</p>
<?php
}

function count_exhibitors() {
    global $mysqli; 
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "
    SELECT event FROM exhibitors WHERE event='$event'");
    $num_rows = mysqli_num_rows($result);?>
    <p class="count"><?php echo $num_rows;?> Exhibitors</p>
<?php
}

// All Quartz Events
function all_quartz_events() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "
    SELECT quartz_event.*, quartz_event.id AS event_id, quartz_event.status AS status, quartz_event.ranking AS ranking, events.id, events.name AS event_name, brands.id, brands.name AS brand_name, brands.name 
    FROM quartz_event, events, brands
    WHERE quartz_event.Event = events.id AND quartz_event.brand = brands.id ORDER BY event_id ASC
    ");?>

    <table class="table table-responsive table-bordered">
        <thead>
            <th>Status</th>
            <th>Ranking</th>
            <th>Event</th>
            <th>Date</th>
            <th>Attendees</th>
            <th>Exhibitors</th>
            <th></th>
        </thead>
        <tbody>
            <?php while($res = mysqli_fetch_array($result)) { ?>
            
<?php $ev_id=$res['event_id'];?>
<?php $count_attendees = mysqli_query($mysqli, "SELECT event FROM attendees WHERE event='$ev_id'"); $num_rows = mysqli_num_rows($count_attendees);?>   
<?php $count_exhibitors = mysqli_query($mysqli, "SELECT event FROM exhibitors WHERE event='$ev_id'"); $ex_count = mysqli_num_rows($count_exhibitors);?>

                <tr>
                   <td>
                       <span class="active-state <?php if($res['status']==1) { echo 'active'; }?>"><i class="material-icons">check</i></span>    
                   </td>
                   <td>
                       <span class="active-state <?php if($res['ranking']==1) { echo 'active'; }?>"><i class="material-icons">check</i></span>    
                   </td>
                   <td><a href="<?php echo $uri;?>/events/?event=<?php echo $res['event_id'];?>"><?php echo $res['brand_name'];?> <?php echo $res['event_name'];?></a></td>
                   <td><?php echo $res['date'];?></td>
                    <td><?php echo $num_rows;?></td>
                    <td><?php echo $ex_count;?></td>
                   <td>
                       <div class="btn-group float-right">
                           <a href="<?php echo $uri;?>/events/?event=<?php echo $res['event_id'];?>" class="btn btn-info btn-sm">View</a>
                            <a href="<?php echo $uri;?>/admin/edit/?event=<?php echo $res['event_id'];?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?php echo $uri;?>/events/delete.php?id=<?php echo $res['event_id'];?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-sm btn-danger">Delete</a>   
                       </div>
                   </td>
                </tr>
            <?php } ?>    
        </tbody>
    </table>
<?php
}

/******* Brands **********/

// All Brands
function all_brands() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "SELECT * FROM brands");
        while($res = mysqli_fetch_array($result)) { ?>
        <tr>
            <td><?php echo $res['name'];?></td>
            <td>
               <div class="btn-group float-right">
                    <a href="<?php echo $uri;?>/admin/brand/?brand=<?php echo $res['id'];?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?php echo $uri;?>/admin/brand/delete.php?id=<?php echo $res['id'];?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
               </div>
            </td>
        </tr>   
    <?php } 
}

// All Brands
function all_seasons() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "SELECT * FROM events");
        while($res = mysqli_fetch_array($result)) { ?>
        <tr>
            <td><?php echo $res['name'];?></td>
            <td>
               <div class="btn-group float-right">
                    <a href="<?php echo $uri;?>/admin/event/?event=<?php echo $res['id'];?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?php echo $uri;?>/admin/event/delete.php?id=<?php echo $res['id'];?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
               </div>
            </td>
        </tr>   
    <?php } 
}

// New Brand
function add_brand() {
    global $mysqli; 
    global $uri;
    if(isset($_POST['add_brand'])) {
        $name = $_POST['name'];
        $result = mysqli_query($mysqli, "INSERT INTO brands(name) VALUES('$name')");
        echo "<meta http-equiv='refresh' content='0'>"; 
    } ?> 
    <form  method="post" action="">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" name="add_brand" value="Create Brand">
        </div>
    </form>
<?php 
}

// All Brands
function edit_brand() {
    global $mysqli; 
    global $uri;
    $brand = $_GET['brand'];
    $result = mysqli_query($mysqli, "
    SELECT * FROM brands WHERE id='$brand'
    ");
    
    // SELECT * FROM brands WHERE id='$brand'
    
    if(isset($_POST['edit_brand'])) {
        $name = $_POST['name'];
        $event = $_POST['Event'];
        $result = mysqli_query($mysqli, "UPDATE brands SET name='$name' WHERE id='$brand'");
        header('Location: ../');
    } 
    while($res = mysqli_fetch_array($result)) { ?>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <form  method="post" action="">
   <div class="form-group">
       <label>Brand Name</label>
       <input class="form-control" name="name" value="<?php echo $res['name'];?>">
   </div>
   <div class="form-group">
       <input type="submit" class="btn btn-success" name="edit_brand" value="Save">
   </div>
                </form>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <?php upload_logo();?>
            </div>
        </div>
    <?php }
}

        
/******* Events **********/

// New Event
function add_event() {
    global $mysqli; 
    global $uri;
    if(isset($_POST['add_event'])) {
        $brand = $_POST['brand'];
        $event = $_POST['Event'];
        $title = $_POST['title'];
        $ranking = $_POST['ranking'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $copy_form = $_POST['event'];
        $instructions = $_POST['instructions'];
        $result = mysqli_query($mysqli, "INSERT INTO quartz_event(brand, Event, title, ranking, status, date, instructions) VALUES('$brand', '$event', '$title', '$ranking', '$status', '$date', '$instructions')");
        
        $last_id = $mysqli->insert_id;
        
        $result_2 = mysqli_query($mysqli, "
        INSERT INTO forms
          ( event, title, form_type, intro, subject_registrant, message_registrant, thank_you_message, t_c, rules, meetings, subject_admin, message_admin, from_email )
            SELECT '$last_id', title, form_type, intro, subject_registrant, message_registrant, thank_you_message, t_c, rules, meetings, subject_admin, message_admin, from_email 
            FROM forms WHERE event = '$copy_form'
        ");
    
        $result_2 = mysqli_query($mysqli, "
        INSERT INTO fields ( event, active, order_no, title, description, slug, type, options, required, has_options, conditional_child ) SELECT '$last_id', active, order_no, title, description, slug, type, options, required, has_options, conditional_child FROM fields WHERE event='$copy_form'
        ");
        
        echo "<meta http-equiv='refresh' content='0'>"; 
        
    } ?>
    <form  method="post" action="">
        <div class="form-group">
            <label>Event Title</label>
            <input type="text" class="form-control" name="title"  />
        </div>
        <div class="form-group">
           <label>Brand</label>
           <?php brand_select();?>
        </div>
        <div class="form-group">
           <label>Season</label>
           <?php event_cat_select();?>
        </div>
        <div class="form-group">            
            <label>Active Event?</label>
            <div class="btn-group" data-toggle="buttons">
                 <label class="btn btn-secondary">
                   <input type="radio" name="status" id="option1" value="1" autocomplete="off">Yes
                 </label>
                 <label class="btn btn-secondary">
                   <input type="radio" name="status" id="option1" value="0" autocomplete="off">No
                 </label>
            </div> 
        </div> 
        <div class="form-group">            
            <label>Ranking</label>
            <div class="btn-group" data-toggle="buttons">
                 <label class="btn btn-secondary">
                   <input type="radio" name="ranking" id="option2" value="1" autocomplete="off">On
                 </label>
                 <label class="btn btn-secondary">
                   <input type="radio" name="ranking" id="option2" value="0" autocomplete="off">Off
                 </label>
            </div> 
        </div>

        <div class="form-group">
            <label>Event Date</label>
            <input type="date" class="form-control" name="date"  />
        </div>
        <div class="form-group">
            <label>URL for Instructions</label>
            <input type="text" class="form-control" name="instructions"  />
        </div>
        
        <div class="form-group">
            <label>Copy Form Fields from Event:</label>
            <?php event_select();?>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-success" name="add_event" value="Create Event">
        </div>
    </form>
<?php 
}

// All Events
function all_events() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "SELECT * FROM events");?>
    <table class="table table-responsive table-bordered">
        <thead>
            <th>Status</th>
            <th>Event</th>
            <th>Date</th>
            <th></th>
        </thead>
        <tbody>
            <?php while($res = mysqli_fetch_array($result)) { ?>
                <tr>
                <td>
   <span class="active-state <?php if($res['active']==1) { echo 'active'; }?>"><i class="material-icons">check</i></span>    
                </td>
                <td><?php echo $res['name'];?></td>
                <td><?php echo $res['date'];?></td>
                <td>
   <div class="btn-group float-right">
   <a href="<?php echo $uri;?>/admin/event/?event=<?php echo $res['id'];?>" class="btn btn-warning btn-sm">Edit</a><a href="<?php echo $uri;?>/event/?event=<?php echo $res['id'];?>" class="btn btn-danger btn-sm">Delete</a>
   </div>    
   </td>
                </tr>
            <?php } ?>    
        </tbody>
    </table>
<?php
}

// Edit Event
function edit_event() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "SELECT * FROM events WHERE id='$event'");
    if(isset($_POST['edit_brand'])) {
        $name = $_POST['name'];
        $result = mysqli_query($mysqli, "UPDATE events SET name='$name' WHERE id='$event'");
        header('Location: ../');
    } 
    while($res = mysqli_fetch_array($result)) { ?>
        <form  method="post" action="">
            <div class="form-group">
                <label>Event Name</label>
                <input class="form-control" name="name" value="<?php echo $res['name'];?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" name="edit_brand" value="Save">
            </div>
        </form>
    <?php }
}

// New Season
function add_season() {
    global $mysqli; 
    global $uri;
    if(isset($_POST['add_season'])) {
        $name = $_POST['name'];
        $year = $_POST['year'];
        $season = $_POST['season'];
        $result = mysqli_query($mysqli, "INSERT INTO events(name, year, season, login_id) VALUES('$name', '$year', '$season', '1')");
        echo "<meta http-equiv='refresh' content='0'>"; 
    } ?> 
    <form  method="post" action="">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" />
        </div>
        <div class="form-group">
            <label>Season</label>
            <input type="text" name="season" class="form-control" />
        </div>
        <div class="form-group">
            <label>Year</label>
            <input type="text" name="year" class="form-control" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" name="add_season" value="Create Season">
        </div>
    </form>
<?php 
}

/*
// Event Name
function event_name() {
    global $mysqli; 
    $event = $_GET['event'];
    $brand = $_GET['brand'];
    $brand_res = mysqli_query($mysqli, "SELECT * FROM brands WHERE id='$brand';");
    $event_res = mysqli_query($mysqli, "SELECT * FROM events WHERE id='$event';");
    while($res = mysqli_fetch_array($brand_res)) { echo $res['name']; echo ' ';}
    while($res = mysqli_fetch_array($event_res)) { echo $res['name'];}
}

*/


// Event Name
function event_name() {
    global $mysqli; 
    $event = $_GET['event'];
    $brand_res = mysqli_query($mysqli, "
    SELECT quartz_event.id, quartz_event.title AS event_title, quartz_event.Event, quartz_event.brand, events.id, events.name AS event_name, brands.id, brands.name AS brand_name
    FROM quartz_event
    LEFT JOIN events ON quartz_event.Event = events.id
    LEFT JOIN brands ON quartz_event.brand = brands.id
    WHERE quartz_event.id = '$event'
    ");
    while($res = mysqli_fetch_array($brand_res)) { echo $res['brand_name']; echo ' '; echo $res['event_title'];  echo ' '; echo $res['event_name'];}
}


// Seasons Name
function season_name() {
    global $mysqli; 
    $event = $_GET['event'];
    $brand = $_GET['brand'];
    $brand_res = mysqli_query($mysqli, "SELECT * FROM brands WHERE id='$brand';");
    $event_res = mysqli_query($mysqli, "SELECT * FROM events WHERE id='$event';");
    while($res = mysqli_fetch_array($event_res)) { echo $res['name'];}
}

// Events Select Button
function event_select() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "
    SELECT quartz_event.*, quartz_event.id AS ev_id, events.id, events.name AS event_name, brands.id, brands.name AS brand_name, brands.name 
    FROM quartz_event, events, brands
    WHERE quartz_event.Event = events.id AND quartz_event.brand = brands.id   
    ");
    echo '<div class="select-wrap">';?>
    <select class="form-control" name="event">
    <?php 
    while($res = mysqli_fetch_array($result)) { 
        $event_name = $res['event_name'];
        $brand_name = $res['brand_name'];
        $brand_id = $res['brand_id'];
        $event_id = $res['event_id'];
        $ev_id = $res['ev_id'];
        ?>
            <option value="<?php echo $ev_id;?>"><?php echo $brand_name;?> <?php echo $event_name;?></option>  
        <?php
    }
    echo '</select></div>';
}

// Events Select Button
function event_cat_select() {
    global $mysqli; 
    $brand = $_GET['brand'];
    $result = mysqli_query($mysqli, "SELECT * FROM events");
    echo '<div class="select-wrap"><select name="Event" class="form-control">';
    while($res = mysqli_fetch_array($result)) { ?>
        <option value="<?php echo $res['id'];?>" <?php if($res['brand_id']==$brand) { echo 'selected';}?>><?php echo $res['name'];?></option>  
    <?php
    }
    echo '</select></div>';
}

// Brand Select Button
function brand_select() {
    global $mysqli; 
    $result = mysqli_query($mysqli, "SELECT * FROM brands");
    echo '<div class="select-wrap"><select name="brand" class="form-control">';
    while($res = mysqli_fetch_array($result)) { ?>
        <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option>  
    <?php
    }
    echo '</select></div>';
}

// Edit Event/brand
function edit_quartz_event() {
    global $mysqli; 
    global $uri;
    $event_id = $_GET['event'];
    $result = mysqli_query($mysqli, "SELECT * FROM quartz_event WHERE id='$event_id'");
    if(isset($_POST['edit'])) {
        $event = $_POST['Event'];
        $brand = $_POST['brand'];
        $date = $_POST['date'];
        $active = $_POST['status'];
        $ranking = $_POST['ranking'];
        $copy_form = $_POST['event'];
        $instructions = $_POST['instructions'];
        
        $result = mysqli_query($mysqli, "UPDATE quartz_event SET status='$active', ranking='$ranking', date='$date', instructions='$instructions' WHERE id='$event_id'"); 
        echo "<meta http-equiv='refresh' content='0'>"; 
            
        // If Copying Form
        if($_POST['event']) {
            
            $result_2 = mysqli_query($mysqli, "
            INSERT INTO forms
              ( event, title, form_type, intro, subject_registrant, message_registrant, thank_you_message, t_c, rules, meetings, subject_admin, message_admin, from_email )
                SELECT '$event_id', title, form_type, intro, subject_registrant, message_registrant, thank_you_message, t_c, rules, meetings, subject_admin, message_admin, from_email 
                FROM forms WHERE event = '$copy_form'
            ");

  
            $result_2 = mysqli_query($mysqli, "
            INSERT INTO fields ( event, active, order_no, title, description, slug, type, options, required, has_options ) SELECT '$event_id', active, order_no, title, description, slug, type, options, required, has_options FROM fields WHERE event='$copy_form'
            ");
          
            
            echo "<meta http-equiv='refresh' content='0'>"; 
            
        }
          
    } 
    while($res = mysqli_fetch_array($result)) { ?>
        <form  method="post" action="">
            <div class="form-group">
               <label>Brand</label>
               <?php brand_select();?>
            </div>
            <div class="form-group">
               <label>Season</label>
               <?php event_cat_select();?>
            </div>
            <div class="form-group">            
                <label>Active Event?</label> 
                <div class="btn-group" data-toggle="buttons">
                     <label class="btn btn-secondary <?php if($res['status']==1) { echo 'active'; } ?>">
                       <input type="radio" name="status" <?php if($res['status']==1) { echo 'checked'; } ?> id="option1" value="1" autocomplete="off">Yes
                     </label>
                     <label class="btn btn-secondary <?php if($res['status']==0) { echo 'active'; } ?>">
                       <input type="radio" name="status" <?php if($res['status']==0) { echo 'checked'; } ?> id="option1" value="0" autocomplete="off">No
                     </label>
                </div> 
            </div> 
            <div class="form-group">            
                <label>Ranking</label>
                <div class="btn-group" data-toggle="buttons">
                     <label class="btn btn-secondary <?php if($res['ranking']==1) { echo 'active'; } ?>">
                       <input type="radio" name="ranking" <?php if($res['ranking']==1) { echo 'checked'; } ?> id="option2" value="1" autocomplete="off">On
                     </label>
                     <label class="btn btn-secondary <?php if($res['ranking']==0) { echo 'active'; } ?>">
                       <input type="radio" name="ranking" <?php if($res['ranking']==0) { echo 'checked'; } ?> id="option2" value="0" autocomplete="off">Off
                     </label>
                </div> 
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="date" value="<?php echo $res['date'];?>" />
            </div>
            <div class="form-group">
                <label>URL for Instructions</label>
                <input type="text" class="form-control" name="instructions" value="<?php echo $res['instructions'];?>" />
            </div>
            <div class="form-group">
                <label>Copy Form Fields from Event:</label>
                <?php event_select();?>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" name="edit" value="Save">
            </div>
        </form>
    <?php }
}

// Instructional PDF View

function instructions_pdf() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "
    SELECT instructions FROM quartz_event WHERE id = '$event'
    ");
    while($res = mysqli_fetch_array($result)) { ?>
    <div class="modal fade" id="instructions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Instructions</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="material-icons">close</i>
            </button>
          </div>
          <div class="modal-body">
              <div class="embed-responsive embed-responsive-1by1">
              <embed class="embed-responsive-item" src="<?php echo $res['instructions'];?>" />
              </div>
          </div>
        </div>
      </div>
    </div>  

<?php }
}

/******* Exhibitors **********/

// All Exhibitors
function all_exhibitors() {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "
    SELECT exhibitors.name AS exhibitor_name, exhibitors.id AS exhibitor_id, exhibitors.active AS active, exhibitors.email AS exhibitor_email, exhibitors.completed AS completed, exhibitors.company AS exhibitor_company, exhibitors.job_title AS exhibitor_job_title, quartz_event.id, quartz_event.Event, quartz_event.brand, events.id, events.name AS event_name, brands.id, brands.name AS brand_name from exhibitors
    LEFT JOIN quartz_event ON exhibitors.event = quartz_event.id
    LEFT JOIN events ON quartz_event.Event = events.id
    LEFT JOIN brands ON quartz_event.brand = brands.id");
    while($res = mysqli_fetch_array($result)) { ?>
        <table class="table filter-table table-responsive" id="all_exhibitors">
            <thead>
                <th>Name</th>
                <th>Company</th>
                <th>Job Title</th>
                <th>Email</th>
                <th>Event</th>
                <th>Active</th>
                <th>Ranking</th>
                <th></th>
            </thead>
            <tbody>
            <?php while($res = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $res['exhibitor_name'];?></td>
                <td><?php echo $res['exhibitor_company'];?></td>
                <td><?php echo $res['exhibitor_job_title'];?></td>
                <td><a href="mailto:<?php echo $res['exhibitor_email'];?>"><?php echo $res['exhibitor_email'];?></td>
                <td><?php echo $res['brand_name'];?> <?php echo $res['event_name'];?></td>
                <td><?php if($res['active'] == 0) { echo 'Inactive'; } else {echo 'Active';}?></td>
                <td><div class="star-num"><?php echo $res['completed'];?></div><?php if($res['completed'] == 0) { echo 'No'; } else {echo 'Done';}?></td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo $uri;?>/exhibitor/edit/?id=<?php echo $res['exhibitor_id'];?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?php echo $uri;?>/exhibitor/delete.php?id=<?php echo $res['exhibitor_id'];?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-sm btn-danger">Delete</a>   
                    </div>
                </td>
            </tr>
            <?php } ?>    
            </tbody>
        </table>
        <?php }
}

// All Exhibitor Emails
function all_exhibitor_emails() {
    global $mysqli; 
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "SELECT exhibitors.email, exhibitors.event from exhibitors WHERE event='$event'");
    while($res = mysqli_fetch_array($result)) { ?>
        <?php echo $res['email'];?>, 
    <?php }
}

// Exhibitor Name
function exhibitor_name() {
    global $mysqli; 
    $exhibitor = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE id='$exhibitor'");
    while($res = mysqli_fetch_array($result)) { ?>
        <?php echo $res['name'];?>
    <?php }
}

// Exhibitor Profile
function exhibitor_profile() {
    global $mysqli; 
    $exhibitor = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE id='$exhibitor'");
    echo '<ul class="list-unstyled att-response">';
    while($res = mysqli_fetch_array($result)) { ?>
        <li>
            <span class="question">Name</span>
            <?php echo $res['name'];?>
        </li>
        <li>
            <span class="question">Email</span>
            <?php echo $res['email'];?>
        </li>
        <li>
            <span class="question">Phone</span>
            <?php echo $res['phone'];?>
        </li>
        <li>
            <span class="question">Company</span>
            <?php echo $res['company'];?>
        </li>
        <li>
            <span class="question">Job Title</span>
            <?php echo $res['job_title'];?>
        </li>
        <li>
            <span class="question">Fax</span>
            <?php echo $res['fax'];?>
        </li>
        <li>
            <span class="question">Website</span>
            <?php echo $res['website'];?>
        </li>
        
        <li>
            <span class="question">Address</span>
            <?php echo $res['address'];?>, <?php echo $res['address'];?>, <?php echo $res['city'];?>, <?php echo $res['state'];?> <?php echo $res['zip'];?>, <?php echo $res['country'];?>
        </li>
        <li>
            <span class="question">Products and Services</span>
                <?php
                echo '<ul class="normal-list"><li>';
                $products_services = $res['products_services'];
                $products_services = trim($res['products_services']);
                $products_services = str_replace(",", "</li><li>", $products_services);   
                echo $products_services;                                               
                echo '</li></ul>';
                ?>
        </li>
        <li>
            <span class="question">Industries Served</span>
            <?php
            echo '<ul class="normal-list"><li>';
            $industries_served = $res['industries_served'];
            $industries_served = trim($res['industries_served']);
            $industries_served = str_replace(",", "</li><li>", $industries_served);   
            echo $industries_served;                                               
            echo '</li></ul>';
            ?>
        </li>
        <li>
            <span class="question">Customers</span>
            <?php
            echo '<ul class="normal-list"><li>';
            $customers = $res['customers'];
            $customers = trim($res['customers']);
            $customers = str_replace(",", "</li><li>", $customers);                                        
            echo $customers;                                               
            echo '</li></ul>';
            ?>
        </li>
        <li>
            <span class="question">Testimonials</span>
            <?php echo $res['testimonials'];?>
        </li>
        
    <?php }
    echo '</ul>';
}

// Exhibitor Profile SMALL
function exhibitor_profile_sm() {
    global $mysqli; 
    $exhibitor = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE id='$exhibitor'");
    while($res = mysqli_fetch_array($result)) { ?>

        <div class="attendee-card">
            <h1><?php echo $res['name'];?></h1>
            <h3><?php echo $res['company'];?> | <?php echo $res['job_title'];?></h3>
        </div>
        <h3><a href="http://<?php echo $res['website'];?>" target="_blank"><?php echo $res['website'];?></a></h3>
        <p><?php echo $res['address'];?>, <?php echo $res['address'];?>, <?php echo $res['city'];?>, <?php echo $res['state'];?> <?php echo $res['zip'];?>, <?php echo $res['country'];?></p>
        <hr>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
                <h3>Products and Services</h3>
                <?php
                echo '<ul class="normal-list"><li>';
                $products_services = $res['products_services'];
                $products_services = trim($res['products_services']);
                $products_services = str_replace(",", "</li><li>", $products_services);   
                echo $products_services;                                               
                echo '</li></ul>';
                ?>


                <h3>Industries Served</h3>
                <?php
                echo '<ul class="normal-list"><li>';
                $industries_served = $res['industries_served'];
                $industries_served = trim($res['industries_served']);
                $industries_served = str_replace(",", "</li><li>", $industries_served);   
                echo $industries_served;                                               
                echo '</li></ul>';
                ?>

                <h3>Customers</h3>
                <p>
                <?php
                echo '<ul class="normal-list"><li>';
                $customers = $res['customers'];
                $customers = trim($res['customers']);
                $customers = str_replace(",", "</li><li>", $customers);                                        
                echo $customers;                                               
                echo '</li></ul>';
                ?>
                </p>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <h3>Testimonials</h3>
                <p><?php echo $res['testimonials'];?></p>
            </div>
        </div>    
    <?php }
}


// Edit Exhibitor Events
function edit_exhibitor_events() {
    global $mysqli; 
    $exhibitor = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE id='$exhibitor'");
    if(isset($_POST['edit_exhibitor_events'])) {
        $event_1 = $_POST['event'];  
        $result = mysqli_query($mysqli, "UPDATE exhibitors SET
        event='$event_1'
        WHERE id='$exhibitor'");   
        echo "<meta http-equiv='refresh' content='0'>";
    }
    while($res = mysqli_fetch_array($result)) { ?>    
    <form  method="post" action="">
        <div class="form-group">
            <label>Event</label>
            <?php $result_event = mysqli_query($mysqli, 
            "SELECT quartz_event.*, quartz_event.id AS ev_id, events.id, events.name AS event_name, brands.id, brands.name AS brand_name, brands.name 
            FROM quartz_event, events, brands
            WHERE quartz_event.Event = events.id AND quartz_event.brand = brands.id");                                                       
            echo '<div class="select-wrap">';?>
            <select class="form-control" name="event">
            <option  value="">Select Event</option>
            <?php while($res_event = mysqli_fetch_array($result_event)) { 
                    $ev_id = $res_event['ev_id'];
                    $event_name = $res_event['event_name'];
                    $brand_name = $res_event['brand_name'];
                    $brand_id = $res_event['brand_id'];
                    $event_id = $res_event['event_id'];?>
                    <option <?php if($res['event']==$ev_id): echo 'selected'; endif;?> value="<?php echo $ev_id;?>"><?php echo $brand_name;?> <?php echo $event_name;?></option>  
            <?php }
            echo '</select></div>';?>
        </div>
        <input type="submit" class="btn btn-primary" name="edit_exhibitor_events" value="Update Exhibitor Event" />
    </form>
    <hr>    
<?php } }

// Edit Exhibitor Profile
function edit_exhibitor() {
    global $mysqli; 
    $exhibitor = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE id='$exhibitor'");
    if(isset($_POST['edit_exhibitor'])) {
        
        $event = $_POST['event'];
        
        $name = $_POST['name'];
        $email = $_POST['email']; 
        $phone = $_POST['phone'];
        $company = $_POST['company'];
        $job_title = $_POST['job_title'];
        $rank_amount = $_POST['rank_amount'];
        $active = $_POST['active'];
        $fax = $_POST['fax'];
        $website = $_POST['website'];
        $description = $_POST['description'];
        $products_services = $_POST['products_services'];
        $industries_served = $_POST['industries_served'];
        $customers= $_POST['customers'];
        $testimonials = $_POST['testimonials'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $country = $_POST['country'];
        $sales_name_1 = $_POST['sales_name_1'];
        $sales_phone_1 = $_POST['sales_phone_1'];
        $sales_email_1 = $_POST['sales_email_1'];
        $sales_title_1 = $_POST['sales_title_1'];
        $sales_name_2 = $_POST['sales_name_2'];
        $sales_phone_2 = $_POST['sales_phone_2'];
        $sales_email_2 = $_POST['sales_email_2'];
        $sales_title_2 = $_POST['sales_title_2'];
        $sales_name_3 = $_POST['sales_name_3'];
        $sales_phone_3 = $_POST['sales_phone_3'];
        $sales_email_3 = $_POST['sales_email_3'];
        $sales_title_3 = $_POST['sales_title_3'];
        $sales_name_4 = $_POST['sales_name_4'];
        $sales_phone_4 = $_POST['sales_phone_4'];
        $sales_email_4 = $_POST['sales_email_4'];
        $sales_title_4 = $_POST['sales_title_4'];
        $sales_name_5 = $_POST['sales_name_5'];
        $sales_phone_5 = $_POST['sales_phone_5'];
        $sales_email_5 = $_POST['sales_email_5'];
        $sales_title_5 = $_POST['sales_title_5'];
        $username = $_POST['username'];
        $password = $_POST['password'];   
        
        $result = mysqli_query($mysqli, "UPDATE exhibitors SET
        name='$name',
        email='$email',
        phone='$phone',
        company='$company', 
        job_title='$job_title',
        rank_amount='$rank_amount',
        active = '$active',
        fax='$fax',
        website='$website',
        description='$description',
        products_services='$products_services',
        industries_served='$industries_served',
        customers='$customers',
        testimonials='$testimonials',
        address='$address',
        city='$city',
        state='$state',
        zip='$zip',
        country='$country',
        sales_name_1='$sales_name_1',
        sales_phone_1='$sales_phone_1',
        sales_email_1='$sales_email_1',
        sales_title_1='$sales_title_1',
        sales_name_2='$sales_name_2',
        sales_phone_2='$sales_phone_2',
        sales_email_2='$sales_email_2',
        sales_title_2='$sales_title_2',
        sales_name_3='$sales_name_3',
        sales_phone_3='$sales_phone_3',
        sales_email_3='$sales_email_3',
        sales_title_3='$sales_title_3',
        sales_name_4='$sales_name_4',
        sales_phone_4='$sales_phone_4',
        sales_email_4='$sales_email_4',
        sales_title_4='$sales_title_4',
        sales_name_5='$sales_name_5',
        sales_phone_5='$sales_phone_5',
        sales_email_5='$sales_email_5',
        sales_title_5='$sales_title_5',
        username='$username',
        password='$password'
        WHERE id='$exhibitor'"); 
        
        // Get Exhibitor -> Admin Message
        $result_email = mysqli_query($mysqli, "SELECT * FROM quartz_event WHERE id='$event'");
        while($res_email = mysqli_fetch_array($result_email)) { 

            $admin_notice = $res_email['exhibitor_update_notice'];
            $to_email = $res_email['admin_email'];
            $from_email = $res_email['admin_email'];
            $to = $email;
            $subject = "Exhibitor  updated their profile";
            $notice = $admin_notice.": ".$name;
            $txt = $notice; 
            $headers = "From: ".$from_email . "\r\n" .
            "CC: ".$from_email;
            mail($to,$subject,$txt,$headers);
        }        
        
        echo "<meta http-equiv='refresh' content='0'>";
    } 
    while($res = mysqli_fetch_array($result)) { ?>

        <form  method="post" action="">
            <input type="hidden" name="event" value="<?php echo $res['event'];?>">
            <?php if($_SESSION['permission']==1):?>
            <h4 class="sec-title">Login Credentials</h4>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="username" value="<?php echo $res['username'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" name="password" value="<?php echo $res['password'];?>">
                    </div>
                </div>
            </div>           
            <?php endif;?>
            <h4 class="sec-title">Exhibitor Information</h4>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" value="<?php echo $res['name'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" value="<?php echo $res['email'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control" name="phone" value="<?php echo $res['phone'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Fax</label>
                        <input class="form-control" name="fax" value="<?php echo $res['fax'];?>">
                    </div>
                </div>
                  <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Website (No HTTP://)</label>
                        <input class="form-control" name="website" value="<?php echo $res['website'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Company</label>
                        <input class="form-control" name="company" value="<?php echo $res['company'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Job Title</label>
                        <input class="form-control" name="job_title" value="<?php echo $res['job_title'];?>">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" name="address" value="<?php echo $res['address'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>City</label>
                        <input class="form-control" name="city" value="<?php echo $res['city'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>State</label>
                        <input class="form-control" name="state" value="<?php echo $res['state'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Zip</label>
                        <input class="form-control" name="zip" value="<?php echo $res['zip'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-5">
                    <div class="form-group">
                    <div class="form-group">
                        <label>Country</label>
                        <?php include('layout/countries.php');?>
                    </div> 
                    </div>
                </div>                
            </div>
            <div class="form-group">
                <label>Description<span>150 words maximum</span></label>
                <textarea class="form-control" name="description"><?php echo $res['description'];?></textarea>
            </div>
            <div class="form-group">
                <label>Products and Services<span>Separated by commas</span></label>
                <textarea class="form-control" name="products_services"><?php echo $res['products_services'];?></textarea>
            </div>
            <div class="form-group">
                <label>Industries Served<span>Separated by commas</span></label>
                <textarea class="form-control" name="industries_served"><?php echo $res['industries_served'];?></textarea>
            </div>
            <div class="form-group">
                <label>Customers<span>Separated by commas (Limit to 10)</span></label>
                <textarea class="form-control" name="customers"><?php echo $res['customers'];?></textarea>
            </div>
            <!--
            <div class="form-group">
                <label>Testimonials<span>Limit to 3</span></label>
                <textarea class="form-control" name="testimonials"><?php echo $res['testimonials'];?></textarea>
            </div>
            -->
            <div class="form-group"> 
                <label>Testimonials<span>Limit to 3</span></label>
                <div class="wysiwyg">
                   <div id='editControls'>
                     <div class="editor-controls btn-group">
                       <a class="btn" data-role='undo' href='javascript:void(0)'><i class='fa fa-undo'></i></a>
                       <a class="btn" data-role='bold' href='javascript:void(0)'><i class='fa fa-bold'></i></a>
                       <a class="btn" data-role='italic' href='javascript:void(0)'><i class='fa fa-italic'></i></a>
                       <a class="btn" data-role='underline' href='javascript:void(0)'><i class='fa fa-underline'></i></a>
                       <a class="btn" data-role='justifyLeft' href='javascript:void(0)'><i class='fa fa-align-left'></i></a>
                       <a class="btn" data-role='justifyCenter' href='javascript:void(0)'><i class='fa fa-align-center'></i></a>
                       <a class="btn" data-role='justifyRight' href='javascript:void(0)'><i class='fa fa-align-right'></i></a>
                       <a class="btn" data-role='insertUnorderedList' href='javascript:void(0)'><i class='fa fa-list-ul'></i></a>
                       <a class="btn" data-role='insertOrderedList' href='javascript:void(0)'><i class='fa fa-list-ol'></i></a>
                       <a class="btn" data-role='h1' href='javascript:void(0)'>h<sup>1</sup></a>
                       <a class="btn" data-role='h2' href='javascript:void(0)'>h<sup>2</sup></a>
                       <a class="btn" data-role='p' href='javascript:void(0)'>p</a>
                     </div>
                   </div>
                   <div id='editor' class="form-control" contenteditable><?php echo $res['testimonials'];?></div> 
                </div>
                <textarea id='output' name="testimonials" class="hidden-xl-down form-control"><?php echo $res['testimonials'];?></textarea>              
            </div>            
            
            
            <?php if($_SESSION['permission']==1):?>
            
            <div class="form-group">
                <label>Active Status: 
                   <?php
                       if($res['active'] == 0) {
                           echo 'Inactive';
                       } else {
                           echo 'Active';
                       }
                   ?>  
                </label>
                <div class="btn-group" data-toggle="buttons">
                   <label class="btn btn-secondary <?php if($res['active'] == 1) { echo 'active'; }?>">
                       <input type="radio" name="active" value="1" id="option1" autocomplete="off" <?php if($res['active'] == 1) { echo 'checked'; }?>> Active
                   </label>
                   <label class="btn btn-secondary <?php if($res['active'] == 0) { echo 'active'; }?>">
                       <input type="radio" name="active" value="0" id="option2" autocomplete="off" <?php if($res['active'] == 2) { echo 'checked'; }?>> Inactive
                   </label>
                </div>            
            </div>
            <div class="form-group">
                <label>Rank Amount</label>
                <input class="form-control" name="rank_amount" value="<?php echo $res['rank_amount'];?>">
            </div>
            <?php endif;?>
            <h4 class="sec-title">Sales Contacts</h4>
            
            <p>Sales Contact 1</p>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input class="form-control" name="sales_name_1" value="<?php echo $res['sales_name_1'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input class="form-control" name="sales_email_1" value="<?php echo $res['sales_email_1'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input class="form-control" name="sales_phone_1" value="<?php echo $res['sales_phone_1'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Title</label>
                        <input class="form-control" name="sales_title_1" value="<?php echo $res['sales_title_1'];?>">
                    </div>
                </div>
            </div>
            
            <p>Sales Contact 2</p>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input class="form-control" name="sales_name_2" value="<?php echo $res['sales_name_2'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input class="form-control" name="sales_email_2" value="<?php echo $res['sales_email_2'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input class="form-control" name="sales_phone_2" value="<?php echo $res['sales_phone_2'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Title</label>
                        <input class="form-control" name="sales_title_2" value="<?php echo $res['sales_title_2'];?>">
                    </div>
                </div>
            </div>
            
            <p>Sales Contact 3</p>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input class="form-control" name="sales_name_3" value="<?php echo $res['sales_name_3'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input class="form-control" name="sales_email_3" value="<?php echo $res['sales_email_3'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input class="form-control" name="sales_phone_3" value="<?php echo $res['sales_phone_3'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Title</label>
                        <input class="form-control" name="sales_title_3" value="<?php echo $res['sales_title_3'];?>">
                    </div>
                </div>
            </div>

            <p>Sales Contact 4</p>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input class="form-control" name="sales_name_4" value="<?php echo $res['sales_name_4'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input class="form-control" name="sales_email_4" value="<?php echo $res['sales_email_4'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input class="form-control" name="sales_phone_4" value="<?php echo $res['sales_phone_4'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Title</label>
                        <input class="form-control" name="sales_title_4" value="<?php echo $res['sales_title_4'];?>">
                    </div>
                </div>
            </div>
            
            <p>Sales Contact 5</p>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input class="form-control" name="sales_name_5" value="<?php echo $res['sales_name_5'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input class="form-control" name="sales_email_5" value="<?php echo $res['sales_email_5'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input class="form-control" name="sales_phone_5" value="<?php echo $res['sales_phone_5'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Contact Title</label>
                        <input class="form-control" name="sales_title_5" value="<?php echo $res['sales_title_5'];?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-success" name="edit_exhibitor" value="Save">
            </div>
        </form>
        <hr>

    <?php }
}

// Add New Exhibitor
function add_exhibitor() {
    global $mysqli; 
    if(isset($_POST['add_new'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $company = $_POST['company'];
        $job_title = $_POST['job_title'];
        $username = $_POST['username'];
        $password = randomPassword();
        $event = $_POST['event']; 
        if(empty($name)) {
            echo "You have empty fields";
        } else { 
            $result = mysqli_query($mysqli, "INSERT INTO exhibitors(
            name, email, phone, company, job_title, username, password, event, permission
            ) VALUES(
            '$name', '$email', '$phone', '$company','$job_title','$username', '$password', '$event',  2
            )");
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}

// Exhibitors for Event
function exhibitor_by_event() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $brand = $_GET['brand'];
    $result = mysqli_query($mysqli, "
    SELECT exhibitors.name AS exhibitor_name, exhibitors.id AS exhibitor_id, exhibitors.email AS exhibitor_email, exhibitors.completed AS completed, exhibitors.company AS exhibitor_company FROM exhibitors
    LEFT JOIN quartz_event ON exhibitors.event = quartz_event.id
    WHERE exhibitors.event='$event'
    ");
    while($res = mysqli_fetch_array($result)) { ?>
        <table class="table table-responsive">
            <thead>
                <th>Name</th>
                <th>Company</th>
                <th>Email</th>
                <th></th>
            </thead>
            <tbody>
            <?php while($res = mysqli_fetch_array($result)) { ?>
                <tr>
               <td><?php echo $res['exhibitor_name'];?></td>
               <td><?php echo $res['exhibitor_company'];?></td>
               <td><?php echo $res['exhibitor_email'];?></td>
               <td>
                   <div class="btn-group">
                   <a href="" data-toggle="modal" class="btn btn-info btn-sm view-exhibitor-info" data-target="#exhibitorInfo" data-exhibitor="<?php echo $res['exhibitor_id'];?>">Details</a>
                   <a href="<?php echo $uri;?>/exhibitor/edit/?id=<?php echo $res['exhibitor_id'];?>" class="btn btn-warning btn-sm">Edit</a>
                   </div>
               </td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    <?php }
}

// Duplicate Exhibitor for Other Event
function duplicate_exhibitor() {
    global $mysqli; 
    global $uri;
    $id = $_GET['id'];
    $exhibitor_res = mysqli_query($mysqli, "SELECT * FROM exhibitors WHERE id = '$id'");  
    if(isset($_POST['copy_exhibitor'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $username = randomPassword();
        $password = $_POST['password'];
        $event = $_POST['event'];      
        $copy_form = $_POST['id'];
        $result = mysqli_query($mysqli, "INSERT INTO exhibitors(permission, active, name, email, phone, username, password, event ) VALUES('2', '0', '$name', '$email', '$phone', '$username', '$password', '$event')");
        $result_2 = mysqli_query($mysqli, "
        INSERT INTO fields ( permission, active, name, email, phone, username, password) SELECT permission, active, name, email, phone, username, password FROM exhibitors WHERE id='$copy_form'
        ");
        
        // Email Exhibitor that they've been added to another event
        $to = $email;
        $from_email = 'lyuba.nova@eatsleepwork.com';
        $subject = "You've been added to another event!";
        $login_creds = 
        "\r\n Username: ".$username.
        "\r\n Password: ".$password;
        $txt = "Here are your login credentials for when ranking for this event is open! \r\n \r\n" .$login_creds; 
        $headers = "From: ".$from_email . "\r\n" .
        "CC: ".$from_email;
        mail($to,$subject,$txt,$headers);
        echo "<meta http-equiv='refresh' content='0'>"; 
        
    } 
    while($res = mysqli_fetch_array($exhibitor_res)) { ?>
    <form  method="post" action="">
        <div class="form-group">
            <input type="hidden" value="<?php echo $res['name'];?>" name="name" class="form-control" />
            <input type="hidden" value="<?php echo $res['email'];?>" name="email" class="form-control" />
            <input type="hidden" value="<?php echo $res['phone'];?>" name="phone" class="form-control" />
            <input type="hidden" value="<?php echo $res['username'];?>" name="username" class="form-control" />
            <input type="hidden" value="<?php echo $res['password'];?>" name="password" class="form-control" />
        </div>
        <div class="form-group">
            <label>Add New Event to this Exhibitor ( This will duplicate the exhibitor ) </label>
            <?php event_select();?>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" name="copy_exhibitor" value="Add Exhibitor to Event">
        </div>
    </form>        
<?php } }

// All Events for Each Exhibitor // REDUNDANT?
function exhibitor_events($btn) {
    global $mysqli; 
    global $uri;
    $exhibitor = $_SESSION['id'];
    $result = mysqli_query($mysqli, "
    SELECT 
    exhibitors.*,
    quartz_event.id AS q_event, 
        quartz_event.Event,
        events.id AS event_id, events.name AS event_name,
        brands.id AS brand_id, brands.name AS brand_name      
    FROM exhibitors   
    LEFT JOIN quartz_event ON exhibitors.event = quartz_event.id OR exhibitors.event_2 =  quartz_event.id  OR exhibitors.event_3 =  quartz_event.id
        LEFT JOIN events ON quartz_event.Event = events.id
        LEFT JOIN brands ON quartz_event.brand = brands.id    
    WHERE exhibitors.id='$exhibitor'
    ");    
    while($res = mysqli_fetch_array($result)) { ?>
        <a class="btn btn-secondary <?php echo $btn;?>" href="<?php echo $uri;?>/events/?event=<?php echo $res['q_event'];?>"><?php echo $res['brand_name'];?> <?php echo $res['event_name'];?></a>
    <?php }
}

/******* Attendees **********/

// All Attendees
function all_attendees($finished) {
    global $mysqli; 
    global $uri;
    // $result = mysqli_query($mysqli, "SELECT * FROM attendees");
    $result = mysqli_query($mysqli, "
    SELECT attendees.id AS att_id, attendees.name AS name, attendees.job_title AS job_title, attendees.company AS company, attendees.registration_date AS registration_date, attendees.invitation_number AS invitation_number, attendees.email AS email, attendees.approved AS approved, attendees.event,
    quartz_event.id AS e_id, quartz_event.Event, quartz_event.brand, 
    events.id, events.name AS event_name, brands.id, brands.name AS brand_name FROM attendees
    LEFT JOIN quartz_event ON attendees.event = quartz_event.id
    LEFT JOIN events ON quartz_event.Event = events.id
    LEFT JOIN brands ON quartz_event.brand = brands.id
    WHERE attendees.finished = $finished
    ");
 
    while($res = mysqli_fetch_array($result)) { ?>
        <table class="table table-responsive filter-table" id="all_attendees">
            <thead>
                <th>Name</th>
                <th>Company</th>
                <th>Job Title</th>
                <th>Reg. Date</th>
                <th>Invitation No.</th>
                <th>Email</th>
                <th>Status</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
            <?php while($res = mysqli_fetch_array($result)) { ?>
                <tr>
               <td><?php echo $res['name'];?></td>
                <td><?php echo $res['company'];?></td>
               <td><?php echo $res['job_title'];?></td>
               <td><?php echo $res['registration_date'];?></td>
               <td><?php echo $res['invitation_number'];?></td>
               <td><a href="mailto:<?php echo $res['email'];?>"><?php echo $res['email'];?></td>
               <td>
                   
                   <?php                                     
                    if($res['finished'] == 0) {
                       echo 'Unfinished';
                    } else {
                       // Check Attendee Approval
                       if($res['approved'] == 0) {
                           echo '<div class="approval pending">Pending</div>';
                       } else if($res['approved'] == 1) {
                           echo '<div class="approval approved">Approved</div>';
                       } else if($res['approved'] == 2) {
                           echo '<div class="approval denied">Denied</div>';
                       } else if($res['approved'] == 3) {
                           echo '<div class="approval cancelled">Cancelled</div>';
                       }
                    }                                    
                                         
                   ?>
                </td>
               <td>
                   <div class="btn-group">
                   <a href="" data-toggle="modal" class="btn btn-info btn-sm view-info" data-target="#attendeeInfo" data-attendee="<?php echo $res['att_id'];?>">Details</a>
                   <a href="<?php echo $uri;?>/attendee/edit/?id=<?php echo $res['att_id'];?>" class="btn btn-warning btn-sm">Edit</a>
                   <a href="<?php echo $uri;?>/attendee/delete.php?id=<?php echo $res['att_id'];?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-sm btn-danger">Delete</a>   
                   </div>
                </td>
                <td><?php echo $res['brand_name'];?> <?php echo $res['event_name'];?></td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    <?php }
}

// Attendee Approval Status
function attendee_approval_status() {
    global $mysqli; 
    $attendee = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM attendees WHERE id='$attendee'");
    while($res = mysqli_fetch_array($result)) { ?>
        <?php
            // Check Attendee Approval
            if($res['approved'] == 0) {
                echo '<div class="approval pending">Pending</div>';
            } else if($res['approved'] == 1) {
                echo '<div class="approval approved">Approved</div>';
            } else if($res['approved'] == 2) {
                echo '<div class="approval denied">Denied</div>';
            } else {
                echo '<div class="approval cancelled">Cancelled</div>';
            }
        ?>
    <?php }
}

// Edit Attendee Profile
function edit_attendee() {
    global $mysqli; 
    $attendee = $_GET['id'];

    $result = mysqli_query($mysqli, "SELECT * FROM attendees WHERE id='$attendee'");
    if(isset($_POST['edit_attendee'])) {
        
        $event = $_POST['event'];
        
        $approved = $_POST['approved'];
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
        $track  = $_POST['track'];
        
        $revenue  = $_POST['revenue'];
        $company_size  = $_POST['company_size'];
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
        
        $result = mysqli_query($mysqli, "UPDATE attendees SET
        name='$name',
        approved='$approved',
        email = '$email',
        company = '$company',
        job_title = '$job_title',
        address = '$address',
        city = '$city',
        state = '$state',
        zip = '$zip',
        country = '$country',
        alt_email = '$alt_email',
        direct_phone = '$direct_phone',
        cell_phone = '$cell_phone',
        fax = '$fax',
        website = '$website',
        track = '$track',
        revenue='$revenue',
        company_size='$company_size', 
        industry='$industry',
        scheduling='$scheduling',
        erp = '$erp',
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
        procurement_interest='$procurement_interest'    
        WHERE id='$attendee'");
        
        // Get Attendee -> Admin Message
        $result_email = mysqli_query($mysqli, "SELECT * FROM quartz_event WHERE id='$event'");
        while($res_email = mysqli_fetch_array($result_email)) { 

            $admin_notice = $res_email['attendee_update_notice'];
            $to_email = $res_email['admin_email'];
            $from_email = $res_email['admin_email'];
            $to = $email;
            $subject = "Attendee  updated their profile";
            $notice = $admin_notice.": ".$name;
            $txt = $notice; 
            $headers = "From: ".$from_email . "\r\n" .
            "CC: ".$from_email;
            mail($to,$subject,$txt,$headers);
            
        }    

        /*
        // Send Admin Email that Attendee has updated their profile
        $from_email = "lyuba.nova@eatsleepwork.com";
        $to = "lyuba.nova@eatsleepwork.com";
        $subject = "Attendee has updated their profile!";
 
        $txt = $name. " has updated their profile."; 

        $headers = "From: ".$from_email . "\r\n" .
        "CC: ".$from_email; 

        mail($to,$subject,$txt,$headers);
        
        */

        echo "<meta http-equiv='refresh' content='0'>";
    } 
    while($res = mysqli_fetch_array($result)) { ?>
        <form  method="post" action="">
            <input type="hidden" name="event" value="<?php echo $res['event'];?>">
            <?php if($_SESSION['permission']==1):?>
            <div class="form-group">
                <label>Attendee Status: 
                   <?php
                       // Check Attendee Approval
                       if($res['approved'] == 0) {
                           echo 'Pending';
                       } else if($res['approved'] == 1) {
                           echo 'Approved';
                       } else if($res['approved'] == 2) {
                           echo "Denied";
                       } else {
                           echo 'Cancelled';
                       }
                   ?>  
                </label>
                <div class="btn-group" data-toggle="buttons">
                   <label class="btn btn-secondary <?php if($res['approved'] == 1) { echo 'active'; }?>">
                       <input type="radio" name="approved" value="1" id="option1" autocomplete="off" <?php if($res['approved'] == 1) { echo 'checked'; }?>> Approve
                   </label>
                   <label class="btn btn-secondary <?php if($res['approved'] == 2) { echo 'active'; }?>">
                       <input type="radio" name="approved" value="2" id="option2" autocomplete="off" <?php if($res['approved'] == 2) { echo 'checked'; }?>> Deny
                   </label>
                   <label class="btn btn-secondary <?php if($res['approved'] == 3) { echo 'active'; }?>">
                       <input type="radio" name="approved" value="3" id="option3" autocomplete="off" <?php if($res['approved'] == 3) { echo 'checked'; }?>> Cancel
                   </label>
                </div>            
            </div>
            <?php endif;?>
            <hr>
            <h4 class="sec-title">Contact Information</h4>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" value="<?php echo $res['name'];?>">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Company *</label>
                        <input type="text" class="form-control" name="company" value="<?php echo $res['company'];?>" />
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Job Title *</label>
                        <input type="text" class="form-control" name="job_title"  value="<?php echo $res['job_title'];?>" />
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Business Email *</label>
                        <input type="email" class="form-control email_input" name="email" id="email_1"  value="<?php echo $res['email'];?>" />
                    </div> 
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Alternate Email</label>
                        <input type="text" class="form-control" name="alt_email"  value="<?php echo $res['alt_email'];?>" />
                    </div> 
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Direct Phone</label>
                        <input type="text" class="form-control" name="direct_phone"  value="<?php echo $res['direct_phone'];?>" />
                    </div> 
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Cell Phone</label>
                        <input type="text" class="form-control" name="cell_phone"  value="<?php echo $res['cell_phone'];?>" />
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Fax</label>
                        <input type="text" class="form-control" name="fax"  value="<?php echo $res['fax'];?>" />
                    </div>  
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" class="form-control" name="website"  value="<?php echo $res['website'];?>" />
                    </div> 
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Mailing Street</label>
                        <input type="text" class="form-control" name="address"  value="<?php echo $res['address'];?>" />
                    </div> 
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" name="city"  value="<?php echo $res['city'];?>" />
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" class="form-control" name="state"  value="<?php echo $res['state'];?>" />
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Zip</label>
                        <input type="text" class="form-control" name="zip"  value="<?php echo $res['zip'];?>" />
                    </div> 
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Country</label>
                        <?php include('layout/countries.php');?>
                    </div> 
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Track</label>
                        <input type="text" class="form-control" name="track"  value="<?php echo $res['track'];?>" />
                    </div> 
                </div>
            </div>
            <hr>
            <h4 class="sec-title">Other Information</h4>
            
                <?php standard_form_field_attendee_edit($slug='industry');?>
                <?php standard_form_field_attendee_edit($slug='revenue');?>
                <?php standard_form_field_attendee_edit($slug='company_size');?>
                <?php standard_form_field_attendee_edit($slug='products_services');?>   
                <?php standard_form_field_attendee_edit($slug='erp');?>   
                <?php standard_form_field_attendee_edit($slug='geo');?>

                <h4 class="sec-title">Warehouse</h4>
                <?php standard_form_field_attendee_edit($slug='warehouse');?>
                <?php standard_form_field_attendee_edit($slug='number_facilities');?>
                <?php standard_form_field_attendee_edit($slug='facility_responsibilities');?>
                <?php standard_form_field_attendee_edit($slug='facilities_size');?>
                <?php standard_form_field_attendee_edit($slug='facilities_equipment_interest');?>
                <?php standard_form_field_attendee_edit($slug='facilities_software_interest');?>
                <?php standard_form_field_attendee_edit($slug='facilities_projects');?>

                <h4 class="sec-title">Transportation</h4>
                <?php standard_form_field($slug='transportation_responsibility');?>
                <?php standard_form_field_attendee_edit($slug='ftl');?>
                <?php standard_form_field_attendee_edit($slug='ltl');?>
                <?php standard_form_field_attendee_edit($slug='intermodel');?>
                <?php standard_form_field_attendee_edit($slug='parcel');?>
                <?php standard_form_field_attendee_edit($slug='modes_transporation');?>
                <?php standard_form_field_attendee_edit($slug='tansportation_interest');?>
                <?php standard_form_field_attendee_edit($slug='transportation_projects');?>

                <h4 class="sec-title">3PL</h4>
                <?php standard_form_field_attendee_edit($slug='threepls');?>
                <?php standard_form_field_attendee_edit($slug='footprint');?>
                <?php standard_form_field_attendee_edit($slug='threepl_interest');?>
                <?php standard_form_field_attendee_edit($slug='threepl_projects');?>

                <h4 class="sec-title">Supply Chain</h4> 
                <?php standard_form_field_attendee_edit($slug='supply_responsibility');?>
                <?php standard_form_field_attendee_edit($slug='supply_services');?>
                <?php standard_form_field_attendee_edit($slug='supply_projects');?>

                <h4 class="sec-title">Procurement</h4>
                <?php standard_form_field_attendee_edit($slug='procurement');?>
                <?php standard_form_field_attendee_edit($slug='procurement_projects');?>
                <?php standard_form_field_attendee_edit($slug='procurement_interest');?>
            
            <div class="form-group">
                <input type="submit" class="btn btn-success" name="edit_attendee" value="Save">
            </div>
        </form>
    <?php }
}

function update_password($user) {
    global $mysqli; 
    $attendee = $_GET['id'];
    $password = $_POST['password'];
    if(isset($_POST['update_password'])) {
        // $password = md5($_POST['password']);
        $password = $_POST['password'];
        $result = mysqli_query($mysqli, "UPDATE $user SET
        password='$password'
        WHERE id='$attendee'");
        echo "<meta http-equiv='refresh' content='0'>";
    } ?>
    <form  method="post" action="">
        <h4 class="sec-title">Update Password</h4>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="form-group">
                    <label>Update <?php echo $user;?> password:</label>
                    <input class="form-control" name="password" value="">
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" name="update_password" value="Update Password">
        </div>
    </form>
    <?php    
}

// Approve / Deny Attendees
function approve_attendees() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "SELECT * FROM attendees WHERE approved=0 AND attendees.event = $event");  
    if(isset($_POST['deny_attendee'])) {
        $id = $_POST['id'];
        $result = mysqli_query($mysqli, "UPDATE attendees SET approved=2 WHERE id='$id'");
        echo $result;
        echo "<meta http-equiv='refresh' content='0'>";
    } 
    if(isset($_POST['cancel_attendee'])) {
        $id = $_POST['id'];
        $result = mysqli_query($mysqli, "UPDATE attendees SET approved=3 WHERE id='$id'");
        echo $result;
        echo "<meta http-equiv='refresh' content='0'>";
    } 
    while($res = mysqli_fetch_array($result)) { ?>
        <table class="table table-responsive">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th></th>
            </thead>
            <tbody>
            <?php while($res = mysqli_fetch_array($result)) { ?>
                <tr>
                   <form  method="post" action="">
                       <td><?php echo $res['name'];?><input type="hidden" name="id" value="<?php echo $res['id'];?>"></td>
                       <td><?php echo $res['email'];?></td>
                       <td>
                       <div class="btn-group float-right">
                       <a href="" data-toggle="modal" class="btn btn-secondary btn-sm view-info" data-target="#attendeeInfo" data-attendee="<?php echo $res['id'];?>">Details</a>
                       <!--<input type="submit" class="btn btn-secondary btn-sm" name="approve_attendee" value="Approve">-->
                       <a href="" data-toggle="modal" class="btn btn-secondary btn-sm approve-attendee" data-target="#attendeeApproval" data-attendee="<?php echo $res['id'];?>">Approve</a>
                       <input type="submit" class="btn btn-secondary btn-sm" name="deny_attendee" value="Deny">
                       <input type="submit" class="btn btn-secondary btn-sm" name="cancel_attendee" value="Cancel">
                       </div>
                       </td>
                   </form>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    <?php }
}

function approve_attendee() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $att_id = $_GET['id'];
    if(isset($_POST['approve_attendee'])) {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $event = $_POST['event'];

        // Get Event Approval Message
        $result_email = mysqli_query($mysqli, "SELECT * FROM quartz_event WHERE id='$event'");
        while($res_email = mysqli_fetch_array($result_email)) { 
            // Send Email Confirmation with Login Credenatials
            $approval_notice = $res_email['approval_notice'];
            $from_email = $res_email['admin_email'];
            
            $to = $email;
            $subject = "You've been approved!";
            $notice = $approval_notice;
            $login_creds = 
            "\r\n Login Email: ".$email.
            "\r\n Password: ".$password;
                
            $txt = $notice. "\r\n \r\n" .$login_creds; 
            
            $headers = "From: ".$from_email . "\r\n" .
            "CC: ".$from_email;

            mail($to,$subject,$txt,$headers);
        }
        // Update DB as Approved
        $result = mysqli_query($mysqli, "UPDATE attendees SET approved=1, password='$password' WHERE id='$id'");
        echo "<meta http-equiv='refresh' content='0'>";
    }   
}

// LIz's Dumb Function 
function basic_event_attendees() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "
    SELECT attendees.id, attendees.name, attendees.company, attendees.job_title, attendees.registration_date, attendees.invitation_number, attendees.email, attendees.password, attendees.approved, attendees.id AS att_id, attendees.event FROM attendees WHERE attendees.event = $event
    ");
    while($res = mysqli_fetch_array($result)) { ?>
        <table class="table table-responsive filter-table" id="all_attendees_admin">
            <thead>
                <th>Name</th>
                <th>Company</th>
                <th>Job Title</th>
                <th>Reg. Date</th>
                <th>Invitation No.</th>
                <th>Email</th>
                <th>Password</th> 
                <th>Status</th>
                <th></th>
            </thead>
            <tbody>
            <?php while($res = mysqli_fetch_array($result)) { ?>
                <tr>
                <td><?php echo $res['name'];?></td>
                <td><?php echo $res['company'];?></td>
                <td><?php echo $res['job_title'];?></td>
                <td><?php echo $res['registration_date'];?></td> 
                <td><?php echo $res['invitation_number'];?></td>
                <td><a href="mailto:<?php echo $res['email'];?>"><?php echo $res['email'];?></td>
                <td><?php echo $res['password'];?></td>
                <td>
                   <?php
                       // Check Attendee Approval
                       if($res['approved'] == 0) {
                           echo '<div class="approval pending">Pending</div>';
                       } else if($res['approved'] == 1) {
                           echo '<div class="approval approved">Approved</div>';
                       } else if($res['approved'] == 2) {
                           echo '<div class="approval denied">Denied</div>';
                       } else {
                           echo '<div class="approval cancelled">Cancelled</div>';
                       }
                   ?>
                </td>
                <td>
                   <div class="btn-group">
                   <a href="" data-toggle="modal" class="btn btn-info btn-sm view-info" data-target="#attendeeInfo" data-attendee="<?php echo $res['att_id'];?>">Details</a>
                   <a href="<?php echo $uri;?>/attendee/edit/?id=<?php echo $res['att_id'];?>" class="btn btn-warning btn-sm">Edit</a>
                   <a href="<?php echo $uri;?>/attendee/delete.php?id=<?php echo $res['att_id'];?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-sm btn-danger">Delete</a>   
                   </div>
                </td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    <?php }
}



// Attendees for Event
function attendees_by_event() {
    global $mysqli; 
    global $uri;
    $event_id = $_GET['event'];
    $ex_id = $_SESSION['id'];
    $geo   = $_GET['geo'];
    $warehouse   = $_GET['warehouse'];
    $attendee_result = mysqli_query($mysqli, "
    SELECT uploads.attendee_id, uploads.file AS upload_logo,
    attendees.id AS att_id, attendees.approved AS approved, attendees.name, attendees.company, attendees.company_size, attendees.industry, attendees.revenue, 
    attendees.geo, attendees.facilities_equipment_interest, attendees.facilities_software_interest,
    exhibitors_meta.attendee_id, exhibitors_meta.exhibitor_id AS this_ex, exhibitors_meta.stars AS stars, exhibitors_meta.rating FROM attendees  
    LEFT JOIN exhibitors_meta ON exhibitors_meta.attendee_id = attendees.id AND exhibitors_meta.exhibitor_id = $ex_id 
    LEFT JOIN uploads ON attendees.id = uploads.attendee_id 
    WHERE event='$event_id' AND approved = 1
    ");    
    
    ?>
    <?php while($att_res = mysqli_fetch_array($attendee_result)) {?>

        
        <tr>
            <td>
                <div class="attendee-thumb">
                    <div class="brand-icon view-info" data-attendee="<?php echo $att_res['att_id'];?>" style="background: #f7f7f7 url('<?php echo $uri;?>/uploads/<?php if($att_res['upload_logo']) { echo $att_res['upload_logo'];} else { echo 'company-logo.png'; }?>') no-repeat center;background-size: cover;"></div>
                    <a href="" data-toggle="modal" data-target="#attendeeInfo" class="view-info" data-attendee="<?php echo $att_res['att_id'];?>"><?php echo $att_res['company'];?></a>
                </div>
            </td>
            <td><?php echo $att_res['industry'];?></td>
            <td><?php echo $att_res['revenue'];?></td>
            <td><?php echo $att_res['company_size'];?></td>
            
            <?php if(isset($geo)) { ?>
                <td><?php echo $att_res['geo'];?> </td>          
            <?php } ?>
            
            <?php if(isset($warehouse)) { ?>
                <td><?php echo $att_res['facilities_equipment_interest'];?></td>  
                <td><?php echo $att_res['facilities_software_interest'];?></td>  
            <?php } ?>
                <form method="post" class="ex_star_form_<?php echo $att_res['att_id'];?>" autocomplete="off">
                <td>

                    <div class="star-num" id="star_rating_<?php echo $att_res['att_id'];?>"><?php if($att_res['stars'] ===NULL || $att_res['stars'] == 0) {echo '4';} else { echo $att_res['stars']; }?></div>


                    <!-- Display Star -->
                    <div class="star-toggler">

                        <div class="star-btns">
                            <div class="btn-group">
                                <label class="btn btn-star  star_<?php echo $att_res['att_id'];?> gold <?php if($att_res['stars'] == 1) { echo 'active'; } ?>" data-id="<?php echo $att_res['att_id'];?>"  data-star="gold">
                                    <input type="radio" class="change-rating" data-id="<?php echo $att_res['att_id'];?>" name="stars" value="1" id="option1" autocomplete="off" <?php if($att_res['stars'] == 1) { echo 'checked'; } ?>> 
                                    <i class="material-icons">star_rate</i>
                                </label>
                                <label class="btn btn-star  star_<?php echo $att_res['att_id'];?> silver <?php if($att_res['stars'] == 2) { echo 'active'; } ?>" data-id="<?php echo $att_res['att_id'];?>" data-star="silver">
                                    <input type="radio" class="change-rating" data-id="<?php echo $att_res['att_id'];?>" name="stars" value="2" id="option2" autocomplete="off" <?php if($att_res['stars'] == 2) { echo 'checked'; } ?>>
                                    <i class="material-icons">star_rate</i>
                                </label>
                                <label class="btn btn-star  star_<?php echo $att_res['att_id'];?> bronze <?php if($att_res['stars'] == 3) { echo 'active'; } ?>" data-id="<?php echo $att_res['att_id'];?>" data-star="bronze">
                                    <input type="radio" class="change-rating" data-id="<?php echo $att_res['att_id'];?>" name="stars" value="3" id="option3" autocomplete="off" <?php if($att_res['stars'] == 3) { echo 'checked'; } ?>>
                                    <i class="material-icons">star_rate</i>
                                </label>
                                <label class="btn btn-star  star_<?php echo $att_res['att_id'];?> none <?php if($att_res['stars'] == 4) { echo 'active'; } ?>" data-id="<?php echo $att_res['att_id'];?>" data-star="none">
                                    <input type="radio" class="change-rating" data-id="<?php echo $att_res['att_id'];?>" name="stars" value="4" id="option4" autocomplete="off" <?php if($att_res['stars'] == 4) { echo 'checked'; } ?>>
                                    <i class="material-icons">star_rate</i>
                                </label>              
                            </div>
                        </div>
                    </div>                    
                 
                    <input type="hidden" name="meta" value="<?php echo $att_res['stars'];?>" />
                    <input type="hidden" name="exhibitor_id" value="<?php echo $_SESSION['id'];?>" />
                    <input type="hidden" name="attendee_id" value="<?php echo $att_res['att_id'];?>" />
                    
                </td>
                <td>
                    <div class="star-num">
                        <?php if($att_res['rating']== NULL || $att_res['rating']==0) { echo '999999999999'; } else { echo $att_res['rating']; }?>
                    </div>
                    <input type="text" class="faux-input form-control change-rating" data-id="<?php echo $att_res['att_id'];?>" name="rating" value="<?php echo $att_res['rating'];?>" />
                </form>     
                </td>
            <td>
                <div class="btn-group">
                    <a href="" data-toggle="modal" data-target="#attendeeInfo" class="btn btn-secondary btn-sm view-info" data-attendee="<?php echo $att_res['att_id'];?>">Details</a>
                </div> 
            </td>



            <!--<td>
                all  
                <?php

                $att_id = $att_res['att_id'];
                echo $att_id;                                                

                $result = mysqli_query($mysqli, "
                SELECT attendees.*, attendee_meta.attendee_id, attendee_meta.question, attendee_meta.answer, attendee_meta.revenue, forms.id, forms.title FROM attendees
                LEFT JOIN attendee_meta ON attendees.id = attendee_meta.attendee_id
                LEFT JOIN forms ON forms.id = attendee_meta.question
                WHERE attendee_id='$att_id'");?>

                <?php while($res = mysqli_fetch_array($result)) {	?>

                    <div class="form-response">
                        <p class="question"><span>Q: </span><?php echo $res['title'];?></p>
                        <p class="answer"><span>A: </span><?php echo $res['answer'];?></p>
                    </div>

                <?php } ?>

            </td>-->
        </tr>



    <?php                                                                                                     
    }
}


// ADMIN: Attendees for Event 
function admin_attendees_by_event() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $ex_id = $_SESSION['id'];
    $attendee_result = mysqli_query($mysqli, "
    SELECT 
    attendees.id AS att_id, attendees.approved AS approved, attendees.name, attendees.company, attendees.company_size, attendees.industry, attendees.revenue, 
    attendees.geo, attendees.facilities_equipment_interest, attendees.facilities_software_interest 
    FROM attendees WHERE attendees.event = '$event'
    "); 
    ?>
    <?php while($att_res = mysqli_fetch_array($attendee_result)) {?>
        <tr>
            <td>
                <div class="attendee-thumb">
   <a href="" data-toggle="modal" data-target="#attendeeInfo" class="view-info" data-attendee="<?php echo $att_res['att_id'];?>"><?php echo $att_res['name'];?></a>
                </div>
            </td>
            <td><?php echo $att_res['company'];?></td>
            <td><?php echo $att_res['industry'];?></td>
            <td><?php echo $att_res['revenue'];?></td>
            <td><?php echo $att_res['company_size'];?></td>
            <td>
                <div class="btn-group">
                    <a href="" data-toggle="modal" data-target="#attendeeInfo" class="btn btn-info btn-sm view-info" data-attendee="<?php echo $att_res['att_id'];?>">Details</a>
                </div> 
            </td>

        </tr>

    <?php                
    }
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

// Add New Attendee
function add_attendee() {
    global $mysqli; 
    if(isset($_POST['add_attendee'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['direct_phone'];
        $company = $_POST['company'];
        $job_title = $_POST['job_title'];
        $password = randomPassword();
        $event = $_POST['event'];
        $result = mysqli_query($mysqli, "INSERT INTO attendees(
        name, email, event, direct_phone, company, job_title, password
        ) VALUES(
        '$name', '$email', '$event', '$phone', '$company', '$job_title', '$password'
        )");
        echo "<meta http-equiv='refresh' content='0'>";
    }
}

/******* Forms **********/

function check_form_existence() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "
    SELECT event FROM forms WHERE event='$event'");
    $num_rows = mysqli_num_rows($result);
    if($num_rows < 1):?>
        <div class="alert alert-info" role="alert">
            <strong>There are no forms associated with this event. Add one now.</strong><a href="<?php echo $uri;?>/admin/edit/?event=<?php echo $event;?>" class="btn btn-primary float-right">Add Form</a><div class="clearfix"></div>
        </div>
        <br><br>
    <?php endif;
}

function form_messages() {
    global $mysqli; 
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "SELECT * FROM forms WHERE event='$event' AND form_type=9");
    // Update Field
    if(isset($_POST['update_messages'])) {
        $intro = $_POST['intro'];
        $thank_you_message = $_POST['thank_you_message'];
        $t_c = $_POST['t_c'];
        $rules = $_POST['rules'];
        $meetings =  $_POST['meetings'];
        $result = mysqli_query($mysqli, "UPDATE forms SET
        form_type=9,
        intro='$intro',
        thank_you_message='$thank_you_message',
        t_c='$t_c',
        rules='$rules',
        meetings='$meetings'
        WHERE event=$event");
        echo "<meta http-equiv='refresh' content='0'>";
    } 
    while($res = mysqli_fetch_array($result)) { ?>

        <form method="post" action="">
            <input type="submit" value="Save" name="update_messages" class="btn btn-success btn-lg float-right" /><div class="clearfix"></div>
            <input type="hidden" name="id" value="<?php echo $res['id'];?>" />

            <div class="form-group"> 
                <label>Message<span>Message for the Registration Form</span></label>
                <div class="wysiwyg">
                   <div id='editControls'>
                     <div class="editor-controls btn-group">
                       <a class="btn" data-role='undo' href='javascript:void(0)'><i class='fa fa-undo'></i></a>
                       <a class="btn" data-role='bold' href='javascript:void(0)'><i class='fa fa-bold'></i></a>
                       <a class="btn" data-role='italic' href='javascript:void(0)'><i class='fa fa-italic'></i></a>
                       <a class="btn" data-role='underline' href='javascript:void(0)'><i class='fa fa-underline'></i></a>
                       <a class="btn" data-role='justifyLeft' href='javascript:void(0)'><i class='fa fa-align-left'></i></a>
                       <a class="btn" data-role='justifyCenter' href='javascript:void(0)'><i class='fa fa-align-center'></i></a>
                       <a class="btn" data-role='justifyRight' href='javascript:void(0)'><i class='fa fa-align-right'></i></a>
                       <a class="btn" data-role='insertUnorderedList' href='javascript:void(0)'><i class='fa fa-list-ul'></i></a>
                       <a class="btn" data-role='insertOrderedList' href='javascript:void(0)'><i class='fa fa-list-ol'></i></a>
                       <a class="btn" data-role='h1' href='javascript:void(0)'>h<sup>1</sup></a>
                       <a class="btn" data-role='h2' href='javascript:void(0)'>h<sup>2</sup></a>
                       <a class="btn" data-role='p' href='javascript:void(0)'>p</a>
                     </div>
                   </div>
                   <div id='editor' class="form-control" contenteditable><?php echo $res['intro'];?></div> 
                </div>
                <textarea id='output' name="intro" class="hidden-xl-down form-control"><?php echo $res['intro'];?></textarea>               
            </div>

            <div class="form-group">
                <label>Thank You Message<span>After attendee registers</span></label>
                <textarea name="thank_you_message" class="form-control"><?php echo $res['thank_you_message'];?></textarea>
            </div>
            
            <div class="form-group">
                <label>Rules of Engagement</label>
                <textarea name="rules" class="form-control"><?php echo $res['rules'];?></textarea>
            </div>
          
            <div class="form-group">
                <label>Schedule Meetings</label> 
                <textarea name="meetings" class="form-control"><?php echo $res['meetings'];?></textarea>
            </div>            
            
            <div class="form-group">
                <label>Terms and Conditions</label>
                <textarea name="t_c" class="form-control" value=""><?php echo $res['t_c'];?></textarea>
            </div>
            <input type="submit" value="Save" name="update_messages" class="btn btn-success btn-lg float-right" />
        </form>

    <?php } 
}
    
function form_fields() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $brand = $_GET['brand'];    
    // Get All Fields
    $result = mysqli_query($mysqli, "SELECT * FROM fields WHERE event='$event' ORDER BY order_no ASC");


    // Update Standard Field
    if(isset($_POST['update_field'])) {
        $id = $_POST['id'];
        $active = $_POST['active'];
        $order_no = $_POST['order_no'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $options = $_POST['options'];
        $required = $_POST['required'];
        $has_options = $_POST['has_options'];
        $conditional_child = $_POST['conditional_child'];
        $page=$_POST['page'];
        $result = mysqli_query($mysqli, "UPDATE fields SET
        id='$id',
        active='$active',
        order_no='$order_no',
        title='$title',
        description='$description',
        type='$type',
        options='$options',
        required='$required',
        has_options='$has_options',
        conditional_child='$conditional_child',
        page='$page'
        WHERE id='$id'");
        echo "<meta http-equiv='refresh' content='0'>";
    } 

    
    // Update Custom Field
    if(isset($_POST['update_custom_field'])) {
        $id = $_POST['id'];
        $order_no = $_POST['order_no'];
        $title = $_POST['title'];
        $type = $_POST['form_type'];
        $options = $_POST['field_options'];
        $required = $_POST['required'];
        $description = $_POST['description'];
        $page=$_POST['page'];
        $result = mysqli_query($mysqli, "UPDATE custom_fields SET
        id='$id',
        order_no='$order_no',
        title='$title',
        form_type='$type',
        field_options='$options',
        required='$required',
        description='$description',
        page='$page'
        WHERE id='$id'");
        echo "<meta http-equiv='refresh' content='0'>";
    }     
    
    $result_2 = mysqli_query($mysqli, "SELECT * FROM custom_fields WHERE event='$event'");
    while($res = mysqli_fetch_array($result_2)) {?>
                <li id="<?php echo $res['order_no'];?>">
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?php echo $res['id'];?>" />
                        <div class="card">
                            <div class="card-header" role="tab" id="field_<?php echo $i;?>">
                               <div class="row">
                                   <div class="col-4 col-sm-1 col-md-1">
                                       <span class="active-state active"><i class="material-icons">check</i></span>
                                   </div>
                                   <div class="col-8 col-sm-2 col-md-2">
                                       <span class="page">Page <?php echo $res['page'];?></span>
                                   </div>
                                   <div class="col-8 col-sm-2 col-md-1">
                                       <span class="order-no"><?php echo $res['order_no'];?></span>
                                   </div>
                                   <div class="col-12 col-sm-8 col-md-5">
                                       <p><?php echo $res['title'];?> - Custom Field - <?php if($res['form_type']==6) { echo '(Message)'; } ?></p>
                                   </div>
                                   <div class="col-12 col-sm-2 col-md-3">
                                       <div class="btn-group float-right">
                                           <a class="btn btn-info btn-sm" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>" aria-expanded="true" aria-controls="collapseOne">Edit</a>
                                           <input type="submit" class="btn btn-success btn-sm" name="update_custom_field" value="Save">
                                       </div>
                                   </div>
                               </div>
                            </div>
                            <div id="collapse_<?php echo $i;?>" class="collapse" role="tabpanel" aria-labelledby="field_<?php echo $i;?>">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-2 col-sm-2">
                                            <div class="form-group">
                                               <label>Page</label>
                                               <input type="text" class="form-control" name="page" value="<?php echo $res['page'];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                            <div class="form-group">
                                                <label>Order</label>
                                                <input type="text" class="form-control" name="order_no" value="<?php echo $res['order_no'];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-6">
                                            <div class="form-group">
                                                <label>Field Label</label>
                                                <input type="text" class="form-control" name="title" value="<?php echo $res['title'];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2">
                                           <div class="form-group">
                                              <label>Required?</label>
                                              <label class="custom-control custom-checkbox">
                                              <input type="checkbox" class="custom-control-input" value="1" name="required" <?php if($res['required']==1) { echo 'checked'; }?>>
                                              <span class="custom-control-indicator"></span>
                                              <span class="custom-control-description">Yes</span>
                                              </label>
                                           </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>Field Description</label>
                                                <input type="text" class="form-control" name="description" value="<?php echo $res['description'];?>">   
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-5">
                                            <div class="form-group">            
                                                <label>Field Type</label>
                                                <div class="field-btns" data-toggle="buttons">
                                                    <label class="btn btn-secondary btn-block <?php if($res['form_type']==1) { echo 'active'; } ?>">
                                                          <input type="radio" name="form_type" <?php if($res['form_type']==1) { echo 'checked'; } ?> id="option1" value="1" autocomplete="off">
                                                          <i class="material-icons">check</i>Checkbox - Multiple
                                                    </label>
                                                    <label class="btn btn-secondary btn-block <?php if($res['form_type']==2) { echo 'active'; } ?>">
                                                          <input type="radio" name="form_type" <?php if($res['form_type']==2) { echo 'checked'; } ?> id="option1" value="2" autocomplete="off">
                                                          <i class="material-icons">arrow_drop_down</i>Select - Single Select
                                                    </label>
                                                    <label class="btn btn-secondary btn-block <?php if($res['form_type']==3) { echo 'active'; } ?>">
                                                          <input type="radio" name="form_type" <?php if($res['form_type']==3) { echo 'checked'; } ?> id="option1" value="3" autocomplete="off">
                                                          <i class="material-icons">text_format</i>Text Input - Small Text Field
                                                    </label>
                                                    <label class="btn btn-secondary btn-block <?php if($res['form_type']==4) { echo 'active'; } ?>">
                                                          <input type="radio" name="form_type" <?php if($res['form_type']==4) { echo 'checked'; } ?> id="option1" value="4" autocomplete="off">
                                                          <i class="material-icons">short_text</i>Textarea - Large Text Area
                                                    </label>
                                                    <label class="btn btn-secondary btn-block <?php if($res['form_type']==5) { echo 'active'; } ?>">
                                                          <input type="radio" name="form_type" <?php if($res['form_type']==5) { echo 'checked'; } ?> id="option1" value="5" autocomplete="off">
                                                          <i class="material-icons">radio_button_checked</i>Yes / No
                                                    </label>
                                                    <label class="btn btn-secondary btn-block <?php if($res['form_type']==6) { echo 'active'; } ?>">
                                                          <input type="radio" name="form_type" <?php if($res['form_type']==6) { echo 'checked'; } ?> id="option1" value="6" autocomplete="off">
                                                          <i class="material-icons">chat</i>Message
                                                    </label>
                                                </div> 
                                            </div> 
                                        </div>
                                        <div class="col-xs-2 col-sm-7">
                                            <div class="form-group">
                                                <label>Options available (for types Single and Multi) -  One per line</label>
                                                <textarea name="field_options" class="form-control"><?php echo $res['field_options'];?></textarea>  
                                            </div>
                                       </div>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </form>
                </li>
    <?php }     

    $i=0; while($res = mysqli_fetch_array($result)) { $i++; ?>

    <li id="<?php echo $res['order_no'];?>">
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $res['id'];?>" />
            <div class="card <?php if($res['conditional_child']==1) { echo 'conditional'; }?>">
                <div class="card-header" role="tab" id="field_<?php echo $i;?>">
                   <div class="row">
                       <div class="col-4 col-sm-1 col-md-1">
                           <span class="active-state <?php if($res['active']==1) { echo 'active'; }?>"><i class="material-icons">check</i></span>
                       </div>
                       <div class="col-8 col-sm-2 col-md-2">
                           <span class="page">Page <?php echo $res['page'];?></span>
                       </div>
                       <div class="col-8 col-sm-2 col-md-1">
                           <span class="order-no"><?php echo $res['order_no'];?></span>
                       </div>
                       <div class="col-12 col-sm-8 col-md-5">
                           <p><?php echo $res['title'];?> <?php if($res['has_options']==1) { echo '(Conditional)'; }?></p>
                       </div>
                       <div class="col-12 col-sm-2 col-md-3">
                           <div class="btn-group float-right">
                               <a class="btn btn-info btn-sm" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>" aria-expanded="true" aria-controls="collapseOne">Edit</a>
                               <input type="submit" class="btn btn-success btn-sm" name="update_field" value="Save">
                           </div>
                       </div>
                   </div>
                </div>
                <div id="collapse_<?php echo $i;?>" class="collapse" role="tabpanel" aria-labelledby="field_<?php echo $i;?>">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <label>Active?</label>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-secondary <?php if($res['active']==1) { echo 'active'; } ?>">
                                            <input type="radio" name="active" <?php if($res[ 'active']==1) { echo 'checked'; } ?> id="option1" value="1" autocomplete="off">Yes
                                        </label>
                                        <label class="btn btn-secondary <?php if($res['active']==0) { echo 'active'; } ?>">
                                            <input type="radio" name="active" <?php if($res[ 'active']==0) { echo 'checked'; } ?> id="option1" value="0" autocomplete="off">No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 col-sm-2">
                                <div class="form-group">
                                   <label>Page</label>
                                   <input type="text" class="form-control" name="page" value="<?php echo $res['page'];?>">
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <label>Order</label>
                                    <input type="text" class="form-control" name="order_no" value="<?php echo $res['order_no'];?>">
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-6">
                                <div class="form-group">
                                    <label>Field Label</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo $res['title'];?>">
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                               <div class="form-group">
                                  <label>Required?</label>
                                  <label class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" value="1" name="required" <?php if($res['required']==1) { echo 'checked'; }?>>
                                  <span class="custom-control-indicator"></span>
                                  <span class="custom-control-description">Yes</span>
                                  </label>
                               </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Field Description</label>
                                    <input type="text" class="form-control" name="description" value="<?php echo $res['description'];?>">   
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-5">
                                <div class="form-group">            
                                    <label>Field Type</label>
                                    <div class="field-btns" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-block <?php if($res['type']==1) { echo 'active'; } ?>">
                                              <input type="radio" name="type" <?php if($res['type']==1) { echo 'checked'; } ?> id="option1" value="1" autocomplete="off">
                                              <i class="material-icons">check</i>Checkbox - Multiple
                                        </label>
                                        <label class="btn btn-secondary btn-block <?php if($res['type']==2) { echo 'active'; } ?>">
                                              <input type="radio" name="type" <?php if($res['type']==2) { echo 'checked'; } ?> id="option1" value="2" autocomplete="off">
                                              <i class="material-icons">arrow_drop_down</i>Select - Single Select
                                        </label>
                                        <label class="btn btn-secondary btn-block <?php if($res['type']==3) { echo 'active'; } ?>">
                                              <input type="radio" name="type" <?php if($res['type']==3) { echo 'checked'; } ?> id="option1" value="3" autocomplete="off">
                                              <i class="material-icons">text_format</i>Text Input - Small Text Field
                                        </label>
                                        <label class="btn btn-secondary btn-block <?php if($res['type']==4) { echo 'active'; } ?>">
                                              <input type="radio" name="type" <?php if($res['type']==4) { echo 'checked'; } ?> id="option1" value="4" autocomplete="off">
                                              <i class="material-icons">short_text</i>Textarea - Large Text Area
                                        </label>
                                        <label class="btn btn-secondary btn-block <?php if($res['type']==5) { echo 'active'; } ?>">
                                              <input type="radio" name="type" <?php if($res['type']==5) { echo 'checked'; } ?> id="option1" value="5" autocomplete="off">
                                              <i class="material-icons">radio_button_checked</i>Yes / No
                                        </label>
                                    </div> 
                                </div> 
                                <div class="form-group">
                                    <label>Conditional?</label>
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="1" name="has_options" <?php if($res['has_options']==1) { echo 'checked'; }?>>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Yes</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-7">
                                <div class="form-group">
                                    <label>Options available (for types Single and Multi) -  One per line</label>
                                    <textarea name="options" class="form-control"><?php echo $res['options'];?></textarea>  
                                </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </form>
        </li>
    <?php }
}

function email_messages() {
    global $mysqli; 
    $event = $_GET['event'];
    $brand = $_GET['brand'];
    $result = mysqli_query($mysqli, "SELECT * FROM forms WHERE event='$event' AND form_type=9");
    // Update Field
    if(isset($_POST['update_emails'])) {
        $from_email = $_POST['from_email'];
        $subject_admin = $_POST['subject_admin'];
        $message_admin = $_POST['message_admin'];
        $subject_registrant = $_POST['subject_registrant'];
        $message_registrant = $_POST['message_registrant'];
        $result = mysqli_query($mysqli, "UPDATE forms SET
        from_email='$from_email',
        subject_admin='$subject_admin',
        message_admin='$message_admin',
        subject_registrant='$subject_registrant',
        message_registrant='$message_registrant'
        WHERE Event='$event'");
        echo "<meta http-equiv='refresh' content='0'>";
    } 
    while($res = mysqli_fetch_array($result)) { ?>

        <form method="post" action="">
            <input type="submit" value="Save" name="update_emails" class="btn btn-success btn-lg float-right" /><div class="clearfix"></div>
            <h5>Email to Admin</h5>
            <div class="form-group">
                <label>From Email</label>
                <input type="text" class="form-control" name="from_email" value="<?php echo $res['from_email'];?>" />
            </div>
            <div class="form-group">
                <label>Subject Line to Admin</label>
                <input type="text" class="form-control" name="subject_admin" value="<?php echo $res['subject_admin'];?>" />
            </div>
            <div class="form-group">
                <label>Message to Admin</label>
                <textarea name="message_admin" class="form-control"><?php echo $res['message_admin'];?></textarea>
            </div>
            <hr>
            <h5>Email to Registrant</h5>
            <div class="form-group">
                <label>Subject Line to Registrant</label>
                <input type="text" class="form-control" name="subject_registrant" value="<?php echo $res['subject_registrant'];?>" />
            </div>
            <div class="form-group">
                <label>Message to Registrant</label>
                <textarea name="message_registrant" class="form-control"><?php echo $res['message_registrant'];?></textarea>
            </div>
            <input type="submit" value="Save" name="update_emails" class="btn btn-success btn-lg float-right" /><div class="clearfix"></div>
        </form>

    <?php } 
}

// Edit Event Info
function event_info_form() {
    global $mysqli; 
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "SELECT * FROM quartz_event WHERE id='$event'");
    // Update Field
    if(isset($_POST['update_info'])) {
        $color = $_POST['color'];
        $approval_notice = $_POST['approval_notice'];
        $admin_email = $_POST['admin_email'];
        $exhibitor_update_notice=$_POST['exhibitor_update_notice'];
        $attendee_update_notice=$_POST['attendee_update_notice'];
        $result = mysqli_query($mysqli, "UPDATE quartz_event SET
        color='$color',
        approval_notice='$approval_notice',
        admin_email = '$admin_email',
        exhibitor_update_notice='$exhibitor_update_notice',
        attendee_update_notice='$attendee_update_notice'
        WHERE id='$event'");
        echo "<meta http-equiv='refresh' content='0'>";
    } 
    while($res = mysqli_fetch_array($result)) { ?>
        <form method="post" action="">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <h3>Event Color</h3>
                        <label>HEX Color (exclude hash symbol)</label>
                        <input type="text" class="form-control" name="color" placeholder="000000" value="<?php echo $res['color'];?>" />
                    </div>     
                </div>
            </div>
            <hr><br>
            <div class="form-group">
                <h3>Message to Attendee upon approval</h3>
                <label>Attendee will receive this notice along with login credentials upon approval status</label>
                <textarea class="form-control" name="approval_notice"><?php echo $res['approval_notice'];?></textarea>
            </div> 
            <br><hr><br>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <h3>Notification Message to Admin  (Exhibitor Updates)</h3>
                        <label>Message sent to Admin (Email Below) when exhibitor updates profile.</label>
                        <input type="text" class="form-control" name="exhibitor_update_notice" placeholder="" value="<?php echo $res['exhibitor_update_notice'];?>" />
                    </div> 
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <h3>Notification Message to Admin (Attendee Updates)</h3>
                        <label>Message sent to Admin (Email Below) when attendee updates profile.</label>
                        <input type="text" class="form-control" name="attendee_update_notice" placeholder="" value="<?php echo $res['attendee_update_notice'];?>" />
                    </div>
                </div>
            </div>
            <br><hr><br>
            <div class="form-group">
                <h3>Message to Attendee upon approval</h3>
                <label>From Email (Admin Email)</label>
                <input type="email" class="form-control" name="admin_email" placeholder="" value="<?php echo $res['admin_email'];?>" />
            </div> 
            <br>
            <div class="form-group">
                <input type="submit" value="Update Event Info" name="update_info" class="btn btn-success" />
            </div> 
        </form>
    <?php } 
}

// Get Event Color
function get_event_color() {
    global $mysqli; 
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "SELECT * FROM quartz_event WHERE id='$event'");
    while($res = mysqli_fetch_array($result)) {
         echo '#'. $res['color'];
    } 
}

// View Created Custom Fields
function view_custom_fields() {
    global $mysqli; 
    $event = $_GET['event'];
    
    $result_view = mysqli_query($mysqli, "
    SELECT * FROM custom_fields WHERE event='$event'");?>

    <!-- Update Custom Fields -->
    <?php
    if(isset($_POST['create_custom'])) {
        // $brand = $_post['brand'];
        $order_no = $_POST['order_no'];
        $form_type = $_POST['form_type'];
        $required = $_POST['required'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $field_options = $_POST['field_options'];
        $page = $_POST['page'];
        
        $result = $mysqli->query("INSERT INTO custom_fields(event, order_no, form_type, required, title, description, field_options, page) VALUES('$event', '$order_no', '$form_type', '$required', '$title', '$description', $field_options', '$page')");
        
        /*
        $sql = 'INSERT INTO custom_fields (event, order_no, form_type, required, title, field_options) VALUES ';
        foreach ($_POST['title'] as $key => $value) {
            $sql .= '( '.$event . ','.$order_no .','.$form_type .','.$required.',\'' . $value . '\',\'' . $field_options . '\'),';
            // $sql .= '(\'' . $brand . ',' . $value . '\'),';
        }
        $sql = rtrim($sql, ','); 
        */
        
        // echo $sql; 
        // $result = mysqli_query($mysqli, $sql);   
        // $result_2 = mysqli_query($mysqli, $sql_2);    
            echo "<meta http-equiv='refresh' content='0'>";
        } ?>
    <!-- End Update Custom Fields -->

    <!-- Add Custom Fields -->
    <form method="post" action="">
        <div class="row">
            <div class="col-2 col-sm-2">
                <div class="form-group">
                   <label>Page</label>
                   <input type="text" class="form-control" name="page" value="">
                </div>
            </div>
            <div class="col-2 col-sm-2">
                <div class="form-group">
                   <label>Order</label>
                   <input type="text" class="form-control" name="order_no" value="">
                </div>
            </div>
            <div class="col-2 col-sm-6">
                <div class="form-group">
                   <label>Title</label>
                   <input type="text" class="form-control" name="title" />
                </div>
            </div>
            <div class="col-2 col-sm-2">
                <div class="form-group">
                   <label>Required?</label>
                   <label class="custom-control custom-checkbox">
                   <input type="checkbox" class="custom-control-input" value="1" name="required" <?php if($res['required']==1) { echo 'checked'; }?>>
                   <span class="custom-control-indicator"></span>
                   <span class="custom-control-description">Yes</span>
                   </label>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Field Description</label>
                    <input type="text" class="form-control" name="description">   
                </div>
            </div>
            <div class="col-12 col-sm-5">
                <div class="form-group">
                   <label>Type</label>
                   <div class="select-wrap">
                   <select class="form-control input-type" name="form_type">
                       <option selected disabled>Field Type</option>
                       <option value="1">Checkbock (Multi-select)</option>
                       <option value="2">Select (Single-Select)</option>
                       <option value="3">Text Input</option>
                       <option value="4">Textarea</option>
                       <option value="5">Yes/No</option>
                       <option value="6">Message</option>
                   </select>
                   </div>
                </div>
            </div>
            <div class="col-12 col-sm-7">
                <div class="form-group">
                   <label>Options available (for types Single and Multi) -  One per line</label>
                   <textarea name="field_options" class="form-control"></textarea>  
                </div>
            </div>
        </div>
    
        <div class="form-group">
            <input type="submit" value="Create Field" name="create_custom" class="btn btn-success float-right" />
            <div class="clearfix"></div>
        </div>
    </form>
    <hr>
    <h3>Current Custom Fields</h3>
    <table class="table table-responsive">
        <thead>
            <th>Order</th>
            <th>Field</th>
            <th>Type</th>
            <th>Options</th>
            <th></th>
        </thead>
        <tbody>
        <?php while($res = mysqli_fetch_array($result_view)) {if($res['title']):?>
        <tr>
            <td><?php echo $res['order_no'];?></td>
            <td><?php echo $res['title'];?></td>
                <td>
                <?php if($res['form_type'] == 1) { 
                echo 'Checkbox';
                } elseif($res['form_type'] == 2)  { 
                echo 'Select';
                } elseif($res['form_type'] == 3)  { 
                echo 'Textarea';
                } elseif($res['form_type'] == 4)  { 
                echo 'Input';
                } elseif($res['form_type'] == 5)  { 
                echo 'Yes/No';
                } else {
                echo 'Message';
                } ?>
            <td><?php echo $res['field_options'];?></td>
            <td>
            <a onClick="return confirm('Are you sure you want to delete?')" href="delete.php?id=<?php echo $res['id'];?>" class="btn btn-sm btn-danger">Delete Field</a>
        </tr>
        <?php endif; } ?>
        </tbody>
    </table>
    <?php 
}


// View Final Event Form
function preview_form() {
    global $mysqli; 
    $event = $_GET['event'];
    
    $result = mysqli_query($mysqli, "SELECT * FROM forms WHERE event=".$event." ORDER BY order_no ASC LIMIT 1");
    
    $custom_fields = mysqli_query($mysqli, "SELECT * FROM forms WHERE ORDER BY order_no ASC");?>
    
        <?php while($res = mysqli_fetch_array($result)) { ?>

                <div class="form-group form-intro">
   <?php echo $res['intro'];?>
                </div>
                <div class="form-group">
   <label>Name</label>
   <input type="text" class="form-control" name="name" value="" placeholder="Name">
                </div>
                <div class="form-group">
   <label>Email</label>
   <input type="text" class="form-control" name="email" value="" placeholder="Email">
                </div>
        <?php } ?>
            <!-- View Custom Fields -->
            <?php while($res = mysqli_fetch_array($custom_fields)) {
                // Replace spaces with underscores in title to add as field name
                $form_title = trim($res['title']);
                $form_title = str_replace(' ', '_', $form_title);  
                ?>
                
                <?php // Select Box 
   if($res['form_type'] == 2) { ?>
                <div class="col-12 col-sm-6 col-md-4">
   <div class="form-group">
       <label><?php echo $res['title'];?></label>
       <div class="select-wrap">
       <select class="form-control" name="question_[<?php echo $res['id'];?>]">
           <?php
           $text = trim($res['field_options']);   
           $textAr = explode("\n", $text);
           $textAr = array_filter($textAr, 'trim'); 
           foreach ($textAr as $line) { ?>
               <option value="<?php echo $line;?>"><?php echo $line;?></option>
           <?php } 
           ?> 
       </select>
       </div>
   </div>
   <?php // Checkboxes
   } elseif($res['form_type'] == 1) { ?>
       <div class="form-group">
       <label><?php echo $res['title'];?></label><br>
           <?php
           $text = trim($res['field_options']); 
           $textAr = explode("\n", $text);
           $textAr = array_filter($textAr, 'trim'); 
           foreach ($textAr as $line) { ?>
               <label class="custom-control custom-checkbox">
  <input type="checkbox" value="<?php echo $line;?>" name="question_[<?php echo $res['id'];?>]" class="custom-control-input">
  <span class="custom-control-indicator"></span>
  <span class="custom-control-description"><?php echo $line;?></span>
               </label>
           <?php } ?> 

       </div>
    <?php // Input field
       } elseif($res['form_type'] == 3) { ?>
       <div class="form-group">
           <?php $field_name = trim($res['title']);
           $field_name = str_replace(' ', '_', $field_name);?>
           <label><?php echo $res['title'];?></label>
           <input type="text" class="form-control" placeholder="<?php echo $res['title'];?>" value="" name="question_[<?php echo $res['id'];?>]">
       </div>

    <?php } else { ?>
            
                <?php } ?>

            <?php } ?>  
        
<?php  
} 

/******* Filter Data **********/

// Filter Events
function event_options() {
    global $mysqli; 
    $result = mysqli_query($mysqli, "
    SELECT events.id, events.name AS event_name, brands.id, brands.Event, brands.name AS brand_name
    FROM events, brands
    WHERE events.id = brands.Event
    ");
    while($res = mysqli_fetch_array($result)) { 
        $event_name = $res['event_name'];
        $brand_name = $res['brand_name'] 
        ?>
            <option value="<?php echo $brand_name;?> <?php echo $brand_name;?>"><?php echo $brand_name;?> <?php echo $event_name;?></option>  
        <?php
    }
}

// Show Custom Fields

function show_custom_fields($page) {
global $mysqli; 
$event = $_GET['event'];
$result_2 = mysqli_query($mysqli, "SELECT * FROM custom_fields WHERE event='$event' AND page='$page'");
while($res = mysqli_fetch_array($result_2)) {?>
    <li id="<?php echo $res['order_no'];?>">
        <div class="form-group">
        <label><?php echo $res['title'];?> </label>
        <?php if($res['form_type']=='6') { echo $res['description']; } ?>
        </div>
    </li>
<?php }    
    
}

// Form Fields Display

function standard_form_field($slug, $page) {
global $mysqli; 
$brand = $_GET['brand'];
$event = $_GET['event'];
$result = mysqli_query($mysqli, "SELECT * FROM fields WHERE event='$event' AND slug='$slug' AND page='$page'");
while($res = mysqli_fetch_array($result)) { ?>              
                     
    <?php if($res['active'] == 1):?>
    <li id="<?php echo $res['order_no'];?>">
        <div class="form-group <?php if($res['required']==1) { echo 'required'; } ?>">
            <label class="title"><?php echo $res['title'];?> <?php if($res['required']==1) { echo '*'; } ?> <span><?php echo $res['description'];?></span></label>
            <!-- Checkbox -->
            <?php if($res['type'] == 1): ?>
                <div class="form-check">
                <?php
                $text = trim($res['options']); 
                $textAr = explode("\n", $text);
                $textAr = array_filter($textAr, 'trim'); 
                foreach ($textAr as $line) { ?>
                   <label class="form-check-label">
                       <input class="form-check-input has-other-field" <?php if($res['required']==1) { echo 'required="" required'; } ?> type="checkbox" name="<?php echo $slug;?>" value="<?php echo $line;?>" data-id="<?php echo $res['slug'];?>"> <?php echo $line;?>
                   </label>
                <?php } ?> 
                    <input class="form-control other-input hidden_input" id="<?php echo $res['slug'];?>" type="text" placeholder="Other" />
                </div>
            <?php endif;?>

            <!-- Select -->
            <?php if($res['type'] == 2): ?>
                <div class="select-wrap">
               <select class="form-control has-other has-other-field" id="field_<?php echo $res['slug'];?>" <?php if($res['required']==1) { echo 'required="" required';  } ?> name="<?php echo $res['slug'];?>" data-id="<?php echo $res['slug'];?>">
                   <option value="-">-</option>
                   <?php 
                   $text = trim($res['options']); 
                   $textAr = explode("\n", $text);
                   $textAr = array_filter($textAr, 'trim'); 
                   foreach ($textAr as $line) { ?>
                       <option value="<?php echo $line;?>"><?php echo $line;?></option>
                   <?php } 
                   ?> 
               </select>
                </div>
                <input class="form-control other-input hidden_input" id="<?php echo $res['slug'];?>" type="text" placeholder="Other" />
            <?php endif;?>

            <!-- Input -->
            <?php if($res['type'] == 3): ?>
                <input type="text" class="form-control" <?php if($res['required']==1) { echo 'required=""'; } ?> name="<?php echo $res['slug'];?>">
            <?php endif;?>

            <!-- Textarea -->
            <?php if($res['type'] == 4): ?>
                <textarea class="form-control" <?php if($res['required']==1) { echo 'required=""';  } ?> name="<?php echo $res['slug'];?>"></textarea>
            <?php endif;?>
            
            <!-- Textarea -->
            <?php if($res['type'] == 5): ?>
                <div class="form-check">
                   <label class="form-check-label <?php if($res['has_options']==1) { echo 'has-other'; } ?>" data-id="<?php echo $slug;?>">
                   <input class="form-check-input" type="radio" name="<?php echo $res['slug'];?>" id="exampleRadios1" name="<?php echo $slug;?>" value="yes"> Yes</label>
                   <label class="form-check-label  <?php if($res['has_options']==1) { echo 'has-other'; } ?>" data-id="<?php echo $slug;?>">
                   <input class="form-check-input" type="radio" name="<?php echo $res['slug'];?>" id="exampleRadios1" name="<?php echo $slug;?>" value="No"> No</label>
                </div> 
            <?php endif;?>            
  
        </div>
    </li>          

    <?php endif;?>             
<?php } 
}

// Attendee Edit Form Fields
function standard_form_field_attendee_edit($slug) {
global $mysqli; 
$brand = $_GET['brand'];
$event = $_GET['event'];
$attendee = $_GET['id'];
$result_1 = mysqli_query($mysqli, "SELECT * FROM attendees WHERE id='$attendee'");
    while($res_1 = mysqli_fetch_array($result_1)) { 
        $this_event  = $res_1['event'];     
        $result = mysqli_query($mysqli, "SELECT * FROM fields WHERE event='$this_event' AND slug='$slug'");
        while($res = mysqli_fetch_array($result)) { ?>    
            <?php if($res['active'] == 1):?>
                <div class="form-group <?php if($res['required']==1) { echo 'required'; } ?>">
                    <label class="title"><?php echo $res['title'];?> <?php if($res['required']==1) { echo '*'; } ?> <span><?php echo $res['description'];?></span></label>
                    
                    <p class="att_answer"><?php echo $res_1[$slug];?></p>
                    
                    <!-- Checkbox -->
                    <?php if($res['type'] == 1): ?>
                        <div class="form-check">
                        <?php
                        $text = trim($res['options']); 
                        $textAr = explode("\n", $text);
                        $textAr = array_filter($textAr, 'trim'); 
                        foreach ($textAr as $line) { ?>
                           <label class="form-check-label">
                               <input class="form-check-input has-other-field" type="checkbox" name="<?php echo $slug;?>" value="<?php echo $line;?>" data-id="<?php echo $res['slug'];?>"> <?php echo $line;?>
                           </label>
                        <?php } ?> 
                            <input class="form-control other-input hidden_input" id="<?php echo $res['slug'];?>" type="text" placeholder="Other" />
                        </div>
                    <?php endif;?>

                    <!-- Select -->
                    <?php if($res['type'] == 2): ?>
                        <div class="select-wrap">
                       <select class="form-control has-other has-other-field" id="field_<?php echo $res['slug'];?>" name="<?php echo $res['slug'];?>" data-id="<?php echo $res['slug'];?>">
                           <option value="-">-</option>
                           <?php 
                           $text = trim($res['options']); 
                           $textAr = explode("\n", $text);
                           $textAr = array_filter($textAr, 'trim'); 
                           foreach ($textAr as $line) { ?>
                               <option value="<?php echo $line;?>"><?php echo $line;?></option>
                           <?php } 
                           ?> 
                       </select>
                        </div>
                        <input class="form-control other-input hidden_input" id="<?php echo $res['slug'];?>" type="text" placeholder="Other" value="<?php echo $res_1[$slug];?>" />
                    <?php endif;?>

                    <!-- Input -->
                    <?php if($res['type'] == 3): ?>
                        <input type="text" class="form-control" name="<?php echo $res['slug'];?>" value="<?php echo $res_1[$slug];?>">
                    <?php endif;?>

                    <!-- Textarea -->
                    <?php if($res['type'] == 4): ?>
                    <?php echo $res_1[$slug];?>
                        <textarea class="form-control"  name="<?php echo $res['slug'];?>"><?php echo $res_1[$slug];?></textarea>
                    <?php endif;?>

                    <!-- Textarea -->
                    <?php if($res['type'] == 5): ?>
                        <div class="form-check">
                           <label class="form-check-label <?php if($res['has_options']==1) { echo 'has-other'; } ?>" data-id="<?php echo $slug;?>">
                           <input class="form-check-input" type="radio" name="<?php echo $res['slug'];?>" id="exampleRadios1" name="<?php echo $slug;?>" value="yes"> Yes</label>
                           <label class="form-check-label  <?php if($res['has_options']==1) { echo 'has-other'; } ?>" data-id="<?php echo $slug;?>">
                           <input class="form-check-input" type="radio" name="<?php echo $res['slug'];?>" id="exampleRadios1" name="<?php echo $slug;?>" value="No"> No</label>
                        </div> 
                    <?php endif;?>            

                </div>
            <?php endif;?>             
        <?php } 
    }
}

// Form Messages
function form_message($slug) {
global $mysqli; 
$brand = $_GET['brand'];
$event = $_GET['event'];
$result = mysqli_query($mysqli, "SELECT $slug FROM forms WHERE event='$event'");
while($res = mysqli_fetch_array($result)) {            
    echo $res[$slug];            
    } 
}

function filter_field($slug, $filter, $field) {
global $mysqli; 
$brand = $_GET['brand'];
$event = $_GET['event'];
$result = mysqli_query($mysqli, "SELECT * FROM fields WHERE event='$event' AND slug='$slug'");
while($res = mysqli_fetch_array($result)) { ?>                  
    <div class="filter">
    <div class="select-wrap">
        <h5><?php echo $res['title'];?></h5>
        <select class="form-control filter-select industry-filter" name="<?php echo $res['slug'];?>" data-column-index='<?php echo $filter;?>' data-filter="<?php echo $field;?>" data-test="<?php echo $res['slug'];?>"> 
            <?php
            $text = trim($res['options']); 
            $textAr = explode("\r\n", $text);
            $textAr = array_filter($textAr, 'trim');
                            
            foreach ($textAr as $line) { ?>
                <option value="<?php echo $line;?>"><?php echo $line;?></option>
            <?php } 
            ?> 
        </select>
    </div>       
    </div>
<?php } 
}

/*********** COUNT RANKS ***************/

function count_ranks() {
    global $mysqli; 
    global $uri;
    $brand_id = $_GET['brand'];
    $event_id = $_GET['event'];
    $exhibitor = $_SESSION['id'];
    $query = "SELECT COUNT(*) AS SUM FROM exhibitors_meta WHERE exhibitor_id='$exhibitor'";
    $result = mysqli_query($mysqli,$query);
    $rows = mysqli_fetch_assoc($result);
    $ex_ranks = $rows['SUM'];
    $result = mysqli_query($mysqli, "SELECT rank_amount FROM exhibitors WHERE id='$exhibitor'");
    while($res = mysqli_fetch_array($result)) { ?>
        <span class="total"><?php echo $ex_ranks;?> / <?php echo $res['rank_amount'];?> required attendees ranked</span>

    <?php }
}


/*********** UPDATE RANK STATUS FOR EXHIBITORS ***************/

function update_rank_status() {
    global $mysqli; 
    global $uri;
    $exhibitor = $_SESSION['id'];
    $result_view = mysqli_query($mysqli, "
    SELECT completed FROM exhibitors WHERE id='$exhibitor'");
    if(isset($_POST['update_ranks'])) {
        $rating = $_POST['completed'];
        $result = mysqli_query($mysqli, "UPDATE exhibitors SET
        completed='$rating'
        WHERE id='$exhibitor'");
        echo "<meta http-equiv='refresh' content='0'>";
    }
    while($res = mysqli_fetch_array($result_view)) { 
        if($res['completed'] == 1) { ?>
            <div class="success-box"><p>Great, you're all done rating!</p></div>
        <?php } else { ?>
            <form method="post" action="" class="float-right">
                <input type="hidden" name="completed" value="1" />
                <input type="submit" value="I'm Done Rating" name="update_ranks" class="btn btn-success" />
            </form>      
        <?php } ?>
    <?php }
}

/*********** ATTENDEE REGISTRATION ***************/

// Attendee Registration

function register_attendee_HOLD() {
    global $mysqli; 
    global $uri; 
    $event_id = $_GET['event'];

    if(isset($_POST['submit_form'])) {
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
        $result = $mysqli->query("INSERT INTO attendees(
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
            finished
        )VALUES(
            '3',
            '$event_id',
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
            '1'
        )");?>
        <script>
            // window.location = "./thanks";
            window.location = "../thanks/?id=<?php echo $last_id;?>&event=<?php echo $event_id;?>";
        </script>    
        <?php
    } 
}

function register_attendee() {
    global $mysqli; 
    global $uri; 
    $event_id = $_GET['event'];

    if(isset($_POST['submit_form'])) {

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
        // $t_c  = $_POST['t_c'];
        $logo_use  = $_POST['logo_user'];
        
        if(isset($_POST['logo_use'])) {
            $finished = '1';
        } else {
            $finished = '0';
        }
        
        $result = $mysqli->query("INSERT INTO attendees(
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
            '3',
            '$event_id',
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
            
        /*
            // Email Message to Registrant
            // $to = $from_email; // To Attendee Email
            // $from = $from_email; // From Admin Email
            $to = 'lyuba.nova@eatsleepwork.com'; // To Attendee Email
            $from = 'lyuba.nova@eatsleepwork.com';
             
            $name = $name;
            $subject = "Form submission";
            $subject2 = "Copy of your form submission";
            $message = $name . " wrote the following:" . "\n\n" . $company;
            $message2 = "Here is a copy of your message " . $name . "\n\n" . $company;

            $headers = "From:" . $from;
            $headers2 = "From:" . $to;
            mail($to,$subject,$message,$headers);
            mail($from,$subject2,$message2,$headers2); 

            

        // Send Email to Admin that Attendee has registered
        $to      = 'john.chimmy@eatsleepwork.com';
        $subject = 'attendee has Registered';
        $message = "$name has registered for an event. View attendee: $uri/attendees/?id=$last_id ";
        $headers = 'From: admin@quartz.com' . "\r\n" .
            // 'Reply-To: admin@quartz.com' . "\r\n" .
             'Reply-To: lyuba.nova@eatsleepwork.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers); 
      
        */
            
        /*
        foreach($_POST["question_"] as $key => $val){
            $result_2 = mysqli_query($mysqli, "INSERT INTO attendee_meta(attendee_id,question, answer) VALUES('$last_id','$key', '$val')");
        } 
        */
        
        // echo "<meta http-equiv='refresh' content='0'>";

        ?>

        <script>
            // window.location = "./thanks";
            window.location = "../thanks/?id=<?php echo $last_id;?>&event=<?php echo $event_id;?>";
        </script>
        <?php
    }
} 




// Attendee Registration
function send_email() {
    global $mysqli; 
    global $uri; 
    $event_id = $_GET['event'];
    $attendee = $_GET['id'];

} 


/*
// Form Fields Display
function form_question($slug) {
global $mysqli; 
$brand = $_GET['brand'];
$event = $_GET['event'];
$attendee = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM fields WHERE slug='$slug' AND Event='$event' AND brand='$brand'");
    while($res = mysqli_fetch_array($result)) {                          
        echo $res['title'];         
    } 
}

function form_answer($slug) {
global $mysqli; 
$brand = $_GET['brand'];
$event = $_GET['event'];
$attendee = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM attendees WHERE id='$attendee'");
    while($res = mysqli_fetch_array($result)) {                          
        echo $res[$slug];         
    } 
}

*/

function standard_att_response() {
global $mysqli; 
$attendee = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM attendees WHERE id='$attendee'");   
while($res = mysqli_fetch_array($result)) {     
?>
    <div class="form-response">
        <p><span class="question">Company </span><?php echo $res['company'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Name </span><?php echo $res['name'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Job title </span><?php echo $res['job_title'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Email </span><?php echo $res['email'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Direct Phone </span><?php echo $res['direct_phone'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Cell Phone </span><?php echo $res['cell_phone'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Fax </span><?php echo $res['fax'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Website </span><a href="<?php echo $res['website'];?>" target="_blank"><?php echo $res['website'];?></a></p>
    </div>
    <div class="form-response">
        <p><span class="question">Address </span><?php echo $res['address'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">City </span><?php echo $res['city'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">State </span><?php echo $res['state'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Zip </span><?php echo $res['zip'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Country </span><?php echo $res['country'];?></p>
    </div>
    <div class="form-response">
        <p><span class="question">Track </span><?php echo $res['track'];?></p>
    </div>            
                    
                    
    <?php 
     }
}

function exhibitor_att_response() {
global $mysqli; 
$brand = $_GET['brand'];
$event = $_GET['event'];
$attendee = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM attendees WHERE id='$attendee'");   
while($res = mysqli_fetch_array($result)) {     
?>
               
    <h4 class="job-title"><?php echo $res['job_title'];?></h4>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="form-response">
                <p><span class="question">Company </span><?php echo $res['company'];?></p>
            </div>
            <div class="form-response">
                <p><span class="question">Job title </span><?php echo $res['job_title'];?></p>
            </div>
            <div class="form-response">
                <p><span class="question">Website </span><a href="<?php echo $res['website'];?>" target="_blank"><?php echo $res['website'];?></a></p>
            </div>
        </div>  
        <div class="col-12 col-sm-12 col-md-6">
            <div class="form-response">
                <p><span class="question">Address </span><?php echo $res['address'];?></p>
            </div>
            <div class="form-response">
                <p><span class="question">City </span><?php echo $res['city'];?></p>
            </div>
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6">
                    <div class="form-response">
                        <p><span class="question">State </span><?php echo $res['state'];?></p>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6">
                    <div class="form-response">
                        <p><span class="question">Zip </span><?php echo $res['zip'];?></p>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6">
                    <div class="form-response">
                        <p><span class="question">Country </span><?php echo $res['country'];?></p>
                    </div>
                </div>
            </div> 
        </div>  
    </div>                         
    <?php 
     }
}

function att_response() {
global $mysqli; 
$att_id = $_GET['id'];
    $result_2 = mysqli_query($mysqli, "
    SELECT attendees.*, attendees.Event AS attendee_event, attendees.id AS user_id, fields.* FROM attendees, fields
    WHERE attendees.id = '$att_id' AND fields.event = attendees.event
    ");
    /*
    SELECT attendees.*, attendees.Event AS attendee_event, attendees.id AS user_id, fields.* FROM attendees, fields
    WHERE attendees.id = '$att_id' AND fields.Event = attendees.Event AND fields.brand = attendees.brand 
    */
    echo '<div class="row">';
    while($res = mysqli_fetch_array($result_2)) {    
    $field = $res['slug'];
    $title = $res['title'];
        $result_answers = mysqli_query($mysqli, "
        SELECT attendees.* FROM attendees
        WHERE attendees.id = '$att_id'
        "); 

        while($res = mysqli_fetch_array($result_answers)) {  
            if($res[$field]) {
            echo '<div class="col-12 col-sm-12 col-md-6"><p><span class="question">'.$title.'</span>';
            echo $res[$field];
            echo '</p></div>';
            }
        }
    }    
    echo '</div>';
}

// Thank You Message to Registrant
function thank_you() {
    global $mysqli; 
    $event = $_GET['event'];
    $attendee = $_GET['id'];

    $result = mysqli_query($mysqli, "
    SELECT forms.from_email AS from_email, forms.thank_you_message AS thank_you_message, forms.subject_admin AS subject_admin, forms.message_admin AS message_admin, forms.message_registrant AS message_registrant, forms.subject_registrant AS subject_registrant, forms.message_registrant AS message_registrant, forms.event,
    
    attendees.*, 
    attendees.name AS name, 
    attendees.company AS company,
    attendees.email AS att_email
    
    FROM forms
    LEFT JOIN attendees ON forms.Event = attendees.Event
    WHERE attendees.id='$attendee' AND forms.event='$event'");    
 
    while($res = mysqli_fetch_array($result)) { ?>
            <h1>Thank you, your registration for <?php event_name();?> is complete.</h1>
            <hr>
            <p class="lead"><?php echo $res['thank_you_message']; ?></p>
            
            <?php 
            // Email to Registrant
            $subject_registrant = $res['subject_registrant'];
            $message_registrant = $res['message_registrant'];     
                                                                            
            $to = $res['att_email'];
            $from = $res['from_email'];
            $subject = $subject_registrant; 
            $message = $message_registrant;
                  
            // Registrant Information                                
            $name = $res['name'];    
            $company = $res['company'];   
        
            // Not yet added Fields
            $email = $res['att_email'];
            $job_title= $res['job_title'];
            $address= $res['address'];
            $city= $res['city'];
            $state= $res['state'];
            $zip= $res['zip'];
            $country= $res['country'];
            $alt_email  = $res['alt_email'];
            $direct_phone  = $res['direct_phone'];
            $cell_phone  = $res['cell_phone'];
            $fax  = $res['fax'];
            $website  = $res['website'];
            $revenue  = $res['revenue'];
            $company_size  = $res['company_size'];
            $track = $res['track'];
            $industry  = $res['industry'];
            $scheduling  = $res['scheduling'];
            $erp  = $res['erp'];
            $geo  = $res['geo'];
            $warehouse  = $res['warehouse'];
            $number_facilities  = $res['number_facilities'];
            $facility_responsibilities  = $res['facility_responsibilities'];
                                               
            $facilities_size  = $res['facilities_size'];
            $facilities_equipment_interest  = $res['facilities_equipment_interest'];
            $facilities_software_interest  = $res['facilities_software_interest'];
            $facilities_projects  = $res['facilities_projects'];
            $transportation_responsibility  = $res['transportation_responsibility'];
            $ftl  = $res['ftl'];
            $ltl  = $res['ltl'];
            $intermodel  = $res['intermodel'];
            $parcel  = $res['parcel'];
            $modes_transporation  = $res['modes_transporation'];
            $tansportation_interest  = $res['tansportation_interest'];
            $transportation_projects  = $res['transportation_projects'];
            $threepls  = $res['threepls'];
            $footprint  = $res['footprint'];
            $threepl_interest  = $res['threepl_interest'];
            $threepl_projects  = $res['threepl_projects'];
            $supply_responsibility  = $res['supply_responsibility'];
            $supply_services  = $res['supply_services'];
            $supply_projects  = $res['supply_projects'];
            $procurement  = $res['procurement'];
            $procurement_projects  = $res['procurement_projects']; 
            $procurement_interest  = $res['procurement_interest'];
                                               
            $att_info = " Name: ".$name. "\r\n Email: ".$email. "\r\n Company: ".$company. "\r\n Job Title: ".$job_title. "\r\n Address: ".$address. "\r\n City: ".$city."\r\n State: ".$state."\r\n Zip: ".$zip."\r\n Country: ".$country.
            "\r\n Revenue: ".$revenue.
            "\r\n Company Size: ".$company_size.
            "\r\n Industry: ".$industry.
            "\r\n ERP: ".$erp.
            "\r\n GEO Location: ".$geo.
            "\r\n Warehouse Responsibility: ".$warehouse.
            "\r\n Number of Facilities: ".$number_facilities.
            "\r\n Facility Responsibilities: ".$facility_responsibilities.
            "\r\n Facilities Size: ".$facilities_size.
            "\r\n Facilities Equipment INterest: ".$facilities_equipment_interest.
            "\r\n Facilities Software Interest: ".$facilities_software_interest.
            "\r\n Facilities Projects: ".$facilities_projects.
            "\r\n Transportation Respobility: ".$transportation_responsibility.
            "\r\n FTL: ".$ftl.
            "\r\n LTL: ".$ltl.
            "\r\n Intermodel: ".intermodel. 
            "\r\n Modes of Transporation: ".$modes_transporation.
            "\r\n Transporation Interest: ".$tansportation_interest.
            "\r\n Transporation Projects: ".$transportation_projects.
            "\r\n 3PLs: ".$threepls.
            "\r\n Footprint: ".$footprint.
            "\r\n 3PL Interest: ".$threepl_interest.
            "\r\n Supply Chain Responsibility: ".$supply_responsibility.
            "\r\n Supply Chain Services: ".$supply_services.
            "\r\n Procurement Inolvement: ".$procurement.
            "\r\n Procurement Projects: ".$procurement_projects.
            "\r\n Procurement Interest: ".$procurement_interest;  
                                               
            $txt = $message_registrant. "\r\n \r\n" .$att_info;                           
                                               
            $headers = "From: " .$from. "\r\n" .
            "CC: lyuba.nova@eatsleepwork.com";
                                               
            // mail($to,$subject,$txt,$headers);                                       
                                 
    } 
}


/*********** LOGO UPLAODS ***************/

// Upload Brand Logo
function upload_logo() {
    global $mysqli; 
    $brand_id = $_GET['brand'];

    if(isset($_POST['btn-upload']))
    {    
        $brand = $brand_id;
        
        $exhibitor = mt_rand(10000000, 99999999);
        $attendee = mt_rand(10000000, 99999999);
        
        $file = rand(1000,100000)."-".$_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        // $folder="../../uploads";
        $folder="../../uploads/";

        // new file size in KB
        $new_size = $file_size/1024;  
        // new file size in KB

        // make file name in lower case
        $new_file_name = strtolower($file);
        // make file name in lower case

        $final_file=str_replace(' ','-',$new_file_name);

        if(move_uploaded_file($file_loc,$folder.$final_file))
        {
          
        mysqli_query($mysqli, "
        INSERT INTO uploads (brand, exhibitor_id, attendee_id, file,type,size) VALUES('$brand', '$exhibitor', '$attendee', '$final_file','$file_type','$new_size')
        ON DUPLICATE KEY
        UPDATE file='$final_file', type='$file_type', size='$new_size'
        ");   
        
        echo "<meta http-equiv='refresh' content='0'>";
            
 
        }
 
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="upload-logo">
        <div class="form-group">
            <label>Upload Brand Logo</label>
            <input type="hidden" name="brand" value="<?php echo $brand_id;?>">
            <div class="form-group file-upload">
                <input type="file" name="file" class="btn btn-secondary" />
            </div>
            <button type="submit" name="btn-upload" class="btn btn-success">Upload</button>
        </div>        
    </form>

<?php }

// Upload Exhibitor Logo
function upload_exhibitor_logo() {
    global $mysqli; 
    $exhibitor = $_GET['id'];
    

    if(isset($_POST['btn-upload']))
        
    {    
        $exhibitor_id = $_GET['id'];
        $brand = mt_rand(10000000, 99999999);
        $attendee = mt_rand(10000000, 99999999);
    
        $file = rand(1000,100000)."-".$_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $folder="../../uploads/";
        $new_size = $file_size/1024;  
        $new_file_name = strtolower($file);
        $final_file=str_replace(' ','-',$new_file_name);
        if(move_uploaded_file($file_loc,$folder.$final_file))
        {
        mysqli_query($mysqli, "
        INSERT INTO uploads (brand, exhibitor_id, attendee_id, file,type,size) VALUES('$brand', '$exhibitor_id', '$attendee', '$final_file','$file_type','$new_size')
        ON DUPLICATE KEY 
        UPDATE file='$final_file', type='$file_type', size='$new_size'
        ");   
        echo "<meta http-equiv='refresh' content='0'>";
     }
     else
     {
  
     }
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data" class="upload-logo">
        <div class="form-group">
            <label>Upload Logo</label>
            <div class="form-group file-upload">
                <input type="file" name="file" class="btn btn-secondary" />
            </div>
            <button type="submit" name="btn-upload" class="btn btn-success">Upload</button>
        </div>        
    </form>

<?php }


// Upload Attendee Logo
function upload_attendee_logo() {
    global $mysqli; 
    $attendee = $_GET['id'];

    if(isset($_POST['btn-upload']))
        
    {    
        $attendee = $_GET['id'];
        $brand = mt_rand(10000000, 99999999);
        $exhibitor_id = mt_rand(10000000, 99999999);
    
        $file = rand(1000,100000)."-".$_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $folder="../../uploads/";
        $new_size = $file_size/1024;  
        $new_file_name = strtolower($file);
        $final_file=str_replace(' ','-',$new_file_name);
        if(move_uploaded_file($file_loc,$folder.$final_file))
        {
        mysqli_query($mysqli, "
        INSERT INTO uploads (brand, exhibitor_id, attendee_id, file,type,size) VALUES('$brand', '$exhibitor_id', '$attendee', '$final_file','$file_type','$new_size')
        ON DUPLICATE KEY 
        UPDATE file='$final_file', type='$file_type', size='$new_size'
        ");   
        echo "<meta http-equiv='refresh' content='0'>";
     }
     else
     {
  
     }
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data" class="upload-logo">
        <div class="form-group">
            <label>Upload Logo</label>
            <div class="form-group file-upload">
                <input type="file" name="file" class="btn btn-secondary" />
            </div>
            <button type="submit" name="btn-upload" class="btn btn-success">Upload</button>
        </div>        
    </form>

<?php }

// Show Brand Logo
function brand_logo($slug, $slug_2) {
    global $mysqli; 
    global $uri;
    $field = $_GET[$slug]; 
    // $field = $_GET[$slug];
    // $brand_result = mysqli_query($mysqli, "SELECT * FROM uploads WHERE brand='$brand_id' ORDER BY id DESC LIMIT 1");
    $brand_result = mysqli_query($mysqli, "
    SELECT uploads.*, brands.*, quartz_event.* FROM uploads
    LEFT JOIN brands ON brands.id = uploads.brand
    LEFT JOIN quartz_event ON uploads.brand = quartz_event.brand
    WHERE quartz_event.$slug_2 = $field
    ");  ?>                      
    <figure class="brand-logo">
        <?php while($brand = mysqli_fetch_array($brand_result)) {?>
            <img src="<?php echo $uri;?>/uploads/<?php echo $brand['file'];?>" class="" />
        <?php } ?>
    </figure>  
<?php }


function brand_logo_img() {
    global $mysqli; 
    global $uri;
    $brand = $_GET['brand'];
    $brand_result = mysqli_query($mysqli, "
    SELECT uploads.*, brands.id FROM uploads
    LEFT JOIN brands ON brands.id = uploads.brand
    WHERE brands.id = $brand
    ");  ?>                    
    <figure class="brand-logo">
        <?php while($brand = mysqli_fetch_array($brand_result)) {?>
            <img src="<?php echo $uri;?>/uploads/<?php echo $brand['file'];?>" class="" />
        <?php } ?>
    </figure>  
<?php }


// Show Exhibitor Logo
function exhibitor_logo() {
    global $mysqli; 
    global $uri;
    // $exhibitor = $_SESSION['id'];
    if($_SESSION['permission']==1) {
        $exhibitor = $_GET['id'];
    } else {
        $exhibitor = $_SESSION['id'];
    }
    $brand_result = mysqli_query($mysqli, "SELECT * FROM uploads WHERE exhibitor_id='$exhibitor' ORDER BY id DESC LIMIT 1");?>
    <figure class="brand-logo">
        <?php if($brand_result->num_rows === 0) { ?>
            <img src="<?php echo $uri;?>/uploads/user-logo.png" class="" />
        <?php } else { ?>
            <?php while($brand = mysqli_fetch_array($brand_result)) {?>
            <img src="<?php echo $uri;?>/uploads/<?php echo $brand['file'];?>" class="" />
            <?php } ?>
        <?php } ?> 
    </figure> 
<?php }


// Show Attendee Logo
function attendee_logo() {
    global $mysqli; 
    global $uri;
    // $attendee = $_SESSION['id'];
    $attendee = $_GET['id'];
    $brand_result = mysqli_query($mysqli, "SELECT * FROM uploads WHERE attendee_id='$attendee' ORDER BY id DESC LIMIT 1");?>
    <figure class="brand-logo">
        <?php if($brand_result->num_rows === 0) { ?>
            <img src="<?php echo $uri;?>/uploads/company-logo.png" class="" />
        <?php } else { ?>
            <?php while($brand = mysqli_fetch_array($brand_result)) {?>
            <img src="<?php echo $uri;?>/uploads/<?php echo $brand['file'];?>" class="" />
            <?php } ?>
        <?php } ?> 
    </figure> 
<?php }

// Show Attendee Logo
function attendee_logo_use() {
    global $mysqli; 
    global $uri;
    // $attendee = $_SESSION['id'];
    $attendee = $_GET['id'];
    $brand_result = mysqli_query($mysqli, "SELECT logo_user FROM attendees WHERE id='$attendee'");?>
    
    <?php while($res = mysqli_fetch_array($brand_result)) {?>
        <p class="logo-use">Allow Logo Use: <span><?php if($res['logo_user'] === '0') { echo 'No'; } else { echo 'Yes'; } ?></span></p>
    <?php } ?>
  
<?php }

/********************* People Filters *******************/

function filter_invite_no() {
    global $mysqli; 
    $result = mysqli_query($mysqli, "
    SELECT DISTINCT(invitation_number) AS invitation_number FROM attendees ORDER BY invitation_number DESC;");
    echo '<div class="select-wrap">';?>
    <select class="form-control filter-select industry-filter" data-column-index='4'> 
        <option value="">All Invitation Numbers</option>
    <?php 
    while($res = mysqli_fetch_array($result)) { ?>
            <option value="<?php echo $res['invitation_number'];?>"><?php echo $res['invitation_number'];?></option>  
        <?php
    }
    echo '</select></div>';
}

function filter_status() {
    global $mysqli; 
    $result = mysqli_query($mysqli, "
    SELECT DISTINCT(approved) AS approved FROM attendees ORDER BY approved ASC LIMIT 4;
    ");
    echo '<div class="select-wrap">';?>
    <select class="form-control filter-select industry-filter" data-column-index='6'> 
        <option value="">All Statuses</option>
    <?php 
    while($res = mysqli_fetch_array($result)) { ?>
            <?php
               if($res['approved'] == 0) {
                   $status = 'Pending';
               } else if($res['approved'] == 1) {
                   $status = 'Approved';
               } else if($res['approved'] == 2) {
                   $status = "Denied";
               } else {
                   $status = 'Cancelled';
               }                           
            ?>
            <option value="<?php echo $status;?>"><?php echo $status;?></option>  
        <?php
    }
    echo '</select></div>';
}

function filter_by_event($filter) {
    global $mysqli; 
    global $uri;
    $result = mysqli_query($mysqli, "
    SELECT quartz_event.*, quartz_event.status AS status, quartz_event.ranking AS ranking, events.id, events.name AS event_name, brands.id, brands.name AS brand_name, brands.name 
    FROM quartz_event, events, brands
    WHERE quartz_event.Event = events.id AND quartz_event.brand = brands.id   
    ");
    echo '<div class="select-wrap">';?>
    <select class="form-control filter-select industry-filter" data-column-index='<?php echo $filter;?>'> 
        <option value="">All Events</option>
    <?php 
    while($res = mysqli_fetch_array($result)) { 
        $event_name = $res['event_name'];
        $brand_name = $res['brand_name'];
        $brand_id = $res['brand_id'];
        $event_id = $res['event_id'];
        ?>
            <option value="<?php echo $brand_name;?> <?php echo $event_name;?>"><?php echo $brand_name;?> <?php echo $event_name;?></option>  
        <?php
    }
    echo '</select></div>';
}

// Exhibitor List for Invite Form

function exhibitors_invite_form() {
    global $mysqli; 
    global $uri;
    $event = $_GET['event'];
    $result = mysqli_query($mysqli, "
    SELECT * FROM exhibitors WHERE event='$event' ORDER BY company ASC
    
    ");
    // SELECT * FROM exhibitors WHERE event='$event' ORDER BY company ASC
    echo '<div class="custom-controls row">';
    while($res = mysqli_fetch_array($result)) { ?>                   
    <div class="col-12 col-sm-6">
      <label class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" name="exhibitors" value="<?php echo $res['company'];?>" />
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description"><?php echo $res['name'];?></span>
      </label>
    <a href="#" data-toggle="modal" class="btn-help view-exhibitor-info" data-target="#exhibitorInfo" data-exhibitor="<?php echo $res['id'];?>"><i class="material-icons">info</i></a>
    </div>
    <?php }
    echo '</div>';
}

// Fields for Pages

function fields_for_page($page_no) {  ?>
    <ul id="page_<?php echo $page_no;?>" class="list-unstyled">
        <?php show_custom_fields($page=$page_no); ?>        
        <?php standard_form_field($slug='track', $page=$page_no);?>
        <?php standard_form_field($slug='industry',$page=$page_no);?>
        <?php standard_form_field($slug='revenue',$page=$page_no);?>
        <?php standard_form_field($slug='company_size',$page=$page_no);?>
        <?php standard_form_field($slug='products_services',$page=$page_no);?>   
        <?php standard_form_field($slug='erp',$page=$page_no);?>   
        <?php standard_form_field($slug='geo',$page=$page_no);?>
        <!-- WAREHOUSE -->
        <?php standard_form_field($slug='warehouse',$page=$page_no);?>
        <div class="other-input additional-fields" id="warehouse">
            <?php show_custom_fields(); ?>        
            <?php standard_form_field($slug='number_facilities',$page=$page_no);?>
            <?php standard_form_field($slug='facility_responsibilities',$page=$page_no);?>
            <?php standard_form_field($slug='facilities_size',$page=$page_no);?>
            <?php standard_form_field($slug='facilities_equipment_interest',$page=$page_no);?>
            <?php standard_form_field($slug='facilities_software_interest',$page=$page_no);?>
            <?php standard_form_field($slug='facilities_projects',$page=$page_no);?>
        </div>
        <!-- TRANSPORTATION -->
        <?php standard_form_field($slug='transportation_responsibility',$page=$page_no);?>
        <div class="other-input additional-fields" id="transportation_responsibility">
            <?php standard_form_field($slug='ftl',$page=$page_no);?>
            <?php standard_form_field($slug='ltl',$page=$page_no);?>
            <?php standard_form_field($slug='intermodel',$page=$page_no);?>
            <?php standard_form_field($slug='parcel',$page=$page_no);?>
            <?php standard_form_field($slug='modes_transporation',$page=$page_no);?>
            <?php standard_form_field($slug='tansportation_interest',$page=$page_no);?>
            <?php standard_form_field($slug='transportation_projects',$page=$page_no);?>
        </div>
        <!-- 3PL-->
        <?php standard_form_field($slug='threepls',$page=$page_no);?>
        <div class="other-input additional-fields" id="threepls">
            <?php standard_form_field($slug='footprint',$page=$page_no);?>
            <?php standard_form_field($slug='threepl_interest',$page=$page_no);?>
            <?php standard_form_field($slug='threepl_projects',$page=$page_no);?>
        </div>
        <!-- SUPPLY CHAIN -->
        <?php standard_form_field($slug='supply_responsibility',$page=$page_no);?>
        <div class="other-input additional-fields" id="supply_responsibility">
            <?php standard_form_field($slug='supply_services',$page=$page_no);?>
            <?php standard_form_field($slug='supply_projects',$page=$page_no);?>
        </div>
        <!-- PROCUREMENT -->
        <?php standard_form_field($slug='procurement',$page=$page_no);?>
        <div class="other-input additional-fields" id="procurement">
            <?php standard_form_field($slug='procurement_projects',$page=$page_no);?>
            <?php standard_form_field($slug='procurement_interest',$page=$page_no);?>
        </div>
    </ul>        
<?php 
}


/***************** DELETES ****************/

// Delete Exhibitor
function delete_exhibitor() {
    global $mysqli; 
    $id = $_GET['id'];
    $result=mysqli_query($mysqli, "DELETE FROM exhibitors WHERE id=$id"); ?>
    <script>
        window.location = "../admin/exhibitors";
    </script>
<?php }

// Delete Attendee
function delete_attendee() {
    global $mysqli; 
    $id = $_GET['id'];
    $result=mysqli_query($mysqli, "DELETE FROM attendees WHERE id=$id"); ?>
    <script>
        window.location = "../admin/attendees";
    </script>
<?php }

// Delete Event
function delete_event() {
    global $mysqli; 
    $id = $_GET['id'];
    $result=mysqli_query($mysqli, "DELETE FROM quartz_event WHERE id=$id"); ?>
    <script>
        window.location = "../admin";
    </script>
<?php }

// Delete Brand
function delete_brand() {
    global $mysqli; 
    $id = $_GET['id'];
    $result=mysqli_query($mysqli, "DELETE FROM brands WHERE id=$id"); ?>
    <script>
        window.location = "../../admin";
    </script>
<?php }

// Delete Season
function delete_season() {
    global $mysqli; 
    $id = $_GET['id'];
    $result=mysqli_query($mysqli, "DELETE FROM events WHERE id=$id"); ?>
    <script>
        window.location = "../admin";
    </script>
<?php }

// Delete Custom Field 
function delete_custom_field() {
    global $mysqli; 
    $id = $_GET['id'];
    $result=mysqli_query($mysqli, "DELETE FROM custom_fields WHERE id=$id"); 
}