<?php 
$body_class = 'invite-form';
include_once("../../connection.php");
include('../../layout/header.php');?>
<?php
$brand = $_GET['brand'];
$event = $_GET['event'];
?>

<?php form_code();?>

<div class="container">
    <div class="invite-wrap">
       <div class="invite-header">
            <?php brand_logo($slug='event', $slug_2 = 'id');?>
        </div>        
        <!--<p class="text-muted"><?php event_name();?></p>-->
        <div class="form-progress">
            <ul class="progress_bar list-unstyled">
                <li class="progress_li sec_1"><span>1</span></li>
                <li class="progress_li sec_2"><span>2</span></li>
                <li class="progress_li sec_3"><span>3</span></li>
                <li class="progress_li sec_4"><span>4</span></li>
                <li class="progress_li sec_5"><span>5</span></li>
                <li class="progress_li sec_6"><span>6</span></li>
                <li class="progress_li sec_7"><span>7</span></li>
                <li class="progress_li sec_8"><span>8</span></li>
            </ul> 
        </div>
        
    <!--<form class="registration-form" id="registeruserform" type="POST" enctype="multipart/form-data" accept-charset="UTF-8" action="https://marketing.quartzb2b.com/acton/eform/17258/038f/d-ext-0001">-->
        
    <form action="" method="post" enctype="multipart/form-data" class="registration-form">

        <!-- Step 1 -->
        <div class="form-section" id="sec_1">
            <?php form_message($slug='intro');?>
            <ul id="page_1" class="list-unstyled">
            <?php show_custom_fields($page='1'); ?>
            <li id="1">
                <h2 class="form-sec-title">Contact Information</h2>  
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Invitation Code <a href="#" data-toggle="modal" class="btn-help view-exhibitor-info" data-target="#invitationCode"><i class="material-icons">info</i></a></label>
                            <input type="text" class="form-control" name="invitation_code" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Company *</label>
                            <input type="text" class="form-control" required=""  name="company" />
                        </div>                
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" class="form-control required required-input" required=""  name="name" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Job Title *</label>
                            <input type="text" class="form-control required required-input" required="" name="job_title" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Business Email *</label>
                            <input type="email" class="form-control email_input" required="" required="" name="email" id="email_1" />
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Confirm Email *</label>
                            <input type="text" class="form-control email_input" required="" name="" id="email_2"  />
                            <p class="error-text"></p>
                        </div> 
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Alternate Email</label>
                            <input type="text" class="form-control" name="alt_email" />
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Direct Phone*</label>
                            <input type="text" class="form-control" required=""  name="direct_phone" />
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Cell Phone</label>
                            <input type="text" class="form-control" name="cell_phone" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" class="form-control"  name="website" />
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Mailing Street*</label>
                            <input type="text" class="form-control" required="" name="address" />
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>City*</label>
                            <input type="text" class="form-control" required=""  name="city" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>State*</label>
                            <input type="text" class="form-control" required=""  name="state" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Zip*</label> 
                            <input type="text" class="form-control" required="" name="zip" />
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Country</label>
                            <?php include('../../layout/countries.php');?>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label>Rules of Engagement</label>
                    <div class="form-msg">
                        <?php form_message($slug='rules');?> 
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" required="" name="exampleRadios" id="exampleRadios1" value="option1"> Agree to Rules of Engagment *
                      </label>
                    </div>
                </div>
                </li>
            </ul>
        </div>
        
        <!--<input type="submit" class="btn btn-black btn-lg float-right" name="submit_form" value="Continue" />-->

        <!-- Step 2 -->
        <div class="form-section" id="sec_2">
            <h2 class="form-sec-title">Additional Information</h2>  
            <div class="form-group">
                <label>Meetings Scheduling</label>
                <div class="form-msg">
                    <?php form_message($slug='meetings');?> 
                </div>
            </div>
            <?php fields_for_page($page_no='2');?>
        </div>

        <!-- Step 3 -->
        <div class="form-section" id="sec_3">
            <h2 class="form-sec-title">DC/Warehouse</h2>  
            <?php fields_for_page($page_no='3');?>
        </div>

        <!-- Step 4 -->
        <div class="form-section" id="sec_4">
            <h2 class="form-sec-title">Transportation</h2>  
            <?php fields_for_page($page_no='4');?>
        </div>

        <!-- Step 5 -->
        <div class="form-section" id="sec_5">
            <h2 class="form-sec-title">3PL</h2>  
            <?php fields_for_page($page_no='5');?>
        </div>

        <!-- Step 6 -->
        <div class="form-section" id="sec_6">
            <h2 class="form-sec-title">Supply Chain</h2>  
            <?php fields_for_page($page_no='6');?>
        </div>

        <!-- Step 7 -->
        <div class="form-section" id="sec_7">
            <h2 class="form-sec-title">Procurement</h2>  
            <?php fields_for_page($page_no='7');?>
        </div>

        <!-- Step 8 -->
        <div class="form-section" id="sec_8">
            <h2 class="form-sec-title">Submit Your Application</h2>  
            
            <!-- Complete Registration Field for QUARTZ -->
            <input type="hidden" name="Completed Event Registration" value="true" />
            
            <input type="hidden" name="finished" value="1" />
            
            <div class="form-group">
                <label>Exhibitor Selection <span>Below you will find a list of solutions and services partners. If you would like to meet with a specific supplier please select their corresponding box. We will arrange an appointment within the meeting windows specified.</span></label>
                <?php exhibitors_invite_form();?>
            </div>
            <div class="form-group">
                <label>Logo Permission <span>Can <?php event_name();?> use your company logo to show your participation at the conference?</span></label>
                <div class="form-check">
                    <label class="form-check-label" data-id="">
                        <input class="form-check-input" type="radio" name="logo_user" id="exampleRadios1" value="1"> Yes
                    </label>
                    <label class="form-check-label" data-id="">
                        <input class="form-check-input" type="radio" name="logo_user" id="exampleRadios1" value="0"> No
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-navigation">
            <button type="button" class="previous btn btn-black btn-lg float-left"><i class="material-icons">arrow_back</i> Previous</button>
            <button type="button" class="next btn btn-black btn-lg float-right">Continue <i class="material-icons">arrow_forward</i></button>
            <div class="clearfix"></div>
            <input type="submit" value="Submit" name="submit_form" class="submit-form btn btn-success float-right btn-lg">
        </div>        
        
        <?php register_attendee();?> 
        
    </form>

