<?php 
$connection = mysqli_connect("localhost","root","");
$db=mysqli_select_db($connection,'crudv1');

if(isset($_POST['submit']))
{
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $organization = $_POST["organization"];
    $province = $_POST["province"];
    $city = $_POST["city"];
    $brgy = $_POST["brgy"];
    $street = $_POST["street"];


    if ($_FILES["imgInput"]["error"] === 4) {
        echo "<script>alert('Image Does Not Exist');</script>";
    } else {
        $fileName = $_FILES["imgInput"]["name"];
        $fileSize = $_FILES["imgInput"]["size"];
        $tmpName = $_FILES["imgInput"]["tmp_name"];

        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $validImageExtensions)) {
            echo "<script>alert('Invalid Image Extension')</script>";
        } elseif ($fileSize > 1000000) {
            echo "<script>alert('Image is too Large')</script>";
        } else {
            
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, 'image2/' . $newImageName);

            $sql = "INSERT INTO `crud_data` (`image`, `Name`, `Phone`, `Email`, `Organization`, `Province`, `City`, `Brgy`, `Street`) VALUES ('$newImageName', '$name', '$phone', '$email', '$organization', '$province', '$city', '$brgy', '$street')";
            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
            
            }

        }
    }



}

?>