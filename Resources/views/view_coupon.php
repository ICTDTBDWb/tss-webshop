<div class="d-flex flex-column m-4 mt-2">
    <h2>Cadeaubon Toevoegen</h2>
    <div class="mb-3">
        <label for="code" class="form-label">Code</label>
        <input type="text" class="form-control" id="code" name="code" maxlength="25" >
        <div class="invalid-feedback" id="codeValidationMsg">Code is verplicht.</div>
    </div>
    <div class="mb-3">
        <label for="pin" class="form-label">Pin</label>
        <input type="password" class="form-control" id="pin" name="pin" maxlength="11" >
        <div class="invalid-feedback" id="pinValidationMsg">Pin is verplicht.</div>
    </div>
    <div class="mb-3">
        <label for="bedrag" class="form-label">Bedrag</label>
        <input type="number" class="form-control" id="bedrag" name="bedrag" step="0.01" >
        <div class="invalid-feedback" id="bedragValidationMsg">Bedrag is verplicht.</div>
    </div>
    <button type="button" class="btn btn-primary" id="validateCoupon">Valideren</button>
    <div id="couponResultMessage"></div>
</div>


<script>
    $(document).ready(function() {

        // Add coupon
        $('#validateCoupon').on('click', function() {
            var code = $('#code').val();
            var pin = $('#pin').val();
            var bedrag = $('#bedrag').val();

            var codeValid = code.length > 0;
            var pinValid = pin.length > 0;
            var bedragValid = bedrag.length > 0;

            if (!codeValid) {
                $('#codeValidationMsg').show();
            } else {
                $('#codeValidationMsg').hide();
            }

            if (!pinValid) {
                $('#pinValidationMsg').show();
            } else {
                $('#pinValidationMsg').hide();
            }

            if (!bedragValid) {
                $('#bedragValidationMsg').show();
            } else {
                $('#bedragValidationMsg').hide();
            }

            if (codeValid && pinValid && bedragValid) {
                $.ajax({
                    type: 'POST',
                    url: '/coupon.php',
                    data: {
                        code: code,
                        pin: pin,
                        bedrag: bedrag,
                        method: 'add'
                    },
                    success: function(response) {

                        var removeButton = "<button type='button' class='btn btn-outline-danger added-coupon-remove-button' attr-coupon-code='" + code + "' attr-coupon-bedrag='" + bedrag + "'>" +
                            "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>" +
                                "<path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'></path>" +
                                "<path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'></path>" +
                                "</svg></button>";

                        $('#couponResultMessage').html(response);

                        // Update added coupons section
                        $('#addedCouponsSection').append(
                            '<div class="d-flex flex-grow-1 flex-row my-1 added-coupon" attr-coupon-code="' + code + '">' +
                            '<div class="flex-grow-1" style="flex-basis: 0;">' + code + '</div>' +
                            '<div class="flex-grow-1" style="flex-basis: 0;">' + bedrag + '</div>' +
                              removeButton +
                            '</div>'
                        );

                        // Update total price after adding the coupon value
                        var totalPrice = parseFloat($('#totalPrice').text());
                        var couponValue = parseFloat(bedrag);
                        $('#totalPrice').text(totalPrice - couponValue);
                    },
                    error: function(xhr, status, error) {
                        $('#couponResultMessage').html( xhr.responseText );
                    }
                });
            }
        });
    });

    // Remove coupon
    $(document).on('click', '.added-coupon-remove-button', function() {
        var code = $(this).attr('attr-coupon-code');
        var bedrag = $(this).attr('attr-coupon-bedrag');
        $.ajax({
            type: 'POST',
            url: '/coupon.php',
            data: {
                code: code,
                method: 'remove'
            },
            success: function(response) {
                $('#couponResultMessage').html(response);
                $(".added-coupon[attr-coupon-code='" + code + "']").remove();


                // Update total price after adding the coupon value
                var totalPrice = parseFloat($('#totalPrice').text());
                var couponValue = parseFloat(bedrag);

                $('#totalPrice').text(totalPrice - couponValue);
            },
            error: function(xhr, status, error) {
                $('#couponResultMessage').html( xhr.responseText );
            }
        });
    });


</script>