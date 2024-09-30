<?php
    //Seguridad de sesiones paginacion
    session_start();
    error_reporting(0);
    $varsesion= $_SESSION['usuario'];
    if($varsesion== null || $varsesion=''){
        header("location:../index.html");
        die();
    }

    require 'usuarios_conexion.php';
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
                <a class="op-nuevo" id="openModal"><i class="bi bi-person-fill-add"></i> NUEVO REGISTRO</a>
                <a type="submit" class="op-eliminar"><i class="bi bi-person-dash"></i> ELIMINAR REGISTROS</a>              
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





        <div id="userModal" class="modal">
            <div class="modal-contenedor">
                <span class="cerrar">&times;</span><br><br>
                <form method="POST" action="usuarios_guardar.php" enctype="multipart/form-data" autocomplete="on">
                    
                    <input type="hidden" name="id" id="id">
                    
                    <div>
                        <label label for="nombre" class="texto-simple-whi"><i class="bi bi-person-fill"></i> NOMBRE</label>
                        <input type="text" class="barra-registro" name="nombre" id="nombre" placeholder=""><br>
                    </div>

                    <div>
                        <label label for="usuario" class="texto-simple-whi"><i class="bi bi-person-circle"></i> USUARIO</label>
                        <input type="text" class="barra-registro" name="usuario" id="usuario" placeholder=""><br>
                    </div>

                    <div>
                    <label for="area" class="texto-simple-whi"><i class="bi bi-pin-map-fill"></i> AREA</label>
                        <select name="area" id="area" class="boton-listado-registro">
                            <option class="texto-simple-grey">--SELECCIONAR--</option>
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
				        <select id="id_cargo" name="id_cargo" class="boton-listado-registro">
				            <option value="" class="texto-simple-grey">--SELECCIONAR--</option>
				            <option value="1">SISTEMAS</option>
                            <option value="2">FATIMA</option>
                            <option value="3">CONTABILIDAD</option>
                            <option value="4">GENERAL</option>
                        </select><br>
			        </div>
                    
                    <div>
                        <label label for="password" class="texto-simple-whi"><i class="bi bi-key-fill"></i> CONTRASEÑA</label>
                        <input type="password" class="barra-registro" name="password" id="password" placeholder=""><br>
                        <div class="op-texto-white"> Mostrar Contraseña:</div>
                        <div class="checkbox-wrapper-39">
                        <label>
                            <input type="checkbox" id="checkContraseña" onclick="mostrar()"/>
                            <span class="checkbox"></span>
                        </label>
                    </div>

                    </div>
                    <div class="contenedor-botones-login">
                        <input class="boton-op" type="submit" name="submit" id="submit" value="GUARDAR">
                        <input class="boton-op" type="reset" name="reset" id="reset" value="BORRAR">
                    </div>

                </form>
            </div>
        </div>





        <script>
            // Invoca la funcion getData.
            getData()

            // Eventos.
            document.getElementById("busqueda").addEventListener("keyup", function(){ //Busqueda
                getData()
            }, false);
            document.getElementById("num_registros").addEventListener("change", function(){ //Paginacion
                getData()
            }, false);

            // Peticion AJAX.
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

            // Muestra la contraseña al registrar.
            function mostrar(){
                var tipo = document.getElementById("password");
                if(tipo.type == "password"){
                    tipo.type = "text";
                }else{
                    tipo.type = "password";
                }
            }

            // Todo sobre el modal:
            var modal = document.getElementById("userModal"); // Obtener el modal.
            var btn = document.getElementById("openModal"); // Obtener el botón que abre el modal.
            var span = document.getElementsByClassName("cerrar")[0]; // Obtener el elemento <span> que cierra el modal.
            btn.onclick = function() { // Cuando el usuario hace clic en el botón, abre el modal 
                modal.style.display = "block";
            }

            // Cuando el usuario hace clic en <span> (x), cierra el modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Cuando el usuario hace clic en cualquier lugar fuera del modal, cierra el modal.
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

        </script>
    </body>
</html>