<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
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
					<th>Pilihan</th>
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
					<td><?php echo get_data('member','no_telp',$rw->agen_ref,'nama') ?></td>
					<td><?php echo $rw->is_agen ?></td>
					<td><?php echo $rw->kota ?></td>
					<td>
						<?php if ($rw->is_agen == 't'): ?>
							<a href="app/agen/<?php echo $rw->id_member ?>/y" class="btn btn-xs btn-success">Jadikan Agen</a>
						<?php else: ?>
							<a href="app/agen/<?php echo $rw->id_member ?>/t" class="btn btn-xs btn-danger">Batal Jadikan Agen</a>
						<?php endif ?>

						<a href="app/hapus_member/<?php echo $rw->id_member ?>" onclick="javasciprt: return confirm('Yakin hapus member ini ?')" class="label label-danger" >Hapus</a>
						
					</td>
				</tr>
				<?php $no++; endforeach ?>
			</tbody>
		</table>
		</div>
	</div>
</div>