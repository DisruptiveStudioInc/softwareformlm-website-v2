<!-- ============================================== -->
<!-- HERO -->
<!-- ============================================== -->

<section class="hero-pin <?= ($Lang === 'es') ? 'med-h-auto' : 'overlay o-30'; ?>">
  <div class="anchor" id="home"></div>
  <img src="./images/hero/hero.webp" alt="Software for MLM" class="background" />

	<div class="section-arrows">
    <button class="arrow down"></button>
	</div>

  <?php if($Lang === 'en'): ?>
    <div class="text-hero t-c hero-text tc-0">
      <h1 class="h1-special first"><?= $Hero_01; ?></h1>
      <p class="h2 m-center"><?= $Hero_02; ?></p>
    </div>
  <?php endif; ?>

  <?php if($Lang === 'es'): ?>
    <div class="dh med-h-auto of-h rel">

      <div class="video-iframe-wrapper">
        <video class="d-block" id="video" muted loop disablepictureinpicture controlslist="nofullscreen nodownload" >
          <source src="./video/sfmlm_V6_es.webm" type="video/webm" />
        </video>
      </div>

      <button id="video-sound" class="btn-sound abs br-50 d-flex ai-center jc-center p-5">
        <?php include('./includes/iconSound.php') ?>
      </button>
    </div>
  <?php endif; ?>
</section>

<!-- ============================================== -->
<!-- ONE -->
<!-- ============================================== -->

<section>

	<div class="section-arrows">
    <button class="arrow up"></button>
    <button class="arrow down"></button>
	</div>

	<div class="anchor" id="sfmlm"></div>
	<div class="mw-1440 jc-center ai-center min-h-dvh med-h-0 small-pt-40 small-pb-40">
		<div class="t-c">
			<h2 class="h1-special first mb-50 small-mb-30"><?= $Journey_title; ?></h2>
			<ul class="journey-container col-2 g-40 med-g-20 m-center">
        <?php foreach($Sfmlm_about as $item): ?>
          <li class="journey-item c-surf-400 br-16 p-40 med-p-20 pt-0 med-pt-0 t-c">
            <div class="icon-journey c-acc br-50 d-flex ai-center jc-center">
              <svg class="w-70" style="height:auto;aspect-ratio:1"><use href="#<?= $item['icon']; ?>" /></svg>
            </div>
            <h3 class="h4"><?= $item['title']; ?></h3>
            <p class="t-pretty"><?= $item['text']; ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
		</div>
	</div>
</section>

<!-- ============================================== -->
<!-- TWO -->
<!-- ============================================== -->

<section>

  <div class="rel">
    <div class="abs slider-tabs-wrap w-100 d-flex">
      <button id="prevTab" type="button" class="btn c-surf br-8 slider-tabs-nav no-animate">
        <?php include './includes/iconArrow.php'; ?>
      </button>
      <div class="of-h f-grow">
        <ul id="sliderTabs" class="slider-tabs t-c w-100 d-flex">
          <?php foreach($Sfmlm_tabs as $k => $item): ?>
            <li class="tab br-8 p-20 w-100 <?= ($k == 0) ? 'active' : '' ?>">
              <h3 class="h6 m-0"><?= "0".($k+1) ?> <?= $item['title'] ?></h3>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <button id="nextTab" type="button" class="btn c-surf br-8 slider-tabs-nav no-animate">
        <?php include './includes/iconArrow.php'; ?>
      </button>
    </div>
    <div class="tabs-content">
      <ul class="rel tabs-content-wrapper h-dvh t-c">
        <?php foreach($Sfmlm_tabs as $k => $item): ?>
          <li class="abs tabs-content-slide <?= ($k == 0) ? 'active' : '' ?>">
            <div class="rel d-flex fd-col ai-center jc-center overlay o-50 h-100">
              <img class="background" src="./images/body/letters/<?= $item['image']; ?>.webp" alt="<?= $item['title']; ?>">
              <h2 class="tab-content-title z-index-2 tc-acc m-0"><?= $item['title']; ?></h2>
              <p class="tab-content-text h1 fw-700 z-index-2 tc-0 m-0 t-pretty"><?= $item['text']; ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ============================================== -->
