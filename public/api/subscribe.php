<?php
/**
 * GradMapper — email signup endpoint
 *
 * Upload this file to your Hostinger account at:
 *   public_html/api/subscribe.php
 *
 * 1) In hPanel → Databases → MySQL, run this once to create the table:
 *
 *    CREATE TABLE IF NOT EXISTS subscribers (
 *      id          INT AUTO_INCREMENT PRIMARY KEY,
 *      email       VARCHAR(255) NOT NULL UNIQUE,
 *      audience    VARCHAR(64)  DEFAULT NULL,
 *      source      VARCHAR(64)  DEFAULT NULL,
 *      ip          VARCHAR(45)  DEFAULT NULL,
 *      user_agent  VARCHAR(255) DEFAULT NULL,
 *      created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
 *    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 *
 * 2) Fill in the DB credentials below (from hPanel → Databases).
 */

// === CONFIG ===================================================
$DB_HOST = 'localhost';
$DB_NAME = 'u748207893_gradmapperdb';
$DB_USER = 'REPLACE_WITH_DB_USER';
$DB_PASS = 'REPLACE_WITH_DB_PASSWORD';
// ==============================================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method not allowed']); exit;
}

$raw = file_get_contents('php://input');
$body = json_decode($raw, true);
if (!is_array($body)) $body = $_POST;

$email    = isset($body['email'])    ? trim((string)$body['email'])    : '';
$audience = isset($body['audience']) ? trim((string)$body['audience']) : null;
$source   = isset($body['source'])   ? trim((string)$body['source'])   : null;

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Invalid email']); exit;
}
if ($audience !== null && strlen($audience) > 64) $audience = substr($audience, 0, 64);
if ($source   !== null && strlen($source)   > 64) $source   = substr($source,   0, 64);

try {
  $pdo = new PDO(
    "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
    $DB_USER, $DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );

  $stmt = $pdo->prepare(
    'INSERT INTO subscribers (email, audience, source, ip, user_agent)
     VALUES (:email, :audience, :source, :ip, :ua)
     ON DUPLICATE KEY UPDATE audience = VALUES(audience), source = VALUES(source)'
  );
  $stmt->execute([
    ':email'    => $email,
    ':audience' => $audience,
    ':source'   => $source,
    ':ip'       => $_SERVER['REMOTE_ADDR'] ?? null,
    ':ua'       => isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 255) : null,
  ]);

  echo json_encode(['ok' => true]);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Server error']);
}
