<?php
$facebook = new Facebook();
$user = $facebook->getUser();
$this->load->model('users');
if ($user) {
//$logoutUrl2 = $this->tank_auth->logout();
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me'); 
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
?>
<div class="span3 margin_zero float_l">
						<div class="sidebar_profic_pic">
							<?php
							if(file_exists(getcwd().'/uploads/user_pic/'.$profile_pic['user_pic_path']) && $profile_pic['user_pic_path']!='')
							{
								echo "<img style='max-height:210px;' src='".base_url()."uploads/user_pic/".$profile_pic['user_pic_path']."'/>";
							}
							else if(file_exists(getcwd().'/uploads/user_pic/thumbs/'.$profile_pic['user_thumb_pic_path']) && $profile_pic['user_thumb_pic_path']!='' )
							{
							//echo $image_thumb = $profile_pic['user_pic_path'].'_thumb';
							
								echo "<img style='max-height:210px;' src='".base_url()."uploads/user_pic/thumbs/".$profile_pic['user_thumb_pic_path']."'/>";
							}
							
							else if($user)
							{
							?>
								<img style='max-height:210px;' src="https://graph.facebook.com/<?php echo $user; ?>/picture?type=large">
							<?php
							}
							else{
							echo "<img style='max-height:210px;' src='".base_url()."images/profile_icon.png'/>";
							}
							?>
								<!--<src="<?php echo "$base$img_path";  ?>profile_pic.png">-->
								<h3 class="text_align"><a href="<?php echo $base; ?>home"><?php echo $query['fullname']; ?></a></h3>
								<div>
									<div class="margin_all">
									<?php
										$dob = $profile_pic['dob'];
										$dob_explode = explode("-",$dob);
									?>
										<h4><?php 
									if($dob_explode[2] == 00 || $dob_explode[2] == '')
									{ echo '';} else {
									echo $dob_explode[2].'&nbsp;';
									}
										 if($dob_explode[1] ==00) { echo '';} 
										 else if($dob_explode[1] ==01) { echo 'Jan';} 
										 else if($dob_explode[1] ==02) { echo 'Feb';} 
										 else if($dob_explode[1] ==03) { echo 'March';} 
										 else if($dob_explode[1] ==04) { echo 'April';} 
										 else if($dob_explode[1] ==05) { echo 'May';} 
										 else if($dob_explode[1] ==06) { echo 'June';} 
										 else if($dob_explode[1] ==07) { echo 'July';} 
										 else if($dob_explode[1] ==08) { echo 'Aug';} 
										 else if($dob_explode[1] ==09) { echo 'Sept';} 
										 else if($dob_explode[1] ==10) { echo 'Oct';} 
										 else if($dob_explode[1] ==11) { echo 'Nov';} 
										 else if($dob_explode[1] ==12) { echo 'Dec';} ?>
									<?php
									if($dob_explode[0] == 0000 || $dob_explode[0] == '')
									{ echo ''; } else {
									echo $dob_explode[0].',';
									}
									if($profile_pic['gender'] != '') { echo ucwords($profile_pic['gender']); } else { echo " "; }
									?> </h4>
										
									</div>
								</div>
								<div class="part_second" style="">
									<div class="index_sidebar_body">
										<h4 class="font_sidebar">Your Profile Completes <?php echo $pro_complete; ?>%</h4>
										<div class="progress_outline progress_out">
											<div class="progress progress_bar">
												<div class="bar margin_zero" style="width: <?php echo $pro_complete; ?>%;">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="part_second">
								<div class="index_sidebar_box">
									<div class="index_sidebar_header font_sidebar">
										My Colleges
									</div>
									<div class="index_sidebar_body">
									<ul class="links">
									<?php if(!empty($my_collage_of_user))
									{
										foreach($my_collage_of_user as $my_collage)
										{
									$univ_link=$this->subdomain->generate_univ_link_by_subdomain($my_collage['subdomain_name']);
									?>
										<li><a href="<?php echo $univ_link; ?>" target="_blank" title="<?php echo $my_collage['univ_name']; ?>"><?php echo $my_collage['univ_name']; ?></a></li>
									<?php }
											}
									else { ?><li>No Activity Yet</li><?php } ?>	
									
									</ul>
									<div class="clearfix"></div>
									</div>
								</div>
							</div>
							<div class="part_second">
								<div class="index_sidebar_box">
									<div class="index_sidebar_header font_sidebar">
										Messages
									</div>
									<div class="index_sidebar_content">
										<ul class="links1">
           <li><a href="<?php echo "$base"; ?>compose_email">Composer</a></li>
           <li><div><div class="float_l"><a href="<?php echo "$base"; ?>inbox">Inbox </a></div><div class="float_r"><?php if($count_inbox) { ?><span class="badge badge-warning"><?php echo $count_inbox ? $count_inbox : ''; ?></span><?php } ?></div><div class="clearfix"></div></div></li><!--29-->
           <li><div><div class="float_l"><a href="<?php echo "$base"; ?>outbox">Outbox </a></div><div class="clearfix"></div></div></li><!--29-->
          </ul>
		  <div class="clearfix"></div>
									</div>
								</div>
							</div>
							<div class="part_second">
								<div class="index_sidebar_box">
									<div class="index_sidebar_header font_sidebar">
										Account Settings
									</div>
									<div class="index_sidebar_content">
										<ul class="links1">
											<li><a href="<?php echo "$base" ?>update_profile">Update profile</a></li>
											<?php if(!$user) { ?>
											<li><a href="<?php echo "$base" ?>update_password">Change password</a></li>
											<?php } ?>
											
										</ul>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
					</div>