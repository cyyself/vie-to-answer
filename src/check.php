<?php
	$config = json_decode(file_get_contents("config.db"),true);
	$userauth = false;
	foreach ($config['user'] as $name => $pass) {
		if ($name == $_POST['name'] && $pass == $_POST['pwd']) {
			$userauth = true;
			break;
		}
	}
	$ret = array('s'=>'0','msg'=>'');
	if ($userauth) $ret['s'] = 1;
	else $ret['msg'] = '用户名或密码不正确';
	echo json_encode($ret);
?>
