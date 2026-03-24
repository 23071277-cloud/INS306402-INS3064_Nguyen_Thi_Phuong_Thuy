<?php
$result = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $num1 = $_POST['num1'] ?? '';
    $num2 = $_POST['num2'] ?? '';
    $operation = $_POST['operation'] ?? '';

    // Numeric Validation
    if (is_numeric($num1) && is_numeric($num2)) {
        // Type Casting
        $n1 = (float)$num1;
        $n2 = (float)$num2;

        // Match expression (PHP 8.0+)
        $result = match($operation) {
            'add' => $n1 + $n2,
            'subtract' => $n1 - $n2,
            'multiply' => $n1 * $n2,
            'divide' => $n2 != 0 ? $n1 / $n2 : 'Lỗi: Không thể chia cho 0',
            default => 'Phép tính không hợp lệ',
        };
    } else {
        $error = 'Vui lòng nhập giá trị số hợp lệ.';
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Calculator</title></head>
<body>
    <h2>Máy tính cơ bản</h2>
    <form method="POST" action="">
        <input type="text" name="num1" placeholder="Số thứ nhất" value="<?= htmlspecialchars($_POST['num1'] ?? '') ?>">
        <select name="operation">
            <option value="add" <?= (isset($_POST['operation']) && $_POST['operation'] === 'add') ? 'selected' : '' ?>>Cộng (+)</option>
            <option value="subtract" <?= (isset($_POST['operation']) && $_POST['operation'] === 'subtract') ? 'selected' : '' ?>>Trừ (-)</option>
            <option value="multiply" <?= (isset($_POST['operation']) && $_POST['operation'] === 'multiply') ? 'selected' : '' ?>>Nhân (*)</option>
            <option value="divide" <?= (isset($_POST['operation']) && $_POST['operation'] === 'divide') ? 'selected' : '' ?>>Chia (/)</option>
        </select>
        <input type="text" name="num2" placeholder="Số thứ hai" value="<?= htmlspecialchars($_POST['num2'] ?? '') ?>">
        <button type="submit">Tính toán</button>
    </form>

    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php elseif ($result !== ''): ?>
        <p>Kết quả: <strong><?= $result ?></strong></p>
    <?php endif; ?>
</body>
</html>