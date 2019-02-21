$(document).ready(function () {

    var page = 1;
    var current_page = 1;
    var total_page = 0;
    var is_ajax_fire = 0;

    manageData();

    /* manage data list */
    function manageData() {
        $.ajax({
            dataType: 'json',
            url: url + 'getData.php',
            data: {page: page, op: 1}
        }).done(function (data) {
            total_page = Math.ceil(data.total / 5);
            current_page = page;

            $('#pagination').twbsPagination({
                totalPages: total_page,
                visiblePages: current_page,
                onPageClick: function (event, pageL) {
                    page = pageL;
                    if (is_ajax_fire != 0) {
                        getPageData(1);
                    }
                }
            });

            manageRow(data.data);
            is_ajax_fire = 1;

        });
    }

    /* Get Page Data*/
    function getPageData(operacao) {
        $.ajax({
            dataType: 'json',
            url: url + 'getData.php',
            data: {page: page, op: operacao}
        }).done(function (data) {
            if (operacao == 1)
                manageRow(data.data);
            else if (operacao == 2)
                manageRowEstado(data.data);
        });
    }

    /* Add states in select */
    function manageRowEstado(data) {
        var options = '<option>Selecione seu estado de nascimento</option>';
        $.each(data, function (key, value) {
            options = options + '<option value="' + value.id_estado + '">' + value.descricao + '</option>';
        });

        $('select[name=estado]').empty();
        $('select[name=estado]').append(options);
    }

    /* Add new client table row */
    function manageRow(data) {
        var rows = '';
        $.each(data, function (key, value) {
            var dat = value.data_nascimento.split('-');
            dat = dat[2] + '/' + dat[1] + '/' + dat[0];

            rows = rows + '<tr>';
            rows = rows + '<td>' + value.nome + '</td>';
            rows = rows + '<td>' + dat + '</td>';
            rows = rows + '<td>' + (value.sexo == 'M' ? 'Masculino' : 'Feminino') + '</td>';
            rows = rows + '<td>' + value.descricao + '</td>';
            rows = rows + '<td>' + (value.situacao == 1 ? 'Ativo' : 'Inativo') + '</td>';
            rows = rows + '<td data-id="' + value.id_cliente + '">';
            rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Editar</button> ';
            rows = rows + '<button class="btn btn-danger remove-item">Excluir</button>';
            rows = rows + '</td>';
            rows = rows + '</tr>';
        });

        $("tbody").html(rows);
    }

    /* Preencher o select dos estados */
    $("#btnCadastrar").click(function (e) {
        e.preventDefault();
        getPageData(2);
    });

    /* Create new client */
    $(".crud-submit").click(function (e) {
        e.preventDefault();
        var form_action = $("#create-item").find("form").attr("action");
        var nome = $("#create-item").find("input[name='nome']").val();
        var sexo = $("#create-item").find("select[name='sexo']").val();
        var estado = $("#create-item").find("select[name='estado']").val();
        var situacao = $("#create-item").find("select[name='situacao']").val();
        var jsDate = $('#data_nascimento').datepicker('getDate');

        if (nome != '' && jsDate != null && sexo != '' && situacao != '' && estado != '') {

            var date = jsDate.toLocaleString('en-US', {hour12: false}).split(" ");
            var time = date[1];
            var mdy = date[0];
            mdy = mdy.split('/');
            var month = parseInt(mdy[0]);
            var day = parseInt(mdy[1]);
            var year = parseInt(mdy[2]);
            var formattedDate = year + '-' + month + '-' + day + ' ' + time;

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: url + form_action,
                data: {nome: nome, data_nascimento: formattedDate, sexo: sexo, estado: estado, situacao: situacao}
            }).done(function (data) {
                $("#create-item").find("input[name='nome']").val('');
                $("#create-item").find("input[name='data_nascimento']").val('');

                getPageData(1);
                $(".modal").modal('hide');
                toastr.success('Cliente criado com sucesso.', 'Success Alert', {timeOut: 5000});
            });
        } else {
            alert('Dados obrigatórios ausente, por favor tente novamente.');
        }
    });

    /* Remove client */
    $("body").on("click", ".remove-item", function () {
        var id = $(this).parent("td").data('id');
        var c_obj = $(this).parents("tr");

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: url + 'delete.php',
            data: {id: id}
        }).done(function (data) {
            c_obj.remove();
            toastr.success('Cliente deletado com sucesso.', 'Success Alert', {timeOut: 5000});
            getPageData(1);
        });
    });

    /* Edit client */
    $("body").on("click", ".edit-item", function () {
        var id = $(this).parent("td").data('id');
        var nome = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
        var data_nascimento = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
        var sexo = $(this).parent("td").prev("td").prev("td").prev("td").text();
        var estado = $(this).parent("td").prev("td").prev("td").text();
        var situacao = $(this).parent("td").prev("td").text();

        var id_estado = 0;
        /* Get estados */
        $.ajax({
            dataType: 'json',
            url: url + 'getData.php',
            data: {op: 2}
        }).done(function (data) {

            $.each(data.data, function (key, value) {
                if (estado === value.descricao)
                    id_estado = value.id_estado;
            });

            manageRowEstado(data.data);

            $("#edit-item").find("input[name='nome']").val(nome);
            $("#edit-item").find("input[name='data_nascimento']").val(data_nascimento);
            $("#edit-item").find("select[name='sexo']").val(sexo == 'Masculino' ? 'M' : 'F');
            $("#edit-item").find("select[name='estado']").val(id_estado);
            $("#edit-item").find("select[name='situacao']").val(situacao == 'Ativo' ? '1' : '0');
            $("#edit-item").find(".edit-id").val(id);
        });
    });

    /* Updated new Client */
    $(".crud-submit-edit").click(function (e) {
        e.preventDefault();
        var form_action = $("#edit-item").find("form").attr("action");
        var nome = $("#edit-item").find("input[name='nome']").val();
        var sexo = $("#edit-item").find("select[name='sexo']").val();
        var estado = $("#edit-item").find("select[name='estado']").val();
        var situacao = $("#edit-item").find("select[name='situacao']").val();
        var id = $("#edit-item").find(".edit-id").val();
        var jsDate = $('#data_nascimento_edit').datepicker('getDate');

        if (nome != '' && jsDate != null && sexo != '' && situacao != '' && estado != '') {

            // Parse our locale string to [date, time]
            var date = jsDate.toLocaleString('en-US', {hour12: false}).split(" ");

            // Now we can access our time at date[1], and monthdayyear @ date[0]
            var time = date[1];
            var mdy = date[0];

            // We then parse  the mdy into parts
            mdy = mdy.split('/');
            var month = parseInt(mdy[0]);
            var day = parseInt(mdy[1]);
            var year = parseInt(mdy[2]);

            // Putting it all together
            var formattedDate = year + '-' + month + '-' + day + ' ' + time;

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: url + form_action,
                data: {
                    nome: nome,
                    data_nascimento: formattedDate,
                    sexo: sexo,
                    estado: estado,
                    situacao: situacao,
                    id: id
                }
            }).done(function (data) {
                getPageData(1);
                $(".modal").modal('hide');
                toastr.success('Cliente atualizado com sucesso.', 'Success Alert', {timeOut: 5000});
            });
        } else {
            alert('Dados obrigatórios ausente, por favor tente novamente.')
        }
    });
});