<?php
$fetch_country = array();
$fetch_area_interest = array();
$fetch_country = $this->frontmodel->fetch_country_having_univ_footer();
$fetch_area_interest = $this->frontmodel->fetch_area_interest_having_univ_footer();
?>
<footer>
		<div class="container">
			<div class="margin">
				<div>
					<div class="footer margin_delta">
						<h4 class="white">Colleges</h4>
						<ul style="margin-left:-1px;">
						<?php
						if(!empty($fetch_area_interest))
						{
						foreach($fetch_area_interest as $interest)
						{
						?>
							<li><a href="<?php echo $base; ?>/colleges/<?php echo str_replace(' ','_',$interest['program_parent_name']); ?>"><?php echo $interest['program_parent_name'];  ?></a></li>
						<?php } } ?>
						</ul>
					</div>
					<div class="footer">
						<h4 class="white">Destinations</h4>
						<ul>
						<?php
						if(!empty($fetch_country))
						{
						foreach($fetch_country as $country)
						{
						?>
							<li><a href="<?php echo "$base"; ?>colleges/<?php echo $country['country_name']; ?>"><?php echo $country['country_name']; ?></a></li>
						<?php } } ?>
						<!--<li style="margin-left: -26px;"><a href="#"> >>>More Countries<<< </a></li>-->
						</ul>
					</div>
					<div class="footer">
						<h4 class="white">View Our</h4>
						<ul>
							<li><a href="<?php echo $base; ?>about_us">About us</a></li>
							<li><a href="<?php echo $base; ?>contact_us">Contact us</a></li>
							<li><a href="<?php echo $base; ?>colleges">Colleges</a></li>
							<li><a href="<?php echo $base; ?>QuestandAns">Questions & Answers</a></li>
							<li><a href="">Service Agreement</a></li>
						</ul>
						<!--<h4 class="white">Follow us</h4>
							<div>
								<img src="images/face.png" />
								<img src="images/in.png" />
								<img src="images/twitter.png" />
						</div>-->
					</div>
					<div class="footer margin_beta">
						<h4 class="white">Reach Us</h4>
						<div>
								<a href="mailto:contact@meetuniversities.com" class="white">contact@meetuniversities.com</a>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="span4">
							&copy; 2011 - 2012 Meet Universities
						</div>
						<div class="span5 offset5 text-right">
							Powered by Global Campus Media.
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
<div class="body_footer"></div>
<script type="text/javascript" src="<?php echo "$base$js";?>/bootstrap-collapse.js"></script>
<script type="text/javascript" src="<?php echo "$base$js";?>/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="<?php echo "$base$js";?>/bootstrap-modal.js"></script>
<script type="text/javascript" src="<?php echo "$base$js";?>/pic_upload_js.js"></script>
<script type="text/javascript" src="<?php echo "$base$js";?>/bootstrap-button.js"></script>

<script type="text/javascript" src="<?php echo "$base$js";?>/slides.min.jquery.js"></script>
<script type="text/javascript" src="<?php echo "$base$js";?>/jquery.timeago.js"></script>
<script type="text/javascript" src="<?php echo "$base$js";?>/thingerly-calendar.js"></script>
<script type="text/javascript" src="<?php echo "$base$js";?>/jquery.mtz.monthpicker.js"></script>	
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32165390-1']);
  _gaq.push(['_setDomainName', 'meetuniversities.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>