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