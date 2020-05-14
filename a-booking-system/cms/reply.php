<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemReply {
  
    function __construct(){
    }
    
    /*
     *  Get own replies
     */ 
    function own($ticket_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $value = '';
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row('SELECT replies FROM '.$absdashboardDB->absd_table->tickets.' where tid = '.$ticket_id);
            $replies = json_decode($row->replies);
            
            return $replies;
        }
    }
  
    function save_data($reply){
      global $absdashboardclasses;
      $reply = json_decode($reply);
      
      // Save reply
      $this->add($reply->content,
                 $reply->id,
                 $reply->uid,
                 $reply->tid,
                 $reply->type,
                 $reply->username,
                 $reply->created,
                 '0000-00-00 00:00:00',
                 'true');
    }
    
    /*
     *  Add reply
     */ 
    function add($content,
                 $id = 0,
                 $user_id = 0,
                 $tid = 0,
                 $type = 'public',
                 $username = '',
                 $created = '0000-00-00 00:00:00',
                 $update_time = '0000-00-00 00:00:00',
                 $answered = 'false',
                 $update = 'false') {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $update_time = date('Y-m-d H:i:s');
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row('SELECT replies FROM '.$absdashboardDB->absd_table->tickets.' where tid = '.$tid.' AND user_id = '.$user_id);
          	
            $replies = json_decode($row->replies);
            
						$new_reply = new stdClass;
						$new_reply->id = $id;
						$new_reply->tid = $tid;
						$new_reply->uid = $user_id;
						$new_reply->username = $username;
						$new_reply->content = $content;
						$new_reply->type = $type;
						$new_reply->created = $created;
						$reply_founded = false;

						foreach($replies as $key => $reply) {

							if($replies[$key]->id == $new_reply->id) {
									$reply_founded = true;
									$replies[$key] = $new_reply;
							}
						}

						if(!$reply_founded) {
							array_push($replies, $new_reply);
						}

						$ticket_update_data = array('replies' => json_encode($replies));
						$ticket_update_data['last_reply_user'] = $username;
						$ticket_update_data['answered'] = $answered;

						$absdashboardDB->update($absdashboardDB->absd_table->tickets, 
													 $ticket_update_data,
													 array('tid' => $tid,
																 'user_id' => $user_id)
						);

						if($update == 'false') {
							// Save update date
							$absdashboardclasses->updates->add('ticket_update_'.$tid, 
																				'',
																				$user_id,
																				$update_time);
						}
        }
    }
    
    /*
     *  Delete reply
     */ 
    function delete($id = 0,
                    $tid = 0,
                    $user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          $row = $absdashboardDB->get_row('SELECT replies FROM '.$absdashboardDB->absd_table->tickets.' where tid = '.$tid);
          
            
          if($replies != '[]') {
            $replies = json_decode($row->replies);
            
            if(count($replies) > 0) {
              
              foreach($replies as $key => $reply) {
                  
                if($replies[$key]->id == $id) {
                    unset($replies[$key]);
                }
              }
              
              $ticket_update_data = array('replies' => json_encode($replies));
              
              if(count($replies) > 1) {
                  $ticket_update_data['last_reply_user'] = $replies[count($replies[-1])]->username;
                  $last_reply_user_type = $absdashboardclasses->option->get('account_type', $replies[count($replies[-1])]->uid);
                
                  if($last_reply_user_type == 'support') {
                      $ticket_update_data['answered'] = 'true';
                  } else {
                      $ticket_update_data['answered'] = 'false';
                  }
              } else {
                  $ticket_update_data['last_reply_user'] = '';
                  $ticket_update_data['answered'] = 'false';
              }
  
              // Update last reply user & answered & replies
              $absdashboardDB->update($absdashboardDB->absd_table->tickets, 
                             $ticket_update_data,
                             array('tid' => $tid,
                                   'user_id' => $user_id)
              );
            }
          }
        }
    }
}