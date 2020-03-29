$(document).ready(function () {
    getAllProductsLeft();
    getAllProductsRight();

    $(document).on('click', '#move-to-right', moveToRight);
    $(document).on('click', '#move-to-left', moveToLeft);
    $(document).on('click', '#addCheckbox', addCheckbox);
    $(document).on('click', '#send-request', sendRequest);
})


function getAllProductsLeft() {
    $.ajax({
        url: 'index.php?page=getAllProductsLeft',
        dataType: 'json',
        method: 'GET',
        success: function (data) {
            printProductsLeft(data);
            // console.log(data)
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}
function getAllProductsRight() {
    $.ajax({
        url: 'index.php?page=getAllProductsRight',
        dataType: 'json',
        method: 'GET',
        success: function (data) {
            printProductRight(data);
            // console.log(data)
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function printProductsLeft(data) {
    let html  = '';
    data.forEach(d => {
       html += `
       <div class='single-chb'>
            <label>
                <input type="checkbox" name='single-chb' value="${d.id_product}" id="single-chb">
                <span class='custom-checkbox'></span>
            </label>
            <span class='chb-title'>${d.product}</span>
        </div>
       `
    });

    $("#products-left").html(html);
}

function printProductRight(data) {
    let html = '';
    data.forEach(d => {
       html += `
            <div class='single-chb single-chb-right'>
                <label>
                    <input type="checkbox" name='single-chb' value="${d.id_product}" id="single-chb">
                    <span class='custom-checkbox custom-checkbox-right'></span>
                </label>
                <span class='chb-title chb-title-right'>${d.product}</span>
            </div>
       `
    });
    $('#products-right').html(html);
}

function moveToRight() {
    let products = [];
    $("#products-left").find("[name='single-chb']:checked").each(
        function () {
            products.push($(this).val());
        }
    );

    $.ajax({
        url: 'index.php?page=moveToRight',
        method: 'POST',
        data: {
            products: products
        },
        statusCode: {
          422: function () {
              toastr.error('You must check Products at the LEFT side');
          }
        },
        success: function () {
            getAllProductsLeft();
            getAllProductsRight();
            toastr.success('Products moved to Right');
        },
        error: function (xhr, status ,error) {
            console.log(error);

        }
    })
}

function moveToLeft() {
    let products = [];
    $("#products-right").find("[name='single-chb']:checked").each(
        function () {
            products.push($(this).val());
        }
    );

    $.ajax({
        url: 'index.php?page=moveToLeft',
        method: 'POST',
        data: {
            products: products
        },
        statusCode: {
            422: function () {
                toastr.error('You must check Products at the RIGHT side');
            }
        },
        success: function () {
            getAllProductsLeft();
            getAllProductsRight();
            toastr.success('Products moved to Left');
        },
        error: function (xhr, status ,error) {
            console.log(error);

        }
    })
}

function addCheckbox() {
    $.ajax({
        url: 'index.php?page=addCheckbox',
        method: 'post',
        success: function () {
            toastr.success('Checkbox added');
            getAllProductsLeft();
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function sendRequest() {
    let products = [];
    $("#products-right").find("[name='single-chb']:checked").each(
        function () {
            products.push($(this).val());
        }
    );

    $.ajax({
        url: 'index.php?page=sendRequest',
        method: 'POST',
        data: {
            products: products
        },
        statusCode: {
            422: function () {
                toastr.error('You must check Products at the RIGHT side to delete them');
            }
        },
        success: function () {
            getAllProductsRight();
            toastr.success('Products has been removed');
        },
        error: function (xhr, status ,error) {
            console.log(error);

        }
    })
}