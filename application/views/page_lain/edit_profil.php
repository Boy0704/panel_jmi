<?php include 'header.php'; ?>

<div class="row">
	<div class="col-md-12" style="margin: 20px;">
		<?php 
		$data = $this->db->get_where('member', ['id_member'=>$this->uri->segment(3)])->row();
		 ?>
		<form>
			<div class="form-group">
				<label>Nama Lengkap</label>
				<input type="text" class="form-control" name="nama" value="<?php echo $data->nama ?>">
			</div>
			<div class="form-group">
				<label>No Rekening</label>
				<input type="text" class="form-control" name="no_rekening" value="<?php echo $data->no_rekening ?>">
			</div>
			<div class="form-group">
				<label>Kota</label>
				<input type="text" class="form-control" name="kota" value="<?php echo $data->kota ?>">
			</div>
			<div class="form-group">
				<label>No Telp</label>
				<input type="text" class="form-control" name="no_telp" value="<?php echo $data->no_telp ?>">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="text" class="form-control" name="password" value="<?php echo $data->password ?>">
			</div>
			<div class="form-group">
				<button class="btn btn-primary">Update</button>
			</div>
		</form>
	</div>
</div>

<?php include 'footer.php' ?>