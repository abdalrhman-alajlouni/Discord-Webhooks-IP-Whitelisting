<?php
	
	/********************************************************************
		
		.----------------.  .----------------.  .----------------.  .----------------. 
		| .--------------. || .--------------. || .--------------. || .--------------. |
		| | ____    ____ | || |    ______    | || |   _____      | || | ____    ____ | |
		| ||_   \  /   _|| || |   / ____ `.  | || |  |_   _|     | || ||_   \  /   _|| |
		| |  |   \/   |  | || |   `'  __) |  | || |    | |       | || |  |   \/   |  | |
		| |  | |\  /| |  | || |   _  |__ '.  | || |    | |   _   | || |  | |\  /| |  | |
		| | _| |_\/_| |_ | || |  | \____) |  | || |   _| |__/ |  | || | _| |_\/_| |_ | |
		| ||_____||_____|| || |   \______.'  | || |  |________|  | || ||_____||_____|| |
		| |              | || |              | || |              | || |              | |
		| '--------------' || '--------------' || '--------------' || '--------------' |
		'----------------'  '----------------'  '----------------'  '----------------' 	
		
		Website : https://m3lm.games
        Email : info@m3lm.co
        Discord : https://discord.gg/m3lmco 
		
		@ Secured Webhooks System
		
	********************************************************************/
	
	
	// المعلومات التي يجب ملئها
	
	$FirstTimeSetup = false; // فقط عند استخدام النظام اول مرة لتثبت المتغييرات واعطاءها لك للتسهيل عليك
	$DomainOrIP = '0'; // اكتب ايبي خادمك , او اذا عندك دومين
	$SSL = false; // تشغلها فقط لو عندك شهادة حماية اس اس ال
	$DefaultIconURL = "https://media.discordapp.net/attachments/870376559742156810/1021763678271447141/m3lmlogo.png"; // الصورة الديفولت اذا ما تم ارسال صورة
	$DefaultColor = 3145472; // اللون الديفولت اذا ما تم ارسال لون
	$DefaultBotName = "Logs System"; // الاسم الديفولت اذا ما تم ارسال اسم للبوت
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if ($FirstTimeSetup == true) {
		
		$luaTable = file_get_contents("LOGs-System.lua");
		
		$matches = [];
		preg_match_all('/(\w+)\s*=\s*"(.*)"/u', $luaTable, $matches);
		
		$result = [];
		for ($i = 0; $i < count($matches[0]); $i++) {
			$key = $matches[1][$i];
			$pvalue = ''.$SSL ? 'https' : 'http';
			$value = $pvalue.'://'.$DomainOrIP.'/discord/m3lm/systems/private/api/M3LMPrivateSending?t='.$matches[1][$i];
			$result[$key] = $value;
			file_put_contents('New-File.lua', "".$key." = '".$value."',\n", FILE_APPEND | LOCK_EX);
		}
		
		
		echo "Setup Done";
		exit();
		
		
		
		
		
		}else{
		$luaTable = file_get_contents("LOGs-System.lua");
		
		$matches = [];
		preg_match_all('/(\w+)\s*=\s*"(.*)"/u', $luaTable, $matches);
		
		$result = [];
		for ($i = 0; $i < count($matches[0]); $i++) {
			$key = $matches[1][$i];
			$value = $matches[2][$i];
			$result[$key] = $value;
		}
	}
	
	$WebhookID = $_GET['t'] ?? null;
	
	$data = json_decode(file_get_contents('php://input'), true);
	
	if (!$data || !$WebhookID) {
		$datarev = array();
		$datarev["done"] = "no1";
		echo json_encode($datarev);	
		$datarev = array();	
		exit();
	}
	
	
	$WebhookEmbed = $data['embeds'] ?? null;
	$WebhookUsername = $data['username'] ?? $DefaultBotName;
	$WebhookAvatar = $data['avatar_url'] ?? $DefaultIconURL;
	
	
	if ($WebhookEmbed == null) {
		
		$datarev = array();
		$datarev["done"] = "no";
		echo json_encode($datarev);	
		$datarev = array();	
		exit();
	}
	
	
	$Color = $data['embeds'][0]['color'] ?? $DefaultColor;
	$Tittle = $data['embeds'][0]['title'] ?? "Tittle";
	$AuthorName = $data['embeds'][0]['author']['name'] ?? "";
	$AuthorIcon = $data['embeds'][0]['author']['icon_url'] ?? "";
	$ThumbnailUrl = $data['embeds'][0]['thumbnail']['url'] ?? $DefaultIconURL;
	$Fields = $data['embeds'][0]['fields'] ?? null;
	$Timestamp = $data['embeds'][0]['timestamp'] ?? gmdate('Y-m-d\TH:i:s\Z');
	$FooterText = $data['embeds'][0]['footer']['text'] ?? "";
	$FooterIcon = $data['embeds'][0]['footer']['icon_url'] ?? $DefaultIconURL;
	$Description = $data['embeds'][0]['description'] ?? "";
	
	
	$WebHookURL = $result[$WebhookID];
	
	$hookObject = json_encode([
    "content" => "",
    "tts" => false,
	"username" => $WebhookUsername,
	"avatar_url" => $WebhookAvatar,
	"embeds" => [
	[
	"title" => $Tittle,
	"type" => "rich",
	"description" => $Description,
	"timestamp" => $Timestamp,
	"color" => $Color,
	
	"author" => [
	"name" => $AuthorName,
	"icon_url" => $AuthorIcon
	],
	
	"footer" => [
	"text" => $FooterText,
	"icon_url" => $FooterIcon
	],
	
	"thumbnail" => [
	"url" => $ThumbnailUrl
	],
	"fields" => $Fields
	]
	]
	
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	
	$ch = curl_init();
	
	curl_setopt_array($ch, [
	CURLOPT_URL => $WebHookURL,
	CURLOPT_POST => true,
	CURLOPT_POSTFIELDS => $hookObject,
	CURLOPT_HTTPHEADER => [
	"Content-Type: application/json"
	]
	]);
	$response = curl_exec($ch);
	curl_close($ch);
	
	
	
	
	$datarev = array();
	$datarev["done"] = "yes";
	echo json_encode($datarev);	
	$datarev = array();	
	exit();
	
	
?>