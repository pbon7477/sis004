

//MENU HAMBURGESA
  document.addEventListener('DOMContentLoaded', () => {
    
    // Burger toggle
    const burger = document.querySelector('.navbar-burger');
    const menu = document.getElementById(burger.dataset.target);

    burger.addEventListener('click', () => {
      burger.classList.toggle('is-active');      
      menu.classList.toggle('is-active');
      
    });

    // navbar Submenu toggle
    const btnSubMenu = document.querySelector('.btnSubMenu');
    const subMenu = document.getElementById(btnSubMenu.dataset.target);

    btnSubMenu.addEventListener('click', (e) => {
      e.preventDefault(); // evita que salte al enlace #
      
      subMenu.classList.toggle('is-hidden');
     
    });


    //navbar subMenu left toggle
    const btnSubMenu2 = document.querySelector('#btnSubMenu2');
    
    btnSubMenu2.addEventListener('click', (e)=>{
      e.preventDefault();
      const subMenu2 = document.querySelector('#subMenu2');      
      subMenu2.classList.toggle('is-hidden');
    })





    

  });



 









