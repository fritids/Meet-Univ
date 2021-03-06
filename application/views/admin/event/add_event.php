<div id="content" class="content_msg" style="display:none;z-index:99;position:absolute;left:190px;">
<div class="span8 margin_t">
  <div class="message success"><p class="info_message"></p>
</div>
  </div>
  </div>
 <?php 
$class_title=''; 
$class_univ_name='';
$class_country='';
$class_state='';
$class_city='';

$error_title = form_error('title');
$error_univ_id = form_error('university');
$error_univ_name = form_error('university_name');
$error_country=form_error('country');
$error_state=form_error('state');
$error_city=form_error('city');


if($error_title != '') { $class_title = 'focused_error_univ'; } else { $class_title='text'; }

if($error_univ_name != '' || $error_univ_id!='') { $class_univ_name = 'focused_error_univ'; } else { $class_univ_name='text'; }

if($error_country != '') { $class_country = 'focused_error_univ'; } else { $class_country='text'; }
if($error_state != '') { $class_state = 'focused_error_univ'; } else { $class_state='text'; }
if($error_city != '') { $class_city = 'focused_error_univ'; } else { $class_city='text'; }

?>
 <script type="text/javascript">
 
$(document).ready(function() {
	
	$("#univ_name").autocomplete("<?php echo $base; ?>autosuggest/suggest_university", {
		width: 320,
		matchContains: true,
		mustMatch: true
	});
	$("#univ_name").result(function(event, data, formatted) {
		$("#university").val(data[1]);
	});
	
	$("#country_name").autocomplete('<?php echo $base; ?>autosuggest/suggest_country', {
		width: 260,
		matchContains: true,
		mustMatch: true
	});
	$("#country_name").result(function(event1, data1, formatted1) {
		$("#country").val(data1[1]);
	});
    $("#state_name").autocomplete('<?php echo $base; ?>autosuggest/suggest_state', {
		width: 260,
		matchContains: true,
		mustMatch: true
	});
	$("#state_name").result(function(event2, data2, formatted2) {
	$("#state").val(data2[1]);
	});
	$("#city_name").autocomplete('<?php echo $base; ?>autosuggest/suggest_city', {
		width: 260,
		matchContains: true,
		mustMatch: true
	});
	$("#city_name").result(function(event3, data3, formatted3) {
	$("#city").val(data3[1]);
	});

});
</script>
  <script type="text/javascript" src="<?php echo $base; ?>/js/jquery.timepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>css/admin/jquery.timepicker.css" />

 <div id="content" >
	
		<div class="form span8 content_event_form1" >
		<h4 class="margin">Create University Events Step1</h4>
			<form action="<?php echo $base; ?>adminevents/add_event" method="post" class="caption_form">
				<ul>
					<li>
						<div>
							<div class="float_l span3 margin_zero">
								<label> Event Title</label>
							</div>
							<div class="float_l span3">
								<input type="text" id="title_event" size="30" title="Event Title" class="<?php echo $class_title; ?>" value="<?php echo set_value('title'); ?>" name="title">
								<span class="fillthis" id="title_event_ajax_err"> <?php echo form_error('title'); ?><?php echo isset($errors['title'])?$errors['title']:''; ?> </span>
								
							</div>
							
							<div class="clearfix"></div>
						</div>
					</li>
					<?php if($admin_user_level=='5' || $admin_user_level=='4') {?>
					<li>
						<div>
						<div class="float_l span3 margin_zero">
							<label>Choose University</label>
						</div>
						<div class="float_l span3">
	
						<input type="text" size="30" title="university" autocomplete="off"   value="<?php echo set_value('university_name'); ?>" class="<?php echo $class_univ_name; ?>" title="university" name="university_name" id="univ_name" />
						<input type="hidden" name="university" id="university" value="<?php echo set_value('university'); ?>" />
		<span class="fillthis" id="univ_name_ajax_err">
		<?php if($class_univ_name=='focused_error_univ') {
		 echo form_error('university_name'); echo isset($errors['university_name'])?$errors['university_name']:'';
		 } ?>
		</span>
		
						</div>
						<div class="clearfix"></div>
						</div>
					</li>
					
					<!--<li>
						<div>
						<div class="float_l span3 margin_zero">
							<label>Event Type</label>
						</div>
						<div class="float_l span3">
								<label><input type="radio" class="radio" name="demo" checked="checked" />University Event</label>
								<label><input type="radio" class="radio" name="demo" />Study Abroad Event</label>
				
						</div>
						<div class="clearfix"></div>
						</div>
					</li>
					-->
					<?php } else { ?>
	 				<input type="hidden" name="university" id="university" value="<?php echo $univ_info['univ_id']; ?>">
					<input type="hidden" name="university_name" id="university_name" value="<?php echo $univ_info['univ_name']; ?>">
					
					<?php }?>
					<li>
						<div>
						<div class="float_l span3 margin_zero">
							<label>Checked IF Event IS Online</label>
						</div>
					<div class="float_l span3">
					<label><input type="checkbox"  name="location_event" id="location_event"  /></label>
					</div>
						<div class="clearfix"></div>
						</div>
					</li>
					<li class="location_hide_show">
						<div>
							<div class="float_l span3 margin_zero">
								<label></label>
							</div>
							<div class="float_l span4" style="font-style:italic;font-weight:bold;color:#000" >
								<span>First Fill the Country and then State and then City..</span>
							
							</div>
								
								<div class="clearfix"></div>
						</div>
					</li>
					<li class="location_hide_show">
						<div>
							<div class="float_l span3 margin_zero">
								<label>Country</label>
							</div>
							<div class="float_l span3" >
								
