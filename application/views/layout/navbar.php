<nav class="main-header navbar navbar-expand navbar-dark navbar-purple">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="index3.html" class="nav-link">Contabilidad</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="#" class="nav-link">Finanzas</a>
		</li>
	</ul>

	<!-- SEARCH FORM -->
	<!--	<form class="form-inline ml-3">-->
	<!--		<div class="input-group input-group-sm">-->
	<!--			<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">-->
	<!--			<div class="input-group-append">-->
	<!--				<button class="btn btn-navbar" type="submit">-->
	<!--					<i class="fas fa-search"></i>-->
	<!--				</button>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</form>-->

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown user user-menu">
			<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
				<img src="<?php echo base_url() ?>assets/img/admin/avatar04.png"
					 class="user-image img-circle elevation-2 alt=" User Image">
				<span class="hidden-xs"><?php echo $this->session->userdata('name')?></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<!-- User image -->
				<li class="user-header bg-purple">
					<img src="<?php //echo image_user($this->session->userdata("id")) ?>" class="img-circle elevation-2"
						 alt="User Image">

					<p>
						<?php echo $this->session->userdata('name')?>
						<small><?php echo $this->session->userdata('email')?></small>
					</p>
				</li>
				<li class="user-footer">
					<div class="pull-right">
						<a href="<?php echo base_url() ?>auth/logout" class="btn btn-default btn-flat">Salir</a>
					</div>
				</li>
			</ul>
		</li>
	</ul>
</nav>
