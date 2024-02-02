var imgInput = document.querySelector(".img"),
    file = document.getElementById("imgInput")



file.onchange = function() {
    if (file.files[0].size < 1000000) {
        var fileReader = new FileReader();

        fileReader.onload = function(e) {

            imgUrl = e.target.result;
            imgInput.src = imgUrl;
        }
        fileReader.readAsDataURL(file.files[0]);
    } else {

        alert("This file is too large! ");

    }
};


$(document).ready(function() {
    $('.editbtn').on('click', function() {

        $('#editmodal').modal('show');


        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);


        // $('#Image').val(data[1]);
        $('#id').val(data[0]);
        $('#Name').val(data[2]);
        $('#Phone').val(data[3]);
        $('#Email').val(data[4]);
        $('#Organization').val(data[5]);
        $('#Province').val(data[6]);
        $('#City').val(data[7]);
        $('#Brgy').val(data[8]);
        $('#Street').val(data[9]);

    });

});

$(document).ready(function() {
    $('.deletebtn').on('click', function() {
        $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#delete_id').val(data[0]);



    });

});