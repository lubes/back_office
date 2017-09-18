<?php session_start();
include_once("connection.php");
?>
<!doctype html>
<html> 
<head>
	<title>Quartz</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.rawgit.com/infostreams/bootstrap-select/fd227d46de2afed300d97fd0962de80fa71afb3b/dist/css/bootstrap-select.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo $uri;?>/dist/css/all.min.css" rel="stylesheet" type="text/css">
    
<style>
    .banner, .modal .close,
    .navbar-inverse .navbar-nav .dropdown-menu .nav-link:hover,
    .progress_bar li.active span{
        background: <?php get_event_color();?>;
    } 
    .btn.btn-primary, .btn.btn-primary:hover, .btn.btn-primary:focus {
        background: <?php get_event_color();?>;
        border-color:  <?php get_event_color();?>;
    }
</style>

</head>
<body class="<?php echo $body_class;?>">
<?php if($body_class !== 'invite-form' && $body_class !== 'thanks'):?>
    <?php if(isset($_SESSION['valid'])):?>
    <header class="banner">
        <div class="container"> 
            <div class="hamburger-menu">
                <div class="bar"></div>	
            </div>
            <nav class="navbar navbar-toggleable-sm navbar-inverse"> 
                <a class="navbar-brand" href="<?php echo $uri;?>">Quartz</a>
                <div class="collapse navbar-collapse navigation" id="navbarSupportedContent">
                    <div class="mobile-header hidden-md-up">
                        <?php if($_SESSION['permission']==2):?>
                            <?php user_welcome();?>
                            <?php exhibitor_events($btn='btn-info btn-block btn-lg');?>
                        <?php endif;?>
                        <?php if($_SESSION['permission']==3):?>
                            <?php user_welcome_attendee();?>
                        <?php endif;?>
                        <?php if($_SESSION['permission']==1):?>
                        <div class="welcome">
                            <p>Welcome, Admin</p>
                        </div>
                        <?php endif;?>                    
                    </div>
                    
                    <ul class="navbar-nav mr-auto">
                        <!-- Admin Nav -->
                        <?php if($_SESSION['permission']==1):?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Events
                            </a> 
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php events_nav();?>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $uri;?>/admin/exhibitors">Exhibitors</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Attendees
                            </a> 
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="nav-link"  href="<?php echo $uri;?>/admin/attendees">All Attendees</a>
                                <a class="nav-link"  href="<?php echo $uri;?>/admin/attendees/aborts">Form Aborts</a>
                            </div>
                        </li>                        
                        
                        <?php endif;?>
                        
                        <!-- mobile log out and profile -->
                        
                        <?php if($_SESSION['permission']==2):?>
                            <li class="nav-item hidden-md-up">
                                <a class="nav-link" href="<?php echo $uri;?>/exhibitor/?id=<?php echo $_SESSION['id'];?>">My Profile</a>
                            </li>
                        <?php endif;?>
                        <?php if($_SESSION['permission']==3):?>
                            <li class="nav-item hidden-md-up">
                            <a class="nav-link" href="<?php echo $uri;?>/attendee/?id=<?php echo $_SESSION['id'];?>">My Profile</a>
                            </li>
                        <?php endif;?>                        
                        
                        <li class="nav-item hidden-md-up">
                            <a class="nav-link" href="<?php echo $uri;?>/logout.php">Logout</a>
                        </li>
                        
                    </ul>
                    <ul class="navbar-nav my-2 my-lg-0">
                        <?php if(isset($_SESSION['valid'])):?>
                        <li class="nav-item dropdown hidden-sm-down">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if($_SESSION['permission']==2):?>
                                <?php user_welcome();?>
                                <?php endif;?>
                                <?php if($_SESSION['permission']==3):?>
                                    <?php user_welcome_attendee();?>
                                <?php endif;?>
                                <?php if($_SESSION['permission']==1):?>
                                <div class="welcome">
                                    <p>Welcome, Admin</p>
                                </div>
                                <?php endif;?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php if($_SESSION['permission']==2):?>
                                    <a class="nav-link" href="<?php echo $uri;?>/exhibitor/?id=<?php echo $_SESSION['id'];?>">My Profile</a>
                                <?php endif;?>
                                <?php if($_SESSION['permission']==3):?>
                                    <a class="nav-link" href="<?php echo $uri;?>/attendee/?id=<?php echo $_SESSION['id'];?>">My Profile</a>
                                <?php endif;?>
                                <a class="nav-link" href="<?php echo $uri;?>/logout.php">Logout</a>
                            </div>
                        </li>                    
                        <?php endif;?>
                    </ul>
                </div>
             
            </nav>  
        </div>
    </header>
    <?php endif;?>
<?php endif;?>
    
<!-- New Event Modal -->
<div class="modal fade" id="newEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
        <?php add_event();?>           
      </div>
    </div>
  </div>
</div>
    
<!-- New Season Modal -->
<div class="modal fade" id="newSeason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Season</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
        <?php add_season();?>           
      </div>
    </div>
  </div>
</div>
    
<!-- New Brand Modal -->
<div class="modal fade" id="newBrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
        <?php add_brand();?>           
      </div>
    </div>
  </div>
</div>