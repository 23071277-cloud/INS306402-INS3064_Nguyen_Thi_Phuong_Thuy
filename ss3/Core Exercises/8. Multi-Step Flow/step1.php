<!DOCTYPE html>
<html>
<head><title>Bước 1 - Thông tin cơ bản</title></head>
<body>
    <h2>Bước 1/2: Thông tin cá nhân</h2>
    <form method="POST" action="step2.php">
        <label>Họ và tên:</label><br>
        <input type="text" name="fullname" required value="Linh Nguyen"><br><br>
        
        <label>Mã số sinh viên (Tùy chọn):</label><br>
        <input type="text" name="student_id"><br><br>

        <button type="submit">Tiếp tục sang Bước 2</button>
    </form>
</body>
</html>