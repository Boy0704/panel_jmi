<div class="row">
	<div class="col-md-12">
		<div class="alert alert-warning">
			<h2>Selamat datang, <?php echo $this->session->userdata('nama'); ?></h2>
		</div>
		
	</div>

	<div class="col-md-3">
		<a href="app/transfer_hari_semua" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-success">Konfirmasi Semua Pembayaran Hari ini</a>
	</div>

</div>
