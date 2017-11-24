<?php
	$CurrentTime = microtime(true);
	$ret = array('s'=>0,'html'=>'');
	$qdinfo = json_decode(file_get_contents('qdinfo.json'),true);
	$EndTime = $qdinfo['StartTime'] + $qdinfo['Delay'] + $qdinfo['TimeOut'];
	if ($CurrentTime >= $qdinfo['StartTime'] && $CurrentTime <= $EndTime) $ret['s'] = 1;
	$qdlog = explode("\n",file_get_contents('qdlog.db'));
	$rank = 0;
	foreach ($qdlog as $line) {//遍历抢答日志
		$row = explode("\t",$line);
		if (count($row) == 2 && $row[0] >= $qdinfo['StartTime'] + $qdinfo['Delay']) {
			$ret['html'] .= sprintf("No.%d %s %0.3fs<br />",++$rank,htmlspecialchars($row[1]),$row[0] - ($qdinfo['StartTime'] + $qdinfo['Delay']));
		}
	}
	echo json_encode($ret);
?>
