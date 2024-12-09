<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rotate Image</title>
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
        <h1 class="text-center mb-4">Rotate Image</h1>
        <div class="card p-4 shadow">
            <form action="process_rotate.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Upload Image</button>
            </form>
        </div>

        <!-- Display Image with Rotate Option -->
        <?php if (isset($_GET['image'])): ?>
        <div class="mt-5">
            <h4 class="text-center">Adjust Rotation</h4>
            <div class="canvas-container">
                <canvas id="canvas"></canvas>
            </div>
            <div class="mt-3">
                <label for="rotateRange" class="form-label">Rotate Image:</label>
                <input type="range" class="form-range" id="rotateRange" min="0" max="360" step="1" value="0">
            </div>
            <button class="btn btn-success w-100" id="saveBtn">Save Final Image</button>
        </div>
        <?php endif; ?>
    </div>

    <script>
        const imageSrc = "<?php echo htmlspecialchars($_GET['image']); ?>";

        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        const rotateRange = document.getElementById('rotateRange');
        const saveBtn = document.getElementById('saveBtn');

        let image = new Image();
        let angle = 0;

        image.src = imageSrc;

        image.onload = () => {
            canvas.width = image.width;
            canvas.height = image.height;
            drawCanvas();
        };

        rotateRange.addEventListener('input', () => {
            angle = parseInt(rotateRange.value, 10);
            drawCanvas();
        });

        saveBtn.addEventListener('click', () => {
            const finalImage = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.href = finalImage;
            link.download = 'rotated_image.png';
            link.click();
        });

        function drawCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Rotate around the center of the canvas
            ctx.save();
            ctx.translate(canvas.width / 2, canvas.height / 2);
            ctx.rotate(angle * Math.PI / 180);
            ctx.drawImage(image, -image.width / 2, -image.height / 2);
            ctx.restore();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
