<?php
$counter = 1;

foreach ($Modal as $item){
	echo "
	<div id='Modal{$counter}' class='modal'>
	<div class='modal-content rel t-c'>
	<span class='v-white c-pri icon icon-close' onclick=\"closeModal('Modal{$counter}')\"></span>
	<h2 class='h2 tc-pri t-c med-t-l'>{$item['title']}</h2>
	<p class='h5'>{$item['sub']}</p>
	<p>{$item['text']}</p>
	</div>
	</div>
	";
	$counter++;
}
?>

<section class="products">

	<div class="of-h">

    <div class="anchor" id="plans"></div>
    <div class="h-100 med-h-0 med-fd-col content-scroll jc-center ai-center rel wrap_products">

      <div class="section-arrows">
          <button class="arrow up"></button>
          <button class="arrow down"></button>
      </div>

      <div class="box_product img-three">
        <span>
          <button type="button" class="v-white c-acc icon br-50 icon-more" onclick="openModal('Modal1')"></button>
        </span>
        <img src="./images/body/products/basic.webp" class="product" alt="basic"/>
      </div>

      <div class="box_product img-two">
        <span>
          <button type="button" class="v-white c-acc icon br-50 icon-more" onclick="openModal('Modal2')"></button>
        </span>
        <img src="./images/body/products/advanced.webp" class="product" alt="advanced"/>
      </div>

      <div class="box_product img-one">
        <span>
          <button type="button" class="v-white c-acc icon br-50 icon-more" onclick="openModal('Modal3')"></button>
        </span>
        <img src="./images/body/products/premium.webp" class="product" alt="premium"/>
      </div>

      <img class="background med-d-none imgs-product img_product_basic" src="./images/body/subpage/bg_basic.webp" alt="<?php echo $link_01; ?> background">
      <img class="background med-d-none imgs-product img_product_advanced" src="./images/body/subpage/bg_advanced.webp" alt="<?php echo $link_02; ?> background">
      <img class="background med-d-none imgs-product img_product_premium" src="./images/body/subpage/bg_premium.webp" alt="<?php echo $link_03; ?> background">

    </div>
  </div>
</section>