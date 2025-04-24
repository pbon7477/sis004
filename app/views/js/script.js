


//cerrar cualquier caja de notificación (version de bulma)
/*     document.addEventListener('DOMContentLoaded', () => {
        (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
            const $notification = $delete.parentNode;
            
            $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
                });
                });
                }); */

//cerrar cualquier caja de notificación (version pablo)
document.addEventListener("DOMContentLoaded", () => {

  let btnsDelete = document.querySelectorAll(".delete");
  btnsDelete.forEach((btnDelete) => {
    btnDelete.addEventListener("click", (e) => {
      e.target.parentNode.style.display = "none";
    });
  });

});



//Codigo para el boton volver (reutilizable en todas las paginas)
document.querySelector('#btnVolver').addEventListener('click',(e)=>{
  e.preventDefault();
  window.history.back();
});