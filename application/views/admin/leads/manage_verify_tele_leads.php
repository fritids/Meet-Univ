<style>
#content_msg {
	overflow: hidden;
	padding: 0 20px;
	left: 220px;
	width: 25%;
	position: relative;
	top: 22px;
	}
#content_verify_message {
	overflow: hidden;
	padding: 0 20px;
	left: 220px;
	width: 82%;
	}	
.message.info {
	border: 1px solid #bbdbe0;
	background: #ecf9ff url(../../images/admin/info.gif) 12px 12px no-repeat;
	color: #0888c3;
	}
	
	.message {
	padding: 10px 15px 10px 40px;
	margin-bottom: 15px;
	font-weight: bold;
	overflow: hidden;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	}
	
</style>
<div id="content_msg" style="display:none;">
<div class="message info"><p>Student Info updated Successfully.</p></div> 
</div>
<div id="content_verify_message" class="content_verify_msg" style="display:none;">
<div class="message info"><p>No Verify has selected!!!</p></div> 
</div>
<div id="content_drop_msg" style="display:none;">
<div class="message info"><p>Record dropped !!!</p></div> 
</div>
	
	<div id="content" >
		
			<?php if($verify_teleleads!='0') { ?>
			<!-- .breadcrumb ends -->
	<div class="margin-delta margin_t" style="width: 945px;">
		<div>
			<div class="grid1 float_l">
				<b>Sr.no</b>
			</div>
			<div class="span1 float_l">
				<b class="blue">FullName</b>
			</div>
			<div class="width_adjust float_l">
				<b class="green">Email Verfied</b>
			</div>
			<div class="span1 float_l">
				<b class="blue">Source</b>
			</div>
			<div class="span1 float_l">
				<b class="green">Phone Verified</b>
			</div>
			<div class="span0 float_l">
				
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="dotted_line"></div>
		<div id="content_data">
		<?php 
	$sno=1;
	foreach($verify_teleleads as $teleleadsres) {
	if($sno % 2) {
        $class = 'back_diff';
    } else {
	$class = '';
    }
	?>	
		<div id="data_data_<?php echo $teleleadsres['v_id']; ?>" class="<?php echo $class; ?> old_data old_data_paging" style="-webkit-border-bottom: 1px solid #CCC;-moz-border-bottom: 1px solid #CCC;border-bottom: 1px solid #CCC;padding: 3px 0px;">
			<div class="grid1 float_l">
					<?php echo $sno++ ;?>
			</div>
			<div class="span1 float_l" id="lead_fname_<?php echo $teleleadsres['v_id']; ?>">
				<?php echo $teleleadsres['v_fullname']; ?>
			</div>
			<div class="width_adjust float_l" >
				
<?php if($teleleadsres['v_verified_email']) {
?>
<span class="float_l data_img" id="span_verified_email_<?php echo $teleleadsres['v_id']; ?>" style="float: left;">
<img  src="<?php echo base_url(); ?>images/admin/success.gif"/>
</span>
<?php } else { ?>

<span  class="float_l data_img" id="span_verified_email_<?php echo $teleleadsres['v_id']; ?>" style="float: left;">
 <img  src="<?php echo base_url(); ?>images/admin/error.gif"/> </span>
 <?php } 
 if($teleleadsres['v_email']!='')
       { ?>
	   <span class="email_data" id="lead_email_<?php echo $teleleadsres['v_id']; ?>">
 <?php
	   echo $teleleadsres['v_email'];
	   }
	   else
	   { ?>
	      <span class="email_data" id="lead_email_<?php echo $teleleadsres['v_id']; ?>" style="color:blue;">
      <?php
	   echo "Not Availbale";
	   }
 ?></span>
			</div>
			
			
			<div class="span1 float_l">
				<?php
if($teleleadsres['v_user_type']=='site_user'){ 
$lead_source="Site User"; }
else if($teleleadsres['v_user_type']=='fb_login'){ $lead_source="FB Login(Site User)"; }
else if($teleleadsres['v_user_type']=='android_user'){ $lead_source="Mobile App"; }
else if($teleleadsres['v_user_type']=='event_user'){ $lead_source="Event Registration"; }
else if($teleleadsres['v_user_type']=='fb_canvas'){ $lead_source="FB Application"; }
else if($teleleadsres['v_user_type']=='college_request') { $lead_source="Request College"; }
else{$lead_source="Other";};
echo $lead_source;
?>
			</div>

<div class="span1 float_l" >

<?php 

 if($teleleadsres['v_verified_phone']) {
?>
<span  id="span_verified_phone_<?php echo $teleleadsres['v_id']; ?>">
<img  src="<?php echo base_url(); ?>images/admin/success.gif"/>
</span>
<?php } else { ?>

<span  id="span_verified_phone_<?php echo $teleleadsres['v_id']; ?>">
 <img  src="<?php echo base_url(); ?>images/admin/error.gif"/> </span>
 <?php }  ?>
<?php if($teleleadsres['v_phone']=='' || $teleleadsres['v_phone']==0 || $teleleadsres['v_phone']==NULL) {
echo "<span style='color:blue'>Not Available</span>";
}
else {
echo "<span id='lead_phone_$teleleadsres[v_id]'>".$teleleadsres['v_phone']."</span>";
}?>
</div>


 <div class="span0 float_l">
				<a href="javascript:void(0);" onclick="edit_user_lead('<?php echo $teleleadsres['v_id']; ?>','<?php echo $teleleadsres['v_lead_id']; ?>')" id="data_<?php echo $teleleadsres['v_id']; ?>" class="edit inline"><img src="<?php echo $base; ?>images/admin/edit-icon.png" alt="Edit"></a>
				<a href="javascript:void(0);" onclick="delete_this_record('<?php echo $teleleadsres['v_id']; ?>')" id="data_del_<?php echo $teleleadsres['v_id']; ?>" class="edit inline"><img style="height:18px;" src="<?php echo $base; ?>images/admin/delete.png" alt="Delete"></a>	
				<div class="inline margin_l1" id="ajax_loading_img_<?php echo $teleleadsres['v_id']; ?>" style="display:none;"><img src="<?php echo $base ;?>images/ajax_loader.gif"></div>
</div>
			<div class="clearfix"></div>
		</div>
		<div id="<?php echo $teleleadsres['v_id']; ?>"></div>
	<?php }
?>
<div id="pagination" class="table_pagination right paging-margin float_r" style="margin-right:50px;">
            <?php echo $this->pagination->create_links();?>
           
  </div>
  <input type="hidden" id="lastviewdlead" value="0">	

</div>
<?php	}?>	
	</div>
	</div>
		
