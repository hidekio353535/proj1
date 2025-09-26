<?php

// GitHub Actionsのシークレットに登録したキーを環境変数から取得
$secret = "SampleSecret";//getenv('WEBHOOK_SECRET');

// リクエストヘッダーから署名を取得
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? null;
if (!$signature) {
    http_response_code(403);
    die('Signature header missing.');
}

// リクエストボディを取得
$payload = file_get_contents('php://input');

// 署名を検証
list($algorithm, $hash) = explode('=', $signature, 2);
$payload_hash = hash_hmac($algorithm, $payload, $secret);

if (!hash_equals($hash, $payload_hash)) {
    http_response_code(403);
    die('Invalid signature.');
}

// 検証が成功した場合の処理（例：デプロイコマンドの実行）
// ウェブフックのペイロードをデコード
$payload_data = json_decode($payload, true);

// 例: mainブランチへのプッシュ時にデプロイ
if (isset($payload_data['ref']) && $payload_data['ref'] === 'refs/heads/main') {
    exec('git pull');
    // その他のデプロイ処理
    echo 'Deployment successful.';
}
exec("git pull origin main");

echo 'Webhook processed successfully.';

?>
