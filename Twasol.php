<?php

define('API_KEY','5608236087:AAG5Wk19sNSd-bANSvtqVVwxGkeOTRmzOPY');

function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  foreach ($parameters as $key => &$val) {

    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
}

$update = json_decode(file_get_contents('php://input'));
var_dump($update);

$chat_id = $update->message->chat->id;
$boolean = file_get_contents('booleans.txt');
  $booleans= explode("\n",$boolean);

$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$rpto = $update->message->reply_to_message->forward_from->id;
$stickerid = $update->message->reply_to_message->sticker->file_id;
$photo = $update->message->photo;
$video = $update->message->video;
$sticker = $update->message->sticker;
$file = $update->message->document;
$music = $update->message->audio;
$voice = $update->message->voice;
$forward = $update->message->forward_from;
$admin = 5369272645;  ##هنا ايديك###
//-------
function SendMessage($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendSticker($ChatId, $sticker_ID)
{
 makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}
function save($filename,$TXTdata)
	{
	$myfile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}

//------------

if($textmessage == '/start')
 if ($from_id == $admin) {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"
مرحبا *$name* انت مدير هنا

استخدم الاوامر التالية ⤵️

- /X لحظر المشترك من البوت ❌

- /T لإلغاء حظر المشترك من البوت ✅

الاسم : $name
اسم المستخدم : @$username
",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"🔢 عدد المشتركين"],['text'=>"❌ قائمة الحظر"]
              ],
	      [
                ['text'=>"💭 رسالة للمشتركين"],['text'=>"📛 مسح الحظر"]
              ],
	      [
	        ['text'=>""]
	      ]
            ]
        ])
    ]));
 }
 else{
 
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"
مرحبا بك عزيزي $name

في بوت تواصل فريق ( JoKeR Team)

فقط ارسل ماتريد وسيتم ارسالها الى الفريق ،🤟🏿

[- المطور ،🌪](t.me/iiziiii)

~~~~~~~~~~~~~~~~~
[-جديدنا على التيليجرام،📟](t.me/murtjaa_1)
",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"",'request_contact' => true],['text'=>"",'request_location' => true]
              ],
	      [
                ['text'=>""],['text'=>""]
              ],
        [
                ['text'=>""],['text'=>""], ['text'=>""]
              ]
            ]
        ])
    ]));	
    $txxt = file_get_contents('member.txt');
$pmembersid= explode("\n",$txxt);
	if (!in_array($chat_id,$pmembersid)) {
		$aaddd = file_get_contents('member.txt');
		$aaddd .= $chat_id."
";
    	file_put_contents('member.txt',$aaddd);
}
 }

	elseif(strpos($textmessage , '/setprofile')!== false && $chat_id == $admin)
	{
		$javab = str_replace('/setprofile',"",$textmessage);
		if ($javab != "")
	{
	save("profile.txt","$javab");
	SendMessage($chat_id,"تم بالتاكيد وضع النص ،🛠");
	}
	}

elseif($textmessage == '')
	{
	$profile = file_get_contents("profile.txt");
	Sendmessage($chat_id," $profile ");
	}

  elseif(strpos($textmessage , '/userteam')!== false && $chat_id == $admin)
  {
    $javab = str_replace('/userteam',"",$textmessage);
    if ($javab != "")
  {
  save("membertxt.txt","$javab");
  SendMessage($chat_id,"تم وضح النص بنجاح ✅");
  }
  }

  elseif($textmessage == '')
  {
  $membertxt = file_get_contents("membertxt.txt");
  Sendmessage($chat_id," $membertxt ");
  }

	elseif($textmessage == '')
{
	$phone = 'رقمك';
	$namea = 'Ivar';
makereq('sendContact',[
	'chat_id'=>$chat_id,
	'phone_number'=>$phone,
	'first_name'=>$namea
	]);
}

elseif($textmessage == '')
  {
  	Sendmessage($chat_id,"تابع جديدنا على التلكرام @murtjaa_1");
  }

elseif($textmessage == '')
if($chat_id == $admin){
	{
		Sendmessage($chat_id,"");
	}
}
else
	{
		Sendmessage($chat_id,"");
	}


elseif ($chat_id != $admin) {


    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);
