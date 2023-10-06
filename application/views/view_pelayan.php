<table class="table table-bordered border-dark">
  <thead class="table-dark">
    <tr>
      <th scope="col" class="text-center" style="width: 50%;">MINUMAN</th>
      <th scope="col" class="text-center" style="width: 50%;">MAKANAN</th>
    </tr>
  </thead>
  <tbody id="tabelPesananPelayan">
    <tr class="text-center">
      <td>
        <?php foreach ($dataAntrianMinuman as $antrianMinuman) : ?>
          <div class="card text-bg-info border-dark mb-3 kolomMinuman">
            <div class="card-header bg-danger h4">MEJA <?php echo $antrianMinuman->no_meja; ?></div>
            <span style="position: absolute; background-color: rgba(255, 255, 255, 0); top: 0; bottom: 0; left: 0; right: 0;"></span>
            <div class="card-body p-1">
              <?php foreach ($dataDetailAntrianMinuman as $detailMinuman) : ?>
                <?php if ($antrianMinuman->id_antrian_masak == $detailMinuman->id_antrian_masak) : ?>
                  <h4 class="card-text mb-3" data-idMenu="<?php echo $detailMinuman->id_menu ?>" data-idPesanan="<?php echo $detailMinuman->id_pesanan; ?>" data-idAntrian="<?php echo $detailMinuman->id_antrian_masak; ?>">
                    <label class="form-check-label">
                      <?php echo $detailMinuman->nama_menu; ?>: <?php echo $detailMinuman->jumlah; ?>
                    </label>
                  </h4>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </td>
      <td>
        <?php foreach ($dataAntrianMakanan as $antrianMakanan) : ?>
          <div class="card text-bg-info border-dark mb-3 kolomMakanan">
            <div class="card-header bg-danger h4">MEJA <?php echo $antrianMakanan->no_meja; ?></div>
            <span style="position: absolute; background-color: rgba(255, 255, 255, 0); top: 0; bottom: 0; left: 0; right: 0;"></span>
            <div class="card-body p-1">
              <?php foreach ($dataDetailAntrianMakanan as $detailMakanan) : ?>
                <?php if ($antrianMakanan->id_antrian_masak == $detailMakanan->id_antrian_masak) : ?>
                  <h4 class="card-text mb-3" data-idMenu="<?php echo $detailMakanan->id_menu ?>" data-idPesanan="<?php echo $detailMakanan->id_pesanan; ?>" data-idAntrian="<?php echo $detailMakanan->id_antrian_masak; ?>">
                    <label class="form-check-label">
                      <?php echo $detailMakanan->nama_menu; ?>: <?php echo $detailMakanan->jumlah; ?>
                    </label>
                  </h4>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </td>
    </tr>
  </tbody>
</table>