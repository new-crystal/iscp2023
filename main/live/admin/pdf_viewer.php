<?php
    $file_path = $_GET["path"];

    if(!$file_path) {
        echo "<script>alert('유효하지 않은 파일입니다.'); self.close();</script>";
        exit;
    }
?>

<embed src= "<?=$file_path?>" width= "100%" height= "100%">
