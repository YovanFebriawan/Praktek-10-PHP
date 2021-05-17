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
	$jumlah_kasus[] = $row['jumlah_kasus'];
	$kasus_baru[] = $row['kasus_baru'];
	$kematian_baru[] = $row['kematian_baru'];
	$jumlah_kematian[] = $row['jumlah_kematian'];
	$jumlah_sembuh[] = $row['jumlah_sembuh'];
	$kasus_aktif[] = $row['kasus_aktif'];
}
?>
<!-- Mendefnisikan bertipe html -->
<!DOCTYPE html>
<html>
<head>
	<!-- Menambahkan judul pada tab browser -->
	<title>Bar Chart COVID-19</title>
	<!-- Memanggil file Chart.js -->
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<h2 align="center">Bar Chart COVID-19 di 10 Negara</h2>
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
					// Membuat label
					label: 'Total Cases',
					// Menghilangkan warna yang mengisi chart
					fill: false,
					// Memasukkan data
					data: <?php echo json_encode($jumlah_kasus); ?>,
					// Mengatur warna line chart
					backgroundColor: 'rgba(255,0,0,1)',
					// Mengatur warna border chart
					borderColor: 'rgba(255,0,0,1)',
					// Mengatur ketebalan border
					borderWidth: 1},
					// Membuat label
				{	label: 'New Cases',
					// Menghilangkan warna yang mengisi chart
					fill: false,
					// Memasukkan data
					data: <?php echo json_encode($kasus_baru); ?>,
					// Mengatur warna line chart
					backgroundColor: 'rgba(255,255,0,1)',
					// Mengatur warna border chart
					borderColor: 'rgba(255,255,0,1)',
					// Mengatur ketebalan border
					borderWidth: 1},
					// Membuat label
				{	label: 'Total Death',
					// Menghilangkan warna yang mengisi chart
					fill: false,
					// Memasukkan data
					data: <?php echo json_encode($jumlah_kematian); ?>,
					// Mengatur warna line chart
					backgroundColor: 'rgba(0,0,0,1)',
					// Mengatur warna border chart
					borderColor: 'rgba(0,0,0,1)',
					// Mengatur ketebalan border
					borderWidth: 1},
					// Membuat label
				{	label: 'New Death',
					// Menghilangkan warna yang mengisi chart
					fill: false,
					// Memasukkan data
					data: <?php echo json_encode($kematian_baru); ?>,
					// Mengatur warna line chart
					backgroundColor: 'rgba(255,138,0,1)',
					// Mengatur warna border chart
					borderColor: 'rgba(255,138,0,1)',
					// Mengatur ketebalan border
					borderWidth: 1},
					// Membuat label
				{	label: 'Total Recovered',
					// Menghilangkan warna yang mengisi chart
					fill: false,
					// Memasukkan data
					data: <?php echo json_encode($jumlah_sembuh); ?>,
					// Mengatur warna line chart
					backgroundColor: 'rgba(48,255,0,1)',
					// Mengatur warna border chart
					borderColor: 'rgba(48,255,0,1)',
					// Mengatur ketebalan border
					borderWidth: 1},
					// Membuat label
				{	label: 'Active Cases',
					// Menghilangkan warna yang mengisi chart
					fill: false,
					// Memasukkan data
					data: <?php echo json_encode($kasus_aktif); ?>,
					// Mengatur warna line chart
					backgroundColor: 'rgba(0,11,255,1)',
					// Mengatur warna border chartt
					borderColor: 'rgba(0,11,255,1)',
					// Mengatur ketebalan border
					borderWidth: 1
				}]
			},
			options: {
				elements: {
					line: {
						tension: 0
					}
				},
				legend:{
					display: true
				},
				barValueSpacing: 20,
				scales: {
					yAxes: [{
						ticks: {
							// Memberikan angka 0 di ujung sumbu x dan y sebagai jumlah awal
							beginAtZero:true
						}
					}],
					xAxes: [{
						// Membuat garis horizontal pada chart
						gridLines: [{
							// Merubah warna
							color:"rgba(0,0,0,0)",
						}]
					}]
				}
			}
		});
	</script>
</body>
</html>