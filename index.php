<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>餐點預訂系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">餐點預訂系統</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="student_name" class="form-label">學生姓名</label>
                <input type="text" name="student_name" id="student_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="student_id" class="form-label">學號</label>
                <input type="text" name="student_id" id="student_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">班級</label>
                <input type="text" name="class" id="class" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="main_course" class="form-label">主餐</label>
                <select name="main_course" id="main_course" class="form-select">
                    <option value="">選擇主餐</option>
                    <option value="炒飯">炒飯 - NT$50</option>
                    <option value="炒泡麵">炒泡麵 - NT$60</option>
                    <option value="蛋包飯">蛋包飯 - NT$65</option>
                    <option value="牛肉麵">牛肉麵 - NT$100</option>
                    <option value="鍋燒麵">鍋燒麵 - NT$70</option>
                    <option value="排骨飯">排骨飯 - NT$80</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="drink" class="form-label">飲料 (可選)</label>
                <select name="drink" id="drink" class="form-select">
                    <option value="">不需要飲料</option>
                    <option value="紅茶">紅茶 - NT$30</option>
                    <option value="綠茶">綠茶 - NT$30</option>
                    <option value="奶茶">奶茶 - NT$30</option>
                    <option value="冬瓜茶">冬瓜茶 - NT$30</option>
                    <option value="檸檬水">檸檬水 - NT$20</option>
                    <option value="水果茶">水果茶 - NT$45</option>
                    <option value="拿鐵">拿鐵 - NT$55</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">提交訂單</button>
        </form>
        <div class="text-center mt-4">
            <a href="view_bookings.php" class="btn btn-success">查看預約紀錄</a>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'db.php';

            $student_name = $_POST['student_name'];
            $student_id = $_POST['student_id'];
            $class = $_POST['class'];
            $main_course = $_POST['main_course'];
            $drink = $_POST['drink'];

            // 定義主餐與飲料的價格
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

            // 計算總金額
            $total_price = 0;
            if (isset($main_course_prices[$main_course])) {
                $total_price += $main_course_prices[$main_course];
            }
            if (!empty($drink) && isset($drink_prices[$drink])) {
                $total_price += $drink_prices[$drink];
            }

            // 生成亂數取餐編號
            $pickup_number = rand(1000, 9999);

            // 插入資料庫
            $stmt = $conn->prepare("INSERT INTO bookings (student_name, student_id, class, main_course, drink, total_price, pickup_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssid", $student_name, $student_id, $class, $main_course, $drink, $total_price, $pickup_number);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success mt-3'>訂單提交成功！<br>總金額：NT$" . htmlspecialchars($total_price) . "<br>取餐編號：" . htmlspecialchars($pickup_number) . "</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>提交失敗：" . $conn->error . "</div>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
