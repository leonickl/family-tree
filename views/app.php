<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/media">
    <link rel="stylesheet" href="/css/colors">
    <link rel="stylesheet" href="/css/base">
    <link rel="stylesheet" href="/css/snippets">
    <link rel="stylesheet" href="/css/button">
    <link rel="stylesheet" href="/css/table">
    <link rel="stylesheet" href="/css/notification">
    <link rel="stylesheet" href="/css/components">
    <link rel="stylesheet" href="/css/form">

    <title>Family Tree</title>
</head>

<body>
    <main>
        <?php if(App\Auth::auth()): ?>
            <div class="row end mb">
                <a href="/" class="btn" type="submit">Home</a>
                <a href="/logout?__method=post" class="btn" type="submit" style="background-color: red">Logout</a>
            </div>
        <?php endif ?>

        <?= $slot ?>
    </main>
</body>

</html>
