<?php
/**
 * B2C Player API - PHP Example
 * 
 * This example demonstrates how to use the B2C Player API with PHP.
 * 
 * Usage:
 *   1. Update the $baseUrl variable with your actual API endpoint
 *   2. Replace 'your_username' and 'your_password' with your credentials
 *   3. Run: php php_example.php
 */

$baseUrl = 'https://api.example.com/play/b2c/v1';

// Authenticate
function authenticate($username, $password) {
    global $baseUrl;
    $ch = curl_init($baseUrl . '/auth');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'username' => $username,
        'password' => $password
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    return $data['auth_token'];
}

// Get VOD content
function getVodContent($token, $options = []) {
    global $baseUrl;
    $params = [];
    if (isset($options['with_links']) && $options['with_links'] === false) {
        $params['with_links'] = 0;
    }
    if (isset($options['updated_at_gt'])) {
        $params['updated_at_gt'] = $options['updated_at_gt'];
    }
    if (isset($options['bkey'])) {
        $params['bkey'] = $options['bkey'];
    }
    if (isset($options['page'])) {
        $params['page'] = $options['page'];
    }
    if (isset($options['per_page'])) {
        $params['per_page'] = $options['per_page'];
    }
    
    $url = $baseUrl . '/content/vod';
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get live content
function getLiveContent($token, $options = []) {
    global $baseUrl;
    $params = [];
    if (isset($options['with_links']) && $options['with_links'] === false) {
        $params['with_links'] = 0;
    }
    if (isset($options['updated_at_gt'])) {
        $params['updated_at_gt'] = $options['updated_at_gt'];
    }
    if (isset($options['bkey'])) {
        $params['bkey'] = $options['bkey'];
    }
    if (isset($options['page'])) {
        $params['page'] = $options['page'];
    }
    if (isset($options['per_page'])) {
        $params['per_page'] = $options['per_page'];
    }
    
    $url = $baseUrl . '/content/live';
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get series content
function getSeriesContent($token, $options = []) {
    global $baseUrl;
    $params = [];
    if (isset($options['with_links']) && $options['with_links'] === false) {
        $params['with_links'] = 0;
    }
    if (isset($options['updated_at_gt'])) {
        $params['updated_at_gt'] = $options['updated_at_gt'];
    }
    if (isset($options['bkey'])) {
        $params['bkey'] = $options['bkey'];
    }
    if (isset($options['page'])) {
        $params['page'] = $options['page'];
    }
    if (isset($options['per_page'])) {
        $params['per_page'] = $options['per_page'];
    }
    
    $url = $baseUrl . '/content/series';
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get VOD by ID
function getVodById($token, $streamId) {
    global $baseUrl;
    $ch = curl_init($baseUrl . '/content/vod/' . $streamId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get series by ID
function getSeriesById($token, $seriesId) {
    global $baseUrl;
    $ch = curl_init($baseUrl . '/content/series/' . $seriesId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get content hashes
function getContentHashes($token) {
    global $baseUrl;
    $ch = curl_init($baseUrl . '/content-info/hashes');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get play links for a stream
function getStreamLinks($token, $streamId) {
    global $baseUrl;
    $ch = curl_init($baseUrl . '/links/' . $streamId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get notifications
function getNotifications($token) {
    global $baseUrl;
    $ch = curl_init($baseUrl . '/notifications');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Example usage
$token = authenticate('your_username', 'your_password');

// Get content hashes
$hashes = getContentHashes($token);
echo "Movies hash: " . $hashes['content']['movies_hash'] . "\n";
echo "Bouquet key: " . $hashes['content']['bouquets_key'] . "\n";

// Get VOD content (feed mode - no links)
$bkey = $hashes['content']['bouquets_key'];
$vodContent = getVodContent($token, [
    'with_links' => false,
    'bkey' => $bkey,
    'per_page' => 10
]);
echo "Total movies: " . $vodContent['pagination']['total_items'] . "\n";

// Get updated content only
$yesterday = date('Y-m-d\TH:i:s\Z', strtotime('-1 day'));
$updatedVod = getVodContent($token, [
    'with_links' => false,
    'updated_at_gt' => $yesterday,
    'bkey' => $bkey
]);
echo "Updated movies: " . $updatedVod['pagination']['total_items'] . "\n";

// Get play links for a specific movie
if (!empty($vodContent['content'])) {
    $movie = $vodContent['content'][0];
    echo "Fetching play links for: " . $movie['name'] . "\n";
    $links = getStreamLinks($token, $movie['stream_id']);
    echo "Play link: " . ($links['links']['mp4'] ?? 'N/A') . "\n";
}

// Get series content
$series = getSeriesContent($token, ['per_page' => 5]);
echo "Total series: " . $series['pagination']['total_items'] . "\n";
?>

