<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && isset($_FILES['overlay'])) {
    // 处理主图像
    $image = $_FILES['image']['tmp_name'];
    $mainOutput = 'uploads/main_' . time() . '.png';

    // 将主图像保存到指定路径
    move_uploaded_file($image, $mainOutput);

    // 处理 Overlay 图像
    if (isset($_FILES['overlay']) && $_FILES['overlay']['error'] == 0) {
        $overlayOutput = 'uploads/overlay_' . time() . '.png';
        move_uploaded_file($_FILES['overlay']['tmp_name'], $overlayOutput);

        // 定向到 overlay_image.php 页面，传递主图和覆盖图路径
        header("Location: overlay_image.php?main=$mainOutput&overlay=$overlayOutput");
        exit;
    } else {
        // 如果没有上传 Overlay 图像，只传递主图
        header("Location: overlay_image.php?main=$mainOutput");
        exit;
    }
} else {
    // 如果请求不符合条件，返回到 overlay_image.php 页面
    header('Location: overlay_image.php');
    exit;
}
