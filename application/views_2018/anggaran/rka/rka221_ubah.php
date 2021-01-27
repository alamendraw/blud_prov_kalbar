<div id="content">        
    	<h1><?php echo $page_title; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
       </h1>
        <?php echo form_open('rka_blud/cari221', array('class' => 'basic')); ?>
		Karakter yang di cari :&nbsp;&nbsp;&nbsp;<input type="text" name="nm_skpd" id="nm_skpd" value="<?php echo set_value('text'); ?>" />
        <input type='submit' name='cari' value='cari' class='btn' />
        <?php echo form_close(); ?>   
		
		TTD Anggaran :   
									<select>
										<option value=""></option>
									<?php foreach($ttdpa->result() as $ttd_pa) : ?>
									  <option value="<?php echo $ttd_pa->nip; ?>"><?php  echo $ttd_pa->nama; ?></option>
									</select> 
									 <?php endforeach; ?>
		
		<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
        <table class="narrow">
        	<tr>
 	            <th>Kode BLUD</th>            	
                <th>Nama BLUD</th>                
                <th>Aksi</th>
            </tr>
            <?php foreach($list->result() as $skpd) : ?>
            <tr>
                <td><?php echo $skpd->kd_kegiatan; ?></td>            	
                <td><?php echo $skpd->nm_kegiatan; ?></td>  
                <td>                     
                    <a href="<?php echo site_url(); ?>/rka_blud/preview_rba_ubah/<?php echo $skpd->kd_skpd; ?>/<?php echo $skpd->kd_kegiatan; ?>/<?php echo $ttd_pa->nip; ?>" target='_blank'><img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php echo $this->pagination->create_links(); ?> <span class="totalitem">Total Item <?php echo $total_rows ;  ?></span>
        <div class="clear"></div>
	</div>