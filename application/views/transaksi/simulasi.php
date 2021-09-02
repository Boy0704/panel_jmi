<div class="row">
	<div class="col-md-12">
		<form action="" method="POST">
			<div class="form-group">
				<label>Nominal Investasi</label>
				<input type="number" name="nominal" class="form-control input-lg" required>
			</div>
			<div class="form-group">
				<label>Planning</label>
				<select name="plan" class="form-control" required>
					<option value="">Pilih Plan</option>
					<option value="mingguan">Mingguan</option>
					<option value="bulanan">Bulanan</option>
				</select>
			</div>
			<div class="form-group">
				<button type="submit" name="proses" class="btn btn-success btn-block">PROSES</button>
			</div>
		</form>
	</div>
	<?php if (isset($_POST['proses'])):
		if ($_POST['plan'] == 'mingguan') {
			$hasil = $_POST['nominal'] * 0.08;
		} else {
			$hasil = $_POST['nominal'] * 0.25;
		}
		
		?>
		<div class="col-md-12">
			<div>
				<h3>Nominal : <?php echo number_format($_POST['nominal']) ?></h3>
				<?php if ($_POST['plan'] == 'mingguan'): ?>
					<h4>Persentase Keuntungan : 8%</h4>
					<h4>Keuntungan yang diterima setiap minggu : <?php echo number_format($hasil) ?> x 32 Cair</h4>
					<h4>Total Profit : <?php echo number_format($hasil * 32) ?></h4>

				<?php else: ?>
					<h4>Persentase Keuntungan : 25%</h4>
					<h4>Keuntungan yang diterima setiap bulan : <?php echo number_format($hasil) ?> x 12 Cair</h4>
					<h4>Total Profit : <?php echo number_format($hasil * 12) ?></h4>
				<?php endif ?>


			</div>
		</div>
	<?php endif ?>
	
</div>