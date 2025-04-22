<div class="container-fluid">
    <div class="container is-fluid my-5">

        <div class="columns">
            <div class="column is-12">
            <h1 class="title">Usurios</h1>
            <h1 class="subtitle">Lista de usurios</h1>

            </div>
        </div>

        <div class="columns">
            <div class="column is-9" style="border: 1px solid #7777;">

            <div class="container ">
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th class="has-text-centered">#</th>
                    <th class="has-text-centered">Nombre</th>
                    <th class="has-text-centered">Usuario</th>
                    <th class="has-text-centered">Email</th>
                    <th class="has-text-centered">Creado</th>
                    <th class="has-text-centered">Actualizado</th>
                    <th class="has-text-centered">Foto</th>
                    <th class="has-text-centered" colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="has-text-centered">
                    <td>1</td>
                    <td>nombre</td>
                    <td>usuario</td>
                    <td>email</td>
                    <td>creado</td>
                    <td>actualizado</td>
                    <td>
                        <a href="#" class="button is-info is-rounded is-small">Foto</a>
                    </td>
                    <td>
                        <a href="#" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <form action="" class="FormularioAjax" method="post" autocomplete="off" >
                            <input type="hidden" name="modulo_usuario" value="eliminar">
                            <input type="hidden" name="usuario_id" value="1">
                            <button type="submit" class="button is-danger is-rounded is-small">Elimnar</button>
                        </form>
                    </td>
                </tr>

                <tr class="has-text-centered">
                    <td colspan="7">
                        <a href="#" class="button is-link is-rounded is-small my-4 ">Haga click para recargar el listado</a>
                    </td>                    
                </tr>

                <tr class="has-text-centered">
                    <td colspan="7">No hay registros en el sistema</td>
                </tr>
            </tbody>

        </table>
    </div>

    <p class="has-text-rught">Mostrando usuarios <b>1</b> al <b>7</b> de un <b>total de 7</b></p>
<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
    <a href="#" class="pagination-previous is-disabled" disabled>Anterior</a>
    <ul class="pagination-list">
        <li><a href="#" class="pagination-link is-current">1</a></li>
    </ul>
    <a href="#" class="pagination-next is-disabled" disabled>Siguiente</a>
        
</nav>

</div>

            </div>
        </div>

    </div>
</div>




