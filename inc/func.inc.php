<?php
/**
 * Created by PhpStorm.
 * User: Delbert
 * Date: 2015/1/4
 * Time: 09:57
 */
	$ASS_TOK = $_COOKIE["access_token"];
	$CODE    = $_COOKIE["code"];


	$code_uri  = "https://api.weibo.com/oauth2/authorize?client_id=$APP_KEY&redirect_uri=$CAL_BAK&display=default";
	$post_uri  = "https://upload.api.weibo.com/2/statuses/upload.json";
	$oauth_uri = "https://api.weibo.com/oauth2/access_token?";

	function ask_code(){
		global $code_uri ;
		echo "<p>正在进行重定向，如果页面长时间没有反应，请点击<a href=".$code_uri.">这里</a></p>";
		header("Location: $code_uri");
		exit();
/*		$curl_handle = curl_init($code_uri);
		$cd = curl_exec($curl_handle);
		curl_close($curl_handle);
		echo $cd;*/
	};
	
	function check_code($c=0){
        global $CODE, $ASS_TOK;
		if(empty($_COOKIE["access_token"]) and empty($_GET["code"]))
			// No access_token
			$d = 1;
		elseif(!empty($_GET["code"]) and empty($_COOKIE["access_token"])){
			// Need to get_token
			$d = 2;
		}else{
			$d = 3;
		}
		if($c == 0){
			return $d;
		}else{
			return $c == $d;
		}
	};
	
	function acc_token(){
		global $APP_KEY, $APP_SEC, $CAL_BAK, $CODE;
		$CODE = $_GET["code"];
		$oauth_uri = "https://api.weibo.com/oauth2/access_token?";
		$param_string = "client_id=$APP_KEY&client_secret=$APP_SEC&grant_type=authorization_code&redirect_uri=$CAL_BAK&code=$CODE";
		
		$curl_handle=curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $oauth_uri);
		curl_setopt($curl_handle, CURLOPT_POST, true);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $param_string);
		curl_setopt($curl_handle, CURLOPT_HEADER, 0);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		$token_return = curl_exec($curl_handle);
		curl_close($curl_handle);

		$token_return = json_decode($token_return, true);

		if($token_return["error"]){
			foreach ($token_return as $key => $value){
				echo $key." : ".$value."<br>";
			}
		}else{
			$ASS_TOK = $token_return["access_token"];
			$EXP_TIM = $token_return["expires_in"];
			setcookie("access_token", $ASS_TOK, time() + $EXP_TIM, '/');
			setcookie("code", $_GET["code"], time() + $EXP_TIM, '/');
//            if($_GET["code"]){ header("Location: $CAL_BAK");}
		}
	};
	
	function get_token(){
		
	};
	
	function post_pic(){
		global $APP_KEY, $ASS_TOK;
		if($_POST["check_up"]){
			if(empty($_FILES["pic"]["name"])){
				$post_uri = "https://api.weibo.com/2/statuses/update.json";
				$param_string = "source=$APP_KEY&access_token=$ASS_TOK&visible=".($_POST['visible'])."&status=".urlencode($_POST["status"]);
			}else{
				$post_uri = "https://upload.api.weibo.com/2/statuses/upload.json";
				$param_string = array(
                    "source" => $APP_KEY,
                    "access_token" => $ASS_TOK,
					"visible" => $_POST["visible"],
                    "status" => urlencode($_POST["status"]),
                    "pic" => "@".$_FILES["pic"]["tmp_name"]
                );
                //"source=$APP_KEY&access_token=$ASS_TOK&status=".urlencode($_POST["status"])."&pic=".$_FILES["pic"];
			}

			echo($_FILES["pic"]["name"]);
			$curl_handle=curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $post_uri);
			curl_setopt($curl_handle, CURLOPT_POST, true);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $param_string);
			curl_setopt($curl_handle, CURLOPT_HEADER, 0);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			$raw_msg_return = curl_exec($curl_handle);
			curl_close($curl_handle);
//			echo $raw_msg_return;
			$msg_return = json_decode($raw_msg_return, true);
            return $msg_return;
		}
		
	};
