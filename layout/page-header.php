<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-9">
                <?php if($body_class=='edit-brand') { brand_logo($slug='brand', $slug_2 = 'brand'); } ?>
                    <?php if($page_vars !== 0):?>
                    <h1><?php echo $page_vars;?></h1>
                <?php endif;?>
            </div>
            <div class="col-12 col-sm-3">
                <?php if($page_var !== 0):?>
                    <a class="btn btn-success float-right" href="#" data-toggle="modal" data-target="#add<?php echo $page_var;?>">Add New</a>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>