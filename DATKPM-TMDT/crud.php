<?php
require_once 'Product_Database.php'; // Đường dẫn tới file chứa class Product_Database

// Khởi tạo đối tượng Product_Database
$productDB = new Product_Database();

// Xử lý thêm sản phẩm khi form được gửi
$success_message = '';
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = $_POST['name'];
	$price = $_POST['price'];
	$category_id = $_POST['category_id'];
	$stock = $_POST['stock'];
	$description = $_POST['description'];
	$image_url = $_POST['image_url'];

	// Gọi phương thức addProduct với các tham số
	if ($productDB->addProduct($name, $price, $category_id, $description, $stock, $image_url)) {
		$success_message = "Product added successfully!";
	} else {
		$error_message = "Error adding product.";
	}
}

// Lấy tất cả sản phẩm (sẽ tự động cập nhật sau khi thêm)
$products = $productDB->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Shop Item - Start Bootstrap Template</title>
	<!-- Favicon-->
	<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
	<!-- Bootstrap icons-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
	<!-- Core theme CSS (includes Bootstrap)-->
	<link href="public/css/styles1.css" rel="stylesheet" />
</head>

<body>
	<!-- Navigation-->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container px-4 px-lg-5">
			<a class="navbar-brand" href="#!">TPV E-COMMERCE</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
				data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
				aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
					<li class="nav-item"><a class="nav-link active" aria-current="page" href="home1.php">Home</a></li>
				</ul>
				<form class="d-flex">
					<button class="btn btn-outline-dark" type="submit">
						<i class="bi-cart-fill me-1"></i>
						Cart
						<span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
					</button>
				</form>
			</div>
		</div>
	</nav>
	<!-- Product section-->
	<section class="py-5">
		<div class="container px-4 px-lg-5 my-5">
			<div class="row gx-4 gx-lg-5 align-items-center">
				<div class="table-wrapper">
					<div class="table-title">
						<div class="row">
							<div class="col-sm-6">
								<h2>Manage <b>Product</b></h2>
							</div>
							<div class="col-sm-6">
								<a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
										class="bi bi-pencil"></i><span>Add New Product</span></a>
							</div>
						</div>
					</div>
					<?php if (!empty($success_message)): ?>
						<div class="alert alert-success"><?php echo $success_message; ?></div>
					<?php endif; ?>
					<?php if (!empty($error_message)): ?>
						<div class="alert alert-danger"><?php echo $error_message; ?></div>
					<?php endif; ?>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>
									<span class="custom-checkbox">
										<input type="checkbox" id="selectAll">
										<label for="selectAll"></label>
									</span>
								</th>
								<th>ProductID</th>
								<th>ProductName</th>
								<th>CategoryID</th>
								<th>Price</th>
								<th>Stock</th>
								<th>Description</th>
								<th>ImageURL</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($products)): ?>
								<?php foreach ($products as $index => $product): ?>
									<tr>
										<td>
											<span class="custom-checkbox">
												<input type="checkbox" id="checkbox<?php echo $index + 1; ?>" name="options[]"
													value="<?php echo $product['ProductID']; ?>">
												<label for="checkbox<?php echo $index + 1; ?>"></label>
											</span>
										</td>
										<td><?php echo htmlspecialchars($product['ProductID']); ?></td>
										<td><?php echo htmlspecialchars($product['ProductName']); ?></td>
										<td><?php echo htmlspecialchars($product['CategoryID']); ?></td>
										<td><?php echo htmlspecialchars($product['Price']); ?></td>
										<td><?php echo htmlspecialchars($product['Stock'] ?? 'N/A'); ?></td>
										<td><?php echo htmlspecialchars($product['Description']); ?></td>
										<td><?php echo htmlspecialchars($product['ImageURL'] ?? 'N/A'); ?></td>
										<td>
											<a data-bs-target="#editEmployeeModal" class="edit" data-bs-toggle="modal"><i
													class="bi bi-pencil"></i></a>
											<a data-bs-target="#deleteEmployeeModal" class="delete" data-bs-toggle="modal"><i
													class="bi bi-trash"></i></a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="9">No products found.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
					<div class="clearfix">
						<div class="hint-text">Showing <b><?php echo count($products); ?></b> out of
							<b><?php echo count($products); ?></b> entries</div>
						<ul class="pagination">
							<li class="page-item"><a href="#" class="page-link">Previous</a></li>
							<li class="page-item active"><a href="#" class="page-link">1</a></li>
							<li class="page-item"><a href="#" class="page-link">Next</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Add Modal HTML -->
	<div id="addEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="POST" action="crud.php">
					<div class="modal-header">
						<h4 class="modal-title">Add Product</h4>
						<button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>ProductName</label>
							<input type="text" name="name" class="form-control" required>
						</div>
						<div class="form-group">
							<label>CategoryID</label>
							<input type="number" name="category_id" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Price</label>
							<input type="number" step="0.01" name="price" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Stock</label>
							<input type="number" name="stock" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Description</label>
							<input type="text" name="description" class="form-control" required>
						</div>
						<div class="form-group">
							<label>ImageURL</label>
							<input type="text" name="image_url" class="form-control" required>
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Footer-->
	<footer class="py-5 bg-dark">
		<div class="container">
			<p class="m-0 text-center text-white">Shrimp © TPV E-COMMERCE 2025</p>
		</div>
	</footer>
	<!-- Bootstrap core JS-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Core theme JS-->
	<script src="js/scripts.js"></script>
</body>

</html>