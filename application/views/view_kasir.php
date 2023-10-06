<!-- <div class="container mt-5 mb-5 text-center d-flex flex-column align-items-center">
  <div class="row mb-3">
    <div class="col">
      <select class="form-select" style="width: max-content; font-weight: bolder;" id="kasirSelectMeja">
        <option selected>Pilih Meja</option>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <table class="table" style="width: max-content;">
        <thead class="table-dark">
          <tr>
            <th scope="col">Menu</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Harga</th>
          </tr>
        </thead>
        <tbody id="tabelDetailPesanan">
        </tbody>
      </table>
    </div>
  </div>
  <div class="row mb-3" id="modelBayar">
  </div>
</div> -->
<div class="container mt-5 mb-5 text-center d-flex justify-content-center">
  <table>
    <tr>
      <td style="padding: 15px;">
        <table class="table table-sm" style="width: max-content;">
          <thead>
            <tr>
              <th>Meja yang Terisi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="d-flex flex-column gap-1" style="height: 40vh; overflow-x: scroll;">
                <?php if ($dataPesananMeja == null) : ?>
                  <div class="card card-body">
                    <p style="font-size: .8em;">Tidak Ada Pelanggan</p>
                  </div>
                <?php endif; ?>
                <?php foreach ($dataPesananMeja as $dataMeja) : ?>
                  <button class="btn btn-sm btn-primary btnKasirSelectMeja" type="button" data-idPesanan="<?php echo $dataMeja->id_pesanan; ?>" data-idMeja="<?php echo $dataMeja->id_meja; ?>">Meja <?php echo $dataMeja->no_meja; ?></button>
                <?php endforeach; ?>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
      <td class="border-start border-end" style="padding: 15px;">
        <p class="fs-5">Pesanan Meja</p>
        <table class="table" style="width: max-content;">
          <thead class="table-dark">
            <tr>
              <th scope="col">Menu</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Harga</th>
            </tr>
          </thead>
          <tbody id="tabelDetailPesanan" style="height: 10%; overflow-x: scroll;">
          </tbody>
        </table>
        <div class="mt-3 mb-3" id="modelBayar">
        </div>
      </td>
      <td style="padding: 15px;">
        efwe
      </td>
    </tr>
  </table>
</div>

<!-- Modal radio Bayar Tunai-->
<div class="modal fade" id="modalBayarTunai" tabindex="-1" aria-labelledby="modalBayarTunaiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalBayarTunaiModalLabel">Kalkulator</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <span class="h4" style="color: red;">Total Harga: Rp. <span id="modalTotalHargaMenu"></span></span>
        <div class="mb-3 mt-3">
          <label for="inputUangTunai" class="form-label h5">Uang Tunai</label>
          <input type="number" class="form-control text-center form-control-lg no-spinners" id="inputUangTunai" style="font-weight: bolder;" autofocus>
        </div>
        <div class="mb-3 mt-3">
          <label for="inputKembalianUangTunai" class="form-label h5">Kembalian</label>
          <input type="text" class="form-control text-center form-control-lg" id="inputKembalianUangTunai" style="font-weight: bolder;" disabled>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnCetakBayarTunai">Cetak</button>
      </div>
    </div>
  </div>
</div>