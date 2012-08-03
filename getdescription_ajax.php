<?php
define('DL_BASESCRIPT',substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/')));
require_once(DL_BASESCRIPT . '/lib/lib.php');

$ids = explode(',',$_REQUEST['entityid']);
$entityids = array();
foreach($ids as $id) {
	$entityids[] = intval($id);
}

$rtrn = array();
$result = pg_query("SELECT entity_id, title, description FROM democracylab_entities WHERE entity_id IN (" . implode(',',$entityids) . ")");
while($row = pg_fetch_object($result)) {
	if($row->description) {
		ob_start();
		?><b><?= $row->title ?>:</b> <?= $row->description ?><?php
		$rtrn[$row->entity_id] = ob_get_contents();
		ob_end_clean();
	} else {
		ob_start();
		?><b><?= $row->title ?>:</b> <span class="instructions">(no description)</span><?php	
		$rtrn[$row->entity_id] = ob_get_contents();
		ob_end_clean();
	}
}
echo json_encode($rtrn);
?>