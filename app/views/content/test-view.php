<div class="container-fluid">
    <div class="container my-6">

    <div class="columns">
        <div class="column is-8 " style="border: 1px dashed #fff;">
            <h1>Columna derecha</h1>
            <p>ocupa 8 espacios</p>
        </div>
        
        <div class="column is-4 " style="border: 1px dashed #fff;">
            <h1>Columna izquierda</h1>
            <p>ocupa 4 espacios</p>
            
        </div>
        
    </div>


    </div>
</div>



<div class="container">

<section>
    <div class="container">
        <h1 class="is-size-2 px-1">Test</h1>
        <hr>
        <div class="columns is-flex is-justify-content-center">
            <h1>Otro contenido</h1>
        </div>
        <div class="columns is-flex is-justify-content-center">
            <h2 class="subtitle">¡Bienvenido User nombre</h2>
        </div>
    </div>
</section>

<hr>   
<section>
    <div class="container ">
        
    <div class="my-2">
        <h2 class="title">boton de test de sweetAlert2</h2>
        <button class="button is-primary testAlerta">Probar alerta</button>
    </div>
    </div>
</section>



<sectiont>
    <div class="container">
        <p>Correccion de ortografia</p>

        <textarea name="" id="" cols="50" rows="10"></textarea>
    </div>

    <hr>

    <div class="container">
        <div class="columns is-flex is-justify-content-center">
            
            <form action="usuarios.php" class="FormularioAjax" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
                <br>
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido">
                <br>
                <input type="submit" value="Guardar">
            </form>
        </div>
    </div>

</sectiont>


</div>


<script>
    //test sweetalert
document.querySelector(".testAlerta").addEventListener("click", () => {
  Swal.fire({
    title: "The Internet?",
    text: "That thing is still around?",
    icon: "question",
  });
});
</script>