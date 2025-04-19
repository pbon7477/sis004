// → Gestion de alertas ajax

let formularios_ajax = document.querySelectorAll(".FormularioAjax");

formularios_ajax.forEach((formulario) => {
  formulario.addEventListener("submit", (e) => {
    e.preventDefault();

    Swal.fire({
      title: "¿Esta seguro?",
      text: "Desea realiza la acción solicitada?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#222",
      cancelButtonColor: "#888",
      confirmButtonText: "Si, realizar",
      cancelButtonText: "No, cancelar"

    }).then((result) => {

      if (result.isConfirmed) {

        let data = new FormData(formulario);
        let method = formulario.getAttribute("method");
        let action = formulario.getAttribute("action");

        let encabezados = new Headers();

        let config = {
          method: method,
          headers: encabezados,
          mode: "cors",
          cache: "no-cache",
          body: data,
        };

        fetch(action, config)
          .then((response) => response.json())
          .then((respuesta) => {
            //console.log(respuesta)
            return alerta_ajax(respuesta);
          })
          .catch( error => console.log( `Tu Error: ${error}`) );
      }
    });
  });
});


function alerta_ajax(alerta) {

  if (alerta.tipo == "simple") {
    Swal.fire({
      icon: alerta.icono,
      title: alerta.titulo,
      text: alerta.texto,
      confirmButtonText: "Aceptar",
      confirmButtonColor: "#222",
    });

  } else if (alerta.tipo == "recargar") {
    Swal.fire({
      icon: alerta.icono,
      title: alerta.titulo,
      text: alerta.texto,
      confirmButtonColor: "#222",
      confirmButtonText: "Aceptar",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.reload();
      }
    });

  } else if (alerta.tipo == "limpiar") {
    Swal.fire({
      icon: alerta.icono,
      title: alerta.titulo,
      text: alerta.texto,
      confirmButtonColor: "#222",
      confirmButtonText: "Aceptar",
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector(".FormularioAjax").reset();
      }
    });
  } else if (alerta.tipo == "redireccionar") {
    window.location.href = alerta.url;
  }
}
