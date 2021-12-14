<?php
require_once "credentials.php";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS users (
  account_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  email VARCHAR(50) NOT NULL UNIQUE,
  user_password VARCHAR(50) NOT NULL,
  reg_date TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table Users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS forum_thread (
    thread_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    thread_subject VARCHAR(30) NOT NULL,
    account_id INT(6) UNSIGNED NOT NULL,
    creation_date TIMESTAMP,
    CONSTRAINT FK_forum_thread FOREIGN KEY (`account_id`) 
    REFERENCES `users` (`account_id`)
  )";
  
  if (mysqli_query($conn, $sql)) {
      echo "Table forum_thread created successfully";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
  }

  $sql = "CREATE TABLE IF NOT EXISTS post (
    post_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content VARCHAR(1000) NOT NULL,
    account_id INT(6) UNSIGNED NOT NULL,
    thread_id INT(6) UNSIGNED NOT NULL,
    creation_date TIMESTAMP,
    CONSTRAINT FK_account_id FOREIGN KEY (`account_id`)
    REFERENCES `users` (`account_id`),
    CONSTRAINT FK_thread_id FOREIGN KEY (`thread_id`)
    REFERENCES `forum_thread` (`thread_id`)
    
  )";
  
  if (mysqli_query($conn, $sql)) {
      echo "Table post created successfully";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
  }

mysqli_close($conn);
?>
