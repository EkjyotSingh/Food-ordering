$('#contact-form').on('submit',function (e){
    e.preventDefault();
    let msg=$('.form-message');
    let form=$('#contact-form');
    $('.contact_button').html('Please wait...');
    $('.contact_button').attr('disabled',true);
    msg.html('');
    $.ajax({
        url:FETCH_PATH+'contact_us_submit',
        type:'POST',
        data:form.serialize(),
        success:function(result){
            $('.contact_button').html('Send Message');
            $('.contact_button').attr('disabled',false);
            form[0].reset();
            msg.html('Thanks for contacting us,we will reach you soon.');
            
        }
});
});
$('.register_form').on('submit',function (e){
    e.preventDefault();
    $('.register_button').html('Please Wait...');
    $('.register_button').attr('disabled',true);
    let form=$('.register_form');
    let user_name=$('.user_name').val();
    let user_email=$('.user_email').val();
    let user_mobile=$('.user_mobile').val();
    let user_password=$('.user_password').val();
    let user_type=$('.user_type').val();
    $('.email').html('');
    $('.form_message').html('');
    $.ajax({
        url:`${FETCH_PATH}login_register_submit`,
        type:'post',
        data:`name=${user_name}&email=${user_email}&mobile=${user_mobile}&password=${user_password}&type=${user_type}`,
        success:function(result){
            let data=$.parseJSON(result);
            $('.register_button').html('Register');
            $('.register_button').attr('disabled',false);
            if(data.status=='success'){
                $(`.${data.error_field}`).html(data.message);
                form[0].reset();
            }
            if(data.status=='error'){
                $(`.${data.error_field}`).html(data.message);
            }
        }
    });
});
                
                
                $('.login_form').on('submit',function (e){
                    e.preventDefault();
                    $('.login_button').html('Please Wait...');
                    $('.login_button').attr('disabled',true);
                    let login_email=$('.login_email').val();
                    let login_password=$('.login_password').val();
                    let login_checkout=$('.login_checkout').val();
                    let login_type=$('.login_type').val();
                    $('.login_message').html('');
                    $('.email_message').html('');
                    $('.password_message').html('');
                    $.ajax({
                        url:`${FETCH_PATH}login_register_submit`,
                        type:'post',
                        data:`email=${login_email}&password=${login_password}&type=${login_type}&checkout=${login_checkout}`,
                        success:function(result){
                            let data=$.parseJSON(result);
                            $('.login_button').html('Login');
                            $('.login_button').attr('disabled',false);
                            if(data.status=='error'){
                                $('.login_password').val('');
                                if(data.error_field=='form'){
                                    $('.login_message').html(data.message);
                                }else if(data.error_field=='email'){
                                    $('.email_message').html(data.message);
                                }else{
                                    $('.password_message').html(data.message);
                                }
                            }
                            if(data.status=='success'){
                                window.location.href=`${FETCH_PATH}shop`;
                            }
                            if(data.status=='checkout'){
                                window.location.href=window.location.href;
                            }
                        }
                    });
                });

                $('.forgot_form').on('submit',function (e){
                    e.preventDefault();
                    $('.forgot_button').html('Please Wait...');
                    $('.forgot_button').attr('disabled',true);
                    let forgot_email=$('.forgot_email').val();
                    let forgot_type=$('.forgot_type').val();
                    $('.forgot_message').html('');
                    $.ajax({
                        url:`${FETCH_PATH}login_register_submit`,
                        type:'post',
                        data:`email=${forgot_email}&type=${forgot_type}`,
                        success:function(result){
                            $('.forgot_button').html('Send');
                            $('.forgot_button').attr('disabled',false);
                            let data=$.parseJSON(result);
                            if(data.status=='success'){
                                $('.forgot_message').html(data.message);
                            }
                            if(data.status=='error'){
                                $('.forgot_message').html(data.message);
                            }
                            
                        }
                    });
                });

                function increment(id){
                    let value=$(`.input-number-${id}`).val();
                    value=parseInt(value);
                    isNaN(value)?value=0:value;
                    value++;
                    $(`.input-number-${id}`).val(value);
                    }

                function decrement(id){
                    let value=$(`.input-number-${id}`).val();
                    if(value!='Qty'){
                        value=parseInt(value);
                        isNaN(value)?value=0:value;
                        value--;
                        value<1?value='Qty':value;
                    }
                    $(`.input-number-${id}`).val(value);

                }

                $(window).on('load',function(){
                    $('.preloader').remove();
                    $('body').css('overflow-y','auto');
                    $('body').css('overflow-x','auto');
                });

                $('.account_form').on('submit',function (e){
                    e.preventDefault();
                    $('.account_button').html('Updating...');
                    $('.account_button').attr('disabled',true);
                    $('.account_message').html('');
                    let account_name=$('.account_name').val();
                    let account_mobile=$('.account_mobile').val();
                    $('.forgot_message').html('');
                    $.ajax({
                        url:`${FETCH_PATH}my_account_submit`,
                        type:'post',
                        data:`mobile=${account_mobile}&name=${account_name}&type=name_details`,
                        success:function(result){
                            $('.account_button').html('Continue');
                            $('.account_button').attr('disabled',false);
                            $('.account_message').html('Your account details has been updated');
                            $('.user_name1').html(`${account_name.substr(0,1).toUpperCase()}${account_name.substr(1)}  <i class="ion-chevron-down"></i>`);
                        }
                    });
                });

                $('.password_form').on('submit',function (e){
                    e.preventDefault();
                    $('.password_button').html('Updating...');
                    $('.password_button').attr('disabled',true);
                    $('.password_message').html('');
                    let old_password=$('.old_password').val();
                    let new_password=$('.new_password').val();
                    let password_confirm=$('.password_confirm').val();
                    $('.forgot_message').html('');
                    
                    if(password_confirm==new_password)
                    {
                        $.ajax({
                        url:`${FETCH_PATH}my_account_submit`,
                        type:'post',
                        data:`old_password=${old_password}&new_password=${new_password}&type=password_details`,
                        success:function(result){
                            $('.password_button').html('Continue');
                            $('.password_button').attr('disabled',false);
                            if(result=='success'){
                                $('.password_message').html('Your password has been updated');
                                window.location.href=`${FETCH_PATH}logout`;
                            }
                            if(result=='error'){
                                $('.password_message').html('Please enter correct old password');
                            }
                        }
                    });
                }else{
                    $('.password_button').html('Continue');
                    $('.password_button').attr('disabled',false);
                    $('.password_message').html('Password and confirm password must be same');
                }
                });
                detail_updates='no';
                payment_updates='no';

                $('.detail_form').on('submit',function(e){
                    e.preventDefault();
                    let checkout_name=$('.checkout_name').val();
                    let checkout_address=$('.checkout_address').val();
                    let checkout_mobile=$('.checkout_mobile').val();
                    let checkout_zipcode=$('.checkout_zipcode').val();
                    let checkout_email=$('.checkout_email').val();
                    let checkout_city=$('.checkout_city').val();
                    $('.detail_button').html('Please wait..');
                    $('.detail_button').attr('disabled',true);
                    $.ajax({
                        url:`${FETCH_PATH}checkout_submit`,
                        method:'post',
                        data:`checkout_name=${checkout_name}&checkout_address=${checkout_address}&checkout_mobile=${checkout_mobile}&checkout_zipcode=${checkout_zipcode}&checkout_email=${checkout_email}&checkout_city=${checkout_city}&type=checkout_detail`,
                        success:function(result){
                            detail_updates='yes';
                            $('.detail_button').html('Next');
                            $('.detail_button').attr('disabled',false);
                            $('#payment-2').removeClass('show');
                            $('#payment-5').addClass('show');
                        }
                    });
                });

                $('.payment_form').on('submit',function(e){
                    e.preventDefault();
                    let checkout_payment=$('input[name="checkout_payment"]:checked').val();
                    $('.payment_button').html('Please wait..');
                    $('.payment_button').attr('disabled',true);
                    $.ajax({
                        url:`${FETCH_PATH}checkout_submit`,
                        method:'post',
                        data:`checkout_payment=${checkout_payment}&type=checkout_payment`,
                        success:function(result){
                            payment_updates='yes';
                            $('.payment_button').html('Next');
                            $('.payment_button').attr('disabled',false);
                            $('#payment-5').removeClass('show');
                            $('#payment-6').addClass('show');
                        }
                    });
                });

                $('.coupon_form').on('submit',function(e){
                    e.preventDefault();
                    $('.coupon-remove').remove();
                    $('.coupon_message').html('');
                    let total_price=$('.total-price').text();
                    let coupon_code=$('.coupon-input').val();
                    let apply_coupon=$('.apply_coupon');
                    apply_coupon.attr('disabled',true);
                    apply_coupon.html('Applying...');
                    if(coupon_code==''){
                        $.ajax({
                            url:`${FETCH_PATH}checkout_submit`,
                            method:'post',
                            data:`type=remove_coupon_code`,
                            success:function(result){
                                $('.coupon_message').html('Please enter coupon code');
                                apply_coupon.attr('disabled',false);
                                apply_coupon.html('Apply &nbsp;Coupon');
                            }
                        });
                        re();
                    }else{
                        $.ajax({
                            url:`${FETCH_PATH}checkout_submit`,
                            method:'post',
                            data:`type=coupon&coupon_code=${coupon_code}`,
                            success:function(result){
                                let data=$.parseJSON(result);
                                if(data.status=="expired"){
                                    re();
                                    $('.coupon_message').html('Coupon expired');
                                }
                                else if(data.status=="minimum_cart"){
                                    re();
                                    $('.coupon_message').html(`Cart minimum value be must be greater than <b>${data.min}</b>`);
                                }else if(data.status=="invalid"){
                                    re();
                                    $('.coupon_message').html('Please enter valid coupon code');
                                }else{
                                    let html=`<td colspan="2" class="text-danger coupon-remove"><span class="text-bold">Coupon:${data.coupon_code}</span></td>
                                    <td colspan="1" class="text-danger coupon-remove"><span class="text-bold">- Rs ${data.discount}</span></td>`;

                                    $('.coupon_message').html(`<b>${data.coupon_code}</b> applied succefully`);

                                    $('.coupon-minus').append(html);

                                    $('.without-coupon').remove();
                                    let html1=`<td class="coupon-remove"><span class="text-bold  amount final-price">Rs ${total_price - data.discount}</span></td>`;
                                    $('.coupon-final').append(html1);

                                }
                                apply_coupon.attr('disabled',false);
                                apply_coupon.html('Apply &nbsp;Coupon');
                            }
                        });
                    }

                });

                function re(){
                    let total_price=$('.total-price').text();
                    let html2=`<td class="coupon-remove"><b>Rs</b>&nbsp;<span class="text-bold amount final-price">${total_price}</span></td>`;
                    $('.without-coupon').remove();
                    $('.coupon-final').append(html2);
                }

                function detail_update(){
                    detail_updates='no';
                }
                function payment_update(){
                    payment_updates='no';
                }

                function place_order(){
                    $('body').css('overflow-y','hidden');
                    $('body').css('overflow-x','hidden');
                    if(detail_updates=='yes'){
                        if(payment_updates=='yes'){
                            if($('input[name="checkout_payment"]:checked').val()=='stripe'){

                                    var html=`<div class="cart_black"><div class="cart_success">
                                    
                                    <form action="${FETCH_PATH}/charge" method="post" id="payment-form" style="height:100%;display:flex;
                                    flex-direction:column;justify-content:space-between;">
                                        <div>
                                        <h3> Amount :${$('.amount').text()}</h3>
                                            <label for="card-element" class=" mt-5">
                                            Credit or debit card
                                            </label>
                                            <div id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                            </div>

                                            <!-- Used to display form errors. -->
                                            <div id="card-errors" class="mt-2 text-danger" role="alert"></div>
                                        </div>

                                        <div>
                                        <h3 class="text-center text-danger mb-3">Place order ?</h3>
                                        <div class="both">
                                            <button class="placed">Place</button>
                                            <button class="both" onclick="remove_message()">Cancel</button>
                                        </div></div>
                                    </form>
                                    </div></div>`;
                                    $('body').append(html);
                                    var stripe = Stripe(`${stripe_key}`);

                                    // Create an instance of Elements.
                                    var elements = stripe.elements();

                                    // Custom styling can be passed to options when creating an Element.
                                    // (Note that this demo uses a wider set of styles than the guide below.)
                                    var style = {
                                    base: {
                                        color: '#32325d',
                                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                        fontSmoothing: 'antialiased',
                                        fontSize: '16px',
                                        '::placeholder': {
                                            color: '#666'
                                        }
                                    },
                                    invalid: {
                                        color: '#fa755a',
                                    }
                                    };

                                    // Create an instance of the card Element.
                                    var card = elements.create('card', {
                                        hidePostalCode: true,
                                        style: style});

                                    // Add an instance of the card Element into the `card-element` <div>.
                                    card.mount('#card-element');
                                    // Handle real-time validation errors from the card Element.
                                    card.on('change', function(event) {
                                    var displayError = document.getElementById('card-errors');
                                    if (event.error) {
                                        displayError.textContent = event.error.message;
                                    } else {
                                        displayError.textContent = '';
                                    }
                                    });

                                    // Handle form submission.
                                    var form = document.getElementById('payment-form');
                                    form.addEventListener('submit', function(event) {
                                    event.preventDefault();
                                    $('.placed').attr('disabled',true);
                                    $('.placed').text('wait...');

                                    stripe.createToken(card).then(function(result) {
                                        if (result.error) {
                                            $('.placed').attr('disabled',false);
                                            $('.placed').text('Add money');
                                        // Inform the user if there was an error.
                                        var errorElement = document.getElementById('card-errors');
                                        errorElement.textContent = result.error.message;
                                        } else {
                                        // Send the token to your server.
                                        stripeTokenHandler(result.token);
                                        }
                                    });
                                    });
                                
                                    // Submit the form with the token ID.
                                    function stripeTokenHandler(token) {
                                    // Insert the token ID into the form so it gets submitted to the server
                                    var form = document.getElementById('payment-form');
                                    var hiddenInput = document.createElement('input');
                                    var hiddenAmount = document.createElement('input');
                                    var hiddenFor = document.createElement('input');
                                    hiddenAmount.setAttribute('type', 'hidden');
                                    hiddenAmount.setAttribute('name', 'amount');
                                    hiddenAmount.setAttribute('value', $('.amount').attr('data-amount'));
                                    hiddenInput.setAttribute('type', 'hidden');
                                    hiddenInput.setAttribute('name', 'stripeToken');
                                    hiddenInput.setAttribute('value', token.id);
                                    hiddenFor.setAttribute('type', 'hidden');
                                    hiddenFor.setAttribute('name', 'for');
                                    hiddenFor.setAttribute('value', 'order');
                                    form.appendChild(hiddenInput);
                                    form.appendChild(hiddenAmount);
                                    form.appendChild(hiddenFor);


                                    // Submit the form
                                    //if($('.amount').attr('data-amount')>=5){
                                        form.submit();
                                    //}
                                }


                            }else{
                                $html=`<div class="cart_black"><div class="cart_success text-center"><h2 class="text-danger">Place Order !</h2><svg class="icon icon-checkbox-checked"><use xlink:href="assets/img/sprite.svg#icon-checkbox-checked"></use></svg><h4>Once placed cannot be cancelled</h4><div class="both"><button class="placed" onclick="order_placed()">Place</button><button class="both" onclick="remove_message()">Cancel</button></div></div></div>`;
                                $('body').append($html);
                            }
                        }else{
                            $html=`<div class="cart_black"><div class="cart_error text-center"><h2 class="text-danger">Error occurred !</h2><svg class="icon icon-cancel-circle"><use xlink:href="assets/img/sprite.svg#icon-cancel-circle"></use></svg><h4>You have not submitted <span class="text-danger">payment information</span></h4><div><button onclick="remove_message()">OK</button></div></div></div>`;
                            $('body').append($html);
                        }
                    }else{
                        $html=`<div class="cart_black"><div class="cart_error text-center"><h2 class="text-danger">Error occurred !</h2><svg class="icon icon-cancel-circle"><use xlink:href="assets/img/sprite.svg#icon-cancel-circle"></use></svg><h4>You have not submitted <span class="text-danger">billing information</span></h4><div><button onclick="remove_message()">OK</button></div></div></div>`;
                        $('body').append($html);
                    }
                }
                function order_placed(){
                    $('.placed').html('Please wait..');
                    $('.placed').attr('disabled',true);
                    $('.both').attr('disabled',true);
                    if($('input[name="checkout_payment"]:checked').val()=='paytm'){
                        window.location.href=`${FETCH_PATH}order_with_paytm?paytm=pp`;
                    }else{
                        $.ajax({
                            url:`${FETCH_PATH}checkout_submit`,
                            method:'post',
                            data:`type=order_placed`,
                            success:function(result){
                                if(result=='success'){
                                    window.location.href=`${FETCH_PATH}success`;
                                }
                                if(result=='error'){
                                    $('.placed').html('Place order');
                                    $('.placed').attr('disabled',false);
                                    $html=`<div class="cart_black"><div class="cart_error text-center"><h2 class="text-danger">Error occurred !</h2><svg class="icon icon-cancel-circle"><use xlink:href="assets/img/sprite.svg#icon-cancel-circle"></use></svg><h4>You cart is <span class="text-danger">empty</span></h4><div><button onclick="redirect()">OK</button></div></div></div>`;
                                    $('body').append($html);
                                }
                            }
                        });
                    }
                }
                function redirect(){
                    window.location.href=window.location.href;
                }
                
                $('.clickable-row').on('click',function(){
                    window.location.href=$(this).attr('data-href');
                })