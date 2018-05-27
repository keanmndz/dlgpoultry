$(document).ready(function() { 
  $('.choose-item').select2({ 
    placeholder: "Select an item", 
    allowClear: true 
  }); 

  $('.choose-itemr').select2({ 
    placeholder: "Select an item", 
    allowClear: true 
  }); 

  $('.itemp-remarks').select2({ 
    placeholder: "Select an item", 
    allowClear: true 
  }); 

  $('.itemr-remarks').select2({ 
    placeholder: "Select an item", 
    allowClear: true 
  }); 
}); 

// update price
$('.update-this').on('click', function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        type: 'POST',
        url: '/inventory/update-price',
        data: {
            'id': $('#itemprice').val(),
            'name': $('#itemprice').find(':selected').data('name'),
            'price': $('#price_update').val(),
            'remarks': $('#itemprice_remarks').val(),
            'type': $('.choose-item').find(':selected').data('type')
        },
        success: function(data) {
            if ((data.errors)) {
                $('.cancel-this').on('click', function () {
                    window.location.href = "/vet/medicines";
                });

                if(data.errors.price) {
                    $('.errorPrice3').removeClass('hidden');
                    $('.errorPrice3').text(data.errors.price);
                }

            }

            else {

            $('#success').text('Successfully updated price of this item!');
            $('#myModal2').modal('show');
            $('.modal-footer').on('click', '.close-this', function () {
                    window.location.href = "/vet/medicines";
                });
            }
        }
    });
});

// update reorder level
$('.update-reorder').on('click', function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        type: 'POST',
        url: '/inventory/update-reorder',
        data: {
            'id': $('#itemr').val(),
            'name': $('#itemr').find(':selected').data('name'),
            'reorder': $('#reorder_update').val(),
            'type': $('#itemr').find(':selected').data('type')
        },
        success: function(data) {
            if ((data.errors)) {
                $('.cancel-update').on('click', function () {
                    window.location.href = "/vet/medicines";
                });

                if(data.errors.reorder) {
                    $('.errorReorder2').removeClass('hidden');
                    $('.errorReorder2').text(data.errors.reorder);
                }

            }

            else {

            $('#success').text('Successfully updated reorder level of this item!');
            $('#myModal2').modal('show');
            $('.modal-footer').on('click', '.close-this', function () {
                    window.location.href = "/vet/medicines";
                });
            }
        }
    });
});

$('#remarks_use').change(function() {
    var option = $(this).find("option:selected").val();

    if (option == 'Others')
    {
        $('#remarks_use1').removeClass('hidden');
        $('#remLabel').removeClass('hidden');
    }

    else
    {
        $('#remarks_use1').addClass('hidden');
        $('#remLabel').addClass('hidden');
    }
});


// add feeds/meds
$(document).on('click', '.add-modal1', function() {
	$('#type_add1').val($(this).data('type'));
    $('#addInv1').modal('show');
    typeAdd = $('#type_add1').val();

});

// for feeds/meds
$('.modal-footer').on('click', '.add-this1', function() {

	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});

    $.ajax({
        type: 'POST',
        url: '/inventory/add',
        data: {
        	'name': $('#name_add').val(),
        	'price': $('#price_add').val(),
        	'quantity': $('#quantity_add').val(),
        	'unit': $('#unit_add').val(),
        	'reorder_level': $('#reorder_add').val(),
            'remarks': $('#remarks_add').val(),
        	'type': typeAdd
        },
        success: function(data) {
        	if ((data.errors)) {
        		$('#addInv1').modal('show');
        		$('.modal-footer').on('click', '.add-close', function () {
                    window.location.href = "/vet/medicines";
                });

        		if(data.errors.name) {
        			$('.errorName').removeClass('hidden');
                    $('.errorName').text(data.errors.name);
        		}

        		if(data.errors.price) {
        			$('.errorPrice').removeClass('hidden');
                    $('.errorPrice').text(data.errors.price);
        		}

        		if(data.errors.quantity) {
        			$('.errorQuantity').removeClass('hidden');
                    $('.errorQuantity').text(data.errors.quantity);
        		}

        		if(data.errors.reorder_level) {
        			$('.errorReorder').removeClass('hidden');
                    $('.errorReorder').text(data.errors.reorder_level);
        		}

                if(data.errors.remarks) {
                    $('.errorRemarks').removeClass('hidden');
                    $('.errorRemarks').text(data.errors.remarks);
                }
        	}

        	else {

            $('#success').text('Successfully added this item!');
            $('#myModal2').modal('show');
            $('.modal-footer').on('click', '.close-this', function () {
                    window.location.href = "/vet/medicines";
                });
        	}
        }
    });
});

