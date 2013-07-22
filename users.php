<?php
define('DL_BASESCRIPT',substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/')));
require_once(DL_BASESCRIPT . '/lib/lib.php');

if($democracylab_user_role == 0) {
	header('Location: ' . dl_facebook_url('summary.php') );
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>DemocracyLab: Users</title>
	<link href="images/favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" href="stylesheets/screen.css" media="screen">
	<script src="js/jquery-1.7.2.js"></script>
</head>
<body>
<header class="clearfix">
	<div style="margin-left: -5px; background-image: url(images/vv.png); width: 293px; height: 102px; float: left; margin-right: 20px;"></div>
</header>

<script>
function change_admin(userid,node) {
	var x = node.value;
	var data = {};
	data['userid'] = userid;
	data['admin'] = x;
	$.ajax({
		url: '<?= dl_facebook_url('saveuseradmin_ajax.php') ?>',
		context: document.body,
		data: data,
		type: "POST",
		global: false
	});
}
</script>
<div id="issue-section" class="clearfix">
	<table style="color: black;">
		<tr style="border: thin solid black;">
			<th style="padding: 5px;">name</th>
			<th style="padding: 5px;">role</th>
			<th style="padding: 5px;">facebook</th>
			<th style="padding: 5px;">twitter</th>
			<th style="padding: 5px;">linkedin</th>
		</tr>
	<?php
	$result = pg_query($dbconn, "SELECT * FROM democracylab_users ORDER BY name");
	while($row = pg_fetch_object($result)) {
		?><tr style="border: thin solid black;">
			<td style="padding: 5px;"><?= htmlspecialchars($row->name) ?></td>
			<td style="padding: 5px; color: grey;"><select onchange="change_admin(<?= $row->user_id ?>,this);"><option value="admin" <?= $row->role == 1 ? 'selected' : '' ?>>admin</option><option value="user" <?= $row->role == 0 ? 'selected' : '' ?>>user</option></select></td>
			<td style="padding: 5px; color: grey;"><?= $row->fb_id ? $row->fb_id : '' ?></td>
			<td style="padding: 5px; color: grey;"><?= $row->twitter_id ? $row->twitter_id : '' ?></td>
			<td style="padding: 5px; color: grey;"><?= $row->linkedin_id ? $row->linkedin_id : '' ?></td>
		</tr>
<?php
	}
	?>
	</table>
</div>

    <div id="footer" class="clearfix">
	<p><a href="<?= dl_facebook_url('summary.php') ?>">back to main page</a></p>
	</div>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-2879129-3']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>  </body>
</html>