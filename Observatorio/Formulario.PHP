<?php include 'encabezado.php'; ?>

<div class="contenedor">
    <h1>Editar incidencia</h1>

    <form method="post" class="form-issste">

        <!-- Incidencia / problema -->
        <label for="incidencia_problema">Incidencia / problema</label>
        <textarea name="incidencia_problema" id="incidencia_problema" required>
<?= htmlspecialchars($inc['incidencia_problema']) ?>
        </textarea>

        <div class="fila">
            <!-- Prioridad -->
            <div class="col-50">
                <label for="prioridad_impacto">Prioridad / impacto</label>
                <select name="prioridad_impacto" id="prioridad_impacto" required>
                    <option value="BAJA"    <?= $inc['prioridad_impacto']=='BAJA'?'selected':'' ?>>BAJA</option>
                    <option value="MEDIA"   <?= $inc['prioridad_impacto']=='MEDIA'?'selected':'' ?>>MEDIA</option>
                    <option value="ALTA"    <?= $inc['prioridad_impacto']=='ALTA'?'selected':'' ?>>ALTA</option>
                    <option value="CRÍTICA" <?= $inc['prioridad_impacto']=='CRÍTICA'?'selected':'' ?>>CRÍTICA</option>
                </select>
            </div>

            <!-- Asignado a -->
            <div class="col-50">
                <label for="asignado_a">Asignado a</label>
                <input type="text" name="asignado_a" id="asignado_a"
                       value="<?= htmlspecialchars($inc['asignado_a']) ?>">
            </div>
        </div>

        <div class="fila">
            <!-- Estado -->
            <div class="col-50">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" required>
                    <option value="ABIERTA"     <?= $inc['estado']=='ABIERTA'?'selected':'' ?>>ABIERTA</option>
                    <option value="EN PROCESO"  <?= $inc['estado']=='EN PROCESO'?'selected':'' ?>>EN PROCESO</option>
                    <option value="RESUELTA"    <?= $inc['estado']=='RESUELTA'?'selected':'' ?>>RESUELTA</option>
                    <option value="CERRADA"     <?= $inc['estado']=='CERRADA'?'selected':'' ?>>CERRADA</option>
                </select>
            </div>

            <!-- Corregido -->
            <div class="col-50" style="display:flex; align-items:center; margin-top:22px;">
                <label style="display:flex; align-items:center; gap:6px;">
                    <input type="checkbox" name="corregido" <?= $inc['corregido'] ? 'checked' : '' ?>>
                    Marcar como corregido
                </label>
            </div>
        </div>

        <div class="acciones" style="margin-top:20px;">
            <button type="submit" class="btn-primario">Guardar cambios</button>
        </div>

    </form>
</div>

<?php include 'pie.php'; ?>