<input type="text"  size="30" class="<?php echo $class_country; ?>" autocomplete="off"  value="<?php echo set_value('country_name'); ?>" title="country" name="country_name" id="country_name" />
				<input type="hidden" name="country" id="country" value="<?php echo set_value('country'); ?>" />
			<span class="fillthis" id="country_name_ajax_err" > <?php echo form_error('country'); ?><?php echo isset($errors['country'])?$errors['country']:''; ?> </span>
							
							</div>
								<div class="float_l span3">
								<a rel="modal-profile" href="#" id="add_country" class="tdn">Add New Country</a>
								</div>
								<div class="clearfix"></div>
						</div>
					</li>
					
					<li class="location_hide_show">
						<div>
						<div class="float_l span3 margin_zero">
							<label>State</label>
						</div>
						<div class="float_l span3">
							
	<input type="text" size="30" autocomplete="off"  value="<?php echo set_value('state_name'); ?>" class="<?php echo $class_state; ?>" disabled="disabled" title="state" name="state_name" id="state_name" />
						<input type="hidden" name="state" id="state" value="<?php echo set_value('state'); ?>" />
				
						<span class="fillthis" id="state_name_ajax_err"> <?php echo form_error('state'); ?><?php echo isset($errors['state'])?$errors['state']:''; ?> </span>
			
						</div>
						<div class="float_l span3">
							<a id="add_state" href="#" class="tdn">Add New State</a>
						</div>
						<div class="clearfix"></div>
						</div>
					</li>
					
					<li class="location_hide_show">
						<div>
						<div class="float_l span3 margin_zero">
							<label>City</label>
						</div>
						<div class="float_l span3">
						
						<input type="text" size="30" autocomplete="off"  class="<?php echo $class_city; ?>" disabled title="city" name="city_name" id="city_name" value="<?php echo set_value('city_name'); ?>" />
						<input type="hidden" name="city" id="city" value="<?php echo set_value('city'); ?>" />
				

	<span class="fillthis" id="city_name_ajax_err"> <?php echo form_error('city'); ?><?php echo isset($errors['city'])?$errors['city']:''; ?> </span>
				
						</div>
						<div class="float_l span3">
						<a id="add_city" href="#" class="tdn">Add New City</a>
						</div>
						<div class="clearfix"></div>
						</div>
					</li>
					<li>
						<div>
						<div class="float_l span3 margin_zero">
							<label>Hide Event On Site</label>
						</div>
					<div class="float_l span3">
					<label><input type="checkbox"  name="location_event" id="hide_event" value="1"  /></label>
					</div>
						<div class="clearfix"></div>
						</div>
					</li>
					<li>
						<div>
						<div class="float_l span3 margin_zero">
							<label>Event Place</label>
						</div>
						<div class="float_l span3">
						<input type="text" size="30" id="event_place" class="text" value="<?php echo set_value('event_place'); ?>" name="event_place">	
					<span class="fillthis" id="event_place_ajax_err" > </span>
						</div>
						</div>
					</li>
					
				</ul>
				<input type="button" id="add_event_step1" name="submit" class="ajaxsubmit margin_left_ajax" value="Next">
						
				</form>
		</div>
		<div class="form span8 content_event_form2">
		<h4 class="margin">Create University Events step II</h4>
				
			<form action="<?php echo $base; ?>adminevents/add_event" method="post" class="caption_form">
			<input type="button" id="add_event_step2" name="submit" class="ajaxsubmit margin_left_ajax" value="Back">
		
				<ul>
					
					<li>
						<div>
						<div class="float_l span3 margin_zero">
							<label>Event Type</label>
						</div>
						<div class="float_l span3">
							<select class="text styled span3 margin_zero" id="event_type"   name="event_type">
								<option value="">Select Category</option>
								<option value="spot_admission">Spot Admission</option>
								<option value="fairs">Fairs</option>
								<option value="alumuni">Counselling-Alumuni</option>
								<option value="others">Counselling-Others</option>
								
							</select>
				<span class="fillthis" id="event_type_ajax_err" > </span>
					
						</div>
						
						<div class="clearfix"></div>
						</div>
					</li>
					
					
					
					<li>
						<div>
							<div class="float_l span3 margin_zero">
								<label>Event Date</label>
							</div>
							<div class="float_l span3">
								<input type="text" size="30" id="event_date" style="background-color:none;" onkeydown="return false;" class="date_picker" value="<?php echo set_value('event_time'); ?>" name="event_time">
								<span class="fillthis" id="event_date_ajax_err" > </span>
					
		
							</div>
							
							<div class="clearfix"></div>
						</div>
					</li>
					<li>
						<div>
						<div class="float_l span3 margin_zero">
							<label>Checked IF Event Timing Is <br />
							(<i>Appintment based,Not Fixed etc.</i>)</label>
						</div>
						<div class="float_l span3">
						<label><input type="checkbox"  name="event_timing_not_fixed" id="event_timing_fixed_not_fixed"  /></label>
						</div>
						<div class="clearfix"></div>
						</div>
					</li>
					<li class="notfixed_event_timing" style="display:none;">
						<div >
							<div class="float_l span3 margin_zero">
								<label>Mention Event Timing </label>
							</div>
							<div class="float_l span3 ">
								<input type="text" class="text time" id="event_timing" size="30" value="" name="event_timing">
							<span class="fillthis" id="event_timing_ajax_err" > </span>
	
							</div>
							
							<div class="clearfix"></div>
						</div>
					</li>
					<li class="fix_event_timing">
						<div >
							<div class="float_l span3 margin_zero">
								<label>Event Start Time</label>
							</div>
							<div class="float_l span3 ">
								<input type="text" onkeydown="return false;" class="text time" id="event_time_start" size="30" value="<?php echo set_value('event_start_timing'); ?>" name="event_start_timing">
							<span class="fillthis" id="event_time_start_ajax_err" > </span>
	
							</div>
							
							<div class="clearfix"></div>
						</div>
					</li>
					<li class="fix_event_timing">
						<div >
							<div class="float_l span3 margin_zero">
								<label>Event End Time</label>
							</div>
							<div class="float_l span3" >
								<input type="text" onkeydown="return false;" class="text time" id="event_time_end" size="30" value="<?php echo set_value('event_end_timing'); ?>" name="event_end_timing">
							<span class="fillthis" id="event_time_end_ajax_err" > </span>
	
							</div>
							
							<div class="clearfix"></div>
						</div>
					</li>
					
					
					<li class="share_facebook_show_hide">
						<div >
							<div class="float_l span3 margin_zero">
								<label>Share on Facebook</label>
							</div>
							<div class="float_l span3" >
								<input type="checkbox"  class="text time" id="share_facebook"  name="share_facebook" />
						</span>					
							</div>
							
							<div class="clearfix"></div>
						</div>
					</li>
					<li class="post_facebook_show_hide">
						<div >
							<div class="float_l span3 margin_zero">
								<label>Post To Facebook Before</label>
							</div> 
							<div class="float_l span1" >
								<input type="checkbox"  class="text time" />&nbsp;3 days
							</div>
							<div class="float_l span1" >
								<input type="checkbox"  class="text time" />&nbsp;7 days
							</div><div class="float_l span1" >
								<input type="checkbox"  class="text time" />&nbsp;15 days
							</div>
							
							<div class="clearfix"></div>
						</div>
					</li>
					<li>
						<div>
							<div class="float_l span3 margin_zero">
								<label>Detail</label>
							</div>
							<div class="">
								<textarea rows="4" name="detail" id="event_detail" class="wysiwyg" cols="103"><?php echo set_value('detail'); ?></textarea>
							</div>
							<div class="clearfix"></div>
						</div>
					</li>
					
				</ul>
				<input type="hidden" name="edit_event" id="edit_event" value="0" >
				<input type="hidden" name="submit"  value="1" >
				
				<input type="button" id="submit_event"  name="submit" class="ajaxsubmit margin_left_ajax" value="Submit">
						
				</form>
		</div>
	
		<div class="form span11">
			
			<div class="modal-lightsout" id="add-country">
				<div class="modal-profile" id="add-country1">
					<h2>Add Your Place</h2>
					<a href="#" title="Close profile window" class="modal-close-profile">
					<img src="<?php echo "$base$img_path/$admin"; ?>/close_model.png" class="closeimagesize" alt="Close window"/></a>
					<form action="" method="post" id="form_country" id="add_country_form" >
						<p>
							<label>Country:</label><br>
							<input type="text" size="30" class="text" name="country_model" id="country_model" value=""> 
							<label class="form_error"  id="country_error"></label>
						</p>
						<p>
							<label>State:</label><br>
							<input type="text" size="30" class="text" name="state_model" id="state_model" value=""> 
							<label class="form_error"  id="state_error"></label>
						</p>
						<p>
							<label>City:</label><br>
							<input type="text" size="30" class="text" name="city_model" id="city_model" value=""> 
							<label class="form_error"  id="city_error"></label>
						</p>
						<p>
							<input type="button" class="submit" name="addcountry" id="addcountry" value="Submit">
						</p>
					</form>
				</div>
			</div>
			
			<div class="modal-lightsout" id="add-state">
				<div class="modal-profile" id="add-state1">
					<h2>Add Your Place</h2>
					<a href="#" title="Close profile window" class="modal-close-profile">
					<img src="<?php echo "$base$img_path/$admin"; ?>/close_model.png" class="closeimagesize" alt="Close window"/></a>
						<form action="" method="post" id="form_state" id="add_state_form">
						<p>
							<label>Country:</label><br>
						<select class="text country_select margin_zero" name="country_model1" id="country_model1" >
										<option value="">Select Country</option>
							<?php foreach($countries as $country) { ?>
										<option value="<?php echo $country['country_id']; ?>" ><?php echo $country['country_name']; ?></option>
										<?php } ?>
						</select>
							<label class="form_error"  id="country_error1"></label>
						
						</p>
							
						<p>
							<label>State:</label><br>
							<input type="text" size="30" class="text" name="state_model1" id="state_model1" value=""> 
								<label class="form_error"  id="state_error1"></label>
						
						</p>
						<p>
							<label>City:</label><br>
							<input type="text" size="30" class="text" name="city_model1" id="city_model1" value=""> 
								<label class="form_error"  id="city_error1"></label>
						
						</p>
						<p>
							<input type="button" class="submit" name="addstate" id="addstate" value="Submit">
						</p>
					</form>
					
				</div>
			</div>
			<div class="modal-lightsout" id="add-city">
				<div class="modal-profile" id="add-city1">
					<h2>Add Your Place</h2>
					<a href="#" title="Close profile window" class="modal-close-profile">
					<img src="<?php echo "$base$img_path/$admin"; ?>/close_model.png" class="closeimagesize" alt="Close window"/></a>
					<form action="" method="post" id="add_city_form" >
						<p>
							<label>Country:</label><br>
						<select class="text country_select margin_zero" name="country_model2"  id="country_model2" onchange="fetchstates('-1')">
										<option value="">Select Country</option>
							<?php foreach($countries as $country) { ?>
										<option value="<?php echo $country['country_id']; ?>" ><?php echo $country['country_name']; ?></option>
										<?php } ?>
						</select>
						<label class="form_error"  id="country_error2"></label>
						<div style="color: red;"> <?php echo form_error('country_model2'); ?><?php echo isset($errors['country_model2'])?$errors['country_model2']:''; ?> </div>
						
						</p>
						<p>
							<label>State:</label><br>
							<select class="text country_select margin_zero" name="state_model2"  id="state_model2" disabled="disabled">
							<option value="">Please Select</option>
							</select>
							<label class="form_error"  id="state_error2"></label>
						</p>
						<p>
							<label>City:</label><br>
							<input type="text" size="30" class="text" name="city_model2" id="city_model2"> 
								<label class="form_error"  id="city_error2"></label>
						</p>
						<p>
						<input type="hidden" name="level_user" value="3">
							<input type="button" class="submit" name="addcity" id="addcity" value="Submit">
						</p>
					</form>
					
				</div>
			</div>
	</div>
