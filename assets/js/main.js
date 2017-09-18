var site_url = 'http://localhost:8888/a_quartz/';
// var site_url = 'http://qa.esw.me/';

$(document).ready(function () {
 

    $('select').selectpicker({
        style: 'btn-secondary'
    });

    (function () {
        $('.hamburger-menu').on('click', function() {
            $('.bar').toggleClass('animate');
            $('.body').toggleClass('nav-open');
            $('.navigation').toggleClass('open');
        })
    })();
    
    $('.add-new').on('click', function() { 
        $(this).toggleClass('active'); 
    });

    // All Attendees
    var all_attendees = $('#all_attendees').DataTable({
        pageLength: 100,
        dom: 'Bfrtip',
        "columnDefs": [
            {
                "targets": [ 8 ], 
                "visible": false
            }
        ],
        buttons: [
            {
                extend: 'csv',
                title: 'All Attendees',
                text: 'Export All'
            },
            {
                extend: 'csv',
                title: 'Attendees',
                text: 'Export Selected',
                exportOptions: {
                    modifier: {
                        selected: true
                    }
                }
            } 
        ],
        select: true
    }); 
    
    
    var all_attendees_admin = $('#all_attendees_admin').DataTable({
        pageLength: 100,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                title: 'All Attendees',
                text: 'Export All'
            },
            {
                extend: 'csv',
                title: 'Attendees',
                text: 'Export Selected',
                exportOptions: {
                    modifier: {
                        selected: true
                    }
                }
            } 
        ],
        select: true
    }); 
    
    // All Exhibitors
    var all_exhibitors = $('#all_exhibitors').DataTable({
        pageLength: 100,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                title: 'All Exhibitors',
                text: 'Export All'
            },
            {
                extend: 'csv',
                title: 'Exhibitors',
                text: 'Export Selected',
                exportOptions: {
                    modifier: {
                        selected: true
                    }
                }
            }
        ],
        select: true

    }); 
    
    // Custom Filter
    $('.list-fitler').on('keyup change', function () {
        all_exhibitors.column($(this).data('columnIndex')).search(this.value).draw();
    });
    
    
    
    
 
    // DataTables 
    var attendees_ranking_table = $('#attendees_ranking_table').DataTable({
        paging: true,
        "pageLength": 100,
        dom: 'frtip',
        "aaSorting": [[5,'asc']],
        buttons: [ 
          {
             extend: 'collection',
             text: 'Export',
             title: 'Attendees',
             buttons: [ 'pdfHtml5', 'csvHtml5', 'copyHtml5', 'excelHtml5' ]
          }
        ],
    });
     
    
    
    
    
    
    
    
    
    
    
    
    
    // DataTables 
    var table = $('#example').DataTable({
        paging: true,
        "pageLength": 100,
        dom: 'frtip',
        "aaSorting": [[4,'asc'], [5,'asc']],
        buttons: [ 
          {
             extend: 'collection',
             text: 'Export',
             buttons: [ 'pdfHtml5', 'csvHtml5', 'copyHtml5', 'excelHtml5' ]
          }
        ],
        "columnDefs": [
            {
                "targets": [ 7 ],
                "visible": false
            }
        ]
    });
    
    // DataTables
    var ex_table = $('#ex_ranks').DataTable({
        paging: false,
        dom: 'frtip',
        buttons: [
          {
             extend: 'collection',
             text: 'Export',
             buttons: [ 'pdfHtml5', 'csvHtml5', 'copyHtml5', 'excelHtml5' ]
          }
       ],
    });
    
    // Main Exhibitors DataTables
    var exhibitors_table = $('#exhibitors').DataTable({
        paging: false,
        dom: 'frtip',
        buttons: [
          {
             extend: 'collection',
             text: 'Export',
             buttons: [ 'pdfHtml5', 'csvHtml5', 'copyHtml5', 'excelHtml5' ]
          }
       ],
    });
    
    // Main Exhibtors Tables Filters
    $('#btn-csv').on('click', function(){
        exhibitors_table.button( '0-1' ).trigger();
        attendees_ranking_table.button( '0-1' ).trigger();
        all_exhibitors.button( '0-1' ).trigger();
        all_attendees.button( '0-1' ).trigger();
        all_attendees_admin.button( '0-1' ).trigger();
    }); 
    
    $('.ex-filter').on('change', function () {
        exhibitors_table.column($(this).data('columnIndex')).search(this.value).draw();
    });
        
    
    // Export as CSV
    $('#btn-csv').on('click', function(){
        table.button( '0-1' ).trigger();
        ex_table.button( '0-1' ).trigger();
    }); 

    // Custom Filter
    $('.special-filters').on('keyup change', function () {
        
        table.column($(this).data('columnIndex')).search(this.value).draw();
    });
    
    // Stars Search
    $('.star-filter').on('keyup change', function () {
        attendees_ranking_table.column($(this).data('columnIndex')).search(this.value).draw();

    });
     
    // Stars Search
    $('.industry-filter').on('change', function () {
        attendees_ranking_table.column($(this).data('columnIndex')).search(this.value).draw();
        all_attendees.column($(this).data('columnIndex')).search(this.value).draw();
        all_attendees_admin.column($(this).data('columnIndex')).search(this.value).draw();
        all_exhibitors.column($(this).data('columnIndex')).search(this.value).draw();
    });    
    
    // Range Filter Search
    $('#max_rev, #min_rev, #max_emp, #min_emp').on('change', function () {
        table.draw();
        ex_table.draw();
    });
    
    $(".dataTables_filter input").on('keyup change', function () {
        // table.columns().search('');
        $('.filter').val('');
    });

    
    
    
    
    // Append Filter Items to Filter List
    $('.filter select, .filter input').bind("change keyup", function(event){
        
        
        var this_val = $(this).val();
        var this_filter = $(this).data('filter');
        $(this).addClass('filtering');
        var filter_id = $(this).data('test');
        var filter_val = '<span class="filter-item" id="'+filter_id+'">' + this_filter + ': ' + this_val + '<i class="material-icons">close</i></span>';
        var new_val = $(this).val();
        var replace_filter = $('.filter-item').data('filter', this_filter);
        console.log(filter_id);
        
        if ($('#'+filter_id).text().length > 0) { 
            $('#'+filter_id).html(this_filter + ': ' + this_val + '<i class="material-icons">close</i>');
        }  else {
            $('#filter_list').append(filter_val);
        }
        
        // Remove Filter Items
        $('.filter-item').click(function() {
            
            $(this).remove();
            var this_id = $(this).attr('id');
            var find_filter = $('.filter-select').data('test', this_id);
            $('.filter-select[data-test="'+this_id+'"]').val('');
            
            // table.draw();
            //ex_table.draw(); 

            var table = $('#attendees_ranking_table').DataTable();
            table.search( '' ).columns().search( '' ).draw();

        });
        
        
        if ($("#filter_list").html().length > 0) {
           $('.filter-footer').addClass('filtering'); 
        } else {
            $('.filter-footer').removeClass('filtering'); 
        }
        
    }); 


    
    
  
    

