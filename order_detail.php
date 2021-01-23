<?php
include('header.php');
if(!isset($_SESSION['USER_ID'])){
    redirect(constant('FETCH_PATH').'shop');
}

if(isset($_GET['id']) && $_GET['id']>0){
    $oid=$_GET['id'];
    $rating=array('Bad','Below Average','Average','Good','Very Good');
    $id=$_SESSION['USER_ID'];
    $details=order_detail($oid,'user');
    if(count($details)==0){
        redirect(constant('FETCH_PATH').'order_history');
    }
    //prx($details);
}else{
    redirect(constant('FETCH_PATH').'order_history');
}
?>
<div class="cart-main-area pt-30 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <a href="<?php echo constant('FETCH_PATH')?>order_history" class="order_detail_back">
                <svg class="icon icon-arrow-left2"><use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-arrow-left2"></use></svg>
                <span>Back</span>
                </a>
                <h4 class="wallet_heading">Oder Details</h4>
                    <div class=" table-content table-responsive empty-cart-append">
                        <table>
                            <thead>
                                <tr>
                                    <th class="white-space">S.No</th>
                                    <th class="white-space">Dish</th>
                                    <th class="white-space">Type</th>
                                    <th class="white-space">Quantity</th>
                                    <th class="white-space">Unit Price</th>
                                    <th class="white-space">Total Price</th>
                                    <th class="white-space">Rating</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach( $details as $detail){?>
                                <tr class="text-center">
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $detail['dish']?></td>

                                    <td><?php echo $detail['attribute']?></td>
                                    <td><?php echo $detail['quantity']?></td>
                                    <td><?php echo 'Rs '.$detail['price']?></td>
                                    <td><?php echo 'Rs '.$detail['quantity']*$detail['price']?></td>
                                    <td style="display:flex;justify-content:center;" class="rating_column_<?php echo $detail['dish_detail_id']?>">
                                    <?php
                                    if($detail['order_status']=='delivered'){
                                    $dish=$detail['dish_detail_id'];
                                    $order=$detail['full_order_id'];
                                    $smtm=$con->prepare("select * from rating where order_id='$order' and dish_detail_id='$dish'");
                                    $smtm->execute();
                                    $r=$smtm->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    if(count($r)>0){?>
                                        <span class="rating"><svg class="icon icon-star ">
                                        <use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-star-full"></use></svg>
                                        <span class="rating_name"><?php echo $rating[$r[0]['review']-1]?></span>
                                    <?php
                                    }else{
                                        foreach($rating as $key =>$value){?>

                                        <span class=" rating <?php echo $detail['dish_detail_id']?>_<?php echo $key+1?>" onMouseOver="mouseover(<?php echo $detail['dish_detail_id']?>,<?php echo $key+1?>)"
                                        onMouseLeave="mouseleave(<?php echo $detail['dish_detail_id']?>,<?php echo $key+1?>)"
                                        onClick="clicked(<?php echo $detail['dish_detail_id']?>,<?php echo $key+1?>,<?php echo $detail['full_order_id']?>)">
                                        <svg class="icon icon-star-full "><use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-star-full"></use></svg>
                                        <span class="rating_name"><?php echo $value?></span>
                                        </span>
                                    <?php }}}else{
                                        echo "<span>Only available after delivered</span>";
                                    }?>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
<script>
    let click='no';
    function mouseover(dish_detail_id,value){                    
                    
                        if(click=='no'){
                            for(let m=1;m<=value;m++){
                            $(`.rating.${dish_detail_id}_${m} svg`).css("fill","rgb(228, 209, 36)");
                            $(`.rating.${dish_detail_id}_${m} svg`).css("transition-delay",`${m*0.05}s`);
                            }
                    }
                }
                function mouseleave(dish_detail_id,value){
                    if(click=='no'){
                    for(let m=1;m<=value;m++){
                    $(`.rating.${dish_detail_id}_${m} svg`).css("fill","rgba(194, 189, 189, 0.733)");
                    $(`.rating.${dish_detail_id}_${m} svg`).css("transition-delay",`${.25-m*0.05}s`);
                    }

                }
            }
                function clicked(dish_detail_id,value,full_order_id){
                    if(click=='no'){
                    click="yes";

                    let rate=$(`.${dish_detail_id}_${value} span.rating_name `).text();
                    for(let m=1;m<=value;m++){
                        $(`.${dish_detail_id}_${m} icon `).css("fill","rgb(228, 209, 36)");
                        
                    }
                    $.ajax({
                        url:`${FETCH_PATH}rating`,
                        method:'post',
                        data:`dish_detail_id=${dish_detail_id}&value=${value}&full_order_id=${full_order_id}`,
                        success:function(result){
                        let html=`<span class="rating"><svg class="icon icon-star">
                            <use xlink:href= "${FETCH_PATH}assets/img/sprite.svg#icon-star-full"></use></svg>
                            <span class="rating_name">${rate}</span>`;
                            $(`.rating_column_${dish_detail_id}`).html(html);
                            click="no";
                        }
                    });
                }
            }
</script>
<?php
include('footer.php');?>