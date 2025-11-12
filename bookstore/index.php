<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-store"></i> Product Manager
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card text-white bg-primary">
                    <div class="card-body text-center">
                        <i class="fas fa-box fa-3x mb-3"></i>
                        <?php
                        $productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
                        ?>
                        <div class="stat-number"><?php echo $productCount; ?></div>
                        <h5>Total Products</h5>
                        <a href="products.php" class="btn btn-light btn-sm mt-2">View Products</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card text-white bg-success">
                    <div class="card-body text-center">
                        <i class="fas fa-tags fa-3x mb-3"></i>
                        <?php
                        $categoryCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
                        ?>
                        <div class="stat-number"><?php echo $categoryCount; ?></div>
                        <h5>Categories</h5>
                        <a href="categories.php" class="btn btn-light btn-sm mt-2">View Categories</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card text-white bg-warning">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <?php
                        $orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
                        ?>
                        <div class="stat-number"><?php echo $orderCount; ?></div>
                        <h5>Total Orders</h5>
                        <a href="orders.php" class="btn btn-light btn-sm mt-2">View Orders</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Quick Actions</h4>
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="products.php?action=create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Product
                            </a>
                            <a href="categories.php?action=create" class="btn btn-success">
                                <i class="fas fa-tag"></i> Add New Category
                            </a>
                            <a href="orders.php?action=create" class="btn btn-warning">
                                <i class="fas fa-cart-plus"></i> Create New Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>