// Star Toggles

$('.star-toggler').click(function(){
    $(this).toggleClass('open'); 
    $(this).mouseleave(function() {
         $('.star-toggler').removeClass('open');
    });
}); 
    
// Filter Toggle
$('.filter-toggle').click(function(e){
    e.preventDefault();
    $('.filters').toggleClass('active'); 
    if($('.filters').hasClass('active')) {
        $('.filter-toggle').html('Hide Filters');
    } else {
        $('.filter-toggle').html('Show Filters');
    }
}); 
    

$('.advanced-toggle').click(function(e){
    e.preventDefault();
    $('.advanced-filters').toggleClass('open'); 
    if($('.advanced-filters').hasClass('open')) {
        $('.advanced-toggle').html('Hide Additional Filters');
    } else {
        $('.advanced-toggle').html('Show Additional Filters');
    }
}); 
    

$('#editControls a').click(function(e) {
  switch($(this).data('role')) {
    case 'h1':
    case 'h2':
    case 'p':
      document.execCommand('formatBlock', false, $(this).data('role'));
      break;
    default:
      document.execCommand($(this).data('role'), false, null);
      break;
    }
  update_output();
});

$('#editor').bind('blur keyup paste copy cut mouseup', function(e) {
    update_output();
});

function update_output() {
    $('#output').val($('#editor').html());
}



    // Check Terms and Conditions Checked

    $('#t_c').change(function() {
        var $check = $(this);
        if ($check.prop('checked')) {
            $('.submit-form').removeAttr('disabled');
        } else {
            $('.submit-form').attr("disabled", true);
        }
    });


    $('.has-other').change(function() {
        var other = $(this).find(":selected");
        var this_id = $(this).data('id');
        if(other.val() == 'Other' ) {
            $('#'+this_id+'.other-input').addClass('visible');
        }
        else {
            $('#'+this_id+'.other-input').removeClass('visible');
        }
    });

    $('.has-other').change(function() {
        var other = $(this).find(":checked");
        var this_id = $(this).data('id');
        if(other.val() == 'other' || other.val() == 'yes') {
            $('#'+this_id+'.other-input').addClass('visible');
        }
        else {
            $('#'+this_id+'.other-input').removeClass('visible');
        }
    });
    
    
    
    


    $('.form-toggle').click(function(e) {
        e.preventDefault();
        var this_id = $(this).data('id');
        $(this).addClass('active');
        $('.form-toggle').not(this).removeClass('active');
        console.log(this_id);
        $('.form-tab').not(this).removeClass('active');
        $('#tab_'+this_id).addClass('active');
    });    


    //  Add event/brand values when adding New Att/Exhibitor
    $('#event_select').change(function() {
        var event = $(this).find(":selected").data('event');
        var brand = $(this).find(":selected").data('brand');
        $('#brand_id').val(brand);
        $('#event_id').val(event);
    });


    // View Attendee Info in Modal
    $('.view-info').on('click', function() { 
        
        
        var this_attendee = $(this).data('attendee');
        var attendee_info = $('#attendee_info');
        attendee_info.html('');
        $.ajax({
                url: site_url+'layout/attendee-info.php?id='+this_attendee,
                type: 'POST',
                dataType: "html",
            })
            .done(function (data) {
                attendee_info.html(data);
                // this_ex_res.html(data);
            })
            .fail(function () {
                console.log('Something went wrong...');
            });
    });

    
    $('.step-nav').click(function(e) {
        e.preventDefault();
        var this_id = $(this).data('id');
        $(this).addClass('active');
        $('.step-nav').not(this).removeClass('active');
        // console.log(this_id);
        $('.form-step').not(this).removeClass('active');
        $('.form-step').not(this).find('.required').removeClass('required-input');
        $('#step-'+this_id).addClass('active');
        $('#step-'+this_id).find('.required').addClass('required-input'); 
    }); 
     


    /*
    $('.btn-star').on('click', function() {
        var this_star_form = $(this).data('star');
        console.log(this_star_form);
        var this_parent = $(this).data('id');
        $('#main-star_'+ this_parent ).removeAttr('class');
        $('#main-star_'+ this_parent ).addClass('star');
        $('#main-star_'+ this_parent ).addClass(this_star_form);
    });
    */
       
    $('.btn-star').on('click', function() {
        var this_btn = $(this).data('id');
        $('.star_'+this_btn).removeClass('active');
        $(this).addClass('active');
    });
    
    $('.change-rating').on('change', function() { 
        var this_form =  $(this).data('id');
        var this_data = "";
        var this_data = $(".ex_star_form_"+this_form).serialize();
        var this_star = $("#star_rating_"+this_form);
        $.ajax({
                url: site_url+'events/attendees/stars.php',
                type: 'POST',
                data: this_data, // serialize the form data
            })
            .done(function (data) {
                // location.reload();
            })
            .fail(function () {
                console.log('Something went wrong...');
            });
    });    

    

    

    function updateSearchString() {  
         var allVals = [];
         $('.append_filter:checked').each(function() {
             var filter_val = $(this).val(); 
             var filter_string = '&'+filter_val;
            allVals.push(filter_string);
         });
          var search_string = allVals;
            $('#filter_query').html(allVals);
    }

    $(function() {
        $('.custom_params').on('click', function(e) {
            e.preventDefault();
            updateSearchString();
            console.log($('#filter_query').text());
            
            var filter_param = $('#filter_param').text();
            var filter_query = $('#filter_query').text();
            var filter_url = filter_param+filter_query;
            
            // var filter_string = $('#shit').text();
            
            filter_string = filter_url
    
            var events_url = site_url+'events/?'
            window.location.href = events_url + filter_string;  
        });
    });


    // Reset Filter
    $('.reset').click(function(){
        window.location.reload();
    }); 
   
    
 
    
});
 

    
    
