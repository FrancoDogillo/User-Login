<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if the model_id is set in the URL
if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];
    $model = getModelById($pdo, $model_id);
    $company_id = $model['company_id']; // Fetch company_id from the model
} else {
    echo "Model ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Delete Car Model</title>
    <style>
        .btn_container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            display: inline-block;
        }

        .delete-btn {
            background-color: #e53935;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #b71c1c;
        }

        .cancel-btn {
            background-color: firebrick;
        }

        .cancel-btn:hover {
            background-color: #b50000;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h1>Delete Car Model</h1>

        <?php if ($model): ?>
            <form action="core/handleForms.php" method="POST">
                <p>Are you sure you want to delete the following car model?</p>
                <input type="hidden" name="model_id" value="<?php echo $model_id; ?>">
                <input type="hidden" name="company_id" value="<?php echo $company_id; ?>"> <!-- Add this line -->
                <p><strong>Model Name:</strong> <?php echo htmlspecialchars($model['model_name']); ?></p>
                <p><strong>Year:</strong> <?php echo htmlspecialchars($model['year']); ?></p readonly>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars(number_format($model['price'], 2)); ?></p readonly>
                <div class="btn_container">
                    <button type="submit" name="deleteModelBtn" class="btn delete-btn">Yes, Delete</button>
                    <a href=" models.php" class="btn cancel-btn">Cancel</a>
                </div>
            </form>
        <?php else: ?>
            <p>Model not found.</p>
        <?php endif; ?>
    </div>
</body>

</html>