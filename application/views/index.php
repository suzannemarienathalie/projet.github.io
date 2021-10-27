<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>EMAILING</title>
	<link rel="stylesheet" href="<?= base_url('public/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('public/css/mdb.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('public/fonts/FAS/css/all.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('public/css/index.css') ?>">
</head>
<body>

	<div class="left-sidebar">

		<div class="brand text-white p-2">
			<img src="<?= base_url('public/IMAGE/images3.png') ?>">
		</div>
		
		<div class="menu">
			<ul class="menu-list">
				<li class="menu-item p-2 active" data-uri="<?= base_url('') ?>">
					<i class="fas fa-address-book"></i>
					<span class="ml-2">Ajouter contact</span>
				</li>
				<li class="menu-item p-2" data-uri="<?= base_url('campagne') ?>">
					<i class="fas fa-clipboard-list"></i>
					<span class="ml-2">Campagne</span>
				</li>
				<li class="menu-item p-2" data-uri="<?= base_url('send_mail') ?>">
					<i class="fas fa-paper-plane"></i>
					<span class="ml-2">Envoyer email</span>
				</li>

				
			</ul>
		</div>

	</div>
	<div class="main">
			<div class="d-flex justify-content-center align-items-center spinner w-100">
			  <div class="spinner-border" role="status">
			    <span class="sr-only">Loading...</span>
			  </div>
			</div>
	</div>

	


	<script src="<?= base_url('public/js/jquery.min.js') ?>"></script>
	<script src="<?= base_url('public/js/popper.min.js') ?>"></script>
	<script src="<?= base_url('public/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('public/js/mdb.min.js') ?>"></script>
	<script src="<?= base_url('public/fonts/FAS/js/all.min.js') ?>"></script>
	<script src="<?= base_url('public/js/sweetalert2.all.js') ?>"></script>
	<script src="<?= base_url('public/js/utility.js') ?>"></script>
	<script src="<?= base_url('public/js/sendmail.js') ?>"></script>
	<script src="<?= base_url('public/js/campagne.js') ?>"></script>
	<script src="<?= base_url('public/js/index.js') ?>"></script>
</body>
</html>