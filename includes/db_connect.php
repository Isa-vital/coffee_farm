<?php

/**
 * Database Connection - PDO with Prepared Statements
 * Kiihabwemi Development Company Ltd
 */

require_once __DIR__ . '/../config/config.php';

try {
    // Build DSN with port if defined
    $dsn = "mysql:host=" . DB_HOST;
    if (defined('DB_PORT')) {
        $dsn .= ";port=" . DB_PORT;
    }
    $dsn .= ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_PERSISTENT         => false,
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Log error securely (don't expose to users)
    error_log("Database Connection Error: " . $e->getMessage());

    // Display generic error to user
    die("We're experiencing technical difficulties. Please try again later.");
}

/**
 * Execute a prepared query
 * 
 * @param PDO $pdo Database connection
 * @param string $sql SQL query with placeholders
 * @param array $params Parameters to bind
 * @return PDOStatement
 */
function executeQuery($pdo, $sql, $params = [])
{
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Query Error: " . $e->getMessage());
        throw $e;
    }
}

/**
 * Fetch all rows from query
 */
function fetchAll($pdo, $sql, $params = [])
{
    $stmt = executeQuery($pdo, $sql, $params);
    return $stmt->fetchAll();
}

/**
 * Fetch single row from query
 */
function fetchOne($pdo, $sql, $params = [])
{
    $stmt = executeQuery($pdo, $sql, $params);
    return $stmt->fetch();
}

/**
 * Get last insert ID
 */
function getLastInsertId($pdo)
{
    return $pdo->lastInsertId();
}
