<script type="text/javascript">
    $(document).ready(function(){
        $('#tambah').click(function(){
            var site_url = $(this).attr("name");
            window.location = site_url+"/master/tambah_user";
        });
    });
</script>

<style type="text/css">
      #content{
            padding-top:30px;
        }

        .form-table{
            width: 100%;
        }

        .form-table tr td:first-child{
            width: 20%;
            text-align: right;
            padding-right: 10px;
        }

        .form-table tr td:nth-child(2){
            width: 2%;
        }


         .form-table tr td > select{
            min-width: 100px;
            margin: 0;
        }

         .form-table tr td > input[type="submit"]{
            min-width: 70px;
        }

        .btn{
            border: none;
            background: #428bca;
            color: white;
            padding: 10px 20px;
            display: inline-block;
        }

        .btn{
            text-decoration: none;
        }
         #kanan{
        float: right;
    }
</style>

<div id="content">
    	<h1><?php echo $page_title; ?></h1>
	<?php echo form_open('master/cari_user', array('class' => 'basic')); ?>
	Karakter yang di cari :&nbsp;&nbsp;&nbsp;<input type="text" name="pencarian" id="pencarian" value="<?php echo set_value('text'); ?>" />
        <input type='submit' name='cari' value='cari' class='btn' />
        <?php echo form_close(); ?>
	<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
        <div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
        <?php endif; ?>

        
        <div class='btn' id="tambah" name="<?php echo site_url(); ?>">Tambah User</div>
        
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div id="kanan">
            <a href="<?php echo site_url(); ?>/master/user_group" id="group"><img src="<?php echo base_url(); ?>easyui/themes/default/images/settings-icon.png"> &nbsp;<b>Konfigurasi Group</b></a>
        </div>

        <table class="narrow">
        	<tr>
            	<th>ID </th>
                <th>User Name</th>
                <th>Nama Lengkap</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($list->result() as $user) : ?>
            <tr>
            	<td><?php echo $user->id_user; ?></td>
                <td><?php echo $user->user_name; ?></td>
                <td><?php echo $user->nama; ?></td>
                <td>

                
            <a href="<?php echo site_url(); ?>/master/edit_user/<?php echo $user->id_user; ?>" title="Edit"><img src="<?php echo base_url(); ?>assets/images/icon/edit.png" /></a>
                &nbsp;&nbsp;
            <a href="<?php echo site_url(); ?>/master/hapus_user/<?php echo $user->id_user; ?>" title="Hapus"><img src="<?php echo base_url(); ?>assets/images/icon/cross.png" /></a>
                 
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php echo $this->pagination->create_links(); ?> <span class="totalitem">Total Item <?php echo $total_rows ; ?></span>
        <div class="clear"></div>
	</div>