</div>
</div>

<!-- Invitation Code Modal -->
<div class="modal" id="invitationCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invitation Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
        <p>If you received an email invitation with a registration code, please enter it here.</p>
      </div>
    </div>
  </div>
</div>

<!-- Exhibitor Info Modal -->
<div class="modal" id="exhibitorInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Exhibitor Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body">
        <div id="exhibitor_info"></div>
      </div>
    </div>
  </div>
</div>

<?php include('../../layout/footer.php');?>

<!--
https://marketing.quartzb2b.com/acton/form/17258/038f:d-0001/0/-/-/-/-/index.htm
-->


<script type="text/javascript">
  var aoProtocol = location.protocol;
	if ( aoProtocol.indexOf('http') < 0 ) {
		aoProtocol = 'http:';
	}
	var aoCAP = {
		aid: '17258',
		fid: '038f',
		did: 'd-0001',
		server: 'qa.esw.me',
		formId: 'registeruserform',
		protocol: aoProtocol
	};
	var aoArr = aoArr || []; 
	aoArr.push(aoCAP); 
</script>

<script type="text/javascript">
	function AoProcessForm(formelement) {
	  for (AoI = 0; AoI < aoArr.length; AoI++) {
	    if (aoArr[AoI].aid && aoArr[AoI].fid && aoArr[AoI].did &&
	      aoArr[AoI].server && (aoArr[AoI].formId ||
	        aoArr[AoI].formName)) {
	      var d = document,
	        thisFormId = formelement.id || '',
	        thisFormName = formelement.name || '',
	        bi = function(i) {
	          return d.getElementById(i)
	        },
	        bn = function(i) {
	          return d.getElementsByName(i)[0]
	        },
	        names = [],
	        values = [],
	        params = {},
	        w = window,
	        targetIdOrName = aoArr[AoI].formName ?
	        bn(aoArr[AoI].formName) : bi(aoArr[AoI].formId),
	        len = targetIdOrName.elements.length,
	        isLoaded = false,
	        ud = 'undefined',
	        st = function(f, i) {
	          w.setTimeout(f, i)
	        },
	        ce = function(t) {
	          return d.createElement(t)
	        },
	        gid = function(p) {
	          var j, i = 0,
	            n = Math.random,
	            r = [],
	            c = '0123456789abcdef'.split('');
	          for (; i < 16; i++) r[i] = c[(0 | n() * 16) & 0xf];
	          j = p + r.join('');
	          return bi(j) == null ? j : gid(p);
	        },
	        addInput = function(form, name, value) {
	          var el = ce('input');
	          el.name = name;
	          el.value = value;
	          form.appendChild(el);
	        },
	        idifr = gid('aoCapT');
	      if (aoArr[AoI].formName == thisFormName ||
	        aoArr[AoI].formId == thisFormId) {
	        var dTarget = ce('div');
	        dTarget.style.display = 'none';
	        d.body.appendChild(dTarget);
	        dTarget.innerHTML = '<iframe name="' + idifr + '"id="' +
	          idifr + '"><\/iframe>'; // generate iframe
	        var dForm = ce('form'),
	          idform = gid('aoCapD');
	        dForm.id = idform;
	        dForm.style.display = "none";
	        dForm.method = 'POST';
	        dForm.enctype = 'multipart/form-data';
	        dForm.acceptCharset = 'UTF-8';
	        dForm.target = idifr; // form targets iframe
	        dForm.action = (aoCAP.protocol || w.location.protocol) + '//' +
	          aoCAP.server + '/acton/forms/userSubmit.jsp';
	        d.body.appendChild(dForm); // generate form
	        for (i = 0; i < len; i++) {
	          var el = targetIdOrName.elements[i];
	          var name = typeof(el.name) != ud ? el.name : null;
	          var value = typeof(el.value) != ud ? el.value : null;
	          tagName = el.nodeName.toLowerCase();
	          if (tagName == 'input' && (el.type == 'radio' || el.type ==
	              'checkbox') && !el.checked) {
	            name = null;
	          } else if (tagName == 'select' && el.selectedIndex &&
	            el.selectedIndex != -1 && el.options[el.selectedIndex] &&
	            el.options[el.selectedIndex].value) {
	            value = el.options[el.selectedIndex].value
	          };
	          if (name != null && name != '') {
	            names.push(name);
	            values.push(el.value);
	            console.log("Element name:" + el.name + "/ Elementvalue: " + el.value);
	            params[name] = el.value;
	          };
	          addInput(dForm, el.name, el.value);
	        }
	        aoCAP.pid = 0;
	        aoCAP.cuid = aoCAP.cuid || '';
	        aoCAP.srcid = aoCAP.srcid || '';
	        aoCAP.camp = aoCAP.camp || '';
	        addInput(dForm, 'ao_a', aoArr[AoI].aid);
	        addInput(dForm, 'ao_f', aoArr[AoI].fid);
	        addInput(dForm, 'ao_d', aoArr[AoI].fid + ":" + aoArr[AoI].did);
	        addInput(dForm, 'ao_p', 0);
	        addInput(dForm, 'ao_jstzo', new Date().getTimezoneOffset());
	        addInput(dForm, 'ao_form_neg_cap', '');
	        addInput(dForm, 'ao_refurl', d.referrer);
	        addInput(dForm, 'ao_cuid', aoCAP.cuid);
	        addInput(dForm, 'ao_srcid', aoCAP.srcid);
	        addInput(dForm, 'ao_camp', aoCAP.camp);
	        bi(idform).submit();
	        var dTargetFrame = bi(idifr);
	        dTargetFrame.onload = function() {
	          isLoaded = true;
	        };
	        var waitForSubmit = function() {
	          this.count = "";
	          if (!(isLoaded || dTargetFrame.readyState == "complete")) {
	            st(waitForSubmit, 200);
	            this.count++;
	          } else if (this.count > 7) {
	            return true;
	            console.log("skipping dForm");
	          } else {
	            d.body.removeChild(dForm);
	            d.body.removeChild(dTarget);
	          }
	        };
	        st(waitForSubmit, 100);
	      }
	    } else {
	      console.log('aoCAP property missing');
	    }
	  }
	};
</script>

<script>
var PostData = '';
$.ajax({
  async: false,
  url: '../thanks/?id=16974&event=10',
  type: 'POST',
  data: PostData,
  success: function(data) {
        console.log('SUCCESS!');
        setTimeout(AoProcessForm($('#registeruserform')[0]), 0);
  }
});
</script>






