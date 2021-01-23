<?php
include('header.php');
if(!isset($_SESSION['USER_ID'])){
    redirect(constant('FETCH_PATH').'shop');
}
$error_add_money='';
//prx($_SESSION);

if(isset($_POST['add-money'])){
    $amount=$_POST['amount'];
    $method=$_POST['method'];

    if($amount>0){
        $_SESSION['add_money']='yes';
        if($method=='paytm'){
            $html='<form method="post" action="pgRedirect" name="add_wallet_money" style="display:none;">
            <label>ORDER_ID::*</label>
            <input id="ORDER_ID" tabindex="1" maxlength="20" size="20"
                            name="ORDER_ID" autocomplete="off"
                            value="ADD'.rand(10000,99999999).'">
            <label>CUSTID ::*</label><input id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="'.$_SESSION['USER_ID'].'">
            <label>INDUSTRY_TYPE_ID ::*</label><input id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
            <label>Channel ::*</label><input id="CHANNEL_ID" tabindex="4" maxlength="12"
                            size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
                        <label>txnAmount*</label>
                        <input title="TXN_AMOUNT" tabindex="10"
                            type="text" name="TXN_AMOUNT"
                            value="'.$amount.'">
                        <input value="CheckOut" type="submit"	onclick="">
            * - Mandatory Fields
            </form>
            <script type="text/javascript">
                document.add_wallet_money.submit();
            </script>';
            echo $html;
        }  
    }else{
        $error_add_money='Amount must be greater than 0';
    }
}
?>
<script src="https://js.stripe.com/v3/"></script>

<div class="cart-main-area pt-80 pb-100">
    <div class="container">
        <div class="wallet-main">
            <div class="wallet-inner">
                <h4 class="wallet_heading">Your wallet transactions</h4>
                <div class=" table-content table-responsive empty-cart-append">
                    <?php if(count($wallets)>0){?>
                        <table>
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Added On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach( $wallets as $wallet){
                                    $color='added';
                                    if($wallet['type']=='withdraw'){
                                        $color='withdraw';
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td class="product-thumbnail"><span class="<?php echo $color?>"><?php echo $wallet['amount']?></span></td>
                                        <td class="product-thumbnail"><span class="<?php echo $color?>"><?php echo $wallet['type']?></span></td>
                                        <td class="product-thumbnail"><span class="<?php echo $color?>"><?php echo $wallet['description']?></span></td>
                                        <td class="product-thumbnail"><span class="<?php echo $color?>"><?php echo $wallet['added_on']?></span></td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <?php }else{
                            echo '<h6 class="text-danger no-content mb-100">No transactions!</h6>';
                        }?>
                </div>
            </div>
            <div class="wallet-inner wallet-inner-second">
                <h4 class="wallet_heading wallet_heading_second">Add money to wallet</h4>
                <div class="stripe-form">
                    <form method="post" class="add_money">
                        <div class="mb-30">
                            <input type="number" name="amount" required class="amount add-money-input" placeholder="Amount">
                            <span class="text-danger amount-error"><?php echo $error_add_money?></span>
                        </div>
                        <div class="mb-30">
                            <select name="method" required class="add-money-input input-method">
                                <option value="paytm">Paytm</option>
                                <option value="stripe">Stripe</option>
                            </select>
                        </div>
                        <button class="add-money-btn" type="submit" name="add-money">Add Money</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php');?>
<script>
    alert('This website is in testing phase.\nPaytm wallet test details are\n\nMobile Number: 7777777777\nPassword: Paytm1234\nOTP: 489871\n\nStripe test details are\nCard Number: 4242424242424242\nExpiry Date & CVC: Any number');
    $('.input-method').change(function(){
        if($('.input-method').val()=='stripe'){
            $('.add-money-btn').attr('disabled',true);
            $('.add-money-btn').hide();
            var html=`<form action="charge" method="post" id="payment-form" >
            <div>
                <label for="card-element">
                Credit or debit card
                </label>
                <div id="card-element">
                <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" class="mt-2 text-danger" role="alert"></div>
            </div>

            <button class="add-money-btn  mt-3">Add Money</button>
            </form>`
            $('.stripe-form').append(html);
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
            $('.add-money-btn').attr('disabled',true);
            $('.add-money-btn').text('wait...');

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    $('.add-money-btn').attr('disabled',false);
                    $('.add-money-btn').text('Add money');
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
            hiddenAmount.setAttribute('value', $('.amount').val());
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            hiddenFor.setAttribute('type', 'hidden');
            hiddenFor.setAttribute('name', 'for');
            hiddenFor.setAttribute('value', 'wallet');
            form.appendChild(hiddenInput);
            form.appendChild(hiddenAmount);
            form.appendChild(hiddenFor);


            // Submit the form
            if($('.amount').val()>=5){
                form.submit();
            }
            else{
                    $('.amount-error').text('Amount must be greater than 4');
                    $('.add-money-btn').attr('disabled',false);
                    $('.add-money-btn').text('Add money');
                }
            }

        }else{
            $('.add-money-btn').show();
            $('#payment-form').remove();
        }
    })
</script>
