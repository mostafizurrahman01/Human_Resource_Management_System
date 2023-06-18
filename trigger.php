<?php
session_start();

$conn = oci_connect('scott2', '123', '//localhost/XE');

if (!$conn) {
    echo 'Failed to connect to Oracle' . "<br>";
}

//Trigger to update the user's email in the users_info table when the user's email is updated in the users table:
//ALTER TRIGGER SCOTT2.UPDATE_USER_INFO_EMAIL COMPILE;
$sql1 = "CREATE OR REPLACE TRIGGER update_user_info_email
AFTER UPDATE OF email ON users
FOR EACH ROW
BEGIN
  UPDATE users_info
  SET email = :new.email
  WHERE user_id = :new.user_id;
END";
 
//Trigger to automatically set a user's status to 'active' when they are added to the database: 
$sql2 = "CREATE OR REPLACE TRIGGER set_user_active
AFTER INSERT ON users
FOR EACH ROW
BEGIN
  INSERT INTO users_info (user_id, full_name, address, email, phone_number)
  VALUES (:new.user_id, :new.name, NULL, :new.email, NULL);
END";

//Trigger to update the user's name in the users table when the user's name is updated in the users_info table:
$sql3 = "CREATE OR REPLACE TRIGGER update_user_name
AFTER UPDATE OF full_name ON users_info
FOR EACH ROW
BEGIN
  UPDATE users
  SET name = :new.full_name
  WHERE user_id = :new.user_id;
END";

// Trigger to prevent the deletion of a user if they have associated data in the users_info table:
$sql4 = "CREATE OR REPLACE TRIGGER prevent_user_deletion
BEFORE DELETE ON users
FOR EACH ROW
DECLARE
  info_count INTEGER;
BEGIN
  SELECT COUNT(*) INTO info_count FROM users_info WHERE user_id = :old.user_id;
  IF info_count > 0 THEN
    RAISE_APPLICATION_ERROR(-20001, 'This user has associated data and cannot be deleted.');
  END IF;
END";

//Trigger to delete user from both tables:
$sql5 = "CREATE OR REPLACE TRIGGER delete_user_trigger
BEFORE DELETE ON users
FOR EACH ROW
BEGIN
  DELETE FROM users_info WHERE user_id = :old.user_id;
END";


?>