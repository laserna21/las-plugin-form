(function($) {
    $(document).ready(function() {
        $('#div-dep').hide();
        $('#div-prov').hide();
        $('#div-dist').hide();
        $('#pais').change(function() {
            if ($('#pais').val() == 1) {
                poblarDepartamentos();
                $('#div-dep').show();
            } else {
                $('#div-dep').hide();
                $('#div-prov').hide();
                $('#div-dist').hide();
            }
        });

        $('#departamento').change(function() {
            if ($('#departamento').val() != 0) {
                poblarProvincias();
                $('#div-prov').show();
            } else {
                $('#div-prov').hide();
                $('#div-dist').hide();
            }
        });

        $('#provincia').change(function() {
            if ($('#departamento').val() != 0) {
                poblarDistritos();
                $('#div-dist').show();
            } else {
                $('#div-dist').hide();
            }
        });
    });

    function poblarDepartamentos() {
        $.ajax({
            type: "POST",
            url: "../wp-content/plugins/las-plugin-form/tablas.php",
            data: "p=" + $('#pais').val(),
            dataType: 'html'
        }).done(function(data) {
            $('#departamento').html(data);
        });
    }

    function poblarProvincias() {
        $.ajax({
            type: "POST",
            url: "../wp-content/plugins/las-plugin-form/tablas.php",
            data: "d=" + $('#departamento').val(),
            dataType: 'html'
        }).done(function(data) {
            $('#provincia').html(data);
        });
    }

    function poblarDistritos() {
        $.ajax({
            type: "POST",
            url: "../wp-content/plugins/las-plugin-form/tablas.php",
            data: "pr=" + $('#provincia').val(),
            dataType: 'html'
        }).done(function(data) {
            $('#distrito').html(data);
        });
    }
})(jQuery);