let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick =() =>{
    profile.classList.toggle('active');
    navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick =() =>{
    navbar.classList.toggle('active');
    profile.classList.remove('active');
}

window.onscroll = () => {
    profile.classList.remove('active');
    navbar.classList.remove('active');
}

let nav = document.querySelector('header');

window.addEventListener('scroll', function (){
   if(window.pageYOffset > 100){
       nav.classList.add('bg-dark', 'shadow');
   } else{
       nav.classList.remove('bg-dark', 'shadow');
   }
});