// add more
$(document).on('click', '.more-modal', function() {
    $('#type_more').val($(this).data('type'));
    $('#id_more').val($(this).data('id'));
    $('.moreName').text($(this).data('name'));
    $('#addQuant').modal('show');
    typeMore = $('#type_more').val();
    idMore = $('#id_more').val();
});

// add more functions
$('.modal-footer').on('click', '.add-more', function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        type: 'POST',
        url: '/inventory/add-quantity',
        data: {
            'name': $('.moreName').text(),
            'quantity': $('#quantity_more').val(),
            'remarks': $('#remarks_more').val(),
            'type': typeMore,
            'id': idMore
        },
        success: function(data) {
            if ((data.errors)) {
                $('#addQuant').modal('show');
                $('.modal-footer').on('click', '.add-close', function () {
                    window.location.href = "/vet/medicines";
                });

                if(data.errors.quantity) {
                    $('.validQuantity').removeClass('hidden');
                    $('.validQuantity').text(data.errors.quantity);
                }

                if(data.errors.remarks) {
                    $('.validRemarks').removeClass('hidden');
                    $('.validRemarks').text(data.errors.remarks);
                }
            }

            else {

            $('#success').text('Successfully added quantities!');
            $('#myModal2').modal('show');
            $('.modal-footer').on('click', '.close-this', function () {
                    window.location.href = "/vet/medicines";
                });
            }
        }
    });

});

// update item
$(document).on('click', '.use-modal', function() {
    $("#useInput").attr({
        "max": $(this).data('quantity')
    });
    $('#type_use').val($(this).data('type'));
    $('#id_use').val($(this).data('id'));
    $('.useName').text($(this).data('name'));
    $('#useInv').modal('show');
    typeUse = $('#type_use').val();
    idUse = $('#id_use').val();
});

$('.modal-footer').on('click', '.use-this', function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        type: 'POST',
        url: '/inventory/use-quantity',
        data: {
            'name': $('.useName').text(),
            'quantity': $('#useInput').val(),
            'remarks': $('#remarks_use').val() + '. ' + $('#remarks_use1').val(),
            'type': typeUse,
            'id': idUse
        },
        success: function(data) {
            if ((data.errors)) {
                $('#useInv').modal('show');
                $('.modal-footer').on('click', '.use-close', function () {
                    window.location.href = "/vet/medicines";
                });

                if(data.errors.quantity) {
                    $('.usevalidQuant').removeClass('hidden');
                    $('.usevalidQuant').text(data.errors.quantity);
                }

                if(data.errors.remarks) {
                    $('.usevalidRemarks').removeClass('hidden');
                    $('.usevalidRemarks').text(data.errors.remarks);
                }
            }

            if ((data.error))
            {
                $('#errormsg').text(data.error);
                $('#modalError').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                    window.location.href = "/vet/medicines";
                });
            }

            else {

            $('#success').text('Successfully updated quantities!');
            $('#myModal2').modal('show');
            $('.modal-footer').on('click', '.close-this', function () {
                    window.location.href = "/vet/medicines";
                });
            }
        }
    });

});

// view more info
$(document).on('click', '.view-modal', function() {
    $('#added_more').text($(this).data('added'));
    $('#created_more').text($(this).data('create'));
    $('#updated_more').text($(this).data('update'));
    $('#expiry_date').text($(this).data('expiry'));
    $('.viewName').text($(this).data('name'));
    $('#viewInv').modal('show');
});

// SEARCH ALL

function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInputInv");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Search
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

function myFunctionActs() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  var chooseFilter = $('#chooseFilter').val();
  input = document.getElementById("myInputActs");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTableActs");
  tr = table.getElementsByTagName("tr");

  // Search
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[choose];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}