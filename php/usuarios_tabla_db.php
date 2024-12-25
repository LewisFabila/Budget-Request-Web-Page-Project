<?php
    require 'usuarios_conexion.php';

    /* ARREGLO DE COLUMNAS A MOSTRAR */
    $columns = ['l.id', 'l.nombre', 'l.area', 'l.usuario', 'l.password', 'l.id_cargo', 'c.descripcion'];
    $columnsWhere = ['l.id', 'l.nombre', 'l.area', 'l.usuario'];
    
    /* NOMBRE DE LA TABLA */
    $table = "login l";
    $tableCargo = "cargo c";

    /* VARIABLE DE ID DE USUARIO */
    $id = 'l.id';

    $busqueda = isset($_POST['busqueda']) ? $conn->real_escape_string ($_POST['busqueda']) : null;

    /* FILTRADO */
    $where = '';

    if ($busqueda != null) {
        $where = "WHERE (";

        $cont = count($columnsWhere);
        for($i = 0 ; $i < $cont ; $i++) {
            $where .= $columnsWhere[$i] . " LIKE '%" . $busqueda . "%' OR ";
        }
        $where = substr_replace($where, "", -4);
        $where .= ")";
    }

    /* LIMITE DE FILAS */
    $limit = isset($_POST['registros']) ? $conn->real_escape_string ($_POST['registros']) : 10;
    $pagina = isset($_POST['pagina']) ? $conn->real_escape_string ($_POST['pagina']) : 0;

    if(!$pagina){
        $inicio = 0;
        $pagina = 1;
    }else{
        $inicio = ($pagina - 1) * $limit;
    }

    $sLimit = "LIMIT $inicio , $limit";

    /* ORDENAMIENTO DE COLUMNAS */
    $sOrder = "";
    if (isset($_POST['orderCol'])) {
        $orderCol = intval($_POST['orderCol']);
        $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';

        // Verifica si el orden es por la descripción del cargo (TIPO DE USUARIO):
        if ($orderCol === 5) { // Si el índice de "c.descripcion" es 5.
            $sOrder = "ORDER BY c.descripcion " . $oderType;
        } else {
            $sOrder = "ORDER BY " . $columns[$orderCol] . ' ' . $oderType;
        }
    }

    /* CONSULTA DE REGISTROS */
    $sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
    FROM $table
    JOIN $tableCargo ON l.id_cargo = c.id
    $where
    $sOrder
    $sLimit";
    /* CODIGO PARA IMPRIMIR CONSULTA EN CASO DE ERROR:
    echo $sql;
    exit;
    */
    $resultado = $conn->query($sql);
    $num_rows = $resultado->num_rows;

    /* CONSULTA PARA TOTAL DE REGISTROS FILTRADOS */
    $sqlFiltro = "SELECT FOUND_ROWS()";
    $resFiltro = $conn->query($sqlFiltro);
    $row_filtro = $resFiltro->fetch_array();
    $totalFiltro = $row_filtro[0];

    /* CONSULTA PARA TOTAL DE REGISTROS FILTRADOS */
    $sqlTotal = "SELECT count($id) FROM $table ";
    $resTotal = $conn->query($sqlTotal);
    $row_total = $resTotal->fetch_array();
    $totalRegistros = $row_total[0];

    /* MOSTRANDO RESULTADOS */
    $output = [];
    $output['totalRegistros'] = $totalRegistros;
    $output['totalFiltro'] = $totalFiltro;
    $output['data'] = '';
    $output['paginacion'] = '';

    if($num_rows > 0){
        while($row = $resultado->fetch_assoc()){
            $output['data'] .= '<tr>';
            $output['data'] .= '<td><div><div>'.$row['id'].'</div></td>';
            $output['data'] .= '<td><div>'.$row['nombre'].'</div></td>';
            $output['data'] .= '<td><div>'.$row['area'].'</div></td>';
            $output['data'] .= '<td><div>'.$row['usuario'].'</div></td>';
            $output['data'] .= '<td><div>'.$row['password'].'</div></td>';
            $output['data'] .= '<td><div>'.$row['descripcion'].'</div></td>';
            $output['data'] .= '<td><a href="javascript:void(0);" class="texto-simple-bla" onclick="openEditModal(' . $row['id'] . ')"><div><span style="color: white;"><i class="bi bi-pencil-square"></i></span></a></div></td>';
            $output['data'] .= '<td><div class="checkbox-wrapper-39">
                                <label>
                                    <input type="checkbox" id="" class="">
                                    <span class="checkbox"></span>
                                </label></div></td>';
            $output['data'] .= '</tr>';
        }
    } else{
        $output['data'] .= '<tr>';
        $output['data'] .= '<td colspan="8"><div>Upss... Parece que te has perdido.</div></td>';
        $output['data'] .= '</tr>';
    }

    if($output['totalRegistros'] > 0){
        $totalPaginas = ceil($output['totalRegistros'] / $limit);

        $output['paginacion'] .= '<ul>';

        $pagInicial = 1;
        
        if(($pagina - 4) > 1){
            $pagInicial = $pagina - 4;
        }

        $pagFinal = $pagInicial + 9;

        if($pagFinal > $totalPaginas){
            $pagFinal = $totalPaginas;
        }

        for($i = $pagInicial ; $i <= $totalPaginas ; $i++){
            if($pagina == $i){
                $output['paginacion'] .= '<li class="no-paginacion-active">'.$i.'</li>';
            }else{
                $output['paginacion'] .= '<li class="no-paginacion" onclick="nextPage('.$i.')">'.$i.'</li>';
            }
        }

        $output['paginacion'] .= '</ul>';

    }

    echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>