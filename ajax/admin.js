
$(document).ready(function () {
    $('#displaybtn').click(function (e){
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "fetch_users.php",
            dataType: "html",
            success: function (row) {
                $('#displaydata').html(row);
            }
        })
    })
});

$(document).ready(function () {
    $('#displaybtndetect').click(function (e){
        TableNotes =$("#tableDetects").DataTable();
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "detect_users.php",
            dataType: "html",
            success: function (row) {
                $('#displaydata').html(row);
            }
        })
    })
});

$(document).ready(function (){
   TableNotes =$("#tableNotes").DataTable();
});

$(document).ready(function (){
    TableDetects =$("#tableDetects").DataTable();
});

$(document).ready(function (){
    TableNotifications =$("#tableNotifications").DataTable();
});







