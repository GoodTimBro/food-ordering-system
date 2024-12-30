<?php
require 'db.php';

$result = $conn->query("SELECT * FROM bookings");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>預約紀錄</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">預約紀錄</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>學生姓名</th>
                    <th>學號</th>
                    <th>班級</th>
                    <th>主餐</th>
                    <th>飲料</th>
                    <th>總金額</th>
                    <th>取餐編號</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                    <td><?= htmlspecialchars($row['student_id']) ?></td>
                    <td><?= htmlspecialchars($row['class']) ?></td>
                    <td><?= htmlspecialchars($row['main_course']) ?></td>
                    <td><?= htmlspecialchars($row['drink']) ?></td>
                    <td><?= htmlspecialchars($row['total_price']) ?></td>
                    <td><?= htmlspecialchars($row['pickup_number']) ?></td>
                    <td>
                        <a href="edit_booking.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">修改</a>
                        <a href="delete_booking.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('確定刪除嗎？')">刪除</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
