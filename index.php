<?php
include 'head.php';
echo 'test';
echo 'test';
echo 'test';
echo 'test';



if ( isset($_POST['get']) ) {
    $from = ((int)$_POST['from'] / 100) * 300;
    $to   = ((int)$_POST['to'] / 100) * 300;

    if ( $from > $to) {
        $range[]= $to;
        $range[]= $from;
    } else {
        $range[]= $from;
        $range[]= $to;
    }

    $pdo = $pdo->prepare("SELECT * FROM students WHERE degree > $range[0] AND degree < $range[1]");
    $pdo->execute();
    $pdo->setFetchMode(PDO::FETCH_ASSOC); 
    $result = $pdo->fetchAll();
}else {
    $pdo = $pdo->prepare("SELECT * FROM students");
    $pdo->execute();
    $pdo->setFetchMode(PDO::FETCH_ASSOC); 
    $result = $pdo->fetchAll();
}
$total;
?>

<section class="panel">
    <header class="panel-heading">
        <h3>Students Filter</h3>
    </header>

    <div class="panel-body">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-validate form-horizontal" method="post">

            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">From<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" name="from" minlength="1" class="form-control" placeholder="From" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">To</label>
                        <div class="col-sm-10">
                            <input type="number" name="to" minlength="1" class="form-control" placeholder="To">
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-sm-12">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-primary" name="get" type="submit">Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
	</div>
</section>

<a class="btn btn-primary" href="mem.php" title="Add Student">Add Student</a>

<br>
<br>

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box blue-bg">
            <i class="fa fa-thumbs-o-up"></i>
            <div class="count"><?=count($result)?></div>
            <div class="title">Students</div>						
        </div><!--/.info-box-->			
    </div><!--/.col-->

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box blue-bg">
            <i class="fa fa-thumbs-o-up"></i>
            <div class="count"><?php echo array_sum(array_column($result, 'degree')); ?></div>
            <div class="title"><?=count($result)*300?></div>						
            <div class="title">Total Score</div>						
        </div><!--/.info-box-->			
    </div><!--/.col-->
</div>

<section class="panel">
    <header class="panel-heading">
        The Students
    </header>

    <table class="table table-striped table-advance table-hover">
    <tbody>
        <tr>
            <th><i class="icon_profile"></i> #</th>
            <th><i class="icon_profile"></i> Name</th>
            <th><i class="icon_calendar"></i> Score</th>
            <th><i class="icon_calendar"></i> Final</th>
            <th><i class="icon_calendar"></i> percentage</th>
            <th><i class="icon-envelope-l"></i> Statue</th>
            <th><i class="icon_cogs"></i> Action</th>
        </tr>
    <?php $i=0; foreach ($result as $row){ $i++; ?>
        <tr>
            <td><?=$i?></td>
            <td><?=$row['name']?></td>
            <td><?=$row['degree']?></td>
            <td><?=$final?></td>
            <td><?=number_format(($row['degree']/$final)*100, 2, ',', ' ')?>%</td>
            <td><?php echo $row['degree'] >= $success ? 'Success' : 'Fail'; ?></td>            
            <td>
            <div class="btn-group">
                <a class="btn btn-primary" href="mem.php?id=<?=$row['id']?>"><i class="icon_document"></i></a>
                <a class="btn btn-danger" href="mem.php?delete=<?=$row['id']?>"><i class="icon_close_alt2"></i></a>
            </div>
            </td>
        </tr>
    <?php $total += $row['degree']; } ?>
    </tbody>
    </table>
</section>

<?php include 'foot.php'; ?>
