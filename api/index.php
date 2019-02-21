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

    <script type="text/javascript" src="principal.js"></script>

    <script type="text/javascript">
        var url = "http://localhost:8000/";

        $(function() {
            $("#data_nascimento").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '-100y:c+nn',
                maxDate: '-1d'
            });

            $("#data_nascimento_edit").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '-100y:c+nn',
                maxDate: '-1d'
            });

            $("#btnRedPage").click(function (e) {
                e.preventDefault();
                window.location = url + "listagem_dependentes.php";
            });
        });
    </script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>CRUD - Jquery, PHP and Mysql - CRP</h2>
            </div>
            <div class="pull-right">
                <button type="button" id="btnCadastrar" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                    Cadastrar Cliente
                </button>
            </div>

            <div class="pull-right">
                <button type="button" id="btnRedPage" class="btn btn-success">
                    Teste Red. Página
                </button>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Data de Nascimento</th>
            <th>Sexo</th>
            <th>Estado</th>
            <th>Situacao</th>
            <th width="200px">Ações</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <ul id="pagination" class="pagination-sm"></ul>

    <!-- Create Item Modal -->
    <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cadastrar Cliente</h4>
                </div>

                <div class="modal-body">
                    <form data-toggle="validator" action="create.php" method="POST">

                        <div class="form-group">
                            <label class="control-label" for="title">Nome:</label>
                            <input type="text" name="nome" class="form-control" data-error="Digite seu nome."
                                   required/>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title">Data de Nascimento:</label>
                            <input type="text" name="data_nascimento" id="data_nascimento" class="form-control"
                                   placeholder="Digite sua data de nascimento." required>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title">Sexo:</label>
                            <select name="sexo" class="form-control" data-error="Selecione seu sexo."
                                    required>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title">Estados:</label>
                            <select name="estado" class="form-control" data-error="Selecione seu estado."
                                    required>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title">Situação:</label>
                            <select name="situacao" class="form-control" data-error="Selecione a situação."
                                    required>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn crud-submit btn-success">Confirmar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Client Modal -->
    <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Cliente</h4>
                </div>

                <div class="modal-body">
                    <form data-toggle="validator" action="update.php" method="put">
                        <input type="hidden" name="id" class="edit-id">

                        <div class="form-group">
                            <label class="control-label" for="title">Nome:</label>
                            <input type="text" name="nome" class="form-control" data-error="Digite seu nome."
                                   required/>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title">Data de Nascimento:</label>
                            <input type="text" name="data_nascimento" id="data_nascimento_edit" class="form-control"
                                   placeholder="Digite sua data de nascimento." required>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title">Sexo:</label>
                            <select name="sexo" class="form-control" data-error="Selecione seu sexo."
                                    required>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title">Estados:</label>
                            <select name="estado" class="form-control" data-error="Selecione seu estado."
                                    required>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title">Situação:</label>
                            <select name="situacao" class="form-control" data-error="Selecione a situação."
                                    required>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success crud-submit-edit">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>