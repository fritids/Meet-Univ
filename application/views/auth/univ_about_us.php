<div class="row" style="margin-top:-25px">
				<div class="float_l span13 margin_l">
					<div class="margin_t">
						<?php
							$univ_alumni=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'alumini-detail','','');
							$univ_faculties=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'faculties-detail','','');
							$univ_slife=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'studentlife-detail','','');
							$univ_interstudents=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'internationalstudent-detail','','');
							$univ_expertise=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'expertise-detail','','');
							$univ_departments=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'departments-detail','','');
//foreach($university_details as $univ_detail)
//{
	/*echo "<h3>University title</h3>----".$university_details['title'].'</br>';
	echo "<h3>University keyword</h3>----".$university_details['keyword'].'</br>';
	echo "<h3>University description</h3>----".$university_details['description'].'</br>';
	echo "<h3>University latitude</h3>----".$university_details['latitude'].'</br>';
	echo "<h3>University longitude</h3>----".$university_details['longitude'].'</br>';
	echo "<h3>University univ_logo_path</h3>----".$university_details['univ_logo_path'].'</br>';
	echo "<h3>University address_line1</h3>----".$university_details['address_line1'].'</br>';
	echo "<h3>University address_line2</h3>----".$university_details['address_line2'].'</br>';
	echo "<h3>University user_id</h3>----".$university_details['user_id'].'</br>';
	echo "<h3>University city_id</h3>----".$university_details['city_id'].'</br>';
	echo "<h3>University state_id</h3>----".$university_details['state_id'].'</br>';
	echo "<h3>University country_id</h3>----".$university_details['country_id'].'</br>';
	echo "<h3>University phone_no</h3>----".$university_details['phone_no'].'</br>';
	echo "<h3>University switch_off_univ</h3>----".$university_details['switch_off_univ'].'</br>';
	echo "<h3>University univ_is_client</h3>----".$university_details['univ_is_client'].'</br>';
	echo "<h3>University univ_ranking</h3>----".$university_details['univ_ranking'].'</br>';
	echo "<h3>University subdomain_name</h3>----".$university_details['subdomain_name'].'</br>';
	echo "<h3>University univ_ranking</h3>----".$university_details['univ_ranking'].'</br>';
	echo "<h3>University about_us</h3>----".$university_details['about_us'].'</br>';
	echo "<h3>University contact_us</h3>----".$university_details['contact_us'].'</br>';
	echo "<h3>University createdon</h3>----".$university_details['createdon'].'</br>';
	echo "<h3>University createdby</h3>----".$university_details['createdby'].'</br>';
	echo "<h3>University univ_fax</h3>----".$university_details['univ_fax'].'</br>';
	echo "<h3>University univ_email</h3>----".$university_details['univ_email'].'</br>';
	echo "<h3>University univ_web</h3>----".$university_details['univ_web'].'</br>';
	echo "<h3>University featured_college</h3>----".$university_details['featured_college'].'</br>';
	echo "<h3>University salient_features</h3>----".$university_details['salient_features'].'</br>';*/
	?>
	<?php
	
	
	/* $univ_overview_link=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'about','','');
	$univ_overview_link=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'about','','');
	$univ_overview_link=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'about','','');
	$univ_overview_link=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'about','','');
	$univ_overview_link=$this->subdomain->genereate_the_subdomain_link($university_details['subdomain_name'],'about','',''); */
	?>
	
	<div>
	<?php if($university_details['univ_overview'] != '') { ?>
		<div class="float_l span8 margin_zero about_depend">
		<?php
		echo "<h3>Overview University</h3><div class='course_cont'>".$university_details['univ_overview']."</div>";?>
		
		</div>
		<?php } ?>
		<div class="float_l">
		<?php if($university_details['univ_overview'] == "" && $university_details['univ_campus'] == ""
		&& $university_details['univ_departments'] == "" && $university_details['univ_expertise'] == ""
		&& $university_details['univ_interstudents'] == "" && $university_details['univ_slife'] == ""
		&& $university_details['univ_faculties'] == "" && $university_details['univ_alumni'] == "") { 
		echo "<h2>";
		echo "We are gathering information about the ".$university_details['univ_name'].". Please visit back soon...";
		echo "</h2>";
	} ?>
		</div>
		<div class="float_r span5">
	<?php if($university_details['univ_insights']!='') { ?>	
			<div class="about_round">
			<?php
			
				echo "<h3>University Insights:</h3><div class='course_cont'>".$university_details['univ_insights']."</div>";?>
			</div>
		</div>
	<?php } ?>	
		<div class="clearfix"></div>
	</div>
	<div class="margin_t">
	
	<?php
	if($university_details['univ_departments']!='' || $university_details['univ_expertise']!='' || $university_details['univ_interstudents']!='' || $university_details['univ_slife']!='' || $university_details['univ_faculties']!='' || $university_details['univ_alumni']!=''){
	echo "<h3>University Campus Overview</h3><div class='course_cont'>".$university_details['univ_campus']."</div>"; } 
	
	?>
	</div>
	<div class="span13 margin_delta margin_b">
	<?php if($university_details['univ_departments'] != '') { ?>
		<div class="float_l grid_2 margin_delta margin_t left_about">
			<?php echo "<div class='about_fix'><h3>University Departments</h3>".$university_details['univ_departments']."</div>";
			if(strlen($university_details['univ_departments']) > 250) { 
		?>
		<a href="<?php echo $univ_departments; ?>" class="float_r ">View more&raquo;</a>
		<?php
		}
		
		?>
		</div>
	<?php } ?>
	<?php if($university_details['univ_expertise'] != '') { ?>
		<div class="float_l grid_2 margin_delta margin_t left_about">
			<?php
			echo "<div class='about_fix'><h3>University Research Expertise</h3>".$university_details['univ_expertise']."</div>";
			if(strlen($university_details['univ_expertise']) > 250) { 
		?>
		<a href="<?php echo $univ_expertise; ?>" class="float_r ">View more&raquo;</a>
		<?php
		}
		
		?>
		</div>
	<?php } ?>
	<?php if($university_details['univ_interstudents'] != '') { ?>
		<div class="float_l grid_2 margin_delta margin_t left_about">
		<?php echo "<div class='about_fix'><h3>International Students</h3>".$university_details['univ_interstudents']."</div>";
		if(strlen($university_details['univ_interstudents']) > 250) { 
		?>
		<a href="<?php echo $univ_interstudents; ?>" class="float_r ">View more&raquo;</a>
		<?php
		}
		
		?>
		</div>
	<?php } ?>
	<?php if($university_details['univ_slife'] != '') { ?>
		<div class="margin_t float_l grid_2 margin_delta left_about">
		<?php 
			echo "<div class='about_fix'><h3>University Student Life</h3>".$university_details['univ_slife']."</div>";
			if(strlen($university_details['univ_slife']) > 250) { 
		?>
		<a href="<?php echo $univ_slife; ?>" class="float_r ">View more&raquo;</a>
		<?php
		}
		
		?>
		</div>
	<?php } ?>
	<?php if($university_details['univ_faculties'] != '') { ?>
		<div class="margin_t float_l grid_2 margin_delta left_about">
		<?php
		echo "<div class='about_fix'><h3>University Faculties</h3>".$university_details['univ_faculties']."</div>";
		if(strlen($university_details['univ_faculties']) > 250) { 
		?>
		<a href="<?php echo $univ_faculties; ?>" class="float_r ">View more&raquo;</a>
		<?php
		}
		
		?>
		</div>
	<?php } ?>
	<?php if($university_details['univ_alumni'] != '') { ?>
		<div class="float_l grid_2 margin_delta margin_t left_about">
		<?php echo "<div class='about_fix'><h3>University Awarded Alumni</h3>".$university_details['univ_alumni']."</div>";
		
		if(strlen($university_details['univ_alumni']) > 250) { 
		?>
		<a href="<?php echo $univ_alumni; ?>" class="float_r ">View more&raquo;</a>
		<?php
		}
		
		?>
		</div>
	<?php } ?>
		<div class="clearfix"></div>
	</div>
	<?php
	
	
	
	//echo "<h3>University Facilities & Services / Accommodation</h3><div class='course_cont'>".$university_details['univ_services']."I tried viewing the demo using ietester for 5.5, 6, and 7. Doesn’t seem to be working. Is the demo set to work in IE?I tried viewing the demo using ietester for 5.5, 6, and 7. Doesn’t seem to be working. Is the demo set to work in IE?I tried viewing the demo using ietester for 5.5, 6, and 7. </div>";
	
//}
?>
					</div>
				</div>
				
				
<div class="float_r span3" style="margin-top: -5px;">
					<img src="<?php echo $base; ?>images/banner_img.png">
				</div>
				<div class="clearfix"></div>
</div>








