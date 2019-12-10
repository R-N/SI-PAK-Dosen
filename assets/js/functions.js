
var getUrl = window.location;
var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

function scrollTo(el){
	$('html, body').animate({
		scrollTop: $(el).offset().top
	}, 750);
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
function showNotif(title, content){
	$modal = $("#modal-notif");
	$modal.find(".modal-title").text(title);
	$modal.find(".modal-body").html(content);
	$modal.modal("show");
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

var onInput = null;
function askInput(title, text, placeholder, initialValue, onConfirm){
	$modal = $("#modal-input");
	$modal.find(".modal-title").html(title);
	$modal.find(".modal-body p").html(text);
	$input = $modal.find(".modal-body input");
	$input.attr("placeholder", placeholder);
	$input.val(initialValue);
	onInput = onConfirm;
	$btnConfirm = $modal.find(".btn-confirm");
	$modal.modal("show");
}

$(document).ready(function(){
	$modalInput = $("#modal-input")
	$modalInput.find("#btn-confirm-input").click(function(){
		let inpnut = $modalInput.find("input").val();
		if(inpnut == ""){
			showError("Error", "Input tidak boleh kosong");
			return;
		}
		onInput(inpnut);
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
	$(".table-datatable").DataTable();
})
