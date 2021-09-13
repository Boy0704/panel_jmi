<?php include 'header.php'; ?>

<div class="row">
	<div class="col-md-12" style="margin: 20px;">
		<h3>Pendaftaran Member JMI</h3>
		<form action="" method="POST">
			<div class="form-group">
				<label>Agen Ref</label>
				<input type="text" class="form-control" name="agen_ref" value="<?php echo $this->uri->segment(3) ?>" readonly="">
			</div>
			<div class="form-group">
				<label>Nama Agen</label>
				<input type="text" class="form-control" value="<?php echo get_data('member','no_telp',$this->uri->segment(3),'nama') ?>" readonly="">
			</div>
			<div class="form-group">
				<label>Nama Lengkap</label>
				<input type="text" class="form-control" name="nama" required="">
			</div>
			<div class="form-group">
				<label>No Rekening</label>
				<input type="text" class="form-control" name="no_rekening" required="">
			</div>
			<div class="form-group">
				<label>Kota</label>
				<input type="text" class="form-control" name="kota" required="">
			</div>
			<div class="form-group">
				<label>No Telp</label>
				<input type="text" class="form-control" name="no_telp" required="">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="text" class="form-control" name="password" required="">
			</div>
			<div class="form-group">
				<button class="btn btn-primary">Daftar</button>
			</div>
		</form>
	</div>
</div>

<?php include 'footer.php' ?>