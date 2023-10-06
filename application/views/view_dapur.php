<table class="table table-bordered border-dark">
  <thead class="table-dark">
    <tr>
      <th scope="col" class="text-center" style="width: 50%;">MINUMAN</th>
      <th scope="col" class="text-center" style="width: 50%;">MAKANAN</th>
    </tr>
  </thead>
  <tbody id="tabelPesananDapur">
    <tr class="text-center">
      <td>
        <?php foreach ($dataAntrianMinuman as $antrianMinuman) : ?>
          <div class="card text-bg-info border-dark mb-3 kolomMinuman">
            <div class="card-body p-1">
              <?php foreach ($dataDetailAntrianMinuman as $detailMinuman) : ?>
                <?php if ($antrianMinuman->id_antrian_masak == $detailMinuman->id_antrian_masak) : ?>
                  <h4 class="card-text mb-3">
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
            <div class="card-body p-1">
              <?php foreach ($dataDetailAntrianMakanan as $detailMakanan) : ?>
                <?php if ($antrianMakanan->id_antrian_masak == $detailMakanan->id_antrian_masak) : ?>
                  <h4 class="card-text mb-3">
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