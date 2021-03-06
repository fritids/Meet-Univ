<div class="body" id="content">
		<div>
			
			<div class="float_l data8 margin_delta">
				<div>
					<div class="green_sms float_l">
						<a href="<?php echo $base; ?>admin_promotional/sms_campaign" style="color:white;text-decoration:none">SMS</a>
					</div>
					<div class="orange_active float_l">
						<a href="<?php echo $base; ?>admin_promotional/email_campaign" style="color:white;text-decoration:none">EMAIL</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="data7 margin_delta one_more">
					<span class="green_heading">EMAIL campaign:</span>
					<form class="form-horizontal margin_t" action="send_email" method="post" onsubmit="disable()">
						<div class="control-group2">
							<div class="float_l">								
								<div class="controls-input-data">
								<label class="label-control-data" for="select01">Country: </label>
									<select  id="country_list" name="country" onchange="count_student_change_sms_email_wise(this)">
										<option value="0">Select Country</option>
											<?php foreach($country_list as $country_lists) { ?>
											<option value="<?php echo $country_lists['country_id']; ?>"><?php echo $country_lists['country_name']; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
							<div class="dotted_width float_l"></div>
							<h3 class="count_txt" id="total_no_of_student_in_country"><?php echo $total_student; ?></h3><span class="inline country_text_name">( Worldwide )</span>
						</div>
						<div class="clearfix"></div>
						<div class="control-group2">
							<div class="float_l">								
								<div class="controls-input-data">
								<label class="label-control-data"  for="select01">City: </label>
									<select id="city_list" name="city" onchange="count_student_change_sms_email_wise(this);" >
											<option value="0">Select City</option>
												<?php foreach($all_cities as $all_city) { ?>			
											<option value="<?php echo $all_city['city_id']; ?>"><?php echo $all_city['cityname']; ?></option>
												<?php } ?>			
									</select>
								</div>
							</div>
							<div class="dotted_width float_l"></div>
							<h3 class="count_txt"  id="no_of_student_in_city">0</h3>
						</div>
						<div class="clearfix"></div>
						<div class="control_group2">
						<label class="label-control-data" for="select01">Educational level: </label>
							<div class="float_l">								
								<div class="controls-input-data checkbox_bg">
									<input name="edu_level[]" type="checkbox" id="educ_pg"  value="4" onclick="count_student_change_sms_email_wise(this)">
									Post Graduate</br>
									<input name="edu_level[]" type="checkbox" id="educ_ug"  value="3" onclick="count_student_change_sms_email_wise(this)">
									Under Graduate<br />
									<input name="edu_level[]" type="checkbox" id="educ_foundation"  value="2" onclick="count_student_change_sms_email_wise(this)">
									Foundation
								</div>
							</div>
							<div class="dotted_width float_l"></div>
							<h3 class="count_txt" id="no_of_student_in_educ_lvl">0</h3>
						</div>
						<div class="clearfix"></div>
						<div class="control_form">
						<label class="label-control-data" for="select01"></label>
							<div class="float_l">
								<label class="label-control-data" for="select01"></label>
								<div class="controls-input-data checkbox_bg">
								<?php foreach($area_interest as $all_area_interest) { ?>			
											<input type="checkbox" name="subject[]" value="<?php echo $all_area_interest['prog_parent_id']; ?>">
									<?php echo $all_area_interest['program_parent_name']; ?></br/>
								<?php } ?>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="control-group2">
						<label class="label-control-data" for="select01"></label>
							<div class="float_l">
								<label class="label-control-data" for="select01"></label>
							<div class="controls-input-data">
								<textarea cols="31" rows="1" name="email_subject" placeholder="Subject : "></textarea>
							</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="control-group2">
						<label class="label-control-data" for="select01"></label>
							<div class="float_l">
								<label class="label-control-data" for="select01"></label>
							<div class="controls-input-data">
								<textarea cols="31" rows="3" id="email_body_value" name="email_text" placeholder="Type your text here.."></textarea>
							</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="control_form">
						<label class="label-control-data" for="select01"></label>
							<div class="controls-input-data">
							<input type="submit" class="btn_dark_blue" name="send_email" value="SEND NOW">
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="float_l data5 margin_4 ipad_bg" id="email_preview_box">
				<textarea col="50" rows="20" class="ipad_textarea" id="email_body_preview_value"  value="">Message Here...</textarea>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<script>	
function count_student_change_sms_email_wise(select)
{
var country_id=$('#country_list option:selected').val();
var country_text=$('#country_list option:selected').text();
var city_id=$('#city_list option:selected').val();
var city_text=$('#city_list option:selected').text();
var educ_chk='';
if($('#educ_pg').is(':checked'))
{
educ_chk=$('#educ_pg').val();
}
if($('#educ_ug').is(':checked'))
{
if(educ_chk!=''){
educ_chk=educ_chk+',';
}
educ_chk=educ_chk+$('#educ_ug').val();
}
if($('#educ_foundation').is(':checked'))
{
if(educ_chk!=''){educ_chk=educ_chk+',';}
educ_chk=educ_chk+$('#educ_foundation').val();
}

var change='';
if(select.id=='country_list')
{
change='country';
}
else if(select.id=='city_list')
{
change='city';
}
else
{
change='educ_level';
}
data={country_id:country_id,city_id:city_id,educ_level:educ_chk};
url='<?php echo $base; ?>admin_promotional/count_student_change_sms_email_wise/'+change+'/email';
$.ajax({
	   type: "POST",
	   url: url,
	   async:false,
	   data: data,
	   success: function(msg)
	   {
	   // alert(msg);
	    if(select.id=='country_list')
		{
		 if(country_id==0)
		 {
		 $('.country_text_name').text('Worldwide');
		 }
		 else
		 {
		 $('.country_text_name').text('');
		 }
		 var res=msg.split('!@#$%');
		 $('#city_list').html(res[0]);
		 $('#total_no_of_student_in_country').html(res[1]);
		 $('#no_of_student_in_city').html('0');
		 if(educ_chk!='')
		 $('#no_of_student_in_educ_lvl').html(res[2]);
		}
		else if(select.id=='city_list')
		{
		var res=msg.split('!@#$%');
		
		if(city_id=='0')
		{
		$('#no_of_student_in_city').html('0');
		} else { 
		$('#no_of_student_in_city').html(res[0]);
		}
		if(educ_chk!=''){
		$('#no_of_student_in_educ_lvl').html(res[1]);
		 }
		}
		else
		{
		if(educ_chk=='')
		{
		//$('#educ_lvl_text_name').html('Select Educ. Level');
		 $('#no_of_student_in_educ_lvl').html('0');
		}
		else {
		// $('#educ_lvl_text_name').html(educ_level_text);
		 $('#no_of_student_in_educ_lvl').html(msg);
		}
	   }
	}
});
}

$('#email_body_value').keyup(
function()
{
var val=$(this).val();
$('#email_body_preview_value').val(val);
if(val=='')
{
$('#email_body_preview_value').val('Your Message here....');
}
}
)
$(window).scroll(function(){
       $("#email_preview_box")
              .animate({"marginTop": ($(window).scrollTop() + 30) + "px"}, 100 );
});
function disable()
{
	
}
</script>	