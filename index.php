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
            if(wb_input.value == "<?php echo $CUSTOM_TIP; ?>"){
                wb_input.value = "";
            }
        }

        function wb_default_tip(){
            var wb_input = document.getElementById('wb');
            if(wb_input.value == ''){
                wb_input.value = "<?php echo $CUSTOM_TIP; ?>"
            }
        }

        function add_tag(e){
            var src = e.target || window.event.srcElement;
            wb_input_clear();
            var wb_input = document.getElementById("wb");
            wb_input.value += src.innerHTML;
        }

        function clear_cookie(){
            var date=new Date();
            date.setTime(date.getTime()-10);
            document.cookie = "access_token= ;expires="+date.toGMTString()+";path=/;";
            document.cookie = "code= ;expires="+date.toGMTString()+";path=/;";
        }
    </script>
</head>
<body>
	<?php if(check_code(1)){ ask_code(); } else {if(check_code(2)){ acc_token();}  ?>
	<form action="./" method="POST" enctype="multipart/form-data" >
		<input id="file_select" type="file" name="pic" />
        <br/>
		<textarea id="wb" onfocus="wb_input_clear();" onblur="wb_default_tip();" name="status" rows="5" cols="25"><?php echo $CUSTOM_TIP; ?></textarea>
        <br/>
		<input name="visible" value="1" id="rad_1" type="radio"/><label for="rad_1"> 仅自己可见 </label><br/>
		<input name="visible" value="2" id="rad_2" type="radio"/><label for="rad_2"> 好友圈可见 </label><br/>
		<input name="visible" value="0" id="rad_0" type="radio" checked="checked"/><label for="rad_0"> 所有人可见 </label>
		<br/><br/>
		<input type="submit" value=" 发布微博 "> <input type="reset" value=" 重置 " onblur="wb_default_tip();"/>
        <input class="hidden" type="text" value="<?php echo $ASS_TOK;?>" name="access_token" >
        <input class="hidden" value="true" name="check_up" >

        <br/>
        <?php foreach($tags as $tag){ ?>
            <a href="javascript:void(0);" onclick="add_tag(event)">#<?php echo $tag;?>#</a>
        <?php }; ?>
	</form>

		<br/>
    <?php if(DEBUG_MODE){ ?>
        <form action="https://api.weibo.com/oauth2/get_token_info" method="POST">
            <input class="hidden" type="text" value="<?php echo $ASS_TOK;?>" name="access_token">
            <input type="submit" value="查看Token"> <button onclick="clear_cookie();" type="reset">清理cookies</button>
        </form>
    <?php } ?>
	<?php  $return_msg = post_pic();
        if($return_msg == "no_check_up"){}
        elseif(!empty($return_msg['error']) || empty($return_msg)){ // Error or no return_msg
            echo "<p>发布失败，请与管理员联系。</p>
            <p>".$return_msg['error_code']." ".$return_msg['error']."</p>";
        }elseif($return_msg["thumbnail_pic"]){  // If it is picture.
            echo "<p>发布成功! ".date('Y-m-d H:i:s')."</p>";
            ?>
            <table>
                <tr>
                    <td><a target="_blank" href="<?php echo $return_msg["thumbnail_pic"]; ?>">缩略图</a>：</td>
                    <td class="iurl"><input type="text" size="60" value="<?php echo $return_msg["thumbnail_pic"]; ?>"/></td>
                </tr>

                <tr>
                    <td><a href="<?php echo $return_msg["bmiddle_pic"]; ?>" target="_blank">中等图</a>：</td>
                    <td class="iurl"><input type="text" size="60" value="<?php echo $return_msg["bmiddle_pic"]; ?>"/></td>
                </tr>

                <tr>
                    <td><a href="<?php echo $return_msg["original_pic"]; ?>" target="_blank">原始图</a>：</td>
                    <td class="iurl"><input type="text" size="60" value="<?php echo $return_msg["original_pic"]; ?>"/></td>
                </tr>
            </table>
        <?php }else{    // If it is text.
            echo "<p>发布成功! ".date('Y-m-d H:i:s')."</p>";
        } ?>

        <?php }; ?>

    <p> &copy;2015 Delbert</p>
</body>
</html>
