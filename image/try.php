<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "crudv1";

// create a new client
$connection = new mysqli($servername, $username, $password, $database);

$imgInput = "";
$name = "";
$phone = "";
$email = "";
$organization = "";
$province = "";
$city = "";
$brgy = "";
$street = "";

$errorMessage = "";
$successMessage = "";

// Update and Delete Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id= $_Get["id"];

    if (isset($_POST['update'])) {
        // $client_id = $_GET["id"];

        // Perform an update query based on the $client_id
        $updateSql = "UPDATE `crud_data` SET `Name`='$name', `Phone`='$phone', `Email`='$email', `Organization`='$organization', `Province`='$province', `City`='$city', `Brgy`='$brgy', `Street`='$street' WHERE `id`='$client_id'";        
        $updateResult = $connection->query($updateSql);

        if (!$updateResult) {
            $errorMessage = "Update failed: " . $connection->error;
        } else {
            $successMessage = "Client updated correctly";
        }
    }

    if (isset($_POST['delete'])) {
        $client_id = $_POST["client_id"];

       

        // Perform a delete query based on the $client_id
        $deleteSql = "DELETE FROM `crud_data` WHERE `id`='$client_id'";
        
        $deleteResult = $connection->query($deleteSql);

        if (!$deleteResult) {
            $errorMessage = "Delete failed: " . $connection->error;
        } else {
            $successMessage = "Client deleted correctly";
        }
    }
}

// Add Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_POST["client_id"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $organization = $_POST["organization"];
    $province = $_POST["province"];
    $city = $_POST["city"];
    $brgy = $_POST["brgy"];
    $street = $_POST["street"];

    do {
        if (empty($name) || empty($phone) || empty($email) || empty($organization) || empty($province) || empty($city) || empty($brgy) || empty($street)) {
            $errorMessage = "All fields are required";
            break;
        }

        // handle image upload
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
                

                $query = "INSERT INTO `crud_data` (`image`, `Name`, `Phone`, `Email`, `Organization`, `Province`, `City`, `Brgy`, `Street`) VALUES ('$newImageName', '$name', '$phone', '$email', '$organization', '$province', '$city', '$brgy', '$street')";
                $query_run = mysqli_query($connection,$query);
                $result = $connection->query($sql);

                if($query_run){
                    echo '
                    <script> alert("Data Save");</script>
                    ';
                }else{
                    echo '<script> alert("Data Not Saved");</script>';
                }
            }
        }

        $name = "";
        $phone = "";
        $email = "";
        $organization = "";
        $province = "";
        $city = "";
        $brgy = "";
        $street = "";
    } while (false);
}

// Fetch existing clients for display or further processing
$fetchSql = "SELECT * FROM `crud_data`";
$fetchResult = $connection->query($fetchSql);
?>


<div class="row">
            <div class="col-13">
                <table class="table table-striped table-hover mt-2 text-center table-bordered">
                    <thead>
                        <tr>
                          
                            <th>picture</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Province</th>
                            <th>City/Town</th>
                            <th>Barangay</th>
                            <th>Street</th>
                            <th>action</th>
                        </tr>
                    </thead>

                    <tbody id="data">

                    <?php while ($row = $fetchResult->fetch_assoc()) : ?>
                            
                                <tr>
                                    <td><img src="image2/<?php echo $row['image']; ?>" width="60" height="60"></td>
                                    <td><?php echo $row['Name'];?></td>
                                    <td><?php echo $row['Phone']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td><?php echo $row['Organization']; ?></td>
                                    <td><?php echo $row['Province']; ?></td>
                                    <td><?php echo $row['City']; ?></td>
                                    <td><?php echo $row['Brgy']; ?></td>
                                    <td><?php echo $row['Street']; ?></td>
                                    <td>

                                   
                                    <button type="submit" name='update' value='Update' class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#updateForm" ><i class='bi bi-pencil-square' ></i></button>
                                    <form method="post" action="">

                                    <!-- <input type='hidden' name='client_id' value="<?php echo $row['id']; ?>"> -->
                                    <button type="delete" name='client_id'  Value = "<?php echo $row['id'];?>" class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                    </form>m
                                    
                                   
                                        
                                    </td>
                                </tr>
                            
                                <?php endwhile; ?>                  
                        <!-- <tr>
                            <td>1</td>
                            <td><img src="image/about.png" alt="" width="50" height="50"></td>
                            <td>Jhon</td>
                            <td>09101631896</td>
                            <td>Jhon@gmail.com</td>
                            <td>University of mindanao</td>
                            <td>sta.josefa</td>
                            <td>Dumalag,city</td>
                            <td>angas</td>
                            <td>purok 16 dao, angas</td>
                            <td>
                                <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>



         <td><img src="image2/<?php echo $row['image']; ?>" width="60" height="60"></td>
                    <td><?php echo $row['Name'];?></td>
                    <td><?php echo $row['Phone']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['Organization']; ?></td>
                    <td><?php echo $row['Province']; ?></td>
                    <td><?php echo $row['City']; ?></td>
                    <td><?php echo $row['Brgy']; ?></td>
                    <td><?php echo $row['Street']; ?></td>
                    <td>
                    <button type="submit" name='update' value='Update' class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#updateForm" ><i class='bi bi-pencil-square' ></i></button>
                    <button type="delete" name='client_id'  Value = "<?php echo $row['id'];?>" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                    </td>