<!-- THREE -->
<!-- ============================================== -->

<section>

	<div class="section-arrows">
	    <button class="arrow up"></button>
	    <button class="arrow down"></button>
	</div>

	<div class="mw-1440 t-c h-100 med-h-0 d-flex fd-col jc-center g-40 small-g-20 small-pt-40 small-pb-40">
		<h2 class="h1-special"><?= $Vision_text; ?></h2>
		<ul class="br-16 c-surf-400 d-flex of-h small-fd-col">
      <?php foreach($Sfmlm_vision as $item): ?>
        <li class="vision-item d-flex fd-col jc-center g-0 w-100 p-40 med-p-20 small-pt-40 small-pb-40">
          <h3 class="h4 m-0"><?= $item['title']; ?></h3>
          <div class="vision-text-wrap d-grid col-1">
            <div class="of-h">
              <p class="m-0 pt-10"><?= $item['text']; ?></p>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
	</div>
</section>

<!-- ============================================== -->
<!-- FOUR -->
<!-- ============================================== -->

<section class="c-grad-2-4">
	<div class="section-arrows">
	    <button class="arrow up"></button>
	    <button class="arrow down"></button>
	</div>

	<div class="mw-1280 t-c h-100 med-h-0 jc-center fd-col small-pt-40 small-pb-40">
		<h2 class="h1"><?= $Slogan_title; ?></h2>
		<p class="slogan-text h4 m-center">“<?= $Slogan_text; ?>”</p>
		<a href="<?= $Demo; ?>" target="_blank" class="btn big c-acc br-8 mt-60 small-mt-30" style="gap:8px">
      <?= $Btn_live; ?>
       <?php include './includes/iconArrow.php'; ?>
    </a>
	</div>
</section>

<!-- ============================================== -->
<!-- FIVE -->
<!-- ============================================== -->

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

<!-- ============================================== -->
<!-- SIX -->
<!-- ============================================== -->

<section>
	<div class="wrap-people">
		<div class="mw-1440 p-30 mb-40">
			<h3 class="h3 t-c"><?php echo $Envolvers_title; ?></h3>
		</div>

	<ul class="people">
		<?php foreach ($Logos as $k => $item): ?>
    <li class="item item<?= $k +1; ?>">
      <span class="wrap-logo d-block">
        <img class="m-0" src="./images/body/evolvers/<?= $item['image']; ?>" alt="<?= $item['name']; ?>">
      </span>
    </li>
    <?php endforeach; ?>
	</ul>

	<?php
	$Logos_izquierda = array(
		array('11','Lucy Ugalde',$Testimonial_11),
	    array('12','Mario González',$Testimonial_12),
	    array('13','Tania Ramos',$Testimonial_13),
	    array('14','Luis Cañada',$Testimonial_14),
	    array('15','Bianca Simāo',$Testimonial_15),
	    array('16','Rafael Miranda',$Testimonial_16),
	    array('17','Nuno Sousa',$Testimonial_17),
	    array('18','Fernando Barocio',$Testimonial_18),
	    array('19','Kevin Díaz',$Testimonial_19),
	    array('20','Ali Valenzuela',$Testimonial_20)
	);
	?>

  <?php if(false): ?>
	<ul class="people alreves">
		<?php
		foreach ($Logos_izquierda as $item){
			echo "
			<li class='item item{$item[0]}'>
				<img src='./images/body/evolvers/{$item[0]}.webp' alt='{$item[1]}'>

					<h5>{$item[1]}</h5>
					<p>{$item[2]}</p>

			</li>
			";
		}
		?>
	</ul>
  <?php endif; ?>
	</div>
</section>

<!-- ============================================== -->
<!-- SEVEN -->
<!-- ============================================== -->

