<?php

include_once("config.php");
include_once("functions.php");

session_start();

$user_id=$_SESSION['user_id'];

if(isset($_POST['action'])) {

  $post_id = $_POST['post_id'];
  $action = $_POST['action'];
  switch ($action) {
  	case 'like':
      $vote_action='like';

      insert_vote($user_id,$post_id,$vote_action,$dbConn);
      break;
  	case 'dislike':
      $vote_action='dislike';
      insert_vote($user_id,$post_id,$vote_action,$dbConn);
      break;
  	case 'unlike':
      delete_vote($user_id,$post_id,$dbConn);

	    break;
  	case 'undislike':
      delete_vote($user_id,$post_id,$dbConn);
      break;
    default:

  }
  // execute query to effect changes in the database ...
  echo getRating($post_id,$dbConn);
  exit(0);

}


