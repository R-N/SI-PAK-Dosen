
var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

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

function pilihUnsur(index=null){
    $(".row-unsur").off("click");
    $(".row-unsur").click(function(){
		if(index==null){
			addItemPenilaian($(this).data("id-unsur"));
		}else{
			onPilihUnsur(index, 0);
		}
		$("#modal-unsur").modal("hide");
    });
    $("#modal-unsur").modal("show");
}
function onPilihUnsur(idUnsur, index=null){
	
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

function askConfirmation(title, content, onConfirm){
	$modal = $("#modal-confirm");
	$modal.find(".modal-title").text(title);
	$modal.find(".modal-body").html(content);
	$modal.find(".btn-confirm").click(function(){
		onConfirm();
		$(this).unbind("click");
		$modal.modal("hide");
	});
	$modal.modal("show");
}

function showError(title, content){
	$modal = $("#modal-error");
	$modal.find(".modal-title").text(title);
	$modal.find(".modal-body").html(content);
	$modal.modal("show");
}
function addItemPenilaian(idUnsur){
	let unsur = unsurs[idUnsur];
	let $item0 = $.parseHTML(templateItem);
	let no = $("#item-penilaian-holder .card").length+1;
	let $item =  $('<div/>').html($item0).contents();
	$item.find(".item-header").attr("href", "#item-body-" + no);
	$item.find(".item-body").attr("id", "item-body-" + no);
	$item.find(".item-kegiatan").html(no + ". " + unsur.kegiatan);
	$item.find(".item-kategori").html(unsur.kategori);;
	if(unsur.jenisBatas==1){
		$item.find(".row-semester").removeClass("d-none");
	}
	if(unsur.jenisBatas ==1 || unsur.jenisBatas==2){
		$item.find(".row-tahun").removeClass("d-none");
	}
	if(unsur.bukti){
		$item.find(".item-bukti").removeClass("d-none").html(unsur.butki);
		$item.find(".btn-draft-dokumen").removeClass("d-none");
	}
	if(unsur.batas){
		$item.find(".row-batas").removeClass("d-none");
		$item.find(".item-batas").html(unsur.batas + (unsur.unit?(" " + unsur.unit):"") + (unsur.jenisBatas?("/" + unsur.jenisBatas):""));
	}
	if(unsur.unit){
		$item.find(".item-unit").html(unsur.unit);
	}
	$item.find(".item-nilai").html(0);
	if(unsur.keterangan){
		$item.find(".row-keterangan").removeClass("d-none");
		$item.find(".item-keterangan").html(unsur.keterangan);
	}
	$("#item-penilaian-holder").append($item0);
}

$(document).ready(function(){
    $(".btn-penilai").click(function(){
        pilihPenilai(0,0);
    });
    $(".btn-sidang").click(function(){
        inputHasilSidang(0);
    });
    $(".btn-ganti-item").click(function(){
        pilihUnsur(0);
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
	if (typeof error === 'string') {
		showError("Error", error);
	}else if (typeof error ===  'object'){
		showError(error.title, error.message);
	}
})
