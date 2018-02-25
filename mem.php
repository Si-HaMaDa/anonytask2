<?php include 'head.php';

if ((int)$_GET['id']) {
    $id = (int)$_GET['id'];
    $pdo = $pdo->prepare("SELECT * FROM students WHERE id=$id");
    $pdo->execute();
    $pdo->setFetchMode(PDO::FETCH_ASSOC); 
    $result = $pdo->fetch();
    if ($result) {
        $sub = 'Edit';
    }else {
        echo 'You followed the wrong he link';
        die();        
    }

} elseif ((int)$_GET['delete']) {
    $id = (int)$_GET['delete'];
    $pdo = $pdo->prepare("DELETE FROM students WHERE id = $id");
    if ($pdo->execute()){
        echo 'Student deleted succefully';
        die();
    } else {
        echo 'Something goes wrong!!!';
        die();
    }
} elseif ( isset($_POST['Edit']) ) {
    
    $id = (int)$_POST['id'];
    $pdo = $pdo->prepare("UPDATE students SET name=:name, degree=:degree WHERE id=$id");
    $pdo->bindParam(':name', $name);
    $pdo->bindParam(':degree', $degree);
    $name = filter_var( $_POST['name']   , FILTER_SANITIZE_STRING);
    $degree = filter_var( $_POST['degree']   , FILTER_SANITIZE_STRING);
    if ($pdo->execute()) {
        echo 'Student edited succefully';
        die();
    } else {
        echo 'Something goes wrong!!!';
        die();        
    }


} elseif ( isset($_POST['Add']) ) {

    $pdo = $pdo->prepare("INSERT INTO students('name', 'degree') VALUES (:name, :degree)");
    $pdo->bindParam(':name', $name);
    $pdo->bindParam(':degree', $degree);
    $name = filter_var( $_POST['name']   , FILTER_SANITIZE_STRING);
    $degree = filter_var( $_POST['degree']   , FILTER_SANITIZE_STRING);
    if ($pdo->execute()) {
        echo 'Student added succefully';
        die();
    } else {
        echo 'Something goes wrong!!!';
        die();        
    }

} else {
    $sub = 'Add';
}


?>

<section class="panel">
    <header class="panel-heading">
        <h3>Students</h3>
    </header>

    <div class="panel-body">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-validate form-horizontal" method="post">

            <?php if ($result['id']) { ?>
            <input type="hidden" name="id" value="<?=$result['id']?>">
            <?php } ?>

            <div class="form-group">
                <label class="col-sm-2 control-label">Name<span class="required">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="name" minlength="3" class="form-control" value="<?=@$result['name']?>" placeholder="Name" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Degree<span class="required">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="degree" minlength="1" class="form-control" value="<?=@$result['degree']?>" placeholder="Degree" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-primary" name="<?=$sub?>" type="submit"><?=$sub?> student</button>
                </div>
			</div>
        </form>
	</div>
</section>


<?php include 'foot.php'; ?>
