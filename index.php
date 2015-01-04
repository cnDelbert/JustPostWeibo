<?php 
	require_once("./inc/config.inc.php");
	require_once("./inc/func.inc.php");
    require_once("./inc/tags.inc.php");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>新浪微博登陆测试页面</title>
	<style>
		.hidden{
			display: none;
		}
	</style>
    <script>
        function wb_input_clear(){
            var wb_input = document.getElementById("wb");
            if(wb_input.value == "请在这里输入要发布的微博"){
                wb_input.value = "";
            }
        };

        function add_tag(e){
            var src = e.target || window.event.srcElement;
            wb_input_clear();
            var wb_input = document.getElementById("wb");
            wb_input.value += src.innerHTML;
        };

        function clear_cookie(){
            var date=new Date();
            date.setTime(date.getTime()-10);
            document.cookie = "access_token= ;expires="+date.toGMTString()+";path=/;";
            document.cookie = "code= ;expires="+date.toGMTString()+";path=/;";
        };
    </script>
</head>
<body>
	<?php if(check_code(1)){ ask_code(); } else {if(check_code(2)){ acc_token();}  ?>
	<form action="./" method="POST" enctype="multipart/form-data" >
		<input type="file" name="pic" >
        <br/>
		<textarea id="wb" onfocus="wb_input_clear();" name="status" >这里输入要发布的微博</textarea>
        <br/>
		<input type="submit" value="Submit">
        <input class="hidden" type="text" value="<?php echo $ASS_TOK;?>" name="access_token" >
        <input class="hidden" value="true" name="check_up" >
        <br/>
        <?php foreach($tags as $tag){ ?>
            <a href="javascript:void(0);" onclick="add_tag(event)">#<?php echo $tag;?>#</a>
        <?php }; ?>
	</form>

		<br/>

	<form action="https://api.weibo.com/oauth2/get_token_info" method="POST">
		<input class="hidden" type="text" value="<?php echo $ASS_TOK;?>" name="access_token">
		<input type="submit" value="查看Token"> <button onclick="clear_cookie();" type="reset">清理cookies</button>
	</form>
	<?php  $img_json = post_pic();
        if($img_json){?>
            <table>
                <tr>
                    <td>缩略图：</td>
                    <td class="iurl"><input type="text" size="70" value="<?php echo $img_json["thumbnail_pic"]; ?>"/></td>
                </tr>
                <br/>
                <tr>
                    <td>中  图：</td>
                    <td class="iurl"><input type="text" size="70" value="<?php echo $img_json["bmiddle_pic"]; ?>"/></td>
                </tr>
                <br/>
                <tr>
                    <td>原始图：</td>
                    <td class="iurl"><input type="text" size="70" value="<?php echo $img_json["original_pic"]; ?>"/></td>
                </tr>
            </table>
        <?php } ?>

        <?php }; ?>
</body>
</html>
