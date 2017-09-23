<!-- Step 2 -->
<div class="form-section" id="sec_2">
    <!--<h2 class="form-sec-title">Additional Information</h2>-->  

    <?php fields_for_page($page_no='2');?>
</div>

<!-- Step 3 -->
<div class="form-section" id="sec_3">
    <div class="form-group">
        <!--<label>Meetings Scheduling</label>-->
        <div class="form-msg">
            <?php form_message($slug='meetings');?> 
        </div>
    </div>
    <!--<h2 class="form-sec-title">DC/Warehouse</h2>-->  
    <?php fields_for_page($page_no='3');?>
</div>


<!-- Step 8 -->
<div class="form-section" id="sec_8">
    <!--<h2 class="form-sec-title">Submit Your Application</h2>  -->

    <!-- Complete Registration Field for QUARTZ -->
    <input type="hidden" name="Completed Event Registration" value="true" />

    <input type="hidden" name="finished" value="1" />

    <div class="form-group">
        <label>Exhibitor Selection <span>Below you will find a list of solutions and services partners. If you would like to meet with a specific supplier please select their corresponding box. We will arrange an appointment within the meeting windows specified.</span></label>
        <?php exhibitors_invite_form();?>
    </div>
    <div class="form-group">
        <label>Logo Permission <span>Can we use your company logo to show your participation at the event?
</span></label>
        <div class="form-check">
            <label class="form-check-label" data-id="">
                <input class="form-check-input" required type="radio" name="logo_user" id="exampleRadios1" value="1"> Yes
            </label>
            <label class="form-check-label" data-id="">
                <input class="form-check-input" required type="radio" name="logo_user" id="exampleRadios1" value="0"> No
            </label>
        </div>
    </div>
</div>