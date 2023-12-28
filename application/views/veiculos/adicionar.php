<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-wrench"></i>
                </span>
                <h5>Cadastro de Veiculo</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formVeiculo" method="post" class="form-horizontal">
                    <div class="control-group">
                        <label for="placa" class="control-label">Placa<span class="required">*</span></label>
                        <div class="controls">
                            <input id="placa" maxlength="10" type="text" name="placa" value="<?=set_value('placa')?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="marca" class="control-label">Marca<span class="required">*</span></label>
                        <div class="controls">
                            <input id="marca" maxlength="50" type="text" name="marca" value="<?=set_value('marca')?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="modelo" class="control-label">Modelo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="modelo" maxlength="50" type="text" name="modelo" value="<?=set_value('modelo')?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="cor" class="control-label">Cor<span class="required">*</span></label>
                        <div class="controls">
                            <input id="cor" maxlength="50" type="text" name="cor" value="<?=set_value('cor')?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="ano" class="control-label">Ano<span class="required">*</span></label>
                        <div class="controls">
                            <input id="ano" maxlength="10" type="text" name="ano" value="<?=set_value('ano')?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="combustivel" class="control-label">Combustível<span class="required">*</span></label>
                        <div class="controls">
                            <select name="combustivel" id="combustivel">
                                <option value="Gasolina" <?=(set_value('combustivel') === 'Gasolina') ? 'selected' : ''?>>Gasolina</option>
                                <option value="Alcool" <?=(set_value('combustivel') === 'Alcool') ? 'selected' : ''?>>Alcool</option>
                                <option value="Flex" <?=(set_value('combustivel') === 'Flex') ? 'selected' : ''?>>Flex</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/veiculos" id="btnAdicionar" class="btn"><i class="fas fa-backward"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
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
    });
</script>
