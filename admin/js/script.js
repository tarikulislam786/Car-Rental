


// READ records
function readCartypeRecords() {
    $.get("ajax/Cartype/readRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}

function readCarFeatureRecords() {
    $.get("ajax/Carfeatures/readRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}

function readCarRecords() {
    $.get("ajax/Car/readRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}

function DeleteCarDetails(id) {
    var conf = confirm("Are you sure, do you really want to delete?");
    if (conf == true) {
        $.post("ajax/Car/deleteCar.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readCarRecords();
            }
        );
    }
}

function DeleteRoomtypeDetails(id) {
    var conf = confirm("Are you sure, do you really want to delete?");
    if (conf == true) {
        $.post("ajax/Roomtype/deleteRoomtype.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRoomTypeRecords();
            }
        );
    }
}

function DeleteCartypeDetails(id) {
    var conf = confirm("Are you sure, do you really want to delete?");
    if (conf == true) {
        $.post("ajax/Cartype/deleteCartype.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readCartypeRecords();
            }
        );
    }
}


$(document).ready(function () {
    // READ recods on page load
    var url = document.location.href;
    if (url== 'http://localhost/carrental/admin/cartype-manage.php' || url== 'http://localhost/carrental/admin/cartype-manage.php?success=1' || url== 'http://localhost/carrental/admin/cartype-manage.php?fkeyconstraintG=1' || url== 'http://localhost/carrental/admin/cartype-manage.php?#') {
      readCartypeRecords();
    }if(url== 'http://localhost/carrental/admin/car-features-manage.php' ||  url=='http://localhost/carrental/admin/car-features-manage.php?success=1' || url== 'http://localhost/carrental/admin/car-features-manage.php?fkeyconstraint=1') {
        readCarFeatureRecords(); // calling function
    }if(url== 'http://localhost/carrental/admin/car-manage.php' || url=='http://localhost/carrental/admin/car-manage.php?success=1') {
        readCarRecords(); // calling function
    }

    
    // Pagination initiates
 $.ajax({
 url:"ajax/Cartype/pagination.php",
 type:"POST",
 data:"actionfunction=showData&page=1",
 cache: false,
 success: function(response){

 $('#pagination').html(response);

 }

 });
 $('#pagination').on('click','.page-numbers',function(){
 $page = $(this).attr('href');
 $pageind = $page.indexOf('page=');
 $page = $page.substring(($pageind+5));

 $.ajax({
 url:"ajax/Cartype/pagination.php",
 type:"POST",
 data:"actionfunction=showData&page="+$page,
 cache: false,
 success: function(response){

 $('#pagination').html(response);

 }

 });
 return false;
 });
});