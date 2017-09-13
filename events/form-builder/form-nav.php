
<ul class="list-unstyled form-togglers">
    <a class="btn btn-default btn-block <?php if($form_view == 'tab_1'){ echo 'active'; } ?>" href="<?php echo $uri;?>/events/form-builder?event=<?php echo $event;?>"><i class="material-icons">line_weight</i>Form Message</a>
    <a class="btn btn-default btn-block <?php if($form_view == 'tab_2'){ echo 'active'; } ?>" href="<?php echo $uri;?>/events/form-builder/form-fields.php?event=<?php echo $event;?>"><i class="material-icons">note</i>Standard Fields</a>
    <a class="btn btn-default btn-block <?php if($form_view == 'tab_3'){ echo 'active'; } ?>" href="<?php echo $uri;?>/events/form-builder/custom-fields.php?event=<?php echo $event;?>"><i class="material-icons">note_add</i>Custom Fields</a>
    <a class="btn btn-default btn-block <?php if($form_view == 'tab_4'){ echo 'active'; } ?>" href="<?php echo $uri;?>/events/form-builder/email-messaging.php?event=<?php echo $event;?>"><i class="material-icons">send</i>Email Messages</a>
    <a class="btn btn-default btn-block" href="<?php echo $uri;?>/events/invite-form/?event=<?php echo $event;?>" target="_blank"><i class="material-icons">format_align_justify</i>Preview Form</a>
</ul>