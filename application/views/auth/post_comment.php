<?php
 date_default_timezone_set('Asia/Kolkata');
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
<div class="event_border hover_delete_comment_<?php echo $delete_comment; ?>">
								<div class="float_l">
									<div class="comment_img">
									<?php
							$logged_user_id = $this->tank_auth->get_user_id();
							if(file_exists(getcwd().'/uploads/user_pic/thumbs/'.$user_detail['user_thumb_pic_path']) && $user_detail['user_thumb_pic_path']!='' )
							{
							//echo $image_thumb = $profile_pic['user_pic_path'].'_thumb';
							
								echo "<img src='".base_url()."uploads/user_pic/thumbs/".$user_detail['user_thumb_pic_path']."'/>";
							}
							else if(file_exists(getcwd().'/uploads/user_pic/'.$user_detail['user_pic_path']) && $user_detail['user_pic_path']!='')
							{
								echo "<img src='".base_url()."uploads/user_pic/".$user_detail['user_pic_path']."'/>";
							}
							else if($user && $user_detail['q_askedby'] == $logged_user_id)
							{
							?>
								<img src="https://graph.facebook.com/<?php echo $user; ?>/picture?type=small">
							<?php
							}
							else{
							echo "<img src='".base_url()."images/profile_icon.png'/>";
							}
							?>
									
									<h4 class="center"><a href="#">
									<?php echo $user_detail['fullname']; ?>
									</a></h4>
									</div>
									
								</div>
								<div>
				<!--<span class="float_r delete_comment" >
					<img style="cursor:pointer" class="del_icon" onclick='delete_this_comment("<?php //echo $delete_comment; ?>")' src="<?php //echo "$base$img_path";?>/close.jpg">
			</span>-->

									
									
									<?php echo $commented_text; ?>
									<br/>
									<div class="float_r">
										
									<abbr class="timeago time_ago" title="<?php echo date('Y-m-d H:i:s',time()) ?>"></abbr>
									</div>
								</div>
								<div class="clearfix"></div>
								
</div>
<script>
jQuery(document).ready(function() {
  jQuery("abbr.timeago").timeago();
});
</script>