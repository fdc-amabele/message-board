<?php
class Message extends AppModel {

	public $hasMany = array('User' => array('foreignKey' => 'id'));
	// public $belongsTo = array(
	//         'UserFrom' => array(
	//             'className'  => 'User',
	//             'foreignKey' => 'from_id'
	//         ),
	//         'UserTo' => array(
	//             'className'  => 'User',
	//             'foreignKey' => 'to_id'
	//         )
	//     );	

    public $validate = array(
        'to_id' => array(
            'rule' => 'notBlank'
        ),
        'content' => array(
            'rule' => 'notBlank'
        )
    );

    public function get_messages($limit, $page, $search = ''){
    	$id = AuthComponent::user('id');
    	$search_query = '';
    	if(!empty($search)){
    		$search_query = ' WHERE content like "%'.$search.'%" OR name like "%'.$search.'%"';
    	}

    	$offset = ($page - 1) * $limit;

    	$data['results'] = $this->query("
			SELECT messages.*, users.name, users.image FROM (
					SELECT (CASE WHEN to_id = $id THEN from_id 
							ELSE to_id 
							END
							) as id, 
							DATE_FORMAT(msgs.created, '%Y/%m/%d %H:%i') as msg_date, 
							content
					FROM messages msgs
					INNER JOIN (
					    SELECT (CASE WHEN to_id = $id 
					    			THEN from_id 
					    		ELSE to_id 
					    		END
					    		) as id, 
					    		max(created) as msg_date
					    FROM messages
					    WHERE to_id = $id OR 
					    	  from_id = $id
					    group by (CASE WHEN to_id = $id THEN from_id 
					    		  ELSE to_id 
					    		  END
					    		  )
					) tm on (CASE WHEN to_id = $id THEN from_id 
							 ELSE to_id 
							 END) = tm.id and msgs.created = tm.msg_date
				) as messages
				LEFT JOIN users on messages.id = users.id".$search_query."
				ORDER BY msg_date DESC
				LIMIT ".$offset.",".$limit."   												
    		");

 
    	$data['totalrows'] = $this ->query("
			SELECT count(*) as count
			FROM(
					SELECT DISTINCT (CASE WHEN to_id = $id THEN from_id 
									 ELSE to_id 
									 END) count 
					FROM messages
					WHERE (to_id = $id or from_id = $id) AND 
						  (content LIKE '%".$search."%')
				) as counttbl"
			); 
    	return $data;
    }    

    public function get_message_details($limit, $page, $id){
    	$sess_id = AuthComponent::user('id');
    	$search_query = '';
    	if(!empty($search)){
    		$search_query = ' WHERE content like "%'.$search.'%" OR name like "%'.$search.'%"';
    	}

    	$offset = ($page - 1) * $limit;

    	$data['results'] = $this->query("
							SELECT  messages.*, 
									DATE_FORMAT(messages.created, '%Y/%m/%d %H:%i') as msg_date,
									fromuser.id from_id, 
									fromuser.name from_name, 
									fromuser.image from_image, 
									touser.id to_id, 
									touser.name to_name, 
									touser.image to_image, 
									(CASE WHEN from_id = ".$sess_id." THEN '1' ELSE '0' END) owned
							FROM messages
							LEFT JOIN users fromuser on messages.to_id = fromuser.id
							LEFT JOIN users touser on messages.from_id = touser.id
							WHERE (to_id = ".$sess_id." AND from_id = ".$id.") OR (to_id = ".$id." AND from_id = ".$sess_id.")
							ORDER BY created DESC 			
							LIMIT ".$offset.",".$limit." 								
    					");    	

    	$data['totalrows'] = $this->query("
							SELECT  count(*) count
							FROM messages
							WHERE (to_id = ".$sess_id." and from_id = ".$id.") OR (to_id = ".$id." and from_id = ".$sess_id.")								
    					");

    	return $data;
    }
}