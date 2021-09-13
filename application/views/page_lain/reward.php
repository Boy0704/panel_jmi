<?php include 'header.php'; ?>

<?php 
$data = $this->db->get_where('transaksi_investasi', ['no_transaksi' => $this->uri->segment(3)])->row();
 ?>


<div class="row">

	<div class="col-md-12" style="margin: 20px;">
			<h3>Target Reward Bulan INI</h3>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Gambar</th>
					<th>Target</th>
					<th>Ket</th>
					<th>Target Dicapai</th>
					<th>Sisa Target</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				foreach ($this->db->get('reward')->result() as $rw): ?>
					<tr>
						<td><?php echo $no ?></td>
						<td><img src="image/reward/<?php echo $rw->gambar ?>" style="width: 100px;"></td>
						<td><?php echo number_format($rw->target) ?></td>
						<td><?php echo $rw->ket ?></td>
						<td>
							
							<?php 
							$target_dicapai = 0;

							echo $target_dicapai;

							 ?>

						</td>

						<td>
							<?php 
							echo number_format($rw->target)
							 ?>
						</td>
						<td>
							<span class="badge badge-info">Belum Tercapai</span>
						</td>
					</tr>
				<?php $no++; endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<?php include 'footer.php' ?>