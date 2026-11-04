
// HERO CAROUSEL

const slides = document.querySelectorAll(".hero-slide");

const nextButton = document.querySelector(".next");
const prevButton = document.querySelector(".prev");

let currentSlide = 0;
let carouselTimer;

function showSlide(index) {

    slides.forEach((slide, i) => {

        slide.classList.toggle(
            "active",
            i === index
        );

        slide.setAttribute(
            "aria-hidden",
            i === index ? "false" : "true"
        );
    });

    currentSlide = index;
}

function nextSlide() {

    currentSlide = (currentSlide + 1) % slides.length;

    showSlide(currentSlide);
}

function previousSlide() {

    currentSlide =
        (currentSlide - 1 + slides.length) % slides.length;

    showSlide(currentSlide);
}

function startCarousel() {

    clearInterval(carouselTimer);

    if (!window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    ).matches) {

        carouselTimer = setInterval(nextSlide, 5000);
    }
}

nextButton.addEventListener("click", () => {
    nextSlide();
    startCarousel();
});

prevButton.addEventListener("click", () => {
    previousSlide();
    startCarousel();
});

showSlide(0);
startCarousel();


// MOBILE NAVIGATION

const menuToggle =
    document.getElementById("menuToggle");

const navLinks =
    document.getElementById("navLinks");

menuToggle.addEventListener("click", () => {

    const expanded =
        menuToggle.getAttribute("aria-expanded") === "true";

    menuToggle.setAttribute(
        "aria-expanded",
        String(!expanded)
    );

    navLinks.classList.toggle("show");
});


// CLOSE MOBILE MENU AFTER CLICK

navLinks.querySelectorAll("a").forEach(link => {

    link.addEventListener("click", () => {

        navLinks.classList.remove("show");

        menuToggle.setAttribute(
            "aria-expanded",
            "false"
        );
    });
});


// RESERVATION FORM VALIDATION

const bookingForm =
    document.getElementById("bookingForm");

bookingForm.addEventListener("submit", function(event) {

    event.preventDefault();

    const name =
        document.getElementById("name").value.trim();

    const email =
        document.getElementById("email").value.trim();

    const date =
        document.getElementById("date").value;

    const time =
        document.getElementById("time").value;

    const guests =
        document.getElementById("guests").value;

    const message =
        document.getElementById("formMessage");

    const emailPattern =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (name.length < 2) {

        message.textContent =
            "Please enter a valid name.";

        return;
    }

    if (!emailPattern.test(email)) {

        message.textContent =
            "Please enter a valid email address.";

        return;
    }

    if (!date || date < new Date().toLocaleDateString(
        "en-CA"
    )) {

        message.textContent =
            "Please select today or a future date.";

        return;
    }

    if (!time || !guests) {

        message.textContent =
            "Please select a time and number of guests.";

        return;
    }

    message.textContent =
        "Thank you! Your reservation request is ready.";

    bookingForm.reset();

});

