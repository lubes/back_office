<?php $event=$_GET['event'];?>
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="events-header">
                    <figure class="brand-logo">
                        <img src="<?php echo brand_logo($slug='event', $slug_2 = 'id');?>" class="" />
                    </figure>
                </div>
                <h4><?php season_name();?></h4>
                <div class="event-meta">
                    <a class="btn btn-secondary btn-sm btn-instructions" href="" data-toggle="modal" data-target="#instructions">View Instructions on Ranking</a>
                    <?php if($_SESION['permission']==2){  count_ranks();} ?>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <?php if($_SESION['permission']==2){ update_rank_status();} ?>
            </div>
        </div>
    </div>	
    <?php if($_SESSION['permission']==1):?>
    <?php if($body_class !=='form-builder'):?>
    <div class="add-new"><i class="material-icons">add</i>
        <div class="hover-content">
            <a class="btn btn-secondary" href="" data-toggle="modal" data-target="#addAttendee">Add Attendee</a>
            <a class="btn btn-secondary" href="" data-toggle="modal" data-target="#addexhibitor">Add Exhibitor</a>
        </div>
    </div> 
    <?php endif;?>
    <?php endif;?>
</div>
<?php if($_SESSION['permission']==1):?>
<div class="container">
    <div class="nav-wrap">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link <?php if($body_class=='event-exhibitors' || $body_class=='event-attendees' ){ echo 'active'; }?>" href="<?php echo $uri;?>/events/?event=<?php echo $event;?>"><i class="material-icons">people</i> Registrations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($body_class=='form-builder'){ echo 'active'; }?>" href="<?php echo $uri;?>/events/form-builder/?event=<?php echo $event;?>"><i class="material-icons">mode_edit</i> Form Builder</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($body_class=='event-info'){ echo 'active'; }?>" href="<?php echo $uri;?>/events/event-info/?event=<?php echo $event;?>"><i class="material-icons">record_voice_over</i> Event Info</a>
            </li>
        </ul>
        <div class="registration-links btn-group">
            <?php if($body_class =='event-exhibitors'  || $body_class =='event-attendees'):?>
            <a class="btn btn-secondary <?php if($body_class=='event-exhibitors'){ echo 'active'; }?>" href="<?php echo $uri;?>/events/?event=<?php echo $event;?>">Exhibitors</a>
            <a class="btn btn-secondary <?php if($body_class=='event-attendees'){ echo 'active'; }?>" href="<?php echo $uri;?>/events/attendees/attendees-admin.php?event=<?php echo $event;?>">Attendees</a>   
            <a class="btn btn-secondary" href="<?php echo $uri;?>/events/attendees/attendees-admin.php?event=<?php echo $event;?>#approvals">Approvals</a> 
            <?php endif;?>
        </div>
    </div>
</div>
<?php endif;?>
<?php instructions_pdf();?>