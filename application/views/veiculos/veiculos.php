<style>
  select {
    width: 70px;
  }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-wrench"></i>
        </span>
        <h5>Veículos</h5>
    </div>
    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aVeiculo')) { ?>
    <a href="<?php echo base_url() ?>index.php/veiculos/adicionar" class="button btn btn-mini btn-success" style="max-width: 160px">
      <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2"> Veículos</span></a>
<?php } ?>

    <div class="widget-box">
        <h5 style="padding: 3px 0"></h5>
        <div class="widget-content nopadding tab-content">
            <table id="tabela" class="table table-bordered ">
                <thead>
                    <tr>
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
                                    <td colspan="8">Nenhum Veículo Cadastrado</td>
                                </tr>';
                        }
                        foreach ($results as $r) {
                            echo '<tr>';
                            echo '  <td>' . $r->idVeiculos . '</td>';
                            echo '  <td>' . $r->placa . '</td>';
                            echo '  <td>' . $r->marca . '</td>';
                            echo '  <td>' . $r->modelo . '</td>';
                            echo '  <td>' . $r->cor . '</td>';
                            echo '  <td>' . $r->ano . '</td>';
                            echo '  <td>' . $r->combustivel . '</td>';
                            echo '  <td>';
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVeiculo')) {
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/veiculos/editar/' . $r->idVeiculos . '" class="btn-nwe3" title="Editar Veículo"><i class="bx bx-edit bx-xs"></i></a>';
                            }
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dVeiculo')) {
                                echo '<a href="#modal-excluir" role="button" data-toggle="modal" veiculo="' . $r->idVeiculos . '" class="btn-nwe4" title="Excluir Veículo"><i class="bx bx-trash-alt bx-xs"></i></a>  ';
                            }
                            echo '</td>';
                            echo '</tr>';
                        } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->data['configuration']['control_datatable'] ? "" : $this->pagination->create_links() ?>

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/veiculos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Veículo</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idVeiculo" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este veículo?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
          <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
          <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
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