</div>	
	
<script>
function fetchcountry(cid,cname)
{
$('#country_name').val(cname);
$('#country').val(cid);
 $("#state_name").removeAttr("disabled");
 $("#city_name").removeAttr("disabled");

}
function fetchstates(sid,sname)
{
var stid=sid;
var cid;
if(sid=='-1')
{
stid='0';
cid=$("#country_model2 option:selected").val();
$.ajax({
   type: "POST",
   url: "<?php echo $base; ?>admin/state_list_ajax/",
   data: 'country_id='+cid+'&sel_state_id='+stid,
   cache: false,
   success: function(msg)
   {
    if(sid=='-1')
	{
	$('#state_model2').attr('disabled', false);
	$('#state_model2').html(msg);
	}
   }
   });
}  
else
{
$('#state_name').val(sname);
$('#state').val(sid);
$("#state_name").removeAttr("disabled");
$("#city_name").removeAttr("disabled");
}
} 
function fetchcities(cityid,cityname)
{
$('#city_name').val(cityname);
$('#city').val(cityid);
$("#state_name").removeAttr("disabled");
 $("#city_name").removeAttr("disabled");
}
//for fancy box
$.fn.center = function () {
        this.css("position","absolute");
        this.css("top","100px");
        this.css("left","330px");
        return this;
      }
 
    $(".modal-profile").center();
	$(".modal-profile1").center();
    $('.modal-lightsout').css("height", jQuery(document).height()); 
 
    $('#add_country').click(function() {
		 $('#add-country').fadeIn("slow");
        $('#add-country1').fadeTo("slow", .9);
    });
	$('#add_state').click(function() {
		//remove city and state form
		 $('#add-state').fadeIn("slow");
        $('#add-state1').fadeTo("slow", .9);
    });
	$('#add_city').click(function() {
		//remove city and state form
		$('#add-city').fadeIn("slow");
        $('#add-city1').fadeTo("slow", .9);
    });
    $('a.modal-close-profile').click(function() {
			//remove country and state form
        $('.modal-profile').fadeOut("slow");
        $('.modal-lightsout').fadeOut("slow");
    });
	$('a.modal-close-profile').click(function() {
			//remove country and state form
        $('.modal-profile1').fadeOut("slow");
        $('.modal-lightsout1').fadeOut("slow");
    });
	
	
