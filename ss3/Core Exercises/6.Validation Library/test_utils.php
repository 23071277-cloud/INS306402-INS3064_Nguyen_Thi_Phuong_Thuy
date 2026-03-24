<?php
// Nhúng thư viện
require_once 'utils.php';

echo "<h3>Kiểm thử Validation Library</h3>";

// 1. Test sanitize_input()
$dirty_string = "<script>alert('Lỗi!');</script>  ";
echo "Chuỗi gốc: " . htmlspecialchars($dirty_string) . "<br>";
echo "Sau khi làm sạch: " . sanitize_input($dirty_string) . "<hr>";

// 2. Test is_required()
$empty_input = "   ";
$valid_input = "Linh";
echo "Kiểm tra rỗng (khoảng trắng): " . (is_required($empty_input) ? 'Hợp lệ' : 'Báo lỗi') . "<br>";
echo "Kiểm tra có dữ liệu: " . (is_required($valid_input) ? 'Hợp lệ' : 'Báo lỗi') . "<hr>";

// 3. Test is_valid_email()
$bad_email = "linhnguyen@.com";
$good_email = "linhnguyen@example.com";
echo "Email sai định dạng: " . (is_valid_email($bad_email) ? 'Hợp lệ' : 'Báo lỗi') . "<br>";
echo "Email đúng định dạng: " . (is_valid_email($good_email) ? 'Hợp lệ' : 'Báo lỗi') . "<br>";
?>