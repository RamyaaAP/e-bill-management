<?php 
    require_once('head.php'); 
    require_once('../Includes/config.php'); 
    require_once('../Includes/session.php'); 
    require_once('../Includes/admin.php'); 
    if ($logged==false) {
         header("Location:../dashboard.php");
    }
?>

<body>
    <div id="wrapper">
        <?php 
            require_once("nav_bar.php");
        ?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Bills
                        </h1>
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#generated" data-toggle="pill">Bills History</a>
                            </li>
                            <li class=""><a href="#generate" data-toggle="pill">Generate New Bill</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="generated">                               
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Bill No.</th>
                                                <th>Customer</th>
                                                <th>Date</th>
                                                <th>UNITS Consumed</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $id=$_SESSION['aid'];
                                            $query1 = "SELECT COUNT(users.name) FROM users,bills WHERE users.id=bills.userid AND adminid={$id}";
                                            $result1 = mysqli_query($con,$query1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $numrows = $row1[0];
                                            include("paging_1.php");
                                            $result = retrieve_generated_bills($_SESSION['aid'],$offset, $rowsperpage);
                                            while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <tr>
                                                    <td><?php echo 'BN_'.$row['bid']?></td>
                                                    <td height="50"><?php echo $row['users'] ?></td>
                                                    <td><?php echo $row['billdate'] ?></td>
                                                    <td><?php echo $row['units'] ?></td>
                                                    <td><?php echo '₹'.$row['amount'] ?></td>
                                                    <td><?php echo $row['duedate'] ?></td>
                                                    <td><?php if($row['billstatus'] == 'PENDING') { echo'<span class="badge" style="background: red;">'.$row["billstatus"].'</span>'; } else { echo'<span class="badge" style="background: green;">'.$row["billstatus"].'</span>';} ?></td>
                                                </tr>
                                            <?php 
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php include("paging_2.php");  ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="generate">
                                    
									<?php	include("generate_bill_table.php") ;?>
                                    
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    require_once("footer.php");
    require_once("javascript.php");
    ?>
</body>
</html>

