<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>

<style>
    /* Hiding the checkbox, but allowing it to be focused */
    .badgebox {
        opacity: 0;
    }

    .badgebox+.badge {
        /* Move the check mark away when unchecked */
        text-indent: -999999px;
        /* Makes the badge's width stay the same checked and unchecked */
        width: 27px;
    }

    .badgebox:focus+.badge {
        /* Set something to make the badge looks focused */
        /* This really depends on the application, in my case it was: */
        /* Adding a light border */
        box-shadow: inset 0px 0px 5px;
        /* Taking the difference out of the padding */
    }

    .badgebox:checked+.badge {
        /* Move the check mark back when checked */
        text-indent: 0;
    }

    .control-group.error .help-inline {
        display: flex;
    }

    .form-horizontal .control-group {
        border-bottom: 1px solid #ffffff;
    }

    .form-horizontal .controls {
        margin-left: 20px;
        padding-bottom: 8px 0;
    }

    .form-horizontal .control-label {
        text-align: left;
        padding-top: 15px;
    }

    .nopadding {
        padding: 0 20px !important;
        margin-right: 20px;
    }

    .widget-title h5 {
        padding-bottom: 30px;
        text-align-last: left;
        font-size: 2em;
        font-weight: 500;
    }

    @media (max-width: 480px) {
        form {
            display: contents !important;
        }

        .form-horizontal .control-label {
            margin-bottom: -6px;
        }

        .btn-xs {
            position: initial !important;
        }
    }
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-wrench"></i>
                </span>
                <h5>Editar Veículo</h5>
            </div>
            <div class="widget-content nopadding tab-content">                
                <ul class="nav nav-tabs">
                    <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes</a></li>
                    <li id="tabClientes"><a href="#tab2" data-toggle="tab">Clientes</a></li>
                </ul>
                <div class="tab-content">
                    <!--Detalhes-->
                    <div class="tab-pane active" id="tab1">
                        <div class="span6">
                            <?php echo $custom_error; ?>
                            <form action="<?php echo current_url(); ?>" id="formVeiculo" method="post" class="form-horizontal">
                                <?php echo form_hidden('idVeiculos', $result->idVeiculos) ?>
                                <div class="control-group">
                                    <label for="placa" class="control-label">Placa<span class="required">*</span></label>
                                    <div class="controls">
                                        <input id="placa" maxlength="10" type="text" name="placa" value="<?=$result->placa?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="marca" class="control-label">Marca<span class="required">*</span></label>
                                    <div class="controls">
                                        <input id="marca" maxlength="50" type="text" name="marca" value="<?=$result->marca?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="modelo" class="control-label">Modelo<span class="required">*</span></label>
                                    <div class="controls">
                                        <input id="modelo" maxlength="50" type="text" name="modelo" value="<?=$result->modelo?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="cor" class="control-label">Cor<span class="required">*</span></label>
                                    <div class="controls">
                                        <input id="cor" maxlength="50" type="text" name="cor" value="<?=$result->cor?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="ano" class="control-label">Ano<span class="required">*</span></label>
                                    <div class="controls">
                                        <input id="ano" maxlength="10" type="text" name="ano" value="<?=$result->ano?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="combustivel" class="control-label">Combustível<span class="required">*</span></label>
                                    <div class="controls">
                                        <select name="combustivel" id="combustivel">
                                            <option value="Gasolina" <?=($result->combustivel === 'Gasolina') ? 'selected' : ''?>>Gasolina</option>
                                            <option value="Alcool" <?=($result->combustivel === 'Alcool') ? 'selected' : ''?>>Alcool</option>
                                            <option value="Flex" <?=($result->combustivel === 'Flex') ? 'selected' : ''?>>Flex</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="span12">
                                        <div class="span6 offset3" style="display:flex;justify-content: center">
                                            <button type="submit" class="button btn btn-primary" style="max-width: 160px"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
                                            <a href="<?php echo base_url() ?>index.php/veiculos" id="btnAdicionar" class="button btn btn-mini btn-warning" style="max-width: 160px">
                                            <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Fim tab Detalhes -->
                    <!--Clientes-->
                    <div class="tab-pane" id="tab2">
                        <div class="span12 well" style="padding: 1%; margin-left: 0">
                            <form id="formClientes" action="<?php echo base_url() ?>index.php/veiculos/adicionarCliente" method="post">
                                <div class="span10">
                                    <input type="hidden" name="idClientes" id="idClientes" />
                                    <input type="hidden" name="idVeiculos" id="idVeiculos" value="<?php echo $result->idVeiculos; ?>" />
                                    <label for="">Cliente</label>
                                    <input type="text" class="span12" name="cliente" id="cliente" placeholder="Digite o nome do cliente" />
                                </div>
                                <div class="span2">
                                    <label for="">&nbsp;</label>
                                    <button class="button btn btn-mini btn-success"><span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2"> Adicionar</span></a>
                                </div>
                            </form>
                        </div>
                        <div id="listaVeiculos">
                            <div class="widget-box" id="divClientes">
                                <div class="widget_content nopadding">
                                    <table width="100%" class="table table-bordered" id="tblClientes">
                                        <thead>
                                            <tr>
                                                <th>Cód.</th>
                                                <th>Nome</th>
                                                <th>CPF/CNPJ</th>
                                                <th>Telefone</th>
                                                <th>Email</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totals = 0;
                                            foreach ($clientes as $s) {
                                                echo '<tr>';
                                                echo '<td>' . $s->idClientes . '</td>';
                                                echo '<td><a href="' . base_url() . 'index.php/clientes/visualizar/' . $s->idClientes . '" style="margin-right: 1%">' .$s->nomeCliente. '</a></td>';
                                                echo '<td>' . $s->documento . '</td>';
                                                echo '<td>' . $s->telefone . '</td>';
                                                echo '<td>' . $s->email . '</td>';
                                                echo '<td><span idAcao="' . $s->idClientes . '" title="Desvincular Cliente" class="btn-nwe4 cliente"><i class="bx bx-trash-alt bx-xs"></i></span></td>';
                                                echo '</tr>';
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fim tab Clientes -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".money").maskMoney();
        $('#formVeiculo').validate({
            rules: {
                placa: {
                    required: true
                },
                marca: {
                    required: true
                },
                modelo: {
                    required: true
                },
                cor: {
                    required: true
                },
                ano: {
                    required: true
                },
                combustivel: {
                    required: true
                },
            },
            messages: {
                placa: {
                    required: 'Campo Requerido.'
                },
                marca: {
                    required: 'Campo Requerido.'
                },
                modelo: {
                    required: 'Campo Requerido.'
                },
                cor: {
                    required: 'Campo Requerido.'
                },
                ano: {
                    required: 'Campo Requerido.'
                },
                combustivel: {
                    required: 'Campo Requerido.'
                },
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/clientes/autoCompleteCliente",
            minLength: 2,
            select: function(event, ui) {
                $("#idClientes").val(ui.item.id);
            }
        });

        $("#formClientes").validate({
            rules: {
                cliente: {
                    required: true
                },
            },
            messages: {
                cliente: {
                    required: 'Insira um cliente'
                },
            },
            submitHandler: function(form) {
                var idClientes = $("#idClientes").val();
                var idVeiculos = "<?php echo $result->idVeiculos ?>"

                $("#listaVeiculos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/veiculos/vincularCliente",
                    data: { idClientes, idVeiculos },
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == true) {
                            $("#listaVeiculos").load("<?php echo current_url(); ?> #divClientes");
                            $("#cliente").val('').focus();
                        } else {
                            $("#listaVeiculos").load("<?php echo current_url(); ?> #divClientes");
                            $("#cliente").val('').focus();
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: data.message
                            });
                        }
                    }
                });
                return false;
            }
        });

        $(document).on('click', '.cliente', function(event) {
            var idClientes = $(this).attr('idAcao');
            var idVeiculos = "<?php echo $result->idVeiculos ?>"

            $("#listaVeiculos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/veiculos/desvincularCliente",
                data: { idClientes, idVeiculos },
                dataType: 'json',
                success: function(data) {
                    if (data.result == true) {
                        $("#listaVeiculos").load("<?php echo current_url(); ?> #divClientes");
                    } else {
                        Swal.fire({
                            type: "error",
                            title: "Atenção",
                            text: "Ocorreu um erro ao tentar desvincular cliente."
                        });
                    }
                }
            });
            return false;
        });
    });
</script>
