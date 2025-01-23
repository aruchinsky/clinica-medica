
<section class="content">
    <div class="error-page">
        <h2 class="headline text-lightblue"> 404</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-lightblue"></i> ¡Uy! Página no encontrada.</h3>
            <p>
            No hemos podido encontrar la página que buscaba. Mientras tanto, 
            puede <a href="<?php echo APP_URL; ?>dashboard">volver al inicio</a>
             o intentar utilizar el formulario de búsqueda.
            </p>
            <form class="search-form" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                        <button type="submit" name="submit" class="btn btn-secondary"><i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>