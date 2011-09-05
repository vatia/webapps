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
    <td><?php echo $v1->h01a; ?></td>
    <td><?php echo $v1->h02a; ?></td>
    <td><?php echo $v1->h03a; ?></td>
    <td><?php echo $v1->h04a; ?></td>
    <td><?php echo $v1->h05a; ?></td>
    <td><?php echo $v1->h06a; ?></td>
    <td><?php echo $v1->h07a; ?></td>
    <td><?php echo $v1->h08a; ?></td>
    <td><?php echo $v1->h09a; ?></td>
    <td><?php echo $v1->h10a; ?></td>
    <td><?php echo $v1->h11a; ?></td>
    <td><?php echo $v1->h12a; ?></td>
    <td><?php echo $v1->h13a; ?></td>
    <td><?php echo $v1->h14a; ?></td>
    <td><?php echo $v1->h15a; ?></td>
    <td><?php echo $v1->h16a; ?></td>
    <td><?php echo $v1->h17a; ?></td>
    <td><?php echo $v1->h18a; ?></td>
    <td><?php echo $v1->h19a; ?></td>
    <td><?php echo $v1->h20a; ?></td>
    <td><?php echo $v1->h21a; ?></td>
    <td><?php echo $v1->h22a; ?></td>
    <td><?php echo $v1->h23a; ?></td>
    <td><?php echo $v1->h24a; ?></td>
  </tr>
<?php endforeach; ?>
</table>