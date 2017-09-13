<?php if($body_class !== 'invite-form'):?>
<footer class="content-info">
    <div class="container">
        <p>&copy; <?php echo date("Y"); ?> Quartz</p>
    </div>
</footer>
<?php endif;?>

<?php include('add-attendee.php');?>
<?php include('add-exhibitor.php');?>

<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="http://www.jqueryscript.net/demo/DataTables-Jquery-Table-Plugin/media/js/jquery.js"></script>
<script src="https://cdn.datatables.net/r/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,b-1.0.3,b-html5-1.0.3/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js"></script>
<script src="https://rawgit.com/guillaumepotier/Parsley.js/2.2.0-rc4/dist/parsley.js"></script>
--> 
<!--
<script src="https://cdn.rawgit.com/infostreams/bootstrap-select/fd227d46de2afed300d97fd0962de80fa71afb3b/dist/js/bootstrap-select.min.js"></script>
--> 
<script src="<?php echo $uri;?>/dist/js/main.min.js"></script>
</body>
</html>