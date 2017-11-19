<?php
	$CurrentTime = microtime(true);
	$config = json_decode(file_get_contents('config.db'),true);
	//userauth BEGIN
	$userauth = false;
	foreach ($config['user'] as $name => $pass) {
		if ($name == $_POST['name'] && $pass == $_POST['pwd']) {
			$userauth = true;
			break;
		}
	}
	//userauth END
	$ret = array('s'=>0,'msg'=>'');
	if ($userauth) {
		$NameExist = false;
		$qdlog = explode("\n",file_get_contents('qdlog.db'));
		foreach ($qdlog as $line) {//遍历抢答日志
			$row = explode("\t",$line);
			if (count($row) == 2 && $row[1] == $_POST['name']) {
				$NameExist = true;
				break;
			}
		}
		if (!$NameExist) {
			$qdinfo = json_decode(file_get_contents('qdinfo.json'),true);
			if ($CurrentTime <= $qdinfo['StartTime'] + $qdinfo['Delay'] + $qdinfo['TimeOut']) {
				if ($CurrentTime <= $qdinfo['StartTime'] + $qdinfo['Delay']) $ret['msg'] = '提前抢答，本次弃权！';
				else $ret['s'] = 1;
				//提前抢答也要写入log
				$file = fopen('qdlog.db','a+');
				$content = $CurrentTime . "\t" . $_POST['name'] . "\n";
				fwrite($file,$content);
				fclose($file);
			}
			else $ret['msg'] = '本次抢答已结束';
		}
		else $ret['msg'] = '重复抢答';
	}
	else $ret['msg'] = '用户名或密码不正确';
	echo json_encode($ret);
?>
