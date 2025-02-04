/*let userBox = document.querySelector('.header .flex .account-box');

document.querySelector('#user-btn').onclick = () =>{
    userBox.classList.toggle('active');
    navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    userBox.classList.remove('active');
}

window.onscroll = () =>{
    userBox.classList.remove('active');
    navbar.classList.remove('active');
}*/

/*
let userBox = document.querySelector('.header .flex .account-box');
let navbar = document.querySelector('.header .flex .navbar');

// Toggle userBox on user button click
document.querySelector('#user-btn').onclick = () => {
    userBox.classList.toggle('active');
    navbar.classList.remove('active');
};

// Toggle navbar on menu button click
document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    userBox.classList.remove('active');
};

// Remove active classes when scrolling
window.onscroll = () => {
    userBox.classList.remove('active');
    navbar.classList.remove('active');
};
*/
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
