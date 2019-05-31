<!-- app/View/Users/add.ctp -->
<div class="users form">
	<?php 
		echo $this->Html->link( "Return to Dashboard",   array('action'=>'index') ); 
		$image = !empty($this->request->data['User']['image']) ? $this->Html->image($this->request->data['User']['image'], array('alt' => 'Profile Photo', 'class' => 'thumb')) : '';
	?>
	<br>
	<br>
	<?php echo $this->Form->create('User', array('type' => 'file')); ?>
	    <fieldset>
	        <legend><?php echo __('Edit User'); ?></legend>
	        <div class="default-photo">
				<output id="list">
					<?php echo $image; ?>
				</output>
				<?php echo $this->Form->input('image', array('type' => 'file', 'id' => 'files', 'label' => '', 'required' => false)); ?>
	        </div>
	        <?php 
				echo $this->Form->input('name');
				echo $this->Form->input('birthdate', array('type' => 'text', 'id' => 'datepicker'));
				echo $this->Form->radio('gender', array(
				        '1' => 'Male',
				        '2' => 'Female',
				    ), 
				    array(
				        'legend' => 'Gender'   
				    )
				);

				echo $this->Form->input('email');
		        echo $this->Form->input('password_update', array( 'label' => 'New Password (leave empty if you do not want to change)', 'maxLength' => 255, 'type'=>'password','required' => 0));
				echo $this->Form->input('password_confirm_update', array('label' => 'Confirm New Password *', 'maxLength' => 255, 'title' => 'Confirm New password', 'type'=>'password','required' => 0));

				echo $this->Form->input('hubby', array('type' => 'textarea'));
				echo $this->Form->submit('Update', array('class' => 'form-submit',  'title' => 'Click here to add the user') ); 
			?>
	    </fieldset>
	<?php echo $this->Form->end(); ?>

</div>

