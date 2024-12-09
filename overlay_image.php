<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adjust Image Size & Position</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .canvas-container {
    position: relative;
    width: 100%;
    max-width: 400px;  /* 缩小框架的最大宽度 */
    margin: 0 auto;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
}
canvas {
    display: block;
    margin: 0 auto;
}
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Adjust Image Size & Position</h1>
        <div class="card p-4 shadow">
            <form action="process_overlay.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="overlay" class="form-label">Upload Overlay Image:</label>
                    <input type="file" class="form-control" id="overlay" name="overlay" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Process Image</button>
            </form>
        </div>

        <!-- Adjustment Section -->
        <?php if (isset($_GET['main']) && isset($_GET['overlay'])): ?>
        <div class="mt-5">
            <h4 class="text-center">Adjust Image</h4>
            <div class="canvas-container">
                <canvas id="canvas"></canvas>
            </div>
            <div class="mt-3">
                <label for="sizeRange" class="form-label">Resize Overlay:</label>
                <input type="range" class="form-range" id="sizeRange" min="0.1" max="2" step="0.1" value="1">
            </div>
            <div class="mb-3">
                <label for="xPos" class="form-label">X Position:</label>
                <input type="range" class="form-range" id="xPos" min="-300" max="300" step="1" value="0">
            </div>
            <div class="mb-3">
                <label for="yPos" class="form-label">Y Position:</label>
                <input type="range" class="form-range" id="yPos" min="-300" max="300" step="1" value="0">
            </div>
            <button class="btn btn-success w-100" id="saveBtn">Save Final Image</button>
        </div>
        <?php endif; ?>
    </div>

    <script>
        const mainImageSrc = "<?php echo htmlspecialchars($_GET['main']); ?>";
        const overlayImageSrc = "<?php echo htmlspecialchars($_GET['overlay']); ?>";

        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        const sizeRange = document.getElementById('sizeRange');
        const xPos = document.getElementById('xPos');
        const yPos = document.getElementById('yPos');
        const saveBtn = document.getElementById('saveBtn');

        let mainImage = new Image();
        let overlayImage = new Image();
        let overlayScale = 1;
        let overlayX = 0;
        let overlayY = 0;

        mainImage.src = mainImageSrc;
        overlayImage.src = overlayImageSrc;

        mainImage.onload = () => {
            canvas.width = mainImage.width;
            canvas.height = mainImage.height;
            drawCanvas();
        };

        overlayImage.onload = () => {
            drawCanvas();
        };

        sizeRange.addEventListener('input', () => {
            overlayScale = parseFloat(sizeRange.value);
            drawCanvas();
        });

        xPos.addEventListener('input', () => {
            overlayX = parseInt(xPos.value, 10);
            drawCanvas();
        });

        yPos.addEventListener('input', () => {
            overlayY = parseInt(yPos.value, 10);
            drawCanvas();
        });

        saveBtn.addEventListener('click', () => {
            const finalImage = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.href = finalImage;
            link.download = 'final_image.png';
            link.click();
        });

        function drawCanvas() {
    // 强制设置画布的宽高
    const canvasWidth = 600;  // 设置画布的固定宽度
    const canvasHeight = 300;  // 设置画布的固定高度

    canvas.width = canvasWidth;
    canvas.height = canvasHeight;

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(mainImage, 0, 0, canvas.width, canvas.height);

    const overlayWidth = overlayImage.width * overlayScale;
    const overlayHeight = overlayImage.height * overlayScale;

    const overlayDrawX = canvas.width / 2 - overlayWidth / 2 + overlayX;
    const overlayDrawY = canvas.height / 2 - overlayHeight / 2 + overlayY;

    ctx.drawImage(overlayImage, overlayDrawX, overlayDrawY, overlayWidth, overlayHeight);
}
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
