<?php
include_once("config.php");
session_start();


$user_id=$_SESSION['user_id'];

function userLikesDislikes($post_id,$user_id,$rating_action,$dbConn)
{
        $sql="SELECT COUNT(*) FROM user_rating WHERE user_id=:user_id
        AND post_id=:post_id AND rating_action=:rating_action";
         $stmt = $dbConn->prepare($sql);
 $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->bindParam(':rating_action', $rating_action, PDO::PARAM_STR);
       $stmt->execute();
$count = $stmt->fetchColumn();
  if ($count > 0) {
    return true;
  }else{
    return false;
  }
}
function getLikesDislikes($post_id,$rating_action,$dbConn)
{
     $sql="SELECT COUNT(*) FROM user_rating WHERE post_id = :post_id AND rating_action=:rating_action";
          $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->bindParam(':rating_action', $rating_action, PDO::PARAM_STR);
 $stmt->execute();
        $number_of_rows = $stmt->fetchColumn(); 
        return $number_of_rows;  
}
function insert_vote($user_id,$post_id,$rating_action,$dbConn){
         $sql="INSERT INTO user_rating(user_id, post_id, rating_action) 
             VALUES (:user_id, :post_id, :rating_action) 
             ON DUPLICATE KEY UPDATE rating_action=:rating_action";
     $stmt = $dbConn->prepare($sql); 
       $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
       $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
       $stmt->bindParam(':rating_action', $rating_action, PDO::PARAM_STR);
    $stmt->execute();
      }
      function delete_vote($user_id,$post_id,$dbConn){
         $sql="DELETE FROM user_rating WHERE user_id=:user_id AND post_id=:post_id";
     $stmt = $dbConn->prepare($sql); 
       $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
       $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
      }
      function getRating($post_id,$dbConn)
{
  $rating = array();
     $likes=getLikesDislikes($post_id,'like',$dbConn);
     $dislikes=getLikesDislikes($post_id,'dislike',$dbConn);
  $rating = [
    'likes' => $likes,
    'dislikes' => $dislikes
  ];
  return json_encode($rating);
}
?> 