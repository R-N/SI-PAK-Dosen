
var getUrl = window.location;
var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

function pilihPenilai(idPAK, nomor){
    $(".row-penilai").off("click");
    $(".row-penilai").click(function(){
        onPilihPenilai(idPAK,nomor,0);
    });
    $("#modal-penilai").modal('show');
}

function onPilihPenilai(idPAK, nomor, idPenilai){
    $("#modal-penilai ").modal("hide");
}

function inputHasilSidang(idPAK){
    $("#btn-sidang-setuju").off("click");
    $("#btn-sidang-tolak").off("click");
    $("#btn-sidang-setuju").click(function(){
        onInputHasilSidang(idPAK, true);
    });
    $("#btn-sidang-tolak").click(function(){
        onInputHasilSidang(idPAK, false);
    });
    $("#modal-sidang").modal("show");
}

function onInputHasilSidang(idPAK, setuju){
    $("#modal-sidang").modal("hide");
    window.location.href=baseUrl + "admin/sidang";
}
var itemUnsur = null;
function pilihUnsur(_itemUnsur = null){
	itemUnsur = _itemUnsur;
    $("#modal-unsur").modal("show");
}
function inputDokumen(index){
    $("#btn-simpan-dokumen").off("click");
    $("#btn-simpan-dokumen").click(function(){
        url = $("#field-url-dokumen").val();
        onInputDokumen(index,url);
    });
    $("#modal-dokumen").modal("show");
}

function onInputDokumen(index, url){
    $("#modal-dokumen").modal("hide");
}

function showError(text, title){
    $("#modal-error").modal("show");
}

function submitPenilaian(){
    $(".btn-confirm-submit").off("click");
    $(".btn-confirm-submit").click(function(){
        onSubmitPenilaian();
    });
    $(".modal-confirm").modal("show");
}

function onSubmitPenilaian(){
    $(".modal-confirm").modal("hide");
    window.location.href=baseUrl+"penilai/pak";
}

function submitPAK(){
    $(".btn-confirm-submit").off("click");
    $(".btn-confirm-submit").click(function(){
        onSubmitPAK();
    });
    $(".modal-confirm").modal("show");
}

function onSubmitPAK(){
    $(".modal-confirm").modal("hide");
    window.location.href=baseUrl+"dosen/pak";
}

function suspendPenilai(index){
    
    $("#btn-confirm-suspend").off("click");
    $("#btn-confirm-suspend").click(function(){
        alasan = $("#field-alasan-suspend").val();
        onSuspendPenilai(index, alasan);
    });
    $("#modal-suspend").modal("show");
}

function onSuspendPenilai(index){
    $("#modal-suspend").modal("hide");
}

function aktifkanPenilai(index){
    
    $("#btn-confirm").off("click");
    $("#btn-confirm").click(function(){
        onAktifkanPenilai(index);
    });
    $("#modal-confirm").modal("show");
}

function onAktifkanPenilai(index){
    $("#modal-confirm").modal("hide");
}

function submitPenilaiPAK(index=null){
    $("#btn-confirm").off("click");
    $("#btn-confirm").click(function(){
        onSubmitPenilai(index);
    });
    $("#modal-confirm").modal("show");
}
function onSubmitPenilaiPAK(index){
    $("#modal-confirm").modal("hide");
}