$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id," حبيبى $name تم ارسال رسالتك الى مدير البوت ايفار ،🚬🔩");
}else{

Sendmessage($chat_id,"جاري ارسال الرساله 📮");

    }
    }
      elseif (isset($message['contact'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"تم الارسال،🚶🇮🇶");
}else{

Sendmessage($chat_id,"جاري ارسال الرساله 📮");

}
    }
      }

	   elseif (isset($message['sticker'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"تم ارسال الملصق بنجاح ✅");
}else{

Sendmessage($chat_id,"جاري ارسال الرساله 📮");

}
    }
      }


   elseif (isset($message['photo'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"جاري ارسال الصورة،🚶🙄");
}else{

Sendmessage($chat_id,"جاري ارسال الرساله 📮");

}
    }
      }

         elseif (isset($message['voice'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"يتم الان ارسال الفيس 🔆");
}else{

Sendmessage($chat_id,"جاري ارسال الرساله 📮");

}
    }
      }
               elseif (isset($message['video'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"تم ارسال الفيديو 🎥");
}else{

Sendmessage($chat_id,"جاري ارسال الرساله 📮");

}
    }
      }



	elseif($textmessage == '🔢 عدد المشتركين' && $chat_id == $admin)
	{
		$txtt = file_get_contents('member.txt');
		$membersidd= explode("\n",$txtt);
		$mmemcount = count($membersidd) -1;
{
sendmessage($chat_id,"عدد المشتركين في البوت $mmemcount مشترك 👥");
}
}

	elseif($textmessage == '❌ قائمة الحظر' && $chat_id == $admin){
		$txtt = file_get_contents('banlist.txt');
		$membersidd= explode("\n",$txtt);
		$mmemcount = count($membersidd) -1;
{
sendmessage($chat_id,"تم حظر ↩️ $mmemcount ↪️ من المشتركين في البوت");
}
}




                  elseif (isset($message['location'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"لقد تم ارسال الموقع 🌐");
}else{

Sendmessage($chat_id,"جاري ارسال الرساله 📮");

}
    }
      }
            elseif($rpto != "" && $chat_id == $admin){
    	if($textmessage != "/X" && $textmessage != "/T")
    	{
sendmessage($rpto,"$textmessage");
sendmessage($chat_id,"" );
    	}
    	else
    	{
    		if($textmessage == "/X"){
    	$txtt = file_get_contents('banlist.txt');
		$banid= explode("\n",$txtt);
	if (!in_array($rpto,$banid)) {
		$addd = file_get_contents('banlist.txt');
		$addd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $addd);
		$addd .= $rpto."
";

    	file_put_contents('banlist.txt',$addd);
    	{
sendmessage($rpto,"عذرا، تم حظرك من البوت 📛");
sendmessage($chat_id,"تم الحظر بنجاح 📛");
        }
    		}
}
    	if($textmessage == "/T"){
    	$txttt = file_get_contents('banlist.txt');
		$banidd= explode("\n",$txttt);
	if (in_array($rpto,$banidd)) {
		$adddd = file_get_contents('banlist.txt');
		$adddd = str_replace($rpto,"",$adddd);
		$adddd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $adddd);
    $adddd .="
";


		$banid= explode("\n",$adddd);
    if($banid[1]=="")
      $adddd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $adddd);

    	file_put_contents('banlist.txt',$adddd);
}
sendmessage($rpto,"لقد تم رفع الحظر عن حسابك ⛔️");
sendmessage($chat_id,"تم رفع الحظر بنجاح ✔️");
    		}
    	}
	}


        elseif ($textmessage =="💭 رسالة للمشتركين"  && $chat_id == $admin | $booleans[0]=="false") {
	{
          sendmessage($chat_id,"عزيزي $name ارسل رسالتك الان 💭 ");
	}
      $boolean = file_get_contents('booleans.txt');
		  $booleans= explode("\n",$boolean);
	  	$addd = file_get_contents('banlist.txt');
	  	$addd = "true";
    	file_put_contents('booleans.txt',$addd);

    }
      elseif($chat_id == $admin && $booleans[0] == "true") {
    $texttoall = $textmessage;
		$ttxtt = file_get_contents('member.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){
			sendmessage($membersidd[$y],"
رسالة من الفريق

$texttoall

📢 Our Channel || @murtjaa_1
");

		}
		$memcout = count($membersidd)-1;
	 	{
	 	Sendmessage($chat_id,"✅ تم الارسال الئ  $memcout من اعضاء البوت ");
	 	}
         $addd = "false";
    	file_put_contents('booleans.txt',$addd);
    	}
 elseif($textmessage == '📛 مسح الحظر')
 if($chat_id == $admin){
 {
 file_put_contents('banlist.txt',$chat_id);
 Sendmessage($chat_id,"تم رفع الحظر عن الكل ⛔️");
 }
}
?>
