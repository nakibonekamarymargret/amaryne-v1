$(function () {
    $('#modalButton').click(function () { 
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr("value"));
    });
    $("#addServiceModal").on("show.bs.modal", function () {
      $("#salonDetailsModal").modal("hide");
    });

    $("#editSalonModal").on("show.bs.modal", function () {
      $("#salonDetailsModal").modal("hide");
    });
});
