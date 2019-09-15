<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">หน้าแรก</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?page=car/list">รายการรถยนต์</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?page=myCar/list">รถยนต์ของฉัน</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?page=car/cart">ตะกร้าสินค้า</a>
                </li>
            </ul>
            <div class="my-2 my-lg-0 ml-3">
                <?php if (isset($_SESSION['member'])){ ?>
                    <!-- <a href="index.php?page=member/logout" class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a> -->
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-secondary"><?php echo $_SESSION['member']['name']; ?></button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="index.php?page=member/info">ข้อมูลส่วนตัว</a>
                                <a class="dropdown-item" href="#">ประวัติการสั่งซื้อ</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="member/memberLogout.php"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
                            </div>
                        </div>
                    </div>
                <?php }else{ ?>
                    <a href="index.php?page=member/login" class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</a>
                    <a href="index.php?page=member/register" class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="far fa-registered"></i> สมัครสมาชิก</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
