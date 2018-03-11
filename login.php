<?php
$pageTitle="Login";
include('header.php');
require("db-connect.php");

$isLogin = 0;
$teacher = 0;
$student = 0;
$loginId = 0;
$errmsg = '';
if(isset($_POST['login']) && isset($_POST['username']) && !empty($_POST['username'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = 'SELECT * FROM Logins';

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0){

        // output data of each row
        while($row = $result->fetch_assoc()) {

            if(($row["username"]== $username)){
                if ($row["password"] == $password) {
                    $isLogin = 1;
                    setcookie('currentUser', $row['username']);
                    setcookie("login", $isLogin);
                    //$teacher=1;
                    //$student=0;
                    header('Location: index.php');
                }
                else {
                    $errmsg = "Incorrect Password";
                }
            }
            else{
                //$student=1;
                //$teacher=0;
                $errmsg = "Incorrect username or password";
            }


        }
    }
    else {

    }
    $conn->close();
}
?>
<form method="post" action="<?php echo($_SERVER['PHP_SELF'])?>">
    <div class="form-group">
        <div class="row">
          <div class="col-md-6">
                <?php
                if (!empty($errmsg)) {
                echo '<div class="alert alert-danger" role="alert">';
                echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ';
                echo '<span class="sr-only">Error:</span>';
                    echo '<strong>' . $errmsg .'</strong>';
                    echo '</div>';
                }
                ?>
            <div class="input-group">
                <input type="text" name="username" id="username" class="form-control" required placeholder="Required Username">
                <input type="password" name="password" id="password" class="form-control" required placeholder="Required Password">
                <span class="input-group-btn"><input type="submit" name="login" class="btn btn-primary" value="Login"></span>
            </div><!-- /input-group -->
          </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
    </div>
</form>
<?php
include('footer.php');