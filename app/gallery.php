<?php
require_once 'config.php';
$db = getDB();
$images = $db->query("SELECT * FROM gallery ORDER BY upload_date DESC")->fetchAll(PDO::FETCH_ASSOC);

foreach ($images as $image): ?>
    <div style="border:1px solid #ccc; margin:10px; padding:10px; display:inline-block;">
        <img src="uploads/<?php echo $image['filename']; ?>" style="max-width:200px; max-height:200px;">
        <p>Загружено: <?php echo $image['uploaded_by']; ?></p>
    </div>
<?php endforeach; ?>
