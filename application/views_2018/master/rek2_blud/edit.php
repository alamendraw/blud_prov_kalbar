<div id="content">
	<h1><?php echo $page_title; ?><span><a href="<?php echo site_url(); ?>/master/rek2_blud">Kembali</a></span></h1>

	<?php echo form_open('master/edit_rek2_blud/'.$rek2->kd_rek2, array('class' => 'basic')); ?>
    <table class="form">
    	<tr>
        	<td><label>Kode Rekening 2</label><br /><input name="kd_rek2" type="text" id="kd_rek2" value="<?php echo $rek2->kd_rek2; ?>" size="10" /> <?php echo form_error('kd_rek2'); ?>
            </td>
        </tr>
        <tr>
            <td><label>Nama Rekening 2</label><br />
            <input name="nm_rek2" type="text" id="nm_rek2" value="<?php echo $rek2->nm_rek2; ?>" size="60" />
            <?php echo form_error('ms_rek2'); ?>
            </td>
        </tr>
        <tr>
            <td><input name="simpan" type="submit" id="simpan" value="Simpan" class="btn" /><input name="reset" type="reset" id="reset" value="Reset" class="btn" /></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>