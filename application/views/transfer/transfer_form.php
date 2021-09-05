
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">No Transaksi <?php echo form_error('no_transaksi') ?></label>
            <input type="text" class="form-control" name="no_transaksi" id="no_transaksi" placeholder="No Transaksi" value="<?php echo $this->uri->segment(3); ?>" readonly/>
        </div>
	    <div class="form-group">
            <label for="int">Member <?php echo form_error('id_member') ?></label>
            <select class="form-control select2" name="id_member">
                <option value="">Pilih Member</option>
                <?php foreach ($this->db->get('member')->result() as $rw): ?>
                    <option value="<?php echo $rw->id_member ?>"><?php echo $rw->nama ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="keterangan">Keterangan <?php echo form_error('keterangan') ?></label>
            <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="date">Tanggal <?php echo form_error('tanggal') ?></label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" />
        </div>
	    <div class="form-group">
            <label for="time">Jam <?php echo form_error('jam') ?></label>
            <input type="time" class="form-control" name="jam" id="jam" placeholder="Jam" value="<?php echo $jam; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Jumlah <?php echo form_error('jumlah') ?></label>
            <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php echo $jumlah; ?>" />
        </div>
        <div class="form-group">
            <label>Jenis Transfer</label>
            <select name="jenis" class="form-control" required="">
                <option value="">Pilih</option>
                <option value="member">Member</option>
                <option value="bonus agen">Bonus Agen</option>
            </select>
        </div>
        <div class="form-group">
            <label for="int">Pembayaran ke- </label>
            <input type="number" class="form-control" name="ke" id="ke" placeholder="Ex: 1" value="<?php echo $ke; ?>" required/>
        </div>
	    
	    <input type="hidden" name="id_transfer" value="<?php echo $id_transfer; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	</form>
   