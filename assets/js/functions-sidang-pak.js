
var $pakSidang = null;
function inputSidang($btn){
	$pakSidang = $btn;
	$modal = $("#modal-sidang");
	$modal.find("#field-url-sidang").val("");
	$modal.modal("show");
}

function onInputHasilSidang(url, setuju){
	let idPAK = parseInt($pakSidang.attr("data-id-pak"));
	let data = {
		'idPAK':idPAK,
		'urlSK':url,
		'setuju':setuju
	};
	let ajaxHasilSidang = {
		url: baseUrl + "admin/inputHasilSidang",
		method: 'post',
		data: data,
		dataType: 'json',
		success: function(response){
			if(response.result == "OK"){
				if(window.location.href == response.redirect){
					window.location.reload();
				}else{
					window.location.href = response.redirect;
				}
			}else{
				showError("Simpan penilaian gagal",  response.errorMessage);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(xhr.responseText);
		}
	};
	$.ajax(ajaxHasilSidang);
}


$(document).ready(function(){
    $(".btn-sidang").click(function(){
		inputSidang($(this));
    });
	$("#btn-sidang-setuju").click(function(){
		let url = $("#modal-sidang").find("#field-url-sidang").val();
		onInputHasilSidang(url, true);
	});
	$("#btn-sidang-tolak").click(function(){
		let url = $("#modal-sidang").find("#field-url-sidang").val();
		onInputHasilSidang(url, false);
	});
	
});