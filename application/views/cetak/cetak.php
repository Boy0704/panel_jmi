<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Cetak_Jadwal_Transfer.xls");
?>
<table border="1">
	<tr>
		<td><b>Nama</b></td>
		<td><b>No Rekening</b></td>
		<td><b>Jadwal Tranfer</b></td>
		<td><b>Nominal</b></td>
	</tr>
	<?php
	$no = 1;
	 foreach ($this->db->get_where('jadwal_transfer', ['jadwal_transfer'=>$tanggal])->result() as $rw): ?>
		<tr>
			<td><?php echo $no ?></td>
			<td><?php echo $rw->nama ?></td>
			<td><?php echo get_data('member','id_member',$rw->id_member,'no_rekening') ?></td>
			<td><?php echo $rw->jadwal_tranfer ?></td>
			<td><?php echo $rw->nominal ?></td>
		</tr>
	<?php $no++; endforeach ?>
</table>