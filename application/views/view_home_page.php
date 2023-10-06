<div class="container mt-5 mb-5">
	<h5 class="text-center">Pilihan Menu</h5>
	<div class="d-flex justify-content-center flex-wrap">
		<?php foreach ($dataMenu as $rowDataMenu) : ?>
			<div class="card card-menu" style="width: 10rem; margin: .5rem;">
				<img src="<?php echo base_url("assets/img/") ?><?php echo $rowDataMenu->gambar_menu; ?>" class="card-img-top" alt="...">
				<div class="card-body">
					<h6 class="card-title"><?php echo $rowDataMenu->nama_menu; ?></h6>
					<p class="card-text harga">Rp. <?php echo $rowDataMenu->harga_menu; ?></p>
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">
						<div class="row">
							<div class="col d-flex justify-content-between">
								<button type="button" class="btn btn-sm btn-primary btnMinusMenu">
									<p class="h6">-</p>
								</button>
								<input type="text" class="form-control jumlah inputJumlahMenu" value="0">
								<button type="button" class="btn btn-sm btn-primary btnPlusMenu">
									<p class="h6">+</p>
								</button>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col">
								<button type="button" class="btn btn-sm btn-success btnSelectMenu" value="<?php echo $rowDataMenu->id_menu; ?>" style="width: 100%; display: none;">
									<p class="h6">Pilih</p>
								</button>
							</div>
						</div>
					</li>
				</ul>
			</div>
		<?php endforeach; ?>
	</div>
</div>