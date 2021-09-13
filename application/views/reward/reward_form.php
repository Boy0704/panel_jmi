
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	    <div class="form-group">
            <label for="int">Target <?php echo form_error('target') ?></label>
            <input type="text" class="form-control" name="target" id="target" placeholder="Target" value="<?php echo $target; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Bonus Tunai <?php echo form_error('bonus_tunai') ?></label>
            <input type="text" class="form-control" name="bonus_tunai" id="bonus_tunai" placeholder="Bonus Tunai" value="<?php echo $bonus_tunai; ?>" />
        </div>
	    <div class="form-group">
            <label for="keterangan">Keterangan <?php echo form_error('keterangan') ?></label>
            <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="varchar">Gambar <?php echo form_error('gambar') ?></label>
            <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar" value="<?php echo $gambar; ?>" />
            <input type="hidden" name="foto_old" value="<?php echo $gambar ?>">
            <div>
                <?php if ($gambar != ''): ?>
                    <b>*) Foto Sebelumnya : </b><br>
                    <img src="image/reward/<?php echo $gambar ?>" style="width: 100px;">
                <?php endif ?>
            </div>
        </div>
	    <input type="hidden" name="id_reward" value="<?php echo $id_reward; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('reward') ?>" class="btn btn-default">Cancel</a>
	</form>
   