<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" id="example2">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>No Telp</th>
					<th>Password</th>
					<th>No Rekening</th>
					<th>Agen Ref</th>
					<th>Status Agen</th>
					<th>Kota</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				foreach ($this->db->get('member')->result() as $rw): ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $rw->nama ?></td>
					<td><?php echo $rw->no_telp ?></td>
					<td><?php echo $rw->password ?></td>
					<td><?php echo $rw->no_rekening ?></td>
					<td><?php echo $rw->agen_ref ?></td>
					<td><?php echo $rw->is_agen ?></td>
					<td><?php echo $rw->kota ?></td>
				</tr>
				<?php $no++; endforeach ?>
			</tbody>
		</table>
	</div>
</div>