
function simpanPenilaian(){
	let penilaian = readPenilaian();
	let ajaxSimpanPenilaian = {
		url: baseUrl + "penilai/simpanPenilaian",
		method: 'post',
		data: {'penilaian':penilaian},
		dataType: 'json',
		success: function(response){
			if(response.result == "OK"){
				showNotif("Simpan penilaian berhasil", "");
				//window.location.reload();
			}else{
				showError("Simpan penilaian gagal",  response.errorMessage);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(xhr.responseText);
		}
	};
	$.ajax(ajaxSimpanPenilaian);
}

function submitPenilaian(){
	let penilaian = readPenilaian();
	for(let i = 0; i < penilaian.items.length; ++i){
		if(penilaian.items[i].nilai === null){
			showError("Error", "Anda belum mengisi semua nilai");
			return;
		}
	}
	askConfirmation(
		"Submit Penilaian", 
		"Apa Anda yakin ingin submit penilaian?<br>Proses ini tidak dapat dibatalkan",
		function(){
			let ajaxSubmitpenilaian = {
				url: baseUrl + "penilai/submitPenilaian",
				method: 'post',
				data: {'penilaian':penilaian},
				dataType: 'json',
				success: function(response){
					if(response.result == "OK"){
						window.location.href = response.redirect;
						//window.location.reload();
					}else{
						showError("Simpan penilaian gagal",  response.errorMessage);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(xhr.responseText);
				}
			};
			$.ajax(ajaxSubmitpenilaian);
		}
	);
}


function readPenilaian(){
	let items = [];
	
	$(".nilai-penilai").each(function(){
		items.push(readItem($(this)));
	});
	
	let penilaian = {
		'idPAK':pak.id,
		'items':items
	};
	
	return penilaian;
}
function readItem($input){
	let idItem  =$input.attr("data-id-item");
	let nilaiPenilai = parseFloat($input.val());
	if(isNaN(nilaiPenilai)) nilaiPenilai = null;
	return {
		'idItem':idItem,
		'nilai':nilaiPenilai
	};
}

function hitungNilaiKategori(){
	let subtotals = {};
	let isValid = true;
	Object.keys(batasKategori).forEach(function(idKategori) {
		subtotals[idKategori] = 0;
	});
	$(".nilai-penilai").each(function(){
		let idKategori = $(this).attr("data-id-kategori");
		let nilai = getNilai($(this));
		subtotals[idKategori] += parseFloat(nilai);
	});
	$(".batas-kategori").each(function(){
		let idKategori = $(this).attr("data-id-kategori");
		$(this).find(".nilai-kategori-subtotal").text(subtotals[idKategori]);
	});
	let kreditSebelumnya = parseFloat($(".kredit-sebelumnya").text());
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
function getNilai($input){
	let nilai = parseFloat($input.val());
	if(isNaN(nilai)){
		return $input.attr("data-nilai-awal");
	}
	return nilai;
}

$(document).ready(function(){
	$(".nilai-penilai").bind("change keyup paste", function(){
		$input = $(this);
		let nilaiAwal = parseFloat($input.attr("data-nilai-awal"));
		let sNilaiPenilai = $input.val();
		let nilaiPenilai = parseFloat(sNilaiPenilai);
		if(isNaN(nilaiPenilai) || !$.isNumeric(sNilaiPenilai)){
			if(sNilaiPenilai != ""){
				let lastValue = $input.attr("data-last-value");
				sNilaiPenilai = lastValue;
				nilaiPenilai = parseFloat(lastValue);
				$input.val(lastValue);
			}
		}
		if(isNaN(nilaiPenilai)){
			$input.removeClass("bg-danger text-light").addClass("bg-danger text-light");
		}else{
			$input.removeClass("bg-danger text-light");
		}
		
		if(isNaN(nilaiPenilai)) nilaiPenilai = 0;
		
		$input.attr("data-last-value", sNilaiPenilai);
		$input.data("last-value", sNilaiPenilai);
		$input.data("lastValue", sNilaiPenilai);
		
		if(nilaiPenilai < 0){
			nilaiPenilai = 0;
			$input.val(nilaiPenilai);
		}
		if(nilaiPenilai > nilaiAwal){
			nilaiPenilai = nilaiAwal;
			$input.val(nilaiPenilai);
		}
		hitungNilaiKategori();
	});
	$("#tabel-penilaian").DataTable();
	$(".btn-simpan-penilaian").click(simpanPenilaian);
	$(".btn-submit-penilaian").click(submitPenilaian);
	hitungNilaiKategori();
});