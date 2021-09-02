<div class="row">
	<div class="col-md-12">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label>No Transaksi</label>
				<input type="text" name="no_transaksi" class="form-control" value="<?php echo "TRX".uniqid() ?>" readonly>
			</div>

			<div class="form-group">
				<label>Nama Member </label>
				<input type="text"  class="form-control" value="<?php echo get_data('member','id_member',$this->uri->segment(3),'nama') ?>" readonly>
			</div>
			<div class="form-group">
				<label>Kode Unik</label>
				<input type="number" name="kode_unik" value="<?php echo substr(get_data('member','id_member',$this->uri->segment(3),'no_telp'), -3) ?>" class="form-control" readonly>
			</div>
			<div class="form-group">
				<label>Jumlah Investasi <span class="label label-success">Masukkan jumlah transfer dengan kode unik ex: 100136</span></label>
				<input type="number" name="jumlah_investasi" class="form-control">
			</div>
			<div class="form-group">
				<label>Nama Rekening Pengirim</label>
				<input type="text" name="nama_rekening_transfer" class="form-control">
			</div>

			<div class="form-group">
				<label>Tanggal Transfer</label>
				<input type="date" name="tanggal_transfer" class="form-control">
			</div>

			<div class="form-group">
				<label>Jam Transfer</label>
				<input type="time" name="jam_transfer" class="form-control">
			</div>

			<div class="form-group">
				<label>Plan</label>
				<select name="plan" class="form-control">
					<option value="">Pilih Plan</option>
					<option value="mingguan">Mingguan</option>
					<option value="bulanan">Bulanan</option>
				</select>
			</div>

			<div class="form-group">
				<label>Bukti Transfer</label>
				<input type="file" name="bukti_transfer" class="form-control">
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-success btn-block">Kirim</button>
			</div>
						
		</form>
	</div>
</div>