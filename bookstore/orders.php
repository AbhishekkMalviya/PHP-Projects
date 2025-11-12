<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-store"></i> Product Manager
            </a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Dashboard</a>
                <a class="nav-link" href="products.php">Products</a>
                <a class="nav-link" href="categories.php">Categories</a>
                <a class="nav-link active" href="orders.php">Orders</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-shopping-cart"></i> Order Management</h2>
                    <a href="orders.php?action=create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Order
                    </a>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Orders</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="orders.php">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Search by Customer</label>
                                    <input type="text" name="search" class="form-control" 
                                           value="<?php echo $_GET['search'] ?? ''; ?>" 
                                           placeholder="Customer name or email...">
                                </div>
                                <div class="col-md-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="pending" <?php echo ($_GET['status'] ?? '') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="completed" <?php echo ($_GET['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                        <option value="cancelled" <?php echo ($_GET['status'] ?? '') == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Range</label>
                                    <select name="date_range" class="form-control">
                                        <option value="">All Time</option>
                                        <option value="today" <?php echo ($_GET['date_range'] ?? '') == 'today' ? 'selected' : ''; ?>>Today</option>
                                        <option value="week" <?php echo ($_GET['date_range'] ?? '') == 'week' ? 'selected' : ''; ?>>This Week</option>
                                        <option value="month" <?php echo ($_GET['date_range'] ?? '') == 'month' ? 'selected' : ''; ?>>This Month</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Amount Range</label>
                                    <select name="amount_range" class="form-control">
                                        <option value="">Any Amount</option>
                                        <option value="0-100" <?php echo ($_GET['amount_range'] ?? '') == '0-100' ? 'selected' : ''; ?>>$0 - $100</option>
                                        <option value="100-500" <?php echo ($_GET['amount_range'] ?? '') == '100-500' ? 'selected' : ''; ?>>$100 - $500</option>
                                        <option value="500+" <?php echo ($_GET['amount_range'] ?? '') == '500+' ? 'selected' : ''; ?>>$500+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Apply Filters
                                    </button>
                                    <a href="orders.php" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Clear Filters
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="card">
                    <div class="card-body">
                        <?php
                        // Build query with filters
                        $sql = "SELECT * FROM orders WHERE 1=1";
                        $params = [];

                        if (!empty($_GET['search'])) {
                            $sql .= " AND (customer_name LIKE ? OR customer_email LIKE ?)";
                            $params[] = '%' . $_GET['search'] . '%';
                            $params[] = '%' . $_GET['search'] . '%';
                        }

                        if (!empty($_GET['status'])) {
                            $sql .= " AND status = ?";
                            $params[] = $_GET['status'];
                        }

                        if (!empty($_GET['date_range'])) {
                            $today = date('Y-m-d');
                            if ($_GET['date_range'] == 'today') {
                                $sql .= " AND DATE(order_date) = ?";
                                $params[] = $today;
                            } elseif ($_GET['date_range'] == 'week') {
                                $sql .= " AND order_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                            } elseif ($_GET['date_range'] == 'month') {
                                $sql .= " AND order_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
                            }
                        }

                        if (!empty($_GET['amount_range'])) {
                            if ($_GET['amount_range'] == '0-100') {
                                $sql .= " AND total_amount BETWEEN 0 AND 100";
                            } elseif ($_GET['amount_range'] == '100-500') {
                                $sql .= " AND total_amount BETWEEN 100 AND 500";
                            } elseif ($_GET['amount_range'] == '500+') {
                                $sql .= " AND total_amount >= 500";
                            }
                        }

                        $sql .= " ORDER BY order_date DESC";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($params);
                        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($orders)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No orders found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td>#<?php echo $order['id']; ?></td>
                                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                                <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                                <td>
                                                    <?php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger'
                                                    ];
                                                    $color = $statusColors[$order['status']] ?? 'secondary';
                                                    ?>
                                                    <span class="badge bg-<?php echo $color; ?>">
                                                        <?php echo ucfirst($order['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M j, Y g:i A', strtotime($order['order_date'])); ?></td>
                                                <td>
                                                    <a href="orders.php?action=view&id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="orders.php?action=edit&id=<?php echo $order['id']; ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="orders.php?action=delete&id=<?php echo $order['id']; ?>" 
                                                       class="btn btn-danger btn-sm" 
                                                       onclick="return confirm('Are you sure you want to delete this order?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>