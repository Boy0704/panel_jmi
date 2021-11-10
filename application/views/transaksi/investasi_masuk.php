<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		<table class="table table-bordered" id="example2">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>No Transaksi</th>
					<th>Jumlah Investasi</th>
					<th>Kode Unik</th>
					<th>Rekening Pengirim</th>
					<th>Tanggal Transfer</th>
					<th>Jam Transfer</th>
					<th>Plan</th>
					<th>Bukti Transfer</th>
					<th>Konfirmasi</th>
					<th>Created At</th>
					<th>Pilihan</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				$this->db->order_by('id_transaksi', 'desc');
				foreach ($this->db->get('transaksi_investasi')->result() as $rw): ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo get_data('member','id_member',$rw->id_member,'nama') ?></td>
					<td><?php echo $rw->no_transaksi ?></td>
					<th><?php echo number_format($rw->jumlah_investasi) ?></th>
					<td><?php echo $rw->kode_unik ?></td>
					<td><?php echo $rw->nama_rekening_transfer ?></td>
					<td><?php echo $rw->tanggal_transfer ?></td>
					<td><?php echo $rw->jam_transfer ?></td>
					<td><?php echo $rw->plan ?></td>
					<td>
						<a href="image/bukti/<?php echo $rw->bukti_transfer ?>">Bukti Transfer</a>
					</td>
					<td><?php echo $rw->konfirmasi ?></td>
					<td><?php echo $rw->created_at ?></td>
					<td>
						<a href="app/hapus_investasi/<?php echo $rw->id_transaksi ?>" class="btn btn-xs btn-danger" onclick="javasciprt: return confirm('yakin akan hapus data ini ?')">Hapus</a>
						<?php if ($rw->konfirmasi == 'y'): ?>
							<a href="app/konfirmasi_inv/<?php echo $rw->id_transaksi ?>/t" class="btn btn-xs btn-warning">Batalkan Konfirmasi</a>
							<a href="transfer/index/<?php echo $rw->no_transaksi ?>" class="btn btn-xs btn-info">Input Transfer</a>
						<?php else: ?>
							<a href="app/konfirmasi_inv/<?php echo $rw->id_transaksi ?>/y" class="btn btn-xs btn-success">Konfirmasi</a>
						<?php endif ?>
						
					</td>
				</tr>
				<?php $no++; endforeach ?>
			</tbody>
		</table>
		</div>
	</div>
</div>