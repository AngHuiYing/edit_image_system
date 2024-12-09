<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Image Background</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Remove Image Background</h1>
        <div class="card p-4 shadow">
            <form action="process_remove_background.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Remove Background</button>
            </form>
        </div>

        <!-- Display Result -->
        <?php if (isset($_GET['output'])): ?>
            <div class="mt-5 text-center">
                <h4>Result:</h4>
                <img src="<?php echo htmlspecialchars($_GET['output']); ?>" alt="Result Image" class="img-thumbnail">
                <div class="mt-3">
                    <a href="<?php echo htmlspecialchars($_GET['output']); ?>" download="output.png" class="btn btn-success">Download Image</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