function submitPenilai(){
	$myForm = $("#form-penilai");
	$myForm.removeClass("was-validated");
	if(! $myForm[0].checkValidity()) {
		$myForm.find(':submit').trigger("click", [false]);
	}else if (validatePenilai()){
		askConfirmation("Submit Penilai", "Apa Anda yakin ingin submit?<br>Proses ini tidak dapat di-undo.", onSubmitPenilai);
	}
}
function validatePenilai(){
	$myForm.addClass("was-validated");
	return true;
}
function onSubmitPenilai(){
	$myForm = $("#form-penilai");
	let daftarkanPenilaiData = {
		url: baseUrl + "admin/daftarkanPenilaiLuar",
		method: 'post',
		data: $myForm.serialize(),
		dataType: 'json',
		success: function(response){
			if(response.result == "OK"){
				window.location.href = response.redirect;
			}else{
				console.log(response.errorMessage);
				showError("Pendaftaran Gagal", response.errorMessage);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			console.log(xhr.responseText);
		}
	};
    $.ajax(daftarkanPenilaiData);
}

function login(form){
	let loginData = {
		url: baseUrl + "login/login",
		method: 'post',
		data: form.serialize(),
		dataType: 'json',
		success: function(response){
			if(response.result == "OK"){
				window.location.reload(true);
			}else{
				showError(response.errorMessage, "Login Gagal");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(xhr.responseText);
		}
	};
    $.ajax(loginData);
}

var onConfirm = null;
function askConfirmation(title, content, _onConfirm){
	$modal = $("#modal-confirm");
	$modal.find(".modal-title").text(title);
	$modal.find(".modal-body").html(content);
	onConfirm = _onConfirm;
	$modal.modal("show");
}

function showError(title, content){
	$modal = $("#modal-error");
	$modal.find(".modal-title").text(title);
	$modal.find(".modal-body").html(content);
	$modal.modal("show");
}
function addItemPenilaian(idUnsur){
	let $item = $($.parseHTML(templateItem));
	initUnsur($item, idUnsur);
	initItem($item);
	$("#item-penilaian-holder").append($item);
}

function initUnsur($item, idUnsur){
	let unsur = unsurs[idUnsur];
	let no = $("#item-penilaian-holder .card").length+1;
	$item.attr("data-id-unsur", idUnsur);
	$item.data("id-unsur", idUnsur);
	$item.data("idUnsur", idUnsur);
	$item.data("idunsur", idUnsur);
	$item.attr("data-no", no);
	$item.data("no", no);
	$item.find(".item-header").attr("href", "#item-body-" + no);
	$item.find(".item-body").attr("id", "item-body-" + no);
	$item.find(".item-no").html(no);
	$item.find(".item-kegiatan-kegiatan").html(unsur.kegiatan);
	$item.find(".item-kategori").html(unsur.kategori);
	if(unsur.idJenisBatas==1){
		$item.find(".row-semester").removeClass("d-none");
	}else{
		$item.find(".row-semester").addClass("d-none");
	}
	if(unsur.idJenisBatas ==1 || unsur.idJenisBatas==2){
		$item.find(".row-tahun").removeClass("d-none");
	}else{
		$item.find(".row-tahun").addClass("d-none");
	}
	if(unsur.bukti){
		$item.find(".item-bukti").removeClass("d-none").html(unsur.bukti);
		$item.find(".btn-draft-dokumen").removeClass("d-none");
	}else{
		$item.find(".item-bukti").addClass("d-none");
		$item.find(".btn-draft-dokumen").addClass("d-none");
	}
	if(unsur.batas){
		$item.find(".row-batas").removeClass("d-none");
		$item.find(".item-batas").html(unsur.batas + (unsur.unit?(" " + unsur.unit):"") + (unsur.jenisBatas?(" " + unsur.jenisBatas):""));
	}else{
		$item.find(".row-batas").addClass("d-none");
	}
	if(unsur.unit){
		$item.find(".item-unit").removeClass("d-none").html(unsur.unit);
	}else{
		$item.find(".item-unit").addClass("d-none");
	}
	$jumlah = $item.find(".field-jumlah");
	if(!$.isNumeric($jumlah.val())){
		$item.find(".item-nilai").html(0);
	}else{
		hitungNilai($jumlah);
	}
	if(unsur.keterangan){
		$item.find(".row-keterangan").removeClass("d-none");
		$item.find(".item-keterangan").html(unsur.keterangan);
	}
}

function hitungNilai($jumlah){
	let jumlah = $jumlah.val();
	let $nilai = $jumlah.parent().closest("tbody").find(".item-nilai");
	let idUnsur = $jumlah.parent().closest(".item-penilaian").attr("data-id-unsur");
	let unsur = unsurs[idUnsur];
	if(jumlah > unsur.batas){
		jumlah = unsur.batas;
		$jumlah.val(jumlah);
	}else if (jumlah < 0){
		jumlah = 0;
		$jumlah.val(jumlah);
	}
	$nilai.html(jumlah * unsur.kreditPerItem);
}

function validateItem($item){
	let $itemHeader = $item.find(".item-header");
	$itemHeader.removeClass("bg-warning");
	$itemHeader.removeClass("bg-success");
	if(!_validateItem($item)){
		$itemHeader.addClass("bg-warning");
	}else{
		$itemHeader.addClass("bg-success");
	}
}

function _validateItem($item){
	let idUnsur = $item.attr("data-id-unsur");
	console.log("idUnsur: " + idUnsur);
	let unsur = unsurs[idUnsur];
	if(unsur.idJenisBatas==1){
		
	}
	if(unsur.idJenisBatas ==1 || unsur.idJenisBatas==2){
		let tahun = $item.find(".field-tahun").val();
		if(!tahun || tahun.length != 4 || !$.isNumeric(tahun)) return false;
	}
	if(unsur.bukti){
		let url = $item.find(".btn-lihat-dokumen").attr("href");
		if(!url || !validURL(url)) return false;
	}
	let jumlah = $item.find(".field-jumlah").val();
	if(!jumlah || !$.isNumeric(jumlah) || jumlah == 0) return false;
	let nilai = $item.find(".item-nilai").html();
	if(!nilai || !$.isNumeric(nilai) || nilai == 0) return false;
	if(unsur.batas){
		if(jumlah > unsur.batas) return false;
		if(unsur.idJenisBatas == 1){
		}else if (unsur.idJenisBatas == 2){
		}else if (unsur.idJenisBatas == 3){
		}
	}
	return true;
}
function readItemPenilaian($item){
	let idItem = $item.attr("data-id-item");
	let idUnsur = $item.attr("data-id-unsur");
	let no = $item.attr("data-no");
	
}
function validURL(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return !!pattern.test(str);
}
var onConfirmUrl = null;
function askUrl(title, text, initialValue, onConfirm){
	$modal = $("#modal-url");
	$modal.find(".modal-title").html(title);
	$modal.find(".modal-body p").html(text);
	if(initialValue.startsWith("http")) $modal.find("#field-url").val(initialValue);
	$btnConfirm = $modal.find(".btn-confirm");
	onConfirmUrl = onConfirm;
	$modal.modal("show");
}

function initItem($item){
	$item.each(function(){
		let $fieldJumlah = $item.find(".field-jumlah");
		let $it = $fieldJumlah.parent().closest(".item-penilaian");
		let $btnLihat = $item.find(".btn-lihat-dokumen");
		let $btnUrl = $item.find(".btn-input-dokumen");
		$btnUrl.click(function(){
			askUrl(
			"Dokumen Bukti", 
			"Upload dokumen ke Google Drive Anda, get shareable link, lalu paste ke field di bawah ini.", 
			$btnLihat.attr("href"),
			function(url){
				$btnLihat.attr("href", url);
				validateItem($it);
			});
		});
		$fieldJumlah.bind("change paste keyup", function() {
			hitungNilai($fieldJumlah);
			validateItem($it);
		});
		initBtnDokumen($item.find(".btn-input-dokumen"));
		$it.find(".field-tahun").bind("change paste keyup", function() {
			validateItem($it);
		});
		$it.find(".btn-delete-item").click(function(){
			askConfirmation(
				"Hapus item", 
				"Tolong konfirmasi bahwa Anda benar-benar ingin menghapus item:<br>" + $it.find(".item-kegiatan").text(),
				function(){
					$it.remove();
					let no = 0;
					$(".item-penilaian").each(function(){
						++no;
						$(this).attr("data-no", no);
						$(this).data("no", no);
						$body = $(this).find(".item-body");
						$body.attr("id", "item-body-" + no);
						$span = $(this).find(".item-no");
						$span.html(no);
						$header = $(this).find(".item-header");
						$header.attr("href", "#item-body-" + no);
					});
				}
			);
		});
		$item.find(".btn-change-item").click(function(){
			pilihUnsur($(this).parent().closest(".item-penilaian"));
		});
	});
}

function initBtnDokumen($btn){
	$btnLihat = $btn.parent().find(".btn-lihat-dokumen");
	$btn.click(function(){
		askUrl(
		"Dokumen Bukti", 
		"Upload dokumen ke Google Drive Anda, get shareable link, lalu paste ke field di bawah ini.", 
		$btnLihat.attr("href"),
		function(url){
			$btnLihat.attr("href", url);
			validateItem($btn.parent().closest(".item-penilaian"));
		});
	});
}

function initFieldJumlah($field){
	$field.bind("change paste keyup", function() {
		hitungNilai($field);
		validateItem($field.parent().closest(".item-penilaian"));
	});
}

$(document).ready(function(){
    $(".btn-penilai").click(function(){
        pilihPenilai(0,0);
    });
    $(".btn-sidang").click(function(){
        inputHasilSidang(0);
    });
    $("#btn-tambah-item").click(function(){
        pilihUnsur();
    });
    $(".btn-input-dokumen").click(function(){
        inputDokumen(0);
    });
    $(".btn-submit-penilaian").click(function(){
        submitPenilaian();
    });
    $(".btn-submit-pak").click(function(){
        submitPAK();
    });
    $(".btn-suspend-penilai").click(function(){
        suspendPenilai(0);
    });
    $(".btn-aktifkan-penilai").click(function(){
        aktifkanPenilai(0);
    });
    $(".btn-submit-penilai").click(function(){
        submitPenilaiPAK(0);
    });
    $("#btn-submit-pendaftaran-penilai").click(function(e){
		e.preventDefault();
        submitPenilai();
    });
	$("#form-login").submit(function(e){
		e.preventDefault();
		login($(this));
	});
	$("#tabel-unsur").on("click", ".row-unsur", function(){
		$("#modal-unsur").modal("hide");
		if(itemUnsur==null){
			addItemPenilaian($(this).data("id-unsur"));
		}else{
			initUnsur(itemUnsur, $(this).data("id-unsur"));
		}
	});
	$("#form-penilai").submit(function(e){
		e.preventDefault();
	});
	$(".dropdown-item").click(function(e){
		if($(this).attr("href")=="#"){
			e.preventDefault();
		}
	});
	$(".dropdown-select .dropdown-item").click(function(){
		$(this).parent().parent().find(".dropdown-item.selected").removeClass("selected");
		$(this).addClass("selected");
		$(this).parent().parent().find(".dropdown-toggle").text($(this).text());
	});
	initItem($(".item-penilaian"));
	$("#btn-confirm-url").click(function(){
		$modal = $("#modal-url");
		$field = $modal.find("#field-url");
		let url = $field.val();
		if(!validURL(url)){
			alert("URL tidak valid");
			return;
		}
		$modal.modal("hide");
		$field.val("");
		onConfirmUrl(url);
	});
	$("#btn-confirm").click(function(){
		onConfirm();
		$("#modal-confirm").modal("hide");
	});
	if (typeof error === 'string') {
		showError("Error", error);
	}else if (typeof error ===  'object'){
		showError(error.title, error.message);
	}
})
