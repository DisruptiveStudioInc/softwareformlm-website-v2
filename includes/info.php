<?php

//-------------------------------------------//
// OBTENER PÁGINA ACTUAL Y PARÁMETROS
//-------------------------------------------//

$Actual_Page = !empty($_GET['p']) ? $_GET['p'] : '';
$Actual_Page_Lan = $Actual_Page ? '&p=' . $Actual_Page : '';
$Client_Page_Id = (empty($_GET['id'])) ? '' : '&id=' . $_GET['id'];
$Hide = ($Actual_Page === 'home' || $Actual_Page === '') ? '' : 'none';

//-------------------------//
// CLIENT
//-------------------------//

$Company_Name  = "Software for MLM";

//-------------------------//
// META
//-------------------------//

$Description_Site  = $Description;
$Keywords_Site     = $Keywords;

//-------------------------//
// GENERAL
//-------------------------//

$Host_Site      = $_SERVER["HTTP_HOST"];
$Footer_Rights  = $Company_Name."© ".date("Y").". All rights reserved";

//-------------------------//
// LINKS
//-------------------------//

$Wame    = "https://wa.me/14088584504";
$Demo    = "https://demo.softwareformlm.com/";

// ---------------------------
// Armar bloque HTML dinámico
// ---------------------------
$ref = isset($user_replica) ? "?ref=$user_replica" : '';

//-------------------------//
// VIDEO VIMEO
//-------------------------//

$Video_vimeo = "1112334525";

//-------------------------//
// MENU
//-------------------------//

$Menu = array(
  array('#home','active',$Menu_01),
  array('#sfmlm','',$Menu_02),
  array('#plans','',$Menu_03)
);

//-------------------------//
// SOCIALS
//-------------------------//

$Socials = array(
  'twitter' => 'https://x.com/softwareformlm',
  'facebook' => 'https://www.facebook.com/profile.php?id=61550970312320',
  'instagram' => 'https://www.instagram.com/software.formlm/',
  'linkedin' => 'https://www.linkedin.com/company/90639843/admin/feed/posts/',
  'telegram' => 'https://t.me/+vTvws-qeLfYwNTYx'
);

//-------------------------//
// CONDITIONS
//-------------------------//

$idiomas = [
  'eng' => 'Eng',
  'esp' => 'Esp'
];

$Condicion_lan = isset($idiomas[$idioma]) ? $idiomas[$idioma] : 'Desconocido';

//-------------------------//
// CONTACT
//-------------------------//

$Email = "info@softwareformlm.com";
$Phone = "(1) 408 858 4504";
$Address = "15218 Summit AveSuite 300-527 Fontana CA 92336";

//-------------------------//
// ARRAYS
//-------------------------//

$Sfmlm_about = array(
  [
    'title' => $Journey_title_1,
    'text' => $Journey_text_1,
    'icon' => 'backoffice'
  ],
  [
    'title' => $Journey_title_2,
    'text' => $Journey_text_2,
    'icon' => 'ecommerce'
  ],
  [
    'title' => $Journey_title_3,
    'text' => $Journey_text_3,
    'icon' => 'elearning'
  ],
  [
    'title' => $Journey_title_4,
    'text' => $Journey_text_4,
    'icon' => 'cryptopay'
  ]
);

$Sfmlm_tabs = array(
  [
    'title' => $Letters_title_01,
    'text' => $Letters_text_01,
    'image' => 'estrategia'
  ],
  [
    'title' => $Letters_title_02,
    'text' => $Letters_text_02,
    'image' => 'crecimiento'
  ],
  [
    'title' => $Letters_title_03,
    'text' => $Letters_text_03,
    'image' => 'comunidad'
  ],
  [
    'title' => $Letters_title_04,
    'text' => $Letters_text_04,
    'image' => 'resultados'
  ]
);

$Sfmlm_vision = array(
  [
    'title' => $Vision_title_01,
    'text' => $Vision_text_01
  ],
  [
    'title' => $Vision_title_02,
    'text' => $Vision_text_02
  ],
  [
    'title' => $Vision_title_03,
    'text' => $Vision_text_03
  ]
);

$Modal = array(
  [
    'title' => $Products_title_01,
    'sub' => $Products_sub_01,
    'text' => $Products_text_01,
    'price' => $Products_price_01
  ],
  [
    'title' => $Products_title_02,
    'sub' => $Products_sub_02,
    'text' => $Products_text_02,
    'price' => $Products_price_02
  ],
  [
    'title' => $Products_title_03,
    'sub' => $Products_sub_03,
    'text' => $Products_text_03,
    'price' => $Products_price_03
  ]
);

$Big_texts = array(
  [
    'title' => $Truth_title_01,
    'text' => $Truth_text_01,
    'image' => 'leadership'
  ],
  [
    'title' => $Truth_title_02,
    'text' => $Truth_text_02,
    'image' => 'unlimited'
  ],
  [
    'title' => $Truth_title_03,
    'text' => $Truth_text_03,
    'image' => 'innovation'
  ],
  [
    'title' => $Truth_title_04,
    'text' => $Truth_text_04,
    'image' => 'results'
  ],
);

$Sfmlm_spirit = array(
  [
    'title' => $Spirit_title_01,
    'text' => $Spirit_text_01,
    'icon' => 'strategist'
  ],
  [
    'title' => $Spirit_title_02,
    'text' => $Spirit_text_02,
    'icon' => 'build'
  ],
  [
    'title' => $Spirit_title_03,
    'text' => $Spirit_text_03,
    'icon' => 'leader'
  ],
);

$Logos = array(
  [
    'name' => 'EVO Global',
    'image' => 'logo_evo.svg'
  ],
  [
    'name' => 'Limitless+',
    'image' => 'logo_limitless.svg'
  ],
  [
    'name' => 'Corpsyte',
    'image' => 'logo_corpsyte.svg'
  ],
  [
    'name' => 'iKon',
    'image' => 'logo_ikon.svg'
  ],
  [
    'name' => 'Darevita',
    'image' => 'logo_darevita.svg'
  ]
);

?>