$('#addcountry').click(function(){
	var country=$("#country_model").val();
	var state=$("#state_model").val();
	var city=$("#city_model").val();
	var flag=0;
	if(country=='' || country==null)
	{
	 $('#country_error').html("Please enter the country name"); 
	 $('#country_model').addClass('error');
	 flag=0;
	}
	else
	{
	$('#country_error').html("") 
	 $('#country_model').removeClass('error');
	  flag=flag+1;
	}
	if(state=='' || state==null)
	{
	$('#state_error').html("Please enter the state name"); 
	$('#state_model').addClass('error');
	flag=0;
	
	}
	else
	{
	$('#state_error').html(""); 
	$('#state_model').removeClass('error');
	 flag=flag+1;
	}
	if(city=='' || city==null)
	{
	$('#city_error').html("Please enter the city"); 
	$('#city_model').addClass('error');
	flag=0;
	}
	else
	{
	$('#city_error').html(""); 
	$('#city_model').removeClass('error');
	flag=flag+1;
	}
	if(flag==3)
	{
	 var  countrystatus=0;
		$.ajax({
	   type: "POST",
	   url: "<?php echo $base; ?>admin/check_unique_field/country_name/country",
	   async:false,
	   data: 'field='+country,
	   cache: false,
	   success: function(msg)
	   {
	   if(msg=='1')
		{
		$('#country_error').html('Country Already Exist');
		$('#country_model').addClass('error');
		}
		else if(msg=='0')
		{
		$('#country_model').html('');
		$('#country_error').addClass('');
		countrystatus=1;
		}
	   }
	   });
	 if(countrystatus)
	 {
	$.ajax({
	   type: "POST",
	   url: "<?php echo $base; ?>admin/add_country_ajax",
	   async:false,
	   data: 'country_model='+country+'&state_model='+state+'&city_model='+city,
	   cache: false,
	   success: function(msg)
	   {
	    var place=msg.split('##');
		fetchcountry(place[0],country);
		fetchstates(place[1],state);
		fetchcities(place[2],city);
		
		$('.modal-profile').fadeOut("slow");
        $('.modal-lightsout').fadeOut("slow");
		$('#add_country_form').reset();
		$('.info_message').html('Your Place Added Successfully');
		$('.content_msg').show(500);
	   }
	   });
	 } 
	   
	}
	
});






