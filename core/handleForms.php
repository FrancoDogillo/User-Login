<!-- Purpose: Handle form data from index.php and insert into database -->

<?php

require_once 'dbConfig.php';
require_once 'models.php';


// Handle form submission for adding a new car company
if (isset($_POST['submitCompanyButton'])) {
    // Assuming you have session handling to get the current user's ID
    session_start(); // Start session if not already started
    $user_id = $_SESSION['user_id']; // Get the user ID from the session

    $query = insertCompany($pdo, $_POST['company_name'], $_POST['country'], $_POST['founded_year'], $user_id);
    if ($query) {
        echo "Company added successfully!<br><br>";
        echo "<a href='../index.php'>Return Home</a>";
    } else {
        echo "Failed to add company!";
    }
}

// Handle form submission for editing an existing car company
if (isset($_POST['editCompanyBtn'])) {
    $query = updateCompany($pdo, $_GET['company_id'], $_POST['company_name'], $_POST['country'], $_POST['founded_year']);
    if ($query) {
        echo "Company updated successfully!<br><br>";
        echo "<a href='../index.php'>Return Home</a>";
    } else {
        echo "Failed to update company!";
    }
}

// Handle form submission for deleting a car company
if (isset($_POST['deleteCompanyBtn'])) {
    $company_id = $_POST['company_id']; // Use POST instead of GET
    $query = deleteCompany($pdo, $company_id);
    if ($query) {
        echo "Company deleted successfully!<br><br>";
        echo "<a href='../index.php'>Return Home</a>";
    } else {
        echo "Failed to delete company!";
    }
}


// Handle form submission for adding a new car model
if (isset($_POST["addModelBtn"])) {
    $company_id = $_POST['company_id'];
    $query = insertModel($pdo, $_POST['model_name'], $_POST['year'], $_POST['price'], $company_id);
    if ($query) {
        echo "Model added successfully!<br><br>";
        echo '<a href="../viewmodels.php?company_id=' . urlencode($company_id) . '">Return to View Models</a>';
    } else {
        echo "Failed to add model!";
    }
}

// Handle form submission for editing an existing car model
if (isset($_POST['editModelBtn'])) {
    $model_id = $_GET['model_id'];
    $company_id = $_POST['company_id'];
    $query = updateModel($pdo, $model_id, $_POST['model_name'], $_POST['year'], $_POST['price'], $company_id); // Include company_id here
    if ($query) {
        echo 'Model updated successfully!<br><br>';
        echo '<a href="../viewmodels.php?company_id=' . urlencode($company_id) . '">Return to View Models</a>';
    } else {
        echo 'Failed to update model!';
    }
}


// Handle form submission for deleting a car model
if (isset($_POST['deleteModelBtn'])) {
    $model_id = $_POST['model_id'];
    $company_id = $_POST['company_id']; // This will now be defined
    $query = deleteModel($pdo, $model_id);

    if ($query) {
        echo 'Model deleted successfully!<br><br>';
        echo '<a href="../viewmodels.php?company_id=' . urlencode($company_id) . '">Return to View Models</a>';
    } else {
        echo 'Failed to delete model!';
    }
}


// Check if model_id is set in the URL
if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];

    // Fetch the model details based on model_id
    $model = getModelById($pdo, $model_id); // Ensure this function is defined

    if (!$model) {
        echo "<h3>Model not found!</h3>";
        exit;
    }

    // Debugging: Check if 'company_id' is set
    if (!isset($model['company_id'])) {
        echo "<h3>Company ID not found in the model!</h3>";
        exit;
    }
} else {
    exit;
}


?>