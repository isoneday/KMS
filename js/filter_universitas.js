function selectFakultas(univ_id) {
    if (univ_id != "-1") {
        loadData('fakultas', univ_id);
        $("#jurusan_dropdown").html("<option value='-1'>Pilih Jurusan</option>");
    } else {
        $("#fakultas_dropdown").html("<option value='-1'>Pilih Fakultas</option>");
        $("#jurusan_dropdown").html("<option value='-1'>Pilih Jurusan</option>");
        $("#prodi_dropdown").html("<option value='-1'>Pilih Program Studi</option>");
    }
}

function selectJurusan(fakultas_id) {
    if (fakultas_id != "-1") {
        loadData('jurusan', fakultas_id);
    } else {
        $("#jurusan_dropdown").html("<option value='-1'>Pilih Jurusan</option>");
    }
}

function selectProdi(jurusan_id) {
    if (jurusan_id != "-1") {
        loadData('prodi', jurusan_id);
    } else {
        $("#prodi_dropdown").html("<option value='-1'>Pilih Program Studi</option>");
    }
}

function loadData(loadType, loadId) {
    var dataString = 'loadType=' + loadType + '&loadId=' + loadId;
    $("#" + loadType + "_loader").show();
    $("#" + loadType + "_loader").fadeIn(400).html('Please wait...');
    $.ajax({
        type: "POST",
        url: "loadData",
        data: dataString,
        cache: false,
        success: function(result) {
            alert(result);
            $("#" + loadType + "_loader").hide();
            $("#" + loadType + "_dropdown").html("<option value='-1'>Select " + loadType + "</option>");
            $("#" + loadType + "_dropdown").append(result);
        }
    });
}