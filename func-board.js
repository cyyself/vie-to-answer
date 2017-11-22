var QiangdaRunning = false;
$("#but0").click(function() {
	$("#Delay").val(Number($("#Delay").val()));
	$("#TimeOut").val(Number($("#TimeOut").val()));
	$("#but0").html("正在发送请求");
	var delay=$("#Delay").val();
	var timeout=$("#TimeOut").val();
	$.ajax({
		type: 'POST',
		url: 'newqd.php',
		data: {
			'Delay': delay,
			'TimeOut': timeout
		},
		success: function(data) {
			if(data.s == 1) {
				$("#but0").attr("disabled",true);
				for (var i=0;i<delay;i++) {
					var toshow = delay - i;
					setTimeout("$(\"#showResult\").html(\"" + toshow + "\")",1000*i);
				}
				setTimeout("$(\"#showResult\").html(\"开始抢答！\")",1000*delay);
				setTimeout("$(\"#but0\").attr(\"disabled\",false)",1000*delay);
				QiangdaRunning = false;
				setTimeout("QiangdaRunning = true;",1000*delay+500);
				setTimeout("getresult()",1000*delay+500);
			}
			else {
				alert(data.msg);
			}
			$("#but0").html("开始");
		},
		dataType: 'json',
		error: function() {
			alert('请求异常！');
			$("#but0").html("开始");
		}
	});
});
function getresult() {
	if (QiangdaRunning) {
		$.ajax({
			type: 'GET',
			url: 'showresult.php',
			timeout : 3000,
			dataType: 'json',
			success: function(data) {
				if (data.s == 1) {
					$("#showResult").html(data.html);
					setTimeout("getresult()",500);
					if (data.html == "") $("#showResult").html("开始抢答！");
				}
				else {
					alert("抢答已结束！");
					QiangdaRunning = false;
				}
			},
			error: function() {
				$("#showResult").html("请求异常");
			}
		});
	}
	setTimeout("getresult()",500);
}
