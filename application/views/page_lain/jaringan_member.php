<?php include 'header.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>


<div class="row">
	<div class="col-md-12" style="margin-top: 10px;">
		<button class="btn btn-success btn-block" data-clipboard-action="copy"
      data-clipboard-target="#myInput">Copy Link Referal Agen</button>

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
		<input type="text" value="<?php echo base_url() ?>app/daftar_member/<?php echo $no_telp ?>" id="myInput" class="form-control">
	</div>
</div>

<script>
      var clipboard = new ClipboardJS('.btn');

      clipboard.on('success', function (e) {
        console.log(e);
      });

      clipboard.on('error', function (e) {
        console.log(e);
      });
    </script>



<?php include 'footer.php' ?>