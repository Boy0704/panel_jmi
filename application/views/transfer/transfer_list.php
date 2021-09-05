
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('transfer/create/'.$this->uri->segment(3)),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px" id="example2">
            <thead>
            <tr>
                <th>No</th>
		<th>No Transaksi</th>
		<th>Member</th>
		<th>Keterangan</th>
		<th>Tanggal</th>
		<th>Jam</th>
        <th>Jumlah</th>
		<th>Pembayaran Ke</th>
		<th>Created At</th>
		<th>Updated At</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody>
                <?php
            $start = 1;
            $this->db->where('no_transaksi', $this->uri->segment(3));
            $transfer_data = $this->db->get('transfer');
            foreach ($transfer_data->result() as $transfer)
            {
                ?>
                <tr>
			<td width="80px"><?php echo $start ?></td>
			<td><?php echo $transfer->no_transaksi ?></td>
			<td><?php echo get_data('member','id_member',$transfer->id_member,'nama') ?></td>
			<td><?php echo $transfer->keterangan ?></td>
			<td><?php echo $transfer->tanggal ?></td>
			<td><?php echo $transfer->jam ?></td>
			<td><?php echo number_format($transfer->jumlah) ?></td>
            <td><?php echo $transfer->ke ?></td>
			<td><?php echo $transfer->created_at ?></td>
			<td><?php echo $transfer->updated_at ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				// echo anchor(site_url('transfer/update/'.$transfer->id_transfer),'<span class="label label-info">Ubah</span>'); 
				// echo ' | '; 
				echo anchor(site_url('transfer/delete/'.$transfer->id_transfer),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
                $start++;
            }
            ?>
            </tbody>
        </table>
        </div>
        
    