$('#addstate').click(function(){
	var country=$("#country_model1 option:selected").val();
	var countrytext=$("#country_model1 option:selected").text();
	
	var state=$("#state_model1").val();
	var city=$("#city_model1").val();
	var flag=0;
	if(country=='' || country==null || country=='0')
	{
	 $('#country_error1').html("Please select the country"); 
	 $('#country_model1').addClass('error');
	 flag=0;
	}
	else
	{
	$('#country_error1').html("");
	 $('#country_model1').removeClass('error');
	  flag=flag+1;
	}
	if(state=='' || state==null)
	{
	$('#state_error1').html("Please enter the state name"); 
	$('#state_model1').addClass('error');
	flag=1;
	
	}
	else
	{
	$('#state_error1').html(""); 
	$('#state_model1').removeClass('error');
	  flag=flag+1;
	}
	if(city=='' || city==null)
	{
	$('#city_error1').html("Please enter the city"); 
	$('#city_model1').addClass('error');
	flag=0;
	}
	else
	{
	$('#city_error1').html(""); 
	$('#city_model1').removeClass('error');
	 flag=flag+1;
	}
	if(flag==3)
	{
	 var  statestatus=0;
		$.ajax({
	   type: "POST",
	   url: "<?php echo $base; ?>admin/state_check",
	   async:false,
	   data: 'state_model1='+state+'&country_model1='+country,
	   cache: false,
	   success: function(msg)
	   {
	    if(msg=='1')
		{
		$('#state_error1').html('State Already Exist in Selected Country');
		$('#state_model1').addClass('error');
		}
		else if(msg=='0')
		{
		$('#state_error1').html('');
		$('#state_model1').addClass('');
		statestatus=1;
		}
	   }
	   });
	 if(statestatus)
	 {
	 $.ajax({
	   type: "POST",
	   url: "<?php echo $base; ?>admin/add_state_ajax",
	   async:false,
	   data: 'country_model1='+country+'&state_model1='+state+'&city_model1='+city,
	   cache: false,
	   success: function(msg)
	   {
	    var place=msg.split('##');
		fetchcountry(place[0],countrytext);
		fetchstates(place[1],state);
		fetchcities(place[2],city);
		$('.modal-profile').fadeOut("slow");
        $('.modal-lightsout').fadeOut("slow");
		$('#add_state_form').reset();
		$('.info_message').html('Your Place Added Successfully');
		$('.content_msg').css('display','block');
	   }
	   });
	 } 
	   
	}
	
});




