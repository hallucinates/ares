const toggleSwitch = document.querySelectorAll(
  '.theme-switch input[type="checkbox"]'
);

const currentTheme = localStorage.getItem("theme");
const iconSwitch = document.querySelector(".switch-icon").querySelector("i");

if (currentTheme) {
  document.documentElement.setAttribute("data-theme", currentTheme);
  if (currentTheme === "dark") {
    toggleSwitch.forEach((tgl) => {
      tgl.checked = true;
      iconSwitch.classList.replace("bi-brightness-high", "bi-moon-fill");
      iconSwitch.classList.replace("yellowprim", "darkbl");
    });
  }
}

function switchTheme(e) {
  if (e.target.checked) {
    document.documentElement.setAttribute("data-theme", "dark");
    localStorage.setItem("theme", "dark");
    iconSwitch.classList.replace("bi-brightness-high", "bi-moon-fill");
    iconSwitch.classList.replace("yellowprim", "darkbl");
  } else {
    document.documentElement.setAttribute("data-theme", "light");
    localStorage.setItem("theme", "light");
    iconSwitch.classList.replace("bi-moon-fill", "bi-brightness-high");
    iconSwitch.classList.replace("darkbl", "yellowprim");
  }
}

toggleSwitch.forEach((tgl) => {
  tgl.addEventListener("change", switchTheme, false);
});

// Sidebar
document.getElementById("menuCheckbox").addEventListener("click", function (e) {
  const offcanvasButton = document.querySelector(
    '[data-bs-target="#offcanvas"]'
  );
  offcanvasButton.click();
});

// Password
const showHide = (e) => {
  const icon = e.querySelector("i");
  const input = e.closest(".floating-label-content").querySelector("input");
  if (icon.classList.contains("bi-eye-slash")) {
    e.querySelector("i").classList.replace("bi-eye-slash", "bi-eye");
    input.type = "text";
  } else {
    input.type = "password";
    e.querySelector("i").classList.replace("bi-eye", "bi-eye-slash");
  }
};

// Navigation
// window.addEventListener("scroll", () => {
//   const nav = document.querySelector("nav");
//   if (scrollY > 10) {
//     nav.classList.add("active");
//   } else {
//     nav.classList.remove("active");
//   }
// });

function showRate() {
  $("#checkout").modal("hide");
  $("#rate").modal("show");
}

var swiper = new Swiper(".swiperBanner", {
  slidesPerView: 1.5,
  centeredSlides: true,
  slidesPerGroup: 1,
  loop: true,
  slideToClickedSlide: true,
  spaceBetween: 5,
  initialSlide: 3,
  autoplay: {
    delay: 4000,
  },
  breakpoints: {
    950: {
      slidesPerView: 1.5,
      centeredSlides: true,
    },
    300: {
      slidesPerView: 1,
      centeredSlides: true,
      spaceBetween: 0,
    },
  },
});

