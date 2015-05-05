<html>
<head>
    <title>DashBoard</title>

    <!-- Include require JavaScript and initialize menu -->
    <script src="js/prototype.js" type="text/javascript"></script>
    <script src="js/Menu.js" type="text/javascript"></script>
    <script type="text/javascript">
        Menu.init("menu");
    </script>

    <!-- Simple style sheet for horizontal menu -->
    <style type="text/css">
        /* reset default styles */
        #menu,
        #menu ul { margin: 0; padding: 0; }
        #menu li { list-style-type: none; }

        /* first level */
        #menu li,
        #menu a { float: left; width: 100px; }
        #menu a { display: block; background: #EEE; }
        #menu a:hover,
        #menu a.menu_open { background: #DDD; }

        /* second level and up */
        #menu ul { visibility: hidden; position: absolute; width: 100px; }
        #menu ul a { background: #DDD; }
        #menu ul a:hover,
        #menu ul a.menu_open { background: #CCC; }

        /* third level (colors) */
        #menu ul ul a { background: #CCC; }
        #menu ul ul a:hover { background: #BBB; }
    </style>
</head>
<body>

<!-- Example menu -->
<ul id="menu">
    <li><a href="/emp.php">Employee Management</a></li>
    <li><a href="/dept.php">Department management</a></li>
    <li><a href="/createmanager.php">Manager management</a></li>
    <li><a href="/jobtitle.php">JobTitles Management</a></li>
    <li><a href="/logout.php">Logout</a></li>
</ul>
