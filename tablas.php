<?php
    require_once('../../../wp-config.php');
    global $wpdb;
    
    if($_POST['p']){
        $departamentos = $wpdb->get_results("Select * from {$wpdb->prefix}departamento where idPais='{$_POST['p']}'");
        $html="<option value='0'>ELIGE UN DEPARTAMENTO</option>";
        foreach($departamentos as $p){
            $html .= "<option value='".$p->idDepa."'>".$p->departamento."</option>"; 
        }
        echo $html;       
    }else if($_POST['d']){
        $provincias = $wpdb->get_results("Select * from {$wpdb->prefix}provincia where idDepa='{$_POST['d']}'");
        $html="<option value='0'>ELIGE UNA PROVINCIA</option>";
        foreach($provincias as $p){
            $html .= "<option value='".$p->idProv."'>".$p->provincia."</option>"; 
        }
        echo $html;       
    }else if($_POST['pr']){
        $distritos = $wpdb->get_results("Select * from {$wpdb->prefix}distrito where idProv='{$_POST['pr']}'");
        $html="<option value='0'>ELIGE UN DISTRITO</option>";
        foreach($distritos as $p){
            $html .= "<option value='".$p->idDist."'>".$p->distrito."</option>"; 
        }
        echo $html;       
    }
?>