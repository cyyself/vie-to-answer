$("#but0").click(function(){
	$("#but0").html("正在发送请求");
	var name=$("#name").val();
	var pwd=$("#pwd").val();
	window.localStorage.setItem('qd-name',name);
	window.localStorage.setItem('qd-pwd',pwd);
	$.ajax(
		{
			type: 'POST',
			url: 'click.php',
			data: {
				'name': name,
				'pwd': pwd
			},
			success: function(data){
				if(data.s==1){
					alert("抢答成功！");
				}
				else {
					alert(data.msg);
				}
				$("#but0").html("抢答");
			},
			dataType: 'json',
			error: function(){
				alert('请求异常！');
				$("#but0").html("抢答");
			}
		}
	);
});
$("#but1").click(function(){
	$("#but1").html("正在发送请求");
	var name=$("#name").val();
	var pwd=$("#pwd").val();
	window.localStorage.setItem('qd-name',name);
	window.localStorage.setItem('qd-pwd',pwd);
	$.ajax(
		{
			type: 'POST',
			url: 'check.php',
			data: {
				'name': name,
				'pwd': pwd
			},
			success: function(data) {
				if(data.s==1) {
					alert("验证成功！可以开始抢答了！");
				}
				else {
					alert(data.msg);
				}
				$("#but1").html("验证");
			},
			dataType: 'json',
			error: function() {
				alert('请求异常！');
				$("#but1").html("验证");
			}
		}
	);
});
function pingtest() {
	var sttime = new Date().getTime();
	$.ajax(
		{
			type: 'GET',
			timeout : 3000,
			url: 'ping.json',
			data: {
				't': sttime
			},
			success: function(data) {
				var curtime = new Date().getTime();
				var pingtime = curtime - sttime;
				$("#ping").html("Ping:" + pingtime  + "ms");
			},
			dataType: 'json',
			error: function() {
				$("#ping").html("请检查网络连接");
			}
		}
	);
}
setTimeout("pingtest()",1000);
setInterval("pingtest()",5000);
