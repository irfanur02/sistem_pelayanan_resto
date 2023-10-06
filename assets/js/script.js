var base_url = "http://localhost:81/sistem-pelayanan-resto/";
var currentUrl = window.location.href;

// buat token
const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+=-';
function token(length) {
  let result = '';
  const charactersLength = characters.length;
  for ( let i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

var today = new Date();
var month = today.getMonth()+1;
var day = today.getDate();
var date = today.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;

if($('#noMeja')[0] != undefined) {
  var noMeja = $('#noMeja')[0].getAttribute('data-noMeja');
  if (localStorage.tokenPesanan) {
    if (currentUrl.includes("viewDetailPesanan")) {
      $('#ordersMenu')[0].style.display = "block";
    } else {
      $.ajax({
        type: "POST",
        url: base_url + "pesanan/cekPesananToken",
        data: {tokenPesanan: localStorage.getItem("tokenPesanan"), noMeja:noMeja},
        dataType: "json",
        success: function(response) {
          console.log(response.dataIdPesanan);
          if (response.cekToken == "true") {
            console.log("selamat datang kembali");
          }
          $('#ordersMenu')[0].style.display = "block";
          $('#ordersMenu')[0].innerHTML = response.dataJumlahPesanan;
          $('#lihatPesananku').attr('href', base_url + "pesanan/viewDetailPesanan/" + response. dataIdPesanan);
        }
      });
    }
  } else {
    localStorage.setItem("tokenPesanan", token(11));
    localStorage.setItem("tanggalToken", date);
    $.ajax({
      type: "POST",
      url: base_url + "pesanan/addMejaPesanan",
      data: {tokenPesanan: localStorage.getItem("tokenPesanan"), noMeja: noMeja},
      dataType: "json",
      success: function(response){
        console.log(response.status);
        if (response.status = 'sukses') {
          if (response.cekToken == "true") {
            console.log("hai pelanggan baru");
          }
          $('#ordersMenu')[0].innerHTML = response.dataJumlahPesanan;
          $('#ordersMenu')[0].style.display = "block";
          $('#lihatPesananku').attr('href', base_url + "pesanan/viewDetailPesanan/" + response.dataIdPesanan);
        }
      }
    });
  }
}

$('.btnPlusMenu').on('click', function() {
  var jumlah = this.parentElement.getElementsByClassName('jumlah')[0].value;
  this.parentElement.getElementsByClassName('jumlah')[0].value = parseInt(jumlah) + 1;
  this.parentElement.parentElement.parentElement.getElementsByClassName('btnSelectMenu')[0].style.display = "block";
});

$('.btnMinusMenu').on('click', function() {
  var jumlah = this.parentElement.getElementsByClassName('jumlah')[0].value;
  if (parseInt(jumlah) > 0 ) {
    this.parentElement.getElementsByClassName('jumlah')[0].value = parseInt(jumlah) - 1;
    if (parseInt(this.parentElement.getElementsByClassName('jumlah')[0].value) == 0 ) {
      this.parentElement.parentElement.parentElement.getElementsByClassName('btnSelectMenu')[0].style.display = "none";
    }
  }
});

$('.btnPlusOrder').on('click', function() {
  var jumlah = this.parentElement.getElementsByClassName('jumlah')[0].value;
  this.parentElement.getElementsByClassName('jumlah')[0].value = parseInt(jumlah) + 1;
});

$('.btnMinusOrder').on('click', function() {
  var jumlah = this.parentElement.getElementsByClassName('jumlah')[0].value;
  if (parseInt(jumlah) > 0 ) {
    this.parentElement.getElementsByClassName('jumlah')[0].value = parseInt(jumlah) - 1;
  }
});

$('.btnSelectMenu').on('click', function() {
  var noMeja = $('#noMeja')[0].getAttribute('data-noMeja');
  var idMenu = $(this).val();
  var jumlah = this.parentElement.parentElement.parentElement.getElementsByClassName('jumlah')[0];
  var btn = $(this);
  $.ajax({
    type: "POST",
    url: base_url + "pesanan/addItemPesanan",
    data: {noMeja: noMeja, tokenPesanan: localStorage.getItem("tokenPesanan"), jumlahItemMenu: jumlah.value, idMenu: idMenu},
    dataType: "json",
    success: function(response){
      console.log(response.data);
      if (response.status == 'sukses') {
        btn[0].style.display = "none"
        var ordersMenu = $('#ordersMenu')[0].textContent;
        ordersMenu = parseInt(ordersMenu) + parseInt(jumlah.value);
        $('#ordersMenu')[0].innerHTML = ordersMenu;
        const Toast = Swal.mixin({
          toast: true,
          position: 'bottom',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
        Toast.fire({
          icon: 'success',
          title: 'Menu Berhasil Ditambahkan'
        });
        jumlah.value = 0;
      }
    }
  });
});

$('.btnDeleteMenuOrder').on('click', function() {
  const containerCardMenuOrder = this.parentElement.parentElement.parentElement.parentElement.parentElement;
  const delCardMenuOrder = this.parentElement.parentElement.parentElement.parentElement;
  var jumlah = this.parentElement.parentElement.getElementsByClassName('jumlah')[0].value;
  var ordersMenu = $('#ordersMenu')[0].textContent;
  var idMenu = $(this).attr('data-idMenu');
  var idPesanan = $(this).attr('data-idPesanan');
  $('#ordersMenu')[0].innerHTML = parseInt(ordersMenu) - parseInt(jumlah);
  $.ajax({
    type: "POST",
    url: base_url + "pesanan/deleteItemPesanan",
    data: {idPesanan: idPesanan, idMenu: idMenu},
    dataType: "json",
    success: function(response){
      containerCardMenuOrder.removeChild(delCardMenuOrder);
      $('#ordersMenu')[0].innerHTML = parseInt(ordersMenu) - parseInt(jumlah);
    }
  });
})

$('#modalBayarTunai').on('hidden.bs.modal', function() {
  $('#inputUangTunai').val("");
  $('#inputKembalianUangTunai').val("");
})
$('#modalBayarTunai').on('shown.bs.modal', function() {
  const totalHarga = $('#totalHargaMenu').text();
  $('#modalTotalHargaMenu').text(totalHarga);
  $('#inputUangTunai').attr('autofocus', 'true');
})

$('#inputUangTunai').on('input', function() {
  var uangTunai = $(this).val();
  var textTotalHarga = $('#modalTotalHargaMenu').text();
  var totalHarga = textTotalHarga.replace(".", "");
  var kembaliUangTunai = parseInt(uangTunai) - parseInt(totalHarga);
  $('#inputKembalianUangTunai').val(kembaliUangTunai).currency({
    thousands:".",
    decimals:0,
    hidePrefix:true,
  });
})

$('#btnPesanMenu').on('click', function() {
  var noMeja = $('#noMeja')[0].getAttribute('data-noMeja');
  var jumlah = this.parentElement.parentElement.getElementsByClassName('jumlah');
  var idPesanan = $(this).attr('data-idPesanan');
  var dataIdMenu =[], dataJumlah =[];
  Array.from(jumlah).forEach(function (element, i) {
    if(element.getAttribute('name') == 'idMenu') dataIdMenu.push(element.value)
    if(element.getAttribute('name') == 'jumlah') dataJumlah.push(element.value)
  });
  $.ajax({
    type: "POST",
    url: base_url + "antrianMasak/masukAntrianMasak",
    data: {noMeja: noMeja, idPesanan: idPesanan, dataIdMenu: dataIdMenu, dataJumlah: dataJumlah},
    dataType: "json",
    success: function(response){
      // console.log(response.data);
      location.reload(true);
    }
  });
})

$(document).on("click", ".cbDoneItemIdMenuPelayan", function() {
  var idMenu = (this).getAttribute('data-idMenu');
  var idPesanan = (this).getAttribute('data-idPesanan');
  var idAntrian = (this).getAttribute('data-idAntrian');
  var cbDoneItemMenu = (this);
  $.ajax({
    type: "POST",
    url: base_url + 'antrianMasak/updateIdstatusPesananSelesai',
    data: {idMenu: idMenu, idPesanan: idPesanan, idAntrian: idAntrian},
    dataType: "json",
    success: function(response) {
      if (response.status == 'sukses') {
        var tdCardMenu = cbDoneItemMenu.parentElement.parentElement.parentElement;
        var CardBody = cbDoneItemMenu.parentElement.parentElement;
        var cardItemMenu = cbDoneItemMenu.parentElement;
        var itemMenu = cardItemMenu.getElementsByTagName('h4');
        if (itemMenu.length == 1) {
          tdCardMenu.removeChild(CardBody);
          if (tdCardMenu.children[0] != undefined) {
            var nextCardBody = tdCardMenu.children[0];
            var openBlockSpan = tdCardMenu.getElementsByTagName('span')[0];
            nextCardBody.removeChild(openBlockSpan);
            tdCardMenu.getElementsByTagName('div')[0].classList.remove('text-bg-info');
            tdCardMenu.getElementsByTagName('div')[0].classList.add('text-bg-warning');
            tdCardMenu.getElementsByTagName('div')[1].classList.remove('bg-info');
            tdCardMenu.getElementsByTagName('div')[1].classList.add('bg-danger');
            var cardBody = tdCardMenu.getElementsByClassName('card-body');
            var inputCb = cardBody[0].getElementsByTagName('h4');
            for (let i = 0; i < inputCb.length; i++) {
              inputCb[i].classList.add('cbDoneItemIdMenuPelayan');
              var input = document.createElement('input');
              input.setAttribute("class", "form-check-input");
              input.setAttribute("type", "checkbox");
              input.setAttribute("value", "");
              inputCb[i].appendChild(input)
            }
          }
        } else {
          cardItemMenu.removeChild(cbDoneItemMenu);
        }
      }
    }
  })
})

// ---------- KASIR
$('.btnKasirSelectMeja').on('click', function() {
  var idPesanan = (this).getAttribute('data-idPesanan');
  // console.log(idPesanan);
  $.ajax({
    type: "POST",
    url: base_url + 'pembayaran/getPesananMeja',
    data: {idPesanan: idPesanan},
    success: function(response) {
      $('#tabelDetailPesanan').html(response);
      var childModelBayar = document.querySelectorAll('#modelBayar .col')[0];
      // console.log(childModelBayar);
      if(childModelBayar == undefined) {
        $('#modelBayar').append(`<div class="col">
            <div class="row">
              <div class="col">
                <span style="font-weight: bolder;">Pembayaran</span>
              </div>
            </div>
            <div class="row text-center">
              <div class="col g-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBayarTunai">
                  Tunai
                </button>
                <button type="button" class="btn btn-primary">
                  Non-Tunai
                </button>
              </div>
            </div>
          </div>`)
      }
    }
  })
})

// $('#kasirSelectMeja').on('change', function() {
//   if ($(this).val() != "Pilih Meja") {
//     var childModelBayar = document.querySelectorAll('#modelBayar .col');
//     if (childModelBayar.length != 0) {
//       var childModelBayar = document.querySelectorAll('#modelBayar .col')[0];
//       var parentModelBayar = childModelBayar.parentElement;
//       parentModelBayar.removeChild(childModelBayar);
//     }
//     var idPesanan = $(this).val();
//     $.ajax({
//       type: "POST",
//       url: base_url + 'pembayaran/getPesananMeja',
//       data: {idPesanan: idPesanan},
//       success: function(response) {
//         $('#tabelDetailPesanan').html(response);
//         $('#modelBayar').append(`<div class="col">
//               <div class="row">
//                 <div class="col">
//                   <span style="font-weight: bolder;">Pembayaran</span>
//                 </div>
//               </div>
//               <div class="row text-center">
//                 <div class="col g-2">
//                   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBayarTunai">
//                     Tunai
//                   </button>
//                   <button type="button" class="btn btn-primary">
//                     Non-Tunai
//                   </button>
//                 </div>
//               </div>
//             </div>`)
//       }
//     })
//   } else {
//     var childModelBayar = document.querySelectorAll('#modelBayar .col')[0];
//     var parentModelBayar = childModelBayar.parentElement;
//     var childTabelBayarPesanan = document.querySelectorAll('#tabelDetailPesanan tr');
//     var parentTabelBayarPesanan = childTabelBayarPesanan[0].parentElement;
//     var jumlahChildTabelBayarPesanan = childTabelBayarPesanan.length;
//     for (let index = 0; index < jumlahChildTabelBayarPesanan; index++) {
//       parentTabelBayarPesanan.removeChild(childTabelBayarPesanan[index]);
//     }
//     parentModelBayar.removeChild(childModelBayar);
//   }
// })

$('#btnCetakBayarTunai').on('click', function() {
  if ($('#kasirSelectMeja option:selected').val() != "Pilih Meja") {
    var idPesanan = $('#kasirSelectMeja option:selected').val();
    var idMeja = $('#kasirSelectMeja option:selected').attr('data-idMeja');
    $.ajax({
      type: "POST",
      url: base_url + 'pembayaran/prosesBayarTunai',
      data: {idPesanan: idPesanan,idMeja: idMeja},
      dataType: 'json',
      success: function(response) {
        location.reload(true);
      }
    })
  }
})

// ----------

if (currentUrl.includes("viewPelayan")) {
  setInterval(ajaxCallUpdateViewPelayan, 1000);
  // getElementTabelPelayan();
} else if (currentUrl.includes("viewDapur")) {
  setInterval(ajaxCallUpdateViewDapur, 1000);
  // getElementTabelDapur();
} else if (currentUrl.includes("viewDetailPesanan")) {
  setInterval(ajaxCallUpdateTabelDetailPesananUser, 1000);
}

function ajaxCallUpdateTabelDetailPesananUser() {
  var idPesanan = $('#idPesanan').val();
  $.ajax({
    type: "POST",
    url: base_url + "pesanan/updateTabelPesananUser",
    data: {idPesanan: idPesanan},
    dataType: "json",
    success: function(response) {
      if(response.pesanan == 'true') {
        $("#tabelPesananUser").html(response.dataHTML);
        $('#jumlahPesananDimasak').html(response.jumlahPesananDimasak);
      } else {
        console.log('tidak ada perubahan');
      }
    }
  });
}

function ajaxCallUpdateViewPelayan() {
  $.ajax({
    url: base_url + "antrianMasak/updateViewPelayan",
    dataType: "json",
    success: function(response) {
      // $("#tabelPesananPelayan").html(response);
      // getElementTabelPelayan();
      if(response.pesanan == 'true') {
        $("#tabelPesananPelayan").html(response.dataHTML);
        getElementTabelPelayan();
      } else {
        console.log('tidak ada pesanan');
      }
    }
  });
}
  
function ajaxCallUpdateViewDapur() {
  $.ajax({
    url: base_url + "antrianMasak/updateViewDapur",
    dataType: "json",
    success: function(response) {
      if(response.pesanan == 'true') {
        $("#tabelPesananPelayan").html(response.dataHTML);
        getElementTabelPelayan();
      } else {
        console.log('tidak ada pesanan');
      }
    }
  });
}

function getElementTabelPelayan() {
  var parent = document.getElementById('tabelPesananPelayan');
  if ($('.kolomMinuman')[0] != null) {
    $('.kolomMinuman')[0].classList.remove('text-bg-info');
    $('.kolomMinuman')[0].classList.add('text-bg-warning');

    var tdMinuman = parent.getElementsByTagName('td')[0];
    var parentOpenBlockSpan = tdMinuman.children[0];
    var openBlockSpan = tdMinuman.getElementsByTagName('span')[0];
    parentOpenBlockSpan.removeChild(openBlockSpan);
    var cardItemMenu = tdMinuman.getElementsByClassName('card-body')[0];
    var itemMenu = cardItemMenu.getElementsByTagName('h4');
    for (let i = 0; i < itemMenu.length; i++) {
      itemMenu[i].classList.add('cbDoneItemIdMenuPelayan');
      var inputCheckbox = document.createElement('input');
      inputCheckbox.setAttribute("class", "form-check-input");
      inputCheckbox.setAttribute("type", "checkbox");
      inputCheckbox.setAttribute("value", "");
      itemMenu[i].appendChild(inputCheckbox)
    }
  }
  if ($('.kolomMakanan')[0] != null) {
    $('.kolomMakanan')[0].classList.remove('text-bg-info');
    $('.kolomMakanan')[0].classList.add('text-bg-warning');
    
    var tdMakanan = parent.getElementsByTagName('td')[1];
    var parentOpenBlockSpan = tdMakanan.children[0];
    var openBlockSpan = tdMakanan.getElementsByTagName('span')[0];
    parentOpenBlockSpan.removeChild(openBlockSpan);
    var cardItemMenu = tdMakanan.getElementsByClassName('card-body')[0];
    var itemMenu = cardItemMenu.getElementsByTagName('h4');
    for (let i = 0; i < itemMenu.length; i++) {
      itemMenu[i].classList.add('cbDoneItemIdMenuPelayan');
      var inputCheckbox = document.createElement('input');
      inputCheckbox.setAttribute("class", "form-check-input");
      inputCheckbox.setAttribute("type", "checkbox");
      inputCheckbox.setAttribute("value", "");
      itemMenu[i].appendChild(inputCheckbox)
    }
  }
}

function getElementTabelDapur() {
  $('.kolomMakanan')[0].classList.add('text-bg-warning');
  $('.kolomMinuman')[0].classList.add('text-bg-warning');
}
