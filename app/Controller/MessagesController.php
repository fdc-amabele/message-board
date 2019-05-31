<?php

class MessagesController extends AppController {

	public $uses = array('User', 'Message');

	public $paginate = array(
        'limit' => 2,
        'conditions' => array(),
    	'order' => array('Message.created' => 'asc' ) 
    );

    public $components = array('Flash');
		
    public function index() {
        $data['id'] = $this->Auth->user('id');
        $limit = 2;
        $currpage = 1;
        $search = '';
        $this->set('limit',$limit);  

        //search
        if(!empty($this->request->data['search'])){
             $search = $this->request->data['search'];            
        }        

        if(!empty($this->request->data['currpage'])){
             $currpage = $this->request->data['currpage'];            
        }

        $results = $this->Message->get_messages($limit,$currpage,$search);
        // print_r($results);
        $this->set('messages', $results['results']); 
        $data['messages'] = $results['results'];
        $data['totalrows'] = $results['totalrows'];
        $data['next'] = true;
        if ($this->request->is('ajax')) {
            echo json_encode($data);
            exit;
        } 
    }  

    public function add() {
        if ($this->request->is('post')) {
            $this->Message->create();
            $this->request->data['Message']['from_id'] = $this->Auth->user('id');
            if ($this->Message->save($this->request->data)) {

                // if(isset($this->request->data['type']) && $this->request->data['type'] == 'reply'){
                if ($this->request->is('ajax')) {
                    echo json_encode('success');
                    exit;
                }
                $this->Flash->success(__('Your message has been sent.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to send message.'));
        }		
    }

    public function retrieve_users( $param = null ){
    	$this->layout = 'ajax';
    	if ($this->request->is('ajax')) {	
		$users = $this->User->find(
			'all',
			array(
				'conditions' => array(
					'User.id <>' => $this->Auth->user('id'),
					'OR' => array(
                        'User.name LIKE' => "%".$this->params['url']['term']."%",
                        'User.email LIKE' => "%".$this->params['url']['term']."%"
                    ), 
				)
			)
		);
            echo json_encode($users);
            exit;
    	}   		
    }

    public function delete() {
        $conditions = array(
            'OR' =>
                array(
                    array(
                        array('from_id' => $this->Auth->user('id')),
                        array('to_id' => $this->request->data['id'])
                    ),
                    array(
                        array('from_id' => $this->request->data['id']),
                        array('to_id' => $this->Auth->user('id'))
                    )
                )
        );     
        $result = $this->Message->deleteAll($conditions, false);
        if($result){
            echo json_encode('success');
            exit;
        }
        echo json_encode('error');
        exit;
    } 

    public function deleteDetail() {  
        $result = $this->Message->delete($this->request->data('id'));
        if($result){
            echo json_encode('success');
            exit;
        }
        echo json_encode('error');
        exit;
    } 

    public function details($id){
        $limit = 2;
        $currpage = 1;
        $search = '';
        $this->set('limit',$limit);        

        if(!empty($this->request->data['currpage'])){
             $currpage = $this->request->data['currpage'];            
        }        

        if(!empty($this->request->data['limit'])){
             $limit = $this->request->data['limit'];            
        }

        $results = $this->Message->get_message_details($limit,$currpage,$id);
        $data['messages'] = $results['results'];
        $data['totalrows'] = $results['totalrows'];
        $this->set('messages', $results['results']); 
        $data['next'] = true;
        if ($this->request->is('ajax')) {
            echo json_encode($data);
            exit;
        }           
    }   
}
