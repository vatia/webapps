<table>
  <tr>
    <th>fecha</th>
    <th>h1</th>
    <th>h2</th>
    <th>h3</th>
    <th>h4</th>
    <th>h5</th>
    <th>h6</th>
    <th>h7</th>
    <th>h8</th>
    <th>h9</th>
    <th>h10</th>
    <th>h11</th>
    <th>h12</th>
    <th>h13</th>
    <th>h14</th>
    <th>h15</th>
    <th>h16</th>
    <th>h17</th>
    <th>h18</th>
    <th>h19</th>
    <th>h20</th>
    <th>h21</th>
    <th>h22</th>
    <th>h23</th>
    <th>h24</th>
  </tr>
<?php foreach($data['matrix'] as $k1=>$v1): ?>
  <tr>
    <td><?php echo $v1->fecha; ?></td>
    <td><?php echo $v1->h01r; ?></td>
    <td><?php echo $v1->h02r; ?></td>
    <td><?php echo $v1->h03r; ?></td>
    <td><?php echo $v1->h04r; ?></td>
    <td><?php echo $v1->h05r; ?></td>
    <td><?php echo $v1->h06r; ?></td>
    <td><?php echo $v1->h07r; ?></td>
    <td><?php echo $v1->h08r; ?></td>
    <td><?php echo $v1->h09r; ?></td>
    <td><?php echo $v1->h10r; ?></td>
    <td><?php echo $v1->h11r; ?></td>
    <td><?php echo $v1->h12r; ?></td>
    <td><?php echo $v1->h13r; ?></td>
    <td><?php echo $v1->h14r; ?></td>
    <td><?php echo $v1->h15r; ?></td>
    <td><?php echo $v1->h16r; ?></td>
    <td><?php echo $v1->h17r; ?></td>
    <td><?php echo $v1->h18r; ?></td>
    <td><?php echo $v1->h19r; ?></td>
    <td><?php echo $v1->h20r; ?></td>
    <td><?php echo $v1->h21r; ?></td>
    <td><?php echo $v1->h22r; ?></td>
    <td><?php echo $v1->h23r; ?></td>
    <td><?php echo $v1->h24r; ?></td>
  </tr>
<?php endforeach; ?>
</table>