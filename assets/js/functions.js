
var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

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
    window.location.href="/PAKSidang.html";
}

function pilihUnsur(index=null){
    $(".row-unsur").off("click");
    $(".row-unsur").click(function(){
        onPilihUnsur(index, 0);
    });
    $("#modal-unsur").modal("show");
}
function onPilihUnsur(idUnsur, index=null){
    $("#modal-unsur").modal("hide");
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
    window.location.href="/PenilaianPAK.html";
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
    window.location.href="/PengajuanPAK.html";
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
    $("#btn-confirm").off("click");
    $("#btn-confirm").click(function(){
        onSubmitPenilai();
    });
    $("#modal-confirm").modal("show");
}
function onSubmitPenilai(){
    $("#modal-confirm").modal("hide");
    window.location.href = "/KelolaPenilai.html";
}

function login(form){
	
    $.ajax({
		url: baseUrl + "/Login/login",
		method: 'post',
		data: form.serialize(),
		dataType: 'json',
		success: function(response){
			
			if(response.result == "OK"){
				alert("Hore");
			}else{
				showError(response.errorMessage, "Login Gagal");
			}
			
		}
	});
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
    $("#btn-submit-pendaftaran-penilai").click(function(){
        submitPenilai();
    });
	$("#form-login").submit(function(e){
		e.preventDefault();
		login($(this));
	});
})
