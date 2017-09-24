<?php 
$body_class = 'form-builder';
$form_view = 'tab_2';
$event = $_GET['event'];
include_once("../../connection.php");
include('../../layout/header.php');
include('../nav.php');?>
<div class="container">
    <div class="page-wrap">
        <div class="container">
            <?php check_form_existence();?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10">
                    <div class="form-tab active" id="tab_2">
                        <h3>Form Fields</h3>
                        <p>Page 1 is reserved for contact information. Only append custom fields to page 1.</p>
                        <ul id="field_order" class="list-unstyled">
                            <div class="row">
                               <div class="col-4 col-sm-1 col-md-1">
                                   <p>Active</p>
                               </div>
                               <div class="col-8 col-sm-1 col-md-1">
                                   <p>ID</p>
                               </div>
                                <div class="col-8 col-sm-1 col-md-1">
                                   <p>Page</p>
                               </div>
                               <div class="col-8 col-sm-2 col-md-1">
                                   <p>Order</p>
                               </div>
                               <div class="col-12 col-sm-8 col-md-5">
                                   <p>Title</p>
                               </div>
                            </div>
                            <?php form_fields();?>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <?php include('form-nav.php');?>
                </div>
            </div>    
        </div>
    </div>
</div>
<?php include('../../layout/footer.php');?> 

<script>
var i=100;
$('.field_order').each(function(){
    i++;
    var newID=i;
    $(this).attr('id',newID);
});
    
var i=0;
$('.page_1').each(function(){
    i++;
    var newID=i;
    $(this).attr('id',newID);
});


$("#field_order li").sort(function(a, b) {
  return parseInt(a.id) - parseInt(b.id);
}).each(function() {
  var elem = $(this);
  elem.remove();
  $(elem).appendTo("#field_order");
});
    
 
</script>