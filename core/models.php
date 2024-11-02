<?php

require_once 'dbConfig.php';

// Function to insert a new car company into the database
function insertCompany($pdo, $company_name, $country, $founded_year, $user_id)
{
    $sql = "INSERT INTO CarCompany (company_name, country, founded_year, user_id, last_updated) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(array($company_name, $country, $founded_year, $user_id));
    return $executeQuery; // Return true if successful
}

// Function to show all car companies
function getAllCompanies($pdo)
{
    $sql = "SELECT CarCompany.*, Users.username AS added_by, CarCompany.last_updated 
            FROM CarCompany 
            LEFT JOIN Users ON CarCompany.user_id = Users.user_id"; // Assuming user_id is used to relate
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();
    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}



// Function to get all car models with company names
function getAllModels($pdo)
{
    $sql = "SELECT 
                CarModel.model_id AS model_id,
                CarModel.model_name AS model_name,
                CarModel.year AS year,
                CarModel.price AS price,
                CarCompany.company_name AS company_name
            FROM CarModel
            JOIN CarCompany ON CarModel.company_id = CarCompany.company_id
            ORDER BY CarModel.model_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function to get a car company by ID 
function getCompanyByID($pdo, $company_id)
{
    $sql = "SELECT * FROM CarCompany WHERE company_id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(array($company_id))) {
        return $stmt->fetch();
    } else {
        return false;
    }
}

function getModelsByCompanyID($pdo, $company_id)
{
    $sql = "SELECT * FROM CarModel WHERE company_id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(array($company_id))) {
        return $stmt->fetchAll();
    } else {
        return false;
    }
}


// Function to update a car company in the database
function updateCompany($pdo, $company_id, $company_name, $country, $founded_year)
{
    $sql = "UPDATE CarCompany SET company_name = ?, country = ?, founded_year = ?, last_updated = CURRENT_TIMESTAMP WHERE company_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(array($company_name, $country, $founded_year, $company_id));
    return $executeQuery; // Return true if successful
}

// Function to delete a car company from the database
function deleteCompany($pdo, $company_id)
{
    $sql = "DELETE FROM CarCompany WHERE company_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(array($company_id));
    return $executeQuery;
}

// Function to show all car models for a specific company
function getModelsByCompany($pdo, $company_id)
{
    $sql = "SELECT 
        CarModel.model_id AS model_id,
        CarModel.model_name AS model_name,
        CarModel.year AS year,
        CarModel.price AS price,
        CarCompany.company_name AS company_name
    FROM CarModel
    JOIN CarCompany ON CarModel.company_id = CarCompany.company_id
    WHERE CarCompany.company_id = ?
    GROUP BY CarModel.model_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$company_id]);
    return $stmt->fetchAll();
}

// Function to insert a new car model for a company
function insertModel($pdo, $model_name, $year, $price, $company_id)
{
    $sql = "INSERT INTO CarModel (model_name, year, price, company_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(array($model_name, $year, $price, $company_id));
    if ($executeQuery) {
        return true;
    }
    return false;
}

// Function to get a specific car model by ID
function getModelById($pdo, $model_id)
{
    $sql = "SELECT * FROM CarModel WHERE model_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$model_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC); // This should return an associative array
}


// Function to update a car model in the database
function updateModel($pdo, $model_id, $model_name, $year, $price, $company_id)
{
    $sql = "UPDATE CarModel SET model_name = ?, year = ?, price = ?, company_id = ? WHERE model_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(array($model_name, $year, $price, $company_id, $model_id)); // Updated to include company_id
    return $executeQuery;
}

// Function to delete a car model from the database
function deleteModel($pdo, $model_id)
{
    $sql = "DELETE FROM CarModel WHERE model_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(array($model_id));
    return $executeQuery;
}
