<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cacti Knowledge Base</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body style="background:#f9faf8;">
    <nav class="navbar navbar-dark" style="background-color: #009966;">
        <a class="navbar-brand" href="#">Cacti Knowledge Base</a>
    </nav>
    <div class="container-fluid" style="padding-top:20px;">
        <div class="row">
            <div class="col-3">
                <input type="text" id="search" class="form-control mb-2" placeholder="搜尋知識庫...">
                <div id="fileTree"></div>
            </div>
            <div class="col-9">
                <div id="docContent" style="background:#fff;padding:24px;border-radius:10px;"></div>
            </div>
        </div>
    </div>
    <script src="assets/jquery.min.js"></script>
    <script src="assets/app.js"></script>
</body>
</html>
