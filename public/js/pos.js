// handle amount due

$(document).ready(function() {
    $('#customerAcc').select2({
        placeholder: 'Select a customer',
        allowClear: true
    });
});

$('#amtDue').text($('#totalAmt').text());

$('#payAmt').keyup(function() {

    var thisChange = 0;
    var amtDue = 0;
    var totalAmt = Number($('#totalAmt').text());

    amtDue = totalAmt - Number($(this).val());
    thisChange = Number($(this).val()) - totalAmt;

    if (amtDue < 0)
    {
        amtDue = 0;
    }

    if (isNaN(amtDue))
    {
        $('#amtDue').text('Error!');
    }

    else
    {
        $('#amtDue').text(amtDue);
    }

    if ($(this).val() >= totalAmt)
    {
        $('#confirmOrder').removeAttr('disabled');
    }

    else
        $('#confirmOrder').attr('disabled', 'disabled');

    $('#payChange').val(thisChange);
    
});

// enter quantity
$(document).on('click', '.add-modal', function() {
    $('#itemID').val($(this).data('id'));
    $('#itemName').val($(this).data('name'));
    $('#itemStocks').val($(this).data('stocks'));
    $('#itemRetail').val($(this).data('retail'));
    $('#itemWholesale').val($(this).data('wholesale'));
    $('#quantAdd').modal('show');
    id = $('#itemID').val();

});

$('.modal-footer').on('click', '.add-this', function() {

    quantity = $('#quantity_add').val();
    name = $('#itemName').val();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        type: 'POST',
        url: '/pos/add',
        data: {
            'id': id,
            'name': name,
            'stocks': $('#itemStocks').val(),
            'quantity': quantity,
            'wholesale': $('#itemWholesale').val(),
            'retail': $('#itemRetail').val()
        },
        success: function(data) {
            if ((data.errors)) {
                $('#quantAdd').modal('show');
                $('.modal-footer').on('click', '.add-close', function () {
                    window.location.href = "/pos";
                });

                if(data.errors.quantity) {
                    $('.errorQuantity').removeClass('hidden');
                    $('.errorQuantity').text(data.errors.quantity);
                }

                if(data.errors.stocks) {
                    $('.errorStocks').removeClass('hidden');
                    $('.errorStocks').text(data.errors.stocks);
                }
            }

            if ((data.error)) {
                $('#errormsg').text(data.error);
                $('#modalError').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                    window.location.href = "/pos";
                });
            }

            else {
                    window.location.href = "/pos";
            }
        }
    });

});

// confirm modal
$(document).on('click', '.confirm-modal', function() {
    $('#paidAmt').text($('#payAmt').val());
    $('#amtChange').text($('#payChange').val());
    $('#paidAmt1').text($('#payAmt').val());
    $('#amtChange1').text($('#payChange').val());
    $('#orderConfirm').modal('show');

});

$('.modal-footer').on('click', '.confirm-this', function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        type: 'POST',
        url: '/pos/confirm',
        data: {
            'id': $('#customerAcc').val(),
            'cust': $('#custNew').val(),
            'reserve': $('#confirmReserve').val(),
        },
        success: function(data) {
            $('#success').text('Successful transaction!');
            $('#myModal2').modal('show');
            $('.modal-footer').on('click', '.close-this', function () {
                    window.location.href = "/pos";
                });
            }
        });

});