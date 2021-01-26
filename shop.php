<?php
include('header.php');

$category_value='';
$category_value_array=array();
$category_value_string='';
$type='';
if(isset($_GET['input']) && $_GET['input']!=''){
    $category_value=$_GET['input'];
    $category_value_array=array_filter(explode(':',$category_value));
    $category_value_string=implode(',',$category_value_array);
}
if(isset($_GET['type']) && $_GET['type']!=''){
    $type=$_GET['type'];
}?>
<?php 
    $smtm=$con->prepare("select * from category where status='1' order by name asc");
    $smtm->execute();
    $categories=$smtm->fetchAll(PDO::FETCH_ASSOC);
?>
 <div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo constant('FETCH_PATH')?>index">Home</a></li>
                <li class="active">Shop</li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-page-area pb-100">
    <div class="container">
        <div class="filter_section text-center">
            <!--///////////////////categories filter-->
            <div class="dropdown d-lg-none">
                <button class="dropbtn">
                    <span>Filter By Categories</span>
                    <svg class="icon icon-play3 ml-2"><use xlink:href="<?php echo constant('FETCH_PATH').'assets/img/sprite.svg#icon-play3'?>"></use></svg>
                </button>
                <ul class="dropdown-content text-left">
                    <li><a href="<?php echo constant('FETCH_PATH')?>shop"><u>Clear All</u></a></li>
                    <!--//////////////////Category Checkbox-->
                    <?php
                    foreach($categories as $category){
                        $checked='';
                        if(in_array($category['id'],$category_value_array)){
                            $checked='checked="checked"';
                            }?>
                        <li onclick="category(<?php echo $category['id']?>,'')">
                            <input id="<?php echo $category['id']?>" type="checkbox" <?php echo $checked?> class="inputfield">
                            <label  class="category-link"><?php echo $category['name']?></label>
                        </li>
                    <?php }?>
                </ul>
            </div>
                <!--/////////////////////Veg,Non-veg,both filter-->
            <div class="type ml-auto">
                <?php
                $dish_type=array('veg','non-veg','both');
                foreach($dish_type as $dish_types){
                    $checked='';
                    if($type==$dish_types){
                        $checked='checked="checked"';
                    }
                    ?>
                    <div>
                        <input id="<?php echo $dish_types?>" type="radio"<?php echo $checked?> class="inputfield mr-0" onclick="dish_type('<?php echo $dish_types?>')" name="type">
                        <label style="cursor:pointer" class="<?php echo $dish_types?>  mb-0" for="<?php echo $dish_types?>"><?php echo strtoupper($dish_types)?></label>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <!--<div class="banner-area pb-30">
                    <a href="product-details.html"><img alt="" src="assets/img/banner/banner-49.jpg"></a>
                </div>-->
                <div class="grid-list-product-wrapper">
                    <div class="product-grid product-view pb-20">
                        <div class="row">
                            <?php
                            
                            if(isset($search_input) && $search_input!=''){
                                $sql="select dish.*,dish_detail.dish_id,dish_detail.attribute from dish,dish_detail where dish.status='1' and dish_detail.status='1' and dish_detail.dish_id=dish.id and (dish.dish like '%$search_input%' or dish_detail.attribute like '%$search_input%') group by(dish.id)";
                            }else{
                                $sql="select * from dish where status='1' ";
                                if(isset($category_value_string) && $category_value_string!=''){
                                    $sql.="and category_id in ($category_value_string)";
                                }
                                if(isset($type) && $type!='' && $type!='both'){
                                    $sql.="and type ='$type'";
                                }
                            }
                            
                            $smtm=$con->prepare($sql);
                            $smtm->execute();
                            $dish_row=$smtm->fetchAll(PDO::FETCH_ASSOC);
                            foreach($dish_row as $dish){
                            ?>
                            <div class="product-width  col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                <div class="product-wrapper">
                                    <div class="product-img mb-0">
                                        <a href="<?php echo constant('DISH_FETCH').$dish['image']?>" target="_blank">
                                            <img src="<?php echo constant('DISH_FETCH').$dish['image']?>" alt="">
                                        </a>
                                    </div>
                                    <div class="product-wrapper">
                                        <?php echo ratings($dish['id']);?>
                                        <div class="product-header">
                                            <h6 style="margin-bottom:0;">
                                                <a href="javascript:void(0)" class="product-name-link"><?php echo $dish['dish']?></a>
                                                <!--//////////////veg,non-veg svg-->
                                                <svg class="icon <?php echo $dish['type']?>-icon-leaf ml-10"><use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-leaf"></use></svg> 
                                            </h6>
                                            <span title="Click for adding item to cart" style="display:flex;justify-content:space-between;align-items:center;">
                                                <button class="cart_add_button" onclick="add_to_cart(<?php echo $dish['id']?>,'add')">Add</button>
                                            </span>
                                        </div>
                                        <div class="qty">
                                            <span class="input-number-decrement input-number-decrement-<?php echo $dish['id']?>" onclick="decrement(<?php echo $dish['id']?>)">
                                                –
                                            </span>
                                            <input class="input-number input-number-<?php echo $dish['id']?>"readonly  value="Qty" type="text">
                                            <span class="input-number-increment input-number-increment-<?php echo $dish['id']?>" onclick="increment(<?php echo $dish['id']?>)">
                                                +
                                            </span>
                                        </div>
                                            <!--////////////////////////Dishes-->
                                        <div class="dish_detail mt-10">
                                            <?php
                                            $id=$dish['id'];
                                            $smtm=$con->prepare("select * from dish_detail where dish_id='$id'");
                                            $smtm->execute();
                                            $dish_detail_rows=$smtm->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($dish_detail_rows as $dish_detail){
                                                $disabled='';
                                                $disable='';
                                                $title='';
                                                if($dish_detail['status']=='0'){
                                                    $disable='text-secondary';
                                                    $disabled='disabled';
                                                    $title='title="Not available"';
                                            }
                                            ?>
                                            <!--////////////Dish Radio button-->
                                                    <span class="inner-dish-detail mb-5">
                                                        <span class="" <?php echo $title?>>
                                                            <input type="radio" <?php echo $disabled?> value="<?php echo $dish_detail['id']?>" id="<?php echo $dish_detail['id']?>" class="inputfield" name="radio_<?php echo $dish['id']?>">
                                                            <label class="mb-0 <?php echo $disable?>" for="<?php echo $dish_detail['id']?>"><?php echo $dish_detail['attribute']?></label>
                                                            <?php
                                                            if(array_key_exists($dish_detail['id'],$cartarray)){?>
                                                                <span class="added-item" id="added-item-<?php echo $dish_detail['id']?>">(Added-<?php echo $cartarray[$dish_detail['id']]['quantity']?>)</span>
                                                                <?php }else{?>
                                                                <span class="added-item" id="added-item-<?php echo $dish_detail['id']?>"></span>
                                                                <?php }?>
                                                        </span>
                                                        <span class="product-price <?php echo $disable?>" <?php echo $title?>>Rs.<?php echo $dish_detail['price']?></span>
                                                    </span>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Shop By Categories</h4>
                        <div class="shop-catigory">
                            <ul id="faq">
                                <li class="category-list">
                                    <a href="<?php echo constant('FETCH_PATH')?>shop"><u>Clear All</u></a>
                                </li>
                                <!--//////////////////Category Checkbox-->
                                <?php
                                foreach($categories as $category){
                                    $checked='';
                                    if(in_array($category['id'],$category_value_array)){
                                        $checked='checked="checked"';
                                        }?>
                                    <li>
                                        <input id="<?php echo $category['id']?>" type="checkbox" <?php echo $checked?>onclick="category(<?php echo $category['id']?>,'')" class="inputfield">
                                        <label for="<?php echo $category['id']?>" class="category-link"><?php echo $category['name']?></label>
                                    </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="get" class="category_form">
    <input type="hidden" name="input" class="input_category" value="<?php echo $category_value?>">
    <input type="hidden" name="type" class="dish_type_value" value="<?php echo $type?>">
</form>
<script>
////////for category selection//////
    function category(id){
        let input=$('.input_category').val();
        $check=input.search(":"+id);
        if($check=='-1'){
            input=input+":"+id;
        }else{
            input=input.replace(":"+id,"");
        }
        $('.input_category').val(input);
        $('.category_form')[0].submit();
    }
    ////for veg non-veg///////
    function dish_type(type){
        $('.dish_type_value').val(type);
        $('.category_form')[0].submit();
    }
</script>
<?php
include('footer.php');?>