<?php


$url = "https://digitaling.sakura.ne.jp/proj1_prod/pull2.php";

//cURLセッションを初期化する
$ch = curl_init();

//URLとオプションを指定する
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//URLの情報を取得する
$res =  curl_exec($ch);

//セッションを終了する
curl_close($conn);

?>