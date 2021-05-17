<!-- Menambahkan skrip php -->
<?php
// Menambahkan file eksternal
include('koneksi.php');
// Menyimpan query untuk menampilkan data dari database
$kasus = mysqli_query($koneksi,"SELECT * FROM tb_covid");
// Menampilkan data dari database
while($row = mysqli_fetch_array($kasus)){
	// Membuat array
	$nama_negara[] = $row['negara'];
	// Menyimpan perintah/query untuk menjumlahkan nilai
	$query = mysqli_query($koneksi,"select sum(jumlah_kasus) as jumlah_kasus from tb_covid where id_negara='".$row['id_negara']."'");
	// Menyimpan hasil query
	$row = $query->fetch_array();
	// Menyimpan data jumlah setiap negara
	$jumlah_kasus[] = $row['jumlah_kasus'];
}
?>
<!-- Mendefnisikan bertipe html -->
<!DOCTYPE html>
<html>
<head>
	<!-- Menambahkan judul pada tab browser -->
	<title>Grafik Perbandingan Jumlah Kasus COVID-19</title>
	<!-- Memanggil file Chart.js -->
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<!-- Mengelompokkan elemen -->
	<div style="width: 800px;height: 800px">
		<!-- Membuat objek -->
		<canvas id="myChart"></canvas>
	</div>
	<!-- Menambahkan javascript -->
	<script>
		// Mengambil data dari objek
		var ctx = document.getElementById("myChart").getContext('2d');
		// Membuat objek baru
		var myChart = new Chart(ctx, {
			// Tipe grafik
			type: 'bar',
			// data grafik
			data: {
				// Menambahkan label pada chart
				labels: <?php echo json_encode($nama_negara); ?>,
				datasets: [{
					label: 'Grafik Jumlah Kasus COVID-19',
					// Memasukkan data
					data: <?php echo json_encode($jumlah_kasus); ?>,
					// Memodifikasi warna dari chart
					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					// Memodifikasi border bagian chart
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>