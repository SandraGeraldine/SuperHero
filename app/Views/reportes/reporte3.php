<?= $estilos ?>
<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm">
  <page_header>
    <div>Ssandra De La Cruz</div>
  </page_header>
  
  <page_footer>
    <div>Lista De Super Heroes</div>
  </page_footer>

    <table class="table">
      <colgroup>
        <col style="width: 5%;">
        <col style="width: 24%;">
        <col style="width: 30%;">
        <col style="width: 20%;">
        <col style="width: 20%;">
      </colgroup>
      <thead>
        <tr>
          <th>id</th>
          <th>Nombre</th>
          <th>Alias</th>
          <th>Casa</th>
          <th>Bando</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row): ?>
          <tr>
            <td><?= $row['id']?></td>
            <td><?= $row['superhero_name']?></td>
            <td><?= $row['full_name']?></td>
            <td><?= $row['publisher_name']?></td>
            <td><?= $row['alignment']?></td>
          </tr> 
        <?php endforeach; ?>
      </tbody>
    </table>
</page>
