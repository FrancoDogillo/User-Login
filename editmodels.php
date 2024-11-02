<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Car Model</title>
</head>

<body>
    <div class="wrapper">
        <h4 style="text-align: right;"><a href="index.php">Return Home</a></h4 style="text-align: right;">

        <?php
        // Check if model_id is set in the URL
        if (isset($_GET['model_id'])) {
            $model_id = $_GET['model_id'];

            // Fetch the model details based on model_id
            $model = getModelById($pdo, $model_id); // Ensure you have this function to fetch model details

            if (!$model) {
                echo "<h3>Model not found!</h3>";
                exit;
            }
        } else {
            exit;
        }

        // Fetch all companies for the dropdown
        $companies = getAllCompanies($pdo); // Ensure you have a function to fetch all companies
        ?>

        <!-- Form to Edit Car Model -->
        <h3>Edit Car Model</h3>
        <form action="core/handleForms.php?model_id=<?php echo $model_id; ?>" method="POST">
            <p hidden>
                <label for="company_name">Company</label>
                <select name="company_id" id="company_name" onchange="populateModels()" required>
                    <?php foreach ($companies as $company) { ?>
                        <option value="<?php echo htmlspecialchars($company['company_id']); ?>" <?php if ($company['company_id'] == $model['company_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($company['company_name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="model_name">Model Name</label>
                <select name="model_name" id="model_name" required>
                    <option value="">Select a Model</option> <!-- This is just a placeholder -->
                </select>
            </p>

            <p>
                <label for="year">Year</label>
                <input type="number" name="year" id="year" value="<?php echo htmlspecialchars($model['year']); ?>" required readonly>
            </p>
            <p>
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($model['price']); ?>" required readonly>
            </p>
            <div class="btn_container">
                <button class="btn" type="submit" name="editModelBtn">Update Model</button>
            </div>
        </form>

        <script src="core/carModels.js" type="module"></script>
    </div>
</body>

</html>