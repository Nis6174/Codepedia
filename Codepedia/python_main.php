<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python | HOME</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Pythonの辞書</h1>
        <a href="./html_main.html">[HTML|CSS]</a>
        <a href="./php_main.php">[PHP]</a>
        <a href="./python_main.php">[Python]</a>
        <a href="./Linux_main.php">[Linux]</a>
        <a href="./TCPIP_main.php">[TCP/IP]</a>
        <a class="edit" href="./python_mgt.php">[編集する]</a>
    </header>

    <div id="toc">
    <h2 class="main_h2">目次</h2>
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

        // 目次の自動生成
        echo "<ul class='left'>";
        $result = $conn->query("SELECT title FROM contents");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li class='wind'><a href='#" . $row["title"] . "'>" . $row["title"] . "</a></li>";
            }
        } else {
            echo "0 results";
        }
        echo "</ul>";
        ?>
    </div>

    <div id="updates">
        <h2>更新履歴</h2>
        <?php
        // 更新履歴の自動生成
        echo "<ul class='left'>";
        $result = $conn->query("SELECT action, date, content_title FROM updates WHERE action <> '削除'");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $action = $row["action"];
                $date = $row["date"];
                $contentTitle = $row["content_title"];
                echo "<li class='wind'>[" . $date . "] " . $action;
                if ($contentTitle !== "") {
                    echo "  $contentTitle";
                }
                echo "</li>";
            }
        } else {
            echo "0 results";
        }
        echo "</ul>";
        ?>
    </div>

    <div id="contents">
        <?php
        // メインのコンテンツの自動生成
        $result = $conn->query("SELECT title, description FROM contents");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<h2 id='" . $row["title"] . "'>" . $row["title"] . "</h2>";
                echo "<div class='content-item'>";
                echo "<p>" . $row["description"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "0 results";
        }
        ?>
    </div>
    
    <footer class="f_mgt">
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

</body>
</html>

<?php
// データベース接続を閉じる
$conn->close();
?>
