<?php
/**
 * Làm sạch chuỗi đầu vào để ngăn chặn XSS.
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Kiểm tra xem trường dữ liệu có bị bỏ trống hay không.
 */
function is_required($data) {
    return !empty(trim($data));
}

/**
 * Kiểm tra định dạng email hợp lệ.
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>