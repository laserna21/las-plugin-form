<?php
/**
 * Plugin Name: Las Plugin Form
 * Author: Luis Laserna
 * Description: Plugin para implementar un formulario, mediante un shortcode y select anidados
 * shortcode [las-plugin-form]
 */

register_activation_hook(__FILE__, 'las_encuestados_init');

function las_encuestados_init(){
    global $wpdb; // Este objeto global permite acceder a la base de datos de WP
    // Crea la tabla sólo si no existe
    // Utiliza el mismo prefijo del resto de tablas
    $tabla_encuestados = $wpdb->prefix . 'base_encuestados';
    // Utiliza el mismo tipo de orden de la base de datos
    $charset_collate = $wpdb->get_charset_collate();
    // Prepara la consulta
    $query = "CREATE TABLE IF NOT EXISTS $tabla_encuestados (
        idEncuestado int(5) auto_increment,
        nombres varchar(50) not null,
        apellidos varchar(50) not null,
        correo varchar(50) not null,
        edad int(2) not null,
        sexo varchar(9) not null,
        celular varchar(15) not null,
        fijo varchar(15) default null,
        pais varchar(20) not null,
        departamento varchar(20) default null,
        provincia varchar(20) default null,
        distrito varchar(20) default null,
        direccion varchar(120) not null,
        aceptacion smallint(4) not null,
        creado datetime not null,
        validado boolean default false,
        PRIMARY KEY (idEncuestado)
        ) $charset_collate;";
    // La función dbDelta permite crear tablas de manera segura se
    // define en el archivo upgrade.php que se incluye a continuación
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($query); // Lanza la consulta para crear la tabla de manera segura

}
//Define el shortcode que pinta el formulario
add_shortcode('las_plugin_form','Las_Plugin_Form');


function Las_Plugin_Form(){
    global $wpdb;

    if(!empty($_POST) and $_POST['nombre'] != '' and $_POST['apellido'] != '' and is_email($_POST['correo']) and 
    is_numeric($_POST['edad'])){
        $tabla_encuestados = $wpdb->prefix . 'base_encuestados';
        //Saneamos lo que viene
        $nombre = sanitize_text_field($_POST['nombre']);
        $apellido = sanitize_text_field($_POST['apellido']);
        $correo = sanitize_email($_POST['correo']);
        $edad = (int)$_POST['edad'];
        $sexo = sanitize_text_field($_POST['sexo']);
        $celular = sanitize_text_field($_POST['celular']);
        $fijo = sanitize_text_field($_POST['fijo']);
        $pais = sanitize_text_field($_POST['pais']);
        $departamento = sanitize_text_field($_POST['departamento']);
        $provincia = sanitize_text_field($_POST['provincia']);
        $distrito = sanitize_text_field($_POST['distrito']);
        $direccion = sanitize_text_field($_POST['direccion']);
        $aceptacion = (int)$_POST['aceptacion'];
        $creado = date('Y-m-d');

        $wpdb->insert($tabla_encuestados, 
            array(
                'nombres' => $nombre,
                'apellidos' => $apellido,
                'correo' => $correo,
                'edad' => $edad,
                'sexo' => $sexo,
                'celular' => $celular,
                'fijo' => $fijo,
                'pais' => $pais,
                'departamento' => $departamento,
                'provincia' => $provincia,
                'distrito' => $distrito,
                'direccion' => $direccion,
                'aceptacion' => $aceptacion,
                'creado' => $creado
            )
        );
    }
    wp_enqueue_script('js_eventos',plugins_url('eventos.js', __FILE__),array(),'1.0.0','true');
    // Carga esta hoja de estilo para poner más bonito el formulario
    wp_enqueue_style('css_aspirante', plugins_url('style.css', __FILE__));
    //Buffer de salida en html
    ob_start();
    ?>
    <!-- Escribimos html-->
    <form action="<?php get_the_permalink(); ?>" method = "post" class="encuestados">
        <?php wp_nonce_field('graba_encuestado','encuestado_nonce');?>
        <div class="form-input">
            <label for="nombre">Nombres</label>
            <input type="text" name="nombre" id="nombre" require="required">
        </div>
        <div class="form-input">
            <label for="apellido">Apellidos</label>
            <input type="text" name="apellido" id="apellido" require="required">
        </div>
        <div class="form-input">
            <label for='correo'>Correo</label>
            <input type="email" name="correo" id="correo" required>
        </div>
        <div class="form-input">
            <label for="edad">Edad</label>
            <input type="number" name="edad" id="edad" require="required">
        </div>
        <div class="form-input">
            <label for="sexo">Sexo</label>
            <select name="sexo" id="sexo" require="required">
                <option value="Masculino">Masculino</option> 
                <option value="Femenino" selected>Femenino</option>
            </select> 
        </div>
        <div class="form-input">
            <label for="celular">Celular</label>
            <input type="number" name="celular" id="celular" require="required">
        </div>
        <div class="form-input">
            <label for="fijo">T. Fijo</label>
            <input type="number" name="fijo" id="fijo">
        </div>
        <div class="form-input">
            <label for="pais">Pais</label>
            <select name="pais" id="pais" require="required">
                <option value="0">ELIGE UN PAIS</option>
                <?php
                    $paises = $wpdb->get_results("Select * from {$wpdb->prefix}pais");
                    foreach($paises as $p){
                        echo '<option value="'.$p->idPais.'">'.$p->pais.'</option>';
                    }
                ?>
            </select> 
        </div>
        <div class="form-input" id="div-dep">
            <label for="departamento">Departamento</label>
            <select name="departamento" id="departamento" require="required">
            </select> 
        </div>
        <div class="form-input" id="div-prov">
            <label for="provincia">Provincia</label>
            <select name="provincia" id="provincia" require="required">
                <option value="0">ELIGE UNA PROVINCIA</option>
            </select> 
        </div>
        <div class="form-input" id="div-dist">
            <label for="distrito">Distrito</label>
            <select name="distrito" id="distrito" require="required">
                <option value="0">ELIGE UN DISTRITO</option>
            </select> 
        </div>
        <div class="form-input">
            <label for="direccion">Direcci&oacute;n</label>
            <input type="text" name="direccion" id="direccion" require="required">
        </div>
        <div class="form-input">
            <label for="aceptacion">La información facilitada se tratará 
            con respeto y admiración.</label>
            <input type="checkbox" id="aceptacion" name="aceptacion"
            value="1" required> Entiendo y acepto las condiciones
        </div>
        <div class="form-input">
            <input type="submit" value="Enviar">
        </div>
    </form>
    <?php
    //Nos devuelve el buffer y limpio
    return ob_get_clean();
}

add_action("admin_menu","Las_Encuestado_menu");
/*Agrega el menú del plugin al formulario de wordpress */
function Las_Encuestado_menu(){
    add_menu_page("Formulario Encuestados","Encuestados","manage_option","las_encuestado_menu",
                    "Las_Encuestado_admin","dashicons-feedback",75);
}

function Las_Encuestado_admin(){
     
}

function Kfp_Obtener_IP_usuario()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED',
        'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
}
