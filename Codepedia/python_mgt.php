<?php
// データベース接続設定
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "py_db";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}

// コンテンツの追加
if (isset($_POST['add_content'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // コンテンツを追加
    $sql = "INSERT INTO contents (title, description) VALUES ('$title', '$description')";
    if ($conn->query($sql) === TRUE) {
        // 更新履歴に追加を記録
        $action = "追加";
        // コンテンツのタイトルも一緒に記録
        $sql = "INSERT INTO updates (action, content_title) VALUES ('$action', '$title')";
        $conn->query($sql);
        $message = "新しいコンテンツが追加されました";
        $message_type = "add";
    } else {
        $message = "エラー: " . $sql . "<br>" . $conn->error;
        $message_type = "error";
    }
}

// コンテンツの編集
if (isset($_POST['edit_content'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // コンテンツを更新
    $sql = "UPDATE contents SET description='$description' WHERE title='$title'";
    if ($conn->query($sql) === TRUE) {
        // 更新履歴に編集を記録
        $action = "編集";
        // コンテンツのタイトルも一緒に記録
        $sql = "INSERT INTO updates (action, content_title) VALUES ('$action', '$title')";
        $conn->query($sql);
        $message = "コンテンツが更新されました";
        $message_type = "edit";
    } else {
        $message = "エラー: " . $sql . "<br>" . $conn->error;
        $message_type = "error";
    }
}

// コンテンツの削除
if (isset($_POST['delete_content'])) {
    $title = $_POST['title'];

    // コンテンツを削除
    $sql = "DELETE FROM contents WHERE title='$title'";
    if ($conn->query($sql) === TRUE) {
        // 更新履歴に削除を記録
        $action = "削除";
        // コンテンツのタイトルも一緒に記録
        $sql = "INSERT INTO updates (action, content_title) VALUES ('$action', '$title')";
        $conn->query($sql);
        $message = "コンテンツが削除されました";
        $message_type = "delete";
    } else {
        $message = "エラー: " . $sql . "<br>" . $conn->error;
        $message_type = "error";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python | edit</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        // コンテンツ削除の確認
        function confirmDelete(title) {
            var confirmMessage = "本当にコンテンツ「" + title + "」を削除しますか？";
            if (confirm(confirmMessage)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Pythonの辞書</h1>
        <a href="./html_main.html">[HTML|CSS]</a>
        <a href="./php_main.php">[PHP]</a>
        <a href="./python_main.php">[Python]</a>
        <a href="./Linux_main.php">[Linux]</a>
        <a href="./TCPIP_main.php">[TCP/IP]</a>
    </header>
    
    <main class="mgt_main">
        <div class="form-container">
            <h2 class="mgt">コンテンツ追加</h2>
            <form action="" method="post">
                <label>タイトル:</label><br>
                <input type="text" name="title"><br>
                <label>説明:</label><br>
                <textarea name="description"></textarea><br>
                <input type="submit" name="add_content" value="追加">
            </form>
            <?php if(isset($message) && $message_type === "add") echo "<p class='message'>$message</p>"; ?>
        </div>

        <div class="form-container">
            <h2 class="mgt">コンテンツ編集</h2>
            <form action="" method="post">
                <label>タイトル:</label><br>
                <input type="text" name="title"><br>
                <label>説明:</label><br>
                <textarea name="description"></textarea><br>
                <input type="submit" name="edit_content" value="更新">
            </form>
            <?php if(isset($message) && $message_type === "edit") echo "<p class='message'>$message</p>"; ?>
        </div>

        <div class="form-container">
            <h2 class="mgt">コンテンツ削除</h2>
            <form action="" method="post" onsubmit="return confirmDelete(this.title.value)">
                <label>タイトル:</label><br>
                <input type="text" name="title"><br>
                <input type="submit" name="delete_content" value="削除">
            </form>
            <?php if(isset($message) && $message_type === "delete") echo "<p class='message'>$message</p>"; ?>
        </div>
    </main>
    
    <div class="back_div">
        <a class="back_link" href="./python_main.php">⇐ 戻る</a>
    </div>

    <footer  class="f_mgt">
        <dl>
            <dt>トップページ</dt>
            <dd><a href="./index.html">TOP</a></dd>
            <h4>過去作</h4>
            <dd><a href="./html_main.html">HTML,CSS</a></dd>
        </dl>
        <dl>
            <dt>辞書ページ</dt>
                <dd><a href="./php_main.php">PHP</a></dd>
                <dd><a href="./python_main.php">Python</a></dd>
                <dd><a href="./Linux_main.php">Linux</a></dd>
                <dd><a href="./TCPIP_main.php">TCP/IP</a></dd>
        </dl>
        <dl>
            <dt>編集ページ</dt>
                <dd><a href="./php_mgt.php">PHP</a></dd>
                <dd><a href="./python_mgt.php">Python</a></dd>
                <dd><a href="./Linux_mgt.php">Linux</a></dd>
                <dd><a href="./TCPIP_mgt.php">TCP/IP</a></dd>
        </dl>
        <p class="top_p"> &copy; 2024 Codepedia</p>
    </footer>

    <script>
        // コンテンツ削除の確認
        function confirmDelete(title) {
            var confirmMessage = "本当にコンテンツ「" + title + "」を削除しますか？";
            if (confirm(confirmMessage)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>