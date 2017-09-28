<?php 
$body_class = 'invite-form';
include_once("../../connection.php");
include('../../layout/header.php');
$step = '1';
$event = $_GET['event'];
?>
<?php form_code();?>
<div class="container">
    <div class="invite-wrap">
       <div class="invite-header">
           <figure class="brand-logo">
                    <img src="<?php echo brand_logo($slug='event', $slug_2 = 'id');?>" class="" />
            </figure> 
        </div>        
        <div class="form-progress">
            <ul class="progress_bar list-unstyled">
                <li class="progress_li sec_1 active"><span>1</span></li>
                <li class="progress_li sec_2"><span>2</span></li>
                <li class="progress_li sec_3"><span>3</span></li>
                <li class="progress_li sec_4"><span>4</span></li>
            </ul> 
        </div>
        
        <!--<form target="_blank" class="registration-form" id="registeruserform" type="POST" enctype="multipart/form-data" accept-charset="UTF-8" action="https://marketing.quartzb2b.com/acton/eform/17258/038f/d-ext-0001">-->
        
        <form target="_blank" class="registration-form" id="registeruserform" type="POST" enctype="multipart/form-data" accept-charset="UTF-8" action="https://marketing.quartzb2b.com/acton/eform/17258/038f/d-ext-0001">
            
        <!--<form action="" method="post" enctype="multipart/form-data" class="registration-form">-->
        

            
            
        <div class="form-section" id="sec_1">
            <?php form_message($slug='intro');?>
            <ul id="page_1" class="list-unstyled">
            <?php show_custom_fields($page='1'); ?>
            <li id="0">

                <div class="row">
 
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Invitation Code <a href="#" data-toggle="modal" class="btn-help view-exhibitor-info" data-target="#invitationCode"><i class="material-icons">info</i></a></label>
                            <input type="text" class="form-control" name="invitation_code" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Name*</label>
                            <div id="name-errors"></div>
                            <input type="text" class="form-control required required-input" required=""  name="name" data-parsley-errors-container="#name-errors"/>
                        </div>
                    </div>  
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Company*</label>
                            <div id="company-errors"></div>
                            <input type="text" class="form-control" required=""  name="company" data-parsley-errors-container="#company-errors"/>
                        </div>                
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Job Title*</label>
                            <div id="title-errors"></div>
                            <input type="text" class="form-control required required-input" required="" name="job_title" data-parsley-errors-container="#title-errors"/>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Business Email*</label>
                            <div id="email-errors"></div>
                            <input type="email" class="form-control email_input" required="" required="" name="email" id="email_1" data-parsley-errors-container="#email-errors"/>
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Confirm Email*</label>
                            <div id="confirm-errors"></div>
                            <input type="text" class="form-control email_input" required="" name="" id="email_2"  data-parsley-errors-container="#confirm-errors"/>
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
                            <div id="phone-errors"></div>
                            <input type="text" class="form-control" required=""  name="direct_phone" data-parsley-errors-container="#phone-errors" placeholder="(000) 000-0000"/>
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Cell Phone </label>
                            <input type="text" class="form-control" name="cell_phone" placeholder="(000) 000-0000" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Website*</label>
                            <div id="checkbox-errors"></div>
                            <input type="text" class="form-control" required="" name="website" data-parsley-errors-container="#website-errors"	/>
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Mailing Street</label>
                            <input type="text" class="form-control"  name="address" />
                        </div> 
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control"   name="city" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>State*</label>
                            <div id="state-errors"></div>
                            <input type="text" class="form-control" required name="state" data-parsley-errors-container="#state-errors"/>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Zip</label> 
                            <input type="text" class="form-control" name="zip" />
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
                    <label>Before completing Registration please take a minute to read the following:</label>
                    <div class="form-msg">
                        <?php form_message($slug='rules');?> 
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="hidden" name="exampleRadios" id="exampleRadios1" value="option1">
                      </label>
                    </div>
                </div>
                </li>
            </ul>
        </div>
        <br>
        <?php //$random = rand(0,1000000000);?>
        <input type="hidden" name="id" class="attendee_id" value="" />    
        <input type="hidden" name="event" value="<?php echo $event;?>" />     
        <div class="steps-2-8">
            <?php include('steps-2-8.php');?>   
        </div>        
        <div class="form-navigation">
            <button type="button" class="previous btn btn-black btn-lg float-left"><i class="material-icons">arrow_back</i> Previous</button>
            <!-- First Next Button to Capture Fields and Data -->
            <button type="button" class="next submit-attendee btn btn-black btn-lg float-right">Continue </button>
            <!-- Other Next Button to Capture Fields and Data -->
            <button type="button" class="next update-attendee btn btn-black btn-lg float-right">Continue </button>
            
            <input type="submit" value="Submit" name="submit_form" data-attendee="<?php echo $random;?>" class="submit-form btn btn-success float-right btn-lg">
            <div class="clearfix"></div>
        </div> 
        <div class="clearfix"></div>
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

<script type="text/javascript">    
      
    
// Ajax to Send data to DB and Act On
$('.submit-attendee').click(function(event) {
    serializedData =$("#registeruserform").serialize();
    $.ajax({
          async: false,
          url: '../../_includes/add-attendee.php',
          type: 'POST',
          data: serializedData,
          success: function(data) {
              $(".attendee_id").val(data.trim());

              //console.log(data);
                setTimeout(function(){ 
                    console.log('inserted attendee');
                }, 200);
              
          }
        });
    return true; // return false to cancel form action
});
   
    
// Ajax to Send data to DB and Act On

$('.update-attendee').click(function(event) {
    serializedData =$("#registeruserform").serialize();
    $.ajax({
          async: false,
          url: '../../_includes/update-attendee.php',
          type: 'POST',
          data: serializedData,
          success: function(data) {
                // console.log('SUCCESS!');
                console.log(data);
                setTimeout(function(){ 
                    console.log('updated attendee');
                }, 200);
              
          }
        });
    
    return true; // return false to cancel form action
});
   
    
$('.submit-form').click(function(event) {
    $('#registeruserform').submit(); 
});
    
// Ajax to Send data to DB and Act On
$('#registeruserform').submit(function() {
    serializedData =$("#registeruserform").serialize();
    var att_id = $(".attendee_id").val();
    //console.log(serializedData);
    //console.log("id: " + att_id);
    $.ajax({
          async: false,
          url: '../../_includes/update-attendee.php',
          type: 'POST',
          data: serializedData,
          success: function(data) {
              console.log(data);

                setTimeout(function(){
                window.location = "../thanks/?id="+att_id+"&event=<?php echo $event;?>";
                }, 200);
          }
        });
    return true;
});    
 
// Act On
var aoProtocol = location.protocol;
if ( aoProtocol.indexOf('http') < 0 ) aoProtocol = 'http:';
var aoCAP = {
aid: '17258',
fid: '038f',
did: 'd-ext-0001',
server: 'marketing.quartzb2b.com',
formName: 'registeruserform',
protocol: aoProtocol
};
document.write( '<script type="text/javascript" src="'+aoCAP.protocol+'//'+aoCAP.server+'/acton/js/formcap.min.js"><'+'/script>' );
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