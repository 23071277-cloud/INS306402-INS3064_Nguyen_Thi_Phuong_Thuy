<?php
// Khởi tạo biến để lưu trữ từ khóa tìm kiếm, mặc định là chuỗi rỗng
$searchQuery = '';

// Kiểm tra xem tham số 'q' có tồn tại trên URL hay không
if (isset($_GET['q'])) {
    // Thu thập giá trị và loại bỏ khoảng trắng thừa ở hai đầu
    $searchQuery = trim($_GET['q']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Query Echo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .search-box { margin-bottom: 20px; }
        .result { padding: 10px; background-color: #f9f9f9; border-left: 4px solid #007bff; }
    </style>
</head>
<body>

    <h2>Hệ thống Tìm kiếm</h2>

    <div class="search-box">
        <form method="GET" action="">
            <label for="searchInput">Từ khóa:</label>
            <input type="text" 
                   id="searchInput" 
                   name="q" 
                   placeholder="Nhập nội dung cần tìm..." 
                   value="<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>">
            
            <button type="submit">Tìm kiếm</button>
        </form>
    </div>

    <?php
    // Chỉ hiển thị kết quả nếu người dùng đã nhập từ khóa (không rỗng)
    if ($searchQuery !== '') {
        // XSS Prevention: Làm sạch dữ liệu trước khi in ra trình duyệt
        $safeOutput = htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8');
        
        echo "<div class='result'>";
        echo "<p>Kết quả tìm kiếm cho: <strong>" . $safeOutput . "</strong></p>";
        // Tại đây sẽ là logic truy vấn cơ sở dữ liệu dựa trên $searchQuery trong ứng dụng thực tế
        echo "</div>";
    }
    ?>

</body>
</html>