<html lang="">
    <head>
        <title>Assign Seat</title>

        <link rel="shortcut icon" href="../favicon.ico"> 
        <!-- Assign Seat Admin style sheet files start here-->
        <link rel="stylesheet" type="text/css" href="assets/css/adminPage.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/adminView.css" />
        <link rel="stylesheet" href="assets/js/fancybox/jquery.fancybox.css"
              media="screen" />
        <!-- Assign Seat Admin style sheet files end here-->

        <script src="assets/js/jquery.tools.min.js"></script>
        <script type="text/javascript"  src="assets/js/fancybox/jquery.fancybox.js"></script>
        <script type="text/javascript"  src="assets/js/Admin.js"></script>
    </head>
    <body>
        <div id="adminHeader"> 
            <div id="logo">
                <h1>
                    <a href="index"><?php echo $lang->ASSIGNSEAT ?></a>
                </h1>
            </div>

            <span id='adminMenu'>

                <ul class="adminallMenues">
                    <li><a href="index">Home</a></li>
                    <li><a href="javascript:void(0)" onclick="getUsersPanal()">Users</a></li>
                    <li><a href="javascript:void(0)" onclick="uploadcsv()">Upload CSV File</a></li>
                    <li><a href="javascript:void(0);" onclick="deptcolor()">Dept Color</a></li>
                    <li><a href="javascript:void(0)" onclick="logMeOut()" id="logout"><?php echo $lang->LOGOUT ?></a></li>
                </ul>
            </span>
        </div>

        <div id='leftAdminMenu'>
            <h3>Employees</h3>
            <div id="allEmployee">
                <?php include_once 'allEmployee.php'; ?>
            </div>
            <h3>Rooms</h3>
            <div id="allRooms">           
                <ul class="ca-menu">
                    <?php foreach ($data as $key => $val) { ?>
                        <li>
                            <a href="#" onclick="showRoomDetails(<?php echo $val['id']; ?>)">
                                <span class="ca-icon">L</span>
                                <div class="ca-content" >                             
                                    <h3 class="ca-sub"><?php echo $val['name']; ?></h3>
                                </div>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </div>

        </div>   
        <div id="adminPanal">
            <img alt="admin panal" src="assets/images/adminPanal.jpg" width='100%' height='660px'>
        </div>
        <div id="adminFooter">
            <div id="copyright">
                <?php include_once 'footer.php'; ?>
                <div id = "companyCopyright"><?php echo $lang->COPYRIGHT ?></div>
            </div>
        </div>
    </body>
</html>
