<div class="d-flex flex-column">
	<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		PesananKu Sedang Dimasak
		<input type="hidden" id="idPesanan" value="<?php echo $idPesanan; ?>">
		<span class="badge rounded-pill text-bg-danger" id="jumlahPesananDimasak"><?php echo ($jumlahPesananMejaByMasak != null) ? $jumlahPesananMejaByMasak->jumlah : "0"; ?></span>
	</button>
	<div class="collapse" id="collapseExample">
		<div class="card card-body align-items-center">
			<?php if ($dataPesananMeja != null) : ?>
				<table class="table table-sm text-center" style="max-width: max-content; width: max-content;">
					<thead class="table-dark">
						<tr>
							<th scope="col">Menu</th>
							<th scope="col">Jumlah</th>
							<th scope="col">Harga</th>
						</tr>
					</thead>
					<tbody id="tabelPesananUser">
						<?php foreach ($dataPesananMeja as $dataItem) : ?>
							<tr>
								<td>
									<span class="d-inline-flex gap-1">
										<img src="<?php echo base_url("assets/img/" . $dataItem->gambar_menu); ?>" class="img-fluid" alt="..." style="width: 50px;">
										<span>
											<?php echo $dataItem->nama_menu; ?>
											<br>
											<?php foreach ($dataPesananMejaByMasak as $dataItemMasak) : ?>
												<?php if ($dataItem->id_menu == $dataItemMasak->id_menu) : ?>
													<span class="badge rounded-pill text-bg-success"><?php echo $dataItemMasak->jumlah; ?> Sedang Dimasak</span>
												<?php endif; ?>
											<?php endforeach; ?>
										</span>
									</span>
								</td>
								<td><?php echo $dataItem->jumlah; ?></td>
								<td>Rp. <?php echo $dataItem->harga_menu; ?></td>
							</tr>
						<?php endforeach; ?>
						<tr style="font-weight: bolder;">
							<td colspan="2" class="table-active">Total Harga</td>
							<td>Rp. <span id="totalHargaMenu"><?php echo ($dataTotalHargaPesanan != null) ? $dataTotalHargaPesanan->total_harga : "0"; ?></span></td>
						</tr>
					</tbody>
				</table>
			<?php endif; ?>
			<?php if ($dataTotalHargaPesanan == null) : ?>
				<div class="card card-body align-items-center">
					Belum Pesan
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="container mt-5 mb-5 text-center">
	<h5 class="">Akan Pesan</h5>
	<div class="container d-flex flex-column align-items-center flex-nowrap">
		<?php foreach ($pesananMejaByPilih as $dataItem) : ?>
			<div class="card mb-2">
				<div class="card-body p-0">
					<div class="row">
						<div class="col">
							<img src="<?php echo base_url("assets/img/" . $dataItem->gambar_menu); ?>" class="img-fluid" alt="...">
						</div>
						<div class="col m-2">
							<p class="card-title"><?php echo $dataItem->nama_menu; ?></p>
							<div class="row">
								<div class="col d-flex justify-content-between">
									<button type="button" class="btn btn-sm btn-primary btnMinusOrder">
										<p class="h6">-</p>
									</button>
									<input type="text" class="form-control jumlah" name="jumlah" value="<?php echo $dataItem->jumlah; ?>">
									<input type="hidden" class="form-control jumlah" name="idMenu" value="<?php echo $dataItem->id_menu; ?>">
									<button type="button" class="btn btn-sm btn-primary btnPlusOrder">
										<p class="h6">+</p>
									</button>
								</div>
							</div>
						</div>
						<div class="col">
							<button type="button" class="btn btn-sm btn-danger btnDeleteMenuOrder" data-idMenu="<?php echo $dataItem->id_menu; ?>" data-idPesanan="<?php echo $dataItem->id_pesanan; ?>" style="height: 100%;">
								<p class="h6">Hapus</p>
							</button>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		<?php if ($pesananMejaByPilih != null) : ?>
			<button type="button" data-idPesanan="<?php echo $idPesanan; ?>" class="btn btn-sm btn-success mt-4" id="btnPesanMenu">
				<p class="h6">PESAN</p>
			</button>
		<?php endif ?>
	</div>
</div>