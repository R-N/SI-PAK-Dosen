
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
				showError("Login Gagal",  response.errorMessage);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(xhr.responseText);
		}
	};
    $.ajax(loginData);
}
$(document).ready(function(){
	$("#form-login").submit(function(e){
		e.preventDefault();
		login($(this));
	});
});