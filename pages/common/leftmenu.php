<div id="layoutSidenav_nav">
	<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
		<div class="sb-sidenav-menu">
			<div class="nav">
				<!--<div class="sb-sidenav-menu-heading">Core</div>-->
				<a class="nav-link <?php if($p == 'dashboard'){?>active<?php } ?>" href="?p=dashboard">
					<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
					Dashboard
				</a>
				<!--<div class="sb-sidenav-menu-heading">Interface</div>-->

				<a class="nav-link collapsed <?php if($p == 'items' || $p == 'item_stock' || $p == 'customers'){?>active<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
					<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
					Master Entry
					<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
				</a>
				<div class="collapse  <?php if($p == 'items' || $p == 'item_stock' || $p == 'customers'){?>show<?php } ?>" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
					<nav class="sb-sidenav-menu-nested nav">
					<a class="nav-link <?php if($p == 'items'){?>active<?php } ?>" href="?p=items">Items</a>
					<a class="nav-link <?php if($p == 'item_stock'){?>active<?php } ?>" href="?p=item_stock">Item Stock</a>
					<a class="nav-link <?php if($p == 'customers'){?>active<?php } ?>" href="?p=customers">Customers</a>					
					</nav>
				</div>	

				<a class="nav-link collapsed <?php if($p == 'bill' || $p == 'todays-bill'){?>active<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1">
					<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
					Bill Details
					<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
				</a>
				<div class="collapse  <?php if($p == 'bill' || $p == 'todays-bill'){?>show<?php } ?>" id="collapseLayouts1" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
					<nav class="sb-sidenav-menu-nested nav">
					<a class="nav-link <?php if($p == 'todays-bill'){?>active<?php } ?>" href="?p=todays-bill">Today's Bill</a>
					<!--<a class="nav-link <?php if($p == 'bill'){?>active<?php } ?>" href="?p=bill">Old Bill List</a>-->				
					</nav>
				</div>	

				<a class="nav-link collapsed <?php if($p == 'item_stock_report'){?>active<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1">
					<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
					Reports
					<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
				</a>
				<div class="collapse  <?php if($p == 'item_stock_report'){?>show<?php } ?>" id="collapseLayouts1" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
					<nav class="sb-sidenav-menu-nested nav">
					<a class="nav-link <?php if($p == 'item_stock_report'){?>active<?php } ?>" href="?p=item_stock_report">Item Stock</a>			
					</nav>
				</div>		
				
				
			</div>
		</div>
	</nav>
</div>