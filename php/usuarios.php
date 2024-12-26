<?php
    //Seguridad de sesiones paginacion.
    session_start();
    error_reporting(0);
    $varsesion= $_SESSION['usuario'];
    if($varsesion == null || $varsesion == ''){
        header("location:../index.html");
        die();
    }

    require 'usuarios_conexion.php';

    // Obtener Registros.
    $sql="SELECT * FROM login";
    $query=mysqli_query($conn,$sql);
    $dataRegistro=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../css/main.css">
        <title>Registro de Personal</title>
    </head>
    <body>
        <header>
            <nav>
                <a class="op-actualizar" onclick="window.location.reload()"><i class="bi bi-arrow-clockwise"></i> ACTUALIZAR</a>
                <a class="op-nuevo" id="openAddModal"><i class="bi bi-person-fill-add"></i> NUEVO REGISTRO</a>
                <a class="op-eliminar" id="delUsersBtn"><i class="bi bi-person-dash"></i> ELIMINAR REGISTROS</a>              
                <ul>
                    <li><a class="op-texto"><i class="bi bi-person-circle"></i> <?php echo $_SESSION['usuario']?></li>
                    <li><a class="op-texto" onClick="history.go(-1);"><i class="bi bi-arrow-return-left"></i> REGRESAR</a></li>
                    <li><a class="op-texto" href="logout.php"><i class="bi bi-door-open-fill"></i> CERRAR SESION</a></li>
                </ul>
            </nav>
        </header><br>
        
        <div class="contenedor-filtrado">
            <form action="" method="post">
                <div>
                    <div><label class="texto-simple-whi" for="busqueda">BUSQUEDA: </label></div>
                <input class="barra-busqueda" type="text" name="busqueda" id="busqueda">
                </div>
            </form>
            <div>
                <label for="num_registros" class="texto-simple-whi" >MOSTRAR: </label>
                <select name="num_registros" id="num_registros" class="boton-listado">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="40">40</option>
                    <option value="80">80</option>
                </select>
            </div>
        </div><p></p>
        <table>
                <thead>
                    <tr>                     
                        <th class="ord asc"># <i class="bi bi-arrow-down-up"></i></th>              
                        <th class="ord asc">NOMBRE <i class="bi bi-arrow-down-up"></i></th> 
                        <th class="ord asc">AREA <i class="bi bi-arrow-down-up"></i></th>
                        <th class="ord asc">USUARIO <i class="bi bi-arrow-down-up"></i></th>
                        <th class="ord asc">PASSWORD <i class="bi bi-arrow-down-up"></i></th>
                        <th class="ord asc">TIPO DE USUARIO <i class="bi bi-arrow-down-up"></i></th>
                        <th>EDITAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody id="content">
                    
                </tbody>
        </table><br>
        <div>
            <ul>
                <li><label class="texto-simple-whi" id="total"></label></li>
                <li><a id="paginacion"></a></li>
            </ul>
            <input type="hidden" id="pagina" value="1">
            <input type="hidden" id="orderCol" value="0">
            <input type="hidden" id="orderType" value="asc">
        </div>

        <div id="AddModal" class="modal">
            <div class="modal-contenedor">
                <span class="cerrarAdd">&times;</span><br>
                <form method="POST" action="usuarios_guardar.php" enctype="multipart/form-data" autocomplete="on" id="AddForm" onsubmit="return validarContraseña('AddForm')">                 
                    <input type="hidden" name="id" id="idAdd">
                    <div>
                        <label class="texto-simple-whi">NUEVO REGISTRO</label><br>
                    </div>
                    <div>
                        <label label for="nombre" class="texto-simple-whi"><i class="bi bi-person-fill"></i> NOMBRE</label>
                        <input type="text" class="barra-registro" name="nombre" id="nombreAdd" placeholder=""><br>
                    </div>
                    <div>
                        <label label for="usuario" class="texto-simple-whi"><i class="bi bi-person-circle"></i> USUARIO</label>
                        <input type="text" class="barra-registro" name="usuario" id="usuarioAdd" placeholder=""><br>
                    </div>
                    <div>
                    <label for="area" class="texto-simple-whi"><i class="bi bi-pin-map-fill"></i> AREA</label>
                        <select name="area" id="areaAdd" class="boton-listado-registro">
                            <option value="" disabled selected>--SELECCIONAR--</option>
                            <?php   
				                include ('usuarios_area.php');
				                $areA = mysqli_query($conn, "SELECT * FROM area_user");
				                while($a = mysqli_fetch_array($areA)){
				            ?>
				            <option value="<?php echo $a['nombre_area'] ?>"><?php echo $a['nombre_area']?>
				            <?php }?></option>
                        </select><br>
                    </div>
                    <div>
				        <label label for="id_cargo" class="texto-simple-whi"><i class="bi bi-person-badge-fill"></i> TIPO DE USUARIO</label>
				        <select name="id_cargo" id="id_cargoAdd" class="boton-listado-registro">
                        <option value="" disabled selected>--SELECCIONAR--</option>
                        <?php   
                            $areA = mysqli_query($conn, "SELECT * FROM cargo");
                            while($a = mysqli_fetch_array($areA)){
                                $selected = ($a['id'] == $row['id_cargo']) ? 'selected' : '';
                                echo "<option value='".$a['id']."' $selected>".$a['descripcion']."</option>";
                            }
                        ?>
                    </select><br>
			        </div>                   
                    <div>
                        <label label for="password" class="texto-simple-whi"><i class="bi bi-key-fill"></i> CONTRASEÑA</label>
                        <input type="password" class="barra-registro" name="password" id="passwordAdd" placeholder=""><br>
                        <div class="op-texto-white"> Mostrar Contraseña:</div>
                        <div class="checkbox-wrapper-39">
                        <label>
                            <input type="checkbox" id="checkContraseñaAdd" onclick="mostrarPassAdd()"/>
                            <span class="checkbox"></span>
                        </label>
                    </div>
                    </div>
                    <div class="contenedor-botones-login">
                        <input class="boton-op" type="submit" name="submit" id="submitAdd" value="GUARDAR">
                        <input class="boton-op" type="reset" name="reset" id="resetAdd" value="BORRAR">
                    </div>
                </form>
            </div>
        </div>
        
        <div id="EditModal" class="modal">
            <div class="modal-contenedor">
                <span class="cerrarEdit">&times;</span><br>
                <form method="POST" action="usuarios_actualizar.php" enctype="multipart/form-data" autocomplete="on" id="EditForm" onsubmit="return validarContraseña('EditForm')">
                    <input type="hidden" name="id" id="idEdit" value="<?php echo $row['id']; ?>">
                    <div>
                        <label class="texto-simple-whi">EDITAR REGISTRO</label><br>
                    </div>
                    <div>
                        <label label for="nombre" class="texto-simple-whi"><i class="bi bi-person-fill"></i> NOMBRE</label>
                        <input type="text" class="barra-registro" name="nombre" id="nombreEdit" value="<?php echo $row['nombre']; ?>" placeholder=""><br>
                    </div>
                    <div>
                        <label label for="usuario" class="texto-simple-whi"><i class="bi bi-person-circle"></i> USUARIO</label>
                        <input type="text" class="barra-registro" name="usuario" id="usuarioEdit" value="<?php echo $row['usuario']; ?>" placeholder=""><br>
                    </div>
                    <div>
                        <label for="area" class="texto-simple-whi"><i class="bi bi-pin-map-fill"></i> AREA</label>
                        <select name="area" id="areaEdit" class="boton-listado-registro">
                            <option value="" disabled selected>--SELECCIONAR--</option>
                            <?php   
                                include('usuarios_area.php');
                                $areA = mysqli_query($conn, "SELECT * FROM area_user");
                                while($a = mysqli_fetch_array($areA)){
                                    $selected = ($a['nombre_area'] == $row['area']) ? 'selected' : '';
                                    echo "<option value='".$a['nombre_area']."' $selected>".$a['nombre_area']."</option>";
                                }
                            ?>
                        </select><br>
                    </div>
                    <div>
	        	        <label label for="id_cargo" class="texto-simple-whi"><i class="bi bi-person-badge-fill"></i> TIPO DE USUARIO</label>
	        	        <select id="id_cargoEdit" name="id_cargo" class="boton-listado-registro">
                            <option value="" disabled selected>--SELECCIONAR--</option>
                            <?php   
                                $areA = mysqli_query($conn, "SELECT * FROM cargo");
                                while($a = mysqli_fetch_array($areA)){
                                    $selected = ($a['id'] == $row['id_cargo']) ? 'selected' : '';
                                    echo "<option value='".$a['id']."' $selected>".$a['descripcion']."</option>";
                                }
                            ?>
                        </select><br>
	        	    </div>
                    <div>
                        <label label for="password" class="texto-simple-whi"><i class="bi bi-key-fill"></i> CONTRASEÑA</label>
                        <input type="password" class="barra-registro" name="password" id="passwordEdit" value="<?php echo $row['password']; ?>" placeholder=""><br>
                        <div class="op-texto-white"> Mostrar Contraseña:</div>
                        <div class="checkbox-wrapper-39">
                        <label>
                            <input type="checkbox" id="checkContraseñaEdit" onclick="mostrarPassEdit()"/>
                            <span class="checkbox"></span>
                        </label>
                    </div>
                    </div>
                    <div class="contenedor-botones-login">
                        <input class="boton-op" type="submit" name="submit" id="submitEdit" value="ACTUALIZAR">
                        <input class="boton-op" type="reset" name="reset" id="resetEdit" value="BORRAR">
                    </div>
                </form>
            </div>
        </div>

        <script>
            // INVOCA LA FUNCION getData() PARA OBTENER LOS DATOS DE TABLA.
            getData()

            // EVENTOS DE BUSQUEDA Y PAGINACION:
            document.getElementById("busqueda").addEventListener("keyup", function(){ //Busqueda.
                getData()
            }, false);
            document.getElementById("num_registros").addEventListener("change", function(){ //Paginacion.
                getData()
            }, false);

            // Peticion AJAX:
            function getData(){
                let input = document.getElementById("busqueda").value;
                let num_registros = document.getElementById("num_registros").value;
                let content = document.getElementById("content");
                let pagina = document.getElementById("pagina").value;
                let orderCol = document.getElementById("orderCol").value;
                let orderType = document.getElementById("orderType").value;
                
                if(pagina == null){
                    pagina = 1;
                }
                
                let url = "usuarios_tabla_db.php";
                let formaData = new FormData();
                formaData.append('busqueda', input);
                formaData.append('registros', num_registros);
                formaData.append('pagina', pagina);
                formaData.append('orderCol', orderCol);
                formaData.append('orderType', orderType);
            
                fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data;
                    document.getElementById("total").innerHTML = 'Mostrando ' + data.totalFiltro + ' de ' + data.totalRegistros + ' registros'
                    document.getElementById("paginacion").innerHTML = data.paginacion
                }).catch(err => console.log(err));
            }

            function nextPage(pagina){
                document.getElementById('pagina').value = pagina
                getData()
            }

            let columns = document.getElementsByClassName("ord")
            let longitud = columns.length
            for(let i = 0 ; i < longitud ; i++){
                columns[i].addEventListener("click", ordenar)
            }

            function ordenar(e) {
                let elemento = e.target;
                let orderType = elemento.classList.contains("asc") ? "desc" : "asc";

                document.getElementById('orderCol').value = elemento.cellIndex;
                document.getElementById("orderType").value = orderType;
                elemento.classList.toggle("asc");
                elemento.classList.toggle("desc");

                getData()
            }

            // MODAL DE REGISTRO:
            function mostrarPassAdd(){
                var tipoAdd = document.getElementById("passwordAdd");
                if(tipoAdd.type == "password"){
                    tipoAdd.type = "text";
                }else{
                    tipoAdd.type = "password";
                }
            }

            const modalAdd = document.getElementById("AddModal"); // Obtener el modal.
            const btnAddModal = document.getElementById("openAddModal"); // Obtener el botón que abre el modal.
            const spanAdd = document.querySelector(".cerrarAdd"); // Obtener el primer elemento con clase "cerrarAdd".

            const openModal = () => { // Función para abrir el modal.
                modalAdd.style.display = "block";
            };
            
            const closeModal = () => { // Función para cerrar el modal.
                modalAdd.style.display = "none";
            };

            btnAddModal.addEventListener("click", openModal); // Event listener para abrir el modal.
            
            spanAdd.addEventListener("click", closeModal); // Event listener para cerrar el modal al hacer clic en el botón "cerrar".

            window.addEventListener("click", (event) => { // Event listener para cerrar el modal cuando se hace clic fuera de él.
                if (event.target === modalAdd) {
                    closeModal();
                }
            });
            
            // MODAL DE EDICION:
            function mostrarPassEdit(){
                var tipoEdit = document.getElementById("passwordEdit");

                if(tipoEdit.type == "password"){
                    tipoEdit.type = "text";
                }else{
                    tipoEdit.type = "password";
                }
            }

            // Función para abrir el modal y obtener los datos del usuario:
            function openEditModal(userId) {
                const modalEdit = document.getElementById("EditModal");
                const spanEdit = document.querySelector(".cerrarEdit"); // Se selecciona el primer elemento con la clase "cerrarEdit".

                // Realizamos la petición AJAX usando fetch.
                const url = "usuarios_editar.php"; // URL del servidor que procesa la edición.
                const formData = new FormData();
                formData.append("id", userId);
            
                // Usamos fetch para obtener los datos del usuario.
                fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Llenamos los campos del modal con los datos obtenidos.
                    document.getElementById("idEdit").value = data.id;
                    document.getElementById("nombreEdit").value = data.nombre;
                    document.getElementById("usuarioEdit").value = data.usuario;
                    document.getElementById("areaEdit").value = data.area;
                    document.getElementById("id_cargoEdit").value = data.id_cargo;
                    document.getElementById("passwordEdit").value = data.password;
                    modalEdit.style.display = "block"; // Mostramos el modal.
                })
                .catch(error => {
                    console.error("Error al obtener los datos del usuario:", error);
                });
            
                const closeModal = () => { // Función para cerrar el modal.
                    modalEdit.style.display = "none";
                };

                spanEdit.addEventListener("click", closeModal); // Añadimos el evento para cerrar el modal al hacer clic en el botón "cerrar".

                window.addEventListener("click", (event) => { // Añadimos el evento para cerrar el modal si se hace clic fuera de él.
                    if (event.target === modalEdit) {
                        closeModal();
                    }
                });
            }

            // MENSAJE DE ERROR PARA EL FORMULARIO DE AGREGAR USUARIO:
            document.getElementById('AddForm').addEventListener('submit', function(event) {
                var seleccionAddForm = ['areaAdd','id_cargoAdd'];
                var mensajeError = "Por favor, selecciona opciones validas.";

                for (var i = 0; i < seleccionAddForm.length; i++) {
                    var selectAddForm = document.getElementById(seleccionAddForm[i]);
                    if (selectAddForm.value === "") {
                        alert(mensajeError);
                        event.preventDefault(); // Evita el envío del formulario.
                        break; // Detiene la ejecución del ciclo si ya se detectó un error.
                    }
                }
            });

            // MENSAJE DE ERROR SI LA CONTRASEÑA ES INFERIOR A 8 CARACTERES:
            function validarContraseña(formId) {
                var form = document.getElementById(formId);
                var password = form.querySelector('input[name="password"]').value;

                if (password.length < 8) {
                    alert('La contraseña debe tener al menos 8 caracteres.');
                    return false;  // Previene el envío del formulario.
                }
                return true;  // Permite el envío del formulario.
            }

            // FUNCION DE ELIMINACION DE USUARIOS:
            document.getElementById("delUsersBtn").addEventListener("click", function() {
                let checkboxes = document.querySelectorAll('.checkbox-delete:checked'); // Obtenemos los checkboxes seleccionados

                // Mensaje de error al intentar eliminar sin ningun checkbox seleccionado.
                if (checkboxes.length === 0) {
                    alert("Por favor, selecciona al menos un usuario.");
                    return;
                }

                // Creamos un arreglo con los IDs de los usuarios seleccionados.
                let idsSeleccionados = [];
                checkboxes.forEach(function(checkbox) {
                    idsSeleccionados.push(checkbox.getAttribute('data-id'));
                });

                // Confirmamos si el usuario está seguro de eliminar los registros.
                if (confirm("¿Estás seguro de eliminar los usuarios seleccionados?")) {
                    eliminarUsuarios(idsSeleccionados);
                }
            });

            // ENVIO DE IDs AL SERVIDOR PARA ELIMINACION:
            function eliminarUsuarios(ids) {
                let formData = new FormData();

                formData.append('ids', JSON.stringify(ids)); // Convertimos el arreglo a JSON
                fetch('usuarios_eliminar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Usuarios eliminados correctamente.');
                        getData();  // Recargamos la tabla de usuarios
                    } else {
                        alert('Hubo un error al intentar eliminar.');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        </script>
    </body>
</html>