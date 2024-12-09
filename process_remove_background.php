<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // API Key
    $apiKey = "zDKxcYxPzQuGUipg3VvT4C9f"; // 替换为你的 Remove.bg API Key

    // 上传图片
    $image = $_FILES['image']['tmp_name'];
    $outputPath = 'uploads/output_' . time() . '.png';

    // 调用 Remove.bg API
    $url = 'https://api.remove.bg/v1.0/removebg';
    $cfile = curl_file_create($image, mime_content_type($image), $_FILES['image']['name']);

    $data = [
        'image_file' => $cfile,
        'size' => 'auto'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-Api-Key: ' . $apiKey
    ]);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        file_put_contents($outputPath, $result);
        header('Location: remove_background.php?output=' . $outputPath);
        exit;
    }

    curl_close($ch);
} else {
    header('Location: remove_background.php');
    exit;
}
