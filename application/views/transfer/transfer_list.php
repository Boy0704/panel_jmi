
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php //echo anchor(site_url('transfer/create/'.$this->uri->segment(3)),'Create', 'class="btn btn-primary"'); ?>
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
        <th>Jumlah</th>
        <th>Jadwal</th>
		<th>Pembayaran Ke</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody>
                <?php
            $start = 1;
            $this->db->where('no_transaksi', $this->uri->segment(3));
            $transfer_data = $this->db->get('jadwal_transfer');
            foreach ($transfer_data->result() as $transfer)
            {
                ?>
                <tr>
			<td width="80px"><?php echo $start ?></td>
			<td><?php echo $transfer->no_transaksi ?></td>
			<td><?php echo get_data('member','id_member',$transfer->id_member,'nama') ?></td>
			<td><?php echo number_format($transfer->nominal) ?></td>
            <td><?php echo $transfer->jadwal_transfer ?></td>
            <td><?php echo $transfer->ke ?></td>
			<td style="text-align:center" width="200px">
				<?php 
                $this->db->where('no_transaksi', $transfer->no_transaksi);
                $this->db->where('ke', $transfer->ke);
                if ($this->db->get('transfer')->num_rows() > 0): ?>
                    <span class="label label-success">Success</span>
                <?php else: ?>
                    <a href="app/transfer_now/<?php echo $transfer->no_transaksi.'/'.$transfer->ke ?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="label label-info">Kirim</a>
                <?php endif ?>
			</td>
		</tr>
                <?php
                $start++;
            }
            ?>
            </tbody>
        </table>
        </div>
        
    