<?php
include('db_connection.php');  // اتصال قاعدة البيانات
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة الإدارة</title>
</head>
<body>
    <h1>لوحة الإدارة</h1>

    <!-- إضافة أو تعديل الإعلان -->
    <h2>إضافة إعلان</h2>
    <form action="admin_panel.php" method="POST" enctype="multipart/form-data">
        <label for="image">صورة الإعلان:</label>
        <input type="file" name="image" id="image" required><br>
        <label for="link">رابط الإعلان:</label>
        <input type="text" name="link" id="link" required><br>
        <button type="submit" name="add_ad">إضافة إعلان</button>
    </form>

    <?php
    // إضافة إعلان إلى قاعدة البيانات
    if (isset($_POST['add_ad'])) {
        $image = $_FILES['image']['name'];
        $link = $_POST['link'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $sql = "INSERT INTO ads (image_url, link) VALUES ('$target_file', '$link')";
        if ($conn->query($sql) === TRUE) {
            echo "تم إضافة الإعلان بنجاح!";
        } else {
            echo "خطأ: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

    <!-- عرض الإعلانات -->
    <h2>الإعلانات الحالية</h2>
    <?php
    $sql = "SELECT * FROM ads";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div><img src='" . $row['image_url'] . "' width='100px' /><br>";
            echo "رابط: " . $row['link'] . "</div><br>";
        }
    } else {
        echo "لا توجد إعلانات حالياً.";
    }
    ?>
</body>
</html>

<?php $conn->close(); ?>
