<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aVeiculo')) { ?>
    <a href="<?php echo base_url() ?>index.php/veiculos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Veiculo</a>
<?php } ?>

<style>
    .dataTables_paginate {
        text-align: left;
        margin-top: 20px;
        margin-bottom: 20px;
        margin-left: 10px;
    }

    .dataTables_paginate a, .dataTables_paginate .ellipsis {
        color: #2D335B;
        font-size: 12px;
        padding: 4px 10px !important;
        border-style: solid;
        border-width: 1px;
        border-color: #dddddd #dddddd #cccccc;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        display: inline-block;
        line-height: 16px;
        background: #f5f5f5;
        color: #333333;
        text-shadow: 0 1px 0 #ffffff;
        cursor: pointer;
    }

    .dataTables_paginate .current {
        font-weight: bold;
    }
</style>

<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="fas fa-wrench"></i>
        </span>
        <h5>Veiculos</h5>
    </div>
    <div class="widget-content nopadding tab-content">
        <table id="tabela" class="table table-bordered ">
            <thead>
                <tr style="backgroud-color: #2D335B">
                    <th>Cod. Veiculo</th>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Cor</th>
                    <th>Ano</th>
                    <th>Combustível</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!$results) {
                        echo '<tr>
                                <td colspan="8">Nenhum Veiculo Cadastrado</td>
                              </tr>';
                    }
                    foreach ($results as $r) {
                        echo '<tr>';
                        echo '<td>' . $r->idVeiculos . '</td>';
                        echo '<td>' . $r->placa . '</td>';
                        echo '<td>' . $r->marca . '</td>';
                        echo '<td>' . $r->modelo . '</td>';
                        echo '<td>' . $r->cor . '</td>';
                        echo '<td>' . $r->ano . '</td>';
                        echo '<td>' . $r->combustivel . '</td>';
                        echo '<td>';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVeiculo')) {
                            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/veiculos/editar/' . $r->idVeiculos . '" class="btn btn-info tip-top" title="Editar Veiculo"><i class="fas fa-edit"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dVeiculo')) {
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" veiculo="' . $r->idVeiculos . '" class="btn btn-danger tip-top" title="Excluir Veiculo"><i class="fas fa-trash-alt"></i></a>  ';
                        }
                        echo '</td>';
                        echo '</tr>';
                    } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/veiculos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Veiculo</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idVeiculo" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este veiculo?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var veiculo = $(this).attr('veiculo');
            $('#idVeiculo').val(veiculo);
        });
    });
</script>
