<div class="container">
	<h1>User Profile</h1>
	<?php
	if($profile):
		$gender = 'Not Specified';
		if($profile['User']['gender'] == 1){
			$gender = 'Male';
		}else if($profile['User']['gender'] == 2){
			$gender = 'Female';
		}

		$photo = $profile['User']['image'] ? $profile['User']['image'] : 'default-photo.png';
	?>
	<div class="row">
		<div class="col-md-3">
			<?php echo $this->Html->image($photo, array('alt' => 'Photo', 'class' => 'default-photo-size')); ?>
		</div>
		<div class="col-md-9">
			<label> <?php echo $profile['User']['name'] ?> </label>
			<?php 

			 ?>
			<label>Email: <?php echo $profile['User']['email']; ?> </label>
			<label>Gender: <?php echo $gender; ?> </label>
			<label>Birthdate: <?php echo $profile['User']['birthdate'] ? date("M d, Y", strtotime($profile['User']['birthdate'])) : 'Not Specified' ?> </label>
			<label>Joined: <?php echo date("M d, Y ga", strtotime($profile['User']['created'])) ?> </label>
			<label>Last Login: <?php echo date("M d, Y ga", strtotime($profile['User']['last_login_time'])); ?> </label>
			<label>Hubby: <?php echo $profile['User']['hubby']; ?> </label>
		</div>		
	</div>
	<br><br>
	<?php 
		if($profile['self']):
		echo $this->Html->link( "Edit Profile",   array('action'=>'edit') ); 
		endif; 
	else:
		echo "Cannot find user";
	endif;


	?>
	
</div>