<script type="text/javascript">
	var main_url = "<?php echo $base ?>";
	function delete_this_record(id)
	{//alert(id);
		var current_id = id;
		var ask_confirm = confirm("Do you want to drop this record?");
		var url='<?php echo $base;?>admin_counsellor/droprecord';
		if(ask_confirm)
		{
		$.ajax({
		type: "POST",
		data: "id="+id,
		url: url,
		async: false,
		cache: false,
		success: function(msg)
		{
			if(msg == '1')
			{
				$("#data_data_"+current_id).hide("slow");
				$("#data_data_"+current_id).replaceWith("");
				$("#content_drop_msg").css("display","block");
				$("#content_drop_msg").hide(5000);
			}
		}
		});
		}
	}
	function verify_lead(id)
	{
		var dynamic_lead_id = id.name;
		var verify_image_yes = main_url+'images/admin/success.gif';
		var verify_image_no = main_url+'images/admin/error.gif';
		if(id.id == "check_verify_lead_email_"+dynamic_lead_id)
		{
			if($("#check_verify_lead_email_"+dynamic_lead_id).is(':checked'))
			{
			$("#verify_img_email_"+dynamic_lead_id).html('<img src="'+verify_image_yes+'" />');
			}
			else{
			$("#verify_img_email_"+dynamic_lead_id).html('<img src="'+verify_image_no+'" />');
			}
		}
		else if(id.id == "check_verify_lead_phone_"+dynamic_lead_id)
		{
			if($("#check_verify_lead_phone_"+dynamic_lead_id).is(':checked'))
			{
			$("#verify_img_phone_"+dynamic_lead_id).html('<img src="'+verify_image_yes+'" />');
			}
			else{
			$("#verify_img_phone_"+dynamic_lead_id).html('<img src="'+verify_image_no+'" />');
			}
		}
	}
	
	
	function edit_user_lead(id,lead_id)
	{
	//alert(id);
	var url='<?php echo $base;?>adminleads/fetch_user_info_for_verify_tele';
	$.ajax({
          type: "POST",
          data: "id="+id+"&lead_id="+lead_id,
          url: url,
          beforeSend: function() {
           $('#ajax_loading_img_'+id).show();
		   var lasteditleadid=$('#lastviewdlead').val();
		   //alert(lasteditleadid);
		   if(lasteditleadid!='0')
		   {
		    $('#edit_data_'+lasteditleadid).hide(1000);
			$('#edit_data_'+lasteditleadid).replaceWith('');
			 $('#data_'+lasteditleadid).show();
		   }
          },
          success: function(msg) {
		  $('#lastviewdlead').val(id);
		  $('#ajax_loading_img_'+id).hide();
		  $('#data_data_'+id).after(msg);
		  $('#edit_data_'+id).slideDown(500);
		  //$("#edit_data_"+id).css("width","589").css("padding-top","10px").css("border-color", "#000").css("border-width", "1px").css('border-style','solid');
		  $('#data_'+id).hide();
				 // $(this).after(msg);
          //  $("#xx").html(msg);
           // applyPagination();
          }
        });
	}
	
	$(function() {
    applyPagination();

    function applyPagination() {
      $("#pagination a").click(function() {
        var url = $(this).attr("href");
        $.ajax({
          type: "POST",
          data: "ajax=1",
          url: url,
          beforeSend: function() {
            //$("#content_data").html("");
			 $("#content_data").css("opacity","0.5");
          },
          success: function(msg) {
		  //alert(msg);
		  $("#content_data").css("opacity","1");
            $("#content_data").html(msg);
            applyPagination();
          }
        });
        return false;
      });
    }
  });
  
		/*$(document).ready(function() {
			var globalid;
			 $(".edit").click(function () {
				globalid = $(this).attr('id');
				$(".data").hide('slow');
				$(".old_data").show('slow');
				$("#data_"+globalid).hide('slow');
				$("#edit_"+globalid).slideDown('slow');
				$("#edit_"+globalid).css("width","589").css("padding-top","10px").css("border-color", "#000").css("border-width", "1px").css('border-style','solid');
				$("#cancel_"+globalid).click(function () {
					$("#edit_"+globalid).css('display','none');
					$("#data_"+globalid).show('slow');
				});
				
			 });
		});*/
		function canceldata(id){
					$("#edit_data_"+id).hide(1000);
					$('#edit_data_'+id).replaceWith('');
					$('#data_'+id).show();
					//$("#data_"+id).show('slow');
				};
				
				
</script>

</body>
</html>