$(function () {
  var $sections = $('.form-section');

  function navigateTo(index) { 
    // Mark the current section with the class 'current'
    $sections
      .removeClass('current')
      .eq(index)
        .addClass('current');
    // Show only the navigation buttons that make sense for the current section:
    $('.form-navigation .previous').toggle(index > 0);
    var atTheEnd = index >= $sections.length - 1;
    $('.form-navigation .next').toggle(!atTheEnd);
    $('.form-navigation [type=submit]').toggle(atTheEnd);
      
      
      
// Progress Bar 
// $('.progress_li').removeClass('active');
if($('#sec_1').hasClass('current')) {
    $('.progress_bar .sec_1').addClass('active');
}
if($('#sec_2').hasClass('current')) {
    $('.progress_bar .sec_2').addClass('active');
} 
if($('#sec_3').hasClass('current')) {
    $('.progress_bar .sec_3').addClass('active');
} 
if($('#sec_4').hasClass('current')) {
    $('.progress_bar .sec_4').addClass('active');
} 
if($('#sec_5').hasClass('current')) {
    $('.progress_bar .sec_5').addClass('active');
} 
if($('#sec_6').hasClass('current')) {
    $('.progress_bar .sec_6').addClass('active');
} 
if($('#sec_7').hasClass('current')) {
    $('.progress_bar .sec_7').addClass('active');
} 
if($('#sec_8').hasClass('current')) {
    $('.progress_bar .sec_8').addClass('active');
} 

      
      
      
  }

  function curIndex() {
    // Return the current index by looking at which section has the class 'current'
    return $sections.index($sections.filter('.current'));
  }

  // Previous button is easy, just go back
  $('.form-navigation .previous').click(function() {
    navigateTo(curIndex() - 1);
        $('html, body').animate({
            scrollTop: 0
        }, 400); 
  });

  // Next button goes forward iff current block validates
  $('.form-navigation .next').click(function() {
    if ($('.registration-form').parsley().validate('block-' + curIndex()))
      navigateTo(curIndex() + 1);
        $('html, body').animate({
            scrollTop: 0
        }, 400); 
  });

  // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
  $sections.each(function(index, section) {
    $(section).find(':input').attr('data-parsley-group', 'block-' + index);
  });
  navigateTo(0); // Start at the beginning
});




