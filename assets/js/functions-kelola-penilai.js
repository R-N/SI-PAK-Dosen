
function suspendPenilai($row){
	let idUser = $row.attr("data-id-user");
	let nama = $row.find(".nama-penilai").html();
	
	askInput(
		"Suspend Penilai", 
		"Jika Anda yakin ingin men-suspend " + nama + ", masukkan alasan lalu klik suspend.", 
		"Alasan",
		"",
		function(alasan){
			
			let ajaxSuspend = {
				url: baseUrl + "admin/suspendPenilai",
				method: 'post',
				data: {
					'idPenilai':idUser,
					'alasan':alasan
				},
				dataType: 'json',
				success: function(response){
					if(response.result == "OK"){
						if(window.location.href == response.redirect){
							window.location.reload();
						}else{
							window.location.href = response.redirect;
						}
					}else{
						showError("Suspend gagal",  response.errorMessage);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(xhr.responseText);
				}
			};
			$.ajax(ajaxSuspend);
		}
	);
}

function aktifkanPenilai($row){
	let idUser = $row.attr("data-id-user");
	let nama = $row.find(".nama-penilai").html();
	askConfirmation(
		"Aktifkan Penilai", 
		"Apa Anda yakin ingin mengaktifkan " + nama + "?", 
		function(alasan){
			
			let ajaxAktifkan = {
				url: baseUrl + "admin/aktifkanPenilai",
				method: 'post',
				data: {
					'idPenilai':idUser
				},
				dataType: 'json',
				success: function(response){
					if(response.result == "OK"){
						if(window.location.href == response.redirect){
							window.location.reload();
						}else{
							window.location.href = response.redirect;
						}
					}else{
						showError("Aktifkan gagal",  response.errorMessage);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(xhr.responseText);
				}
			};
			$.ajax(ajaxAktifkan);
		}
	);
}



$(document).ready(function(){
    $(".btn-suspend-penilai").click(function(){
        suspendPenilai($(this).parent().closest(".row-penilai-kelola"));
    });
    $(".btn-aktifkan-penilai").click(function(){
        aktifkanPenilai($(this).parent().closest(".row-penilai-kelola"));
    });
});