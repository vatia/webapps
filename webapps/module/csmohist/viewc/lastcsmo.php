<table>
    <tr>
        <th>Ciclo</th>
        <th>Activa</th>
        <th>Reactiva</th>
    </tr>
<?php foreach($data['facturas'] as $k1=>$v1): ?>
    <tr>
        <td><?php echo $v1->ciclo; ?></td>
        <td><?php echo $v1->csm_act; ?></td>
        <td><?php echo $v1->csm_rea; ?></td>
    </tr>
<?php endforeach; ?>
</table>