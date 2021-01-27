

	<div id="content">      
    	<h1><?php echo $page_title; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
       </h1>
        
		
		<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>
    
        <table class="narrow">
        	<tr>
 	            <th>Kode SKPD </th>            	
                <th>Nama SKPD</th>                
                <th>Aksi</th>
            </tr>
            <?php foreach($list->result() as $skpd) : ?>
            <tr>                
                <td><?php echo $skpd->kd_skpd; ?></td>            	
                <td><?php echo $skpd->nm_skpd; ?></td>  
                <td>                     
                    <a href="<?php echo site_url(); ?>/rka_blud/preview_rka1/<?php echo $skpd->kd_skpd; ?>/<?php echo '1';?> "target='_blank'><img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a href="<?php echo site_url(); ?>/rka_blud/preview_rka1/<?php echo $skpd->kd_skpd; ?>/<?php echo '2';?> "target='_blank'><img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
                    <a href="<?php echo site_url(); ?>/rka_blud/preview_rka1/<?php echo $skpd->kd_skpd; ?>/<?php echo '3';?> "target='_blank'><img src="<?php echo base_url(); ?>assets/images/icon/word.jpg" width="25" height="23" title="cetak"/>
                    </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="clear"></div>
	</div>