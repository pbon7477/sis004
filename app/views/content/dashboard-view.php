<section>
    <div class="container">
        <h1 class="is-size-2 px-1">Home</h1>
        <hr>
        <div class="columns is-flex is-justify-content-center">
            <div class="image is-96x96" >
                <img class="is-rounded" src="<?= APP_URL;?>app/views/fotos/<?= $_SESSION['foto'] ? $_SESSION['foto'] : 'Avatar.png' ;?>" alt="" width="" >
            </div>
        </div>    
        <div class="columns is-flex is-justify-content-center">
            <h2 class="subtitle mt-1">¡Bienvenido <?= $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];?>!</h2>
        </div>
    </div>
</section>









