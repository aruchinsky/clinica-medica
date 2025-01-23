const formularios_ajax=document.querySelectorAll(".FormularioAjax");

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit",function(e){
        // esto se utiliza para omitir el ACTION de un FORMULARIO 
        // para que asi no se redireccione luego de presionar el boton SUBMIT
        e.preventDefault();

        //Aplicamos las SWEETALERT2
        Swal.fire({
            title: "Estás seguro?",
            text: "Quieres realizar la acción solicitada",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Realizar!",
            cancelButtonText: "No, Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                //Creamos un array de datos para los datos que vamos a enviar
                //Instanciamos una nueva clase de FORMDATA
                    //En este array se guardan los NAME de los input como CLAVES DE ARRAY
                    // y los VALORES de cada CLAVE seran los que se escribn dentro de los INPUTS
                let data = new FormData(this);
                
                //Capturamos el METODO con el que esta trabajando el FORMULARIO que RECIBIMOS
                let method = this.getAttribute("method");
                //Capturamos el ACTION con el que esta trabajando el FORMULARIO
                // PAra saber a donde manda el formulario
                let action = this.getAttribute("action");

                //Esto utilizara la API FETCH de javascript
                let encabezados = new Headers();

                // Tendra todas las configuraciones necesarias para la API FETCH
                let config = {
                    method: method,
                    headers: encabezados,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };

                //Utilizamos FETCH
                // Trabajamos con PROMESAS
                fetch(action,config)
                .then(respuesta => respuesta.json()) //Formateamos la variable respuesta a FORMATO JSON
                .then(respuesta => {
                    return alertas_ajax(respuesta);
                });

            }
        });

    });
});

function alertas_ajax(alerta){
    
    if(alerta.tipo=="simple"){

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        });

    }else if(alerta.tipo=="recargar"){

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });

    }else if(alerta.tipo=="limpiar"){

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(".FormularioAjax").reset();
            }
        });

    }else if(alerta.tipo=="redireccionar"){
        window.location.href=alerta.url;
    }

};

/* Boton cerrar sesion */
let btn_exit=document.getElementById("btn_exit");

btn_exit.addEventListener("click", function(e){

    e.preventDefault();
    
    Swal.fire({
        title: '¿Quieres salir del sistema?',
        text: "La sesión actual se cerrará y saldrás del sistema",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, salir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            let url=this.getAttribute("href");
            window.location.href=url;
        }
    });

});