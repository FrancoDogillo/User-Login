<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if the company_id is set in the URL
if (isset($_GET['company_id'])) {
    $company_id = $_GET['company_id'];
    $company = getCompanyByID($pdo, $company_id);
} else {
    echo "Company ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Delete Car Company</title>
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
        <h1>Delete Car Company</h1>

        <?php if ($company): ?>
            <form action="core/handleForms.php" method="POST">
                <p>Are you sure you want to delete the following company?</p>
                <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                <p><strong>Company Name:</strong> <?php echo htmlspecialchars($company['company_name']); ?></p>
                <p><strong>Country:</strong> <?php echo htmlspecialchars($company['country']); ?></p>
                <p><strong>Founded Year:</strong> <?php echo htmlspecialchars($company['founded_year']); ?></p>

                <div class="btn_container">
                    <button type="submit" name="deleteCompanyBtn" class="btn delete-btn">Yes, Delete</button>
                    <a href="index.php" class="btn cancel-btn">Cancel</a>
                </div>
            </form>
        <?php else: ?>
            <p>Company not found.</p>
        <?php endif; ?>
    </div>