<?php session_start();
include_once('../includes/config.php');
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['verifikasi']))
    {
        $userid = $_SESSION['id'];
        $tanggal_tes = $_POST['tanggal_tes'];
        $lokasi_tes = $_POST['lokasi_tes'];
        // var_dump($_POST);
        // die;
        $msg=mysqli_query($con,"update users set tanggal_tes = '$tanggal_tes', lokasi_tes = '$lokasi_tes', status = 'Verified' where id='$userid'");
        if($msg)
        {
            echo "<script>alert('Data telah terverifikasi');</script>";
            // die;
            echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
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
    <title>User Profile | Registration and Login System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
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
$userid=$_GET['uid'];
$query=mysqli_query($con,"select * from users where id='$userid'");
while($result=mysqli_fetch_array($query))
{?>
                    <h1 class="mt-4"><?php echo $result['fname'];?>'s Profile</h1>
                    <div class="card mb-4">

                        <div class="card-body">
                            <a href="edit-profile.php">Edit</a>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Foto Diri</th>
                                    <td colspan="3"><img src="../<?php echo $result['foto'];?>" width="350px"
                                            height="400px" alt=""></td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td colspan="3"><?php echo $result['nik'];?></td>
                                </tr>
                                <tr>
                                    <th>First Name</th>
                                    <td><?php echo $result['fname'];?></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><?php echo $result['lname'];?></td>
                                </tr>

                                <tr>
                                    <th>Pilihan Kementerian</th>
                                    <td><?php echo $result['pilihan'];?></td>
                                </tr>

                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td><?php echo $result['tanggal_lahir'];?></td>
                                </tr>

                                <tr>
                                    <th>Tempat Lahir</th>
                                    <td><?php echo $result['tempat_lahir'];?></td>
                                </tr>

                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td><?php echo $result['jenis_kelamin'];?></td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><?php echo $result['email'];?></td>
                                </tr>

                                <tr>
                                    <th>Nomor Kontak</th>
                                    <td colspan="3"><?php echo $result['contactno'];?></td>
                                </tr>

                                <tr>
                                    <th>Alamat Tinggal</th>
                                    <td colspan="3"><?php echo $result['alamat'];?></td>
                                </tr>

                                <tr>
                                    <th>Lokasi Tes</th>
                                    <td colspan="3"><?php echo $result['contactno'];?></td>
                                </tr>

                                <tr>
                                    <th>Reg. Date</th>
                                    <td colspan="3"><?php echo $result['posting_date'];?></td>
                                </tr>



                                </tbody>
                            </table>
                        </div>
                        <div class="card mb-4 mx-3">

                            <div class="card-body">
                                <form method="post"><input type="hidden" name="status"
                                        value="Sedang dalam verifikasi panitia">

                                    <table class="table table-bordered mx-3">
                                        <tr>
                                            <th>Tanggal Tes</th>
                                            <td><input class="form-control" id="tanggal_lahir" name="tanggal_tes"
                                                    type="date" value="<?php echo $result['tanggal_tes'];?>" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi Tes</th>
                                            <td><input class="form-control" id="tempat_lahir" name="lokasi_tes"
                                                    type="text" value="<?php echo $result['lokasi_tes'];?>" required />
                                            </td>
                                        </tr>
                                    </table>
                                    <button type="submit" class="btn btn-success m-4" name="verifikasi"
                                        width="400px">DATA
                                        SUDAH
                                        VALID</button>
                                </form>
                            </div>

                        </div>
                        <?php } ?>

                    </div>
            </main>
            <?php include('../includes/footer.php');?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>
<?php } ?>