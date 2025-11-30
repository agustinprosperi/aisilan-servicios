<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function add_footer_content()
{
    // Contenido que quieres agregar en el footer
    echo '<script>console.log("Corre un hook");</script>';
}