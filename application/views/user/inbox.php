
	<div class="container">
		<div class="body_bar"></div>
		<div class="body_header"></div>
		<div class="body_container">
			<div class="row">
				<div class="margin_zero span16">
					<!--<div data-alert="alert" class="alert alert-message message">
								<a data-dismiss="alert" class="close"></a>
								<div>
									<div class="float_l"><h2>Welcome! Let&#8217;s get started by</h2></div>
									<div class="float_r close_cont"> <span> Don't want our help? </span> Close Tips </div>
									<div class="clearfix"></div>
								</div>
								<nav id="help-tools">
									<ul>
										<li class="text_dec">1) Step 1</li>
										<li><a href="#">2) Step 2</a></li>
										<li><a href="#">3) Step 3</a></li>
										<li><a href="#">4) Step 4</a></li>
									</ul>
								</nav>
					</div>-->
					<?php $this->load->view('user/profile-sidebar.php'); ?>
					<div class="span13 float_r">
						<div class="span10 margin_zero float_l">
							<div class="inbox_box">
								<h2>Inbox</h2>
								<ul class="inbox_list">
								<form action="delete_message_inbox" method="post">
								<?php
								if(!empty($inbox_messages))
								{
								$checkbox_numbering = 0;
								foreach($inbox_messages as $messages)
								{
								if($messages['msg_read_status'] == '1')
								{
								$color_read_unread_msg = "background-color:white;border:1px solid whiteSmoke";
								}
								else{
								$color_read_unread_msg = "background-color:lightBlue";
								}
								?>
									<li style="<?php echo $color_read_unread_msg; ?>">
										<div class="span0 margin_zero">
											<input type="checkbox" name="msg[]" id="<?php echo $checkbox_numbering; ?>" value="<?php echo $messages['id'] ? $messages['id']: ''; ?>">
										</div>
										<a href="inbox/<?php echo $messages['id']; ?>">
										<div class="span2 margin_l">
											<span><?php echo $messages['subject']!='' ? $messages['subject'] : 'No Subject' ; ?></span>
										</div>
										<div class="span6 margin_l span6_modified">
											<div><?php echo $messages['body']!='' ? $messages['body'] : 'Empty Message' ; ?></div>
										</div>
										</a>
										<div class="span1 margin_l span1_modified">
											<?php echo $messages['ontime']!='' ? $messages['ontime'] : 'Time not Found' ; ?>
										</div>
										
										<div class="span0 margin_l">
											<a href="delete_message_inbox/<?php echo $messages['id']; ?>"><i class="icon-remove"></i></a>
										</div>
										<div class="clearfix"></div>
									</li>
								<?php $checkbox_numbering++; } } else { echo "Empty Message Inbox..."; } ?>
									
								</ul>
								<div class="float_r">
								
									<input type="submit" class="btn btn-success" name="del_multi_msg" value="Delete" />
								</form>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="span3 float_l">
							<img src="images/banner_img.png">
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	