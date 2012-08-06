<style>
#content_msg {
	overflow: hidden;
	padding: 0 20px;
	left: 220px;
	width: 82%;
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
<div class="message info"><p>Student has been verified !!!</p></div> 
</div>
<div id="content_verify_message" class="content_verify_msg" style="display:none;">
<div class="message info"><p>No Verify has selected!!!</p></div> 
</div>
	
	<div id="content" style="margin-left: 200px;">
		
			<?php if($teleleads!='0') { ?>
			<!-- .breadcrumb ends -->
	<div class="grid10 margin-delta margin_t">
		<div>
			<div class="grid1 float_l">
				<b>Sr.no</b>
			</div>
			<div class="span14 float_l">
				<b class="blue">FullName</b>
			</div>
			<div class="span14 float_l">
				<b class="green">Email Verfied</b>
			</div>
			<div class="span14 float_l">
				<b class="blue">Source</b>
			</div>
			<div class="span14 float_l">
				<b class="green">Phone Verified</b>
			</div>
			<div class="span14 float_l">
				
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="dotted_line"></div>
		<div id="content_data">
		<?php 
	$sno=1;
	foreach($teleleads as $teleleadsres) { ?>	
		<div id="data_data_<?php echo $teleleadsres['id']; ?>" class="old_data old_data_paging">
			<div class="grid1 float_l">
					<?php echo $sno++ ;?>
			</div>
			<div class="span14 float_l" id="lead_fname_<?php echo $teleleadsres['id']; ?>">
				<?php echo $teleleadsres['fullname']; ?>
			</div>
			<div class="span14 float_l" >
				<span id="lead_email_<?php echo $teleleadsres['id']; ?>"><?php echo $teleleadsres['email']; ?></span>(
<?php if($teleleadsres['email_verified']) { echo '<span style="color:green;font-size:10px;">Verified</span>' ;}
 else { echo '<span style="color:red;font-size:10px;" id="span_not_verified_'.$teleleadsres['id'].'">Not Verified</span>'; } ?>
 )
			</div>
			
			
			<div class="span14 float_l">
				<?php
if($teleleadsres['lead_source']=='site_user'){ 
$lead_source="Site User"; }
else if($teleleadsres['lead_source']=='fb_login'){ $lead_source="FB Login(Site User)"; }
else if($teleleadsres['lead_source']=='android_user'){ $lead_source="Mobile App"; }
else if($teleleadsres['lead_source']=='event_user'){ $lead_source="Event Registration"; }
else if($teleleadsres['lead_source']=='fb_canvas'){ $lead_source="FB Application"; }
else if($teleleadsres['lead_source']=='college_request') { $lead_source="Request College"; }
else{$lead_source="Other";};
echo $lead_source;
?>
			</div>
			<div class="span14 float_l">
				<?php 
if($teleleadsres['phone_no1']=='' || $teleleadsres['phone_no1']==0 || $teleleadsres['phone_no1']==NULL) {
echo "<span style='color:blue'>Not Available</span>(<span style='color:red;font-size:10px;'>Not Verified</span>)";
}
else {
echo "<span id='lead_phone_$teleleadsres[id]'>".$teleleadsres['phone_no1']."</span>"; ?>(
<?php if($teleleadsres['phone_verified']) { echo '<span style="color:green;font-size:10px;">Verified</span>' ;}
 else { echo '<span style="color:red;font-size:10px;" id="span_not_verified_phone_'.$teleleadsres['id'].'"> Not Verified</span>'; } ?> )<?php }?>
			</div>
			<div class="span14 float_l">
				<a href="javascript:void(0);" onclick="edit_user_lead('<?php echo $teleleadsres['id']; ?>')" id="data_<?php echo $teleleadsres['id']; ?>" class="edit inline">Edit</a>
				<div class="inline margin_l1" id="ajax_loading_img_<?php echo $teleleadsres['id']; ?>" style="display:none;"><img src="<?php echo $base ;?>images/ajax_loader.gif"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div id="<?php echo $teleleadsres['id']; ?>"></div>
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
	
	
	function edit_user_lead(id)
	{
	//alert(id);
	var url='<?php echo $base;?>adminleads/fetch_user_info_for_tele'
	$.ajax({
          type: "POST",
          data: "id="+id,
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
            $("#content_data").html("");
          },
          success: function(msg) {
		  //alert(msg);
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