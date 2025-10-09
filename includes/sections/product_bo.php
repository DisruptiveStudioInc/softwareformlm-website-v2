<section class="products">

	<div class="of-h">

    <div class="product-timeline-wrap min-h-dvh med-fd-col content-scroll jc-center ai-center rel">

      <?php include('./includes/sections/arrows_lat.php'); ?>

      <img class="background" src="./images/body/subpage/bg_basic.webp" alt="<?= $link_01; ?> background">

      <div class="max-w-1080 rel gap-0 m-center d-flex ai-center med-fd-col med-p-50 med-pt-60 med-pb-60">
        <div class="product-bo rel w-50 med-w-100">
          <a class="product-bo-screen" href="<?= $Demo; ?>" target="_blank" rel="noopener noreferrer">
            <img src="./images/body/products/bo.png" class="" alt="basic" style="background:#f6f7f9;"/>
          </a>
          <span class="btn-plus-bo abs d-block c-acc br-50 p-10" style="height:50px;pointer-events:none;">
            <svg width="30" height="30" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M41.8002 23.0002H27.0002V8.2002C27.0002 7.1002 26.1002 6.2002 25.0002 6.2002C23.9002 6.2002 23.0002 7.1002 23.0002 8.2002V23.0002H8.2002C7.1002 23.0002 6.2002 23.9002 6.2002 25.0002C6.2002 26.1002 7.1002 27.0002 8.2002 27.0002H23.0002V41.8002C23.0002 42.9002 23.9002 43.8002 25.0002 43.8002C26.1002 43.8002 27.0002 42.9002 27.0002 41.8002V27.0002H41.8002C42.9002 27.0002 43.8002 26.1002 43.8002 25.0002C43.8002 23.9002 42.9002 23.0002 41.8002 23.0002Z" fill="white"/>
            </svg>
          </span>
        </div>
        <div class="product-content-wrap w-50 med-w-100 med-pt-30">
          <h2 class="product-bo-title h2 t-pretty"><?= $Product_title; ?></h2>
          <p class="product-bo-text h5"><?= $Product_text; ?></p>
        </div>
      </div>

    </div>
  </div>
</section>