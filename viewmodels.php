<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Car Models for Company</title>
    <style>
        .home-link {
            color: #1a73e8;
            /* Keeps the default color */
            text-decoration: none;
        }

        .home-link:hover {
            color: firebrick;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h4 style="text-align: right;"><a href="index.php" class="home-link">Return Home</a></h4>
        <?php
        // Check if company_id is set in the URL
        if (isset($_GET['company_id'])) {
            $company_id = $_GET['company_id'];

            // Fetch the company details
            $company = getCompanyById($pdo, $company_id);
            if ($company) {
                echo "<h3>Models for " . htmlspecialchars($company['company_name']) . "</h3>";
            } else {
                echo "<h3>Company not found!</h3>";
                exit;
            }

            // Fetch all models for this company
            $allModels = getModelsByCompanyId($pdo, $company_id);
        } else {
            echo "<h3>No company selected!</h3>";
            exit;
        }
        ?>

        <!-- Form to Add New Car Model -->
        <h3>Add a New Car Model</h3>
        <form action="core/handleForms.php" method="POST">
            <p>
                <label for="company_name">Company</label>
                <select name="company_id" id="company_name" onchange="populateModels()" required>
                    <option value="<?php echo $company['company_id']; ?>"><?php echo htmlspecialchars($company['company_name']); ?></option>

                </select>
            </p>
            <p>
                <label for="model_name">Model Name</label>
                <select name="model_name" id="model_name" onchange="updateModelDetails()" required>
                    <option value="">Select a Model</option>
                </select>
            </p>
            <p>
                <label for="year">Year</label>
                <input type="number" name="year" id="year" required readonly>
            </p>
            <p>
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price" required readonly>
            </p>
            <div class="btn_container">
                <button class="btn" type="submit" name="addModelBtn">Add Model</button>
            </div>
        </form>
        <script src="core/carModels.js" type="module"></script>


        <!-- Display All Car Models for the Selected Company -->
        <h3>All Car Models</h3>
        <table>
            <thead>
                <tr>
                    <th>Model Name</th>
                    <th>Year</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($allModels) {
                    foreach ($allModels as $model) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($model['model_name']); ?></td>
                            <td><?php echo htmlspecialchars($model['year']); ?></td>
                            <td><?php echo htmlspecialchars($model['price']); ?></td>
                            <td>
                                <a class="links" href="editmodels.php?model_id=<?php echo $model['model_id']; ?>">Edit</a>
                                <a class="links" href="deletemodels.php?model_id=<?php echo $model['model_id']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='4'>No models found for this company.</td></tr>";
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>