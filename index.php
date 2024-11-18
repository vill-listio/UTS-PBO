<?php
 require "koneksi.php";
 $queryProduk = mysqli_query($con, "SELECT id, nama_barang, harga_jual, foto FROM imron_stok LIMIT 6");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Laskar | Home</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Toko Minuman Laskar</h1>
            <h2>Haus? segerin aja pake minuman</h2>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="/Imron_Toko_Minuman/produk_view.php/">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="kuy cari" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn warna4 text-white">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Rekomendasi minuman yang enak</h3>

            <div class="row mt-5">
                <div class="col-4 md-4 mb-3">
                    <div class="highlighted-kategori kategori-teh d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="/Imron_Toko_Minuman/produk_view.php/?kategori=Teh">Teh</a></h4>
                    </div>
                </div>
                <div class="col-4 md-4 mb-3">
                    <div class="highlighted-kategori kategori-kopi d-flex justify-content-center align-items-center">
                    <h4 class="text-white"><a class="no-decoration" href="/Imron_Toko_Minuman/produk_view.php/?kategori=kopi">Kopi</a></h4>
                    </div>
                </div>
                <div class="col-4 md-4 mb-3">
                    <div class="highlighted-kategori kategori-isotonik d-flex justify-content-center align-items-center">
                    <h4 class="text-white"><a class="no-decoration" href="/Imron_Toko_Minuman/produk_view.php/?kategori=Minuman Isotonic">Minuman Isotonic</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3">website ini adalah website ujian praktek uts matakuliah pemmrograman berorientasi objek (PBO)</p>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>

            <div class="row mt-5">
                <?php while($data = mysqli_fetch_array($queryProduk)){ ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card" style="width: 18rem;">
                        <div class="image-box">
                            <img src="../image/<?php echo $data['foto'] ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama_barang'] ?></h4>
                            <p class="card-text text-truncate"></p>
                            <p class="card-text text-harga">RP <?php echo $data['harga_jual'] ?></p>
                            <a href="https://web.whatsapp.com/" class="btn btn-primary">Order Sekarang</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-primary mt-3" href="/Imron_Toko_Minuman/produk_view.php">See more</a>
        </div>
    </div>

    <?php require "footer.php" ?>

<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome-free-6.6.0-web/js/all.min.js"></script> 
</body>
</html>