<tr>
  <td class="text-center">
    <?= $dates['title']; ?>
  </td>

  <?php foreach ($items as $key => $value): ?>
    <td class="text-center">
      <p><?= $value ?></p>
    </td>
  <?php endforeach; ?>
</tr>
