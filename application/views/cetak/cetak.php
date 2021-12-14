<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Cetak_Jadwal_Transfer.xls");
?>
<style type="text/css">
	.num {
	  mso-number-format:General;
	}
	.text{
	  mso-number-format:"\@";/*force text*/
	}
</style>
<table border="1">
	<tr>
		<td><b>No</b></td>
		<td><b>Nama</b></td>
		<td><b>Nama Bank</b></td>
		<td><b>No Rekening</b></td>
		<td><b>Jadwal Tranfer</b></td>
		<td><b>Nominal</b></td>
	</tr>
	<?php
	$no = 1;
	$this->db->select('a.*');
	$this->db->from('jadwal_transfer a');
	$this->db->join('transaksi_investasi b', 'a.no_transaksi = b.no_transaksi', 'inner');
	$this->db->where('a.jadwal_transfer', $tanggal);
	 foreach ($this->db->get()->result() as $rw): ?>
		<tr>
			<td><?php echo $no ?></td>
			<td><?php echo $rw->nama ?></td>
			<td><?php echo get_data('member','id_member',$rw->id_member,'nama_bank') ?></td>
			<td class="text"><?php echo get_data('member','id_member',$rw->id_member,'no_rekening') ?></td>
			<td><?php echo $rw->jadwal_transfer ?></td>
			<td class="num"><?php echo $rw->nominal ?></td>
		</tr>
	<?php $no++; endforeach ?>
</table>