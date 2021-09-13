<?php include 'header.php'; ?>

<?php 
$data = $this->db->get_where('transaksi_investasi', ['no_transaksi' => $this->uri->segment(3)])->row();
 ?>
<div class="row">
	<div class="col-md-12" style="margin: 20px;">
		<table class="table table-bordered">
			<tr>
				<td>No Transaksi</td>
				<td>:</td>
				<td><?php echo $data->no_transaksi ?></td>
			</tr>
			<tr>
				<td>Jumlah Investasi</td>
				<td>:</td>
				<td><?php echo $data->jumlah_investasi ?></td>
			</tr>
			<tr>
				<td>Tgl Transfer</td>
				<td>:</td>
				<td><?php echo $data->tanggal_transfer ?></td>
			</tr>
			<tr>
				<td>Plan</td>
				<td>:</td>
				<td><?php echo $data->plan ?></td>
			</tr>
		</table>
	</div>
</div>

<div class="row">

	<div class="col-md-12" style="margin: 20px;">
			<h3>Detail Transfer</h3>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Jadwal Transfer</th>
					<th>Nominal</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$this->db->order_by('ke', 'asc');
				foreach ($this->db->get_where('jadwal_transfer', ['no_transaksi'=>$data->no_transaksi])->result() as $rw): ?>
					<tr>
						<td><?php echo $rw->ke ?></td>
						<td><?php echo $rw->jadwal_transfer ?></td>
						<td><?php echo number_format($rw->nominal) ?></td>
						<td>
							<?php 
							$status = $this->db->get_where('transfer', ['no_transaksi'=>$rw->no_transaksi,'ke'=>$rw->ke]);
							
							 ?>
							<?php if ($status->num_rows() > 0): ?>
								<span class="badge badge-success">Selesai</span>
							<?php else: ?>
								<span class="badge badge-info">Menunggu</span>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<?php include 'footer.php' ?>