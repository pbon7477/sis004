/* <!-- script para mostrar imagen seleccionada--> */

//let imagenDefault = '<img src="http://localhost/CRUD/app/views/img/default.png" alt="" width="120px">';
let imagenDefault = '<small>Foto</small>';

let outputDiv = document.querySelector('#imagePreview');




document.getElementById('usuario_foto').addEventListener('change', mostrarImagenSeleccionada, false);

function mostrarImagenSeleccionada(e) {
  // Obtener los archivos seleccionados
  let archivosSeleccionados = e.target.files;
  
  // Iterar sobre los archivos seleccionados
  for (let i = 0; i < archivosSeleccionados.length; i++) {
    let archivo = archivosSeleccionados[i];
    
    // Verificar que el archivo sea una imagen
    if (!archivo.type.match("image.*")) {
      continue;
    }
    
    // Crear un objeto FileReader para leer el archivo
    let lectorDeArchivo = new FileReader();
    
    // Establecer la función que se ejecutará cuando se haya leído el archivo
    lectorDeArchivo.onload = function (e) {
      // Mostrar la imagen en el contenedor de salida
      outputDiv.innerHTML = '';
      outputDiv.innerHTML = `
      <div>
      <img class="" src="${e.target.result}" alt="" width="150px" />
      </div>
      <div class="is-flex is-justify-content-end">
      <button type="button" class="tag is-small is-secondary " onclick="cancelarImagen()">cancelar</button>
      </div>
      `;
      
      
      

      
    };
    
    // Leer el archivo como una URL de datos
    lectorDeArchivo.readAsDataURL(archivo);
  }
}


/* end script para mostrar imagen seleccionada */


// Vaciar output de la imagen al pulsar el boton limpiar
let btnLimpiar = document.querySelector('#limpiar')
btnLimpiar.addEventListener('click', ()=>{
  outputDiv.innerHTML = imagenDefault;
})

//Vaciar el output de la imagen al realizar submit
document.querySelector('.FormularioAjax').addEventListener('submit',()=>{
  outputDiv.innerHTML = imagenDefault;
})




//boton cancelar imagen en la imagen

function cancelarImagen(){
  outputDiv.innerHTML='';
  outputDiv.innerHTML = imagenDefault;
  document.querySelector('#usuario_foto').value = '';
} 