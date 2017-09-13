<div class="container">
<div class="filters">   
    <div class="filter-head">
        <div class="row">
            <div class="col-xs-12 col-sm-10">
                <h4>Filter</h4>
            </div>
            <div class="col-xs-12 col-sm-2">
                <div class="text-right">
                    <a href="#" class="filter-toggle btn btn-secondary btn-sm">Show Filters</a>  
                    <a href="#" class="reset btn btn-warning btn-sm">Reset</a>  
                </div>
            </div>
        </div>
    </div>
    <div class="filter-body">
        <div class="basic-filters">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-9"> 
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4"> 
                            <div class="filter">
                                <h5>Stars</h5>
                                <div class="form-group star-filters">
                                    <label class="custom-control custom-radio">
                                        <input id="radio1" name="stars" type="radio" data-column-index='4' value="1" class="custom-control-input star-filter" data-filter="Stars" data-test="filter_stars">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"><div class="star gold"><i class="material-icons">star_rate</i></div></span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="radio2" name="stars" type="radio" data-column-index='4' value="2" class="custom-control-input star-filter" data-filter="Stars" data-test="filter_stars">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"><div class="star silver"><i class="material-icons">star_rate</i></div></span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="radio2" name="stars" type="radio" data-column-index='4' value="3" class="custom-control-input star-filter" data-filter="Stars" data-test="filter_stars">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"><div class="star bronze"><i class="material-icons">star_rate</i></div></span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="radio2" name="stars" type="radio" data-column-index='4' value="4" class="custom-control-input star-filter" data-filter="Stars" data-test="filter_stars">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"><div class="star none"><i class="material-icons">star_border</i></div></span>
                                    </label> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <?php filter_field($slug='industry', $filter=1, $field='Industry');?>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <?php filter_field($slug='company_size', $filter=3, $field='Company Size');?>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <?php filter_field($slug='revenue', $filter=2, $field='Revenue');?>
                        </div>

                        <?php if(isset($geo)):?>
                        <div class="col-12 col-sm-6 col-md-4">
                            <?php filter_field($slug='geo', $filter=4, $field='Geo');?>
                        </div>                
                        <?php endif;?>

                        <?php if(isset($warehouse)):?>
                        <div class="col-12 col-sm-6 col-md-4">
                            <?php filter_field($slug='facilities_equipment_interest', $filter=5, $field='Warehouse');?>
                        </div>  
                        <div class="col-12 col-sm-6 col-md-4">
                            <?php filter_field($slug='facilities_software_interest', $filter=6, $field='Warehouse');?>
                        </div>  
                        <?php endif;?>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-3"> 
                        <div class="inner-body filter_params" id="advanced_filters">
                           
                               <div class="custom-controls-stacked">
                                  <label class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input append_filter" value="geo" <?php if(isset($geo)) { echo 'checked'; } ?> id="append_filter">
                                  <span class="custom-control-indicator"></span>
                                  <span class="custom-control-description">Geo Location</span>
                                  </label>
                      
                                  <label class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input append_filter" value="warehouse" <?php if(isset($warehouse)) { echo 'checked'; } ?> id="append_filter">
                                  <span class="custom-control-indicator"></span>
                                  <span class="custom-control-description">Warehouse</span>
                                  </label>
                    
                                  <label class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input append_filter" value="threepl" <?php if(isset($threepl)) { echo 'checked'; } ?> id="append_filter">
                                  <span class="custom-control-indicator"></span>
                                  <span class="custom-control-description">3PL</span>
                                  </label>
                                  <label class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input append_filter" value="transportation" <?php if(isset($transportation)) { echo 'checked'; } ?> id="append_filter">
                                  <span class="custom-control-indicator"></span>
                                  <span class="custom-control-description">Transportation</span>
                                  </label>
                               </div>
                                <div class="form-group">
                                    <a class="custom_params btn btn-block btn-primary" href="">Filter</a>
                                </div>
        
                            <div class="hidden-xl-down">
                                <span id="filter_param">event=<?php echo $_GET['event'];?></span><span id="filter_query"></span>
                            </div>
                    </div>
                </div>
            </div>
            <!--<a href="" class="btn btn-secondary btn-block advanced-toggle">Filter by Additional Fields</a>-->
        </div>
        <div class="advanced-filters">
        </div>
    </div>
    <div class="filter-footer">
        <div id="filter_list" class="filtering-list"></div>
    </div>
    </div>
</div>
