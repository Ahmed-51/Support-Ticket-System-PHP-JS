<?php
require __DIR__ . '/../config.php';

// Read filter & search inputs
$filter = isset($_GET['status']) && in_array($_GET['status'], ['open','closed'])
    ? $_GET['status'] : null;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

// Pagination setup
$limit  = 10;
$page   = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
            ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Build WHERE clause
$where  = [];
$params = [];
if ($filter) {
    $where[]  = 'status = ?';
    $params[] = $filter;
}
if ($search !== '') {
    $where[]  = '(id = ? OR name LIKE ? OR email LIKE ? OR message LIKE ?)';
    $like      = "%{$search}%";
    $params[]  = $search;
    $params[]  = $like;
    $params[]  = $like;
    $params[]  = $like;
}
$whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';

// Total count
$countSql  = "SELECT COUNT(*) FROM tickets{$whereSql}";
$countStmt = $db->prepare($countSql);
$countStmt->execute($params);
$total     = $countStmt->fetchColumn();
$totalPages = ceil($total / $limit);

// Fetch current page
$dataSql = "SELECT * FROM tickets{$whereSql}
            ORDER BY created_at DESC
            LIMIT {$limit} OFFSET {$offset}";
$stmt    = $db->prepare($dataSql);
$stmt->execute($params);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin – Tickets</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <nav class="bg-blue-600">
    <div class="container mx-auto px-6 py-3">
      <span class="text-xl font-semibold text-white">Admin Dashboard</span>
    </div>
  </nav>

  <div class="container mx-auto px-6 py-8">
    <!-- Search & Filter UI -->
    <div class="mb-6 flex items-center justify-between bg-white p-3 rounded shadow">
      <form method="GET" class="flex items-center space-x-3">
        <label for="status-filter" class="text-gray-500 font-normal">Status</label>
        <select id="status-filter" name="status" onchange="this.form.submit()"
                class="px-2 border rounded-md">
          <option value="" <?= $filter===null ? 'selected' : '' ?>>All</option>
          <option value="open" <?= $filter==='open' ? 'selected' : '' ?>>Open</option>
          <option value="closed" <?= $filter==='closed' ? 'selected' : '' ?>>Closed</option>
        </select>

        <input
          type="text" name="q" placeholder="Search tickets…"
          value="<?= htmlspecialchars($search) ?>"
          class="px-3 py-1 border rounded shadow-sm"
        >
        <button type="submit"
          class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
          Search
        </button>
      </form>
      <a href="index.php" class="text-blue-600 hover:underline font-medium">Clear All</a>
    </div>

    <!-- Bulk Actions + Table + Pagination -->
    <form id="bulkForm" method="POST" action="bulk_action.php">
      <div class="mb-4 space-x-2">
      <button type="button" id="select-all-btn"
      class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Select All</button>
        <button type="submit" name="action" value="close"
          class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-700">
          Close Selected
        </button>
        <button type="submit" name="action" value="delete"
          class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
          Delete Selected
        </button>
      </div>

      <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Select</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($tickets as $t): ?>
            <tr data-id="<?= $t['id'] ?>"
                data-name="<?= htmlspecialchars($t['name']) ?>"
                data-email="<?= htmlspecialchars($t['email']) ?>"
                data-message="<?= htmlspecialchars($t['message']) ?>"
                data-created="<?= htmlspecialchars($t['created_at']) ?>">
              <td class="px-6"><input type="checkbox" class="row-checkbox" name="ids[]" value="<?= $t['id'] ?>" /></td>
              <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($t['id']) ?></td>
              <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($t['name']) ?></td>
              <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($t['email']) ?></td>
        <!-- <td class="px-6 py-4 text-sm text-gray-900 max-w-xs whitespace-normal break-words truncate">
              <?= htmlspecialchars($t['message']) ?>
            </td> -->
              <td 
                class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate"
                title="<?= htmlspecialchars($t['message']) ?>"
              >
                <?= htmlspecialchars($t['message']) ?>
              </td>
              <td class="px-6 py-4">
                <span class="px-2 inline-flex text-xs font-semibold rounded-full <?= $t['status']==='open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                  <?= htmlspecialchars($t['status']) ?>
                </span>
              </td>
              <td class="px-6 py-4 text-right text-sm font-medium">
                <button type="button" class="detail-btn text-blue-600 hover:text-blue-800">Details</button>
                <button class="toggle-btn text-indigo-600 hover:text-indigo-900 ml-2">Toggle</button>
                <button class="delete-btn text-red-500 hover:text-red-700 ml-2">Delete</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-4 flex justify-center space-x-2">
        <?php if ($page > 1): ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page-1])) ?>"
             class="px-3 py-1 bg-white border rounded">Prev</a>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $p])) ?>"
             class="px-3 py-1 rounded <?= $p==$page ? 'bg-blue-600 text-white' : 'bg-white border text-gray-700' ?>">
            <?= $p ?>
          </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page+1])) ?>"
             class="px-3 py-1 bg-white border rounded">Next</a>
        <?php endif; ?>
      </div>
    </form>

    <!-- Details Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white rounded-lg overflow-hidden w-1/2">
        <div class="p-4 border-b flex justify-between items-center">
          <h3 class="text-lg font-semibold">Ticket Details</h3>
          <button id="modalClose" class="text-gray-500 hover:text-gray-800">✕</button>
        </div>
        <div class="p-4 space-y-2" id="modalContent">
          <!-- populated by JS -->
        </div>
      </div>
    </div>

  </div>

  <script src="../js/admin.js"></script>
</body>
</html>
