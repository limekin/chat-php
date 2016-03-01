<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="utf-8"/>
        <title>Chat Stuff</title>
        <link rel="stylesheet" href="/chatcraft/base/base.css" type="text/css"/>
        <link rel="stylesheet" href="/chatcraft/base/fixed_chat.css" type="text/css"/>
        <link rel="stylesheet" href="/chatcraft/base/im_instances.css" type="text/css"/>

        <?php if(isset($_SESSION['user_id'])): ?>
            <script>
                window.user_id = <?php echo $_SESSION['user_id']; ?>;
                window.im_instances = [];
            </script>
        <?php endif; ?>
    </head>

    <body>

