<?php
session_start();
include_once "config.php";

if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    $results = [];

    // Търсене в таблиците
    $tables = [
        'bulgaria' => 'bulgaria',
        'business' => 'business',
        'entertainment' => 'entertainments',
        'sport' => 'sport'
    ];

    foreach ($tables as $type => $table) {
        // Общ случай за таблиците
        $id_column = $type . '_id';
        $title_column = $type . '_post_title';
        $description_column = $type . '_post_description';
        $date_column = 'date_published';
        $category_column = 'category_id';

        $query = "SELECT '$type' AS type, $id_column AS id, $title_column AS post_title, $description_column AS post_description, $date_column, $category_column 
                  FROM $table 
                  WHERE $title_column LIKE '%$searchTerm%' 
                  OR $description_column LIKE '%$searchTerm%' 
                  OR $date_column LIKE '%$searchTerm%'";

        $result = mysqli_query($conn, $query);
        if (!$result) {
            die('SQL Error: ' . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }
    }

    $_SESSION['search_results'] = $results;
    $_SESSION['search_term'] = $searchTerm;

    header('Location: search-results.php');
    exit();
}
?>
