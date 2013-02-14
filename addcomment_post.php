<?php
define('DL_BASESCRIPT',substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/')));
require_once(DL_BASESCRIPT . '/lib/lib.php');

$entity_id = intval($_REQUEST['eid']);
$body = pg_escape_string($_REQUEST['body']);
$user_id = $_SESSION['democracylab_user_id'];

pg_query($dbconn, "INSERT INTO democracylab_conversations (time,user_id,entity_id,type,body) 
					VALUES (NOW()," . $user_id . "," . $entity_id . ",0,'$body')");

header("Location: " . dl_facebook_redirect_url($_REQUEST['r']) );
?>