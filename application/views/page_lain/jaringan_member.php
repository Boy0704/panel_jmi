<?php include 'header.php'; ?>

<div class="row">
	<div class="col-md-12" style="margin-top: 10px;">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>Total Investasi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				$no_telp = get_data('member','id_member',$this->uri->segment(3),'no_telp');
				foreach ($this->db->get_where('member', ['agen_ref'=>$no_telp])->result() as $rw): ?>
					
				
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $rw->nama ?></td>
					<td>
						<?php 
						$sql = "SELECT sum(jumlah_investasi) as total FROM transaksi_investasi WHERE id_member='$rw->id_member' and konfirmasi='y' ";
						$total = $this->db->query($sql)->row()->total;
						echo $total;
						 ?>
					</td>
				</tr>

				<?php $no++; endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<?php include 'footer.php' ?>