let userBox = document.querySelector('.header .flex .account-box');
let userBtn = document.querySelector('#user-btn');
let navbar = document.querySelector('.header .flex .navbar');
let menuBtn = document.querySelector('#menu-btn');

// Toggle the account box when the user button is clicked
userBtn.onclick = () => {
    event.stopPropagation(); // Prevents triggering document click listener
    userBox.classList.toggle('active');
    navbar.classList.remove('active'); // Close navbar if open
}

// Toggle the navbar when the menu button is clicked
menuBtn.onclick = () => {
    navbar.classList.toggle('active');
    userBox.classList.remove('active'); // Close account box if open
}

// Close account box and navbar when scrolling
window.onscroll = () => {
    userBox.classList.remove('active');
    navbar.classList.remove('active');
}

// Close the account box when the cursor moves away
userBox.addEventListener('mouseleave', () => {
    userBox.classList.remove('active');
});

// Close the account box if clicking outside of it
document.addEventListener('click', (event) => {
    if (!userBox.contains(event.target) && !userBtn.contains(event.target)) {
        userBox.classList.remove('active'); // Close account box
    }

    if (!navbar.contains(event.target) && !menuBtn.contains(event.target)) {
        navbar.classList.remove('active'); // Close navbar
    }
}); 










/*let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("gallery-slide");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 3000); // Change image every 3 seconds
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }*/

            let slideIndex = 0;
            showSlides();
            
            function showSlides(n) {
                let i;
                let slides = document.getElementsByClassName("gallery-slide");
                let dots = document.getElementsByClassName("dot");
            
                // Reset slideIndex if undefined
                if (n) {
                    slideIndex = n;
                }
            
                // If slideIndex exceeds number of slides, reset it to 1
                if (slideIndex > slides.length) { slideIndex = 1 }
                if (slideIndex < 1) { slideIndex = slides.length }
            
                // Hide all slides
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
            
                // Remove active class from all dots
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
            
                // Display the current slide and add active class to the current dot
                slides[slideIndex - 1].style.display = "block";
                dots[slideIndex - 1].className += " active";
            
                // Auto-play with a timeout
                setTimeout(() => showSlides(slideIndex + 1), 3000); // Auto-play
            }
            
            function currentSlide(n) {
                showSlides(n);
            }
            