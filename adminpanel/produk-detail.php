<?php
     require "sesion.php";
     require "../koneksi.php";

     $id = $_GET['x'];

     $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM imron_stok a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'" );
     $data = mysqli_fetch_array($query);

     $queryKategory = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

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
    <title>Produk Detail</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Detail Produk</h2>
        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama_barang">nama</label>
                    <input type="text" name="nama_barang" id="nama_barang" value="<?php echo $data['nama_barang']; ?>" class="form-control">
                </div>
                <div>
                <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="<?php echo $data['kategori_id'] ?>"><?php echo $data['nama_kategori']; ?></option>
                    <?php
                        while($dataKategori=mysqli_fetch_array($queryKategory)){
                    ?>
                        <option value=" <?php echo $dataKategori['id'] ?>"><?php echo $dataKategori['nama']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga Beli </label>
                    <input type="number" class="form-control" name="harga_beli" value="<?php echo $data['harga_beli']; ?>">
                    <label for="harga">Harga Jual </label>
                    <input type="number" class="form-control" name="harga_jual" value="<?php echo $data['harga_jual']; ?>">
                </div>
                <div>
                    <label for="currentFoto">Foto Produk Sekarang</label>
                    <img src="../image/<?php echo $data['foto'] ?>" alt="" width="300px">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok" value="<?php echo $data['stok']; ?>">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                </div>
            </form>
            <?php
            if(isset($_POST['simpan'])){
                $nama_produk = htmlspecialchars($_POST['nama_barang']);
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
                    $queryUpdate = mysqli_query($con, "UPDATE imron_stok SET kategori_id='$kategori', nama_barang='$nama_produk', harga_beli='$harga_beli', harga_jual='$harga_jual', stok='$stok' WHERE id=$id ");

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

                                    $queryUpdate = mysqli_query($con, "UPDATE imron_stok SET foto='$new_name' WHERE id='$id'");
                            }
                        }
                        if($queryUpdate){
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
            }

            if(isset($_POST['hapus'])){
                $queryHapus = mysqli_query($con, "DELETE FROM imron_stok WHERE id='$id'");

                if($queryHapus){
                    ?>
                        <div class="alert alert-primary mt-3" role="alert">
                                Produk Berhasil Dihapus
                        </div>
                        <meta http-equiv="refresh" content="1; url=produk.php"/>
                    <?php
                }
                else{
                echo mysqli_error($con);
                }
                
            }

            ?>
        </div>
    </div>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>