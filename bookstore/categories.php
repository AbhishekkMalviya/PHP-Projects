<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Management</title>
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
                <a class="nav-link active" href="categories.php">Categories</a>
                <a class="nav-link" href="orders.php">Orders</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-tags"></i> Category Management</h2>
                    <a href="categories.php?action=create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Category
                    </a>
                </div>

                <!-- Categories Grid -->
                <div class="row">
                    <?php
                    $categories = getCategories($pdo);
                    foreach ($categories as $category):
                        $productCount = $pdo->query("SELECT COUNT(*) FROM products WHERE category_id = {$category['id']}")->fetchColumn();
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                                <?php if (!empty($category['description'])): ?>
                                    <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                                <?php endif; ?>
                                <p class="text-muted"><?php echo $productCount; ?> products</p>
                            </div>
                            <div class="card-footer">
                                <a href="categories.php?action=edit&id=<?php echo $category['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="categories.php?action=delete&id=<?php echo $category['id']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure? This will also delete all products in this category.')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>