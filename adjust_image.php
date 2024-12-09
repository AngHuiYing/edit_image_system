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
            max-width: 600px;
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
            <form action="process_adjust_image.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Process Image</button>
            </form>
        </div>

        <!-- Adjustment Section -->
        <?php if (isset($_GET['image'])): ?>
        <div class="mt-5">
            <h4 class="text-center">Adjust Image</h4>
            <div class="canvas-container">
                <canvas id="canvas"></canvas>
            </div>
            <div class="mt-3">
                <label for="sizeRange" class="form-label">Resize Image:</label>
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
        const imageSrc = "<?php echo htmlspecialchars($_GET['image']); ?>";

        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        const sizeRange = document.getElementById('sizeRange');
        const xPos = document.getElementById('xPos');
        const yPos = document.getElementById('yPos');
        const saveBtn = document.getElementById('saveBtn');

        let image = new Image();
        let imageScale = 1;
        let imageX = 0;
        let imageY = 0;

        image.src = imageSrc;

        image.onload = () => {
            canvas.width = image.width;
            canvas.height = image.height;
            drawCanvas();
        };

        sizeRange.addEventListener('input', () => {
            imageScale = parseFloat(sizeRange.value);
            drawCanvas();
        });

        xPos.addEventListener('input', () => {
            imageX = parseInt(xPos.value, 10);
            drawCanvas();
        });

        yPos.addEventListener('input', () => {
            imageY = parseInt(yPos.value, 10);
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
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            const imageWidth = image.width * imageScale;
            const imageHeight = image.height * imageScale;

            const imageDrawX = canvas.width / 2 - imageWidth / 2 + imageX;
            const imageDrawY = canvas.height / 2 - imageHeight / 2 + imageY;

            ctx.drawImage(image, imageDrawX, imageDrawY, imageWidth, imageHeight);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