var swiper = new Swiper(".swiperFlashSale", {
  direction: "vertical",
  slidesPerView: 4,
  loop: true,
  slideToClickedSlide: true,
  spaceBetween: 20,
  slidesPerGroup: 1,
  autoplay: {
    delay: 2000,
  },
  breakpoints: {
    1000: {
      slidesPerView: 4,
      direction: "horizontal",
    },
    800: {
      slidesPerView: 3,
      direction: "horizontal",
    },
    400: {
      slidesPerView: 1.5,
      direction: "horizontal",
    },
    200: {
      slidesPerView: 1.5,
      direction: "horizontal",
    },
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

var swiper = new Swiper(".swiperTesti", {
  slidesPerGroup: 1,
  loop: true,
  spaceBetween: 20,
  grabCursor: true,
  autoplay: {
    delay: 2500,
  },
  breakpoints: {
    800: {
      slidesPerView: 2.2,
      centeredSlides: false,
    },
    300: {
      slidesPerView: 1.5,
      centeredSlides: false,
    },
  },
});

var swiper = new Swiper(".swiperNews", {
  slidesPerGroup: 1,
  loop: true,
  spaceBetween: 20,
  grabCursor: true,
  breakpoints: {
    900: {
      slidesPerView: 3,
      centeredSlides: false,
    },
    650: {
      slidesPerView: 2,
      centeredSlides: false,
    },
    300: {
      slidesPerView: 1.5,
      centeredSlides: false,
    },
  },
});

const accordionBtns = document.querySelectorAll(".accordionHead");

accordionBtns.forEach((accordion) => {
  accordion.onclick = function () {
    this.classList.toggle("is-open");

    let content = this.nextElementSibling;

    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }

    const otherAccordions = document.querySelectorAll(".accordionHead");
    otherAccordions.forEach((otherAccordion) => {
      if (
        otherAccordion !== this &&
        otherAccordion.classList.contains("is-open")
      ) {
        otherAccordion.classList.remove("is-open");
        let otherContent = otherAccordion.nextElementSibling;
        otherContent.style.maxHeight = null;
      }
    });
  };
});

const accordionBtnPay = document.querySelectorAll(".accordionHeadPay");

accordionBtnPay.forEach((accordion) => {
  accordion.onclick = function () {
    this.classList.toggle("is-open");

    let content = this.nextElementSibling;

    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }

    const otherAccordions = document.querySelectorAll(".accordionHeadPay");
    otherAccordions.forEach((otherAccordion) => {
      if (
        otherAccordion !== this &&
        otherAccordion.classList.contains("is-open")
      ) {
        otherAccordion.classList.remove("is-open");
        let otherContent = otherAccordion.nextElementSibling;
        otherContent.style.maxHeight = null;
      }
    });
  };
});

// Popover
const popover = new bootstrap.Popover(".contact", {
  container: "body",
});

// Search Game
const placeholders = [
  "Cari Game",
  "Mobile Legends",
  "Free Fire",
  "League Of Legends",
  "Genshin Impact",
];

function changePlaceholder() {
  const input = document.getElementById("searchInput");
  const randomIndex = Math.floor(Math.random() * placeholders.length);
  input.placeholder = placeholders[randomIndex];
}

setInterval(changePlaceholder, 3000);
changePlaceholder();

// Back To Top
const backToTopBtn = document.getElementById("backToTopBtn");

window.addEventListener("scroll", function () {
  const viewportHeight =
    window.innerHeight || document.documentElement.clientHeight;

  if (window.scrollY > viewportHeight / 2) {
    backToTopBtn.style.setProperty("display", "block", "important");
  } else {
    backToTopBtn.style.setProperty("display", "none", "important");
  }
});

function scrollToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// MobileNav
function isMobileDevice() {
  return window.innerWidth <= 767;
}

const mobileNav = document.querySelector(".mobileNav");
let lastScrollPosition = 0;

function handleScroll() {
  if (isMobileDevice()) {
    const currentScrollPosition = window.scrollY;

    if (currentScrollPosition > lastScrollPosition) {
      mobileNav.style.transform = "translateY(100%)";
    } else {
      mobileNav.style.transform = "translateY(0)";
    }

    lastScrollPosition = currentScrollPosition;
  }
}

window.addEventListener("scroll", handleScroll);

// document.addEventListener("contextmenu", function (e) {
//   e.preventDefault();
//   alert("Sorry, Inspect element is disabled.");
// });

// document.onkeydown = function (e) {
//   if (event.keyCode == 123) {
//     return false;
//   }

//   if (e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0)) {
//     return false;
//   }

//   if (e.ctrlKey && e.shiftKey && e.keyCode == "C".charCodeAt(0)) {
//     return false;
//   }

//   if (e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0)) {
//     return false;
//   }

//   if (e.ctrlKey && e.keyCode == "U".charCodeAt(0)) {
//     return false;
//   }
// };
