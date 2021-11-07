<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<div class="sidebar-brand d-flex align-items-center justify-content-center mt-1">
		<div class="sidebar-brand-icon">
			<i class="fas fa-user-shield fa-1x"></i>
		</div>
		<div class="sidebar-brand-text mx-1 small font-weight-bold">Área de Administração</div>
	</div>

	<!-- Divider -->
	<hr class="sidebar-divider my-3">

	<!-- Heading -->
	<div class="sidebar-heading mt-3">
		Painel de Controlo
	</div>

	<!-- Nav Item - Dashboard -->
	<li class="nav-item active">
		<a class="nav-link" href="index.php">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Ver painel de controlo</span>
		</a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider my-3">

	<!-- Heading -->
	<div class="sidebar-heading mt-3">
		Notícias
	</div>

	<!-- Nav Item - Dashboard -->
	<li class="nav-item">
		<a class="nav-link" href="publish.php">
			<i class="fas fa-fw fa-edit"></i>
			<span>Publicar notícias</span>
		</a>
	</li>

	<!-- Nav Item - Dashboard -->
	<li class="nav-item">
		<a class="nav-link" href="news.php">
			<i class="far fa-fw fa-newspaper"></i>
			<span>Gerir notícias</span>
		</a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider my-3">

	<!-- Heading -->
	<div class="sidebar-heading mt-3">
		Registo de atividade
	</div>

	<!-- Nav Item - Dashboard -->
	<li class="nav-item">
		<a class="nav-link" href="logs.php">
			<i class="far fa-fw fa-file-alt"></i>
			<span>Ver registo de atividade</span>
		</a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider my-3">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>
<!-- End of Sidebar -->

<script>
	// handle active nav items
	Array.from(document.getElementsByClassName("nav-item")).forEach(elem => {
		elem.classList.remove("active");
		if (elem.children[0].pathname.split('.')[0] === window.location.pathname)
			elem.classList.add("active");
	});

</script>