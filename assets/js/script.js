const btn = document.querySelector('.switch');
const nav = document.querySelector('.navbar');


btn.addEventListener('change', function () {
    document.body.classList.toggle('dark-theme');
    nav.classList.toggle('bg-light');
    nav.classList.toggle('bg-dark');
    nav.classList.toggle('navbar-light');
    nav.classList.toggle('navbar-dark');

    let theme = "light";

    if (document.body.classList.contains("dark-theme")) {
        theme = "dark";
    }

    document.cookie = "theme=" + theme;
    location.reload();


})

$(document).ready(function() {
    $('#participantTable').DataTable( {
        // "pagingType": "full_numbers"
        "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]]
    } );
} );


