<div id="content" class="content_msg" style="display:none;">
<div class="span8 margin_t">  
<div class="message success"><p class="info_message"></p></div>  
</div>  
</div> 
<?php $class_title=''; 
$class_univ_name='';
$class_country='';
$class_state='';
$class_city='';
$error_title = form_error('title');
$error_univ_name = form_error('university');
if($error_title != '') 
{ $class_title = 'focused_error_univ'; } 
else 
{ $class_title='text'; }
if($error_univ_name != '') 
{ $class_univ_name = 'focused_error_univ'; } 
else { $class_univ_name='text'; }?>   
<div id="content">		
<h2 class="margin">Create News</h2>	
<div class="form span8">			
<form action="<?php echo $base; ?>adminnews/add_news" method="post" class="caption_form" enctype="multipart/form-data">				
<input type="hidden" name="news_type_ud" value="univ_news"/>
<ul>					
<li>						
<div>							
<div class="float_l span3 margin_zero">								
<label>Title</label>							
</div>							
<div class="float_l span3">								
<input type="text" size="30" class="<?php echo $class_title; ?>" value="<?php echo set_value('title'); ?>" name="title">								
<span style="color: red;"> <?php echo form_error('title'); ?><?php echo isset($errors['title'])?$errors['title']:''; ?> 
</span>									
</div>														
<div class="clearfix"></div>						
</div>					
</li>					
<?php if($admin_user_level=='5' || $admin_user_level=='4') 
{?>
<li>						
<div>						
<div class="float_l span3 margin_zero">							
<label>Choose University</label>						
</div>						
<div class="float_l span3">							
<select class="<?php echo $class_univ_name; ?> styled span3 margin_zero" name="university">								
<option value="">Please Select</option>									
<?php foreach($univ_info as $univ_detail) { ?>										
<option value="<?php echo $univ_detail->univ_id; ?>" ><?php echo $univ_detail->univ_name; ?></option>										
<?php } ?>							
</select>		
<span style="color: red;"> <?php echo form_error('university'); ?><?php echo isset($errors['university'])?$errors['university']:''; ?> </span>
</div>						
<div class="clearfix"></div>						
</div>					
</li>					
<?php } 
else { ?>	 				
<input type="hidden" name="university" value="<?php echo $univ_info['univ_id']; ?>">					
<?php }?>															
<li>						
<div>							
<div class="float_l span3 margin_zero">								
<label>News Logo</label>							
</div>							
<div class="">								
<input type="file" name="userfile" class="file">							
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
<textarea rows="12" name="detail"  cols="103"><?php echo set_value('detail'); ?></textarea>								
<span style="color: red;"> <?php echo form_error('detail'); ?><?php echo isset($errors['detail'])?$errors['detail']:''; ?> </span>							
</div>							
<div class="clearfix"></div>						
</div>					
</li>				
</ul>						
<input type="submit" name="submit" class="submit" value="Add news">									
</form>		
</div>					
</div>