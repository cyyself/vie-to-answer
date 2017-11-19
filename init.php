<?php
	function is_cli(){
		return preg_match("/cli/i", php_sapi_name()) ? true : false;
	}
	if (is_cli()) {
		$config = array(
			'adminuser'=>'admin',
			'adminpass'=>md5('admin'),
			'user'=>array(
				'user1'=>'123456',
				'user2'=>'123456'
			)
		);
		file_put_contents('config.db',json_encode($config));
		$ret = array(
			'StartTime'=>microtime(true),
			'Delay'=>3,
			'TimeOut'=>60
		);
		file_put_contents('qdlog.db','');
		file_put_contents('qdinfo.json',json_encode($ret));
		echo "OK, you can use admin:admin to login.\n";
	}
	else {
		echo "init.php can only running on CLI.\n";
	}
?>
