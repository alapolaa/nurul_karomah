<?php
include 'koneksi.php';

// Mengambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$subjek = $_POST['subjek'];
$pesan = $_POST['pesan'];

// Menyiapkan dan menjalankan query SQL
$sql = "INSERT INTO kontak (nama, email, subjek, pesan) VALUES ('$nama', '$email', '$subjek', '$pesan')";

if ($conn->query($sql) === TRUE) {
    echo "<!DOCTYPE html>
          <html>
          <head>
              <title>Pesan Terkirim</title>
              <style>
                  #notification {
                      display: block;
                      position: fixed;
                      top: 50%;
                      left: 50%;
                      transform: translate(-50%, -50%);
                      background-color: #f0f0f0;
                      padding: 40px;
                      border-radius: 15px;
                      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                      width: 400px;
                      text-align: center; /* Teks di tengah */
                  }
                  #notification img {
                      width: 250px; /* Ukuran gambar diperbesar */
                      height: 250px; /* Ukuran gambar diperbesar */
      
                  }
                  #notification h2 {
                      font-size: 30px;
                    
                  }
                  #notification p {
                      font-size: 20px;
                      margin-bottom: 20px;
                  }
                  #notification button {
                      background-color:rgba(7, 218, 101, 0.91);
                      color: white;
                      border: none;
                      padding: 10px 10px;
                      border-radius: 8px;
                      cursor: pointer;
                      font-size: 18px;
                  }
              </style>
          </head>
          <body>
              <div id='notification'>
                  <img src='img/sukses.png' alt='Ikon Sukses'>
                  <h2>Selamat</h2>
                  <p>Pesan Anda berhasil dikirim</p>
                  <button onclick=\"window.location.href='index.php'\">Oke</button>
              </div>
          </body>
          </html>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi
$conn->close();
