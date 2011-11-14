<?php if ($menu_data) { ?>
<div id="menu">
  <ul>
    <?php foreach ($menu_data as $data) { ?>
    <li><a href="<?php echo $data['href']; ?>" <?php if ($data['children']) echo 'class="parent"'; ?>><?php echo $data['name']; ?></a>
      <?php if ($data['children']) { ?>
      <div>
        <?php for ($i = 0; $i < count($data['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($data['children']) / $data['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($data['children'][$i])) { ?>
          <li><a href="<?php echo $data['children'][$i]['href']; ?>"><?php echo $data['children'][$i]['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php } ?>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } ?>