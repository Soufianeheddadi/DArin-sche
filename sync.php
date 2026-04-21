<?php
/**
 * sync.php — Self-hosted schedule sync API (replaces JSONBin)
 *
 * GET  sync.php?bin={id}  → read stored JSON    (public, no key needed)
 * POST sync.php           → create a new bin    (requires X-Master-Key)
 * PUT  sync.php?bin={id}  → update existing bin (requires X-Master-Key)
 *
 * SETUP: Change SYNC_API_KEY below to any strong secret string.
 *        Use the same string as the "Sync API Key" in the admin panel.
 */

// ── Security headers ──────────────────────────────────────────────────────────
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: same-origin');

// CORS — needed when admin and agent pages are on the same origin
$allowedOrigin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
header('Access-Control-Allow-Origin: ' . ($allowedOrigin ?: '*'));
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Master-Key, X-Bin-Meta');
header('Content-Type: application/json; charset=utf-8');

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ── Configuration — CHANGE BEFORE DEPLOYING ───────────────────────────────────
define('SYNC_API_KEY',  'CHANGE_THIS_TO_A_STRONG_SECRET');
define('DATA_DIR',      __DIR__ . '/sync_data/');
define('MAX_BODY_BYTES', 2 * 1024 * 1024); // 2 MB limit per save

// ── Routing ───────────────────────────────────────────────────────────────────
$method = $_SERVER['REQUEST_METHOD'];

// Sanitise bin ID — only hex, letters, digits, dash, underscore are allowed
$binId = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['bin'] ?? '');

// Ensure the data directory exists
if (!is_dir(DATA_DIR)) {
    if (!mkdir(DATA_DIR, 0750, true)) {
        http_response_code(500);
        echo json_encode(['error' => 'Storage directory could not be created']);
        exit;
    }
}

switch ($method) {

    // ── READ ──────────────────────────────────────────────────────────────────
    case 'GET':
        if (!$binId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing bin ID']);
            exit;
        }
        $file = DATA_DIR . $binId . '.json';
        if (!file_exists($file)) {
            http_response_code(404);
            echo json_encode(['error' => 'Bin not found']);
            exit;
        }
        header('Cache-Control: no-store');
        readfile($file);
        break;

    // ── CREATE ────────────────────────────────────────────────────────────────
    case 'POST':
        authCheck();
        $body = readBody();
        $id   = bin2hex(random_bytes(12)); // 24-char hex ID, unique per bin
        file_put_contents(DATA_DIR . $id . '.json', $body, LOCK_EX);
        echo json_encode([
            'record'   => json_decode($body, true),
            'metadata' => ['id' => $id, 'createdAt' => gmdate('c')]
        ]);
        break;

    // ── UPDATE ────────────────────────────────────────────────────────────────
    case 'PUT':
        authCheck();
        if (!$binId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing bin ID']);
            exit;
        }
        $file = DATA_DIR . $binId . '.json';
        if (!file_exists($file)) {
            http_response_code(404);
            echo json_encode(['error' => 'Bin not found']);
            exit;
        }
        $body = readBody();
        file_put_contents($file, $body, LOCK_EX);
        echo json_encode([
            'record'   => json_decode($body, true),
            'metadata' => ['id' => $binId, 'updatedAt' => gmdate('c')]
        ]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}

// ── Helper functions ──────────────────────────────────────────────────────────

function authCheck() {
    $key = $_SERVER['HTTP_X_MASTER_KEY'] ?? '';
    if ($key === '' || $key === 'CHANGE_THIS_TO_A_STRONG_SECRET' || $key !== SYNC_API_KEY) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized — set your Sync API Key first']);
        exit;
    }
}

function readBody() {
    $body = file_get_contents('php://input', false, null, 0, MAX_BODY_BYTES + 1);
    if (strlen($body) > MAX_BODY_BYTES) {
        http_response_code(413);
        echo json_encode(['error' => 'Payload too large (max 2 MB)']);
        exit;
    }
    if (json_decode($body) === null) {
        http_response_code(400);
        echo json_encode(['error' => 'Request body must be valid JSON']);
        exit;
    }
    return $body;
}
