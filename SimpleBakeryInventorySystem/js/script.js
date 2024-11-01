document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.nav-link');
    const pages = document.querySelectorAll('.content-section');

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault(); 
            const target = this.getAttribute('data-target');

            
            pages.forEach(page => {
                page.style.display = 'none';
            });

           
            const targetPage = document.getElementById(target);
            if (targetPage) {
                targetPage.style.display = 'block';
            }
        });
    });

   
    document.getElementById('history').style.display = 'block'; 


});
