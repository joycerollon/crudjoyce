
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

    if(isset($_POST['updatedata']))
    {
        $id = $_POST["id"];
        $name = $_POST["Name"];
        $phone = $_POST["Phone"];
        $email = $_POST["Email"];
        $organization = $_POST["Organization"];
        $province = $_POST["Province"];
        $city = $_POST["City"];
        $brgy = $_POST["Brgy"];
        $street = $_POST["Street"];

        $sql = "UPDATE `crud_data` SET `Name`='$name',`Phone`='$phone',`Email`='$email',`Organization`='$organization',`Province`='$province',`City`='$city',`Brgy`='$brgy',`Street`='$street' WHERE `id`='$id'";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        
        }

    }

    if(isset($_POST['deletedata']))
    {
        $id = $_POST["delete_id"];
     

        $sql = "DELETE FROM `crud_data` WHERE `id`='$id'";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        
        }

    }






?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <script src="jquery.js" type="text/javascript"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="jquery.js" type="text/javascript"></script>
    <!-- custom css link -->
    <link rel="stylesheet" type="text/css" href="style.css ">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- box icon link -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"> </head>

   

<script type="text/javascript">
    $(document).ready(function() {
        $("#city option").hide();
        $("#brgy option").hide();

        $("#province").change(function() {
            var val = $(this).val();
            $("#city option").hide();
            $("#city").val("");
            $("#city [data-city='" + val + "']").show();
            $("#city").change();
        });

        $("#city").change(function() {
            var val = $(this).find(":selected").prop("id");
            $("#brgy option").hide();
            $("#brgy").val("");
            $("#brgy [data-brgy='" + val + "']").show();
        });
    });
</script>



</head>
<body class="bg-black">

   
    <!--home section -->
    <section class="p-5 " >
        <div class="container">
            <div class="card">
                <div class="card-body bg-dark">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userForm" id="openModalBtn" >RegisterForm<i class="bi bi-people-fill"></i></button>
                </div>
            </div>
            <div class="card">
                <div class="card-body table-responsive">

            <?php 
                 $connection = mysqli_connect("localhost","root","");
                $db=mysqli_select_db($connection,'crudv1');

                $query= "SELECT * FROM `crud_data`";
                $query_run = mysqli_query($connection,$query);
            ?>

                <table class="table table-striped ">
                    <thead class="thead-dark">
                        <tr>
                        <th>ID</th>
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
                    </thead>

            <?php
                if($query_run)
                {

                    foreach($query_run as $row)
                    {
            ?>
                    <tbody>
                        <tr>
                        <td> <?php echo $row['id'];?> </td>
                            <td> <img src="image2/<?php echo $row['image']; ?>" width="60" height="60"> </td>
                            <td> <?php echo $row['Name'];?> </td>
                            <td> <?php echo $row['Phone'];?> </td>
                            <td> <?php echo $row['Email'];?> </td>
                            <td> <?php echo $row['Organization']; ?> </td>
                            <td> <?php echo $row['Province'];?> </td>
                            <td> <?php echo $row['City'];?> </td>
                            <td> <?php echo $row['Brgy'];?> </td>
                            <td> <?php echo $row['Street'];?> </td>
                            <td>
                            <button type="button" class="btn btn-success editbtn"><i class='bi bi-pencil-square' ></i></button>
                            <button type="button" class="btn btn-danger deletebtn"><i class="bi bi-trash"></i></button>

                            </td>
                        </tr>
                    </tbody>

            <?php
                    }

                }
                else
                {
                         echo " No record Found";
                }
            ?>
                </table>
                </div>
            </div>
        </div>