<section class="">

	<div class="section-arrows">
	    <button class="arrow up"></button>
	    <button class="arrow down"></button>
	</div>

  <ul>
    <?php foreach($Big_texts as $item): ?>
      <li class="truth-item rel t-c of-h">
        <img class="truth-image" src="./images/body/truth/<?= $item['image']; ?>.webp" alt="<?= $item['title']; ?>">
        <div class="truth-content small-p-20 small-pt-40 small-pb-40">
          <h2 class="truth-title m-0"><?= $item['title']; ?></h2>
          <p class="truth-text h4 m-0 t-pretty"><?= $item['text']; ?></p>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</section>

<!-- ============================================== -->
<!-- EIGHT -->
<!-- ============================================== -->

<section>

	<div class="section-arrows">
	    <button class="arrow up"></button>
	    <button class="arrow down"></button>
	</div>

	<div class="spirit-wrap d-flex med-fd-col min-h-dvh">
		<div class="spirit-banner rel w-50 med-w-100">
			<img src="./images/body/the_spirit/1.webp" alt="" class="background img-spirit active">
			<img src="./images/body/the_spirit/2.webp" alt="" class="background img-spirit">
			<img src="./images/body/the_spirit/3.webp" alt="" class="background img-spirit">
		</div>

		<!-- Textos -->
		<div class="w-50 med-w-100 d-flex fd-col jc-center p-80 med-p-50 small-p-20 small-pt-50 small-pb-50">
			<h2 class="h2 small-t-c mt-0 mb-50"><?= $Spirit_title; ?></h2>
      <ul class="d-flex fd-col g-40">
        <?php foreach($Sfmlm_spirit as $item): ?>
          <li class="spirit-container br-16 c-surf-400 rel">
            <div class="spirit-icon abs c-acc tc-0 p-10 br-50 d-flex ai-center jc-center">
              <svg class="w-90" style="height:auto;aspect-ratio:1"><use href="#<?= $item['icon']; ?>" /></svg>
            </div>
            <h3 class="h4 mt-0"><?= $item['title']; ?></h3>
            <p class="mb-0 t-pretty"><?= $item['text']; ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
		</div>
	</div>
</section>

<!-- ============================================== -->
<!-- NINE -->
<!-- ============================================== -->

<section class="c-grad-1-4">

	<div class="section-arrows">
	    <button class="arrow up"></button>
	</div>

	<div class="mw-1280 t-c big">
		<h2 class="h1 big-last"><?php echo $Traits_title; ?></h2>
		<a href="<?php echo $Demo; ?>" target="_blank" class="btn big c-acc br-8 mt-40 small-mt-20" style="gap:8px">
      <?php echo $Btn_part; ?>
      <?php include './includes/iconArrow.php'; ?>
    </a>
	</div>
</section>

<script>

/* ==============================================
    MODAL
============================================== */
// Función para abrir el modal
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('open'); // Muestra el modal
        document.body.classList.add('no-scroll'); // Bloquea el scroll
    }
}

// Función para cerrar el modal
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('open'); // Oculta el modal
        checkModalsOpen(); // Verifica si hay otros modales abiertos
    }
}

// Función para verificar si hay modales abiertos y desbloquear el scroll
function checkModalsOpen() {
    var openModals = document.querySelectorAll('.modal.open');
    if (openModals.length === 0) {
        document.body.classList.remove('no-scroll'); // Reactiva el scroll
    }
}

// Función para cerrar el modal si se hace clic fuera de él
window.onclick = function(event) {
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        if (event.target === modal) {
            closeModal(modal.id);
        }
    });
};

