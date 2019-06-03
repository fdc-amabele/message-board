<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo 'Message Board' //$cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('bootstrap-4.3.1');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('select2.min');
		echo $this->Html->css('custom');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<?php echo $this->Html->script('jquery'); ?>
	<?php echo $this->Html->script('jquery-ui'); ?>
	<?php echo $this->Html->script('bootstrap-4.3.1'); ?>
	<?php echo $this->Html->script('select2.min'); ?>
	<?php echo $this->Html->script('events'); ?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1> MESSAGE BOARD<?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		 

		<div id="content">
			<?php
				if($this->Session->check('Auth.User')):
			?>
			<div class="message">Welcome <?php echo $this->Session->read('Auth.User.name'); ?>!
				| <?php echo $this->Html->link( "Profile",   array('controller'=>'users', 'action' => 'index') ); ?>
				| <?php echo $this->Html->link( "Messages",   array('controller'=>'messages', 'action' => 'index') ); ?>
				<span style="float: right;">
					<?php echo $this->Html->link( "Logout",   array( 'controller' => 'users', 'action'=>'logout')); ?>
				</span> 
			</div>
		<?php endif; ?>
		
		<br>

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php 
			echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php 
	$limit = isset($limit) ? $limit : '';
	echo $this->Form->input('limit', array('type' => 'hidden', 'value' => $limit));
	//echo $this->element('sql_dump'); ?>
</body>
</html>