<!--modal form  -->
<div id="userForm" class="modal fade" id="bookkeepingmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" arial-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalLabel">Add Contact</h5>
                        <button type='button' class='btn-close'  data-bs-dismiss='modal' aria-label='Close'>
                        <span arial-hidden="true">&times;;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-dark">
                        <form name="contact" method="POST" enctype="multipart/form-data" onsubmit="return val();">
                            <div class="card imgholder">
                                <label for="imgInput" class="upload">
                                    <input  type="file" name="imgInput" id="imgInput" accept=".jpg, .jpeg, .png">
                                    <i class="bi bi-plus-circle-dotted"></i>
                                </label>
                                <img src="image/5bbc3519d674c.jpg" alt="" width="200px" height="200px" class="img">                                
                            </div>

                            <div class="inputField">
                                <!-- name -->
                                <div>
                                    <label for="name" class="  text-white">Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Your Name">
                                </div>
                                <!-- phone -->
                                <div>
                                    <label for="phone.no" class=" text-white">Phone No.:</label>
                                    <input type="text"  id="phone" name="phone" class="form-control" placeholder="Valid formats: (123) 456-7890, (123)456-7890, 123-456-7890, 123.456.7890">
                                </div>
                                <!-- email -->
                                <div>
                                    <label for="Email" class=" text-white">Email:</label>
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Sample@host.com" >
                                </div>
                                <!-- org -->
                                <div>
                                    <label for="Organization" class="text-white">Organization:</label></label>
                                    <input type="text" name="organization" id="organization" class="form-control" placeholder="Organization" >
                                </div>
                                <!-- province -->
                                <div>
                                    <label for="province" class="text-white">Province:</label>
                                    <select id="province" name="province" >
                                    <option>Select your Province</option>
                                    <option value="Abra">Abra</option>
                                    <option value="Agusan del Norte">Agusan del Norte</option>
                                    <option value="Agusan del Sur">Agusan del Sur</option>
                                    <option value="Aklan">Aklan</option>
                                    <option value="Albay">Albay</option>
                                    <option value="Antique">Antique</option>
                                    <option value="Apayao">Apayao</option>
                                    <option value="Aurora">Aurora</option>
                                    <option value="Basilan">Basilan</option>
                                    <option value="Bataan">Bataan</option>
                                    <option value="Batanes">Batanes</option>
                                    <option value="Batangas">Batangas</option>
                                    <option value="Benguet">Benguet</option>
                                    <option value="Biliran">Biliran</option>
                                    <option value="Bohol">Bohol</option>
                                    <option value="Bukidnon">Bukidnon</option>
                                    <option value="Bulacan">Bulacan</option>
                                    <option value="Cagayan">Cagayan</option>
                                    <option value="Camarines Norte">Camarines Norte</option>
                                    <option value="Camarines Sur">Camarines Sur</option>
                                    <option value="Camiguin">Camiguin</option>
                                    <option value="Capiz">Capiz</option>
                                    <option value="Catanduanes">Catanduanes</option>
                                    <option value="Cavite">Cavite</option>
                                    <option value="Cebu">Cebu</option>
                                    <option value="Cotabato">Cotabato</option>
                                    <option value="Davao de Oro">Davao de Oro</option>
                                    <option value="Davao del Norte">Davao del Norte</option>
                                    <option value="Davao del Sur">Davao del Sur</option>
                                    <option value="Davao Occidental">Davao Occidental</option>
                                    <option value="Davao Oriental">Davao Oriental</option>
                                    <option value="Dinagat Islands">Dinagat Islands</option>
                                    <option value="Eastern Samar">Eastern Samar</option>
                                    <option value="Guimaras">Guimaras</option>
                                    <option value="Ifugao">Ifugao</option>
                                    <option value="Ilocos Norte">Ilocos Norte</option>
                                    <option value="Ilocos Sur">Ilocos Sur</option>
                                    <option value="Iloilo">Iloilo</option>
                                    <option value="Isabela">Isabela</option>
                                    <option value="Kalinga">Kalinga</option>
                                    <option value="La Union">La Union</option>
                                    <option value="Laguna">Laguna</option>
                                    <option value="Lanao del Norte">Lanao del Norte</option>
                                    <option value="Lanao del Sur">Lanao del Sur</option>
                                    <option value="Leyte">Leyte</option>
                                    <option value="Maguindanao">Maguindanao</option>
                                    <option value="Marinduque">Marinduque</option>
                                    <option value="Masbate">Masbate</option>
                                    <option value="Metro Manila">Metro Manila</option>
                                    <option value="Misamis Occidental">Misamis Occidental</option>
                                    <option value="Misamis Oriental">Misamis Oriental</option>
                                    <option value="Mountain Province">Mountain Province</option>
                                    <option value="Negros Occidental">Negros Occidental</option>
                                    <option value="Negros Oriental">Negros Oriental</option>
                                    <option value="Northern Samar">Northern Samar</option>
                                    <option value="Nueva Ecija">Nueva Ecija</option>
                                    <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                                    <option value="Occidental Mindoro">Occidental Mindoro</option>
                                    <option value="Oriental Mindoro">Oriental Mindoro</option>
                                    <option value="Palawan">Palawan</option>
                                    <option value="Pampanga">Pampanga</option>
                                    <option value="Pangasinan">Pangasinan</option>
                                    <option value="Quezon">Quezon</option>
                                    <option value="Quirino">Quirino</option>
                                    <option value="Rizal">Rizal</option>
                                    <option value="Romblon">Romblon</option>
                                    <option value="Samar">Samar</option>
                                    <option value="Sarangani">Sarangani</option>
                                    <option value="Siquijor">Siquijor</option>
                                    <option value="Sorsogon">Sorsogon</option>
                                    <option value="South Cotabato">South Cotabato</option>
                                    <option value="Southern Leyte">Southern Leyte</option>
                                    <option value="Sultan Kudarat">Sultan Kudarat</option>
                                    <option value="Sulu">Sulu</option>
                                    <option value="Surigao del Norte">Surigao del Norte</option>
                                    <option value="Surigao del Sur">Surigao del Sur</option>
                                    <option value="Tarlac">Tarlac</option>
                                    <option value="Tawi-Tawi">Tawi-Tawi</option>
                                    <option value="Zambales">Zambales</option>
                                    <option value="Zamboanga del Norte">Zamboanga del Norte</option>
                                    <option value="Zamboanga del Sur">Zamboanga del Sur</option>
                                    <option value="Zamboanga Sibugay">Zamboanga Sibugay</option>
                                    </select>
                                </div>
                                <!-- city -->
                                <div>
                                    <label for="city/town" class="text-white">City/Town:</label>
                                    <select id="city" name="city" >
                                    <option>Select your Municipality or City</option>
                                    <option value="Aborlan" data-city="Palawan" id="Aborlan">Aborlan</option>
                                    <option value="Abra de Ilog" data-city="Occidental Mindoro" id="Abra de Ilog">Abra de Ilog</option>
                                    <option value="Abucay" data-city="Bataan" id="Abucay">Abucay</option>
                                    <option value="Abulug" data-city="Cagayan" id="Abulug">Abulug</option>
                                    <option value="Abuyog" data-city="Leyte" id="Abuyog">Abuyog</option>
                                    <option value="Adams" data-city="Ilocos Norte" id="Adams">Adams</option>
                                    <option value="Agdangan" data-city="Quezon" id="Agdangan">Agdangan</option>
                                    <option value="Aglipay" data-city="Quirino" id="Aglipay">Aglipay</option>
                                    <option value="Agno" data-city="Pangasinan" id="Agno">Agno</option>
                                    <option value="Agoncillo" data-city="Batangas" id="Agoncillo">Agoncillo</option>
                                    <option value="Agoo" data-city="La Union" id="Agoo">Agoo</option>
                                    <option value="Aguilar" data-city="Pangasinan" id="Aguilar">Aguilar</option>
                                    <option value="Aguinaldo" data-city="Ifugao" id="Aguinaldo">Aguinaldo</option>
                                    <option value="Agutaya" data-city="Palawan" id="Agutaya">Agutaya</option>
                                    <option value="Ajuy" data-city="Iloilo" id="Ajuy">Ajuy</option>
                                    <option value="Akbar" data-city="Basilan" id="Akbar">Akbar</option>
                                    <option value="Al-Barka" data-city="Basilan" id="Al-Barka">Al-Barka</option>
                                    <option value="Alabat" data-city="Quezon" id="Alabat">Alabat</option>
                                    <option value="Alabel" data-city="Sarangani" id="Alabel">Alabel</option>
                                    <option value="Alamada" data-city="Cotabato" id="Alamada">Alamada</option>
                                    <option value="Alaminos" data-city="Laguna" id="Alaminos">Alaminos</option>
                                    <option value="Alangalang" data-city="Leyte" id="Alangalang">Alangalang</option>
                                    <option value="Albuera" data-city="Leyte" id="Albuera">Albuera</option>
                                    <option value="Alburquerque" data-city="Bohol" id="Alburquerque">Alburquerque</option>
                                    <option value="Alcala" data-city="Cagayan" id="Alcala">Alcala</option>
                                    <option value="Alcantara" data-city="Cebu" id="Alcantara">Alcantara</option>
                                    <option value="Alcoy" data-city="Cebu" id="Alcoy">Alcoy</option>
                                    <option value="Alegria" data-city="Cebu" id="Alegria">Alegria</option>
                                    <option value="Aleosan" data-city="Cotabato" id="Aleosan">Aleosan</option>
                                    <option value="Alfonso" data-city="Cavite" id="Alfonso">Alfonso</option>
                                    <option value="" data-city="Nueva Vizcaya" id=""></option>
                                    <option value="Alfonso Lista" data-city="Ifugao" id="Alfonso Lista">Alfonso Lista</option>
                                    <option value="Aliaga" data-city="Nueva Ecija" id="Aliaga">Aliaga</option>
                                    <option value="Alicia" data-city="Bohol" id="Alicia">Alicia</option>
                                    <option value="Alilem" data-city="Ilocos Sur" id="Alilem">Alilem</option>
                                    <option value="Alimodian" data-city="Iloilo" id="Alimodian">Alimodian</option>
                                    <option value="Alitagtag" data-city="Batangas" id="Alitagtag">Alitagtag</option>
                                    <option value="Allacapan" data-city="Cagayan" id="Allacapan">Allacapan</option>
                                    <option value="Allen" data-city="Northern Samar" id="Allen">Allen</option>
                                    <option value="Almagro" data-city="Samar" id="Almagro">Almagro</option>
                                    <option value="Almeria" data-city="Biliran" id="Almeria">Almeria</option>
                                    <option value="Aloguinsan" data-city="Cebu" id="Aloguinsan">Aloguinsan</option>
                                    <option value="Aloran" data-city="Misamis Occidental" id="Aloran">Aloran</option>
                                    <option value="Altavas" data-city="Aklan" id="Altavas">Altavas</option>
                                    <option value="Alubijid" data-city="Misamis Oriental" id="Alubijid">Alubijid</option>
                                    <option value="Amadeo" data-city="Cavite" id="Amadeo">Amadeo</option>
                                    <option value="Amai Manabilang" data-city="Lanao del Sur" id="Amai Manabilang">Amai Manabilang</option>
                                    <option value="Ambaguio" data-city="Nueva Vizcaya" id="Ambaguio">Ambaguio</option>
                                    <option value="Amlan" data-city="Negros Oriental" id="Amlan">Amlan</option>
                                    <option value="Ampatuan" data-city="Maguindanao" id="Ampatuan">Ampatuan</option>
                                    <option value="Amulung" data-city="Cagayan" id="Amulung">Amulung</option>
                                    <option value="Anahawan" data-city="Southern Leyte" id="Anahawan">Anahawan</option>
                                    <option value="Anao" data-city="Tarlac" id="Anao">Anao</option>
                                    <option value="Anda" data-city="Bohol" id="Anda">Anda</option>
                                    <option value="Angadanan" data-city="Isabela" id="Angadanan">Angadanan</option>
                                    <option value="Angat" data-city="Bulacan" id="Angat">Angat</option>
                                    <option value="Angeles" data-city="Pampanga" id="Angeles">Angeles</option>
                                    <option value="Angono" data-city="Rizal" id="Angono">Angono</option>
                                    <option value="Anilao" data-city="Iloilo" id="Anilao">Anilao</option>
                                    <option value="Anini-y" data-city="Antique" id="Anini-y">Anini-y</option>
                                    <option value="Antequera" data-city="Bohol" id="Antequera">Antequera</option>
                                    <option value="Antipas" data-city="Cotabato" id="Antipas">Antipas</option>
                                    <option value="Antipolo" data-city="Rizal" id="Antipolo">Antipolo</option>
                                    <option value="Apalit" data-city="Pampanga" id="Apalit">Apalit</option>
                                    <option value="Aparri" data-city="Cagayan" id="Aparri">Aparri</option>
                                    <option value="Araceli" data-city="Palawan" id="Araceli">Araceli</option>
                                    <option value="Arakan" data-city="Cotabato" id="Arakan">Arakan</option>
                                    <option value="Arayat" data-city="Pampanga" id="Arayat">Arayat</option>
                                    <option value="Argao" data-city="Cebu" id="Argao">Argao</option>
                                    <option value="Aringay" data-city="La Union" id="Aringay">Aringay</option>
                                    <option value="Aritao" data-city="Nueva Vizcaya" id="Aritao">Aritao</option>
                                    <option value="Aroroy" data-city="Masbate" id="Aroroy">Aroroy</option>
                                    <option value="Arteche" data-city="Eastern Samar" id="Arteche">Arteche</option>
                                    <option value="Asingan" data-city="Pangasinan" id="Asingan">Asingan</option>
                                    <option value="Asipulo" data-city="Ifugao" id="Asipulo">Asipulo</option>
                                    <option value="Asturias" data-city="Cebu" id="Asturias">Asturias</option>
                                    <option value="Asuncion" data-city="Davao del Norte" id="Asuncion">Asuncion</option>
                                    <option value="Atimonan" data-city="Quezon" id="Atimonan">Atimonan</option>
                                    <option value="Atok" data-city="Benguet" id="Atok">Atok</option>
                                    <option value="Aurora" data-city="Isabela" id="Aurora">Aurora</option>
                                    <option value="Ayungon" data-city="Negros Oriental" id="Ayungon">Ayungon</option>
                                    <option value="Baao" data-city="Camarines Sur" id="Baao">Baao</option>
                                    <option value="Babatngon" data-city="Leyte" id="Babatngon">Babatngon</option>
                                    <option value="Bacacay" data-city="Albay" id="Bacacay">Bacacay</option>
                                    <option value="Bacarra" data-city="Ilocos Norte" id="Bacarra">Bacarra</option>
                                    <option value="Baclayon" data-city="Bohol" id="Baclayon">Baclayon</option>
                                    <option value="Bacnotan" data-city="La Union" id="Bacnotan">Bacnotan</option>
                                    <option value="Baco" data-city="Oriental Mindoro" id="Baco">Baco</option>
                                    <option value="Bacolod" data-city="Lanao del Norte" id="Bacolod">Bacolod</option>
                                    <option value="Bacolod-Kalawi" data-city="Lanao del Sur" id="Bacolod-Kalawi">Bacolod-Kalawi</option>
                                    <option value="Bacolor" data-city="Pampanga" id="Bacolor">Bacolor</option>
                                    <option value="Bacong" data-city="Negros Oriental" id="Bacong">Bacong</option>
                                    <option value="Bacoor" data-city="Cavite" id="Bacoor">Bacoor</option>
                                    <option value="Bacuag" data-city="Surigao del Norte" id="Bacuag">Bacuag</option>
                                    <option value="Badian" data-city="Cebu" id="Badian">Badian</option>
                                    <option value="Badiangan" data-city="Iloilo" id="Badiangan">Badiangan</option>
                                    <option value="Badoc" data-city="Ilocos Norte" id="Badoc">Badoc</option>
                                    <option value="Bagabag" data-city="Nueva Vizcaya" id="Bagabag">Bagabag</option>
                                    <option value="Bagac" data-city="Bataan" id="Bagac">Bagac</option>
                                    <option value="Bagamanoc" data-city="Catanduanes" id="Bagamanoc">Bagamanoc</option>
                                    <option value="Baganga" data-city="Davao Oriental" id="Baganga">Baganga</option>
                                    <option value="Baggao" data-city="Cagayan" id="Baggao">Baggao</option>
                                    <option value="Bago" data-city="Negros Occidental" id="Bago">Bago</option>
                                    <option value="Baguio" data-city="Benguet" id="Baguio">Baguio</option>
                                    <option value="Bagulin" data-city="La Union" id="Bagulin">Bagulin</option>
                                    <option value="Bagumbayan" data-city="Sultan Kudarat" id="Bagumbayan">Bagumbayan</option>
                                    <option value="Bais" data-city="Negros Oriental" id="Bais">Bais</option>
                                    <option value="Bakun" data-city="Benguet" id="Bakun">Bakun</option>
                                    <option value="Balabac" data-city="Palawan" id="Balabac">Balabac</option>
                                    <option value="Balabagan" data-city="Lanao del Sur" id="Balabagan">Balabagan</option>
                                    <option value="Balagtas" data-city="Bulacan" id="Balagtas">Balagtas</option>
                                    <option value="Balamban" data-city="Cebu" id="Balamban">Balamban</option>
                                    <option value="Balanga" data-city="Bataan" id="Balanga">Balanga</option>
                                    <option value="Balangiga" data-city="Eastern Samar" id="Balangiga">Balangiga</option>
                                    <option value="Balangkayan" data-city="Eastern Samar" id="Balangkayan">Balangkayan</option>
                                    <option value="Balaoan" data-city="La Union" id="Balaoan">Balaoan</option>
                                    <option value="Balasan" data-city="Iloilo" id="Balasan">Balasan</option>
                                    <option value="Balatan" data-city="Camarines Sur" id="Balatan">Balatan</option>
                                    <option value="Balayan" data-city="Batangas" id="Balayan">Balayan</option>
                                    <option value="Balbalan" data-city="Kalinga" id="Balbalan">Balbalan</option>
                                    <option value="Baleno" data-city="Masbate" id="Baleno">Baleno</option>
                                    <option value="Baler" data-city="Aurora" id="Baler">Baler</option>
                                    <option value="Balete" data-city="Aklan" id="Balete">Balete</option>
                                    <option value="Baliangao" data-city="Misamis Occidental" id="Baliangao">Baliangao</option>
                                    <option value="Baliguian" data-city="Zamboanga del Norte" id="Baliguian">Baliguian</option>
                                    <option value="Balilihan" data-city="Bohol" id="Balilihan">Balilihan</option>
                                    <option value="Balindong" data-city="Lanao del Sur" id="Balindong">Balindong</option>
                                    <option value="Balingasag" data-city="Misamis Oriental" id="Balingasag">Balingasag</option>
                                    <option value="Balingoan" data-city="Misamis Oriental" id="Balingoan">Balingoan</option>
                                    <option value="Baliuag" data-city="Bulacan" id="Baliuag">Baliuag</option>
                                    <option value="Ballesteros" data-city="Cagayan" id="Ballesteros">Ballesteros</option>
                                    <option value="Balo-i" data-city="Lanao del Norte" id="Balo-i">Balo-i</option>
                                    <option value="Balud" data-city="Masbate" id="Balud">Balud</option>
                                    <option value="Balungao" data-city="Pangasinan" id="Balungao">Balungao</option>
                                    <option value="Bamban" data-city="Tarlac" id="Bamban">Bamban</option>
                                    <option value="Bambang" data-city="Nueva Vizcaya" id="Bambang">Bambang</option>
                                    <option value="Banate" data-city="Iloilo" id="Banate">Banate</option>
                                    <option value="Banaue" data-city="Ifugao" id="Banaue">Banaue</option>
                                    <option value="Banaybanay" data-city="Davao Oriental" id="Banaybanay">Banaybanay</option>
                                    <option value="Banayoyo" data-city="Ilocos Sur" id="Banayoyo">Banayoyo</option>
                                    <option value="Banga" data-city="Aklan" id="Banga">Banga</option>
                                    <option value="Bangar" data-city="La Union" id="Bangar">Bangar</option>
                                    <option value="Bangued" data-city="Abra" id="Bangued">Bangued</option>
                                    <option value="Bangui" data-city="Ilocos Norte" id="Bangui">Bangui</option>
                                    <option value="Banguingui" data-city="Sulu" id="Banguingui">Banguingui</option>
                                    <option value="Bani" data-city="Pangasinan" id="Bani">Bani</option>
                                    <option value="Banisilan" data-city="Cotabato" id="Banisilan">Banisilan</option>
                                    <option value="Banna" data-city="Ilocos Norte" id="Banna">Banna</option>
                                    <option value="Bansalan" data-city="Davao del Sur" id="Bansalan">Bansalan</option>
                                    <option value="Bansud" data-city="Oriental Mindoro" id="Bansud">Bansud</option>
                                    <option value="Bantay" data-city="Ilocos Sur" id="Bantay">Bantay</option>
                                    <option value="Bantayan" data-city="Cebu" id="Bantayan">Bantayan</option>
                                    <option value="Banton" data-city="Romblon" id="Banton">Banton</option>
                                    <option value="Baras" data-city="Catanduanes" id="Baras">Baras</option>
                                    <option value="Barbaza" data-city="Antique" id="Barbaza">Barbaza</option>
                                    <option value="Barcelona" data-city="Sorsogon" id="Barcelona">Barcelona</option>
                                    <option value="Barili" data-city="Cebu" id="Barili">Barili</option>
                                    <option value="Barira" data-city="Maguindanao" id="Barira">Barira</option>
                                    <option value="Barlig" data-city="Mountain Province" id="Barlig">Barlig</option>
                                    <option value="Barobo" data-city="Surigao del Sur" id="Barobo">Barobo</option>
                                    <option value="Barotac Nuevo" data-city="Iloilo" id="Barotac Nuevo">Barotac Nuevo</option>
                                    <option value="Barotac Viejo" data-city="Iloilo" id="Barotac Viejo">Barotac Viejo</option>
                                    <option value="Baroy" data-city="Lanao del Norte" id="Baroy">Baroy</option>
                                    <option value="Barugo" data-city="Leyte" id="Barugo">Barugo</option>
                                    <option value="Basay" data-city="Negros Oriental" id="Basay">Basay</option>
                                    <option value="Basco" data-city="Batanes" id="Basco">Basco</option>
                                    <option value="Basey" data-city="Samar" id="Basey">Basey</option>
                                    <option value="Basilisa" data-city="Dinagat Islands" id="Basilisa">Basilisa</option>
                                    <option value="Basista" data-city="Pangasinan" id="Basista">Basista</option>
                                    <option value="Basud" data-city="Camarines Norte" id="Basud">Basud</option>
                                    <option value="Batac" data-city="Ilocos Norte" id="Batac">Batac</option>
                                    <option value="Batad" data-city="Iloilo" id="Batad">Batad</option>
                                    <option value="Batan" data-city="Aklan" id="Batan">Batan</option>
                                    <option value="Batangas City" data-city="Batangas" id="Batangas City">Batangas City</option>
                                    <option value="Bataraza" data-city="Palawan" id="Bataraza">Bataraza</option>
                                    <option value="Bato" data-city="Camarines Sur" id="Bato">Bato</option>
                                    <option value="Batuan" data-city="Bohol" id="Batuan">Batuan</option>
                                    <option value="Bauan" data-city="Batangas" id="Bauan">Bauan</option>
                                    <option value="Bauang" data-city="La Union" id="Bauang">Bauang</option>
                                    <option value="Bauko" data-city="Mountain Province" id="Bauko">Bauko</option>
                                    <option value="Baungon" data-city="Bukidnon" id="Baungon">Baungon</option>
                                    <option value="Bautista" data-city="Pangasinan" id="Bautista">Bautista</option>
                                    <option value="Bay" data-city="Laguna" id="Bay">Bay</option>
                                    <option value="Bayabas" data-city="Surigao del Sur" id="Bayabas">Bayabas</option>
                                    <option value="Bayambang" data-city="Pangasinan" id="Bayambang">Bayambang</option>
                                    <option value="Bayang" data-city="Lanao del Sur" id="Bayang">Bayang</option>
                                    <option value="Bayawan" data-city="Negros Oriental" id="Bayawan">Bayawan</option>
                                    <option value="Baybay" data-city="Leyte" id="Baybay">Baybay</option>
                                    <option value="Bayog" data-city="Zamboanga del Sur" id="Bayog">Bayog</option>
                                    <option value="Bayombong" data-city="Nueva Vizcaya" id="Bayombong">Bayombong</option>
                                    <option value="Bayugan" data-city="Agusan del Sur" id="Bayugan">Bayugan</option>
                                    <option value="Belison" data-city="Antique" id="Belison">Belison</option>
                                    <option value="Benito Soliven" data-city="Isabela" id="Benito Soliven">Benito Soliven</option>
                                    <option value="Besao" data-city="Mountain Province" id="Besao">Besao</option>
                                    <option value="Bien Unido" data-city="Bohol" id="Bien Unido">Bien Unido</option>
                                    <option value="Bilar" data-city="Bohol" id="Bilar">Bilar</option>
                                    <option value="Biliran" data-city="Biliran" id="Biliran">Biliran</option>
                                    <option value="Binalbagan" data-city="Negros Occidental" id="Binalbagan">Binalbagan</option>
                                    <option value="Binalonan" data-city="Pangasinan" id="Binalonan">Binalonan</option>
                                    <option value="" data-city="Laguna" id=""></option>
                                    <option value="Binangonan" data-city="Rizal" id="Binangonan">Binangonan</option>
                                    <option value="Bindoy" data-city="Negros Oriental" id="Bindoy">Bindoy</option>
                                    <option value="Bingawan" data-city="Iloilo" id="Bingawan">Bingawan</option>
                                    <option value="Binidayan" data-city="Lanao del Sur" id="Binidayan">Binidayan</option>
                                    <option value="Binmaley" data-city="Pangasinan" id="Binmaley">Binmaley</option>
                                    <option value="Binuangan" data-city="Misamis Oriental" id="Binuangan">Binuangan</option>
                                    <option value="Biri" data-city="Northern Samar" id="Biri">Biri</option>
                                    <option value="Bislig" data-city="Surigao del Sur" id="Bislig">Bislig</option>
                                    <option value="Boac" data-city="Marinduque" id="Boac">Boac</option>
                                    <option value="Bobon" data-city="Northern Samar" id="Bobon">Bobon</option>
                                    <option value="Bocaue" data-city="Bulacan" id="Bocaue">Bocaue</option>
                                    <option value="Bogo" data-city="Cebu" id="Bogo">Bogo</option>
                                    <option value="Bokod" data-city="Benguet" id="Bokod">Bokod</option>
                                    <option value="Bolinao" data-city="Pangasinan" id="Bolinao">Bolinao</option>
                                    <option value="Boliney" data-city="Abra" id="Boliney">Boliney</option>
                                    <option value="Boljoon" data-city="Cebu" id="Boljoon">Boljoon</option>
                                    <option value="Bombon" data-city="Camarines Sur" id="Bombon">Bombon</option>
                                    <option value="Bongabon" data-city="Nueva Ecija" id="Bongabon">Bongabon</option>
                                    <option value="Bongabong" data-city="Oriental Mindoro" id="Bongabong">Bongabong</option>
                                    <option value="Bongao" data-city="Tawi-Tawi" id="Bongao">Bongao</option>
                                    <option value="Bonifacio" data-city="Misamis Occidental" id="Bonifacio">Bonifacio</option>
                                    <option value="Bontoc" data-city="Mountain Province" id="Bontoc">Bontoc</option>
                                    <option value="Borbon" data-city="Cebu" id="Borbon">Borbon</option>
                                    <option value="Borongan" data-city="Eastern Samar" id="Borongan">Borongan</option>
                                    <option value="Boston" data-city="Davao Oriental" id="Boston">Boston</option>
                                    <option value="Botolan" data-city="Zambales" id="Botolan">Botolan</option>
                                    <option value="Braulio E. Dujali" data-city="Davao del Norte" id="Braulio E. Dujali">Braulio E. Dujali</option>
                                    <option value="Brooke's Point" data-city="Palawan" id="Brooke's Point">Brooke's Point</option>
                                    <option value="Buadiposo-Buntong" data-city="Lanao del Sur" id="Buadiposo-Buntong">Buadiposo-Buntong</option>
                                    <option value="Bubong" data-city="Lanao del Sur" id="Bubong">Bubong</option>
                                    <option value="Bucay" data-city="Abra" id="Bucay">Bucay</option>
                                    <option value="Bucloc" data-city="Abra" id="Bucloc">Bucloc</option>
                                    <option value="Buenavista" data-city="Agusan del Norte" id="Buenavista">Buenavista</option>
                                    <option value="Bugallon" data-city="Pangasinan" id="Bugallon">Bugallon</option>
                                    <option value="Bugasong" data-city="Antique" id="Bugasong">Bugasong</option>
                                    <option value="Buguey" data-city="Cagayan" id="Buguey">Buguey</option>
                                    <option value="Buguias" data-city="Benguet" id="Buguias">Buguias</option>
                                    <option value="Buhi" data-city="Camarines Sur" id="Buhi">Buhi</option>
                                    <option value="Bula" data-city="Camarines Sur" id="Bula">Bula</option>
                                    <option value="Bulakan" data-city="Bulacan" id="Bulakan">Bulakan</option>
                                    <option value="Bulalacao" data-city="Oriental Mindoro" id="Bulalacao">Bulalacao</option>
                                    <option value="Bulan" data-city="Sorsogon" id="Bulan">Bulan</option>
                                    <option value="Buldon" data-city="Maguindanao" id="Buldon">Buldon</option>
                                    <option value="Buluan" data-city="Maguindanao" id="Buluan">Buluan</option>
                                    <option value="Bulusan" data-city="Sorsogon" id="Bulusan">Bulusan</option>
                                    <option value="Bunawan" data-city="Agusan del Sur" id="Bunawan">Bunawan</option>
                                    <option value="Burauen" data-city="Leyte" id="Burauen">Burauen</option>
                                    <option value="Burdeos" data-city="Quezon" id="Burdeos">Burdeos</option>
                                    <option value="Burgos" data-city="Ilocos Norte" id="Burgos">Burgos</option>
                                    <option value="Buruanga" data-city="Aklan" id="Buruanga">Buruanga</option>
                                    <option value="Bustos" data-city="Bulacan" id="Bustos">Bustos</option>
                                    <option value="Busuanga" data-city="Palawan" id="Busuanga">Busuanga</option>
                                    <option value="Butig" data-city="Lanao del Sur" id="Butig">Butig</option>
                                    <option value="Butuan" data-city="Agusan del Norte" id="Butuan">Butuan</option>
                                    <option value="Buug" data-city="Zamboanga Sibugay" id="Buug">Buug</option>
                                    <option value="Caba" data-city="La Union" id="Caba">Caba</option>
                                    <option value="Cabadbaran" data-city="Agusan del Norte" id="Cabadbaran">Cabadbaran</option>
                                    <option value="Cabagan" data-city="Isabela" id="Cabagan">Cabagan</option>
                                    <option value="Cabanatuan" data-city="Nueva Ecija" id="Cabanatuan">Cabanatuan</option>
                                    <option value="Cabangan" data-city="Zambales" id="Cabangan">Cabangan</option>
                                    <option value="Cabanglasan" data-city="Bukidnon" id="Cabanglasan">Cabanglasan</option>
                                    <option value="Cabarroguis" data-city="Quirino" id="Cabarroguis">Cabarroguis</option>
                                    <option value="Cabatuan" data-city="Iloilo" id="Cabatuan">Cabatuan</option>
                                    <option value="Cabiao" data-city="Nueva Ecija" id="Cabiao">Cabiao</option>
                                    <option value="Cabucgayan" data-city="Biliran" id="Cabucgayan">Cabucgayan</option>
                                    <option value="Cabugao" data-city="Ilocos Sur" id="Cabugao">Cabugao</option>
                                    <option value="Cabusao" data-city="Camarines Sur" id="Cabusao">Cabusao</option>
                                    <option value="Cabuyao" data-city="Laguna" id="Cabuyao">Cabuyao</option>
                                    <option value="Cadiz" data-city="Negros Occidental" id="Cadiz">Cadiz</option>
                                    <option value="Cagayan de Oro" data-city="Misamis Oriental" id="Cagayan de Oro">Cagayan de Oro</option>
                                    <option value="Cagayancillo" data-city="Palawan" id="Cagayancillo">Cagayancillo</option>
                                    <option value="Cagdianao" data-city="Dinagat Islands" id="Cagdianao">Cagdianao</option>
                                    <option value="Cagwait" data-city="Surigao del Sur" id="Cagwait">Cagwait</option>
                                    <option value="Caibiran" data-city="Biliran" id="Caibiran">Caibiran</option>
                                    <option value="Cainta" data-city="Rizal" id="Cainta">Cainta</option>
                                    <option value="Cajidiocan" data-city="Romblon" id="Cajidiocan">Cajidiocan</option>
                                    <option value="Calabanga" data-city="Camarines Sur" id="Calabanga">Calabanga</option>
                                    <option value="Calaca" data-city="Batangas" id="Calaca">Calaca</option>
                                    <option value="Calamba" data-city="Laguna" id="Calamba">Calamba</option>
                                    <option value="Calanasan" data-city="Apayao" id="Calanasan">Calanasan</option>
                                    <option value="Calanogas" data-city="Lanao del Sur" id="Calanogas">Calanogas</option>
                                    <option value="Calapan" data-city="Oriental Mindoro" id="Calapan">Calapan</option>
                                    <option value="Calape" data-city="Bohol" id="Calape">Calape</option>
                                    <option value="Calasiao" data-city="Pangasinan" id="Calasiao">Calasiao</option>
                                    <option value="Calatagan" data-city="Batangas" id="Calatagan">Calatagan</option>
                                    <option value="Calatrava" data-city="Negros Occidental" id="Calatrava">Calatrava</option>
                                    <option value="Calauag" data-city="Quezon" id="Calauag">Calauag</option>
                                    <option value="Calauan" data-city="Laguna" id="Calauan">Calauan</option>
                                    <option value="Calayan" data-city="Cagayan" id="Calayan">Calayan</option>
                                    <option value="Calbayog" data-city="Samar" id="Calbayog">Calbayog</option>
                                    <option value="Calbiga" data-city="Samar" id="Calbiga">Calbiga</option>
                                    <option value="Calinog" data-city="Iloilo" id="Calinog">Calinog</option>
                                    <option value="Calintaan" data-city="Occidental Mindoro" id="Calintaan">Calintaan</option>
                                    <option value="Caloocan" data-city="Metro Manila" id="Caloocan">Caloocan</option>
                                    <option value="Calubian" data-city="Leyte" id="Calubian">Calubian</option>
                                    <option value="Calumpit" data-city="Bulacan" id="Calumpit">Calumpit</option>
                                    <option value="Caluya" data-city="Antique" id="Caluya">Caluya</option>
                                    <option value="Camalaniugan" data-city="Cagayan" id="Camalaniugan">Camalaniugan</option>
                                    <option value="Camalig" data-city="Albay" id="Camalig">Camalig</option>
                                    <option value="Camaligan" data-city="Camarines Sur" id="Camaligan">Camaligan</option>
                                    <option value="Camiling" data-city="Tarlac" id="Camiling">Camiling</option>
                                    <option value="Can-avid" data-city="Eastern Samar" id="Can-avid">Can-avid</option>
                                    <option value="Canaman" data-city="Camarines Sur" id="Canaman">Canaman</option>
                                    <option value="Candaba" data-city="Pampanga" id="Candaba">Candaba</option>
                                    <option value="Candelaria" data-city="Quezon" id="Candelaria">Candelaria</option>
                                    <option value="Candijay" data-city="Bohol" id="Candijay">Candijay</option>
                                    <option value="Candon" data-city="Ilocos Sur" id="Candon">Candon</option>
                                    <option value="Candoni" data-city="Negros Occidental" id="Candoni">Candoni</option>
                                    <option value="Canlaon" data-city="Negros Oriental" id="Canlaon">Canlaon</option>
                                    <option value="Cantilan" data-city="Surigao del Sur" id="Cantilan">Cantilan</option>
                                    <option value="Caoayan" data-city="Ilocos Sur" id="Caoayan">Caoayan</option>
                                    <option value="Capalonga" data-city="Camarines Norte" id="Capalonga">Capalonga</option>
                                    <option value="Capas" data-city="Tarlac" id="Capas">Capas</option>
                                    <option value="Capoocan" data-city="Leyte" id="Capoocan">Capoocan</option>
                                    <option value="Capul" data-city="Northern Samar" id="Capul">Capul</option>
                                    <option value="Caraga" data-city="Davao Oriental" id="Caraga">Caraga</option>
                                    <option value="Caramoan" data-city="Camarines Sur" id="Caramoan">Caramoan</option>
                                    <option value="Caramoran" data-city="Catanduanes" id="Caramoran">Caramoran</option>
                                    <option value="Carasi" data-city="Ilocos Norte" id="Carasi">Carasi</option>
                                    <option value="Carcar" data-city="Cebu" id="Carcar">Carcar</option>
                                    <option value="Cardona" data-city="Rizal" id="Cardona">Cardona</option>
                                    <option value="Carigara" data-city="Leyte" id="Carigara">Carigara</option>
                                    <option value="Carles" data-city="Iloilo" id="Carles">Carles</option>
                                    <option value="Carmen" data-city="Agusan del Norte" id="Carmen">Carmen</option>
                                    <option value="Carmona" data-city="Cavite" id="Carmona">Carmona</option>
                                    <option value="Carranglan" data-city="Nueva Ecija" id="Carranglan">Carranglan</option>
                                    <option value="Carrascal" data-city="Surigao del Sur" id="Carrascal">Carrascal</option>
                                    <option value="Casiguran" data-city="Aurora" id="Casiguran">Casiguran</option>
                                    <option value="Castilla" data-city="Sorsogon" id="Castilla">Castilla</option>
                                    <option value="Castillejos" data-city="Zambales" id="Castillejos">Castillejos</option>
                                    <option value="Cataingan" data-city="Masbate" id="Cataingan">Cataingan</option>
                                    <option value="Catanauan" data-city="Quezon" id="Catanauan">Catanauan</option>
                                    <option value="Catarman" data-city="Camiguin" id="Catarman">Catarman</option>
                                    <option value="Catbalogan" data-city="Samar" id="Catbalogan">Catbalogan</option>
                                    <option value="Cateel" data-city="Davao Oriental" id="Cateel">Cateel</option>
                                    <option value="Catigbian" data-city="Bohol" id="Catigbian">Catigbian</option>
                                    <option value="Catmon" data-city="Cebu" id="Catmon">Catmon</option>
                                    <option value="Catubig" data-city="Northern Samar" id="Catubig">Catubig</option>
                                    <option value="Cauayan" data-city="Isabela" id="Cauayan">Cauayan</option>
                                    <option value="Cavinti" data-city="Laguna" id="Cavinti">Cavinti</option>
                                    <option value="Cavite City" data-city="Cavite" id="Cavite City">Cavite City</option>
                                    <option value="Cawayan" data-city="Masbate" id="Cawayan">Cawayan</option>
                                    <option value="Cebu City" data-city="Cebu" id="Cebu City">Cebu City</option>
                                    <option value="Cervantes" data-city="Ilocos Sur" id="Cervantes">Cervantes</option>
                                    <option value="Clarin" data-city="Bohol" id="Clarin">Clarin</option>
                                    <option value="Claver" data-city="Surigao del Norte" id="Claver">Claver</option>
                                    <option value="Claveria" data-city="Cagayan" id="Claveria">Claveria</option>
                                    <option value="Columbio" data-city="Sultan Kudarat" id="Columbio">Columbio</option>
                                    <option value="Compostela" data-city="Cebu" id="Compostela">Compostela</option>
                                    <option value="Concepcion" data-city="Iloilo" id="Concepcion">Concepcion</option>
                                    <option value="Conner" data-city="Apayao" id="Conner">Conner</option>
                                    <option value="Consolacion" data-city="Cebu" id="Consolacion">Consolacion</option>
                                    <option value="Corcuera" data-city="Romblon" id="Corcuera">Corcuera</option>
                                    <option value="Cordon" data-city="Isabela" id="Cordon">Cordon</option>
                                    <option value="Cordova" data-city="Cebu" id="Cordova">Cordova</option>
                                    <option value="Corella" data-city="Bohol" id="Corella">Corella</option>
                                    <option value="Coron" data-city="Palawan" id="Coron">Coron</option>
                                    <option value="Cortes" data-city="Bohol" id="Cortes">Cortes</option>
                                    <option value="Cotabato City" data-city="Maguindanao" id="Cotabato City">Cotabato City</option>
                                    <option value="Cuartero" data-city="Capiz" id="Cuartero">Cuartero</option>
                                    <option value="Cuenca" data-city="Batangas" id="Cuenca">Cuenca</option>
                                    <option value="Culaba" data-city="Biliran" id="Culaba">Culaba</option>
                                    <option value="Culasi" data-city="Antique" id="Culasi">Culasi</option>
                                    <option value="Culion" data-city="Palawan" id="Culion">Culion</option>
                                    <option value="Currimao" data-city="Ilocos Norte" id="Currimao">Currimao</option>
                                    <option value="Cuyapo" data-city="Nueva Ecija" id="Cuyapo">Cuyapo</option>
                                    <option value="Cuyo" data-city="Palawan" id="Cuyo">Cuyo</option>
                                    <option value="Daanbantayan" data-city="Cebu" id="Daanbantayan">Daanbantayan</option>
                                    <option value="Daet" data-city="Camarines Norte" id="Daet">Daet</option>
                                    <option value="Dagami" data-city="Leyte" id="Dagami">Dagami</option>
                                    <option value="Dagohoy" data-city="Bohol" id="Dagohoy">Dagohoy</option>
                                    <option value="Daguioman" data-city="Abra" id="Daguioman">Daguioman</option>
                                    <option value="Dagupan" data-city="Pangasinan" id="Dagupan">Dagupan</option>
                                    <option value="Dalaguete" data-city="Cebu" id="Dalaguete">Dalaguete</option>
                                    <option value="Damulog" data-city="Bukidnon" id="Damulog">Damulog</option>
                                    <option value="Danao" data-city="Bohol" id="Danao">Danao</option>
                                    <option value="Dangcagan" data-city="Bukidnon" id="Dangcagan">Dangcagan</option>
                                    <option value="Danglas" data-city="Abra" id="Danglas">Danglas</option>
                                    <option value="Dao" data-city="Capiz" id="Dao">Dao</option>
                                    <option value="Dapa" data-city="Surigao del Norte" id="Dapa">Dapa</option>
                                    <option value="Dapitan" data-city="Zamboanga del Norte" id="Dapitan">Dapitan</option>
                                    <option value="Daraga" data-city="Albay" id="Daraga">Daraga</option>
                                    <option value="Daram" data-city="Samar" id="Daram">Daram</option>
                                    <option value="" data-city="Cavite" id=""></option>
                                    <option value="Dasol" data-city="Pangasinan" id="Dasol">Dasol</option>
                                    <option value="Datu Abdullah Sangki" data-city="Maguindanao" id="Datu Abdullah Sangki">Datu Abdullah Sangki</option>
                                    <option value="Datu Anggal Midtimbang" data-city="Maguindanao" id="Datu Anggal Midtimbang">Datu Anggal Midtimbang</option>
                                    <option value="Datu Blah T. Sinsuat" data-city="Maguindanao" id="Datu Blah T. Sinsuat">Datu Blah T. Sinsuat</option>
                                    <option value="Datu Hoffer Ampatuan" data-city="Maguindanao" id="Datu Hoffer Ampatuan">Datu Hoffer Ampatuan</option>
                                    <option value="Datu Montawal" data-city="Maguindanao" id="Datu Montawal">Datu Montawal</option>
                                    <option value="Datu Odin Sinsuat" data-city="Maguindanao" id="Datu Odin Sinsuat">Datu Odin Sinsuat</option>
                                    <option value="Datu Paglas" data-city="Maguindanao" id="Datu Paglas">Datu Paglas</option>
                                    <option value="Datu Piang" data-city="Maguindanao" id="Datu Piang">Datu Piang</option>
                                    <option value="Datu Salibo" data-city="Maguindanao" id="Datu Salibo">Datu Salibo</option>
                                    <option value="Datu Saudi-Ampatuan" data-city="Maguindanao" id="Datu Saudi-Ampatuan">Datu Saudi-Ampatuan</option>
                                    <option value="Datu Unsay" data-city="Maguindanao" id="Datu Unsay">Datu Unsay</option>
                                    <option value="Dauin" data-city="Negros Oriental" id="Dauin">Dauin</option>
                                    <option value="Dauis" data-city="Bohol" id="Dauis">Dauis</option>
                                    <option value="Davao City" data-city="Davao del Sur" id="Davao City">Davao City</option>
                                    <option value="Del Carmen" data-city="Surigao del Norte" id="Del Carmen">Del Carmen</option>
                                    <option value="Del Gallego" data-city="Camarines Sur" id="Del Gallego">Del Gallego</option>
                                    <option value="Delfin Albano" data-city="Isabela" id="Delfin Albano">Delfin Albano</option>
                                    <option value="Diadi" data-city="Nueva Vizcaya" id="Diadi">Diadi</option>
                                    <option value="Diffun" data-city="Quirino" id="Diffun">Diffun</option>
                                    <option value="Digos" data-city="Davao del Sur" id="Digos">Digos</option>
                                    <option value="Dilasag" data-city="Aurora" id="Dilasag">Dilasag</option>
                                    <option value="Dimasalang" data-city="Masbate" id="Dimasalang">Dimasalang</option>
                                    <option value="Dimataling" data-city="Zamboanga del Sur" id="Dimataling">Dimataling</option>
                                    <option value="Dimiao" data-city="Bohol" id="Dimiao">Dimiao</option>
                                    <option value="Dinagat" data-city="Dinagat Islands" id="Dinagat">Dinagat</option>
                                    <option value="Dinalungan" data-city="Aurora" id="Dinalungan">Dinalungan</option>
                                    <option value="Dinalupihan" data-city="Bataan" id="Dinalupihan">Dinalupihan</option>
                                    <option value="Dinapigue" data-city="Isabela" id="Dinapigue">Dinapigue</option>
                                    <option value="Dinas" data-city="Zamboanga del Sur" id="Dinas">Dinas</option>
                                    <option value="Dingalan" data-city="Aurora" id="Dingalan">Dingalan</option>
                                    <option value="Dingle" data-city="Iloilo" id="Dingle">Dingle</option>
                                    <option value="Dingras" data-city="Ilocos Norte" id="Dingras">Dingras</option>
                                    <option value="Dipaculao" data-city="Aurora" id="Dipaculao">Dipaculao</option>
                                    <option value="Diplahan" data-city="Zamboanga Sibugay" id="Diplahan">Diplahan</option>
                                    <option value="Dipolog" data-city="Zamboanga del Norte" id="Dipolog">Dipolog</option>
                                    <option value="Ditsaan-Ramain" data-city="Lanao del Sur" id="Ditsaan-Ramain">Ditsaan-Ramain</option>
                                    <option value="Divilacan" data-city="Isabela" id="Divilacan">Divilacan</option>
                                    <option value="Dolores" data-city="Abra" id="Dolores">Dolores</option>
                                    <option value="Don Carlos" data-city="Bukidnon" id="Don Carlos">Don Carlos</option>
                                    <option value="Don Marcelino" data-city="Davao Occidental" id="Don Marcelino">Don Marcelino</option>
                                    <option value="Don Victoriano Chiongbian" data-city="Misamis Occidental" id="Don Victoriano Chiongbian">Don Victoriano Chiongbian</option>
                                    <option value="" data-city="Bulacan" id=""></option>
                                    <option value="Donsol" data-city="Sorsogon" id="Donsol">Donsol</option>
                                    <option value="" data-city="Iloilo" id=""></option>
                                    <option value="Duero" data-city="Bohol" id="Duero">Duero</option>
                                    <option value="Dulag" data-city="Leyte" id="Dulag">Dulag</option>
                                    <option value="Dumaguete" data-city="Negros Oriental" id="Dumaguete">Dumaguete</option>
                                    <option value="Dumalag" data-city="Capiz" id="Dumalag">Dumalag</option>
                                    <option value="Dumalinao" data-city="Zamboanga del Sur" id="Dumalinao">Dumalinao</option>
                                    <option value="Dumalneg" data-city="Ilocos Norte" id="Dumalneg">Dumalneg</option>
                                    <option value="Dumangas" data-city="Iloilo" id="Dumangas">Dumangas</option>
                                    <option value="Dumanjug" data-city="Cebu" id="Dumanjug">Dumanjug</option>
                                    <option value="Dumaran" data-city="Palawan" id="Dumaran">Dumaran</option>
                                    <option value="Dumarao" data-city="Capiz" id="Dumarao">Dumarao</option>
                                    <option value="Dumingag" data-city="Zamboanga del Sur" id="Dumingag">Dumingag</option>
                                    <option value="Dupax del Norte" data-city="Nueva Vizcaya" id="Dupax del Norte">Dupax del Norte</option>
                                    <option value="Dupax del Sur" data-city="Nueva Vizcaya" id="Dupax del Sur">Dupax del Sur</option>
                                    <option value="Echague" data-city="Isabela" id="Echague">Echague</option>
                                    <option value="El Nido" data-city="Palawan" id="El Nido">El Nido</option>
                                    <option value="El Salvador" data-city="Misamis Oriental" id="El Salvador">El Salvador</option>
                                    <option value="Enrile" data-city="Cagayan" id="Enrile">Enrile</option>
                                    <option value="Enrique B. Magalona" data-city="Negros Occidental" id="Enrique B. Magalona">Enrique B. Magalona</option>
                                    <option value="Enrique Villanueva" data-city="Siquijor" id="Enrique Villanueva">Enrique Villanueva</option>
                                    <option value="Escalante" data-city="Negros Occidental" id="Escalante">Escalante</option>
                                    <option value="Esperanza" data-city="Agusan del Sur" id="Esperanza">Esperanza</option>
                                    <option value="Estancia" data-city="Iloilo" id="Estancia">Estancia</option>
                                    <option value="Famy" data-city="Laguna" id="Famy">Famy</option>
                                    <option value="Ferrol" data-city="Romblon" id="Ferrol">Ferrol</option>
                                    <option value="Flora" data-city="Apayao" id="Flora">Flora</option>
                                    <option value="Floridablanca" data-city="Pampanga" id="Floridablanca">Floridablanca</option>
                                    <option value="Gabaldon" data-city="Nueva Ecija" id="Gabaldon">Gabaldon</option>
                                    <option value="Gainza" data-city="Camarines Sur" id="Gainza">Gainza</option>
                                    <option value="Galimuyod" data-city="Ilocos Sur" id="Galimuyod">Galimuyod</option>
                                    <option value="Gamay" data-city="Northern Samar" id="Gamay">Gamay</option>
                                    <option value="Gamu" data-city="Isabela" id="Gamu">Gamu</option>
                                    <option value="Ganassi" data-city="Lanao del Sur" id="Ganassi">Ganassi</option>
                                    <option value="Gandara" data-city="Samar" id="Gandara">Gandara</option>
                                    <option value="Gapan" data-city="Nueva Ecija" id="Gapan">Gapan</option>
                                    <option value="Garchitorena" data-city="Camarines Sur" id="Garchitorena">Garchitorena</option>
                                    <option value="Garcia Hernandez" data-city="Bohol" id="Garcia Hernandez">Garcia Hernandez</option>
                                    <option value="Gasan" data-city="Marinduque" id="Gasan">Gasan</option>
                                    <option value="Gattaran" data-city="Cagayan" id="Gattaran">Gattaran</option>
                                    <option value="General Emilio Aguinaldo" data-city="Cavite" id="General Emilio Aguinaldo">General Emilio Aguinaldo</option>
                                    <option value="General Luna" data-city="Quezon" id="General Luna">General Luna</option>
                                    <option value="General MacArthur" data-city="Eastern Samar" id="General MacArthur">General MacArthur</option>
                                    <option value="General Mamerto Natividad" data-city="Nueva Ecija" id="General Mamerto Natividad">General Mamerto Natividad</option>
                                    <option value="General Mariano Alvarez" data-city="Cavite" id="General Mariano Alvarez">General Mariano Alvarez</option>
                                    <option value="General Nakar" data-city="Quezon" id="General Nakar">General Nakar</option>
                                    <option value="General Salipada K. Pendatun" data-city="Maguindanao" id="General Salipada K. Pendatun">General Salipada K. Pendatun</option>
                                    <option value="General Santos" data-city="South Cotabato" id="General Santos">General Santos</option>
                                    <option value="General Tinio" data-city="Nueva Ecija" id="General Tinio">General Tinio</option>
                                    <option value="General Trias" data-city="Cavite" id="General Trias">General Trias</option>
                                    <option value="Gerona" data-city="Tarlac" id="Gerona">Gerona</option>
                                    <option value="Getafe" data-city="Bohol" id="Getafe">Getafe</option>
                                    <option value="Gigaquit" data-city="Surigao del Norte" id="Gigaquit">Gigaquit</option>
                                    <option value="Gigmoto" data-city="Catanduanes" id="Gigmoto">Gigmoto</option>
                                    <option value="Ginatilan" data-city="Cebu" id="Ginatilan">Ginatilan</option>
                                    <option value="Gingoog" data-city="Misamis Oriental" id="Gingoog">Gingoog</option>
                                    <option value="Giporlos" data-city="Eastern Samar" id="Giporlos">Giporlos</option>
                                    <option value="Gitagum" data-city="Misamis Oriental" id="Gitagum">Gitagum</option>
                                    <option value="Glan" data-city="Sarangani" id="Glan">Glan</option>
                                    <option value="Gloria" data-city="Oriental Mindoro" id="Gloria">Gloria</option>
                                    <option value="Goa" data-city="Camarines Sur" id="Goa">Goa</option>
                                    <option value="Godod" data-city="Zamboanga del Norte" id="Godod">Godod</option>
                                    <option value="Gonzaga" data-city="Cagayan" id="Gonzaga">Gonzaga</option>
                                    <option value="Governor Generoso" data-city="Davao Oriental" id="Governor Generoso">Governor Generoso</option>
                                    <option value="Gregorio del Pilar" data-city="Ilocos Sur" id="Gregorio del Pilar">Gregorio del Pilar</option>
                                    <option value="Guagua" data-city="Pampanga" id="Guagua">Guagua</option>
                                    <option value="Gubat" data-city="Sorsogon" id="Gubat">Gubat</option>
                                    <option value="Guiguinto" data-city="Bulacan" id="Guiguinto">Guiguinto</option>
                                    <option value="Guihulngan" data-city="Negros Oriental" id="Guihulngan">Guihulngan</option>
                                    <option value="Guimba" data-city="Nueva Ecija" id="Guimba">Guimba</option>
                                    <option value="Guimbal" data-city="Iloilo" id="Guimbal">Guimbal</option>
                                    <option value="Guinayangan" data-city="Quezon" id="Guinayangan">Guinayangan</option>
                                    <option value="Guindulman" data-city="Bohol" id="Guindulman">Guindulman</option>
                                    <option value="Guindulungan" data-city="Maguindanao" id="Guindulungan">Guindulungan</option>
                                    <option value="Guinobatan" data-city="Albay" id="Guinobatan">Guinobatan</option>
                                    <option value="Guinsiliban" data-city="Camiguin" id="Guinsiliban">Guinsiliban</option>
                                    <option value="Guipos" data-city="Zamboanga del Sur" id="Guipos">Guipos</option>
                                    <option value="Guiuan" data-city="Eastern Samar" id="Guiuan">Guiuan</option>
                                    <option value="Gumaca" data-city="Quezon" id="Gumaca">Gumaca</option>
                                    <option value="Gutalac" data-city="Zamboanga del Norte" id="Gutalac">Gutalac</option>
                                    <option value="Hadji Mohammad Ajul" data-city="Basilan" id="Hadji Mohammad Ajul">Hadji Mohammad Ajul</option>
                                    <option value="Hadji Muhtamad" data-city="Basilan" id="Hadji Muhtamad">Hadji Muhtamad</option>
                                    <option value="Hadji Panglima Tahil" data-city="Sulu" id="Hadji Panglima Tahil">Hadji Panglima Tahil</option>
                                    <option value="Hagonoy" data-city="Bulacan" id="Hagonoy">Hagonoy</option>
                                    <option value="Hamtic" data-city="Antique" id="Hamtic">Hamtic</option>
                                    <option value="Hermosa" data-city="Bataan" id="Hermosa">Hermosa</option>
                                    <option value="Hernani" data-city="Eastern Samar" id="Hernani">Hernani</option>
                                    <option value="Hilongos" data-city="Leyte" id="Hilongos">Hilongos</option>
                                    <option value="Himamaylan" data-city="Negros Occidental" id="Himamaylan">Himamaylan</option>
                                    <option value="Hinabangan" data-city="Samar" id="Hinabangan">Hinabangan</option>
                                    <option value="Hinatuan" data-city="Surigao del Sur" id="Hinatuan">Hinatuan</option>
                                    <option value="Hindang" data-city="Leyte" id="Hindang">Hindang</option>
                                    <option value="Hingyon" data-city="Ifugao" id="Hingyon">Hingyon</option>
                                    <option value="Hinigaran" data-city="Negros Occidental" id="Hinigaran">Hinigaran</option>
                                    <option value="Hinoba-an" data-city="Negros Occidental" id="Hinoba-an">Hinoba-an</option>
                                    <option value="Hinunangan" data-city="Southern Leyte" id="Hinunangan">Hinunangan</option>
                                    <option value="Hinundayan" data-city="Southern Leyte" id="Hinundayan">Hinundayan</option>
                                    <option value="Hungduan" data-city="Ifugao" id="Hungduan">Hungduan</option>
                                    <option value="Iba" data-city="Zambales" id="Iba">Iba</option>
                                    <option value="Ibaan" data-city="Batangas" id="Ibaan">Ibaan</option>
                                    <option value="Ibajay" data-city="Aklan" id="Ibajay">Ibajay</option>
                                    <option value="Igbaras" data-city="Iloilo" id="Igbaras">Igbaras</option>
                                    <option value="Iguig" data-city="Cagayan" id="Iguig">Iguig</option>
                                    <option value="Ilagan" data-city="Isabela" id="Ilagan">Ilagan</option>
                                    <option value="Iligan" data-city="Lanao del Norte" id="Iligan">Iligan</option>
                                    <option value="Ilog" data-city="Negros Occidental" id="Ilog">Ilog</option>
                                    <option value="Iloilo City" data-city="Iloilo" id="Iloilo City">Iloilo City</option>
                                    <option value="Imelda" data-city="Zamboanga Sibugay" id="Imelda">Imelda</option>
                                    <option value="Impasugong" data-city="Bukidnon" id="Impasugong">Impasugong</option>
                                    <option value="Imus" data-city="Cavite" id="Imus">Imus</option>
                                    <option value="Inabanga" data-city="Bohol" id="Inabanga">Inabanga</option>
                                    <option value="Indanan" data-city="Sulu" id="Indanan">Indanan</option>
                                    <option value="Indang" data-city="Cavite" id="Indang">Indang</option>
                                    <option value="Infanta" data-city="Pangasinan" id="Infanta">Infanta</option>
                                    <option value="Initao" data-city="Misamis Oriental" id="Initao">Initao</option>
                                    <option value="Inopacan" data-city="Leyte" id="Inopacan">Inopacan</option>
                                    <option value="Ipil" data-city="Zamboanga Sibugay" id="Ipil">Ipil</option>
                                    <option value="Iriga" data-city="Camarines Sur" id="Iriga">Iriga</option>
                                    <option value="Irosin" data-city="Sorsogon" id="Irosin">Irosin</option>
                                    <option value="Isabel" data-city="Leyte" id="Isabel">Isabel</option>
                                    <option value="Isabela" data-city="Basilan" id="Isabela">Isabela</option>
                                    <option value="Isulan" data-city="Sultan Kudarat" id="Isulan">Isulan</option>
                                    <option value="Itbayat" data-city="Batanes" id="Itbayat">Itbayat</option>
                                    <option value="Itogon" data-city="Benguet" id="Itogon">Itogon</option>
                                    <option value="Ivana" data-city="Batanes" id="Ivana">Ivana</option>
                                    <option value="Ivisan" data-city="Capiz" id="Ivisan">Ivisan</option>
                                    <option value="Jabonga" data-city="Agusan del Norte" id="Jabonga">Jabonga</option>
                                    <option value="Jaen" data-city="Nueva Ecija" id="Jaen">Jaen</option>
                                    <option value="Jagna" data-city="Bohol" id="Jagna">Jagna</option>
                                    <option value="Jalajala" data-city="Rizal" id="Jalajala">Jalajala</option>
                                    <option value="Jamindan" data-city="Capiz" id="Jamindan">Jamindan</option>
                                    <option value="Janiuay" data-city="Iloilo" id="Janiuay">Janiuay</option>
                                    <option value="Jaro" data-city="Leyte" id="Jaro">Jaro</option>
                                    <option value="Jasaan" data-city="Misamis Oriental" id="Jasaan">Jasaan</option>
                                    <option value="Javier" data-city="Leyte" id="Javier">Javier</option>
                                    <option value="Jiabong" data-city="Samar" id="Jiabong">Jiabong</option>
                                    <option value="Jimalalud" data-city="Negros Oriental" id="Jimalalud">Jimalalud</option>
                                    <option value="Jimenez" data-city="Misamis Occidental" id="Jimenez">Jimenez</option>
                                    <option value="Jipapad" data-city="Eastern Samar" id="Jipapad">Jipapad</option>
                                    <option value="Jolo" data-city="Sulu" id="Jolo">Jolo</option>
                                    <option value="Jomalig" data-city="Quezon" id="Jomalig">Jomalig</option>
                                    <option value="Jones" data-city="Isabela" id="Jones">Jones</option>
                                    <option value="Jordan" data-city="Guimaras" id="Jordan">Jordan</option>
                                    <option value="Jose Abad Santos" data-city="Davao Occidental" id="Jose Abad Santos">Jose Abad Santos</option>
                                    <option value="Jose Dalman" data-city="Zamboanga del Norte" id="Jose Dalman">Jose Dalman</option>
                                    <option value="Jose Panganiban" data-city="Camarines Norte" id="Jose Panganiban">Jose Panganiban</option>
                                    <option value="Josefina" data-city="Zamboanga del Sur" id="Josefina">Josefina</option>
                                    <option value="Jovellar" data-city="Albay" id="Jovellar">Jovellar</option>
                                    <option value="Juban" data-city="Sorsogon" id="Juban">Juban</option>
                                    <option value="Julita" data-city="Leyte" id="Julita">Julita</option>
                                    <option value="Kabacan" data-city="Cotabato" id="Kabacan">Kabacan</option>
                                    <option value="Kabankalan" data-city="Negros Occidental" id="Kabankalan">Kabankalan</option>
                                    <option value="Kabasalan" data-city="Zamboanga Sibugay" id="Kabasalan">Kabasalan</option>
                                    <option value="Kabayan" data-city="Benguet" id="Kabayan">Kabayan</option>
                                    <option value="Kabugao" data-city="Apayao" id="Kabugao">Kabugao</option>
                                    <option value="Kabuntalan" data-city="Maguindanao" id="Kabuntalan">Kabuntalan</option>
                                    <option value="Kadingilan" data-city="Bukidnon" id="Kadingilan">Kadingilan</option>
                                    <option value="Kalamansig" data-city="Sultan Kudarat" id="Kalamansig">Kalamansig</option>
                                    <option value="Kalawit" data-city="Zamboanga del Norte" id="Kalawit">Kalawit</option>
                                    <option value="Kalayaan" data-city="Laguna" id="Kalayaan">Kalayaan</option>
                                    <option value="Kalibo" data-city="Aklan" id="Kalibo">Kalibo</option>
                                    <option value="Kalilangan" data-city="Bukidnon" id="Kalilangan">Kalilangan</option>
                                    <option value="Kalingalan Caluang" data-city="Sulu" id="Kalingalan Caluang">Kalingalan Caluang</option>
                                    <option value="Kananga" data-city="Leyte" id="Kananga">Kananga</option>
                                    <option value="Kapai" data-city="Lanao del Sur" id="Kapai">Kapai</option>
                                    <option value="Kapalong" data-city="Davao del Norte" id="Kapalong">Kapalong</option>
                                    <option value="Kapangan" data-city="Benguet" id="Kapangan">Kapangan</option>
                                    <option value="Kapatagan" data-city="Lanao del Norte" id="Kapatagan">Kapatagan</option>
                                    <option value="Kasibu" data-city="Nueva Vizcaya" id="Kasibu">Kasibu</option>
                                    <option value="Katipunan" data-city="Zamboanga del Norte" id="Katipunan">Katipunan</option>
                                    <option value="Kauswagan" data-city="Lanao del Norte" id="Kauswagan">Kauswagan</option>
                                    <option value="Kawayan" data-city="Biliran" id="Kawayan">Kawayan</option>
                                    <option value="Kawit" data-city="Cavite" id="Kawit">Kawit</option>
                                    <option value="Kayapa" data-city="Nueva Vizcaya" id="Kayapa">Kayapa</option>
                                    <option value="Kiamba" data-city="Sarangani" id="Kiamba">Kiamba</option>
                                    <option value="Kiangan" data-city="Ifugao" id="Kiangan">Kiangan</option>
                                    <option value="Kibawe" data-city="Bukidnon" id="Kibawe">Kibawe</option>
                                    <option value="Kiblawan" data-city="Davao del Sur" id="Kiblawan">Kiblawan</option>
                                    <option value="Kibungan" data-city="Benguet" id="Kibungan">Kibungan</option>
                                    <option value="Kidapawan" data-city="Cotabato" id="Kidapawan">Kidapawan</option>
                                    <option value="Kinoguitan" data-city="Misamis Oriental" id="Kinoguitan">Kinoguitan</option>
                                    <option value="Kitaotao" data-city="Bukidnon" id="Kitaotao">Kitaotao</option>
                                    <option value="Kitcharao" data-city="Agusan del Norte" id="Kitcharao">Kitcharao</option>
                                    <option value="Kolambugan" data-city="Lanao del Norte" id="Kolambugan">Kolambugan</option>
                                    <option value="Koronadal" data-city="South Cotabato" id="Koronadal">Koronadal</option>
                                    <option value="Kumalarang" data-city="Zamboanga del Sur" id="Kumalarang">Kumalarang</option>
                                    <option value="La Carlota" data-city="Negros Occidental" id="La Carlota">La Carlota</option>
                                    <option value="La Castellana" data-city="Negros Occidental" id="La Castellana">La Castellana</option>
                                    <option value="La Libertad" data-city="Negros Oriental" id="La Libertad">La Libertad</option>
                                    <option value="La Paz" data-city="Abra" id="La Paz">La Paz</option>
                                    <option value="La Trinidad" data-city="Benguet" id="La Trinidad">La Trinidad</option>
                                    <option value="Laak" data-city="Davao de Oro" id="Laak">Laak</option>
                                    <option value="Labangan" data-city="Zamboanga del Sur" id="Labangan">Labangan</option>
                                    <option value="Labason" data-city="Zamboanga del Norte" id="Labason">Labason</option>
                                    <option value="Labo" data-city="Camarines Norte" id="Labo">Labo</option>
                                    <option value="Labrador" data-city="Pangasinan" id="Labrador">Labrador</option>
                                    <option value="Lacub" data-city="Abra" id="Lacub">Lacub</option>
                                    <option value="Lagangilang" data-city="Abra" id="Lagangilang">Lagangilang</option>
                                    <option value="Lagawe" data-city="Ifugao" id="Lagawe">Lagawe</option>
                                    <option value="Lagayan" data-city="Abra" id="Lagayan">Lagayan</option>
                                    <option value="Lagonglong" data-city="Misamis Oriental" id="Lagonglong">Lagonglong</option>
                                    <option value="Lagonoy" data-city="Camarines Sur" id="Lagonoy">Lagonoy</option>
                                    <option value="Laguindingan" data-city="Misamis Oriental" id="Laguindingan">Laguindingan</option>
                                    <option value="Lake Sebu" data-city="South Cotabato" id="Lake Sebu">Lake Sebu</option>
                                    <option value="Lakewood" data-city="Zamboanga del Sur" id="Lakewood">Lakewood</option>
                                    <option value="Lal-lo" data-city="Cagayan" id="Lal-lo">Lal-lo</option>
                                    <option value="Lala" data-city="Lanao del Norte" id="Lala">Lala</option>
                                    <option value="Lambayong" data-city="Sultan Kudarat" id="Lambayong">Lambayong</option>
                                    <option value="Lambunao" data-city="Iloilo" id="Lambunao">Lambunao</option>
                                    <option value="Lamitan" data-city="Basilan" id="Lamitan">Lamitan</option>
                                    <option value="Lamut" data-city="Ifugao" id="Lamut">Lamut</option>
                                    <option value="Langiden" data-city="Abra" id="Langiden">Langiden</option>
                                    <option value="Languyan" data-city="Tawi-Tawi" id="Languyan">Languyan</option>
                                    <option value="Lantapan" data-city="Bukidnon" id="Lantapan">Lantapan</option>
                                    <option value="Lantawan" data-city="Basilan" id="Lantawan">Lantawan</option>
                                    <option value="Lanuza" data-city="Surigao del Sur" id="Lanuza">Lanuza</option>
                                    <option value="Laoac" data-city="Pangasinan" id="Laoac">Laoac</option>
                                    <option value="Laoag" data-city="Ilocos Norte" id="Laoag">Laoag</option>
                                    <option value="Laoang" data-city="Northern Samar" id="Laoang">Laoang</option>
                                    <option value="Lapinig" data-city="Northern Samar" id="Lapinig">Lapinig</option>
                                    <option value="Lapu-Lapu" data-city="Cebu" id="Lapu-Lapu">Lapu-Lapu</option>
                                    <option value="Lapuyan" data-city="Zamboanga del Sur" id="Lapuyan">Lapuyan</option>
                                    <option value="Larena" data-city="Siquijor" id="Larena">Larena</option>
                                    <option value="Las Navas" data-city="Northern Samar" id="Las Navas">Las Navas</option>
                                    <option value="Las Nieves" data-city="Agusan del Norte" id="Las Nieves">Las Nieves</option>
                                    <option value="" data-city="Metro Manila" id=""></option>
                                    <option value="Lasam" data-city="Cagayan" id="Lasam">Lasam</option>
                                    <option value="Laua-an" data-city="Antique" id="Laua-an">Laua-an</option>
                                    <option value="Laur" data-city="Nueva Ecija" id="Laur">Laur</option>
                                    <option value="Laurel" data-city="Batangas" id="Laurel">Laurel</option>
                                    <option value="Lavezares" data-city="Northern Samar" id="Lavezares">Lavezares</option>
                                    <option value="Lawaan" data-city="Eastern Samar" id="Lawaan">Lawaan</option>
                                    <option value="Lazi" data-city="Siquijor" id="Lazi">Lazi</option>
                                    <option value="Lebak" data-city="Sultan Kudarat" id="Lebak">Lebak</option>
                                    <option value="Leganes" data-city="Iloilo" id="Leganes">Leganes</option>
                                    <option value="Legazpi" data-city="Albay" id="Legazpi">Legazpi</option>
                                    <option value="Lemery" data-city="Batangas" id="Lemery">Lemery</option>
                                    <option value="Leon" data-city="Iloilo" id="Leon">Leon</option>
                                    <option value="Leon B. Postigo" data-city="Zamboanga del Norte" id="Leon B. Postigo">Leon B. Postigo</option>
                                    <option value="Leyte" data-city="Leyte" id="Leyte">Leyte</option>
                                    <option value="Lezo" data-city="Aklan" id="Lezo">Lezo</option>
                                    <option value="Lian" data-city="Batangas" id="Lian">Lian</option>
                                    <option value="Lianga" data-city="Surigao del Sur" id="Lianga">Lianga</option>
                                    <option value="Libacao" data-city="Aklan" id="Libacao">Libacao</option>
                                    <option value="Libagon" data-city="Southern Leyte" id="Libagon">Libagon</option>
                                    <option value="Libertad" data-city="Antique" id="Libertad">Libertad</option>
                                    <option value="Libjo" data-city="Dinagat Islands" id="Libjo">Libjo</option>
                                    <option value="Libmanan" data-city="Camarines Sur" id="Libmanan">Libmanan</option>
                                    <option value="Libon" data-city="Albay" id="Libon">Libon</option>
                                    <option value="Libona" data-city="Bukidnon" id="Libona">Libona</option>
                                    <option value="Libungan" data-city="Cotabato" id="Libungan">Libungan</option>
                                    <option value="Licab" data-city="Nueva Ecija" id="Licab">Licab</option>
                                    <option value="Licuan-Baay" data-city="Abra" id="Licuan-Baay">Licuan-Baay</option>
                                    <option value="Lidlidda" data-city="Ilocos Sur" id="Lidlidda">Lidlidda</option>
                                    <option value="Ligao" data-city="Albay" id="Ligao">Ligao</option>
                                    <option value="Lila" data-city="Bohol" id="Lila">Lila</option>
                                    <option value="Liliw" data-city="Laguna" id="Liliw">Liliw</option>
                                    <option value="Liloan" data-city="Cebu" id="Liloan">Liloan</option>
                                    <option value="Liloy" data-city="Zamboanga del Norte" id="Liloy">Liloy</option>
                                    <option value="Limasawa" data-city="Southern Leyte" id="Limasawa">Limasawa</option>
                                    <option value="Limay" data-city="Bataan" id="Limay">Limay</option>
                                    <option value="Linamon" data-city="Lanao del Norte" id="Linamon">Linamon</option>
                                    <option value="Linapacan" data-city="Palawan" id="Linapacan">Linapacan</option>
                                    <option value="Lingayen" data-city="Pangasinan" id="Lingayen">Lingayen</option>
                                    <option value="Lingig" data-city="Surigao del Sur" id="Lingig">Lingig</option>
                                    <option value="Lipa" data-city="Batangas" id="Lipa">Lipa</option>
                                    <option value="Llanera" data-city="Nueva Ecija" id="Llanera">Llanera</option>
                                    <option value="Llorente" data-city="Eastern Samar" id="Llorente">Llorente</option>
                                    <option value="Loay" data-city="Bohol" id="Loay">Loay</option>
                                    <option value="Lobo" data-city="Batangas" id="Lobo">Lobo</option>
                                    <option value="Loboc" data-city="Bohol" id="Loboc">Loboc</option>
                                    <option value="Looc" data-city="Occidental Mindoro" id="Looc">Looc</option>
                                    <option value="Loon" data-city="Bohol" id="Loon">Loon</option>
                                    <option value="Lope de Vega" data-city="Northern Samar" id="Lope de Vega">Lope de Vega</option>
                                    <option value="Lopez" data-city="Quezon" id="Lopez">Lopez</option>
                                    <option value="Lopez Jaena" data-city="Misamis Occidental" id="Lopez Jaena">Lopez Jaena</option>
                                    <option value="Loreto" data-city="Agusan del Sur" id="Loreto">Loreto</option>
                                    <option value="" data-city="Laguna" id=""></option>
                                    <option value="Luba" data-city="Abra" id="Luba">Luba</option>
                                    <option value="Lubang" data-city="Occidental Mindoro" id="Lubang">Lubang</option>
                                    <option value="Lubao" data-city="Pampanga" id="Lubao">Lubao</option>
                                    <option value="Lubuagan" data-city="Kalinga" id="Lubuagan">Lubuagan</option>
                                    <option value="Lucban" data-city="Quezon" id="Lucban">Lucban</option>
                                    <option value="Lucena" data-city="Quezon" id="Lucena">Lucena</option>
                                    <option value="Lugait" data-city="Misamis Oriental" id="Lugait">Lugait</option>
                                    <option value="Lugus" data-city="Sulu" id="Lugus">Lugus</option>
                                    <option value="Luisiana" data-city="Laguna" id="Luisiana">Luisiana</option>
                                    <option value="Lumba-Bayabao" data-city="Lanao del Sur" id="Lumba-Bayabao">Lumba-Bayabao</option>
                                    <option value="Lumbaca-Unayan" data-city="Lanao del Sur" id="Lumbaca-Unayan">Lumbaca-Unayan</option>
                                    <option value="Lumban" data-city="Laguna" id="Lumban">Lumban</option>
                                    <option value="Lumbatan" data-city="Lanao del Sur" id="Lumbatan">Lumbatan</option>
                                    <option value="Lumbayanague" data-city="Lanao del Sur" id="Lumbayanague">Lumbayanague</option>
                                    <option value="Luna" data-city="Apayao" id="Luna">Luna</option>
                                    <option value="Lupao" data-city="Nueva Ecija" id="Lupao">Lupao</option>
                                    <option value="Lupi" data-city="Camarines Sur" id="Lupi">Lupi</option>
                                    <option value="Lupon" data-city="Davao Oriental" id="Lupon">Lupon</option>
                                    <option value="Lutayan" data-city="Sultan Kudarat" id="Lutayan">Lutayan</option>
                                    <option value="Luuk" data-city="Sulu" id="Luuk">Luuk</option>
                                    <option value="M'lang" data-city="Cotabato" id="M'lang">M'lang</option>
                                    <option value="Ma-ayon" data-city="Capiz" id="Ma-ayon">Ma-ayon</option>
                                    <option value="Maasim" data-city="Sarangani" id="Maasim">Maasim</option>
                                    <option value="Maasin" data-city="Iloilo" id="Maasin">Maasin</option>
                                    <option value="Mabalacat" data-city="Pampanga" id="Mabalacat">Mabalacat</option>
                                    <option value="Mabinay" data-city="Negros Oriental" id="Mabinay">Mabinay</option>
                                    <option value="Mabini" data-city="Batangas" id="Mabini">Mabini</option>
                                    <option value="Mabitac" data-city="Laguna" id="Mabitac">Mabitac</option>
                                    <option value="Mabuhay" data-city="Zamboanga Sibugay" id="Mabuhay">Mabuhay</option>
                                    <option value="Macabebe" data-city="Pampanga" id="Macabebe">Macabebe</option>
                                    <option value="Macalelon" data-city="Quezon" id="Macalelon">Macalelon</option>
                                    <option value="MacArthur" data-city="Leyte" id="MacArthur">MacArthur</option>
                                    <option value="Maco" data-city="Davao de Oro" id="Maco">Maco</option>
                                    <option value="Maconacon" data-city="Isabela" id="Maconacon">Maconacon</option>
                                    <option value="Macrohon" data-city="Southern Leyte" id="Macrohon">Macrohon</option>
                                    <option value="Madalag" data-city="Aklan" id="Madalag">Madalag</option>
                                    <option value="Madalum" data-city="Lanao del Sur" id="Madalum">Madalum</option>
                                    <option value="Madamba" data-city="Lanao del Sur" id="Madamba">Madamba</option>
                                    <option value="Maddela" data-city="Quirino" id="Maddela">Maddela</option>
                                    <option value="Madrid" data-city="Surigao del Sur" id="Madrid">Madrid</option>
                                    <option value="Madridejos" data-city="Cebu" id="Madridejos">Madridejos</option>
                                    <option value="Magalang" data-city="Pampanga" id="Magalang">Magalang</option>
                                    <option value="Magallanes" data-city="Agusan del Norte" id="Magallanes">Magallanes</option>
                                    <option value="Magarao" data-city="Camarines Sur" id="Magarao">Magarao</option>
                                    <option value="Magdalena" data-city="Laguna" id="Magdalena">Magdalena</option>
                                    <option value="Magdiwang" data-city="Romblon" id="Magdiwang">Magdiwang</option>
                                    <option value="Magpet" data-city="Cotabato" id="Magpet">Magpet</option>
                                    <option value="Magsaysay" data-city="Davao del Sur" id="Magsaysay">Magsaysay</option>
                                    <option value="Magsingal" data-city="Ilocos Sur" id="Magsingal">Magsingal</option>
                                    <option value="Maguing" data-city="Lanao del Sur" id="Maguing">Maguing</option>
                                    <option value="Mahaplag" data-city="Leyte" id="Mahaplag">Mahaplag</option>
                                    <option value="Mahatao" data-city="Batanes" id="Mahatao">Mahatao</option>
                                    <option value="Mahayag" data-city="Zamboanga del Sur" id="Mahayag">Mahayag</option>
                                    <option value="Mahinog" data-city="Camiguin" id="Mahinog">Mahinog</option>
                                    <option value="Maigo" data-city="Lanao del Norte" id="Maigo">Maigo</option>
                                    <option value="Maimbung" data-city="Sulu" id="Maimbung">Maimbung</option>
                                    <option value="Mainit" data-city="Surigao del Norte" id="Mainit">Mainit</option>
                                    <option value="Maitum" data-city="Sarangani" id="Maitum">Maitum</option>
                                    <option value="Majayjay" data-city="Laguna" id="Majayjay">Majayjay</option>
                                    <option value="Makati" data-city="Metro Manila" id="Makati">Makati</option>
                                    <option value="Makato" data-city="Aklan" id="Makato">Makato</option>
                                    <option value="Makilala" data-city="Cotabato" id="Makilala">Makilala</option>
                                    <option value="Malabang" data-city="Lanao del Sur" id="Malabang">Malabang</option>
                                    <option value="Malabon" data-city="Metro Manila" id="Malabon">Malabon</option>
                                    <option value="Malabuyoc" data-city="Cebu" id="Malabuyoc">Malabuyoc</option>
                                    <option value="Malalag" data-city="Davao del Sur" id="Malalag">Malalag</option>
                                    <option value="Malangas" data-city="Zamboanga Sibugay" id="Malangas">Malangas</option>
                                    <option value="Malapatan" data-city="Sarangani" id="Malapatan">Malapatan</option>
                                    <option value="Malasiqui" data-city="Pangasinan" id="Malasiqui">Malasiqui</option>
                                    <option value="Malay" data-city="Aklan" id="Malay">Malay</option>
                                    <option value="Malaybalay" data-city="Bukidnon" id="Malaybalay">Malaybalay</option>
                                    <option value="Malibcong" data-city="Abra" id="Malibcong">Malibcong</option>
                                    <option value="Malilipot" data-city="Albay" id="Malilipot">Malilipot</option>
                                    <option value="Malimono" data-city="Surigao del Norte" id="Malimono">Malimono</option>
                                    <option value="Malinao" data-city="Aklan" id="Malinao">Malinao</option>
                                    <option value="Malita" data-city="Davao Occidental" id="Malita">Malita</option>
                                    <option value="Malitbog" data-city="Bukidnon" id="Malitbog">Malitbog</option>
                                    <option value="Mallig" data-city="Isabela" id="Mallig">Mallig</option>
                                    <option value="Malolos" data-city="Bulacan" id="Malolos">Malolos</option>
                                    <option value="Malungon" data-city="Sarangani" id="Malungon">Malungon</option>
                                    <option value="Maluso" data-city="Basilan" id="Maluso">Maluso</option>
                                    <option value="Malvar" data-city="Batangas" id="Malvar">Malvar</option>
                                    <option value="Mamasapano" data-city="Maguindanao" id="Mamasapano">Mamasapano</option>
                                    <option value="Mambajao" data-city="Camiguin" id="Mambajao">Mambajao</option>
                                    <option value="Mamburao" data-city="Occidental Mindoro" id="Mamburao">Mamburao</option>
                                    <option value="Mambusao" data-city="Capiz" id="Mambusao">Mambusao</option>
                                    <option value="Manabo" data-city="Abra" id="Manabo">Manabo</option>
                                    <option value="Manaoag" data-city="Pangasinan" id="Manaoag">Manaoag</option>
                                    <option value="Manapla" data-city="Negros Occidental" id="Manapla">Manapla</option>
                                    <option value="Manay" data-city="Davao Oriental" id="Manay">Manay</option>
                                    <option value="Mandaluyong" data-city="Metro Manila" id="Mandaluyong">Mandaluyong</option>
                                    <option value="Mandaon" data-city="Masbate" id="Mandaon">Mandaon</option>
                                    <option value="Mandaue" data-city="Cebu" id="Mandaue">Mandaue</option>
                                    <option value="Mangaldan" data-city="Pangasinan" id="Mangaldan">Mangaldan</option>
                                    <option value="Mangatarem" data-city="Pangasinan" id="Mangatarem">Mangatarem</option>
                                    <option value="Mangudadatu" data-city="Maguindanao" id="Mangudadatu">Mangudadatu</option>
                                    <option value="Manila" data-city="Metro Manila" id="Manila">Manila</option>
                                    <option value="Manito" data-city="Albay" id="Manito">Manito</option>
                                    <option value="Manjuyod" data-city="Negros Oriental" id="Manjuyod">Manjuyod</option>
                                    <option value="Mankayan" data-city="Benguet" id="Mankayan">Mankayan</option>
                                    <option value="Manolo Fortich" data-city="Bukidnon" id="Manolo Fortich">Manolo Fortich</option>
                                    <option value="Mansalay" data-city="Oriental Mindoro" id="Mansalay">Mansalay</option>
                                    <option value="Manticao" data-city="Misamis Oriental" id="Manticao">Manticao</option>
                                    <option value="Manukan" data-city="Zamboanga del Norte" id="Manukan">Manukan</option>
                                    <option value="Mapanas" data-city="Northern Samar" id="Mapanas">Mapanas</option>
                                    <option value="Mapandan" data-city="Pangasinan" id="Mapandan">Mapandan</option>
                                    <option value="Mapun" data-city="Tawi-Tawi" id="Mapun">Mapun</option>
                                    <option value="Marabut" data-city="Samar" id="Marabut">Marabut</option>
                                    <option value="Maragondon" data-city="Cavite" id="Maragondon">Maragondon</option>
                                    <option value="Maragusan" data-city="Davao de Oro" id="Maragusan">Maragusan</option>
                                    <option value="Maramag" data-city="Bukidnon" id="Maramag">Maramag</option>
                                    <option value="Marantao" data-city="Lanao del Sur" id="Marantao">Marantao</option>
                                    <option value="Marawi" data-city="Lanao del Sur" id="Marawi">Marawi</option>
                                    <option value="Marcos" data-city="Ilocos Norte" id="Marcos">Marcos</option>
                                    <option value="Margosatubig" data-city="Zamboanga del Sur" id="Margosatubig">Margosatubig</option>
                                    <option value="Maria" data-city="Siquijor" id="Maria">Maria</option>
                                    <option value="Maria Aurora" data-city="Aurora" id="Maria Aurora">Maria Aurora</option>
                                    <option value="Maribojoc" data-city="Bohol" id="Maribojoc">Maribojoc</option>
                                    <option value="Marihatag" data-city="Surigao del Sur" id="Marihatag">Marihatag</option>
                                    <option value="Marikina" data-city="Metro Manila" id="Marikina">Marikina</option>
                                    <option value="Marilao" data-city="Bulacan" id="Marilao">Marilao</option>
                                    <option value="Maripipi" data-city="Biliran" id="Maripipi">Maripipi</option>
                                    <option value="Mariveles" data-city="Bataan" id="Mariveles">Mariveles</option>
                                    <option value="Marogong" data-city="Lanao del Sur" id="Marogong">Marogong</option>
                                    <option value="Masantol" data-city="Pampanga" id="Masantol">Masantol</option>
                                    <option value="Masbate City" data-city="Masbate" id="Masbate City">Masbate City</option>
                                    <option value="Masinloc" data-city="Zambales" id="Masinloc">Masinloc</option>
                                    <option value="Masiu" data-city="Lanao del Sur" id="Masiu">Masiu</option>
                                    <option value="Maslog" data-city="Eastern Samar" id="Maslog">Maslog</option>
                                    <option value="Mataasnakahoy" data-city="Batangas" id="Mataasnakahoy">Mataasnakahoy</option>
                                    <option value="Matag-ob" data-city="Leyte" id="Matag-ob">Matag-ob</option>
                                    <option value="Matalam" data-city="Cotabato" id="Matalam">Matalam</option>
                                    <option value="Matalom" data-city="Leyte" id="Matalom">Matalom</option>
                                    <option value="Matanao" data-city="Davao del Sur" id="Matanao">Matanao</option>
                                    <option value="Matanog" data-city="Maguindanao" id="Matanog">Matanog</option>
                                    <option value="Mati" data-city="Davao Oriental" id="Mati">Mati</option>
                                    <option value="Matnog" data-city="Sorsogon" id="Matnog">Matnog</option>
                                    <option value="Matuguinao" data-city="Samar" id="Matuguinao">Matuguinao</option>
                                    <option value="Matungao" data-city="Lanao del Norte" id="Matungao">Matungao</option>
                                    <option value="Mauban" data-city="Quezon" id="Mauban">Mauban</option>
                                    <option value="Mawab" data-city="Davao de Oro" id="Mawab">Mawab</option>
                                    <option value="Mayantoc" data-city="Tarlac" id="Mayantoc">Mayantoc</option>
                                    <option value="Maydolong" data-city="Eastern Samar" id="Maydolong">Maydolong</option>
                                    <option value="Mayorga" data-city="Leyte" id="Mayorga">Mayorga</option>
                                    <option value="Mayoyao" data-city="Ifugao" id="Mayoyao">Mayoyao</option>
                                    <option value="Medellin" data-city="Cebu" id="Medellin">Medellin</option>
                                    <option value="Medina" data-city="Misamis Oriental" id="Medina">Medina</option>
                                    <option value="Mendez" data-city="Cavite" id="Mendez">Mendez</option>
                                    <option value="Mercedes" data-city="Camarines Norte" id="Mercedes">Mercedes</option>
                                    <option value="Merida" data-city="Leyte" id="Merida">Merida</option>
                                    <option value="Mexico" data-city="Pampanga" id="Mexico">Mexico</option>
                                    <option value="Meycauayan" data-city="Bulacan" id="Meycauayan">Meycauayan</option>
                                    <option value="Miagao" data-city="Iloilo" id="Miagao">Miagao</option>
                                    <option value="Midsalip" data-city="Zamboanga del Sur" id="Midsalip">Midsalip</option>
                                    <option value="Midsayap" data-city="Cotabato" id="Midsayap">Midsayap</option>
                                    <option value="Milagros" data-city="Masbate" id="Milagros">Milagros</option>
                                    <option value="Milaor" data-city="Camarines Sur" id="Milaor">Milaor</option>
                                    <option value="Mina" data-city="Iloilo" id="Mina">Mina</option>
                                    <option value="Minalabac" data-city="Camarines Sur" id="Minalabac">Minalabac</option>
                                    <option value="Minalin" data-city="Pampanga" id="Minalin">Minalin</option>
                                    <option value="Minglanilla" data-city="Cebu" id="Minglanilla">Minglanilla</option>
                                    <option value="Moalboal" data-city="Cebu" id="Moalboal">Moalboal</option>
                                    <option value="Mobo" data-city="Masbate" id="Mobo">Mobo</option>
                                    <option value="Mogpog" data-city="Marinduque" id="Mogpog">Mogpog</option>
                                    <option value="Moises Padilla" data-city="Negros Occidental" id="Moises Padilla">Moises Padilla</option>
                                    <option value="Molave" data-city="Zamboanga del Sur" id="Molave">Molave</option>
                                    <option value="Moncada" data-city="Tarlac" id="Moncada">Moncada</option>
                                    <option value="Mondragon" data-city="Northern Samar" id="Mondragon">Mondragon</option>
                                    <option value="Monkayo" data-city="Davao de Oro" id="Monkayo">Monkayo</option>
                                    <option value="Monreal" data-city="Masbate" id="Monreal">Monreal</option>
                                    <option value="Montevista" data-city="Davao de Oro" id="Montevista">Montevista</option>
                                    <option value="Morong" data-city="Bataan" id="Morong">Morong</option>
                                    <option value="Motiong" data-city="Samar" id="Motiong">Motiong</option>
                                    <option value="Mulanay" data-city="Quezon" id="Mulanay">Mulanay</option>
                                    <option value="Mulondo" data-city="Lanao del Sur" id="Mulondo">Mulondo</option>
                                    <option value="Munai" data-city="Lanao del Norte" id="Munai">Munai</option>
                                    <option value="" data-city="Nueva Ecija" id=""></option>
                                    <option value="Muntinlupa" data-city="Metro Manila" id="Muntinlupa">Muntinlupa</option>
                                    <option value="Murcia" data-city="Negros Occidental" id="Murcia">Murcia</option>
                                    <option value="Mutia" data-city="Zamboanga del Norte" id="Mutia">Mutia</option>
                                    <option value="Naawan" data-city="Misamis Oriental" id="Naawan">Naawan</option>
                                    <option value="Nabas" data-city="Aklan" id="Nabas">Nabas</option>
                                    <option value="Nabua" data-city="Camarines Sur" id="Nabua">Nabua</option>
                                    <option value="Nabunturan" data-city="Davao de Oro" id="Nabunturan">Nabunturan</option>
                                    <option value="Naga" data-city="Camarines Sur" id="Naga">Naga</option>
                                    <option value="Nagbukel" data-city="Ilocos Sur" id="Nagbukel">Nagbukel</option>
                                    <option value="Nagcarlan" data-city="Laguna" id="Nagcarlan">Nagcarlan</option>
                                    <option value="Nagtipunan" data-city="Quirino" id="Nagtipunan">Nagtipunan</option>
                                    <option value="Naguilian" data-city="Isabela" id="Naguilian">Naguilian</option>
                                    <option value="Naic" data-city="Cavite" id="Naic">Naic</option>
                                    <option value="Nampicuan" data-city="Nueva Ecija" id="Nampicuan">Nampicuan</option>
                                    <option value="Narra" data-city="Palawan" id="Narra">Narra</option>
                                    <option value="Narvacan" data-city="Ilocos Sur" id="Narvacan">Narvacan</option>
                                    <option value="Nasipit" data-city="Agusan del Norte" id="Nasipit">Nasipit</option>
                                    <option value="Nasugbu" data-city="Batangas" id="Nasugbu">Nasugbu</option>
                                    <option value="Natividad" data-city="Pangasinan" id="Natividad">Natividad</option>
                                    <option value="Natonin" data-city="Mountain Province" id="Natonin">Natonin</option>
                                    <option value="Naujan" data-city="Oriental Mindoro" id="Naujan">Naujan</option>
                                    <option value="Naval" data-city="Biliran" id="Naval">Naval</option>
                                    <option value="Navotas" data-city="Metro Manila" id="Navotas">Navotas</option>
                                    <option value="New Bataan" data-city="Davao de Oro" id="New Bataan">New Bataan</option>
                                    <option value="New Corella" data-city="Davao del Norte" id="New Corella">New Corella</option>
                                    <option value="New Lucena" data-city="Iloilo" id="New Lucena">New Lucena</option>
                                    <option value="New Washington" data-city="Aklan" id="New Washington">New Washington</option>
                                    <option value="Norala" data-city="South Cotabato" id="Norala">Norala</option>
                                    <option value="Northern Kabuntalan" data-city="Maguindanao" id="Northern Kabuntalan">Northern Kabuntalan</option>
                                    <option value="Norzagaray" data-city="Bulacan" id="Norzagaray">Norzagaray</option>
                                    <option value="Noveleta" data-city="Cavite" id="Noveleta">Noveleta</option>
                                    <option value="Nueva Era" data-city="Ilocos Norte" id="Nueva Era">Nueva Era</option>
                                    <option value="Nueva Valencia" data-city="Guimaras" id="Nueva Valencia">Nueva Valencia</option>
                                    <option value="Numancia" data-city="Aklan" id="Numancia">Numancia</option>
                                    <option value="Nunungan" data-city="Lanao del Norte" id="Nunungan">Nunungan</option>
                                    <option value="Oas" data-city="Albay" id="Oas">Oas</option>
                                    <option value="Obando" data-city="Bulacan" id="Obando">Obando</option>
                                    <option value="Ocampo" data-city="Camarines Sur" id="Ocampo">Ocampo</option>
                                    <option value="Odiongan" data-city="Romblon" id="Odiongan">Odiongan</option>
                                    <option value="Olongapo" data-city="Zambales" id="Olongapo">Olongapo</option>
                                    <option value="Olutanga" data-city="Zamboanga Sibugay" id="Olutanga">Olutanga</option>
                                    <option value="Omar" data-city="Sulu" id="Omar">Omar</option>
                                    <option value="Opol" data-city="Misamis Oriental" id="Opol">Opol</option>
                                    <option value="Orani" data-city="Bataan" id="Orani">Orani</option>
                                    <option value="Oras" data-city="Eastern Samar" id="Oras">Oras</option>
                                    <option value="Orion" data-city="Bataan" id="Orion">Orion</option>
                                    <option value="Ormoc" data-city="Leyte" id="Ormoc">Ormoc</option>
                                    <option value="Oroquieta" data-city="Misamis Occidental" id="Oroquieta">Oroquieta</option>
                                    <option value="Oslob" data-city="Cebu" id="Oslob">Oslob</option>
                                    <option value="Oton" data-city="Iloilo" id="Oton">Oton</option>
                                    <option value="Ozamiz" data-city="Misamis Occidental" id="Ozamiz">Ozamiz</option>
                                    <option value="Padada" data-city="Davao del Sur" id="Padada">Padada</option>
                                    <option value="Padre Burgos" data-city="Quezon" id="Padre Burgos">Padre Burgos</option>
                                    <option value="Padre Garcia" data-city="Batangas" id="Padre Garcia">Padre Garcia</option>
                                    <option value="Paete" data-city="Laguna" id="Paete">Paete</option>
                                    <option value="Pagadian" data-city="Zamboanga del Sur" id="Pagadian">Pagadian</option>
                                    <option value="Pagalungan" data-city="Maguindanao" id="Pagalungan">Pagalungan</option>
                                    <option value="Pagayawan" data-city="Lanao del Sur" id="Pagayawan">Pagayawan</option>
                                    <option value="Pagbilao" data-city="Quezon" id="Pagbilao">Pagbilao</option>
                                    <option value="Paglat" data-city="Maguindanao" id="Paglat">Paglat</option>
                                    <option value="Pagsanghan" data-city="Samar" id="Pagsanghan">Pagsanghan</option>
                                    <option value="Pagsanjan" data-city="Laguna" id="Pagsanjan">Pagsanjan</option>
                                    <option value="Pagudpud" data-city="Ilocos Norte" id="Pagudpud">Pagudpud</option>
                                    <option value="Pakil" data-city="Laguna" id="Pakil">Pakil</option>
                                    <option value="Palanan" data-city="Isabela" id="Palanan">Palanan</option>
                                    <option value="Palanas" data-city="Masbate" id="Palanas">Palanas</option>
                                    <option value="Palapag" data-city="Northern Samar" id="Palapag">Palapag</option>
                                    <option value="Palauig" data-city="Zambales" id="Palauig">Palauig</option>
                                    <option value="Palayan" data-city="Nueva Ecija" id="Palayan">Palayan</option>
                                    <option value="Palimbang" data-city="Sultan Kudarat" id="Palimbang">Palimbang</option>
                                    <option value="Palo" data-city="Leyte" id="Palo">Palo</option>
                                    <option value="Palompon" data-city="Leyte" id="Palompon">Palompon</option>
                                    <option value="Paluan" data-city="Occidental Mindoro" id="Paluan">Paluan</option>
                                    <option value="Pambujan" data-city="Northern Samar" id="Pambujan">Pambujan</option>
                                    <option value="Pamplona" data-city="Cagayan" id="Pamplona">Pamplona</option>
                                    <option value="Panabo" data-city="Davao del Norte" id="Panabo">Panabo</option>
                                    <option value="Panamao" data-city="Sulu" id="Panamao">Panamao</option>
                                    <option value="Panaon" data-city="Misamis Occidental" id="Panaon">Panaon</option>
                                    <option value="Panay" data-city="Capiz" id="Panay">Panay</option>
                                    <option value="Pandag" data-city="Maguindanao" id="Pandag">Pandag</option>
                                    <option value="Pandami" data-city="Sulu" id="Pandami">Pandami</option>
                                    <option value="Pandan" data-city="Antique" id="Pandan">Pandan</option>
                                    <option value="Pandi" data-city="Bulacan" id="Pandi">Pandi</option>
                                    <option value="Panganiban" data-city="Catanduanes" id="Panganiban">Panganiban</option>
                                    <option value="Pangantucan" data-city="Bukidnon" id="Pangantucan">Pangantucan</option>
                                    <option value="Pangil" data-city="Laguna" id="Pangil">Pangil</option>
                                    <option value="Panglao" data-city="Bohol" id="Panglao">Panglao</option>
                                    <option value="Panglima Estino" data-city="Sulu" id="Panglima Estino">Panglima Estino</option>
                                    <option value="Panglima Sugala" data-city="Tawi-Tawi" id="Panglima Sugala">Panglima Sugala</option>
                                    <option value="Pangutaran" data-city="Sulu" id="Pangutaran">Pangutaran</option>
                                    <option value="Paniqui" data-city="Tarlac" id="Paniqui">Paniqui</option>
                                    <option value="Panitan" data-city="Capiz" id="Panitan">Panitan</option>
                                    <option value="Pantabangan" data-city="Nueva Ecija" id="Pantabangan">Pantabangan</option>
                                    <option value="Pantao Ragat" data-city="Lanao del Norte" id="Pantao Ragat">Pantao Ragat</option>
                                    <option value="Pantar" data-city="Lanao del Norte" id="Pantar">Pantar</option>
                                    <option value="Pantukan" data-city="Davao de Oro" id="Pantukan">Pantukan</option>
                                    <option value="Panukulan" data-city="Quezon" id="Panukulan">Panukulan</option>
                                    <option value="Paoay" data-city="Ilocos Norte" id="Paoay">Paoay</option>
                                    <option value="Paombong" data-city="Bulacan" id="Paombong">Paombong</option>
                                    <option value="Paracale" data-city="Camarines Norte" id="Paracale">Paracale</option>
                                    <option value="Paracelis" data-city="Mountain Province" id="Paracelis">Paracelis</option>
                                    <option value="" data-city="Metro Manila" id=""></option>
                                    <option value="Paranas" data-city="Samar" id="Paranas">Paranas</option>
                                    <option value="Parang" data-city="Maguindanao" id="Parang">Parang</option>
                                    <option value="Pasacao" data-city="Camarines Sur" id="Pasacao">Pasacao</option>
                                    <option value="Pasay" data-city="Metro Manila" id="Pasay">Pasay</option>
                                    <option value="Pasig" data-city="Metro Manila" id="Pasig">Pasig</option>
                                    <option value="Pasil" data-city="Kalinga" id="Pasil">Pasil</option>
                                    <option value="Passi" data-city="Iloilo" id="Passi">Passi</option>
                                    <option value="Pastrana" data-city="Leyte" id="Pastrana">Pastrana</option>
                                    <option value="Pasuquin" data-city="Ilocos Norte" id="Pasuquin">Pasuquin</option>
                                    <option value="Pata" data-city="Sulu" id="Pata">Pata</option>
                                    <option value="Pateros" data-city="Metro Manila" id="Pateros">Pateros</option>
                                    <option value="Patikul" data-city="Sulu" id="Patikul">Patikul</option>
                                    <option value="Patnanungan" data-city="Quezon" id="Patnanungan">Patnanungan</option>
                                    <option value="Patnongon" data-city="Antique" id="Patnongon">Patnongon</option>
                                    <option value="Pavia" data-city="Iloilo" id="Pavia">Pavia</option>
                                    <option value="Payao" data-city="Zamboanga Sibugay" id="Payao">Payao</option>
                                    <option value="" data-city="Cagayan" id=""></option>
                                    <option value="" data-city="Nueva Ecija" id=""></option>
                                    <option value="" data-city="Abra" id=""></option>
                                    <option value="Perez" data-city="Quezon" id="Perez">Perez</option>
                                    <option value="Piagapo" data-city="Lanao del Sur" id="Piagapo">Piagapo</option>
                                    <option value="Piat" data-city="Cagayan" id="Piat">Piat</option>
                                    <option value="Picong" data-city="Lanao del Sur" id="Picong">Picong</option>
                                    <option value="Piddig" data-city="Ilocos Norte" id="Piddig">Piddig</option>
                                    <option value="Pidigan" data-city="Abra" id="Pidigan">Pidigan</option>
                                    <option value="Pigcawayan" data-city="Cotabato" id="Pigcawayan">Pigcawayan</option>
                                    <option value="Pikit" data-city="Cotabato" id="Pikit">Pikit</option>
                                    <option value="Pila" data-city="Laguna" id="Pila">Pila</option>
                                    <option value="Pilar" data-city="Abra" id="Pilar">Pilar</option>
                                    <option value="Pili" data-city="Camarines Sur" id="Pili">Pili</option>
                                    <option value="Pililla" data-city="Rizal" id="Pililla">Pililla</option>
                                    <option value="Pinabacdao" data-city="Samar" id="Pinabacdao">Pinabacdao</option>
                                    <option value="Pinamalayan" data-city="Oriental Mindoro" id="Pinamalayan">Pinamalayan</option>
                                    <option value="Pinamungajan" data-city="Cebu" id="Pinamungajan">Pinamungajan</option>
                                    <option value="" data-city="Zamboanga del Norte" id=""></option>
                                    <option value="Pinili" data-city="Ilocos Norte" id="Pinili">Pinili</option>
                                    <option value="Pintuyan" data-city="Southern Leyte" id="Pintuyan">Pintuyan</option>
                                    <option value="Pinukpuk" data-city="Kalinga" id="Pinukpuk">Pinukpuk</option>
                                    <option value="Pio Duran" data-city="Albay" id="Pio Duran">Pio Duran</option>
                                    <option value="Pio V. Corpuz" data-city="Masbate" id="Pio V. Corpuz">Pio V. Corpuz</option>
                                    <option value="Pitogo" data-city="Quezon" id="Pitogo">Pitogo</option>
                                    <option value="Placer" data-city="Masbate" id="Placer">Placer</option>
                                    <option value="Plaridel" data-city="Bulacan" id="Plaridel">Plaridel</option>
                                    <option value="Pola" data-city="Oriental Mindoro" id="Pola">Pola</option>
                                    <option value="Polanco" data-city="Zamboanga del Norte" id="Polanco">Polanco</option>
                                    <option value="Polangui" data-city="Albay" id="Polangui">Polangui</option>
                                    <option value="Polillo" data-city="Quezon" id="Polillo">Polillo</option>
                                    <option value="Polomolok" data-city="South Cotabato" id="Polomolok">Polomolok</option>
                                    <option value="Pontevedra" data-city="Capiz" id="Pontevedra">Pontevedra</option>
                                    <option value="Poona Bayabao" data-city="Lanao del Sur" id="Poona Bayabao">Poona Bayabao</option>
                                    <option value="Poona Piagapo" data-city="Lanao del Norte" id="Poona Piagapo">Poona Piagapo</option>
                                    <option value="Porac" data-city="Pampanga" id="Porac">Porac</option>
                                    <option value="Poro" data-city="Cebu" id="Poro">Poro</option>
                                    <option value="Pototan" data-city="Iloilo" id="Pototan">Pototan</option>
                                    <option value="Pozorrubio" data-city="Pangasinan" id="Pozorrubio">Pozorrubio</option>
                                    <option value="Presentacion" data-city="Camarines Sur" id="Presentacion">Presentacion</option>
                                    <option value="President Carlos P. Garcia" data-city="Bohol" id="President Carlos P. Garcia">President Carlos P. Garcia</option>
                                    <option value="President Quirino" data-city="Sultan Kudarat" id="President Quirino">President Quirino</option>
                                    <option value="President Roxas" data-city="Capiz" id="President Roxas">President Roxas</option>
                                    <option value="Prieto Diaz" data-city="Sorsogon" id="Prieto Diaz">Prieto Diaz</option>
                                    <option value="Prosperidad" data-city="Agusan del Sur" id="Prosperidad">Prosperidad</option>
                                    <option value="Pualas" data-city="Lanao del Sur" id="Pualas">Pualas</option>
                                    <option value="Pudtol" data-city="Apayao" id="Pudtol">Pudtol</option>
                                    <option value="Puerto Galera" data-city="Oriental Mindoro" id="Puerto Galera">Puerto Galera</option>
                                    <option value="Puerto Princesa" data-city="Palawan" id="Puerto Princesa">Puerto Princesa</option>
                                    <option value="Pugo" data-city="La Union" id="Pugo">Pugo</option>
                                    <option value="Pulilan" data-city="Bulacan" id="Pulilan">Pulilan</option>
                                    <option value="Pulupandan" data-city="Negros Occidental" id="Pulupandan">Pulupandan</option>
                                    <option value="Pura" data-city="Tarlac" id="Pura">Pura</option>
                                    <option value="Quezon" data-city="Bukidnon" id="Quezon">Quezon</option>
                                    <option value="Quezon City" data-city="Metro Manila" id="Quezon City">Quezon City</option>
                                    <option value="Quinapondan" data-city="Eastern Samar" id="Quinapondan">Quinapondan</option>
                                    <option value="Quirino" data-city="Ilocos Sur" id="Quirino">Quirino</option>
                                    <option value="Ragay" data-city="Camarines Sur" id="Ragay">Ragay</option>
                                    <option value="Rajah Buayan" data-city="Maguindanao" id="Rajah Buayan">Rajah Buayan</option>
                                    <option value="Ramon" data-city="Isabela" id="Ramon">Ramon</option>
                                    <option value="Ramon Magsaysay" data-city="Zamboanga del Sur" id="Ramon Magsaysay">Ramon Magsaysay</option>
                                    <option value="Ramos" data-city="Tarlac" id="Ramos">Ramos</option>
                                    <option value="Rapu-Rapu" data-city="Albay" id="Rapu-Rapu">Rapu-Rapu</option>
                                    <option value="Real" data-city="Quezon" id="Real">Real</option>
                                    <option value="Reina Mercedes" data-city="Isabela" id="Reina Mercedes">Reina Mercedes</option>
                                    <option value="Remedios T. Romualdez" data-city="Agusan del Norte" id="Remedios T. Romualdez">Remedios T. Romualdez</option>
                                    <option value="Rizal" data-city="Cagayan" id="Rizal">Rizal</option>
                                    <option value="Rodriguez" data-city="Rizal" id="Rodriguez">Rodriguez</option>
                                    <option value="Romblon" data-city="Romblon" id="Romblon">Romblon</option>
                                    <option value="Ronda" data-city="Cebu" id="Ronda">Ronda</option>
                                    <option value="Rosales" data-city="Pangasinan" id="Rosales">Rosales</option>
                                    <option value="Rosario" data-city="Agusan del Sur" id="Rosario">Rosario</option>
                                    <option value="Roseller Lim" data-city="Zamboanga Sibugay" id="Roseller Lim">Roseller Lim</option>
                                    <option value="Roxas" data-city="Capiz" id="Roxas">Roxas</option>
                                    <option value="Roxas, Palawan" data-city="Palawan" id="Roxas, Palawan">Roxas, Palawan</option>
                                    <option value="Sabangan" data-city="Mountain Province" id="Sabangan">Sabangan</option>
                                    <option value="Sablan" data-city="Benguet" id="Sablan">Sablan</option>
                                    <option value="Sablayan" data-city="Occidental Mindoro" id="Sablayan">Sablayan</option>
                                    <option value="Sabtang" data-city="Batanes" id="Sabtang">Sabtang</option>
                                    <option value="Sadanga" data-city="Mountain Province" id="Sadanga">Sadanga</option>
                                    <option value="Sagada" data-city="Mountain Province" id="Sagada">Sagada</option>
                                    <option value="Sagay" data-city="Camiguin" id="Sagay">Sagay</option>
                                    <option value="Sagbayan" data-city="Bohol" id="Sagbayan">Sagbayan</option>
                                    <option value="" data-city="Camarines Sur" id=""></option>
                                    <option value="Saguday" data-city="Quirino" id="Saguday">Saguday</option>
                                    <option value="Saguiaran" data-city="Lanao del Sur" id="Saguiaran">Saguiaran</option>
                                    <option value="Saint Bernard" data-city="Southern Leyte" id="Saint Bernard">Saint Bernard</option>
                                    <option value="Salay" data-city="Misamis Oriental" id="Salay">Salay</option>
                                    <option value="Salcedo" data-city="Eastern Samar" id="Salcedo">Salcedo</option>
                                    <option value="Sallapadan" data-city="Abra" id="Sallapadan">Sallapadan</option>
                                    <option value="Salug" data-city="Zamboanga del Norte" id="Salug">Salug</option>
                                    <option value="Salvador" data-city="Lanao del Norte" id="Salvador">Salvador</option>
                                    <option value="Salvador Benedicto" data-city="Negros Occidental" id="Salvador Benedicto">Salvador Benedicto</option>
                                    <option value="Samal" data-city="Bataan" id="Samal">Samal</option>
                                    <option value="Samboan" data-city="Cebu" id="Samboan">Samboan</option>
                                    <option value="Sampaloc" data-city="Quezon" id="Sampaloc">Sampaloc</option>
                                    <option value="San Agustin" data-city="Isabela" id="San Agustin">San Agustin</option>
                                    <option value="San Andres" data-city="Catanduanes" id="San Andres">San Andres</option>
                                    <option value="San Antonio" data-city="Northern Samar" id="San Antonio">San Antonio</option>
                                    <option value="San Benito" data-city="Surigao del Norte" id="San Benito">San Benito</option>
                                    <option value="San Carlos" data-city="Negros Occidental" id="San Carlos">San Carlos</option>
                                    <option value="San Clemente" data-city="Tarlac" id="San Clemente">San Clemente</option>
                                    <option value="San Dionisio" data-city="Iloilo" id="San Dionisio">San Dionisio</option>
                                    <option value="San Emilio" data-city="Ilocos Sur" id="San Emilio">San Emilio</option>
                                    <option value="San Enrique" data-city="Iloilo" id="San Enrique">San Enrique</option>
                                    <option value="San Esteban" data-city="Ilocos Sur" id="San Esteban">San Esteban</option>
                                    <option value="San Fabian" data-city="Pangasinan" id="San Fabian">San Fabian</option>
                                    <option value="San Felipe" data-city="Zambales" id="San Felipe">San Felipe</option>
                                    <option value="San Fernando" data-city="Bukidnon" id="San Fernando">San Fernando</option>
                                    <option value="San Francisco" data-city="Agusan del Sur" id="San Francisco">San Francisco</option>
                                    <option value="San Gabriel" data-city="La Union" id="San Gabriel">San Gabriel</option>
                                    <option value="San Guillermo" data-city="Isabela" id="San Guillermo">San Guillermo</option>
                                    <option value="San Ildefonso" data-city="Bulacan" id="San Ildefonso">San Ildefonso</option>
                                    <option value="San Isidro" data-city="Abra" id="San Isidro">San Isidro</option>
                                    <option value="San Jacinto" data-city="Masbate" id="San Jacinto">San Jacinto</option>
                                    <option value="San Joaquin" data-city="Iloilo" id="San Joaquin">San Joaquin</option>
                                    <option value="San Jorge" data-city="Samar" id="San Jorge">San Jorge</option>
                                    <option value="San Jose" data-city="Batangas" id="San Jose">San Jose</option>
                                    <option value="San Jose de Buan" data-city="Samar" id="San Jose de Buan">San Jose de Buan</option>
                                    <option value="San Jose de Buenavista" data-city="Antique" id="San Jose de Buenavista">San Jose de Buenavista</option>
                                    <option value="San Jose del Monte" data-city="Bulacan" id="San Jose del Monte">San Jose del Monte</option>
                                    <option value="San Juan" data-city="Abra" id="San Juan">San Juan</option>
                                    <option value="San Julian" data-city="Eastern Samar" id="San Julian">San Julian</option>
                                    <option value="San Leonardo" data-city="Nueva Ecija" id="San Leonardo">San Leonardo</option>
                                    <option value="San Lorenzo" data-city="Guimaras" id="San Lorenzo">San Lorenzo</option>
                                    <option value="San Lorenzo Ruiz" data-city="Camarines Norte" id="San Lorenzo Ruiz">San Lorenzo Ruiz</option>
                                    <option value="San Luis" data-city="Agusan del Sur" id="San Luis">San Luis</option>
                                    <option value="San Manuel" data-city="Isabela" id="San Manuel">San Manuel</option>
                                    <option value="San Marcelino" data-city="Zambales" id="San Marcelino">San Marcelino</option>
                                    <option value="San Mariano" data-city="Isabela" id="San Mariano">San Mariano</option>
                                    <option value="San Mateo" data-city="Isabela" id="San Mateo">San Mateo</option>
                                    <option value="San Miguel" data-city="Bohol" id="San Miguel">San Miguel</option>
                                    <option value="San Narciso" data-city="Quezon" id="San Narciso">San Narciso</option>
                                    <option value="San Nicolas" data-city="Batangas" id="San Nicolas">San Nicolas</option>
                                    <option value="San Pablo" data-city="Isabela" id="San Pablo">San Pablo</option>
                                    <option value="San Pascual" data-city="Batangas" id="San Pascual">San Pascual</option>
                                    <option value="San Pedro" data-city="Laguna" id="San Pedro">San Pedro</option>
                                    <option value="San Policarpo" data-city="Eastern Samar" id="San Policarpo">San Policarpo</option>
                                    <option value="San Quintin" data-city="Abra" id="San Quintin">San Quintin</option>
                                    <option value="San Rafael" data-city="Bulacan" id="San Rafael">San Rafael</option>
                                    <option value="San Remigio" data-city="Antique" id="San Remigio">San Remigio</option>
                                    <option value="San Ricardo" data-city="Southern Leyte" id="San Ricardo">San Ricardo</option>
                                    <option value="San Roque" data-city="Northern Samar" id="San Roque">San Roque</option>
                                    <option value="San Sebastian" data-city="Samar" id="San Sebastian">San Sebastian</option>
                                    <option value="San Simon" data-city="Pampanga" id="San Simon">San Simon</option>
                                    <option value="San Teodoro" data-city="Oriental Mindoro" id="San Teodoro">San Teodoro</option>
                                    <option value="San Vicente" data-city="Camarines Norte" id="San Vicente">San Vicente</option>
                                    <option value="Sanchez-Mira" data-city="Cagayan" id="Sanchez-Mira">Sanchez-Mira</option>
                                    <option value="Santa" data-city="Ilocos Sur" id="Santa">Santa</option>
                                    <option value="Santa Ana" data-city="Cagayan" id="Santa Ana">Santa Ana</option>
                                    <option value="Santa Barbara" data-city="Iloilo" id="Santa Barbara">Santa Barbara</option>
                                    <option value="Santa Catalina" data-city="Ilocos Sur" id="Santa Catalina">Santa Catalina</option>
                                    <option value="Santa Cruz" data-city="Davao del Sur" id="Santa Cruz">Santa Cruz</option>
                                    <option value="Santa Elena" data-city="Camarines Norte" id="Santa Elena">Santa Elena</option>
                                    <option value="Santa Fe" data-city="Cebu" id="Santa Fe">Santa Fe</option>
                                    <option value="Santa Ignacia" data-city="Tarlac" id="Santa Ignacia">Santa Ignacia</option>
                                    <option value="Santa Josefa" data-city="Agusan del Sur" id="Santa Josefa">Santa Josefa</option>
                                    <option value="Santa Lucia" data-city="Ilocos Sur" id="Santa Lucia">Santa Lucia</option>
                                    <option value="Santa Magdalena" data-city="Sorsogon" id="Santa Magdalena">Santa Magdalena</option>
                                    <option value="Santa Marcela" data-city="Apayao" id="Santa Marcela">Santa Marcela</option>
                                    <option value="Santa Margarita" data-city="Samar" id="Santa Margarita">Santa Margarita</option>
                                    <option value="Santa Maria" data-city="Bulacan" id="Santa Maria">Santa Maria</option>
                                    <option value="Santa Monica" data-city="Surigao del Norte" id="Santa Monica">Santa Monica</option>
                                    <option value="Santa Praxedes" data-city="Cagayan" id="Santa Praxedes">Santa Praxedes</option>
                                    <option value="Santa Rita" data-city="Pampanga" id="Santa Rita">Santa Rita</option>
                                    <option value="Santa Rosa" data-city="Laguna" id="Santa Rosa">Santa Rosa</option>
                                    <option value="Santa Teresita" data-city="Batangas" id="Santa Teresita">Santa Teresita</option>
                                    <option value="Santander" data-city="Cebu" id="Santander">Santander</option>
                                    <option value="Santiago" data-city="Agusan del Norte" id="Santiago">Santiago</option>
                                    <option value="Santo Domingo" data-city="Albay" id="Santo Domingo">Santo Domingo</option>
                                    <option value="" data-city="Cagayan" id=""></option>
                                    <option value="Santo Tomas" data-city="Batangas" id="Santo Tomas">Santo Tomas</option>
                                    <option value="Santol" data-city="La Union" id="Santol">Santol</option>
                                    <option value="Sapa-Sapa" data-city="Tawi-Tawi" id="Sapa-Sapa">Sapa-Sapa</option>
                                    <option value="Sapad" data-city="Lanao del Norte" id="Sapad">Sapad</option>
                                    <option value="Sapang Dalaga" data-city="Misamis Occidental" id="Sapang Dalaga">Sapang Dalaga</option>
                                    <option value="Sapian" data-city="Capiz" id="Sapian">Sapian</option>
                                    <option value="Sara" data-city="Iloilo" id="Sara">Sara</option>
                                    <option value="Sarangani" data-city="Davao Occidental" id="Sarangani">Sarangani</option>
                                    <option value="Sariaya" data-city="Quezon" id="Sariaya">Sariaya</option>
                                    <option value="Sarrat" data-city="Ilocos Norte" id="Sarrat">Sarrat</option>
                                    <option value="Sasmuan" data-city="Pampanga" id="Sasmuan">Sasmuan</option>
                                    <option value="Sebaste" data-city="Antique" id="Sebaste">Sebaste</option>
                                    <option value="Senator Ninoy Aquino" data-city="Sultan Kudarat" id="Senator Ninoy Aquino">Senator Ninoy Aquino</option>
                                    <option value="" data-city="Zamboanga del Norte" id=""></option>
                                    <option value="Sevilla" data-city="Bohol" id="Sevilla">Sevilla</option>
                                    <option value="Shariff Aguak" data-city="Maguindanao" id="Shariff Aguak">Shariff Aguak</option>
                                    <option value="Shariff Saydona Mustapha" data-city="Maguindanao" id="Shariff Saydona Mustapha">Shariff Saydona Mustapha</option>
                                    <option value="Siasi" data-city="Sulu" id="Siasi">Siasi</option>
                                    <option value="Siaton" data-city="Negros Oriental" id="Siaton">Siaton</option>
                                    <option value="Siay" data-city="Zamboanga Sibugay" id="Siay">Siay</option>
                                    <option value="Siayan" data-city="Zamboanga del Norte" id="Siayan">Siayan</option>
                                    <option value="Sibagat" data-city="Agusan del Sur" id="Sibagat">Sibagat</option>
                                    <option value="Sibalom" data-city="Antique" id="Sibalom">Sibalom</option>
                                    <option value="Sibonga" data-city="Cebu" id="Sibonga">Sibonga</option>
                                    <option value="Sibuco" data-city="Zamboanga del Norte" id="Sibuco">Sibuco</option>
                                    <option value="Sibulan" data-city="Negros Oriental" id="Sibulan">Sibulan</option>
                                    <option value="Sibunag" data-city="Guimaras" id="Sibunag">Sibunag</option>
                                    <option value="Sibutad" data-city="Zamboanga del Norte" id="Sibutad">Sibutad</option>
                                    <option value="Sibutu" data-city="Tawi-Tawi" id="Sibutu">Sibutu</option>
                                    <option value="Sierra Bullones" data-city="Bohol" id="Sierra Bullones">Sierra Bullones</option>
                                    <option value="Sigay" data-city="Ilocos Sur" id="Sigay">Sigay</option>
                                    <option value="Sigma" data-city="Capiz" id="Sigma">Sigma</option>
                                    <option value="Sikatuna" data-city="Bohol" id="Sikatuna">Sikatuna</option>
                                    <option value="Silago" data-city="Southern Leyte" id="Silago">Silago</option>
                                    <option value="Silang" data-city="Cavite" id="Silang">Silang</option>
                                    <option value="Silay" data-city="Negros Occidental" id="Silay">Silay</option>
                                    <option value="Silvino Lobos" data-city="Northern Samar" id="Silvino Lobos">Silvino Lobos</option>
                                    <option value="Simunul" data-city="Tawi-Tawi" id="Simunul">Simunul</option>
                                    <option value="Sinacaban" data-city="Misamis Occidental" id="Sinacaban">Sinacaban</option>
                                    <option value="Sinait" data-city="Ilocos Sur" id="Sinait">Sinait</option>
                                    <option value="Sindangan" data-city="Zamboanga del Norte" id="Sindangan">Sindangan</option>
                                    <option value="Siniloan" data-city="Laguna" id="Siniloan">Siniloan</option>
                                    <option value="Siocon" data-city="Zamboanga del Norte" id="Siocon">Siocon</option>
                                    <option value="Sipalay" data-city="Negros Occidental" id="Sipalay">Sipalay</option>
                                    <option value="Sipocot" data-city="Camarines Sur" id="Sipocot">Sipocot</option>
                                    <option value="Siquijor" data-city="Siquijor" id="Siquijor">Siquijor</option>
                                    <option value="Sirawai" data-city="Zamboanga del Norte" id="Sirawai">Sirawai</option>
                                    <option value="Siruma" data-city="Camarines Sur" id="Siruma">Siruma</option>
                                    <option value="Sison" data-city="Pangasinan" id="Sison">Sison</option>
                                    <option value="Sitangkai" data-city="Tawi-Tawi" id="Sitangkai">Sitangkai</option>
                                    <option value="Socorro" data-city="Oriental Mindoro" id="Socorro">Socorro</option>
                                    <option value="" data-city="Palawan" id=""></option>
                                    <option value="Sogod" data-city="Cebu" id="Sogod">Sogod</option>
                                    <option value="Solana" data-city="Cagayan" id="Solana">Solana</option>
                                    <option value="Solano" data-city="Nueva Vizcaya" id="Solano">Solano</option>
                                    <option value="Solsona" data-city="Ilocos Norte" id="Solsona">Solsona</option>
                                    <option value="Sominot" data-city="Zamboanga del Sur" id="Sominot">Sominot</option>
                                    <option value="Sorsogon City" data-city="Sorsogon" id="Sorsogon City">Sorsogon City</option>
                                    <option value="South Ubian" data-city="Tawi-Tawi" id="South Ubian">South Ubian</option>
                                    <option value="South Upi" data-city="Maguindanao" id="South Upi">South Upi</option>
                                    <option value="Sual" data-city="Pangasinan" id="Sual">Sual</option>
                                    <option value="Subic" data-city="Zambales" id="Subic">Subic</option>
                                    <option value="Sudipen" data-city="La Union" id="Sudipen">Sudipen</option>
                                    <option value="Sugbongcogon" data-city="Misamis Oriental" id="Sugbongcogon">Sugbongcogon</option>
                                    <option value="Sugpon" data-city="Ilocos Sur" id="Sugpon">Sugpon</option>
                                    <option value="Sulat" data-city="Eastern Samar" id="Sulat">Sulat</option>
                                    <option value="Sulop" data-city="Davao del Sur" id="Sulop">Sulop</option>
                                    <option value="Sultan Dumalondong" data-city="Lanao del Sur" id="Sultan Dumalondong">Sultan Dumalondong</option>
                                    <option value="Sultan Kudarat" data-city="Maguindanao" id="Sultan Kudarat">Sultan Kudarat</option>
                                    <option value="Sultan Mastura" data-city="Maguindanao" id="Sultan Mastura">Sultan Mastura</option>
                                    <option value="Sultan Naga Dimaporo" data-city="Lanao del Norte" id="Sultan Naga Dimaporo">Sultan Naga Dimaporo</option>
                                    <option value="Sultan sa Barongis" data-city="Maguindanao" id="Sultan sa Barongis">Sultan sa Barongis</option>
                                    <option value="Sultan Sumagka" data-city="Maguindanao" id="Sultan Sumagka">Sultan Sumagka</option>
                                    <option value="Sumilao" data-city="Bukidnon" id="Sumilao">Sumilao</option>
                                    <option value="Sumisip" data-city="Basilan" id="Sumisip">Sumisip</option>
                                    <option value="Surallah" data-city="South Cotabato" id="Surallah">Surallah</option>
                                    <option value="Surigao City" data-city="Surigao del Norte" id="Surigao City">Surigao City</option>
                                    <option value="Suyo" data-city="Ilocos Sur" id="Suyo">Suyo</option>
                                    <option value="T'Boli" data-city="South Cotabato" id="T'Boli">T'Boli</option>
                                    <option value="Taal" data-city="Batangas" id="Taal">Taal</option>
                                    <option value="Tabaco" data-city="Albay" id="Tabaco">Tabaco</option>
                                    <option value="Tabango" data-city="Leyte" id="Tabango">Tabango</option>
                                    <option value="Tabina" data-city="Zamboanga del Sur" id="Tabina">Tabina</option>
                                    <option value="Tabogon" data-city="Cebu" id="Tabogon">Tabogon</option>
                                    <option value="Tabontabon" data-city="Leyte" id="Tabontabon">Tabontabon</option>
                                    <option value="Tabuan-Lasa" data-city="Basilan" id="Tabuan-Lasa">Tabuan-Lasa</option>
                                    <option value="Tabuelan" data-city="Cebu" id="Tabuelan">Tabuelan</option>
                                    <option value="Tabuk" data-city="Kalinga" id="Tabuk">Tabuk</option>
                                    <option value="Tacloban" data-city="Leyte" id="Tacloban">Tacloban</option>
                                    <option value="Tacurong" data-city="Sultan Kudarat" id="Tacurong">Tacurong</option>
                                    <option value="Tadian" data-city="Mountain Province" id="Tadian">Tadian</option>
                                    <option value="Taft" data-city="Eastern Samar" id="Taft">Taft</option>
                                    <option value="Tagana-an" data-city="Surigao del Norte" id="Tagana-an">Tagana-an</option>
                                    <option value="Tagapul-an" data-city="Samar" id="Tagapul-an">Tagapul-an</option>
                                    <option value="Tagaytay" data-city="Cavite" id="Tagaytay">Tagaytay</option>
                                    <option value="Tagbilaran" data-city="Bohol" id="Tagbilaran">Tagbilaran</option>
                                    <option value="Tagbina" data-city="Surigao del Sur" id="Tagbina">Tagbina</option>
                                    <option value="Tagkawayan" data-city="Quezon" id="Tagkawayan">Tagkawayan</option>
                                    <option value="Tago" data-city="Surigao del Sur" id="Tago">Tago</option>
                                    <option value="Tagoloan" data-city="Lanao del Norte" id="Tagoloan">Tagoloan</option>
                                    <option value="Tagoloan II" data-city="Lanao del Sur" id="Tagoloan II">Tagoloan II</option>
                                    <option value="Tagudin" data-city="Ilocos Sur" id="Tagudin">Tagudin</option>
                                    <option value="Taguig" data-city="Metro Manila" id="Taguig">Taguig</option>
                                    <option value="Tagum" data-city="Davao del Norte" id="Tagum">Tagum</option>
                                    <option value="Talacogon" data-city="Agusan del Sur" id="Talacogon">Talacogon</option>
                                    <option value="Talaingod" data-city="Davao del Norte" id="Talaingod">Talaingod</option>
                                    <option value="Talakag" data-city="Bukidnon" id="Talakag">Talakag</option>
                                    <option value="Talalora" data-city="Samar" id="Talalora">Talalora</option>
                                    <option value="Talavera" data-city="Nueva Ecija" id="Talavera">Talavera</option>
                                    <option value="Talayan" data-city="Maguindanao" id="Talayan">Talayan</option>
                                    <option value="Talibon" data-city="Bohol" id="Talibon">Talibon</option>
                                    <option value="Talipao" data-city="Sulu" id="Talipao">Talipao</option>
                                    <option value="Talisay" data-city="Batangas" id="Talisay">Talisay</option>
                                    <option value="Talisayan" data-city="Misamis Oriental" id="Talisayan">Talisayan</option>
                                    <option value="Talugtug" data-city="Nueva Ecija" id="Talugtug">Talugtug</option>
                                    <option value="Talusan" data-city="Zamboanga Sibugay" id="Talusan">Talusan</option>
                                    <option value="Tambulig" data-city="Zamboanga del Sur" id="Tambulig">Tambulig</option>
                                    <option value="Tampakan" data-city="South Cotabato" id="Tampakan">Tampakan</option>
                                    <option value="Tamparan" data-city="Lanao del Sur" id="Tamparan">Tamparan</option>
                                    <option value="Tampilisan" data-city="Zamboanga del Norte" id="Tampilisan">Tampilisan</option>
                                    <option value="Tanauan" data-city="Batangas" id="Tanauan">Tanauan</option>
                                    <option value="Tanay" data-city="Rizal" id="Tanay">Tanay</option>
                                    <option value="Tandag" data-city="Surigao del Sur" id="Tandag">Tandag</option>
                                    <option value="Tandubas" data-city="Tawi-Tawi" id="Tandubas">Tandubas</option>
                                    <option value="Tangalan" data-city="Aklan" id="Tangalan">Tangalan</option>
                                    <option value="Tangcal" data-city="Lanao del Norte" id="Tangcal">Tangcal</option>
                                    <option value="Tangub" data-city="Misamis Occidental" id="Tangub">Tangub</option>
                                    <option value="Tanjay" data-city="Negros Oriental" id="Tanjay">Tanjay</option>
                                    <option value="Tantangan" data-city="South Cotabato" id="Tantangan">Tantangan</option>
                                    <option value="Tanudan" data-city="Kalinga" id="Tanudan">Tanudan</option>
                                    <option value="Tanza" data-city="Cavite" id="Tanza">Tanza</option>
                                    <option value="Tapaz" data-city="Capiz" id="Tapaz">Tapaz</option>
                                    <option value="Tapul" data-city="Sulu" id="Tapul">Tapul</option>
                                    <option value="Taraka" data-city="Lanao del Sur" id="Taraka">Taraka</option>
                                    <option value="Tarangnan" data-city="Samar" id="Tarangnan">Tarangnan</option>
                                    <option value="Tarlac City" data-city="Tarlac" id="Tarlac City">Tarlac City</option>
                                    <option value="Tarragona" data-city="Davao Oriental" id="Tarragona">Tarragona</option>
                                    <option value="Tayabas" data-city="Quezon" id="Tayabas">Tayabas</option>
                                    <option value="Tayasan" data-city="Negros Oriental" id="Tayasan">Tayasan</option>
                                    <option value="Taysan" data-city="Batangas" id="Taysan">Taysan</option>
                                    <option value="Taytay" data-city="Palawan" id="Taytay">Taytay</option>
                                    <option value="Tayug" data-city="Pangasinan" id="Tayug">Tayug</option>
                                    <option value="Tayum" data-city="Abra" id="Tayum">Tayum</option>
                                    <option value="Teresa" data-city="Rizal" id="Teresa">Teresa</option>
                                    <option value="Ternate" data-city="Cavite" id="Ternate">Ternate</option>
                                    <option value="Tiaong" data-city="Quezon" id="Tiaong">Tiaong</option>
                                    <option value="Tibiao" data-city="Antique" id="Tibiao">Tibiao</option>
                                    <option value="Tigaon" data-city="Camarines Sur" id="Tigaon">Tigaon</option>
                                    <option value="Tigbao" data-city="Zamboanga del Sur" id="Tigbao">Tigbao</option>
                                    <option value="Tigbauan" data-city="Iloilo" id="Tigbauan">Tigbauan</option>
                                    <option value="Tinambac" data-city="Camarines Sur" id="Tinambac">Tinambac</option>
                                    <option value="Tineg" data-city="Abra" id="Tineg">Tineg</option>
                                    <option value="Tinglayan" data-city="Kalinga" id="Tinglayan">Tinglayan</option>
                                    <option value="Tingloy" data-city="Batangas" id="Tingloy">Tingloy</option>
                                    <option value="Tinoc" data-city="Ifugao" id="Tinoc">Tinoc</option>
                                    <option value="Tipo-Tipo" data-city="Basilan" id="Tipo-Tipo">Tipo-Tipo</option>
                                    <option value="Titay" data-city="Zamboanga Sibugay" id="Titay">Titay</option>
                                    <option value="Tiwi" data-city="Albay" id="Tiwi">Tiwi</option>
                                    <option value="Tobias Fornier" data-city="Antique" id="Tobias Fornier">Tobias Fornier</option>
                                    <option value="Toboso" data-city="Negros Occidental" id="Toboso">Toboso</option>
                                    <option value="Toledo" data-city="Cebu" id="Toledo">Toledo</option>
                                    <option value="Tolosa" data-city="Leyte" id="Tolosa">Tolosa</option>
                                    <option value="Tomas Oppus" data-city="Southern Leyte" id="Tomas Oppus">Tomas Oppus</option>
                                    <option value="Torrijos" data-city="Marinduque" id="Torrijos">Torrijos</option>
                                    <option value="Trece Martires" data-city="Cavite" id="Trece Martires">Trece Martires</option>
                                    <option value="Trento" data-city="Agusan del Sur" id="Trento">Trento</option>
                                    <option value="Trinidad" data-city="Bohol" id="Trinidad">Trinidad</option>
                                    <option value="Tuao" data-city="Cagayan" id="Tuao">Tuao</option>
                                    <option value="Tuba" data-city="Benguet" id="Tuba">Tuba</option>
                                    <option value="Tubajon" data-city="Dinagat Islands" id="Tubajon">Tubajon</option>
                                    <option value="Tubao" data-city="La Union" id="Tubao">Tubao</option>
                                    <option value="Tubaran" data-city="Lanao del Sur" id="Tubaran">Tubaran</option>
                                    <option value="Tubay" data-city="Agusan del Norte" id="Tubay">Tubay</option>
                                    <option value="Tubigon" data-city="Bohol" id="Tubigon">Tubigon</option>
                                    <option value="Tublay" data-city="Benguet" id="Tublay">Tublay</option>
                                    <option value="Tubo" data-city="Abra" id="Tubo">Tubo</option>
                                    <option value="Tubod" data-city="Lanao del Norte" id="Tubod">Tubod</option>
                                    <option value="Tubungan" data-city="Iloilo" id="Tubungan">Tubungan</option>
                                    <option value="Tuburan" data-city="Basilan" id="Tuburan">Tuburan</option>
                                    <option value="Tudela" data-city="Cebu" id="Tudela">Tudela</option>
                                    <option value="Tugaya" data-city="Lanao del Sur" id="Tugaya">Tugaya</option>
                                    <option value="Tuguegarao" data-city="Cagayan" id="Tuguegarao">Tuguegarao</option>
                                    <option value="Tukuran" data-city="Zamboanga del Sur" id="Tukuran">Tukuran</option>
                                    <option value="Tulunan" data-city="Cotabato" id="Tulunan">Tulunan</option>
                                    <option value="Tumauini" data-city="Isabela" id="Tumauini">Tumauini</option>
                                    <option value="Tunga" data-city="Leyte" id="Tunga">Tunga</option>
                                    <option value="Tungawan" data-city="Zamboanga Sibugay" id="Tungawan">Tungawan</option>
                                    <option value="Tupi" data-city="South Cotabato" id="Tupi">Tupi</option>
                                    <option value="Turtle Islands" data-city="Tawi-Tawi" id="Turtle Islands">Turtle Islands</option>
                                    <option value="Tuy" data-city="Batangas" id="Tuy">Tuy</option>
                                    <option value="Ubay" data-city="Bohol" id="Ubay">Ubay</option>
                                    <option value="Umingan" data-city="Pangasinan" id="Umingan">Umingan</option>
                                    <option value="Ungkaya Pukan" data-city="Basilan" id="Ungkaya Pukan">Ungkaya Pukan</option>
                                    <option value="Unisan" data-city="Quezon" id="Unisan">Unisan</option>
                                    <option value="Upi" data-city="Maguindanao" id="Upi">Upi</option>
                                    <option value="Urbiztondo" data-city="Pangasinan" id="Urbiztondo">Urbiztondo</option>
                                    <option value="Urdaneta" data-city="Pangasinan" id="Urdaneta">Urdaneta</option>
                                    <option value="Uson" data-city="Masbate" id="Uson">Uson</option>
                                    <option value="Uyugan" data-city="Batanes" id="Uyugan">Uyugan</option>
                                    <option value="Valderrama" data-city="Antique" id="Valderrama">Valderrama</option>
                                    <option value="Valencia" data-city="Bohol" id="Valencia">Valencia</option>
                                    <option value="Valenzuela" data-city="Metro Manila" id="Valenzuela">Valenzuela</option>
                                    <option value="Valladolid" data-city="Negros Occidental" id="Valladolid">Valladolid</option>
                                    <option value="Vallehermoso" data-city="Negros Oriental" id="Vallehermoso">Vallehermoso</option>
                                    <option value="Veruela" data-city="Agusan del Sur" id="Veruela">Veruela</option>
                                    <option value="Victoria" data-city="Laguna" id="Victoria">Victoria</option>
                                    <option value="Victorias" data-city="Negros Occidental" id="Victorias">Victorias</option>
                                    <option value="Viga" data-city="Catanduanes" id="Viga">Viga</option>
                                    <option value="Vigan" data-city="Ilocos Sur" id="Vigan">Vigan</option>
                                    <option value="Villaba" data-city="Leyte" id="Villaba">Villaba</option>
                                    <option value="Villanueva" data-city="Misamis Oriental" id="Villanueva">Villanueva</option>
                                    <option value="Villareal" data-city="Samar" id="Villareal">Villareal</option>
                                    <option value="Villasis" data-city="Pangasinan" id="Villasis">Villasis</option>
                                    <option value="Villaverde" data-city="Nueva Vizcaya" id="Villaverde">Villaverde</option>
                                    <option value="Villaviciosa" data-city="Abra" id="Villaviciosa">Villaviciosa</option>
                                    <option value="Vincenzo A. Sagun" data-city="Zamboanga del Sur" id="Vincenzo A. Sagun">Vincenzo A. Sagun</option>
                                    <option value="Vintar" data-city="Ilocos Norte" id="Vintar">Vintar</option>
                                    <option value="Vinzons" data-city="Camarines Norte" id="Vinzons">Vinzons</option>
                                    <option value="Virac" data-city="Catanduanes" id="Virac">Virac</option>
                                    <option value="Wao" data-city="Lanao del Sur" id="Wao">Wao</option>
                                    <option value="Zamboanga City" data-city="Zamboanga del Sur" id="Zamboanga City">Zamboanga City</option>
                                    <option value="Zamboanguita" data-city="Negros Oriental" id="Zamboanguita">Zamboanguita</option>
                                    <option value="Zaragoza" data-city="Nueva Ecija" id="Zaragoza">Zaragoza</option>
                                    <option value="Zarraga" data-city="Iloilo" id="Zarraga">Zarraga</option>
                                    <option value="Zumarraga" data-city="Samar" id="Zumarraga">Zumarraga</option>
                                    </select>
                                </div>
                                <!-- brgy -->
                                <div>
                                    <label for="barangay" class="text-white">Barangay:</label>
                                    <select id="brgy" name="brgy">
                                    <option>Select your Barangay</option>
                                    <option value="" data-brgy="Bangued"></option>
                                    <option value="" data-brgy="Boliney"></option>
                                    <option value="" data-brgy="Bucay"></option>
                                    <option value="" data-brgy="Bucloc"></option>
                                    <option value="" data-brgy="Daguioman"></option>
                                    <option value="" data-brgy="Danglas"></option>
                                    <option value="" data-brgy="Dolores"></option>
                                    <option value="" data-brgy="La Paz"></option>
                                    <option value="" data-brgy="Lacub"></option>
                                    <option value="" data-brgy="Lagangilang"></option>
                                    <option value="" data-brgy="Lagayan"></option>
                                    <option value="" data-brgy="Langiden"></option>
                                    <option value="" data-brgy="Licuan-Baay"></option>
                                    <option value="" data-brgy="Luba"></option>
                                    <option value="" data-brgy="Malibcong"></option>
                                    <option value="" data-brgy="Manabo"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Pidigan"></option>
                                    <option value="" data-brgy="Pilar"></option>
                                    <option value="" data-brgy="Sallapadan"></option>
                                    <option value="" data-brgy="San Isidro"></option>
                                    <option value="" data-brgy="San Juan"></option>
                                    <option value="" data-brgy="San Quintin"></option>
                                    <option value="" data-brgy="Tayum"></option>
                                    <option value="" data-brgy="Tineg"></option>
                                    <option value="" data-brgy="Tubo"></option>
                                    <option value="" data-brgy="Villaviciosa"></option>
                                    <option value="" data-brgy="Buenavista"></option>
                                    <option value="" data-brgy="Butuan"></option>
                                    <option value="" data-brgy="Cabadbaran"></option>
                                    <option value="" data-brgy="Carmen"></option>
                                    <option value="" data-brgy="Jabonga"></option>
                                    <option value="" data-brgy="Kitcharao"></option>
                                    <option value="" data-brgy="Las Nieves"></option>
                                    <option value="" data-brgy="Magallanes"></option>
                                    <option value="" data-brgy="Nasipit"></option>
                                    <option value="" data-brgy="Remedios T. Romualdez"></option>
                                    <option value="" data-brgy="Santiago"></option>
                                    <option value="" data-brgy="Tubay"></option>
                                    <option value="" data-brgy="Bayugan"></option>
                                    <option value="" data-brgy="Bunawan"></option>
                                    <option value="" data-brgy="Esperanza"></option>
                                    <option value="" data-brgy="La Paz"></option>
                                    <option value="" data-brgy="Loreto"></option>
                                    <option value="" data-brgy="Prosperidad"></option>
                                    <option value="" data-brgy="Rosario"></option>
                                    <option value="" data-brgy="San Francisco"></option>
                                    <option value="" data-brgy="San Luis"></option>
                                    <option value="Angas" data-brgy="Santa Josefa">Angas</option>
                                    <option value="San jose" data-brgy="Santa Josefa">San jose</option>
                                    <option value="Awao" data-brgy="Santa Josefa">Awao</option>
                                    <option value="Sayon" data-brgy="Santa Josefa">Sayon</option>
                                    <option value="Poblacion" data-brgy="Santa Josefa">Poblacion</option>
                                    <option value="" data-brgy="Sibagat"></option>
                                    <option value="" data-brgy="Talacogon"></option>
                                    <option value="" data-brgy="Trento"></option>
                                    <option value="" data-brgy="Veruela"></option>
                                    <option value="" data-brgy="Altavas"></option>
                                    <option value="" data-brgy="Balete"></option>
                                    <option value="" data-brgy="Banga"></option>
                                    <option value="" data-brgy="Batan"></option>
                                    <option value="" data-brgy="Buruanga"></option>
                                    <option value="" data-brgy="Ibajay"></option>
                                    <option value="" data-brgy="Kalibo"></option>
                                    <option value="" data-brgy="Lezo"></option>
                                    <option value="" data-brgy="Libacao"></option>
                                    <option value="" data-brgy="Madalag"></option>
                                    <option value="" data-brgy="Makato"></option>
                                    <option value="" data-brgy="Malay"></option>
                                    <option value="" data-brgy="Malinao"></option>
                                    <option value="" data-brgy="Nabas"></option>
                                    <option value="" data-brgy="New Washington"></option>
                                    <option value="" data-brgy="Numancia"></option>
                                    <option value="" data-brgy="Tangalan"></option>
                                    <option value="" data-brgy="Bacacay"></option>
                                    <option value="" data-brgy="Camalig"></option>
                                    <option value="" data-brgy="Daraga"></option>
                                    <option value="" data-brgy="Guinobatan"></option>
                                    <option value="" data-brgy="Jovellar"></option>
                                    <option value="" data-brgy="Legazpi"></option>
                                    <option value="" data-brgy="Libon"></option>
                                    <option value="" data-brgy="Ligao"></option>
                                    <option value="" data-brgy="Malilipot"></option>
                                    <option value="" data-brgy="Malinao"></option>
                                    <option value="" data-brgy="Manito"></option>
                                    <option value="" data-brgy="Oas"></option>
                                    <option value="" data-brgy="Pio Duran"></option>
                                    <option value="" data-brgy="Polangui"></option>
                                    <option value="" data-brgy="Rapu-Rapu"></option>
                                    <option value="" data-brgy="Santo Domingo"></option>
                                    <option value="" data-brgy="Tabaco"></option>
                                    <option value="" data-brgy="Tiwi"></option>
                                    <option value="" data-brgy="Anini-y"></option>
                                    <option value="" data-brgy="Barbaza"></option>
                                    <option value="" data-brgy="Belison"></option>
                                    <option value="" data-brgy="Bugasong"></option>
                                    <option value="" data-brgy="Caluya"></option>
                                    <option value="" data-brgy="Culasi"></option>
                                    <option value="" data-brgy="Hamtic"></option>
                                    <option value="" data-brgy="Laua-an"></option>
                                    <option value="" data-brgy="Libertad"></option>
                                    <option value="" data-brgy="Pandan"></option>
                                    <option value="" data-brgy="Patnongon"></option>
                                    <option value="" data-brgy="San Jose de Buenavista"></option>
                                    <option value="" data-brgy="San Remigio"></option>
                                    <option value="" data-brgy="Sebaste"></option>
                                    <option value="" data-brgy="Sibalom"></option>
                                    <option value="" data-brgy="Tibiao"></option>
                                    <option value="" data-brgy="Tobias Fornier"></option>
                                    <option value="" data-brgy="Valderrama"></option>
                                    <option value="" data-brgy="Calanasan"></option>
                                    <option value="" data-brgy="Conner"></option>
                                    <option value="" data-brgy="Flora"></option>
                                    <option value="" data-brgy="Kabugao"></option>
                                    <option value="" data-brgy="Luna"></option>
                                    <option value="" data-brgy="Pudtol"></option>
                                    <option value="" data-brgy="Santa Marcela"></option>
                                    <option value="" data-brgy="Baler"></option>
                                    <option value="" data-brgy="Casiguran"></option>
                                    <option value="" data-brgy="Dilasag"></option>
                                    <option value="" data-brgy="Dinalungan"></option>
                                    <option value="" data-brgy="Dingalan"></option>
                                    <option value="" data-brgy="Dipaculao"></option>
                                    <option value="" data-brgy="Maria Aurora"></option>
                                    <option value="" data-brgy="San Luis"></option>
                                    <option value="" data-brgy="Akbar"></option>
                                    <option value="" data-brgy="Al-Barka"></option>
                                    <option value="" data-brgy="Hadji Mohammad Ajul"></option>
                                    <option value="" data-brgy="Hadji Muhtamad"></option>
                                    <option value="" data-brgy="Isabela"></option>
                                    <option value="" data-brgy="Lamitan"></option>
                                    <option value="" data-brgy="Lantawan"></option>
                                    <option value="" data-brgy="Maluso"></option>
                                    <option value="" data-brgy="Sumisip"></option>
                                    <option value="" data-brgy="Tabuan-Lasa"></option>
                                    <option value="" data-brgy="Tipo-Tipo"></option>
                                    <option value="" data-brgy="Tuburan"></option>
                                    <option value="" data-brgy="Ungkaya Pukan"></option>
                                    <option value="" data-brgy="Abucay"></option>
                                    <option value="" data-brgy="Bagac"></option>
                                    <option value="" data-brgy="Balanga"></option>
                                    <option value="" data-brgy="Dinalupihan"></option>
                                    <option value="" data-brgy="Hermosa"></option>
                                    <option value="" data-brgy="Limay"></option>
                                    <option value="" data-brgy="Mariveles"></option>
                                    <option value="" data-brgy="Morong"></option>
                                    <option value="" data-brgy="Orani"></option>
                                    <option value="" data-brgy="Orion"></option>
                                    <option value="" data-brgy="Pilar"></option>
                                    <option value="" data-brgy="Samal"></option>
                                    <option value="" data-brgy="Basco"></option>
                                    <option value="" data-brgy="Itbayat"></option>
                                    <option value="" data-brgy="Ivana"></option>
                                    <option value="" data-brgy="Mahatao"></option>
                                    <option value="" data-brgy="Sabtang"></option>
                                    <option value="" data-brgy="Uyugan"></option>
                                    <option value="" data-brgy="Agoncillo"></option>
                                    <option value="" data-brgy="Alitagtag"></option>
                                    <option value="" data-brgy="Balayan"></option>
                                    <option value="" data-brgy="Balete"></option>
                                    <option value="" data-brgy="Batangas City"></option>
                                    <option value="" data-brgy="Bauan"></option>
                                    <option value="" data-brgy="Calaca"></option>
                                    <option value="" data-brgy="Calatagan"></option>
                                    <option value="" data-brgy="Cuenca"></option>
                                    <option value="" data-brgy="Ibaan"></option>
                                    <option value="" data-brgy="Laurel"></option>
                                    <option value="" data-brgy="Lemery"></option>
                                    <option value="" data-brgy="Lian"></option>
                                    <option value="" data-brgy="Lipa"></option>
                                    <option value="" data-brgy="Lobo"></option>
                                    <option value="" data-brgy="Mabini"></option>
                                    <option value="" data-brgy="Malvar"></option>
                                    <option value="" data-brgy="Mataasnakahoy"></option>
                                    <option value="" data-brgy="Nasugbu"></option>
                                    <option value="" data-brgy="Padre Garcia"></option>
                                    <option value="" data-brgy="Rosario"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="San Juan"></option>
                                    <option value="" data-brgy="San Luis"></option>
                                    <option value="" data-brgy="San Nicolas"></option>
                                    <option value="" data-brgy="San Pascual"></option>
                                    <option value="" data-brgy="Santa Teresita"></option>
                                    <option value="" data-brgy="Santo Tomas"></option>
                                    <option value="" data-brgy="Taal"></option>
                                    <option value="" data-brgy="Talisay"></option>
                                    <option value="" data-brgy="Tanauan"></option>
                                    <option value="" data-brgy="Taysan"></option>
                                    <option value="" data-brgy="Tingloy"></option>
                                    <option value="" data-brgy="Tuy"></option>
                                    <option value="" data-brgy="Atok"></option>
                                    <option value="" data-brgy="Baguio"></option>
                                    <option value="" data-brgy="Bakun"></option>
                                    <option value="" data-brgy="Bokod"></option>
                                    <option value="" data-brgy="Buguias"></option>
                                    <option value="" data-brgy="Itogon"></option>
                                    <option value="" data-brgy="Kabayan"></option>
                                    <option value="" data-brgy="Kapangan"></option>
                                    <option value="" data-brgy="Kibungan"></option>
                                    <option value="" data-brgy="La Trinidad"></option>
                                    <option value="" data-brgy="Mankayan"></option>
                                    <option value="" data-brgy="Sablan"></option>
                                    <option value="" data-brgy="Tuba"></option>
                                    <option value="" data-brgy="Tublay"></option>
                                    <option value="" data-brgy="Almeria"></option>
                                    <option value="" data-brgy="Biliran"></option>
                                    <option value="" data-brgy="Cabucgayan"></option>
                                    <option value="" data-brgy="Caibiran"></option>
                                    <option value="" data-brgy="Culaba"></option>
                                    <option value="" data-brgy="Kawayan"></option>
                                    <option value="" data-brgy="Maripipi"></option>
                                    <option value="" data-brgy="Naval"></option>
                                    <option value="" data-brgy="Alburquerque"></option>
                                    <option value="" data-brgy="Alicia"></option>
                                    <option value="" data-brgy="Anda"></option>
                                    <option value="" data-brgy="Antequera"></option>
                                    <option value="" data-brgy="Baclayon"></option>
                                    <option value="" data-brgy="Balilihan"></option>
                                    <option value="" data-brgy="Batuan"></option>
                                    <option value="" data-brgy="Bien Unido"></option>
                                    <option value="" data-brgy="Bilar"></option>
                                    <option value="" data-brgy="Buenavista"></option>
                                    <option value="" data-brgy="Calape"></option>
                                    <option value="" data-brgy="Candijay"></option>
                                    <option value="" data-brgy="Carmen"></option>
                                    <option value="" data-brgy="Catigbian"></option>
                                    <option value="" data-brgy="Clarin"></option>
                                    <option value="" data-brgy="Corella"></option>
                                    <option value="" data-brgy="Cortes"></option>
                                    <option value="" data-brgy="Dagohoy"></option>
                                    <option value="" data-brgy="Danao"></option>
                                    <option value="" data-brgy="Dauis"></option>
                                    <option value="" data-brgy="Dimiao"></option>
                                    <option value="" data-brgy="Duero"></option>
                                    <option value="" data-brgy="Garcia Hernandez"></option>
                                    <option value="" data-brgy="Getafe"></option>
                                    <option value="" data-brgy="Guindulman"></option>
                                    <option value="" data-brgy="Inabanga"></option>
                                    <option value="" data-brgy="Jagna"></option>
                                    <option value="" data-brgy="Lila"></option>
                                    <option value="" data-brgy="Loay"></option>
                                    <option value="" data-brgy="Loboc"></option>
                                    <option value="" data-brgy="Loon"></option>
                                    <option value="" data-brgy="Mabini"></option>
                                    <option value="" data-brgy="Maribojoc"></option>
                                    <option value="" data-brgy="Panglao"></option>
                                    <option value="" data-brgy="Pilar"></option>
                                    <option value="" data-brgy="President Carlos P. Garcia"></option>
                                    <option value="" data-brgy="Sagbayan"></option>
                                    <option value="" data-brgy="San Isidro"></option>
                                    <option value="" data-brgy="San Miguel"></option>
                                    <option value="" data-brgy="Sevilla"></option>
                                    <option value="" data-brgy="Sierra Bullones"></option>
                                    <option value="" data-brgy="Sikatuna"></option>
                                    <option value="" data-brgy="Tagbilaran"></option>
                                    <option value="" data-brgy="Talibon"></option>
                                    <option value="" data-brgy="Trinidad"></option>
                                    <option value="" data-brgy="Tubigon"></option>
                                    <option value="" data-brgy="Ubay"></option>
                                    <option value="" data-brgy="Valencia"></option>
                                    <option value="" data-brgy="Baungon"></option>
                                    <option value="" data-brgy="Cabanglasan"></option>
                                    <option value="" data-brgy="Damulog"></option>
                                    <option value="" data-brgy="Dangcagan"></option>
                                    <option value="" data-brgy="Don Carlos"></option>
                                    <option value="" data-brgy="Impasugong"></option>
                                    <option value="" data-brgy="Kadingilan"></option>
                                    <option value="" data-brgy="Kalilangan"></option>
                                    <option value="" data-brgy="Kibawe"></option>
                                    <option value="" data-brgy="Kitaotao"></option>
                                    <option value="" data-brgy="Lantapan"></option>
                                    <option value="" data-brgy="Libona"></option>
                                    <option value="" data-brgy="Malaybalay"></option>
                                    <option value="" data-brgy="Malitbog"></option>
                                    <option value="" data-brgy="Manolo Fortich"></option>
                                    <option value="" data-brgy="Maramag"></option>
                                    <option value="" data-brgy="Pangantucan"></option>
                                    <option value="" data-brgy="Quezon"></option>
                                    <option value="" data-brgy="San Fernando"></option>
                                    <option value="" data-brgy="Sumilao"></option>
                                    <option value="" data-brgy="Talakag"></option>
                                    <option value="" data-brgy="Valencia"></option>
                                    <option value="" data-brgy="Angat"></option>
                                    <option value="" data-brgy="Balagtas"></option>
                                    <option value="" data-brgy="Baliuag"></option>
                                    <option value="" data-brgy="Bocaue"></option>
                                    <option value="" data-brgy="Bulakan"></option>
                                    <option value="" data-brgy="Bustos"></option>
                                    <option value="" data-brgy="Calumpit"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Guiguinto"></option>
                                    <option value="" data-brgy="Hagonoy"></option>
                                    <option value="" data-brgy="Malolos"></option>
                                    <option value="" data-brgy="Marilao"></option>
                                    <option value="" data-brgy="Meycauayan"></option>
                                    <option value="" data-brgy="Norzagaray"></option>
                                    <option value="" data-brgy="Obando"></option>
                                    <option value="" data-brgy="Pandi"></option>
                                    <option value="" data-brgy="Paombong"></option>
                                    <option value="" data-brgy="Plaridel"></option>
                                    <option value="" data-brgy="Pulilan"></option>
                                    <option value="" data-brgy="San Ildefonso"></option>
                                    <option value="" data-brgy="San Jose del Monte"></option>
                                    <option value="" data-brgy="San Miguel"></option>
                                    <option value="" data-brgy="San Rafael"></option>
                                    <option value="" data-brgy="Santa Maria"></option>
                                    <option value="" data-brgy="Abulug"></option>
                                    <option value="" data-brgy="Alcala"></option>
                                    <option value="" data-brgy="Allacapan"></option>
                                    <option value="" data-brgy="Amulung"></option>
                                    <option value="" data-brgy="Aparri"></option>
                                    <option value="" data-brgy="Baggao"></option>
                                    <option value="" data-brgy="Ballesteros"></option>
                                    <option value="" data-brgy="Buguey"></option>
                                    <option value="" data-brgy="Calayan"></option>
                                    <option value="" data-brgy="Camalaniugan"></option>
                                    <option value="" data-brgy="Claveria"></option>
                                    <option value="" data-brgy="Enrile"></option>
                                    <option value="" data-brgy="Gattaran"></option>
                                    <option value="" data-brgy="Gonzaga"></option>
                                    <option value="" data-brgy="Iguig"></option>
                                    <option value="" data-brgy="Lal-lo"></option>
                                    <option value="" data-brgy="Lasam"></option>
                                    <option value="" data-brgy="Pamplona"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Piat"></option>
                                    <option value="" data-brgy="Rizal"></option>
                                    <option value="" data-brgy="Sanchez-Mira"></option>
                                    <option value="" data-brgy="Santa Ana"></option>
                                    <option value="" data-brgy="Santa Praxedes"></option>
                                    <option value="" data-brgy="Santa Teresita"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Solana"></option>
                                    <option value="" data-brgy="Tuao"></option>
                                    <option value="" data-brgy="Tuguegarao"></option>
                                    <option value="" data-brgy="Basud"></option>
                                    <option value="" data-brgy="Capalonga"></option>
                                    <option value="" data-brgy="Daet"></option>
                                    <option value="" data-brgy="Jose Panganiban"></option>
                                    <option value="" data-brgy="Labo"></option>
                                    <option value="" data-brgy="Mercedes"></option>
                                    <option value="" data-brgy="Paracale"></option>
                                    <option value="" data-brgy="San Lorenzo Ruiz"></option>
                                    <option value="" data-brgy="San Vicente"></option>
                                    <option value="" data-brgy="Santa Elena"></option>
                                    <option value="" data-brgy="Talisay"></option>
                                    <option value="" data-brgy="Vinzons"></option>
                                    <option value="" data-brgy="Baao"></option>
                                    <option value="" data-brgy="Balatan"></option>
                                    <option value="" data-brgy="Bato"></option>
                                    <option value="" data-brgy="Bombon"></option>
                                    <option value="" data-brgy="Buhi"></option>
                                    <option value="" data-brgy="Bula"></option>
                                    <option value="" data-brgy="Cabusao"></option>
                                    <option value="" data-brgy="Calabanga"></option>
                                    <option value="" data-brgy="Camaligan"></option>
                                    <option value="" data-brgy="Canaman"></option>
                                    <option value="" data-brgy="Caramoan"></option>
                                    <option value="" data-brgy="Del Gallego"></option>
                                    <option value="" data-brgy="Gainza"></option>
                                    <option value="" data-brgy="Garchitorena"></option>
                                    <option value="" data-brgy="Goa"></option>
                                    <option value="" data-brgy="Iriga"></option>
                                    <option value="" data-brgy="Lagonoy"></option>
                                    <option value="" data-brgy="Libmanan"></option>
                                    <option value="" data-brgy="Lupi"></option>
                                    <option value="" data-brgy="Magarao"></option>
                                    <option value="" data-brgy="Milaor"></option>
                                    <option value="" data-brgy="Minalabac"></option>
                                    <option value="" data-brgy="Nabua"></option>
                                    <option value="" data-brgy="Naga"></option>
                                    <option value="" data-brgy="Ocampo"></option>
                                    <option value="" data-brgy="Pamplona"></option>
                                    <option value="" data-brgy="Pasacao"></option>
                                    <option value="" data-brgy="Pili"></option>
                                    <option value="" data-brgy="Presentacion"></option>
                                    <option value="" data-brgy="Ragay"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="San Fernando"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="Sipocot"></option>
                                    <option value="" data-brgy="Siruma"></option>
                                    <option value="" data-brgy="Tigaon"></option>
                                    <option value="" data-brgy="Tinambac"></option>
                                    <option value="" data-brgy="Catarman"></option>
                                    <option value="" data-brgy="Guinsiliban"></option>
                                    <option value="" data-brgy="Mahinog"></option>
                                    <option value="" data-brgy="Mambajao"></option>
                                    <option value="" data-brgy="Sagay"></option>
                                    <option value="" data-brgy="Cuartero"></option>
                                    <option value="" data-brgy="Dao"></option>
                                    <option value="" data-brgy="Dumalag"></option>
                                    <option value="" data-brgy="Dumarao"></option>
                                    <option value="" data-brgy="Ivisan"></option>
                                    <option value="" data-brgy="Jamindan"></option>
                                    <option value="" data-brgy="Ma-ayon"></option>
                                    <option value="" data-brgy="Mambusao"></option>
                                    <option value="" data-brgy="Panay"></option>
                                    <option value="" data-brgy="Panitan"></option>
                                    <option value="" data-brgy="Pilar"></option>
                                    <option value="" data-brgy="Pontevedra"></option>
                                    <option value="" data-brgy="President Roxas"></option>
                                    <option value="" data-brgy="Roxas"></option>
                                    <option value="" data-brgy="Sapian"></option>
                                    <option value="" data-brgy="Sigma"></option>
                                    <option value="" data-brgy="Tapaz"></option>
                                    <option value="" data-brgy="Bagamanoc"></option>
                                    <option value="" data-brgy="Baras"></option>
                                    <option value="" data-brgy="Bato"></option>
                                    <option value="" data-brgy="Caramoran"></option>
                                    <option value="" data-brgy="Gigmoto"></option>
                                    <option value="" data-brgy="Pandan"></option>
                                    <option value="" data-brgy="Panganiban"></option>
                                    <option value="" data-brgy="San Andres"></option>
                                    <option value="" data-brgy="San Miguel"></option>
                                    <option value="" data-brgy="Viga"></option>
                                    <option value="" data-brgy="Virac"></option>
                                    <option value="" data-brgy="Alfonso"></option>
                                    <option value="" data-brgy="Amadeo"></option>
                                    <option value="" data-brgy="Bacoor"></option>
                                    <option value="" data-brgy="Carmona"></option>
                                    <option value="" data-brgy="Cavite City"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="General Emilio Aguinaldo"></option>
                                    <option value="" data-brgy="General Mariano Alvarez"></option>
                                    <option value="" data-brgy="General Trias"></option>
                                    <option value="" data-brgy="Imus"></option>
                                    <option value="" data-brgy="Indang"></option>
                                    <option value="" data-brgy="Kawit"></option>
                                    <option value="" data-brgy="Magallanes"></option>
                                    <option value="" data-brgy="Maragondon"></option>
                                    <option value="" data-brgy="Mendez"></option>
                                    <option value="" data-brgy="Naic"></option>
                                    <option value="" data-brgy="Noveleta"></option>
                                    <option value="" data-brgy="Rosario"></option>
                                    <option value="" data-brgy="Silang"></option>
                                    <option value="" data-brgy="Tagaytay"></option>
                                    <option value="" data-brgy="Tanza"></option>
                                    <option value="" data-brgy="Ternate"></option>
                                    <option value="" data-brgy="Trece Martires"></option>
                                    <option value="" data-brgy="Alcantara"></option>
                                    <option value="" data-brgy="Alcoy"></option>
                                    <option value="" data-brgy="Alegria"></option>
                                    <option value="" data-brgy="Aloguinsan"></option>
                                    <option value="" data-brgy="Argao"></option>
                                    <option value="" data-brgy="Asturias"></option>
                                    <option value="" data-brgy="Badian"></option>
                                    <option value="" data-brgy="Balamban"></option>
                                    <option value="" data-brgy="Bantayan"></option>
                                    <option value="" data-brgy="Barili"></option>
                                    <option value="" data-brgy="Bogo"></option>
                                    <option value="" data-brgy="Boljoon"></option>
                                    <option value="" data-brgy="Borbon"></option>
                                    <option value="" data-brgy="Carcar"></option>
                                    <option value="" data-brgy="Carmen"></option>
                                    <option value="" data-brgy="Catmon"></option>
                                    <option value="" data-brgy="Cebu City"></option>
                                    <option value="" data-brgy="Compostela"></option>
                                    <option value="" data-brgy="Consolacion"></option>
                                    <option value="" data-brgy="Cordova"></option>
                                    <option value="" data-brgy="Daanbantayan"></option>
                                    <option value="" data-brgy="Dalaguete"></option>
                                    <option value="" data-brgy="Danao"></option>
                                    <option value="" data-brgy="Dumanjug"></option>
                                    <option value="" data-brgy="Ginatilan"></option>
                                    <option value="" data-brgy="Lapu-Lapu"></option>
                                    <option value="" data-brgy="Liloan"></option>
                                    <option value="" data-brgy="Madridejos"></option>
                                    <option value="" data-brgy="Malabuyoc"></option>
                                    <option value="" data-brgy="Mandaue"></option>
                                    <option value="" data-brgy="Medellin"></option>
                                    <option value="" data-brgy="Minglanilla"></option>
                                    <option value="" data-brgy="Moalboal"></option>
                                    <option value="" data-brgy="Naga"></option>
                                    <option value="" data-brgy="Oslob"></option>
                                    <option value="" data-brgy="Pilar"></option>
                                    <option value="" data-brgy="Pinamungajan"></option>
                                    <option value="" data-brgy="Poro"></option>
                                    <option value="" data-brgy="Ronda"></option>
                                    <option value="" data-brgy="Samboan"></option>
                                    <option value="" data-brgy="San Fernando"></option>
                                    <option value="" data-brgy="San Francisco"></option>
                                    <option value="" data-brgy="San Remigio"></option>
                                    <option value="" data-brgy="Santa Fe"></option>
                                    <option value="" data-brgy="Santander"></option>
                                    <option value="" data-brgy="Sibonga"></option>
                                    <option value="" data-brgy="Sogod"></option>
                                    <option value="" data-brgy="Tabogon"></option>
                                    <option value="" data-brgy="Tabuelan"></option>
                                    <option value="" data-brgy="Talisay"></option>
                                    <option value="" data-brgy="Toledo"></option>
                                    <option value="" data-brgy="Tuburan"></option>
                                    <option value="" data-brgy="Tudela"></option>
                                    <option value="" data-brgy="Alamada"></option>
                                    <option value="" data-brgy="Aleosan"></option>
                                    <option value="" data-brgy="Antipas"></option>
                                    <option value="" data-brgy="Arakan"></option>
                                    <option value="" data-brgy="Banisilan"></option>
                                    <option value="" data-brgy="Carmen"></option>
                                    <option value="" data-brgy="Kabacan"></option>
                                    <option value="" data-brgy="Kidapawan"></option>
                                    <option value="" data-brgy="Libungan"></option>
                                    <option value="" data-brgy="M'lang"></option>
                                    <option value="" data-brgy="Magpet"></option>
                                    <option value="" data-brgy="Makilala"></option>
                                    <option value="" data-brgy="Matalam"></option>
                                    <option value="" data-brgy="Midsayap"></option>
                                    <option value="" data-brgy="Pigcawayan"></option>
                                    <option value="" data-brgy="Pikit"></option>
                                    <option value="" data-brgy="President Roxas"></option>
                                    <option value="" data-brgy="Tulunan"></option>
                                    <option value="" data-brgy="Compostela"></option>
                                    <option value="" data-brgy="Laak"></option>
                                    <option value="" data-brgy="Mabini"></option>
                                    <option value="" data-brgy="Maco"></option>
                                    <option value="" data-brgy="Maragusan"></option>
                                    <option value="" data-brgy="Mawab"></option>
                                    <option value="" data-brgy="Monkayo"></option>
                                    <option value="" data-brgy="Montevista"></option>
                                    <option value="" data-brgy="Nabunturan"></option>
                                    <option value="" data-brgy="New Bataan"></option>
                                    <option value="" data-brgy="Pantukan"></option>
                                    <option value="" data-brgy="Asuncion"></option>
                                    <option value="" data-brgy="Braulio E. Dujali"></option>
                                    <option value="" data-brgy="Carmen"></option>
                                    <option value="" data-brgy="Kapalong"></option>
                                    <option value="" data-brgy="New Corella"></option>
                                    <option value="" data-brgy="Panabo"></option>
                                    <option value="" data-brgy="Samal"></option>
                                    <option value="" data-brgy="San Isidro"></option>
                                    <option value="" data-brgy="Santo Tomas"></option>
                                    <option value="" data-brgy="Tagum"></option>
                                    <option value="" data-brgy="Talaingod"></option>
                                    <option value="" data-brgy="Bansalan"></option>
                                    <option value="" data-brgy="Davao City"></option>
                                    <option value="" data-brgy="Digos"></option>
                                    <option value="" data-brgy="Hagonoy"></option>
                                    <option value="" data-brgy="Kiblawan"></option>
                                    <option value="" data-brgy="Magsaysay"></option>
                                    <option value="" data-brgy="Malalag"></option>
                                    <option value="" data-brgy="Matanao"></option>
                                    <option value="" data-brgy="Padada"></option>
                                    <option value="" data-brgy="Santa Cruz"></option>
                                    <option value="" data-brgy="Sulop"></option>
                                    <option value="" data-brgy="Don Marcelino"></option>
                                    <option value="" data-brgy="Jose Abad Santos"></option>
                                    <option value="" data-brgy="Malita"></option>
                                    <option value="" data-brgy="Santa Maria"></option>
                                    <option value="" data-brgy="Sarangani"></option>
                                    <option value="Baculin" data-brgy="Baganga">Baculin</option>
                                    <option value="Banao" data-brgy="Baganga">Banao</option>
                                    <option value="Batawan" data-brgy="Baganga">Batawan</option>
                                    <option value="Batiano" data-brgy="Baganga">Batiano</option>
                                    <option value="Binondo" data-brgy="Baganga">Binondo</option>
                                    <option value="Bobonao" data-brgy="Baganga">Bobonao</option>
                                    <option value="Campawan" data-brgy="Baganga">Campawan</option>
                                    <option value="Central" data-brgy="Baganga">Central</option>
                                    <option value="Dapnan" data-brgy="Baganga">Dapnan</option>
                                    <option value="Kinablangan" data-brgy="Baganga">Kinablangan</option>
                                    <option value="Lambajon" data-brgy="Baganga">Lambajon</option>
                                    <option value="Lucod" data-brgy="Baganga">Lucod</option>
                                    <option value="Mahanub" data-brgy="Baganga">Mahanub</option>
                                    <option value="Mikit" data-brgy="Baganga">Mikit</option>
                                    <option value="Salingcomot" data-brgy="Baganga">Salingcomot</option>
                                    <option value="San Isidro" data-brgy="Baganga">San Isidro</option>
                                    <option value="San Victor" data-brgy="Baganga">San Victor</option>
                                    <option value="Saoquegue" data-brgy="Baganga">Saoquegue</option>
                                    <option value="Cabangcalan" data-brgy="Banaybanay">Cabangcalan</option>
                                    <option value="Caganganan" data-brgy="Banaybanay">Caganganan</option>
                                    <option value="Calubihan" data-brgy="Banaybanay">Calubihan</option>
                                    <option value="Causwagan" data-brgy="Banaybanay">Causwagan</option>
                                    <option value="Mahayag" data-brgy="Banaybanay">Mahayag</option>
                                    <option value="Maputi" data-brgy="Banaybanay">Maputi</option>
                                    <option value="Mogbongcogon" data-brgy="Banaybanay">Mogbongcogon</option>
                                    <option value="Panikian" data-brgy="Banaybanay">Panikian</option>
                                    <option value="Pintatagan" data-brgy="Banaybanay">Pintatagan</option>
                                    <option value="Piso Proper" data-brgy="Banaybanay">Piso Proper</option>
                                    <option value="Poblacion" data-brgy="Banaybanay">Poblacion</option>
                                    <option value="Punta Linao" data-brgy="Banaybanay">Punta Linao</option>
                                    <option value="Rang-ay" data-brgy="Banaybanay">Rang-ay</option>
                                    <option value="San Vicente" data-brgy="Banaybanay">San Vicente</option>
                                    <option value="Caatihan" data-brgy="Boston">Caatihan</option>
                                    <option value="Cabasagan" data-brgy="Boston">Cabasagan</option>
                                    <option value="Carmen" data-brgy="Boston">Carmen</option>
                                    <option value="Cawayanan" data-brgy="Boston">Cawayanan</option>
                                    <option value="Poblacion" data-brgy="Boston">Poblacion</option>
                                    <option value="San Jose" data-brgy="Boston">San Jose</option>
                                    <option value="Sibajay" data-brgy="Boston">Sibajay</option>
                                    <option value="Simulao" data-brgy="Boston">Simulao</option>
                                    <option value="Alvar" data-brgy="Caraga">Alvar</option>
                                    <option value="Caningag" data-brgy="Caraga">Caningag</option>
                                    <option value="Don Leon Balante" data-brgy="Caraga">Don Leon Balante</option>
                                    <option value="Lamiawan" data-brgy="Caraga">Lamiawan</option>
                                    <option value="Manorigao" data-brgy="Caraga">Manorigao</option>
                                    <option value="Mercedes" data-brgy="Caraga">Mercedes</option>
                                    <option value="Palma Gil" data-brgy="Caraga">Palma Gil</option>
                                    <option value="Pichon" data-brgy="Caraga">Pichon</option>
                                    <option value="Poblacion" data-brgy="Caraga">Poblacion</option>
                                    <option value="San Antonio" data-brgy="Caraga">San Antonio</option>
                                    <option value="San Jose" data-brgy="Caraga">San Jose</option>
                                    <option value="San Luis" data-brgy="Caraga">San Luis</option>
                                    <option value="San Miguel" data-brgy="Caraga">San Miguel</option>
                                    <option value="San Pedro" data-brgy="Caraga">San Pedro</option>
                                    <option value="Santa Fe" data-brgy="Caraga">Santa Fe</option>
                                    <option value="Santiago" data-brgy="Caraga">Santiago</option>
                                    <option value="Sobrecarey" data-brgy="Caraga">Sobrecarey</option>
                                    <option value="Abijod" data-brgy="Cateel">Abijod</option>
                                    <option value="Alegria" data-brgy="Cateel">Alegria</option>
                                    <option value="Aliwagwag" data-brgy="Cateel">Aliwagwag</option>
                                    <option value="Aragon" data-brgy="Cateel">Aragon</option>
                                    <option value="Baybay" data-brgy="Cateel">Baybay</option>
                                    <option value="Maglahus" data-brgy="Cateel">Maglahus</option>
                                    <option value="Mainit" data-brgy="Cateel">Mainit</option>
                                    <option value="Malibago" data-brgy="Cateel">Malibago</option>
                                    <option value="Poblacion" data-brgy="Cateel">Poblacion</option>
                                    <option value="San Alfonso" data-brgy="Cateel">San Alfonso</option>
                                    <option value="San Antonio" data-brgy="Cateel">San Antonio</option>
                                    <option value="San Miguel" data-brgy="Cateel">San Miguel</option>
                                    <option value="San Rafael" data-brgy="Cateel">San Rafael</option>
                                    <option value="San Vicente" data-brgy="Cateel">San Vicente</option>
                                    <option value="Santa Filomena" data-brgy="Cateel">Santa Filomena</option>
                                    <option value="Taytayan" data-brgy="Cateel">Taytayan</option>
                                    <option value="Anitap" data-brgy="Governor Generoso">Anitap</option>
                                    <option value="Crispin Dela Cruz" data-brgy="Governor Generoso">Crispin Dela Cruz</option>
                                    <option value="Don Aurelio Chicote" data-brgy="Governor Generoso">Don Aurelio Chicote</option>
                                    <option value="Lavigan" data-brgy="Governor Generoso">Lavigan</option>
                                    <option value="Luzon" data-brgy="Governor Generoso">Luzon</option>
                                    <option value="Magdug" data-brgy="Governor Generoso">Magdug</option>
                                    <option value="Manuel Roxas" data-brgy="Governor Generoso">Manuel Roxas</option>
                                    <option value="Monserrat" data-brgy="Governor Generoso">Monserrat</option>
                                    <option value="Nangan" data-brgy="Governor Generoso">Nangan</option>
                                    <option value="Oregon" data-brgy="Governor Generoso">Oregon</option>
                                    <option value="Poblacion" data-brgy="Governor Generoso">Poblacion</option>
                                    <option value="Pundaguitan" data-brgy="Governor Generoso">Pundaguitan</option>
                                    <option value="" data-brgy="Governor Generoso"></option>
                                    <option value="Surop" data-brgy="Governor Generoso">Surop</option>
                                    <option value="Tagabebe" data-brgy="Governor Generoso">Tagabebe</option>
                                    <option value="Tamban" data-brgy="Governor Generoso">Tamban</option>
                                    <option value="Tandang Sora" data-brgy="Governor Generoso">Tandang Sora</option>
                                    <option value="Tibanban" data-brgy="Governor Generoso">Tibanban</option>
                                    <option value="Tiblawan" data-brgy="Governor Generoso">Tiblawan</option>
                                    <option value="Upper Tibanban" data-brgy="Governor Generoso">Upper Tibanban</option>
                                    <option value="Bagumbayan" data-brgy="Lupon">Bagumbayan</option>
                                    <option value="Cabadiangan" data-brgy="Lupon">Cabadiangan</option>
                                    <option value="Calapagan" data-brgy="Lupon">Calapagan</option>
                                    <option value="Cocornon" data-brgy="Lupon">Cocornon</option>
                                    <option value="Corporacion" data-brgy="Lupon">Corporacion</option>
                                    <option value="Don Mariano Marcos" data-brgy="Lupon">Don Mariano Marcos</option>
                                    <option value="Ilangay" data-brgy="Lupon">Ilangay</option>
                                    <option value="Langka" data-brgy="Lupon">Langka</option>
                                    <option value="Lantawan" data-brgy="Lupon">Lantawan</option>
                                    <option value="Limbahan" data-brgy="Lupon">Limbahan</option>
                                    <option value="Macangao" data-brgy="Lupon">Macangao</option>
                                    <option value="Magsaysay" data-brgy="Lupon">Magsaysay</option>
                                    <option value="Mahayahay" data-brgy="Lupon">Mahayahay</option>
                                    <option value="Maragatas" data-brgy="Lupon">Maragatas</option>
                                    <option value="Marayag" data-brgy="Lupon">Marayag</option>
                                    <option value="New Visayas" data-brgy="Lupon">New Visayas</option>
                                    <option value="Poblacion" data-brgy="Lupon">Poblacion</option>
                                    <option value="San Isidro" data-brgy="Lupon">San Isidro</option>
                                    <option value="San Jose" data-brgy="Lupon">San Jose</option>
                                    <option value="Tagboa" data-brgy="Lupon">Tagboa</option>
                                    <option value="Tagugpo" data-brgy="Lupon">Tagugpo</option>
                                    <option value="Capasnan" data-brgy="Manay">Capasnan</option>
                                    <option value="Cayawan" data-brgy="Manay">Cayawan</option>
                                    <option value="Central" data-brgy="Manay">Central</option>
                                    <option value="Concepcion" data-brgy="Manay">Concepcion</option>
                                    <option value="Del Pilar" data-brgy="Manay">Del Pilar</option>
                                    <option value="Guza" data-brgy="Manay">Guza</option>
                                    <option value="Holy Cross" data-brgy="Manay">Holy Cross</option>
                                    <option value="Lambog" data-brgy="Manay">Lambog</option>
                                    <option value="Mabini" data-brgy="Manay">Mabini</option>
                                    <option value="Manreza" data-brgy="Manay">Manreza</option>
                                    <option value="New Taokanga" data-brgy="Manay">New Taokanga</option>
                                    <option value="Old Macopa" data-brgy="Manay">Old Macopa</option>
                                    <option value="Rizal" data-brgy="Manay">Rizal</option>
                                    <option value="San Fermin" data-brgy="Manay">San Fermin</option>
                                    <option value="San Ignacio" data-brgy="Manay">San Ignacio</option>
                                    <option value="San Isidro" data-brgy="Manay">San Isidro</option>
                                    <option value="Zaragosa" data-brgy="Manay">Zaragosa</option>
                                    <option value="Badas" data-brgy="Mati">Badas</option>
                                    <option value="Bobon" data-brgy="Mati">Bobon</option>
                                    <option value="Buso" data-brgy="Mati">Buso</option>
                                    <option value="Cabuaya" data-brgy="Mati">Cabuaya</option>
                                    <option value="Central" data-brgy="Mati">Central</option>
                                    <option value="Culian" data-brgy="Mati">Culian</option>
                                    <option value="Dahican" data-brgy="Mati">Dahican</option>
                                    <option value="Danao" data-brgy="Mati">Danao</option>
                                    <option value="Dawan" data-brgy="Mati">Dawan</option>
                                    <option value="Don Enrique Lopez" data-brgy="Mati">Don Enrique Lopez</option>
                                    <option value="Don Martin Marundan" data-brgy="Mati">Don Martin Marundan</option>
                                    <option value="Don Salvador Lopez, Sr." data-brgy="Mati">Don Salvador Lopez, Sr.</option>
                                    <option value="Langka" data-brgy="Mati">Langka</option>
                                    <option value="Lawigan" data-brgy="Mati">Lawigan</option>
                                    <option value="Libudon" data-brgy="Mati">Libudon</option>
                                    <option value="Luban" data-brgy="Mati">Luban</option>
                                    <option value="Macambol" data-brgy="Mati">Macambol</option>
                                    <option value="Mamali" data-brgy="Mati">Mamali</option>
                                    <option value="Matiao" data-brgy="Mati">Matiao</option>
                                    <option value="Mayo" data-brgy="Mati">Mayo</option>
                                    <option value="Sainz" data-brgy="Mati">Sainz</option>
                                    <option value="Sanghay" data-brgy="Mati">Sanghay</option>
                                    <option value="Tagabakid" data-brgy="Mati">Tagabakid</option>
                                    <option value="Tagbinonga" data-brgy="Mati">Tagbinonga</option>
                                    <option value="Taguibo" data-brgy="Mati">Taguibo</option>
                                    <option value="Tamisan" data-brgy="Mati">Tamisan</option>
                                    <option value="Baon" data-brgy="San Isidro">Baon</option>
                                    <option value="Batobato" data-brgy="San Isidro">Batobato</option>
                                    <option value="Bitaogan" data-brgy="San Isidro">Bitaogan</option>
                                    <option value="Cambaleon" data-brgy="San Isidro">Cambaleon</option>
                                    <option value="Dugmanon" data-brgy="San Isidro">Dugmanon</option>
                                    <option value="Iba" data-brgy="San Isidro">Iba</option>
                                    <option value="La Union" data-brgy="San Isidro">La Union</option>
                                    <option value="Lapu-lapu" data-brgy="San Isidro">Lapu-lapu</option>
                                    <option value="Maag" data-brgy="San Isidro">Maag</option>
                                    <option value="Manikling" data-brgy="San Isidro">Manikling</option>
                                    <option value="Maputi" data-brgy="San Isidro">Maputi</option>
                                    <option value="San Miguel" data-brgy="San Isidro">San Miguel</option>
                                    <option value="San Roque" data-brgy="San Isidro">San Roque</option>
                                    <option value="Santo Rosario" data-brgy="San Isidro">Santo Rosario</option>
                                    <option value="Sudlon" data-brgy="San Isidro">Sudlon</option>
                                    <option value="Talisay" data-brgy="San Isidro">Talisay</option>
                                    <option value="Cabagayan" data-brgy="Tarragona">Cabagayan</option>
                                    <option value="Central" data-brgy="Tarragona">Central</option>
                                    <option value="Dadong" data-brgy="Tarragona">Dadong</option>
                                    <option value="Jovellar" data-brgy="Tarragona">Jovellar</option>
                                    <option value="Limot" data-brgy="Tarragona">Limot</option>
                                    <option value="Lucatan" data-brgy="Tarragona">Lucatan</option>
                                    <option value="Maganda" data-brgy="Tarragona">Maganda</option>
                                    <option value="Ompao" data-brgy="Tarragona">Ompao</option>
                                    <option value="Tomoaong" data-brgy="Tarragona">Tomoaong</option>
                                    <option value="Tubaon" data-brgy="Tarragona">Tubaon</option>
                                    <option value="" data-brgy="Basilisa"></option>
                                    <option value="" data-brgy="Cagdianao"></option>
                                    <option value="" data-brgy="Dinagat"></option>
                                    <option value="" data-brgy="Libjo"></option>
                                    <option value="" data-brgy="Loreto"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="Tubajon"></option>
                                    <option value="" data-brgy="Arteche"></option>
                                    <option value="" data-brgy="Balangiga"></option>
                                    <option value="" data-brgy="Balangkayan"></option>
                                    <option value="" data-brgy="Borongan"></option>
                                    <option value="" data-brgy="Can-avid"></option>
                                    <option value="" data-brgy="Dolores"></option>
                                    <option value="" data-brgy="General MacArthur"></option>
                                    <option value="" data-brgy="Giporlos"></option>
                                    <option value="" data-brgy="Guiuan"></option>
                                    <option value="" data-brgy="Hernani"></option>
                                    <option value="" data-brgy="Jipapad"></option>
                                    <option value="" data-brgy="Lawaan"></option>
                                    <option value="" data-brgy="Llorente"></option>
                                    <option value="" data-brgy="Maslog"></option>
                                    <option value="" data-brgy="Maydolong"></option>
                                    <option value="" data-brgy="Mercedes"></option>
                                    <option value="" data-brgy="Oras"></option>
                                    <option value="" data-brgy="Quinapondan"></option>
                                    <option value="" data-brgy="Salcedo"></option>
                                    <option value="" data-brgy="San Julian"></option>
                                    <option value="" data-brgy="San Policarpo"></option>
                                    <option value="" data-brgy="Sulat"></option>
                                    <option value="" data-brgy="Taft"></option>
                                    <option value="" data-brgy="Buenavista"></option>
                                    <option value="" data-brgy="Jordan"></option>
                                    <option value="" data-brgy="Nueva Valencia"></option>
                                    <option value="" data-brgy="San Lorenzo"></option>
                                    <option value="" data-brgy="Sibunag"></option>
                                    <option value="" data-brgy="Aguinaldo"></option>
                                    <option value="" data-brgy="Alfonso Lista"></option>
                                    <option value="" data-brgy="Asipulo"></option>
                                    <option value="" data-brgy="Banaue"></option>
                                    <option value="" data-brgy="Hingyon"></option>
                                    <option value="" data-brgy="Hungduan"></option>
                                    <option value="" data-brgy="Kiangan"></option>
                                    <option value="" data-brgy="Lagawe"></option>
                                    <option value="" data-brgy="Lamut"></option>
                                    <option value="" data-brgy="Mayoyao"></option>
                                    <option value="" data-brgy="Tinoc"></option>
                                    <option value="" data-brgy="Adams"></option>
                                    <option value="" data-brgy="Bacarra"></option>
                                    <option value="" data-brgy="Badoc"></option>
                                    <option value="" data-brgy="Bangui"></option>
                                    <option value="" data-brgy="Banna"></option>
                                    <option value="" data-brgy="Batac"></option>
                                    <option value="" data-brgy="Burgos"></option>
                                    <option value="" data-brgy="Carasi"></option>
                                    <option value="" data-brgy="Currimao"></option>
                                    <option value="" data-brgy="Dingras"></option>
                                    <option value="" data-brgy="Dumalneg"></option>
                                    <option value="" data-brgy="Laoag"></option>
                                    <option value="" data-brgy="Marcos"></option>
                                    <option value="" data-brgy="Nueva Era"></option>
                                    <option value="" data-brgy="Pagudpud"></option>
                                    <option value="" data-brgy="Paoay"></option>
                                    <option value="" data-brgy="Pasuquin"></option>
                                    <option value="" data-brgy="Piddig"></option>
                                    <option value="" data-brgy="Pinili"></option>
                                    <option value="" data-brgy="San Nicolas"></option>
                                    <option value="" data-brgy="Sarrat"></option>
                                    <option value="" data-brgy="Solsona"></option>
                                    <option value="" data-brgy="Vintar"></option>
                                    <option value="" data-brgy="Alilem"></option>
                                    <option value="" data-brgy="Banayoyo"></option>
                                    <option value="" data-brgy="Bantay"></option>
                                    <option value="" data-brgy="Burgos"></option>
                                    <option value="" data-brgy="Cabugao"></option>
                                    <option value="" data-brgy="Candon"></option>
                                    <option value="" data-brgy="Caoayan"></option>
                                    <option value="" data-brgy="Cervantes"></option>
                                    <option value="" data-brgy="Galimuyod"></option>
                                    <option value="" data-brgy="Gregorio del Pilar"></option>
                                    <option value="" data-brgy="Lidlidda"></option>
                                    <option value="" data-brgy="Magsingal"></option>
                                    <option value="" data-brgy="Nagbukel"></option>
                                    <option value="" data-brgy="Narvacan"></option>
                                    <option value="" data-brgy="Quirino"></option>
                                    <option value="" data-brgy="Salcedo"></option>
                                    <option value="" data-brgy="San Emilio"></option>
                                    <option value="" data-brgy="San Esteban"></option>
                                    <option value="" data-brgy="San Ildefonso"></option>
                                    <option value="" data-brgy="San Juan"></option>
                                    <option value="" data-brgy="San Vicente"></option>
                                    <option value="" data-brgy="Santa Catalina"></option>
                                    <option value="" data-brgy="Santa Cruz"></option>
                                    <option value="" data-brgy="Santa Lucia"></option>
                                    <option value="" data-brgy="Santa Maria"></option>
                                    <option value="" data-brgy="Santa"></option>
                                    <option value="" data-brgy="Santiago"></option>
                                    <option value="" data-brgy="Santo Domingo"></option>
                                    <option value="" data-brgy="Sigay"></option>
                                    <option value="" data-brgy="Sinait"></option>
                                    <option value="" data-brgy="Sugpon"></option>
                                    <option value="" data-brgy="Suyo"></option>
                                    <option value="" data-brgy="Tagudin"></option>
                                    <option value="" data-brgy="Vigan"></option>
                                    <option value="" data-brgy="Ajuy"></option>
                                    <option value="" data-brgy="Alimodian"></option>
                                    <option value="" data-brgy="Anilao"></option>
                                    <option value="" data-brgy="Badiangan"></option>
                                    <option value="" data-brgy="Balasan"></option>
                                    <option value="" data-brgy="Banate"></option>
                                    <option value="" data-brgy="Barotac Nuevo"></option>
                                    <option value="" data-brgy="Barotac Viejo"></option>
                                    <option value="" data-brgy="Batad"></option>
                                    <option value="" data-brgy="Bingawan"></option>
                                    <option value="" data-brgy="Cabatuan"></option>
                                    <option value="" data-brgy="Calinog"></option>
                                    <option value="" data-brgy="Carles"></option>
                                    <option value="" data-brgy="Concepcion"></option>
                                    <option value="" data-brgy="Dingle"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Dumangas"></option>
                                    <option value="" data-brgy="Estancia"></option>
                                    <option value="" data-brgy="Guimbal"></option>
                                    <option value="" data-brgy="Igbaras"></option>
                                    <option value="" data-brgy="Iloilo City"></option>
                                    <option value="" data-brgy="Janiuay"></option>
                                    <option value="" data-brgy="Lambunao"></option>
                                    <option value="" data-brgy="Leganes"></option>
                                    <option value="" data-brgy="Lemery"></option>
                                    <option value="" data-brgy="Leon"></option>
                                    <option value="" data-brgy="Maasin"></option>
                                    <option value="" data-brgy="Miagao"></option>
                                    <option value="" data-brgy="Mina"></option>
                                    <option value="" data-brgy="New Lucena"></option>
                                    <option value="" data-brgy="Oton"></option>
                                    <option value="" data-brgy="Passi"></option>
                                    <option value="" data-brgy="Pavia"></option>
                                    <option value="" data-brgy="Pototan"></option>
                                    <option value="" data-brgy="San Dionisio"></option>
                                    <option value="" data-brgy="San Enrique"></option>
                                    <option value="" data-brgy="San Joaquin"></option>
                                    <option value="" data-brgy="San Miguel"></option>
                                    <option value="" data-brgy="San Rafael"></option>
                                    <option value="" data-brgy="Santa Barbara"></option>
                                    <option value="" data-brgy="Sara"></option>
                                    <option value="" data-brgy="Tigbauan"></option>
                                    <option value="" data-brgy="Tubungan"></option>
                                    <option value="" data-brgy="Zarraga"></option>
                                    <option value="" data-brgy="Alicia"></option>
                                    <option value="" data-brgy="Angadanan"></option>
                                    <option value="" data-brgy="Aurora"></option>
                                    <option value="" data-brgy="Benito Soliven"></option>
                                    <option value="" data-brgy="Burgos"></option>
                                    <option value="" data-brgy="Cabagan"></option>
                                    <option value="" data-brgy="Cabatuan"></option>
                                    <option value="" data-brgy="Cauayan"></option>
                                    <option value="" data-brgy="Cordon"></option>
                                    <option value="" data-brgy="Delfin Albano"></option>
                                    <option value="" data-brgy="Dinapigue"></option>
                                    <option value="" data-brgy="Divilacan"></option>
                                    <option value="" data-brgy="Echague"></option>
                                    <option value="" data-brgy="Gamu"></option>
                                    <option value="" data-brgy="Ilagan"></option>
                                    <option value="" data-brgy="Jones"></option>
                                    <option value="" data-brgy="Luna"></option>
                                    <option value="" data-brgy="Maconacon"></option>
                                    <option value="" data-brgy="Mallig"></option>
                                    <option value="" data-brgy="Naguilian"></option>
                                    <option value="" data-brgy="Palanan"></option>
                                    <option value="" data-brgy="Quezon"></option>
                                    <option value="" data-brgy="Quirino"></option>
                                    <option value="" data-brgy="Ramon"></option>
                                    <option value="" data-brgy="Reina Mercedes"></option>
                                    <option value="" data-brgy="Roxas"></option>
                                    <option value="" data-brgy="San Agustin"></option>
                                    <option value="" data-brgy="San Guillermo"></option>
                                    <option value="" data-brgy="San Isidro"></option>
                                    <option value="" data-brgy="San Manuel"></option>
                                    <option value="" data-brgy="San Mariano"></option>
                                    <option value="" data-brgy="San Mateo"></option>
                                    <option value="" data-brgy="San Pablo"></option>
                                    <option value="" data-brgy="Santa Maria"></option>
                                    <option value="" data-brgy="Santiago"></option>
                                    <option value="" data-brgy="Santo Tomas"></option>
                                    <option value="" data-brgy="Tumauini"></option>
                                    <option value="" data-brgy="Balbalan"></option>
                                    <option value="" data-brgy="Lubuagan"></option>
                                    <option value="" data-brgy="Pasil"></option>
                                    <option value="" data-brgy="Pinukpuk"></option>
                                    <option value="" data-brgy="Rizal"></option>
                                    <option value="" data-brgy="Tabuk"></option>
                                    <option value="" data-brgy="Tanudan"></option>
                                    <option value="" data-brgy="Tinglayan"></option>
                                    <option value="" data-brgy="Agoo"></option>
                                    <option value="" data-brgy="Aringay"></option>
                                    <option value="" data-brgy="Bacnotan"></option>
                                    <option value="" data-brgy="Bagulin"></option>
                                    <option value="" data-brgy="Balaoan"></option>
                                    <option value="" data-brgy="Bangar"></option>
                                    <option value="" data-brgy="Bauang"></option>
                                    <option value="" data-brgy="Burgos"></option>
                                    <option value="" data-brgy="Caba"></option>
                                    <option value="" data-brgy="Luna"></option>
                                    <option value="" data-brgy="Naguilian"></option>
                                    <option value="" data-brgy="Pugo"></option>
                                    <option value="" data-brgy="Rosario"></option>
                                    <option value="" data-brgy="San Fernando"></option>
                                    <option value="" data-brgy="San Gabriel"></option>
                                    <option value="" data-brgy="San Juan"></option>
                                    <option value="" data-brgy="Santo Tomas"></option>
                                    <option value="" data-brgy="Santol"></option>
                                    <option value="" data-brgy="Sudipen"></option>
                                    <option value="" data-brgy="Tubao"></option>
                                    <option value="" data-brgy="Alaminos"></option>
                                    <option value="" data-brgy="Bay"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Cabuyao"></option>
                                    <option value="" data-brgy="Calamba"></option>
                                    <option value="" data-brgy="Calauan"></option>
                                    <option value="" data-brgy="Cavinti"></option>
                                    <option value="" data-brgy="Famy"></option>
                                    <option value="" data-brgy="Kalayaan"></option>
                                    <option value="" data-brgy="Liliw"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Luisiana"></option>
                                    <option value="" data-brgy="Lumban"></option>
                                    <option value="" data-brgy="Mabitac"></option>
                                    <option value="" data-brgy="Magdalena"></option>
                                    <option value="" data-brgy="Majayjay"></option>
                                    <option value="" data-brgy="Nagcarlan"></option>
                                    <option value="" data-brgy="Paete"></option>
                                    <option value="" data-brgy="Pagsanjan"></option>
                                    <option value="" data-brgy="Pakil"></option>
                                    <option value="" data-brgy="Pangil"></option>
                                    <option value="" data-brgy="Pila"></option>
                                    <option value="" data-brgy="Rizal"></option>
                                    <option value="" data-brgy="San Pablo"></option>
                                    <option value="" data-brgy="San Pedro"></option>
                                    <option value="" data-brgy="Santa Cruz"></option>
                                    <option value="" data-brgy="Santa Maria"></option>
                                    <option value="" data-brgy="Santa Rosa"></option>
                                    <option value="" data-brgy="Siniloan"></option>
                                    <option value="" data-brgy="Victoria"></option>
                                    <option value="" data-brgy="Bacolod"></option>
                                    <option value="" data-brgy="Balo-i"></option>
                                    <option value="" data-brgy="Baroy"></option>
                                    <option value="" data-brgy="Iligan"></option>
                                    <option value="" data-brgy="Kapatagan"></option>
                                    <option value="" data-brgy="Kauswagan"></option>
                                    <option value="" data-brgy="Kolambugan"></option>
                                    <option value="" data-brgy="Lala"></option>
                                    <option value="" data-brgy="Linamon"></option>
                                    <option value="" data-brgy="Magsaysay"></option>
                                    <option value="" data-brgy="Maigo"></option>
                                    <option value="" data-brgy="Matungao"></option>
                                    <option value="" data-brgy="Munai"></option>
                                    <option value="" data-brgy="Nunungan"></option>
                                    <option value="" data-brgy="Pantao Ragat"></option>
                                    <option value="" data-brgy="Pantar"></option>
                                    <option value="" data-brgy="Poona Piagapo"></option>
                                    <option value="" data-brgy="Salvador"></option>
                                    <option value="" data-brgy="Sapad"></option>
                                    <option value="" data-brgy="Sultan Naga Dimaporo"></option>
                                    <option value="" data-brgy="Tagoloan"></option>
                                    <option value="" data-brgy="Tangcal"></option>
                                    <option value="" data-brgy="Tubod"></option>
                                    <option value="" data-brgy="Amai Manabilang"></option>
                                    <option value="" data-brgy="Bacolod-Kalawi"></option>
                                    <option value="" data-brgy="Balabagan"></option>
                                    <option value="" data-brgy="Balindong"></option>
                                    <option value="" data-brgy="Bayang"></option>
                                    <option value="" data-brgy="Binidayan"></option>
                                    <option value="" data-brgy="Buadiposo-Buntong"></option>
                                    <option value="" data-brgy="Bubong"></option>
                                    <option value="" data-brgy="Butig"></option>
                                    <option value="" data-brgy="Calanogas"></option>
                                    <option value="" data-brgy="Ditsaan-Ramain"></option>
                                    <option value="" data-brgy="Ganassi"></option>
                                    <option value="" data-brgy="Kapai"></option>
                                    <option value="" data-brgy="Kapatagan"></option>
                                    <option value="" data-brgy="Lumba-Bayabao"></option>
                                    <option value="" data-brgy="Lumbaca-Unayan"></option>
                                    <option value="" data-brgy="Lumbatan"></option>
                                    <option value="" data-brgy="Lumbayanague"></option>
                                    <option value="" data-brgy="Madalum"></option>
                                    <option value="" data-brgy="Madamba"></option>
                                    <option value="" data-brgy="Maguing"></option>
                                    <option value="" data-brgy="Malabang"></option>
                                    <option value="" data-brgy="Marantao"></option>
                                    <option value="" data-brgy="Marawi"></option>
                                    <option value="" data-brgy="Marogong"></option>
                                    <option value="" data-brgy="Masiu"></option>
                                    <option value="" data-brgy="Mulondo"></option>
                                    <option value="" data-brgy="Pagayawan"></option>
                                    <option value="" data-brgy="Piagapo"></option>
                                    <option value="" data-brgy="Picong"></option>
                                    <option value="" data-brgy="Poona Bayabao"></option>
                                    <option value="" data-brgy="Pualas"></option>
                                    <option value="" data-brgy="Saguiaran"></option>
                                    <option value="" data-brgy="Sultan Dumalondong"></option>
                                    <option value="" data-brgy="Tagoloan II"></option>
                                    <option value="" data-brgy="Tamparan"></option>
                                    <option value="" data-brgy="Taraka"></option>
                                    <option value="" data-brgy="Tubaran"></option>
                                    <option value="" data-brgy="Tugaya"></option>
                                    <option value="" data-brgy="Wao"></option>
                                    <option value="" data-brgy="Abuyog"></option>
                                    <option value="" data-brgy="Alangalang"></option>
                                    <option value="" data-brgy="Albuera"></option>
                                    <option value="" data-brgy="Babatngon"></option>
                                    <option value="" data-brgy="Barugo"></option>
                                    <option value="" data-brgy="Bato"></option>
                                    <option value="" data-brgy="Baybay"></option>
                                    <option value="" data-brgy="Burauen"></option>
                                    <option value="" data-brgy="Calubian"></option>
                                    <option value="" data-brgy="Capoocan"></option>
                                    <option value="" data-brgy="Carigara"></option>
                                    <option value="" data-brgy="Dagami"></option>
                                    <option value="" data-brgy="Dulag"></option>
                                    <option value="" data-brgy="Hilongos"></option>
                                    <option value="" data-brgy="Hindang"></option>
                                    <option value="" data-brgy="Inopacan"></option>
                                    <option value="" data-brgy="Isabel"></option>
                                    <option value="" data-brgy="Jaro"></option>
                                    <option value="" data-brgy="Javier"></option>
                                    <option value="" data-brgy="Julita"></option>
                                    <option value="" data-brgy="Kananga"></option>
                                    <option value="" data-brgy="La Paz"></option>
                                    <option value="" data-brgy="Leyte"></option>
                                    <option value="" data-brgy="MacArthur"></option>
                                    <option value="" data-brgy="Mahaplag"></option>
                                    <option value="" data-brgy="Matag-ob"></option>
                                    <option value="" data-brgy="Matalom"></option>
                                    <option value="" data-brgy="Mayorga"></option>
                                    <option value="" data-brgy="Merida"></option>
                                    <option value="" data-brgy="Ormoc"></option>
                                    <option value="" data-brgy="Palo"></option>
                                    <option value="" data-brgy="Palompon"></option>
                                    <option value="" data-brgy="Pastrana"></option>
                                    <option value="" data-brgy="San Isidro"></option>
                                    <option value="" data-brgy="San Miguel"></option>
                                    <option value="" data-brgy="Santa Fe"></option>
                                    <option value="" data-brgy="Tabango"></option>
                                    <option value="" data-brgy="Tabontabon"></option>
                                    <option value="" data-brgy="Tacloban"></option>
                                    <option value="" data-brgy="Tanauan"></option>
                                    <option value="" data-brgy="Tolosa"></option>
                                    <option value="" data-brgy="Tunga"></option>
                                    <option value="" data-brgy="Villaba"></option>
                                    <option value="" data-brgy="Ampatuan"></option>
                                    <option value="" data-brgy="Barira"></option>
                                    <option value="" data-brgy="Buldon"></option>
                                    <option value="" data-brgy="Buluan"></option>
                                    <option value="" data-brgy="Cotabato City"></option>
                                    <option value="" data-brgy="Datu Abdullah Sangki"></option>
                                    <option value="" data-brgy="Datu Anggal Midtimbang"></option>
                                    <option value="" data-brgy="Datu Blah T. Sinsuat"></option>
                                    <option value="" data-brgy="Datu Hoffer Ampatuan"></option>
                                    <option value="" data-brgy="Datu Montawal"></option>
                                    <option value="" data-brgy="Datu Odin Sinsuat"></option>
                                    <option value="" data-brgy="Datu Paglas"></option>
                                    <option value="" data-brgy="Datu Piang"></option>
                                    <option value="" data-brgy="Datu Salibo"></option>
                                    <option value="" data-brgy="Datu Saudi-Ampatuan"></option>
                                    <option value="" data-brgy="Datu Unsay"></option>
                                    <option value="" data-brgy="General Salipada K. Pendatun"></option>
                                    <option value="" data-brgy="Guindulungan"></option>
                                    <option value="" data-brgy="Kabuntalan"></option>
                                    <option value="" data-brgy="Mamasapano"></option>
                                    <option value="" data-brgy="Mangudadatu"></option>
                                    <option value="" data-brgy="Matanog"></option>
                                    <option value="" data-brgy="Northern Kabuntalan"></option>
                                    <option value="" data-brgy="Pagalungan"></option>
                                    <option value="" data-brgy="Paglat"></option>
                                    <option value="" data-brgy="Pandag"></option>
                                    <option value="" data-brgy="Parang"></option>
                                    <option value="" data-brgy="Rajah Buayan"></option>
                                    <option value="" data-brgy="Shariff Aguak"></option>
                                    <option value="" data-brgy="Shariff Saydona Mustapha"></option>
                                    <option value="" data-brgy="South Upi"></option>
                                    <option value="" data-brgy="Sultan Kudarat"></option>
                                    <option value="" data-brgy="Sultan Mastura"></option>
                                    <option value="" data-brgy="Sultan Sumagka"></option>
                                    <option value="" data-brgy="Sultan sa Barongis"></option>
                                    <option value="" data-brgy="Talayan"></option>
                                    <option value="" data-brgy="Upi"></option>
                                    <option value="" data-brgy="Boac"></option>
                                    <option value="" data-brgy="Buenavista"></option>
                                    <option value="" data-brgy="Gasan"></option>
                                    <option value="" data-brgy="Mogpog"></option>
                                    <option value="" data-brgy="Santa Cruz"></option>
                                    <option value="" data-brgy="Torrijos"></option>
                                    <option value="" data-brgy="Aroroy"></option>
                                    <option value="" data-brgy="Baleno"></option>
                                    <option value="" data-brgy="Balud"></option>
                                    <option value="" data-brgy="Batuan"></option>
                                    <option value="" data-brgy="Cataingan"></option>
                                    <option value="" data-brgy="Cawayan"></option>
                                    <option value="" data-brgy="Claveria"></option>
                                    <option value="" data-brgy="Dimasalang"></option>
                                    <option value="" data-brgy="Esperanza"></option>
                                    <option value="" data-brgy="Mandaon"></option>
                                    <option value="" data-brgy="Masbate City"></option>
                                    <option value="" data-brgy="Milagros"></option>
                                    <option value="" data-brgy="Mobo"></option>
                                    <option value="" data-brgy="Monreal"></option>
                                    <option value="" data-brgy="Palanas"></option>
                                    <option value="" data-brgy="Pio V. Corpuz"></option>
                                    <option value="" data-brgy="Placer"></option>
                                    <option value="" data-brgy="San Fernando"></option>
                                    <option value="" data-brgy="San Jacinto"></option>
                                    <option value="" data-brgy="San Pascual"></option>
                                    <option value="" data-brgy="Uson"></option>
                                    <option value="" data-brgy="Caloocan"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Makati"></option>
                                    <option value="" data-brgy="Malabon"></option>
                                    <option value="" data-brgy="Mandaluyong"></option>
                                    <option value="" data-brgy="Manila"></option>
                                    <option value="" data-brgy="Marikina"></option>
                                    <option value="" data-brgy="Muntinlupa"></option>
                                    <option value="" data-brgy="Navotas"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Pasay"></option>
                                    <option value="" data-brgy="Pasig"></option>
                                    <option value="" data-brgy="Pateros"></option>
                                    <option value="" data-brgy="Quezon City"></option>
                                    <option value="" data-brgy="San Juan"></option>
                                    <option value="" data-brgy="Taguig"></option>
                                    <option value="" data-brgy="Valenzuela"></option>
                                    <option value="" data-brgy="Aloran"></option>
                                    <option value="" data-brgy="Baliangao"></option>
                                    <option value="" data-brgy="Bonifacio"></option>
                                    <option value="" data-brgy="Calamba"></option>
                                    <option value="" data-brgy="Clarin"></option>
                                    <option value="" data-brgy="Concepcion"></option>
                                    <option value="" data-brgy="Don Victoriano Chiongbian"></option>
                                    <option value="" data-brgy="Jimenez"></option>
                                    <option value="" data-brgy="Lopez Jaena"></option>
                                    <option value="" data-brgy="Oroquieta"></option>
                                    <option value="" data-brgy="Ozamiz"></option>
                                    <option value="" data-brgy="Panaon"></option>
                                    <option value="" data-brgy="Plaridel"></option>
                                    <option value="" data-brgy="Sapang Dalaga"></option>
                                    <option value="" data-brgy="Sinacaban"></option>
                                    <option value="" data-brgy="Tangub"></option>
                                    <option value="" data-brgy="Tudela"></option>
                                    <option value="" data-brgy="Alubijid"></option>
                                    <option value="" data-brgy="Balingasag"></option>
                                    <option value="" data-brgy="Balingoan"></option>
                                    <option value="" data-brgy="Binuangan"></option>
                                    <option value="" data-brgy="Cagayan de Oro"></option>
                                    <option value="" data-brgy="Claveria"></option>
                                    <option value="" data-brgy="El Salvador"></option>
                                    <option value="" data-brgy="Gingoog"></option>
                                    <option value="" data-brgy="Gitagum"></option>
                                    <option value="" data-brgy="Initao"></option>
                                    <option value="" data-brgy="Jasaan"></option>
                                    <option value="" data-brgy="Kinoguitan"></option>
                                    <option value="" data-brgy="Lagonglong"></option>
                                    <option value="" data-brgy="Laguindingan"></option>
                                    <option value="" data-brgy="Libertad"></option>
                                    <option value="" data-brgy="Lugait"></option>
                                    <option value="" data-brgy="Magsaysay"></option>
                                    <option value="" data-brgy="Manticao"></option>
                                    <option value="" data-brgy="Medina"></option>
                                    <option value="" data-brgy="Naawan"></option>
                                    <option value="" data-brgy="Opol"></option>
                                    <option value="" data-brgy="Salay"></option>
                                    <option value="" data-brgy="Sugbongcogon"></option>
                                    <option value="" data-brgy="Tagoloan"></option>
                                    <option value="" data-brgy="Talisayan"></option>
                                    <option value="" data-brgy="Villanueva"></option>
                                    <option value="" data-brgy="Barlig"></option>
                                    <option value="" data-brgy="Bauko"></option>
                                    <option value="" data-brgy="Besao"></option>
                                    <option value="" data-brgy="Bontoc"></option>
                                    <option value="" data-brgy="Natonin"></option>
                                    <option value="" data-brgy="Paracelis"></option>
                                    <option value="" data-brgy="Sabangan"></option>
                                    <option value="" data-brgy="Sadanga"></option>
                                    <option value="" data-brgy="Sagada"></option>
                                    <option value="" data-brgy="Tadian"></option>
                                    <option value="" data-brgy="Bacolod"></option>
                                    <option value="" data-brgy="Bago"></option>
                                    <option value="" data-brgy="Binalbagan"></option>
                                    <option value="" data-brgy="Cadiz"></option>
                                    <option value="" data-brgy="Calatrava"></option>
                                    <option value="" data-brgy="Candoni"></option>
                                    <option value="" data-brgy="Cauayan"></option>
                                    <option value="" data-brgy="Enrique B. Magalona"></option>
                                    <option value="" data-brgy="Escalante"></option>
                                    <option value="" data-brgy="Himamaylan"></option>
                                    <option value="" data-brgy="Hinigaran"></option>
                                    <option value="" data-brgy="Hinoba-an"></option>
                                    <option value="" data-brgy="Ilog"></option>
                                    <option value="" data-brgy="Isabela"></option>
                                    <option value="" data-brgy="Kabankalan"></option>
                                    <option value="" data-brgy="La Carlota"></option>
                                    <option value="" data-brgy="La Castellana"></option>
                                    <option value="" data-brgy="Manapla"></option>
                                    <option value="" data-brgy="Moises Padilla"></option>
                                    <option value="" data-brgy="Murcia"></option>
                                    <option value="" data-brgy="Pontevedra"></option>
                                    <option value="" data-brgy="Pulupandan"></option>
                                    <option value="" data-brgy="Sagay"></option>
                                    <option value="" data-brgy="Salvador Benedicto"></option>
                                    <option value="" data-brgy="San Carlos"></option>
                                    <option value="" data-brgy="San Enrique"></option>
                                    <option value="" data-brgy="Silay"></option>
                                    <option value="" data-brgy="Sipalay"></option>
                                    <option value="" data-brgy="Talisay"></option>
                                    <option value="" data-brgy="Toboso"></option>
                                    <option value="" data-brgy="Valladolid"></option>
                                    <option value="" data-brgy="Victorias"></option>
                                    <option value="" data-brgy="Amlan"></option>
                                    <option value="" data-brgy="Ayungon"></option>
                                    <option value="" data-brgy="Bacong"></option>
                                    <option value="" data-brgy="Bais"></option>
                                    <option value="" data-brgy="Basay"></option>
                                    <option value="" data-brgy="Bayawan"></option>
                                    <option value="" data-brgy="Bindoy"></option>
                                    <option value="" data-brgy="Canlaon"></option>
                                    <option value="" data-brgy="Dauin"></option>
                                    <option value="" data-brgy="Dumaguete"></option>
                                    <option value="" data-brgy="Guihulngan"></option>
                                    <option value="" data-brgy="Jimalalud"></option>
                                    <option value="" data-brgy="La Libertad"></option>
                                    <option value="" data-brgy="Mabinay"></option>
                                    <option value="" data-brgy="Manjuyod"></option>
                                    <option value="" data-brgy="Pamplona"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="Santa Catalina"></option>
                                    <option value="" data-brgy="Siaton"></option>
                                    <option value="" data-brgy="Sibulan"></option>
                                    <option value="" data-brgy="Tanjay"></option>
                                    <option value="" data-brgy="Tayasan"></option>
                                    <option value="" data-brgy="Valencia"></option>
                                    <option value="" data-brgy="Vallehermoso"></option>
                                    <option value="" data-brgy="Zamboanguita"></option>
                                    <option value="" data-brgy="Allen"></option>
                                    <option value="" data-brgy="Biri"></option>
                                    <option value="" data-brgy="Bobon"></option>
                                    <option value="" data-brgy="Capul"></option>
                                    <option value="" data-brgy="Catarman"></option>
                                    <option value="" data-brgy="Catubig"></option>
                                    <option value="" data-brgy="Gamay"></option>
                                    <option value="" data-brgy="Laoang"></option>
                                    <option value="" data-brgy="Lapinig"></option>
                                    <option value="" data-brgy="Las Navas"></option>
                                    <option value="" data-brgy="Lavezares"></option>
                                    <option value="" data-brgy="Lope de Vega"></option>
                                    <option value="" data-brgy="Mapanas"></option>
                                    <option value="" data-brgy="Mondragon"></option>
                                    <option value="" data-brgy="Palapag"></option>
                                    <option value="" data-brgy="Pambujan"></option>
                                    <option value="" data-brgy="Rosario"></option>
                                    <option value="" data-brgy="San Antonio"></option>
                                    <option value="" data-brgy="San Isidro"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="San Roque"></option>
                                    <option value="" data-brgy="San Vicente"></option>
                                    <option value="" data-brgy="Silvino Lobos"></option>
                                    <option value="" data-brgy="Victoria"></option>
                                    <option value="" data-brgy="Aliaga"></option>
                                    <option value="" data-brgy="Bongabon"></option>
                                    <option value="" data-brgy="Cabanatuan"></option>
                                    <option value="" data-brgy="Cabiao"></option>
                                    <option value="" data-brgy="Carranglan"></option>
                                    <option value="" data-brgy="Cuyapo"></option>
                                    <option value="" data-brgy="Gabaldon"></option>
                                    <option value="" data-brgy="Gapan"></option>
                                    <option value="" data-brgy="General Mamerto Natividad"></option>
                                    <option value="" data-brgy="General Tinio"></option>
                                    <option value="" data-brgy="Guimba"></option>
                                    <option value="" data-brgy="Jaen"></option>
                                    <option value="" data-brgy="Laur"></option>
                                    <option value="" data-brgy="Licab"></option>
                                    <option value="" data-brgy="Llanera"></option>
                                    <option value="" data-brgy="Lupao"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Nampicuan"></option>
                                    <option value="" data-brgy="Palayan"></option>
                                    <option value="" data-brgy="Pantabangan"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Quezon"></option>
                                    <option value="" data-brgy="Rizal"></option>
                                    <option value="" data-brgy="San Antonio"></option>
                                    <option value="" data-brgy="San Isidro"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="San Leonardo"></option>
                                    <option value="" data-brgy="Santa Rosa"></option>
                                    <option value="" data-brgy="Santo Domingo"></option>
                                    <option value="" data-brgy="Talavera"></option>
                                    <option value="" data-brgy="Talugtug"></option>
                                    <option value="" data-brgy="Zaragoza"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Ambaguio"></option>
                                    <option value="" data-brgy="Aritao"></option>
                                    <option value="" data-brgy="Bagabag"></option>
                                    <option value="" data-brgy="Bambang"></option>
                                    <option value="" data-brgy="Bayombong"></option>
                                    <option value="" data-brgy="Diadi"></option>
                                    <option value="" data-brgy="Dupax del Norte"></option>
                                    <option value="" data-brgy="Dupax del Sur"></option>
                                    <option value="" data-brgy="Kasibu"></option>
                                    <option value="" data-brgy="Kayapa"></option>
                                    <option value="" data-brgy="Quezon"></option>
                                    <option value="" data-brgy="Santa Fe"></option>
                                    <option value="" data-brgy="Solano"></option>
                                    <option value="" data-brgy="Villaverde"></option>
                                    <option value="" data-brgy="Abra de Ilog"></option>
                                    <option value="" data-brgy="Calintaan"></option>
                                    <option value="" data-brgy="Looc"></option>
                                    <option value="" data-brgy="Lubang"></option>
                                    <option value="" data-brgy="Magsaysay"></option>
                                    <option value="" data-brgy="Mamburao"></option>
                                    <option value="" data-brgy="Paluan"></option>
                                    <option value="" data-brgy="Rizal"></option>
                                    <option value="" data-brgy="Sablayan"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="Santa Cruz"></option>
                                    <option value="" data-brgy="Baco"></option>
                                    <option value="" data-brgy="Bansud"></option>
                                    <option value="" data-brgy="Bongabong"></option>
                                    <option value="" data-brgy="Bulalacao"></option>
                                    <option value="" data-brgy="Calapan"></option>
                                    <option value="" data-brgy="Gloria"></option>
                                    <option value="" data-brgy="Mansalay"></option>
                                    <option value="" data-brgy="Naujan"></option>
                                    <option value="" data-brgy="Pinamalayan"></option>
                                    <option value="" data-brgy="Pola"></option>
                                    <option value="" data-brgy="Puerto Galera"></option>
                                    <option value="" data-brgy="Roxas"></option>
                                    <option value="" data-brgy="San Teodoro"></option>
                                    <option value="" data-brgy="Socorro"></option>
                                    <option value="" data-brgy="Victoria"></option>
                                    <option value="" data-brgy="Aborlan"></option>
                                    <option value="" data-brgy="Agutaya"></option>
                                    <option value="" data-brgy="Araceli"></option>
                                    <option value="" data-brgy="Balabac"></option>
                                    <option value="" data-brgy="Bataraza"></option>
                                    <option value="" data-brgy="Brooke's Point"></option>
                                    <option value="" data-brgy="Busuanga"></option>
                                    <option value="" data-brgy="Cagayancillo"></option>
                                    <option value="" data-brgy="Coron"></option>
                                    <option value="" data-brgy="Culion"></option>
                                    <option value="" data-brgy="Cuyo"></option>
                                    <option value="" data-brgy="Dumaran"></option>
                                    <option value="" data-brgy="El Nido"></option>
                                    <option value="" data-brgy="Kalayaan"></option>
                                    <option value="" data-brgy="Linapacan"></option>
                                    <option value="" data-brgy="Magsaysay"></option>
                                    <option value="" data-brgy="Narra"></option>
                                    <option value="" data-brgy="Puerto Princesa"></option>
                                    <option value="" data-brgy="Quezon"></option>
                                    <option value="" data-brgy="Rizal"></option>
                                    <option value="" data-brgy="Roxas, Palawan"></option>
                                    <option value="" data-brgy="San Vicente"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Taytay"></option>
                                    <option value="" data-brgy="Angeles"></option>
                                    <option value="" data-brgy="Apalit"></option>
                                    <option value="" data-brgy="Arayat"></option>
                                    <option value="" data-brgy="Bacolor"></option>
                                    <option value="" data-brgy="Candaba"></option>
                                    <option value="" data-brgy="Floridablanca"></option>
                                    <option value="" data-brgy="Guagua"></option>
                                    <option value="" data-brgy="Lubao"></option>
                                    <option value="" data-brgy="Mabalacat"></option>
                                    <option value="" data-brgy="Macabebe"></option>
                                    <option value="" data-brgy="Magalang"></option>
                                    <option value="" data-brgy="Masantol"></option>
                                    <option value="" data-brgy="Mexico"></option>
                                    <option value="" data-brgy="Minalin"></option>
                                    <option value="" data-brgy="Porac"></option>
                                    <option value="" data-brgy="San Fernando"></option>
                                    <option value="" data-brgy="San Luis"></option>
                                    <option value="" data-brgy="San Simon"></option>
                                    <option value="" data-brgy="Santa Ana"></option>
                                    <option value="" data-brgy="Santa Rita"></option>
                                    <option value="" data-brgy="Santo Tomas"></option>
                                    <option value="" data-brgy="Sasmuan"></option>
                                    <option value="" data-brgy="Agno"></option>
                                    <option value="" data-brgy="Aguilar"></option>
                                    <option value="" data-brgy="Alaminos"></option>
                                    <option value="" data-brgy="Alcala"></option>
                                    <option value="" data-brgy="Anda"></option>
                                    <option value="" data-brgy="Asingan"></option>
                                    <option value="" data-brgy="Balungao"></option>
                                    <option value="" data-brgy="Bani"></option>
                                    <option value="" data-brgy="Basista"></option>
                                    <option value="" data-brgy="Bautista"></option>
                                    <option value="" data-brgy="Bayambang"></option>
                                    <option value="" data-brgy="Binalonan"></option>
                                    <option value="" data-brgy="Binmaley"></option>
                                    <option value="" data-brgy="Bolinao"></option>
                                    <option value="" data-brgy="Bugallon"></option>
                                    <option value="" data-brgy="Burgos"></option>
                                    <option value="" data-brgy="Calasiao"></option>
                                    <option value="" data-brgy="Dagupan"></option>
                                    <option value="" data-brgy="Dasol"></option>
                                    <option value="" data-brgy="Infanta"></option>
                                    <option value="" data-brgy="Labrador"></option>
                                    <option value="" data-brgy="Laoac"></option>
                                    <option value="" data-brgy="Lingayen"></option>
                                    <option value="" data-brgy="Mabini"></option>
                                    <option value="" data-brgy="Malasiqui"></option>
                                    <option value="" data-brgy="Manaoag"></option>
                                    <option value="" data-brgy="Mangaldan"></option>
                                    <option value="" data-brgy="Mangatarem"></option>
                                    <option value="" data-brgy="Mapandan"></option>
                                    <option value="" data-brgy="Natividad"></option>
                                    <option value="" data-brgy="Pozorrubio"></option>
                                    <option value="" data-brgy="Rosales"></option>
                                    <option value="" data-brgy="San Carlos"></option>
                                    <option value="" data-brgy="San Fabian"></option>
                                    <option value="" data-brgy="San Jacinto"></option>
                                    <option value="" data-brgy="San Manuel"></option>
                                    <option value="" data-brgy="San Nicolas"></option>
                                    <option value="" data-brgy="San Quintin"></option>
                                    <option value="" data-brgy="Santa Barbara"></option>
                                    <option value="" data-brgy="Santa Maria"></option>
                                    <option value="" data-brgy="Santo Tomas"></option>
                                    <option value="" data-brgy="Sison"></option>
                                    <option value="" data-brgy="Sual"></option>
                                    <option value="" data-brgy="Tayug"></option>
                                    <option value="" data-brgy="Umingan"></option>
                                    <option value="" data-brgy="Urbiztondo"></option>
                                    <option value="" data-brgy="Urdaneta"></option>
                                    <option value="" data-brgy="Villasis"></option>
                                    <option value="" data-brgy="Agdangan"></option>
                                    <option value="" data-brgy="Alabat"></option>
                                    <option value="" data-brgy="Atimonan"></option>
                                    <option value="" data-brgy="Buenavista"></option>
                                    <option value="" data-brgy="Burdeos"></option>
                                    <option value="" data-brgy="Calauag"></option>
                                    <option value="" data-brgy="Candelaria"></option>
                                    <option value="" data-brgy="Catanauan"></option>
                                    <option value="" data-brgy="Dolores"></option>
                                    <option value="" data-brgy="General Luna"></option>
                                    <option value="" data-brgy="General Nakar"></option>
                                    <option value="" data-brgy="Guinayangan"></option>
                                    <option value="" data-brgy="Gumaca"></option>
                                    <option value="" data-brgy="Infanta"></option>
                                    <option value="" data-brgy="Jomalig"></option>
                                    <option value="" data-brgy="Lopez"></option>
                                    <option value="" data-brgy="Lucban"></option>
                                    <option value="" data-brgy="Lucena"></option>
                                    <option value="" data-brgy="Macalelon"></option>
                                    <option value="" data-brgy="Mauban"></option>
                                    <option value="" data-brgy="Mulanay"></option>
                                    <option value="" data-brgy="Padre Burgos"></option>
                                    <option value="" data-brgy="Pagbilao"></option>
                                    <option value="" data-brgy="Panukulan"></option>
                                    <option value="" data-brgy="Patnanungan"></option>
                                    <option value="" data-brgy="Perez"></option>
                                    <option value="" data-brgy="Pitogo"></option>
                                    <option value="" data-brgy="Plaridel"></option>
                                    <option value="" data-brgy="Polillo"></option>
                                    <option value="" data-brgy="Quezon"></option>
                                    <option value="" data-brgy="Real"></option>
                                    <option value="" data-brgy="Sampaloc"></option>
                                    <option value="" data-brgy="San Andres"></option>
                                    <option value="" data-brgy="San Antonio"></option>
                                    <option value="" data-brgy="San Francisco"></option>
                                    <option value="" data-brgy="San Narciso"></option>
                                    <option value="" data-brgy="Sariaya"></option>
                                    <option value="" data-brgy="Tagkawayan"></option>
                                    <option value="" data-brgy="Tayabas"></option>
                                    <option value="" data-brgy="Tiaong"></option>
                                    <option value="" data-brgy="Unisan"></option>
                                    <option value="" data-brgy="Aglipay"></option>
                                    <option value="" data-brgy="Cabarroguis"></option>
                                    <option value="" data-brgy="Diffun"></option>
                                    <option value="" data-brgy="Maddela"></option>
                                    <option value="" data-brgy="Nagtipunan"></option>
                                    <option value="" data-brgy="Saguday"></option>
                                    <option value="" data-brgy="Angono"></option>
                                    <option value="" data-brgy="Antipolo"></option>
                                    <option value="" data-brgy="Baras"></option>
                                    <option value="" data-brgy="Binangonan"></option>
                                    <option value="" data-brgy="Cainta"></option>
                                    <option value="" data-brgy="Cardona"></option>
                                    <option value="" data-brgy="Jalajala"></option>
                                    <option value="" data-brgy="Morong"></option>
                                    <option value="" data-brgy="Pililla"></option>
                                    <option value="" data-brgy="Rodriguez"></option>
                                    <option value="" data-brgy="San Mateo"></option>
                                    <option value="" data-brgy="Tanay"></option>
                                    <option value="" data-brgy="Taytay"></option>
                                    <option value="" data-brgy="Teresa"></option>
                                    <option value="" data-brgy="Alcantara"></option>
                                    <option value="" data-brgy="Banton"></option>
                                    <option value="" data-brgy="Cajidiocan"></option>
                                    <option value="" data-brgy="Calatrava"></option>
                                    <option value="" data-brgy="Concepcion"></option>
                                    <option value="" data-brgy="Corcuera"></option>
                                    <option value="" data-brgy="Ferrol"></option>
                                    <option value="" data-brgy="Looc"></option>
                                    <option value="" data-brgy="Magdiwang"></option>
                                    <option value="" data-brgy="Odiongan"></option>
                                    <option value="" data-brgy="Romblon"></option>
                                    <option value="" data-brgy="San Agustin"></option>
                                    <option value="" data-brgy="San Andres"></option>
                                    <option value="" data-brgy="San Fernando"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="Santa Fe"></option>
                                    <option value="" data-brgy="Santa Maria"></option>
                                    <option value="" data-brgy="Almagro"></option>
                                    <option value="" data-brgy="Basey"></option>
                                    <option value="" data-brgy="Calbayog"></option>
                                    <option value="" data-brgy="Calbiga"></option>
                                    <option value="" data-brgy="Catbalogan"></option>
                                    <option value="" data-brgy="Daram"></option>
                                    <option value="" data-brgy="Gandara"></option>
                                    <option value="" data-brgy="Hinabangan"></option>
                                    <option value="" data-brgy="Jiabong"></option>
                                    <option value="" data-brgy="Marabut"></option>
                                    <option value="" data-brgy="Matuguinao"></option>
                                    <option value="" data-brgy="Motiong"></option>
                                    <option value="" data-brgy="Pagsanghan"></option>
                                    <option value="" data-brgy="Paranas"></option>
                                    <option value="" data-brgy="Pinabacdao"></option>
                                    <option value="" data-brgy="San Jorge"></option>
                                    <option value="" data-brgy="San Jose de Buan"></option>
                                    <option value="" data-brgy="San Sebastian"></option>
                                    <option value="" data-brgy="Santa Margarita"></option>
                                    <option value="" data-brgy="Santa Rita"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Tagapul-an"></option>
                                    <option value="" data-brgy="Talalora"></option>
                                    <option value="" data-brgy="Tarangnan"></option>
                                    <option value="" data-brgy="Villareal"></option>
                                    <option value="" data-brgy="Zumarraga"></option>
                                    <option value="" data-brgy="Alabel"></option>
                                    <option value="" data-brgy="Glan"></option>
                                    <option value="" data-brgy="Kiamba"></option>
                                    <option value="" data-brgy="Maasim"></option>
                                    <option value="" data-brgy="Maitum"></option>
                                    <option value="" data-brgy="Malapatan"></option>
                                    <option value="" data-brgy="Malungon"></option>
                                    <option value="" data-brgy="Enrique Villanueva"></option>
                                    <option value="" data-brgy="Larena"></option>
                                    <option value="" data-brgy="Lazi"></option>
                                    <option value="" data-brgy="Maria"></option>
                                    <option value="" data-brgy="San Juan"></option>
                                    <option value="" data-brgy="Siquijor"></option>
                                    <option value="" data-brgy="Barcelona"></option>
                                    <option value="" data-brgy="Bulan"></option>
                                    <option value="" data-brgy="Bulusan"></option>
                                    <option value="" data-brgy="Casiguran"></option>
                                    <option value="" data-brgy="Castilla"></option>
                                    <option value="" data-brgy="Donsol"></option>
                                    <option value="" data-brgy="Gubat"></option>
                                    <option value="" data-brgy="Irosin"></option>
                                    <option value="" data-brgy="Juban"></option>
                                    <option value="" data-brgy="Magallanes"></option>
                                    <option value="" data-brgy="Matnog"></option>
                                    <option value="" data-brgy="Pilar"></option>
                                    <option value="" data-brgy="Prieto Diaz"></option>
                                    <option value="" data-brgy="Santa Magdalena"></option>
                                    <option value="" data-brgy="Sorsogon City"></option>
                                    <option value="" data-brgy="Banga"></option>
                                    <option value="" data-brgy="General Santos"></option>
                                    <option value="" data-brgy="Koronadal"></option>
                                    <option value="" data-brgy="Lake Sebu"></option>
                                    <option value="" data-brgy="Norala"></option>
                                    <option value="" data-brgy="Polomolok"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Surallah"></option>
                                    <option value="" data-brgy="T'Boli"></option>
                                    <option value="" data-brgy="Tampakan"></option>
                                    <option value="" data-brgy="Tantangan"></option>
                                    <option value="" data-brgy="Tupi"></option>
                                    <option value="" data-brgy="Anahawan"></option>
                                    <option value="" data-brgy="Bontoc"></option>
                                    <option value="" data-brgy="Hinunangan"></option>
                                    <option value="" data-brgy="Hinundayan"></option>
                                    <option value="" data-brgy="Libagon"></option>
                                    <option value="" data-brgy="Liloan"></option>
                                    <option value="" data-brgy="Limasawa"></option>
                                    <option value="" data-brgy="Maasin"></option>
                                    <option value="" data-brgy="Macrohon"></option>
                                    <option value="" data-brgy="Malitbog"></option>
                                    <option value="" data-brgy="Padre Burgos"></option>
                                    <option value="" data-brgy="Pintuyan"></option>
                                    <option value="" data-brgy="Saint Bernard"></option>
                                    <option value="" data-brgy="San Francisco"></option>
                                    <option value="" data-brgy="San Juan"></option>
                                    <option value="" data-brgy="San Ricardo"></option>
                                    <option value="" data-brgy="Silago"></option>
                                    <option value="" data-brgy="Sogod"></option>
                                    <option value="" data-brgy="Tomas Oppus"></option>
                                    <option value="" data-brgy="Bagumbayan"></option>
                                    <option value="" data-brgy="Columbio"></option>
                                    <option value="" data-brgy="Esperanza"></option>
                                    <option value="" data-brgy="Isulan"></option>
                                    <option value="" data-brgy="Kalamansig"></option>
                                    <option value="" data-brgy="Lambayong"></option>
                                    <option value="" data-brgy="Lebak"></option>
                                    <option value="" data-brgy="Lutayan"></option>
                                    <option value="" data-brgy="Palimbang"></option>
                                    <option value="" data-brgy="President Quirino"></option>
                                    <option value="" data-brgy="Senator Ninoy Aquino"></option>
                                    <option value="" data-brgy="Tacurong"></option>
                                    <option value="" data-brgy="Banguingui"></option>
                                    <option value="" data-brgy="Hadji Panglima Tahil"></option>
                                    <option value="" data-brgy="Indanan"></option>
                                    <option value="" data-brgy="Jolo"></option>
                                    <option value="" data-brgy="Kalingalan Caluang"></option>
                                    <option value="" data-brgy="Lugus"></option>
                                    <option value="" data-brgy="Luuk"></option>
                                    <option value="" data-brgy="Maimbung"></option>
                                    <option value="" data-brgy="Omar"></option>
                                    <option value="" data-brgy="Panamao"></option>
                                    <option value="" data-brgy="Pandami"></option>
                                    <option value="" data-brgy="Panglima Estino"></option>
                                    <option value="" data-brgy="Pangutaran"></option>
                                    <option value="" data-brgy="Parang"></option>
                                    <option value="" data-brgy="Pata"></option>
                                    <option value="" data-brgy="Patikul"></option>
                                    <option value="" data-brgy="Siasi"></option>
                                    <option value="" data-brgy="Talipao"></option>
                                    <option value="" data-brgy="Tapul"></option>
                                    <option value="" data-brgy="Alegria"></option>
                                    <option value="" data-brgy="Bacuag"></option>
                                    <option value="" data-brgy="Burgos"></option>
                                    <option value="" data-brgy="Claver"></option>
                                    <option value="" data-brgy="Dapa"></option>
                                    <option value="" data-brgy="Del Carmen"></option>
                                    <option value="" data-brgy="General Luna"></option>
                                    <option value="" data-brgy="Gigaquit"></option>
                                    <option value="" data-brgy="Mainit"></option>
                                    <option value="" data-brgy="Malimono"></option>
                                    <option value="" data-brgy="Pilar"></option>
                                    <option value="" data-brgy="Placer"></option>
                                    <option value="" data-brgy="San Benito"></option>
                                    <option value="" data-brgy="San Francisco"></option>
                                    <option value="" data-brgy="San Isidro"></option>
                                    <option value="" data-brgy="Santa Monica"></option>
                                    <option value="" data-brgy="Sison"></option>
                                    <option value="" data-brgy="Socorro"></option>
                                    <option value="" data-brgy="Surigao City"></option>
                                    <option value="" data-brgy="Tagana-an"></option>
                                    <option value="" data-brgy="Tubod"></option>
                                    <option value="" data-brgy="Barobo"></option>
                                    <option value="" data-brgy="Bayabas"></option>
                                    <option value="" data-brgy="Bislig"></option>
                                    <option value="" data-brgy="Cagwait"></option>
                                    <option value="" data-brgy="Cantilan"></option>
                                    <option value="" data-brgy="Carmen"></option>
                                    <option value="" data-brgy="Carrascal"></option>
                                    <option value="" data-brgy="Cortes"></option>
                                    <option value="" data-brgy="Hinatuan"></option>
                                    <option value="" data-brgy="Lanuza"></option>
                                    <option value="" data-brgy="Lianga"></option>
                                    <option value="" data-brgy="Lingig"></option>
                                    <option value="" data-brgy="Madrid"></option>
                                    <option value="" data-brgy="Marihatag"></option>
                                    <option value="" data-brgy="San Agustin"></option>
                                    <option value="" data-brgy="San Miguel"></option>
                                    <option value="" data-brgy="Tagbina"></option>
                                    <option value="" data-brgy="Tago"></option>
                                    <option value="" data-brgy="Tandag"></option>
                                    <option value="" data-brgy="Anao"></option>
                                    <option value="" data-brgy="Bamban"></option>
                                    <option value="" data-brgy="Camiling"></option>
                                    <option value="" data-brgy="Capas"></option>
                                    <option value="" data-brgy="Concepcion"></option>
                                    <option value="" data-brgy="Gerona"></option>
                                    <option value="" data-brgy="La Paz"></option>
                                    <option value="" data-brgy="Mayantoc"></option>
                                    <option value="" data-brgy="Moncada"></option>
                                    <option value="" data-brgy="Paniqui"></option>
                                    <option value="" data-brgy="Pura"></option>
                                    <option value="" data-brgy="Ramos"></option>
                                    <option value="" data-brgy="San Clemente"></option>
                                    <option value="" data-brgy="San Jose"></option>
                                    <option value="" data-brgy="San Manuel"></option>
                                    <option value="" data-brgy="Santa Ignacia"></option>
                                    <option value="" data-brgy="Tarlac City"></option>
                                    <option value="" data-brgy="Victoria"></option>
                                    <option value="" data-brgy="Bongao"></option>
                                    <option value="" data-brgy="Languyan"></option>
                                    <option value="" data-brgy="Mapun"></option>
                                    <option value="" data-brgy="Panglima Sugala"></option>
                                    <option value="" data-brgy="Sapa-Sapa"></option>
                                    <option value="" data-brgy="Sibutu"></option>
                                    <option value="" data-brgy="Simunul"></option>
                                    <option value="" data-brgy="Sitangkai"></option>
                                    <option value="" data-brgy="South Ubian"></option>
                                    <option value="" data-brgy="Tandubas"></option>
                                    <option value="" data-brgy="Turtle Islands"></option>
                                    <option value="" data-brgy="Botolan"></option>
                                    <option value="" data-brgy="Cabangan"></option>
                                    <option value="" data-brgy="Candelaria"></option>
                                    <option value="" data-brgy="Castillejos"></option>
                                    <option value="" data-brgy="Iba"></option>
                                    <option value="" data-brgy="Masinloc"></option>
                                    <option value="" data-brgy="Olongapo"></option>
                                    <option value="" data-brgy="Palauig"></option>
                                    <option value="" data-brgy="San Antonio"></option>
                                    <option value="" data-brgy="San Felipe"></option>
                                    <option value="" data-brgy="San Marcelino"></option>
                                    <option value="" data-brgy="San Narciso"></option>
                                    <option value="" data-brgy="Santa Cruz"></option>
                                    <option value="" data-brgy="Subic"></option>
                                    <option value="" data-brgy="Baliguian"></option>
                                    <option value="" data-brgy="Dapitan"></option>
                                    <option value="" data-brgy="Dipolog"></option>
                                    <option value="" data-brgy="Godod"></option>
                                    <option value="" data-brgy="Gutalac"></option>
                                    <option value="" data-brgy="Jose Dalman"></option>
                                    <option value="" data-brgy="Kalawit"></option>
                                    <option value="" data-brgy="Katipunan"></option>
                                    <option value="" data-brgy="La Libertad"></option>
                                    <option value="" data-brgy="Labason"></option>
                                    <option value="" data-brgy="Leon B. Postigo"></option>
                                    <option value="" data-brgy="Liloy"></option>
                                    <option value="" data-brgy="Manukan"></option>
                                    <option value="" data-brgy="Mutia"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Polanco"></option>
                                    <option value="" data-brgy="Rizal"></option>
                                    <option value="" data-brgy="Roxas"></option>
                                    <option value="" data-brgy="Salug"></option>
                                    <option value="" data-brgy=""></option>
                                    <option value="" data-brgy="Siayan"></option>
                                    <option value="" data-brgy="Sibuco"></option>
                                    <option value="" data-brgy="Sibutad"></option>
                                    <option value="" data-brgy="Sindangan"></option>
                                    <option value="" data-brgy="Siocon"></option>
                                    <option value="" data-brgy="Sirawai"></option>
                                    <option value="" data-brgy="Tampilisan"></option>
                                    <option value="" data-brgy="Aurora"></option>
                                    <option value="" data-brgy="Bayog"></option>
                                    <option value="" data-brgy="Dimataling"></option>
                                    <option value="" data-brgy="Dinas"></option>
                                    <option value="" data-brgy="Dumalinao"></option>
                                    <option value="" data-brgy="Dumingag"></option>
                                    <option value="" data-brgy="Guipos"></option>
                                    <option value="" data-brgy="Josefina"></option>
                                    <option value="" data-brgy="Kumalarang"></option>
                                    <option value="" data-brgy="Labangan"></option>
                                    <option value="" data-brgy="Lakewood"></option>
                                    <option value="" data-brgy="Lapuyan"></option>
                                    <option value="" data-brgy="Mahayag"></option>
                                    <option value="" data-brgy="Margosatubig"></option>
                                    <option value="" data-brgy="Midsalip"></option>
                                    <option value="" data-brgy="Molave"></option>
                                    <option value="" data-brgy="Pagadian"></option>
                                    <option value="" data-brgy="Pitogo"></option>
                                    <option value="" data-brgy="Ramon Magsaysay"></option>
                                    <option value="" data-brgy="San Miguel"></option>
                                    <option value="" data-brgy="San Pablo"></option>
                                    <option value="" data-brgy="Sominot"></option>
                                    <option value="" data-brgy="Tabina"></option>
                                    <option value="" data-brgy="Tambulig"></option>
                                    <option value="" data-brgy="Tigbao"></option>
                                    <option value="" data-brgy="Tukuran"></option>
                                    <option value="" data-brgy="Vincenzo A. Sagun"></option>
                                    <option value="" data-brgy="Zamboanga City"></option>
                                    <option value="" data-brgy="Alicia"></option>
                                    <option value="" data-brgy="Buug"></option>
                                    <option value="" data-brgy="Diplahan"></option>
                                    <option value="" data-brgy="Imelda"></option>
                                    <option value="" data-brgy="Ipil"></option>
                                    <option value="" data-brgy="Kabasalan"></option>
                                    <option value="" data-brgy="Mabuhay"></option>
                                    <option value="" data-brgy="Malangas"></option>
                                    <option value="" data-brgy="Naga"></option>
                                    <option value="" data-brgy="Olutanga"></option>
                                    <option value="" data-brgy="Payao"></option>
                                    <option value="" data-brgy="Roseller Lim"></option>
                                    <option value="" data-brgy="Siay"></option>
                                    <option value="" data-brgy="Talusan"></option>
                                    <option value="" data-brgy="Titay"></option>
                                    <option value="" data-brgy="Tungawan"></option>

                                    </select>
                                </div>
                                <!-- street -->
                                <div>
                                    <label for="street" class=" text-white">Street:</label>
                                    <input type="text" name="street" id="street"  placeholder="Street">
                                </div>

                                <div class='modal-footer'>
                                    <button type='submit' name="submit" value="add" id="submitButton" class='btn btn-primary '>Submit</button>                        
                                </div>                           
                                <!-- End -->
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
</section>


