<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shorten Links</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText.value);

  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}
</script>
</head>

<body>

    <!-- header -->
    <header class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
            <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
                <span class="ml-3 text-xl">Shorten links by iBlog</span>
            </a>
            
            
        </div>
    </header>


    <!-- form -->


    <div class="w-full max-w-xs block ">
        <form action="/short/index.php" type="get" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="text">
                    Slug
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="slug" name="slug" type="text" placeholder="short url">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="url">
                    Url
                </label>
                <input class="shadow appearance-none border  rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="url" name="url" type="url" placeholder="redirect url">
            </div>
            <div class="flex items-center justify-between">
                <input type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">

                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                </a>
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">

        </p>
    </div>
</body>
</html>


<?php
include "db_connect.php";

if (isset($_GET['url'])) {
    $slug = $_GET['slug'];
    $url = $_GET['url'];



    $sql = "SELECT * FROM `main` WHERE `short_url`='$slug'";

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);


    if ($num > 0) {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
  <strong class="font-bold">Sorry!</strong>
  <span class="block sm:inline">' . $slug . ' already exists.</span>
  <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </span>
</div>';
    } else {

        $sql_insert = "INSERT INTO `main` (`short_url` , `redirect_url`) VALUES ('$slug' , '$url')";
        $result_insert = mysqli_query($conn, $sql_insert);

        if ($result_insert) {
            echo '<div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
        <p class="font-bold">Done!</p>
        <p class="text-sm">your url is http://localhost/short/'. $slug .'</p>
        <input  class="shadow appearance-none border  rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"  type="text" value=" http://lund.rf.gd/'.$slug .'" id="myInput">

        
      </div>

<!-- The button used to copy the text -->
<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="myFunction()">Copy link</button>';
        } else {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
        }
    }
} else {
    if (isset($_GET['slug'])) {
        $slug_redirect = $_GET['slug'];
        $sql = "SELECT * FROM `main` WHERE `short_url`='$slug_redirect'";

        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 0) {
            echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Sorry!</strong>
        <span class="block sm:inline">' . $slug_redirect . ' not exists.</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
      </div>';
        } else {
            $sql_redirect = "SELECT * FROM `main` where short_url = '$slug_redirect' ";

            $result_redirect = mysqli_query($conn, $sql_redirect);

            while ($data = mysqli_fetch_assoc($result_redirect)) {
                $url = $data['redirect_url'];
            }
            header('Location: ' . $url);
            exit();
        }
    }
}

?>