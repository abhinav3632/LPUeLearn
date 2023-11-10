<?php
include("includes/config.php");
error_reporting(0);
?>
<?php if($_SESSION['login']!="")
{?>
<header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <strong>Welcome: </strong><?php echo htmlentities($_SESSION['sname']);?>
                    &nbsp;&nbsp;
                    <strong>Last Login:<?php
        $ret=mysqli_query($bd, "SELECT  * from userlog where studentRegno='".$_SESSION['login']."' order by id desc limit 1,1");
                    $row=mysqli_fetch_array($ret);
                    echo $row['userip']; ?> at <?php echo $row['loginTime'];?></strong>
                </div>

            </div>
        </div>
    </header>
    <?php } ?>
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                 <img src="assets/img/LPu.png" alt="login form" class="img-fluid me-3" style="width: 100px; height: 100px; 
                border-radius: 1rem; margin: 0.5rem;"/>
                 <a class="navbar-brand" href="#" style="color:#fff; font-size:36px; font-weight:bold;line-height:24px; ">
                   LPUeLearn
                </a>

            </div>

            <div class="left-div">
            </div>
        </div>
    </div>
