<h1>Registration Form</h1>
<?php 
	echo $this->Form->create('User');
    echo $this->Form->input('name');
    echo $this->Form->input('email');
    echo $this->Form->input('password', array('type'=>'password'));
    echo $this->Form->input('confirm_password', array('type'=>'password'));
	echo $this->Form->end('Submit');
?>