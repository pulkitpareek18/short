<script>app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*"); // update to match the domain you will make the request from
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});</script>

<?php
include "db_connect.php";

if (isset($_GET['url'])) {
    $slug = $_GET['slug'];
    $url = $_GET['url'];



    $sql = "SELECT * FROM `main` WHERE `short_url`='$slug'";

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);


    if ($num > 0) {
        echo ''. $slug . ' already exists.';
    } else {

        $sql_insert = "INSERT INTO `main` (`short_url` , `redirect_url`) VALUES ('$slug' , '$url')";
        $result_insert = mysqli_query($conn, $sql_insert);

        if ($result_insert) {
            echo 'http://localhost/'. $slug .'';
        } else {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
        }
    }
}
?>