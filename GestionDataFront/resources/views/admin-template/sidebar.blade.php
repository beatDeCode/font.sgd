<body>
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
      <div class="sidebar-brand d-none d-md-flex">
        <img src="/img/logo.png">
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
		<li class="nav-item">
			<a class="nav-link active">
				<svg class="nav-icon">
				<use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
				</svg> Menú Principal
			</a></li>
      {!!App\Http\Controllers\core\AutenticacionController::fnArmarSideBar()!!}
      </ul>
      <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>