// Match Emails
$(".email_input").last().on("blur", function () {
    if ($(this).val() === $(".email_input").first().val()) {
        $(".error-text").text("emails match!"); 
        $(".error-text").removeClass("error"); 
        $(".error-text").addClass("valid"); 
    } else {
        $(".error-text").text("the emails don't match!");
        $(".error-text").removeClass("valid"); 
        $(".error-text").addClass("error"); 
    }
});  


// Create "Other" Field if Selected Other 
$(".hidden_input").hide();
$(function () {
     
    $('.has-other-field').on('change', function () {
        
        
        console.log('hey');
        var this_id = $(this).data('id');
        var field_name = $('#field_' + this_id + ' ' + 'option:selected').val();
        var this_attribute = $(this).attr('name');
        
        var inputToHide = $("#"+this_id+".hidden_input");
        console.log(inputToHide);
        
        if (field_name === "Other") {
            $(this).attr('name', '');
            inputToHide.show();
            inputToHide.attr('name', this_attribute);
        } else {
            $('#field_'+this_id).attr('name', this_id);
            inputToHide.hide();
            inputToHide.attr('name', '');
        }
    });
});


// View Attendee Info in Modal
$('.view-exhibitor-info').on('click', function() { 
    console.log('hi');
    var this_exhibitor = $(this).data('exhibitor');
    var exhibitor_info = $('#exhibitor_info');
    exhibitor_info.html('');
    $.ajax({
            url: '../../layout/exhibitor-info-sm.php?id='+this_exhibitor,
            type: 'POST',
            dataType: "html",
        })
        .done(function (data) {
            exhibitor_info.html(data);
            // this_ex_res.html(data);
        })
        .fail(function () {
            console.log('Something went wrong...');
        });
});