$('#addcity').click(function(){
	var country=$("#country_model2 option:selected").val();
	var countrytext=$("#country_model2 option:selected").text();
	var state=$("#state_model2 option:selected").val();
	var statetext=$("#state_model2 option:selected").text();
	var city=$("#city_model2").val();
	var flag=0;
	if(country=='' || country==null || country=='0')
	{
	 $('#country_error2').html("Please select the country"); 
	 $('#country_model2').addClass('error');
	 flag=0;
	}
	else
	{
	$('#country_error2').html("");
	 $('#country_model2').removeClass('error');
	  flag=flag+1;
	}
	if(state=='' || state==null || state=='0')
	{
	$('#state_error2').html("Please select the state "); 
	$('#state_model2').addClass('error');
	flag=0;
	}
	else
	{
	$('#state_error2').html(""); 
	$('#state_model2').removeClass('error');
	 flag=flag+1;
	}
	if(city=='' || city==null)
	{
	$('#city_error2').html("Please enter the city"); 
	$('#city_model2').addClass('error');
	flag=0;
	}
	else
	{
	$('#city_error2').html(""); 
	$('#city_model2').removeClass('error');
	flag=flag+1;
	}
	if(flag==3)
	{
	 var  citystatus=0;
		$.ajax({
	   type: "POST",
	   url: "<?php echo $base; ?>admin/city_check",
	   async:false,
	   data: 'state_model2='+state+'&country_model2='+country+'&city_model2='+city,
	   cache: false,
	   success: function(msg)
	   {
	    if(msg=='1')
		{
		$('#city_error2').html('CIty Already Exist in Selected State');
		$('#city_model2').addClass('error');
		}
		else if(msg=='0')
		{
		$('#city_error2').html('');
		$('#city_model2').addClass('');
		citystatus=1;
		}
	   }
	   });
	 if(citystatus)
	 {
	 $.ajax({
	   type: "POST",
	   url: "<?php echo $base; ?>admin/add_city_ajax",
	   async:false,
	   data: 'country_model2='+country+'&state_model2='+state+'&city_model2='+city,
	   cache: false,
	   success: function(msg)
	   {
	    var place=msg.split('##');
		fetchcountry(place[0],countrytext);
		fetchstates(place[1],statetext);
		fetchcities(place[2],city);
		$('.modal-profile').fadeOut("slow");
        $('.modal-lightsout').fadeOut("slow");
		$('#add_city_form').reset();
		$('.info_message').html('Your Place Added Successfully');
		$('.content_msg').css('display','block');
	   }
	   });
	 } 
	   
	}
	
});			
			$(function() {
			$('#event_time_start').timepicker({ 'step': 15 });
			$('#event_time_end').timepicker({ 'step': 15 });
		  });



</script>