<div class="container message-list">
 <?php //echo $this->Html->link( "New Message",   array('action'=>'add'), array('class' => 'btn btn-primary float-right') );  ?>
	<h1>Message Details</h1>	
	<br>
	<?php echo $this->Form->create('Message'); ?>
	<div class="col-md-6 nopadding float-right">
		<?php 
			
			echo $this->Form->input('to_id', array('value' => $this->request->params['pass'][0] , 'type' => 'hidden')); 
			echo $this->Form->input('content', array('type' => 'textarea', 'label' => false, 'placeholder' => 'Message')); 
			echo $this->Form->input('reply message', array('type' => 'button', 'label' => false, 'class' => 'btn btn-sm btn-danger float-right')); 
			
			?>
	</div>
	<?php echo $this->Form->end();  ?>
	<div class="clearfix"></div>
	<br>
	<ul class="items nopadding">
	</ul>
	<br>
	<?php if($messages): ?>
	<div class="text-center show-section d-none">
		<?php echo $this->Html->link( "Show More", array('action' => ''), array('class' => 'show-more-details'));  ?>
	</div>
	<?php endif; ?>
	<?php 
		unset($message); 
		
	?>	
</div>
