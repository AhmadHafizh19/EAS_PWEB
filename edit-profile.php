<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
function upload(){
    $namaFile = $_FILES['image']['name'];
    $ukuranFile = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];
    
    if($error === 4) {
        // die;
        echo "<script>
            alert('Please choose an image!');
            document.location.href = 'index.php';
        </script>";
        return false;
    }
    // cek yg diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    // gunakan expload untuk memecah string setelah "."
    $ekstensiGambar = explode('.', $namaFile);
    // strtolower untuk mengubah huruf menjadi huruf kecil
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    // cek dalam array apakah terdapat ekstensi gambar yang valid
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        //die;
        echo "<script>
            alert('Please choose a valid image!');
            document.location.href = 'edit-profile.php';
        </script>";
        
        return false;
    }
    // cek ukuran file apabila lebih kembalikan error
    if($ukuranFile > 1000000) {
        //die;
        echo "<script>
            alert('Please choose a smaller image!');
            document.location.href = 'edit-profile.php';
        </script>";
        
        return false;
    }
    // generate nama file baru
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensiGambar;
    // copy file ke folder img
    move_uploaded_file($tmpName, '.\foto/' . $namafilebaru);
    return $namafilebaru;
}
//Code for Updation 
if(isset($_POST['update']))
{
    $userid=$_SESSION['id'];
    $query=mysqli_query($con,"select * from users where id='$userid'");
    $result = mysqli_fetch_assoc($query);
    // var_dump($_FILES);
    // die;
    // $tmp1 = $result[jenis_kelamin];
    // $tmp2 = $result[pilihan];
    // if(!isset($_POST['kelamin']) && isset($result[jenis_kelamin])){
    //     $_POST['kelamin'] = $tmp1;
    // }
    // if(!isset($_POST['kementerian']) && isset($result[pilihan])){
    //     $_POST['kementerian'] = $tmp2;
    // }
    
    // var_dump($result);
    // var_dump($_POST['kelamin']);
    // var_dump($_POST['kementerian']);
    // die;
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $contact=$_POST['contact'];
    $pilihan=$_POST['kementerian'];
    $alamat=$_POST['alamat'];
    $tempat_lahir=$_POST['tempat_lahir'];
    $tanggal_lahir=$_POST['tanggal_lahir'];
    $jenis_kelamin=$_POST['kelamin'];
    $userid=$_SESSION['id'];

    $imagelama = $_POST["imageLama"];

    if($_FILES['image']['error'] === 4) {
        $image = $imagelama;
    } else {
        $image = upload();
        
    }
    $msg=mysqli_query($con,"update users set foto = './foto/$image', jenis_kelamin = '$jenis_kelamin', tanggal_lahir = '$tanggal_lahir', tempat_lahir = '$tempat_lahir', alamat = '$alamat', pilihan = '$pilihan', fname='$fname',lname='$lname',contactno='$contact' where id='$userid'");

if($msg)
{
    echo "<script>alert('Profile updated successfully');</script>";
    // die;
       echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
}
}


    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit Profile | Registration and Login System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php');?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php');?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

                    <?php 
                        $userid=$_SESSION['id'];
                        $query=mysqli_query($con,"select * from users where id='$userid'");
                        while($result=mysqli_fetch_array($query))
                    {?>
                    <h1 class="mt-4"><?php echo $result['fname'];?>'s Profile</h1>
                    <div class="card mb-4">
                        <form method="post" enctype="multipart/form-data">
                            <div class=" card-body">
                                <table class="table table-bordered">
                                    <input type="hidden" name="imageLama" value="<?= $result["foto"] ?>">
                                    <tr>
                                        <th>First Name</th>
                                        <td><input class="form-control" id="fname" name="fname" type="text"
                                                value="<?php echo $result['fname'];?>" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td><input class="form-control" id="lname" name="lname" type="text"
                                                value="<?php echo $result['lname'];?>" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>

                                        <td>
                                            <select class="form-control" id="kelamin" name="kelamin" required>
                                                <option value="<?php echo $result['jenis_kelamin'];?>" selected disabled
                                                    hidden>
                                                    <?php echo $result['jenis_kelamin'];?></option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>

                                        </td>

                                        <!-- <td><input class="form-control" id="kelamin" name="kelamin" type="text"
                                                value="<?php echo $result['jenis_kelamin'];?>" required /></td> -->
                                    </tr>
                                    <tr>
                                        <th>Pilihan</th>
                                        <td>
                                            <select class="form-control" id="kementerian" name="kementerian" required>
                                                <option value="<?php echo $result['pilihan'];?>" selected disabled
                                                    hidden>
                                                    <?php echo $result['pilihan'];?></option>
                                                <option value="Kementerian Agama">Kementerian Agama</option>
                                                <option value="Kementerian Keuangan">Kementerian Keuangan</option>
                                                <option value="Kementerian Pendidikan">Kementerian Pendidikan</option>
                                                <option value="Kementerian Kesehatan">Kementerian Kesehatan</option>
                                                <option value="Kementerian Sosial">Kementerian Sosial</option>
                                                <option value="Kementerian Perdagangan">Kementerian Perdagangan</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td><input class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                                type="date" value="<?php echo $result['tanggal_lahir'];?>" required />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td><input class="form-control" id="tempat_lahir" name="tempat_lahir"
                                                type="text" value="<?php echo $result['tempat_lahir'];?>" required />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Tinggal</th>
                                        <td><input class="form-control" id="alamat" name="alamat" type="text"
                                                value="<?php echo $result['alamat'];?>" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Kontak</th>
                                        <td colspan="3"><input class="form-control" id="contact" name="contact"
                                                type="text" value="<?php echo $result['contactno'];?>"
                                                title="10 numeric characters only" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Upload Foto Diri</th>
                                        <td colspan="3"> <input type="file" name="image" class="form-control "
                                                id="image" required></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td colspan="3"><?php echo $result['email'];?></td>
                                    </tr>

                                    <tr>
                                        <th>Lokasi Tes</th>
                                        <td colspan="3"><?php echo $result['lokasi_tes'];?></td>
                                    </tr>


                                    <tr>
                                        <th>Reg. Date</th>
                                        <td colspan="3"><?php echo $result['posting_date'];?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:center ;"><button type="submit"
                                                class="btn btn-primary btn-block" name="update">Update</button></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <?php } ?>

                </div>
            </main>
            <?php include('includes/footer.php');?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
<?php } ?>