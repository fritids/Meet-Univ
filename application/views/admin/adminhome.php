
<script type="text/javascript" src="<?php echo $base;?>/js/jsapi.js"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['day', 'visitors','pageviews'],
		  <?php for($i = 0; $i < 30; $i++) { 
			$start_date=date('Y-m-d',strtotime($i.' day ago'));
				foreach($objResults[$start_date] as $objResult )
					{				   
					   $Visitors = $objResult->getVisitors( );
					   $intUniquePageViews = $objResult->getUniquePageViews( ); 
						echo "['".$start_date."',".$Visitors.",".$intUniquePageViews."]";	
						if($i!=29)
						{
						echo ',';
						}
						
					}
			} ?>	         
        ]);
        var options = {
          title: 'Users details'
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
</script>
	<div id="content">
		<div class="message info"><p>Welcome to the Meet universities Admin Panel</p></div> 		
		<h2>Statistics</h2>
		<div class="stats_charts" id="chart_div" style="width: 1200px; height: 300px;"></div>	
	
		<div class="registerd_event_admin">
		<center><h3>Latest Users</h3></center>
		</div>
		<?php //print_r($latest_users); 
		if($latest_users!=0){ ?>
		<table cellpadding="0" cellspacing="0" width="100%" class="sortable">
			
				<thead>
					<tr>
						<th>Sr No</th>
						<th>Username</th>
						<th>Email Id</th>
						<th>User Type</th>						
						<th>Created On</th>
					</tr>
				</thead>
				
				<tbody>
				<?php $i=1;
				foreach($latest_users as $latest_user) { ?>	
					<tr> 	
						<td><?php echo $i; $i++;  ?></td>
						<td><?php echo $latest_user['fullname']; ?></td>
						<td><?php echo $latest_user['email']; ?></td>
						<td><?php echo $latest_user['user_type']; ?></td>
						<td><?php $date=strtotime($latest_user['createdon']); echo date('d/M/Y h:m',$date); ?></td>
					</tr>	
				<?php } } ?>		
				
					
				</tbody>
				
			</table>
	
	
	<div class="chat chat_admin">
<div class="chat_messages">
				<h3>Question</h3>
		<ul>
				
		<?php if($ten_question!=0) {
		$x=0;
		foreach($ten_question as $ten_questions) {
		$x=$x+1;
		
		?>	
			
					<li>
						<span><abbr class="timeago time_ago" title="<?php echo $ten_questions['q_asked_time']; ?>"></abbr></span>
						<?php if($ten_questions['user_pic_path']!='') { ?>
					<a href="#" class="avatar"><img src="<?php echo $base.'uploads/'.$ten_questions['user_pic_path']; ?>" /> </a>
					<?php } else { ?>
					<a href="#" class="avatar"><img src="<?php echo $base ?>uploads/user_model.png" /> </a>					
					<?php } ?>						
						<a href="#" class="username"><?php echo $ten_questions['fullname']; ?></a>
						<p><?php echo $ten_questions['q_title']; ?></p>
						<p class="q_detail"><?php $ten_questions['q_detail']; ?></p>
					
					</li>
				
				
		<?php 
		} ?>		
		</ul>
						
		<?php } else { ?>
		NO Recent Question
		<?php } ?>	
		</div>
		</div>
		</div>

<script>
function answerthis(formid)
{
$('#answer_form_'+formid).toggle(500);
}
function submitanswer(qid)
{
var commentedtext=$('#answer_of_que_'+qid).val();
var commentd_on='qna';
var commented_on_id=qid;
if($('#answer_of_que_'+qid).val()!='')
{
	$.ajax({
	   type: "POST",
	   url: "<?php echo $base; ?>univ/post_comment",
	   async:false,
	   data: 'commented_text='+commentedtext+'&commentd_on='+commentd_on+'&commented_on_id='+commented_on_id,
	   cache: false,
	   success: function(msg)
	   {
		
		/*$(".event_border:last").after(msg);
		$('#commented_text').val('');
		$('#txt_cnt_comment_show').val(parseInt(span_comment)+1);*/
		$('.q_detail').html('<div class="answer_box">'+q_detail+'</div>');
		}
	   });
}
}
</script>	

</body>
</html>
