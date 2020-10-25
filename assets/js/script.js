const btn = document.querySelector('.switch');
const nav = document.querySelector('.navbar');


    btn.addEventListener('change', function (){
        document.body.classList.toggle('light-theme');
        nav.classList.toggle('bg-light');
        nav.classList.toggle('bg-dark');
        nav.classList.toggle('navbar-light');
        nav.classList.toggle('navbar-dark');

        let theme = "dark";

        if(document.body.classList.contains("light-theme")){
            theme = "light";
        }

        document.cookie = "theme=" + theme;


    })

