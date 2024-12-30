<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $student_name = $_POST['student_name'];
    $student_id = $_POST['student_id'];
    $class = $_POST['class'];
    $main_course = $_POST['main_course'];
    $drink = $_POST['drink'];

    // 計算總金額
    $main_course_prices = [
        "炒飯" => 50,
        "炒泡麵" => 60,
        "蛋包飯" => 65,
        "牛肉麵" => 100,
        "鍋燒麵" => 70,
        "排骨飯" => 80
    ];
    $drink_prices = [
        "紅茶" => 30,
        "綠茶" => 30,
        "奶茶" => 30,
        "冬瓜茶" => 30,
        "檸檬水" => 20,
        "水果茶" => 45,
        "拿鐵" => 55
    ];

    $total_price = $main_course_prices[$main_course] + ($drink_prices[$drink] ?? 0);

    // 更新資料
    $update_query = "UPDATE bookings SET student_name = ?, student_id = ?, class = ?, main_course = ?, drink = ?, total_price = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssid", $student_name, $student_id, $class, $main_course, $drink, $total_price, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>訂單更新成功！</div>";
        exit();
    } else {
        echo "<div class='alert alert-danger'>更新失敗：" . $conn->error . "</div>";
    }
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM bookings WHERE id = $id");
    $row = $result->fetch_assoc();

    // 主餐與飲料的選項
    $main_course_prices = [
        "炒飯" => 50,
        "炒泡麵" => 60,
        "蛋包飯" => 65,
        "牛肉麵" => 100,
        "鍋燒麵" => 70,
        "排骨飯" => 80
    ];
    $drink_prices = [
        "紅茶" => 30,
        "綠茶" => 30,
        "奶茶" => 30,
        "冬瓜茶" => 30,
        "檸檬水" => 20,
        "水果茶" => 45,
        "拿鐵" => 55
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改訂單</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">修改訂單</h1>
        <form method="post" action="edit_booking.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
            <div class="form-group">
                <label for="student_name">學生姓名</label>
                <input type="text" class="form-control" id="student_name" name="student_name" value="<?= htmlspecialchars($row['student_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="student_id">學號</label>
                <input type="text" class="form-control" id="student_id" name="student_id" value="<?= htmlspecialchars($row['student_id']) ?>" required>
            </div>
            <div class="form-group">
                <label for="class">班級</label>
                <input type="text" class="form-control" id="class" name="class" value="<?= htmlspecialchars($row['class']) ?>" required>
            </div>
            <div class="form-group">
                <label for="main_course">主餐</label>
                <select class="form-control" id="main_course" name="main_course" required>
                    <?php foreach ($main_course_prices as $course => $price): ?>
                        <option value="<?= $course ?>" <?= $row['main_course'] == $course ? 'selected' : '' ?>>
                            <?= $course ?> (NT$<?= $price ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="drink">飲料</label>
                <select class="form-control" id="drink" name="drink">
                    <option value="">無</option>
                    <?php foreach ($drink_prices as $drink => $price): ?>
                        <option value="<?= $drink ?>" <?= $row['drink'] == $drink ? 'selected' : '' ?>>
                            <?= $drink ?> (NT$<?= $price ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">更新訂單</button>
        </form>
    </div>
</body>
</html>
