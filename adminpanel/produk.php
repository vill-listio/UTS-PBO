<?php 
    require "sesion.php";
    require "../koneksi.php";

    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM imron_stok a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($query);

    $queryKategory = mysqli_query($con, "SELECT * FROM kategori");

    function generateRandomSring($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Laskar | Produk</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/fontawesome.min.css">
</head>
<style>
    .no-decoration{
        text-decoration: none;
    }
</style>
<body>
<?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" active aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>  
                </li>
                <li class="breadcrumb-item active" active aria-current="page">
                Produk
                </li>
            </ol>
        </nav>


        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama_produk">nama produk</label>
                    <input type="text" id="nama_produk" name="nama_produk" class="form-control" autocomplete=off>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="">Pilih satu</option>
                    <?php
                        while($data=mysqli_fetch_array($queryKategory)){
                    ?>
                        <option value=" <?php echo $data['id'] ?>"><?php echo $data['nama']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                    
                </div>
                <div>
                    <label for="harga">Harga Beli </label>
                    <input type="number" class="form-control" name="harga_beli">
                    <label for="harga">Harga Jual </label>
                    <input type="number" class="form-control" name="harga_jual">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>
            <?php
            if(isset($_POST['simpan'])){
                $nama_produk = htmlspecialchars($_POST['nama_produk']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga_beli = htmlspecialchars($_POST['harga_beli']);
                $harga_jual = htmlspecialchars($_POST['harga_jual']);
                $stok = htmlspecialchars($_POST['stok']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomSring(20);
                $new_name = $random_name . "." . $imageFileType;
                

                if($nama_produk=='' || $kategori=='' || $harga_beli=='' || $harga_jual=='' || $stok=='' ){
            ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama Produk, Kategori, Harga beli, Harga Jual dan Stok wajib diisi
                    </div>
            <?php
                }
                else{
                    if($nama_file!=''){
                        if($image_size > 10000000){
            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File tidak boleh lebih dari 10MB
                            </div>
            <?php
                        }
                        else{
                            if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif' ){
            ?>
                               <div class="alert alert-warning mt-3" role="alert">
                                    File wajib bertipe jpg/jpeg/png/gif
                                </div> 
            <?php
                            }
                            else{
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }
                    //query insert produk tabel
                    $queryTambah = mysqli_query($con, "INSERT INTO imron_stok (kategori_id, nama_barang, harga_beli, Harga_jual, foto, stok) VALUES ('$kategori', '$nama_produk', '$harga_beli', '$harga_jual', '$new_name', '$stok')");

                    if($queryTambah){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Produk Berhasil Tersimpan
                        </div>

                        <meta http-equiv="refresh" content="1; url=produk.php"/>
            <?php 
                    }
                    else{
                        echo mysqli_error($con);
                    }
                }
            }
            ?>
        </div>

        <div class="mt-3 mb-5">
            <h2>List produk</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>nama_barang</th>
                            <th>Kategori</th>
                            <th>Harga_beli</th>
                            <th>Harga_jual</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                            if($jumlahProduk==0){
                                
                        ?>
                                <tr>
                                    <td colspan=7 class="text-center">Data produk tidak tersedia</td>
                                </tr>
                        <?php
                            }
                            else{
                                $jumlah = 1;
                                    while($data=mysqli_fetch_array($query)){
                                    
                        ?>
                                    <tr>
                                        <td><?php echo $jumlah;?></td>
                                        <td><?php echo $data['nama_barang']; ?></td>
                                        <td><?php echo $data['nama_kategori']; ?></td>
                                        <td><?php echo $data['harga_beli']; ?></td>
                                        <td><?php echo $data['harga_jual']; ?></td>
                                        <td><?php echo $data['stok']; ?></td>
                                        <td>
                                            <a href="produk-detail.php?x=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                                        </td>
                                        
                                    </tr>
                        <?php
                                    $jumlah++;
                                    }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome-free-6.6.0-web/js/all.min.js"></script>
</body>
</html>