<!-- ######################################################################################################## -->


   <!--EditModal -->
         <div id="editmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" arial-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalLabel">EditContact</h5>
                        <button type='button' class='btn-close'  data-bs-dismiss='modal' aria-label='Close'>
                        <span arial-hidden="true">&times;;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-dark">
                        <form name="contact" method="POST" enctype="multipart/form-data" onsubmit="return val();">
                            <div class="card imgholder">
                                <label for="imgInput" class="upload">
                                    <input  type="file" name="Image" id="Image" accept=".jpg, .jpeg, .png">
                                    <i class="bi bi-plus-circle-dotted"></i>
                                </label>
                                <img src="image/5bbc3519d674c.jpg" alt="" width="200px" height="200px" class="img">                                
                            </div>

                            <div class="inputField">
                                <input type="hidden" name="id" id="id">
                                <!-- name -->
                                <div>
                                    <label for="name" class="  text-white">Name:</label>
                                    <input type="text" name="Name" id="Name" class="form-control" >
                                </div>
                                <!-- phone -->
                                <div>
                                    <label for="phone.no" class=" text-white">Phone No.:</label>
                                    <input type="text"  id="Phone" name="Phone" class="form-control" >
                                </div>
                                <!-- email -->
                                <div>
                                    <label for="Email" class=" text-white">Email:</label>
                                    <input type="text" id="Email" name="Email" class="form-control"  >
                                </div>
                                <!-- org -->
                                <div>
                                    <label for="Organization" class="text-white">Organization:</label></label>
                                    <input type="text" name="Organization" id="Organization" class="form-control" >
                                </div>
                                <!-- province -->
                                <div>
                                    <label for="Province" class="text-white">Province:</label></label>
                                    <input type="text" name="Province" id="Province" class="form-control"  >
                                </div>

                                <!-- city -->
                                <div>
                                    <label for="City" class="text-white">City:</label></label>
                                    <input type="text" name="City" id="City" class="form-control" >
                                </div>
                               
                                <!-- brgy -->
                                <div>
                                    <label for="Brgy" class="text-white">Brgy:</label></label>
                                    <input type="text" name="Brgy" id="Brgy" class="form-control" >
                                </div>
                                
                                <!-- street -->
                                <div>
                                    <label for="street" class=" text-white">Street:</label>
                                    <input type="text" name="Street" id="Street"  >
                                </div>

                                <div class='modal-footer'>
                                    <button type='submit' name="updatedata" value="add" id="submitButton" class='btn btn-primary deletebtn'>UpdateData</button>                        
                                </div>                           
                                <!-- End -->
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>

<!-- ######################################################################################################## -->


   <!--deletemodal -->
   <div  class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" arial-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalLabel ">Delete Data</h5>
                        <button type='button' class='btn-close'  data-bs-dismiss='modal' aria-label='Close'>
                        <span arial-hidden="true">&times;;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-dark">
                        <form  method="POST">
                            <div>
                                <input type="hidden" name="delete_id" id="delete_id">
                                <h4 class="text-white">Do You want to Delete this Data ??</h4>
                            </div>
                            <div class='modal-footer'>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">  No</button>
                                <button type='submit' name="deletedata" class='btn btn-primary '> Yes</button>                        
                            </div>                           
                              
                            
                        </form>
                    </div> 
                </div>
            </div>
        </div>
 
 

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- custom jsfile link -->
    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js" integrity="sha512-M+qMI1PHRcYcOpJzeJlaWbVVx2JJyPIwZas8or7dc97LZOokjvbpfRxymhVtlJLyjiF3wGyr0FJOA4DLONLVLw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
</body>

</html>