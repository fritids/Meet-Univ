<?php
$flag=1;
  if($admin_user_level=='3')
  {
  $univ_detail_edit=$this->adminmodel->fetch_univ_detail($user_id);
  if($univ_detail_edit==0)
  {
  $flag=0;
  }
  }
 if($flag==1) { ?> 
	<div id="sidebar">

		<ul id="nav">
			<li><a href="<?php echo $base; ?>admin"><strong><img src="<?php echo "$base$admin_img" ?>/nav/dashboard.png" alt="" /> Dashboard</strong></a></li>
			<li><a href="#"><img src="<?php echo "$base$admin_img" ?>/nav/pages.png" alt="" /> Pages</a></li>
			<?php if($admin_user_level=='5' || $admin_user_level=='3')
			{ ?>
			<li><a href="<?php echo $base; ?>admin_promotional"><img src="<?php echo "$base$admin_img" ?>/nav/world.png" alt="" />Promotional Panel </a></li>
			<?php if($admin_user_level=='3')
			{ ?>
			<li><a href="<?php echo $base; ?>emailpacks/user_email_packs"><img src="<?php echo "$base$admin_img" ?>/mail.png" alt="" />Your Email Plans</a></li>
			
			<li><a href="<?php echo $base; ?>admin_engagement"><img src="<?php echo "$base$admin_img" ?>/nav/world.png" alt="" />Engagement Panel </a></li>
			<?php 
			}
			} 
			if($admin_user_level=='5' || $admin_user_level=='2')
			{ ?>
			<li>
			<a href="<?php echo $base; ?>admin_counsellor/counsellor"><img src="<?php echo "$base$admin_img" ?>/nav/email.png" alt="" /> Counsellor</a>			
			</li>
			<?php
			}
			if($admin_user_level=='6' || $admin_user_level=='4') 
			{ ?>
			<li>
			<a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/leads.jpg" alt="" /> Manage Leads</a>
			
			<ul>
			<li><a href="<?php echo $base; ?>adminleads/managetelecalls"><img src="" alt="" />Unverified Leads</a></li>
			<li><a href="<?php echo $base; ?>adminleads/manage_verified_telecalls"><img src="" alt="" />Verified Leads</a></li></ul></li>
			<?php } ?>
		<!--	<li><a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/media.png" alt="" /> Media</a>
				<ul>
					<li><a href="#">Photos</a></li>
					<li><a href="#">Video</a></li>
					<li><a href="#">Audio</a></li>
				</ul>
			</li>
			<li><a href="#"><img src="<?php echo "$base$admin_img" ?>/nav/calendar.png" alt="" /> Calendar</a></li>
		-->	
		<?php 
		if($admin_user_level=='5' || $admin_user_level=='4' || $admin_user_level=='3') {
		$admin_add_op=array('4','6','8','10');
		
foreach ($admin_priv as $admin_priv_res)
	{
				
			if($admin_priv_res['privilege_type_id']=='3' && $admin_priv_res['privilege_level']!='0')
			{?>
			<li><a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/event.jpg" alt="" /> Events</a>
			<ul>
			<?php
			if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
			{?>
			<li><?php echo anchor("$base".'adminevents/add_event', 'Add Events'); ?></li>
			<!--<li><?php //echo anchor("$base".'adminevents/add_more_event', 'Add Multiple Events'); ?></li>-->
			<?php } ?>
			<li><?php echo anchor("$base".'adminevents', 'Manage Events'); ?></li></ul></li>
			<?php
			}
			
			if($admin_priv_res['privilege_type_id']=='2' && $admin_priv_res['privilege_level']!='0')
			{?>
			<li><a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/nna.gif" alt="" /> Articles</a>
			<ul><?php
			if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
			{?>
			<li><?php echo anchor("$base".'adminarticles/add_article', 'Add Article'); ?></li>
			<?php } ?>
			<li><?php echo anchor("$base".'adminarticles/manage_articles', 'Manage Articles'); ?></li></ul>
			
			</li>
			<?php
			}
			if($admin_priv_res['privilege_type_id']=='2' && $admin_priv_res['privilege_level']!='0')
			{?>
			<li><a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/nna.gif" alt="" />News</a>
			<ul><?php
			if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
			{?>
			<li><?php echo anchor("$base".'adminnews/add_news', 'Add News'); ?></li>
			<?php } ?>
			<li><?php echo anchor("$base".'adminnews/manage_news', 'Manage News'); ?></li></ul>
			
			</li>
			<?php
			}
			if($admin_priv_res['privilege_type_id']=='6' && $admin_priv_res['privilege_level']!='0')
   {?>
   <li><a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/qna.gif" alt="" />Q & A Section</a>
   <ul><?php
   if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
   {?>
   <li><?php echo anchor("$base".'adminques/add_ques', 'Add Question'); ?></li>
   <?php } ?>
   <li><?php echo anchor("$base".'adminques/manage_ques', 'Manage Questions'); ?></li></ul>
   
   </li>
   <?php
   }
   if($admin_priv_res['privilege_type_id']=='5')
   {?>
   <li><a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/nna.gif" alt="" />Email Packs</a>
   <ul><?php
   if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
   {?>
   <li><?php echo anchor("$base".'emailpacks/add_packs', 'Add Email Pack'); ?></li>
   <li><?php echo anchor("$base".'emailpacks/add_promocode', 'Add Promocode'); ?></li>
   <li><?php echo anchor("$base".'emailpacks/manage_promos', 'Manage Promocodes'); ?></li>
   <?php } ?>
   <li><?php echo anchor("$base".'emailpacks/manage_packs', 'Manage Email Packs'); ?></li></ul>
   
   </li>
   <?php
   }
			if($admin_priv_res['privilege_type_id']=='1' && $admin_priv_res['privilege_level']!='0')
			{
			?>
			<li><a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/users.png" alt="" /> Users</a>
				<ul>
		<?php
		if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
		{?>
					<li><?php echo anchor("$base".'admin/adduser', 'Add new User'); ?></li>
					
		<?php }?>			
					<li><?php echo anchor("$base".'admin/manageusers', 'Manage User'); ?></li>
				
				</ul>
			</li>	
		
	<?php 
	}
	
		if($admin_priv_res['privilege_type_id']=='11' && $admin_priv_res['privilege_level']!='0' && $admin_user_level!='3')
		{
			?>
		<li><a href="#" class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/gallery.jpg" alt="" />  Manage Home Gallery</a>
		<ul>
		<?php
		if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
		{ ?>
		<li><?php echo anchor("$base".'admin/home_gallery', 'Add Images'); ?></li>
		<?php } ?>
		<li><?php echo anchor("$base".'admin/manage_home_gallery', 'Manage Home Gallery'); ?></li>
		</ul>
		</li>
		
		<?php
		} 
		if($admin_priv_res['privilege_type_id']=='5' && $admin_priv_res['privilege_level']!='0')
			{
			?>
			
		<li><a href="#"  class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/univ.png" alt="" />  Manage University</a>
		<ul><?php
		if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
		{?>
		<li><?php echo anchor("$base".'admin/create_university', 'Create University'); ?></li>
		<?php } ?>
		<li><?php echo anchor("$base".'admin/manage_university', 'Manage University'); ?></li>
		</ul>
		</li>
		
		<?php }
		if($admin_priv_res['privilege_type_id']=='11' && $admin_priv_res['privilege_level']!='0') {?>
		<li>
		<a href="#"  class="collapse" ><img src="<?php echo "$base$admin_img" ?>/nav/gallery.jpg" alt="" />University Gallery</a>
		<ul><?php
		if(in_array($admin_priv_res['privilege_level'],$admin_add_op))
		{?>
		<li><?php echo anchor("$base".'admin/add_univ_gallery', 'Add Images'); ?></li>
		<?php } ?>
		<li><?php echo anchor("$base".'admin/manage_univ_gallery', 'Manage Gallery'); ?></li>
		</ul>
		</li>
		<?php } 
		
		
	} ?>
			<?php if($admin_user_level=='5'){ ?>
		<li><a href="#"  class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/book.jpg" alt="" /> Program/Courses</a>
		<ul>
		<li><?php echo anchor("$base".'admincourses/upload_courses', 'Add Bulk Courses'); ?></li>
		<li><?php echo anchor("$base".'admincourses/add_course', 'Add SIngle Course'); ?></li>
		<li><?php echo anchor("$base".'admincourses/manage_courses', 'Manage Course'); ?></li>
		
		</ul>
		</li>
		<?php }
		if($admin_user_level=='3')
			{
			?>
			
		<li><a href="#"  class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/univ.png" alt="" />  Manage University</a>
		<ul>
		<li><?php echo anchor("$base".'admin/update_university_detail/'.$univ_detail_edit[0]->univ_id, 'Update University'); ?></li>
		</ul>
		</li>
		
		<?php }

		if($admin_user_level=='3' || $admin_user_level=='5'){  ?>
		
		<li><a href="#"  class="collapse"><img src="<?php echo "$base$admin_img" ?>/nav/book.jpg" alt="" />University/Courses</a>
		<ul>
		<li><?php echo anchor("$base".'admincourses/university_addcourse', 'Add Courses To University'); ?></li>
		<li><?php echo anchor("$base".'admincourses/manage_univ_course', 'Manage Courses'); ?></li>
		
		</ul>
		</li>
		<?php } 
		
		if( $admin_user_level=='5'){
		?>
		<li>
		<a href="#"  class="collapse" ><img src="<?php echo "$base$admin_img" ?>/nav/book.jpg" alt="" />Manage Univ/Program</a>
		<ul>
		<li><?php echo anchor("$base".'admincourses/map_program_and_university', 'Area Of Intrest/Program'); ?></li>
		</ul>
		</li>
		<li>
		<a href="#"  class="collapse" ><img src="<?php echo "$base$admin_img" ?>/nav/book.jpg" alt="" />Manage Univ/users</a>
		<ul>
		<li><?php echo anchor("$base".'admin_users/map_univ_vs_users', 'Add Univ vs Users'); ?></li>
		<li><?php echo anchor("$base".'admin_users/manage_map_univ_vs_users', 'Manage Univ vs Users'); ?></li>
		
		</ul>
		</li>
		<!--<li>
		<a href="#"  class="collapse" ><img src="<?php echo "$base$admin_img" ?>/nav/book.jpg" alt="" />Manage Progrmas</a>
		<ul>
		<li><?php echo anchor("$base".'admincourses/map_area_interest_and_progrmas', 'Area Of Intrest/Program'); ?></li>
		</ul>
		</li>-->
		<?php } ?>
		<li>
			<a href="#"><span>12</span><img src="<?php echo "$base$admin_img" ?>/nav/settings.png" alt="" /> Settings</a></li>
			<li><a href="#"><img src="<?php echo "$base$admin_img" ?>/nav/support.png" alt="" /> Support</a></li>
			
		</ul>
		
<?php } ?>		
		<!--<div class="status_box">
			<ul>
				<li><a href="#" class="online" title="Online">Web server 1</a></li>
				<li><a href="#" class="online" title="Online">Web server 2</a></li>
				<li><a href="#" class="warning" title="Warning">DB server</a></li>
				<li><a href="#" class="offline" title="Offline">Mail server</a></li>
			</ul>
		</div>-->
		
	</div>		<!-- #sidebar ends -->
	
<?php } ?>	
	