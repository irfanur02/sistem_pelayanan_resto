<body>
  <nav class="navbar sticky-top bg-warning border-body" style="padding: 1em; box-shadow: 5px -4px 6px 6px #888888">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="navbar-brand mb-0 h1" href="<?php echo base_url("pesanan/getMeja/$meja"); ?>">RESTO</a>
      <span class="nav-item mb-0 h5" id="noMeja" data-noMeja="<?php echo $meja; ?>">Meja <?php echo $meja; ?></span>
      <a class="btn btn-sm btn-warning position-relative" href="" role="button" id="lihatPesananku">
        Pesananku
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="ordersMenu" style="display: none;">
          <?php echo ($jumlahPesananMeja != null) ? $jumlahPesananMeja->jumlah : "0"; ?>
        </span>
      </a>
    </div>
  </nav>