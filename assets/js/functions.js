function pilihPenilai(idPAK, nomor){
    $("#penilai-modal").modal('show');
}

function onPilihPenilai(idPAK, nomor, idPenilai){
    $("#penilai-modal").modal("hide");
}

function inputHasilSidang(idPAK){
    $("#modal-sidang").modal("show");
}

function onInputHasilSidang(idPAK, setuju){
    $("#modal-sidang").modal("hide");
}

$(document).ready(function(){
    $(".btn-penilai").click(function(){
        pilihPenilai(0,0);
    });
    $(".row-penilai").click(function(){
        onPilihPenilai(0,0,0);
    });
    $(".btn-sidang").click(function(){
        inputHasilSidang(0);
    });
    $("#btn-sidang-setuju").click(function(){
        onInputHasilSidang(0, true);
    });
    $(".btn-sidang-tolak").click(function(){
        onInputHasilSidang(0, false);
    });
})
