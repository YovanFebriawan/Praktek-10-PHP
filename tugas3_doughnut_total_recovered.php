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
	$query = mysqli_query($koneksi,"select jumlah_sembuh from tb_covid where id_negara='".$row['id_negara']."'");
	// Menyimpan hasil query
	$row = $query->fetch_array();
	// Menyimpan data jumlah setiap negara
	$jumlah_sembuh[] = $row['jumlah_sembuh'];
}
?>
<!-- Mendefnisikan bertipe html -->
<!DOCTYPE html>
<html>
<head>
	<!-- Menambahkan judul pada tab browser -->
	<title>Doughnut Chart Total Recovered COVID-19</title>
	<!-- Memanggil file Chart.js -->
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<!-- Menambahkan judul pada halaman browser -->
	<h2>Total Recovered</h2>
	<!-- Mengelompokkan elemen -->
	<div id="canvas-holder" style="width:85%">
		<!-- Membuat objek -->
		<canvas id="chart-area"></canvas>
	</div>
	<!-- Menambahkan javascript -->
	<script>
		var config = {
			// Tipe grafik
			type: 'doughnut',
			// Data grafik
			data: {
				datasets: [{
					// Memasukkan data
					data:<?php echo json_encode($jumlah_sembuh); ?>,
					// Mengatur warna pie chart
					backgroundColor: [
					'rgba(255,99,132,1)',
					'rgba(54,162,235,1)',
					'rgba(255,206,86,1)',
					'rgba(75,192,192,1)',
					'rgba(255,149,0,1)',
					'rgba(0,255,255,1)',
					'rgba(181,0,255,1)',
					'rgba(0,0,0,1)',
					'rgba(27,255,0,1)',
					'rgba(58,0,255,1)'
					],
					// Mengatur warna border
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54,162,235,1)',
					'rgba(255,206,86,1)',
					'rgba(75,192,192,1)',
					'rgba(255,149,0,1)',
					'rgba(0,255,255,1)',
					'rgba(181,0,255,1)',
					'rgba(0,0,0,1)',
					'rgba(27,255,0,1)',
					'rgba(58,0,255,1)'
					],
				}],
				// Menambahkan label pada chart
				labels: <?php echo json_encode($nama_negara); ?>},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			// Mengambil data
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};
		// Mengambil data
		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});
		
		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>
</html>