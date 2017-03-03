<!-- / Hero subheader -->
<table class="container hero-subheader" border="0" cellpadding="0" cellspacing="0" width="620" style="width: 620px;">
	<tr>
		<td class="hero-subheader__title" style="font-size: 20px; font-weight: bold; padding: 20px 0 15px 0;" align="left"></td>
	</tr>

	<tr>
		<td class="hero-subheader__content" style="font-size: 16px; line-height: 27px; color: #969696; padding: 0 60px 30px 0;" align="left">
			Hi <?php echo ucwords(strtolower($row->nama)) ?>, <br/>
			Anda telah terdaftar di <?php echo $this->Config_Model->get_app_name_url() ?> sebagai pelamar.<br/> 
			Dengan detail informasi sebagai berikut.<br/>
			<ul>
				<li>ID : <?php echo $row->id_pelamar ?></li>
				<li>Nama : <?php echo ucwords(strtolower($row->nama)) ?></li>
				<li>Email : <?php echo $row->email ?></li>
				<li>Password : <?php echo $row->pass_view ?></li>
			</ul>
			Perbaruilah profil Anda dengan login di <a href="<?php echo base_url('login/masuk') ?>"><?php echo base_url('login/masuk') ?></a> dan carilah lowongan yang sesuai.<br/>
			Salam Hangat,<br/>
			<?php echo $this->Config_Model->get_app_name() ?>
		</td>
	</tr>
</table>
<!-- /// Hero subheader -->