<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>CRUD - Jquery, PHP and Mysql - CRP</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link href="css/principal.css" rel="stylesheet">

    <script type="text/javascript">
        var url = "http://localhost:8000/";

        $(function() {
            $("#btnVoltar").click(function (e) {
                e.preventDefault();
                window.location = url;
            });
        });
    </script>
</head>
<body>
    <h3>Teste meu amigo rsrs</h3>
    <button type="button" id="btnVoltar" class="btn btn-success">
        Voltar
    </button>
</body>
</html>