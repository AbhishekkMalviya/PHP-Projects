<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
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
                <a class="nav-link active" href="products.php">Products</a>
                <a class="nav-link" href="categories.php">Categories</a>
                <a class="nav-link" href="orders.php">Orders</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-box"></i> Product Management</h2>
                    <a href="products.php?action=create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Products</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="products.php">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Search by Name</label>
                                    <input type="text" name="search" class="form-control" 
                                           value="<?php echo $_GET['search'] ?? ''; ?>" 
                                           placeholder="Product name...">
                                </div>
                                <div class="col-md-3">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">All Categories</option>
                                        <?php
                                        $categories = getCategories($pdo);
                                        foreach ($categories as $category) {
                                            $selected = ($_GET['category_id'] ?? '') == $category['id'] ? 'selected' : '';
                                            echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Price Range</label>
                                    <select name="price_range" class="form-control">
                                        <option value="">Any Price</option>
                                        <option value="0-50" <?php echo ($_GET['price_range'] ?? '') == '0-50' ? 'selected' : ''; ?>>$0 - $50</option>
                                        <option value="50-100" <?php echo ($_GET['price_range'] ?? '') == '50-100' ? 'selected' : ''; ?>>$50 - $100</option>
                                        <option value="100-500" <?php echo ($_GET['price_range'] ?? '') == '100-500' ? 'selected' : ''; ?>>$100 - $500</option>
                                        <option value="500+" <?php echo ($_GET['price_range'] ?? '') == '500+' ? 'selected' : ''; ?>>$500+</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Stock Status</label>
                                    <select name="stock_status" class="form-control">
                                        <option value="">Any Stock</option>
                                        <option value="in_stock" <?php echo ($_GET['stock_status'] ?? '') == 'in_stock' ? 'selected' : ''; ?>>In Stock</option>
                                        <option value="out_of_stock" <?php echo ($_GET['stock_status'] ?? '') == 'out_of_stock' ? 'selected' : ''; ?>>Out of Stock</option>
                                        <option value="low_stock" <?php echo ($_GET['stock_status'] ?? '') == 'low_stock' ? 'selected' : ''; ?>>Low Stock (< 10)</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="active" <?php echo ($_GET['status'] ?? '') == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($_GET['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Apply Filters
                                    </button>
                                    <a href="products.php" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Clear Filters
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card">
                    <div class="card-body">
                        <?php
                        // Build query with filters
                        $sql = "SELECT p.*, c.name as category_name FROM products p 
                                LEFT JOIN categories c ON p.category_id = c.id 
                                WHERE 1=1";
                        $params = [];

                        if (!empty($_GET['search'])) {
                            $sql .= " AND p.name LIKE ?";
                            $params[] = '%' . $_GET['search'] . '%';
                        }

                        if (!empty($_GET['category_id'])) {
                            $sql .= " AND p.category_id = ?";
                            $params[] = $_GET['category_id'];
                        }

                        if (!empty($_GET['price_range'])) {
                            if ($_GET['price_range'] == '0-50') {
                                $sql .= " AND p.price BETWEEN 0 AND 50";
                            } elseif ($_GET['price_range'] == '50-100') {
                                $sql .= " AND p.price BETWEEN 50 AND 100";
                            } elseif ($_GET['price_range'] == '100-500') {
                                $sql .= " AND p.price BETWEEN 100 AND 500";
                            } elseif ($_GET['price_range'] == '500+') {
                                $sql .= " AND p.price >= 500";
                            }
                        }

                        if (!empty($_GET['stock_status'])) {
                            if ($_GET['stock_status'] == 'in_stock') {
                                $sql .= " AND p.stock_quantity > 0";
                            } elseif ($_GET['stock_status'] == 'out_of_stock') {
                                $sql .= " AND p.stock_quantity = 0";
                            } elseif ($_GET['stock_status'] == 'low_stock') {
                                $sql .= " AND p.stock_quantity < 10 AND p.stock_quantity > 0";
                            }
                        }

                        if (!empty($_GET['status'])) {
                            $sql .= " AND p.status = ?";
                            $params[] = $_GET['status'];
                        }

                        $sql .= " ORDER BY p.created_at DESC";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($params);
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($products)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No products found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?php echo $product['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                                    <?php if (!empty($product['description'])): ?>
                                                        <br><small class="text-muted"><?php echo substr($product['description'], 0, 50); ?>...</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($product['category_name']): ?>
                                                        <span class="badge bg-info"><?php echo $product['category_name']; ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Uncategorized</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                                <td>
                                                    <?php if ($product['stock_quantity'] > 10): ?>
                                                        <span class="badge bg-success"><?php echo $product['stock_quantity']; ?> in stock</span>
                                                    <?php elseif ($product['stock_quantity'] > 0): ?>
                                                        <span class="badge bg-warning">Low stock (<?php echo $product['stock_quantity']; ?>)</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Out of stock</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?php echo $product['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst($product['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="products.php?action=edit&id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="products.php?action=delete&id=<?php echo $product['id']; ?>" 
                                                       class="btn btn-danger btn-sm" 
                                                       onclick="return confirm('Are you sure you want to delete this product?')">
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