document.addEventListener("DOMContentLoaded", function () {

    /* ============================================== */
    /* VIDEO HERO */
    /* ============================================== */

    const video = document.getElementById('video')
    const btnSound = document.getElementById('video-sound')

    if(video && btnSound){
      btnSound.addEventListener('click', () => {
        if(video.muted){
          video.muted = false;
          btnSound.classList.add('active');
        } else {
          video.muted = true;
          btnSound.classList.remove('active');
        }
      })
    }

    /* ==============================================
       SCROLL-MAGIC SOLO DESKTOP
    ============================================== */

    if(window.innerWidth >= 1080){

        function loadScript(src){
            return new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = src;
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }

        // Cargar librerías
        Promise.all([
            loadScript("https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"),
            loadScript("https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/ScrollMagic.min.js")
        ])
        .then(() => Promise.all([
            loadScript("https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/plugins/animation.gsap.min.js"),
            loadScript("https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js")
        ]))
        .then(() => {

            var controller = new ScrollMagic.Controller();
            var animationSpeed = 0.75;
            var animationLinear = Power3.easeInOut;
            var animationInOutQuart = Expo.easeInOutQuart;
            var animationIn = Expo.easeIn;

            // ========== PARALLAX
            var parallaxTimeline = new TimelineMax();
            parallaxTimeline
                .fromTo('.parallax .box_1', animationSpeed,{ left:"0%", top:"70%", opacity:0},{ left:"15%", top:"60%", opacity:1, ease:animationIn })
                .fromTo('.parallax .box_2', animationSpeed,{ left:"40%", top:"70%", opacity:0},{ left:"40%", top:"60%", opacity:1, ease:animationIn }, 0)
                .fromTo('.parallax .box_3', animationSpeed,{ left:"80%", top:"70%", opacity:0},{ left:"65%", top:"60%", opacity:1, ease:animationIn }, 0);

            new ScrollMagic.Scene({
                triggerElement: '.parallax',
                duration: "50%",
                triggerHook: 0.5
            })
            .setTween(parallaxTimeline)
            //.addIndicators()
            .addTo(controller);

            // ========== CONTENT SCROLL (jQuery solo si existe)
            if(window.jQuery) {
                $('.products').each(function(){
                    var productsElement = this.querySelector('.wrap_products');
                    if(productsElement){
                        new ScrollMagic.Scene({
                            triggerElement: this,
                            triggerHook: 0.2,
                            duration: "80%"
                        })
                        .setClassToggle(productsElement, 'fade-in')
                        //.addIndicators()
                        .addTo(controller);
                    }
                });
            }


        }).catch(err => console.error("Error cargando scripts ScrollMagic/GSAP:", err));
    }

    /* ==============================================
       PARALLAX TEXTO SOLO EN DESKTOP
    ============================================== */
    function initMouseTrackFloat(selector) {
      const elements = document.querySelectorAll(selector);

      elements.forEach(element => {
        let halfWidth = element.offsetWidth / 2;

        const updateDimensions = () => {
          halfWidth = element.offsetWidth / 2;
        };

        element.addEventListener('mouseenter', (e) => {
          const rect = element.getBoundingClientRect();
          const mouseX = e.clientX - rect.left;
          const xValue = Math.max(-halfWidth, Math.min(halfWidth, mouseX - halfWidth));
          element.style.setProperty('--x', `${xValue}px`);
        });

        element.addEventListener('mousemove', (e) => {
          const rect = element.getBoundingClientRect();
          const mouseX = e.clientX - rect.left;
          const xValue = Math.max(-halfWidth, Math.min(halfWidth, mouseX - halfWidth));
          element.style.setProperty('--x', `${xValue}px`);
        });

        element.addEventListener('mouseleave', () => {
          element.style.setProperty('--x', '0px');
        });

        // Handle resize
        window.addEventListener('resize', updateDimensions);
      });
    }
    initMouseTrackFloat('.truth-item');

     /* ==============================================
       BANNER
    ============================================== */
    const slides = document.querySelectorAll(".img-spirit");
    let currentSlide = 0;
    let intervalSlide;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === index) slide.classList.add("active");
      });
    }

    function nextSlide() {
      setTimeout(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
      }, 600);
    }

    function startSlider() {
      intervalSlide = setInterval(nextSlide, 4000); // cada 4s
    }

    function stopSlider() {
      clearInterval(intervalSlide);
    }

    // Inicialización
    showSlide(currentSlide);
    startSlider();

});
</script>


