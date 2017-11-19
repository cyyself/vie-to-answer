<?php
	function auth($config) {
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];
		if ($config['adminuser'] == $username && $config['adminpass'] == md5($password)) return true;
		else return false;
	}
	$config = json_decode(file_get_contents('config.db'),true);
	$ret = array('s'=>0,'msg'=>'');
	if (auth($config)) {
		$qdinfo = array(
			'StartTime'=>microtime(true),
			'Delay'=>intval($_POST['Delay']),
			'TimeOut'=>intval($_POST['TimeOut'])
		);
		file_put_contents('qdlog.db','');
		file_put_contents('qdinfo.json',json_encode($qdinfo));
		$ret['s'] = 1;
	}
	else $ret['msg'] = '请先到admin.php中登录';
	echo json_encode($ret);
?>
