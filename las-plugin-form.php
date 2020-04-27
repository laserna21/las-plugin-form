<?php
/**
 * Plugin Name: Las Plugin Form
 * Author: Luis Laserna
 * Description: Plugin para implementar un formulario, mediante un shortcode y select anidados
 * shortcode [las-plugin-form]
 */

//Define el shortcode que pinta el formulario
add_shortcode('las_plugin_form','Las_Plugin_Form');

function Las_Plugin_Form(){
    //Buffer de salida en html
    ob_start();
    ?>
    <!-- Escribimos html-->
    <form action="<?php get_the_permalink(); ?>" method = "post" class="encuestados">
        <div class="form-input">
            <label for="nombre">Nombres</label>
            <input type="text" name="nombre" require="required">
        </div>
        <div class="form-input">
            <label for="apellido">Apellidos</label>
            <input type="text" name="apellido" require="required">
        </div>
        <div class="form-input">
            <label for="edad">Edad</label>
            <input type="number" name="edad" require="required">
        </div>
        <div class="form-input">
            <label for="sexo">Sexo</label>
            <select name="sexo" require="required">
                <option value="Masculino">Masculino</option> 
                <option value="Femenino" selected>Femenino</option>
            </select> 
        </div>
        <div class="form-input">
            <label for="celular">Celular</label>
            <input type="number" name="celular" require="required">
        </div>
        <div class="form-input">
            <label for="fijo">T. Fijo</label>
            <input type="number" name="nombre">
        </div>
        <div class="form-input">
            <label for="pais">Pais</label>
            <select name="pais" require="required">
                <option value="1">Peru</option> 
                <option value="2" selected>España</option>
            </select> 
        </div>
        <div class="form-input">
            <label for="departamento">Departamento</label>
            <select name="departamento" require="required">
                <option value="1">Amazonas</option> 
                <option value="2" selected>Ancash</option>
            </select> 
        </div>
        <div class="form-input">
            <label for="provincia">Provincia</label>
            <select name="provincia" require="required">
                <option value="p">papa</option> 
                <option value="m" selected>Mama</option>
            </select> 
        </div>
        <div class="form-input">
            <label for="distrito">Distrito</label>
            <select name="distrito" require="required">
                <option value="p">Santa Anita</option> 
                <option value="m" selected>Pepe</option>
            </select> 
        </div>
        <div class="form-input">
            <label for="direccion">Direcci&oacute;n</label>
            <input type="text" name="direccion" require="required">
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