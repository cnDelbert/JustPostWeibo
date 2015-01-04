<?php 
	require_once("./inc/config.inc.php");
	require_once("./inc/func.inc.php");
    require_once("./inc/tags.inc.php");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>新浪微博简单发布</title>
	<style>
		.hidden{
			display: none;
		}
		#file_select{
			margin-top: 10pt;
			margin-bottom: 10pt;
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
		<input id="file_select" type="file" name="pic" />
        <br/>
		<textarea id="wb" onfocus="wb_input_clear();" name="status" rows="5" cols="25">请在这里输入要发布的微博</textarea>
        <br/>
		<input name="visible" value="1" id="rad_1" type="radio"/><label for="rad_1"> 仅自己可见 </label><br/>
		<input name="visible" value="2" id="rad_2" type="radio"/><label for="rad_2"> 好友圈可见 </label><br/>
		<input name="visible" value="0" id="rad_0" type="radio" checked="checked"/><label for="rad_0"> 所有人可见 </label>
		<br/><br/>
		<input type="submit" value=" 发布微博 ">
        <input class="hidden" type="text" value="<?php echo $ASS_TOK;?>" name="access_token" >
        <input class="hidden" value="true" name="check_up" >

        <br/><br/>
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
        if($img_json["thumbnail_pic"]){?>
            <table>
                <tr>
                    <td>缩略图：</td>
                    <td class="iurl"><input type="text" size="60" value="<?php echo $img_json["thumbnail_pic"]; ?>"/></td>
                </tr>
                <br/>
                <tr>
                    <td>中等图：</td>
                    <td class="iurl"><input type="text" size="60" value="<?php echo $img_json["bmiddle_pic"]; ?>"/></td>
                </tr>
                <br/>
                <tr>
                    <td>原始图：</td>
                    <td class="iurl"><input type="text" size="60" value="<?php echo $img_json["original_pic"]; ?>"/></td>
                </tr>
            </table>
        <?php } ?>

        <?php }; ?>
</body>
</html>
