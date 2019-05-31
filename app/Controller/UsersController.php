<?php

class UsersController extends AppController {

	public $paginate = array(
        'limit' => 25,
        'conditions' => array(),
    	'order' => array('User.name' => 'asc' ) 
    );

    public $components = array('Flash');
	
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','add','thanks'); 
    }
	
    public function index( $id = null ) {
    	$self = false;
    	if($id == null){
    		$id = $this->Auth->user('id');
    		$self = true;
    	}else{
    		if($this->Auth->user('id') == $id)
    			$self = true;
    	}

		$res = $this->User->findById($id);
		$res['self'] = $self;

		$this->set('profile',$res);
    }
    
	public function login() {
		//if already logged-in, redirect
		if($this->Session->check('Auth.User')){
			$this->redirect(array('action' => 'index'));		
		}
		
		// if we get the post information, try to authenticate
		if ($this->request->is('post')) {

			if ($this->Auth->login()) {
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_login_time', date('Y-m-d H:i:s'));
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash(__('Invalid email or password'));
			}
		} 
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

    public function add() {
        if ($this->request->is('post')) {
			$this->User->create();
			$this->request->data['User']['created_ip'] = $this->request->ClientIp();
			$this->request->data['User']['modified_ip'] = $this->request->ClientIp();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been created'));
				$this->redirect(array('action' => 'thanks'));
			} else {
				$this->Session->setFlash(__('The user could not be created. Please, try again.'));
			}	
        }
    }

    public function edit($id = null) {
		$this->User->id = $this->Auth->user('id');
		$user = $this->User->findById($this->Auth->user('id'));
		if (!$this->request->data) {
			$this->request->data = $user;
			$this->request->data['User']['birthdate'] = date('m/d/Y', strtotime($this->request->data['User']['birthdate']));
		}
		$this->set('profile',$user);

		if ($this->request->is('post') || $this->request->is('put')) {
			if(isset($this->data['User']['image'])){
			  $filename = '';
			     $uploadData = $this->data['User']['image'];
			     if ( $uploadData['size'] == 0 || $uploadData['error'] !== 0) {
			     	unset($this->request->data['User']['image']);
			     }else{
				     $filename = basename($uploadData['name']);
				     $uploadFolder = WWW_ROOT. 'img';  
				     $filename = time() .'_'. $filename; 
				     $uploadPath =  $uploadFolder . DS . $filename;
				     if( !file_exists($uploadFolder) ){
				       mkdir($uploadFolder); 
				     }
				     $this->request->data['User']['image'] = $filename;	
			     }
			}

		    $this->request->data['User']['birthdate'] = date('Y-m-d H:i:s', strtotime($this->request->data['User']['birthdate']));
		   

		    if(empty($this->request->data['User']['password_update'])){
		    	unset($this->User->validate["password_update"]);
		    	unset($this->User->validate["password_confirm_update"]);
		    }
		   
	     	if ($this->User->save($this->request->data)) {
	     		if(isset($this->data['User']['image'])){
	     			if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {

	     				$res = $this->User->findById($this->Auth->user('id'));
						$this->set('profile',$res);
		       			$this->Session->setFlash(__('Cannot save image'));
		     		}
	     		}
	     		$this->Session->setFlash(__('Successfully updated.'));
	     		$this->redirect(array('action' => 'index'));
		     	
		 	}else{
		 		$this->Session->setFlash(__('Cannot save data.'));
		 	}
		}
    }

    public function delete($id = null) {
		
		if (!$id) {
			$this->Session->setFlash('Please provide a user id');
			$this->redirect(array('action'=>'index'));
		}
		
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided');
			$this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField()) { //here
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }        
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
	
	public function activate($id = null) {		
		if (!$id) {
			$this->Session->setFlash('Please provide a user id');
			$this->redirect(array('action'=>'index'));
		}
		
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided');
			$this->redirect(array('action'=>'index'));
        }

        if ($this->User->saveField()) { //'status', 1
            $this->Session->setFlash(__('User re-activated'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Session->setFlash(__('User was not re-activated'));
        $this->redirect(array('action' => 'index'));
    }

    public function thanks(){
    }        
  
}

?>