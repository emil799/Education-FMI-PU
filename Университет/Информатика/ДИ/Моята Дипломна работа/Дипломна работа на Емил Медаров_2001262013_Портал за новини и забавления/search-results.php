<?php
session_start();
include_once "config.php";

$results = isset($_SESSION['search_results']) ? $_SESSION['search_results'] : [];
$searchTerm = isset($_SESSION['search_term']) ? $_SESSION['search_term'] : '';

$redirectUrl = null;

if (!empty($results)) {
    foreach ($results as $result) {
        if (in_array($result['type'], ['bulgaria', 'business', 'entertainments', 'sport'])) {
            $redirectUrl = generatePostLink($result['category_id'], $result['id']);
            break;
        }
    }
}

unset($_SESSION['search_results']);
unset($_SESSION['search_term']);

if ($redirectUrl) {
    // Приложете url encoding само към searchTerm
    $encodedSearchTerm = urlencode($searchTerm);
    header('Location: ' . $redirectUrl . '?searchTerm=' . $encodedSearchTerm);
    exit();
}

function generatePostLink($category_id, $post_id) {
    $category_pages = [
        1 => 'bulgaria.php',
        2 => 'business.php',
        3 => 'entertainment.php',
        4 => 'sport.php'
    ];
    return isset($category_pages[$category_id]) ? $category_pages[$category_id] . '?post_id=' . $post_id : '#';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="image/png" href="ïmages/icon-for-the-portal.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="32x32">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon-for-the-portal.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon-for-the-portal.png">
    <link rel="stylesheet" href="style.css">
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    <?php if (empty($results)): ?>
        <p>No results found.</p>
    <?php else: ?>
        <?php foreach ($results as $result): ?>
            <div id="result-<?php echo htmlspecialchars($result['id']); ?>" class="result-item">
                <h3><?php echo htmlspecialchars($result['post_title']); ?></h3>
                <p><?php echo htmlspecialchars($result['post_description']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
