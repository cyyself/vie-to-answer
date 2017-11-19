<?php
	function auth($config) {
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];
		if ($config['adminuser'] == $username && $config['adminpass'] == md5($password)) return true;
		else return false;
	}
	$config = json_decode(file_get_contents("config.db"),true);
	$auth = auth($config);
	if (!$auth) {
		header('WWW-Authenticate: Basic realm="Please Login"');
	}
	else {
		//处理操作
		switch ($_GET['action']) {
			case 'deluser' :
				foreach ($config['user'] as $name => $pass) {
					if ($name == $_GET['username']) unset($config['user'][$name]);
				}
				file_put_contents('config.db',json_encode($config));
				break;
			case 'adduser' :
				$username = $_GET['username'];
				if (strpos($username,"\t") === false && strpos($username,"\n") === false) {
					$config['user'][$username] = $_GET['password'];
					file_put_contents('config.db',json_encode($config));
				}
				break;
			case 'passwd' :
				if ($_GET['password1'] == $_GET['password2']) {
					$config['adminpass'] = md5($_GET['password2']);
					file_put_contents('config.db',json_encode($config));
				}
				else $msg = "密码校验不匹配。";
				break;
		}
	}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>云抢答系统-后台管理</title>
	<?php if ($msg) { ?>
	<script type="text/javascript">
		alert("<?php echo $msg ?>");
	</script>
	<?php } ?>
</head>
<body>
	<h1>云抢答系统-后台管理</h1>
	<h3>当前用户：<?php if ($auth) echo $_SERVER['PHP_AUTH_USER']; else echo "Error 401 Unauthorized"; ?></h3>
	<hr>
	<h2>用户管理</h2>
	<form name="adduser" action="" method="get" autocomplete="off">
		<input type="password" style="display: none;">
		<input type="text" name="action" value="adduser" hidden>
		<input type="text" name="username" id="username">:<input type="password" name="password" autocomplete="new-password">
		<input type="submit" value="添加/修改">
	</form>
	<table border="1">
	<tr>
		<td>用户名</td>
		<td>密码</td>
		<td>操作</td>
	</tr>
	<?php
		if ($auth) {
			$usertable = $config['user'];
			foreach ($usertable as $name => $pass) {
				?><tr>
					<td><?php echo htmlspecialchars($name); ?></td>
					<td><a href='javascript:alert("<?php echo $pass; ?>")'>显示密码</a></td>
					<td>
						<a href="?action=deluser&username=<?php echo $name; ?>">删除</a>
					</td>
				</tr><?php
			}
		}
	?>
	</table>
	<hr>
	<h2>管理员密码修改</h2>
	<form name="passwd" action="" method="get" autocomplete="off">
		<input type="password" style="display: none;"/>
		<input type="text" name="action" value="passwd" hidden>
		密码：<input type="password" name="password1" autocomplete="new-password"><br>
		校验：<input type="password" name="password2" autocomplete="new-password"><br>
		<input type="submit" value="修改">
	</form>
	<hr>
	<h2>控制面板</h2>
	<a href="board.html" target="_Blank">点击进入</a>
</body>
