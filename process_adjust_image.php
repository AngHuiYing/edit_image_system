<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // 处理上传图像
    $image = $_FILES['image']['tmp_name'];
    $output = 'uploads/output_' . time() . '.png';
    move_uploaded_file($image, $output);

    header("Location: adjust_image.php?image=$output");
    exit;
} else {
    header('Location: adjust_image.php');
    exit;
}
