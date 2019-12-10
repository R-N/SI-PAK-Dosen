
function submitPenilai(){
	$myForm = $("#form-penilai");
	$myForm.removeClass("was-validated");
	if(! $myForm[0].checkValidity()) {
		$myForm.find(':submit').trigger("click", [false]);
	}else if (validatePenilai()){
		askConfirmation("Submit Penilai", "Apa Anda yakin ingin submit?<br>Proses ini tidak dapat dibatalkan.", onSubmitPenilai);
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

$(document).ready(function(){
    $("#btn-submit-pendaftaran-penilai").click(function(e){
		e.preventDefault();
        submitPenilai();
    });
	$("#form-penilai").submit(function(e){
		e.preventDefault();
	});
});