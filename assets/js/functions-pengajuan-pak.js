
var getUrl = window.location;
var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

var itemUnsur = null;
function pilihUnsur(_itemUnsur = null){
	itemUnsur = _itemUnsur;
    $("#modal-unsur").modal("show");
}
function submitPAK(){
	if(!validatePAK()) return;
	askConfirmation("Submit PAK", "Apa Anda yakin ingin menyerahkan PAK?", onSubmitPAK);
}

function onSubmitPAK(){
	let pak = readPAK();
	if(pak == null) return;
	console.log(JSON.stringify(pak));
	let ajaxSubmitPAK = {
		url: baseUrl + "dosen/submitPAK",
		method: 'post',
		data: {'pak':pak},
		dataType: 'json',
		success: function(response){
			if(response.result == "OK"){
				window.location.href = response.redirect;
			}else{
				showError("Submit PAK gagal",  response.errorMessage);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(xhr.responseText);
		}
	};
    $.ajax(ajaxSubmitPAK);
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
	let idKategori = unsur.idKategori;
	$item.attr("data-id-kategori", idKategori);
	$item.data("id-kategori", idKategori);
	$item.data("idKategori", idKategori);
	$item.data("idkategori", idKategori);
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
	$item.find(".collapse").addClass("show");
}

function hitungBatas(){
	let kreditAwal = parseFloat($(".kredit-sebelumnya").val());
	let kreditMinimal = pak.kreditMinimal;
	let kreditDibutuhkan = Math.max(0, kreditMinimal-kreditAwal);
	
	Object.keys(batasKategori).forEach(function(idKategori) {
		let batas = batasKategori[idKategori];
		let $batas = $(".batas-kategori[data-id-kategori=\"" + idKategori + "\"]");
		if(batas.minType == 1){
			batas.minimalAbs = batas.minimal * kreditDibutuhkan * 0.01;
			$batas.find(".nilai-kategori-minimal").html(batas.minimalAbs);
		}
		if(batas.maxType == 1){
			batas.maksimalAbs = batas.maksimal * kreditDibutuhkan * 0.01;
			$batas.find(".nilai-kategori-maksimal").html(batas.maksimalAbs);
		}
	});
}

function hitungNilai($jumlah){
	let jumlah = parseFloat($jumlah.val());
	let $nilai = $jumlah.parent().closest("tbody").find(".item-nilai");
	let idUnsur = $jumlah.parent().closest(".item-penilaian").attr("data-id-unsur");
	let unsur = unsurs[idUnsur];
	if(unsur.batas && jumlah > unsur.batas){
		jumlah = unsur.batas;
		$jumlah.val(jumlah);
	}else if (jumlah < 0){
		jumlah = 0;
		$jumlah.val(jumlah);
	}else if ((isNaN(jumlah) || !$.isNumeric($jumlah.val())) && $jumlah.val() != ""){
		let lastValue = $jumlah.attr("data-last-value");
		jumlah = lastValue;
		$jumlah.val(lastValue);
	}
	$jumlah.attr("data-last-value", jumlah);
	$jumlah.data("last-value", jumlah);
	$jumlah.data("lastValue", jumlah);
	
	$nilai.html(jumlah * unsur.kreditPerItem);
	hitungNilaiKategori();
}

function hitungNilaiKategori(){
	let subtotals = {};
	let isValid = true;
	Object.keys(batasKategori).forEach(function(idKategori) {
		subtotals[idKategori] = 0;
	});
	$(".item-penilaian").each(function(){
		let idKategori = $(this).attr("data-id-kategori");
		let nilai = $(this).find(".item-nilai").text();
		subtotals[idKategori] += parseFloat(nilai);
	});
	$(".batas-kategori").each(function(){
		let idKategori = $(this).attr("data-id-kategori");
		$(this).find(".nilai-kategori-subtotal").text(subtotals[idKategori]);
	});
	let kreditSebelumnya = $(".kredit-sebelumnya").val();
	if(isNaN(parseFloat(kreditSebelumnya)) || !$.isNumeric(kreditSebelumnya)) kreditSebelumnya = 0;
	kreditSebelumnya = parseFloat(kreditSebelumnya);
	let totals = [];
	let subtotalSubtotal = 0;
	let subtotalAkhir = 0;
	Object.keys(batasKategori).forEach(function(idKategori) {
		let subtotal = subtotals[idKategori];
		subtotalSubtotal += subtotal;
		let batas = batasKategori[idKategori];
		let $batas = $(".batas-kategori[data-id-kategori=" + idKategori + "]");
		let state = 0;
		if(batas.minimalAbs && batas.minimalAbs > 0
			&& subtotal < batas.minimalAbs){
			$batas.find(".nilai-kategori-minimal").removeClass("bg-success").addClass("bg-danger");
			isValid = false;
			state = 2;
		}else{
			$batas.find(".nilai-kategori-minimal").removeClass("bg-danger").addClass("bg-success");
		}
		if(batas.maksimalAbs && subtotal > batas.maksimalAbs){
			$batas.find(".nilai-kategori-maksimal").removeClass("bg-success").addClass("bg-warning");
			subtotal = batas.maksimalAbs;
			state = 1;
		}else{
			$batas.find(".nilai-kategori-maksimal").removeClass("bg-warning").addClass("bg-success");
		}
		totals[idKategori] = subtotal;
		$batas.find(".nilai-kategori-total").text(subtotal);
		subtotalAkhir += subtotal;
		
	})
	
	$(".subtotal-subtotal").text(subtotalSubtotal);
	$(".subtotal-akhir").text(subtotalAkhir);
	let totalSubtotal = kreditSebelumnya+subtotalSubtotal;
	let totalAkhir = kreditSebelumnya+subtotalAkhir;
	$(".total-subtotal").text(totalSubtotal);
	$(".total-akhir").text(totalAkhir);
	let kreditMinimal = pak.kreditMinimal;
	if(totalAkhir < kreditMinimal){
		isValid = false;
		$(".total-nilai").addClass("bg-danger").removeClass("bg-success bg-warning");
		$(".total-akhir").addClass("bg-danger").removeClass("bg-success bg-warning");
	}else if(isValid){
		$(".total-nilai").addClass("bg-success").removeClass("bg-danger bg-warning");
		$(".total-akhir").addClass("bg-success").removeClass("bg-danger bg-warning");
	}else{
		$(".total-nilai").addClass("bg-warning").removeClass("bg-danger bg-success");
		$(".total-akhir").addClass("bg-warning").removeClass("bg-danger bg-success");
	}
	return isValid;
}

function validateItem($item){
	let $itemHeader = $item.find(".item-header");
	$itemHeader.removeClass("bg-danger");
	$itemHeader.removeClass("bg-success");
	if(!_validateItem($item)){
		$itemHeader.addClass("bg-danger");
		return false;
	}else{
		$itemHeader.addClass("bg-success");
		return true;
	}
}

function _validateItem($item){
	let idUnsur = $item.attr("data-id-unsur");
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
function isKreditValid(kredit){
	return kredit != "" && kredit != null && !isNaN(kredit);
}
function simpanPAK(){
	let pak = readPAK();
	if(pak == null) return;
	if(!isKreditValid(pak.kreditAwal)){
		scrollTo('.kredit-sebelumnya');
		showError("Error", "Anda harus mengisi kredit sebelumnya dengan benar: " + pak.kreditAwal);
		return;
	}
	console.log(JSON.stringify(pak));
	let ajaxSimpanPAK = {
		url: baseUrl + "dosen/simpanPAK",
		method: 'post',
		data: {'pak':pak},
		dataType: 'json',
		success: function(response){
			if(response.result == "OK"){
				if(window.location.href == response.redirect){
					showNotif("Simpan PAK berhasil", "");
				}else{
					window.location.href = response.redirect;
				}
			}else{
				showError("Simpan PAK gagal",  response.errorMessage);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(xhr.responseText);
		}
	};
    $.ajax(ajaxSimpanPAK);
}
function validatePAK(){
	let isValid = true;
	
	let kreditAwal = parseFloat($(".kredit-sebelumnya").val());
	if(!isKreditValid(kreditAwal)){
		scrollTo(".kredit-sebelumnya");
		showError("PAK Invalid", "Anda harus mengisi kredit sebelumnya dengan benar");
		return false;
	}
	$(".item-penilaian").each(function(){
		isValid = isValid && validateItem($(this));
	});
	if(!isValid){
		scrollTo("#card-kegiatan");
		showError("PAK Invalid", "Tolong lengkapi item kegiatan yang berwarna kuning");
		return false;
	}
	isValid = isValid && hitungNilaiKategori();
	if(!isValid){
		scrollTo("#card-nilai-kategori");
		showError("PAK Invalid", "Anda belum memenuhi batas minimal angka kredit. Tolong lihat batas yang berwarna merah.");
		return false;
	}
	return isValid;
}
function readPAK(){
	var pakBaru = JSON.parse(JSON.stringify(pak));
	let sKreditAwal = $(".kredit-sebelumnya").val();
	pakBaru.kreditAwal = parseFloat(sKreditAwal);
	if(isNaN(pakBaru.kreditAwal) || !$.isNumeric(sKreditAwal)){
		scrollTo(".kredit-sebelumnya");
		showError("Anda perlu mengisi kredit awal");
		return null;
	}
	var items = [];
	$(".item-penilaian").each(function(){
		let item = readItemPenilaian($(this));
		//item.idPAK = pakBaru.idPAK;
		items.push(item);
	});
	pakBaru.items = items;
	return pakBaru;
}
function readItemPenilaian($item){
	let idItem = $item.attr("data-id-item");
	let idUnsur = $item.attr("data-id-unsur");
	let nilai = $item.find(".item-nilai").text();
	let urlDokumen = $item.find(".btn-lihat-dokumen").attr("href");
	if(!validURL(urlDokumen)) urlDokumen = null;
	let tahun = $item.find(".field-tahun").val();
	let semester = $item.find(".field-semester").val();
	let unsur = unsurs[idUnsur];
	var item = {
		idItem: idItem,
		idUnsur:idUnsur,
		nilai:nilai,
		urlDokumen:urlDokumen,
		semester:null,
		tahun:null
	};
	if(unsur.idJenisBatas==1){
		item.semester = semester;
	}
	if(unsur.idJenisBatas == 1 || unsur.idJenisBatas==2){
		item.tahun = tahun;
	}
	return item;
	
}

function initItem($item){
	$item.each(function(){
		let $fieldSemester = $item.find(".field-semester");
		let $fieldJumlah = $item.find(".field-jumlah");
		let $fieldTahun = $item.find(".field-tahun");
		let $it = $fieldJumlah.parent().closest(".item-penilaian");
		let $btnLihat = $it.find(".btn-lihat-dokumen");
		let $btnUrl = $it.find(".btn-input-dokumen");
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
		$fieldTahun.bind("change paste keyup", function() {
			let idUnsur = $it.attr("data-id-unsur");
			let unsur = unsurs[idUnsur];
			let sel = ".item-penilaian[data-id-unsur=\"" + idUnsur + "\"]";
			$existing = $(sel);
			let fail = false;
			if($existing.length > 0 && unsur.idJenisBatas==2 || unsur.idJenisBatas == 1){
				let tahun = $(this).val();
				if(isNaN(parseInt(tahun)) && tahun != ""){
					let lastVal = $(this).attr("data-last-value");
					tahun = lastVal;
					$(this).val(lastVal);
				}
				let fails = 0;
				if(unsur.idJenisBatas == 2){
					$existing.each(function(){
						if(!$(this).is($it) && $(this).find(".field-tahun").val() == tahun) ++fails;
					});
					if(fails > 0){
						fail = true;
					}
				}else{
					let semester = $it.find(".field-semester").val();
					$existing.each(function(){
						if(!$(this).is($it) && $(this).find(".field-tahun").val() == tahun && $(this).find(".field-semester").val() == semester) ++fails;
					});
					if(fails > 0){
						fail = true;
					}
				}
			}
			if(fail){
				showError("Error", "Item serupa sudah ada");
				let lastVal = $(this).attr("data-last-value");
				$(this).val(lastVal);
			}else{
				let val = $(this).val();
				$(this).attr("data-last-value", val);
				$(this).data("last-value", val);
				$(this).data("lastValue", val);
			}
		});
		$fieldSemester.bind("change", function() {
			let idUnsur = $it.attr("data-id-unsur");
			let unsur = unsurs[idUnsur];
			let sel = ".item-penilaian[data-id-unsur=\"" + idUnsur + "\"]";
			$existing = $(sel);
			let fail = false;
			if($existing.length > 0 && unsur.idJenisBatas==2 || unsur.idJenisBatas == 1){
				let tahun = $it.find(".field-tahun").val();
				let fails = 0;
				if(unsur.idJenisBatas == 2){
					$existing.each(function(){
						if(!$(this).is($it) && $(this).find(".field-tahun").val() == tahun) ++fails;
					});
					if(fails > 0){
						fail = true;
					}
				}else{
					let semester = $(this).val();
					$existing.each(function(){
						if(!$(this).is($it) && $(this).find(".field-tahun").val() == tahun && $(this).find(".field-semester").val() == semester) ++fails;
					});
					if(fails > 0){
						fail = true;
					}
				}
			}
			if(fail){
				showError("Error", "Item serupa sudah ada");
				let lastVal = $(this).attr("data-last-value");
				$(this).val(lastVal).change();
			}else{
				let val = $(this).val();
				$(this).attr("data-last-value", val);
				$(this).data("last-value", val);
				$(this).data("lastValue", val);
			}
		});
		$it.find(".field-tahun").bind("change paste keyup", function() {
			validateItem($it);
		});
		$it.find(".btn-delete-item").click(function(){
			let $iti = $(this).parent().closest(".item-penilaian");
			askConfirmation(
				"Hapus item", 
				"Tolong konfirmasi bahwa Anda benar-benar ingin menghapus item:<br>" + $item.find(".item-kegiatan").text(),
				function(){
					$iti.remove();
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
					hitungNilaiKategori();
				}
			);
		});
		$it.find(".btn-change-item").click(function(){
			pilihUnsur($(this).parent().closest(".item-penilaian"));
		});
		hitungNilai($fieldJumlah);
	});
}


$(document).ready(function(){
    $("#btn-tambah-item").click(function(){
        pilihUnsur();
    });
    $(".btn-simpan-pak").click(function(){
        simpanPAK();
    });
    $(".btn-submit-pak").click(function(){
        submitPAK();
    });
	$("#tabel-unsur").on("click", ".row-unsur", function(){
		let idUnsur = $(this).data("id-unsur");
		let unsur = unsurs[idUnsur];
		let sel = ".item-penilaian[data-id-unsur=\"" + idUnsur + "\"]";
		$existing = $(sel);
		let fail = false;
		if($existing.length > 0){
			if(!unsur.idJenisBatas || unsur.idJenisBatas>=3){
				if(itemUnsur){
					let fails = 0;
					$existing.each(function(){
						if(!$(this).is(itemUnsur)) ++fails;
					});
					if(fails > 0){
						fail = true;
					}
				}else{
					fail = true;
				}
			}else if (unsur.idJenisBatas==2 || unsur.idJenisBatas == 1){
				let tahun = "";
				if(itemUnsur != null){
					tahun = itemUnsur.find(".field-tahun").val();
				}
				let fails = 0;
				if(unsur.idJenisBatas == 2){
					$existing.each(function(){
						if(!$(this).is(itemUnsur) && $(this).find(".field-tahun").val() == tahun) ++fails;
					});
					if(fails > 0){
						fail = true;
					}
				}else{
					let semester = 1;
					if(itemUnsur != null){
						semester = itemUnsur.find(".field-semester").val();
					}
					$existing.each(function(){
						if(!$(this).is(itemUnsur) && $(this).find(".field-tahun").val() == tahun) ++fails;
					});
					if(fails > 1){
						fail = true;
					}
				}
			}
		}
		if(fail){
			showError("Error", "Unsur sudah ada");
			return;
		}
		$("#modal-unsur").modal("hide");
		if(itemUnsur==null){
			addItemPenilaian(idUnsur);
		}else{
			initUnsur(itemUnsur, idUnsur);
		}
	});
	$(".item-penilaian").each(function(){
		initItem($(this));
	});
	$(".field-jumlah").change();
	$("#tabel-unsur").DataTable({pageLength: 5});
	hitungNilaiKategori();
	$(".kredit-sebelumnya").bind("change keyup paste", function(){
		let val = $(this).val();
		if(isNaN(parseFloat(val)) || !$.isNumeric(val)){
			if(val != ""){
				let lastValue = $(this).attr("data-last-value");
				val = lastValue;
				$(this).val(lastValue);
			}
		}
		$(this).attr("data-last-value", val);
		$(this).data("last-value", val);
		$(this).data("lastValue", val);
		
		if(isNaN(parseFloat(val))){
			$(this).addClass("bg-danger text-light");
		}else{
			$(this).removeClass("bg-danger text-light");
		}
		
		console.log("val: " + val + " " + parseFloat(val));
		
		hitungBatas();
		hitungNilaiKategori();
	});
})
