import "./widgets.js";
import "./third-parties.js";

if (document.getElementById("subcategories-swiper")) {
  import("./home-native-sliders.js");
}

if (document.querySelector("[data-service-slider]")) {
  import("./service-native-slider.js");
}
