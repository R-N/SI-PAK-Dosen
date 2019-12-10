
var _onPilihPenilai = null;
function pilihPenilai(onPilihPenilai, $button){
	_onPilihPenilai = onPilihPenilai;
	$modal = $("#modal-penilai");
	$rows = $modal.find(".row-penilai");
	$rows.removeClass("bg-primary text-light");
	$rows.find(".penilai-selection").html(1);
	let selected = $button.attr("data-id-user");
	if(selected){
		$selected = $modal.find(".row-penilai[data-id-user=\"" + selected + "\"]");
		$selected.addClass("bg-primary text-light");
		$selected.find(".penilai-selection").html(0);
	}
	$("#tabel-penilai-pak").DataTable().rows().invalidate().draw();
    $("#modal-penilai").modal('show');
}


function submitPenilaiPAK($btn){
	askConfirmation(
		"Submit Penilai", 
		"Apa Anda yakin ingin submit penilai?<br>Proses ini tidak dapat dibatalkan.",
		function(){
			let idPAK = $btn.attr("data-id-pak");
			let ajaxSubmitPenilaiPAK = {
				url: baseUrl + "admin/submitPenilaiPAK",
				method: 'post',
				data: {'idPAK':idPAK},
				dataType: 'json',
				success: function(response){
					if(response.result == "OK"){
						if(window.location.href == response.redirect){
							window.location.reload();
						}else{
							window.location.href = response.redirect;
						}
					}else{
						showError("Submit penilai PAK gagal",  response.errorMessage);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(xhr.responseText);
				}
			};
			$.ajax(ajaxSubmitPenilaiPAK);
		}
	);
}

$(document).ready(function(){
	$(".row-penilai").click(function(){
		$("#modal-penilai").modal("hide");
		_onPilihPenilai($(this));
	});
    $(".btn-submit-penilai").click(function(){
        submitPenilaiPAK($(this));
    });
	$("#tabel-penilai-pak").DataTable();
	
	$(".btn-penilai").click(function(){
		let no = $(this).attr("data-no-penilai");
		let idPAK = $(this).attr("data-id-pak");
		let $btn = $(this);
		pilihPenilai(function($penilai){
			let idUser = $penilai.attr("data-id-user");
			let idPegawai = $penilai.attr("data-id-pegawai");
			
			let ajaxPilihPenilai = {
				url: baseUrl + "admin/tentukanPenilai",
				method: 'post',
				data: {
					'idPAK':idPAK,
					'nomor':no,
					'idUser':idUser,
					'idPegawai':idPegawai
				},
				dataType: 'json',
				success: function(response){
					if(response.result=="OK"){
						$btn.removeClass("btn-light btn-primary").addClass("btn-primary");
						idUser = response.idUser;
						$btn.attr("data-id-user", idUser);
						$btn.data("id-user", idUser);
						$btn.data("idUser", idUser);
						$penilai.attr("data-id-user", idUser);
						$penilai.data("id-user", idUser);
						$penilai.data("idUser", idUser);
						$btn.parent().find(".nama-penilai").html($penilai.find(".nama-penilai").html());
					}else{
						showError("Gagal memilih penilai", response.errorMessage);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(xhr.responseText);
				}
			};
			$.ajax(ajaxPilihPenilai);
		}, $btn);
	});
	$("#tabel-penilai-pak").DataTable();
})
