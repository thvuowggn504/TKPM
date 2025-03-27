<?php
require_once 'database.php'; // Kết nối database
require_once 'config.php'; // Cấu hình database

class Product_Database extends Database
{
    // Lấy tất cả sản phẩm
    public function getAllProducts()
    {
        $sql = self::$connection->prepare("SELECT * FROM products");
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $sql = self::$connection->prepare("SELECT * FROM products WHERE ProductID = ?"); // Sửa id thành ProductID
        $sql->bind_param("i", $id);
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }

    // Thêm sản phẩm mới
    public function addProduct($name, $price, $category_id, $description)
    {
        $sql = self::$connection->prepare("INSERT INTO products (ProductName, Price, CategoryID, Description) VALUES (?, ?, ?, ?)"); // Sửa tên cột
        $sql->bind_param("sdis", $name, $price, $category_id, $description);
        return $sql->execute();
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $price, $category_id, $description)
    {
        $sql = self::$connection->prepare("UPDATE products SET ProductName=?, Price=?, CategoryID=?, Description=? WHERE ProductID=?"); // Sửa tên cột
        $sql->bind_param("sdisi", $name, $price, $category_id, $description, $id);
        return $sql->execute();
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $sql = self::$connection->prepare("DELETE FROM products WHERE ProductID=?"); // Sửa id thành ProductID
        $sql->bind_param("i", $id);
        return $sql->execute();
    }

    // Tìm kiếm sản phẩm theo tên
    public function searchProducts($keyword)
    {
        $keyword = "%" . htmlspecialchars(strip_tags($keyword)) . "%";
        $sql = self::$connection->prepare("SELECT * FROM products WHERE ProductName LIKE ?"); // Sửa name thành ProductName
        $sql->bind_param("s", $keyword);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy sản phẩm mới nhất
    public function getLatestProducts($limit = 5)
    {
        $sql = self::$connection->prepare("SELECT * FROM products ORDER BY CreatedAt DESC LIMIT ?"); // Sửa created_at thành CreatedAt
        $sql->bind_param("i", $limit);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Tìm kiếm sản phẩm theo từ khóa
    public function getProductsByKeyword($keyword)
    {
        $keyword = "%" . $keyword . "%";
        $sql = self::$connection->prepare("SELECT * FROM products WHERE ProductName LIKE ?"); // Sửa name thành ProductName
        $sql->bind_param("s", $keyword);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>