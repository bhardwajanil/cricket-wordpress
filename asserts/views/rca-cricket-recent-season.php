<div class="rca-container rca-margin">
  <div class="rca-row">
    <!--Widget Inner -->
    <div class="rca-column-12">
      <div class="rca-menu-widget rca-left-border">
        <ul class="rca-season-list">
          
          <?php foreach ($recentSeasonData as $key => $match) :?>

            <li>
              <a href="<?php echo $matchUrlPrefix. $match['key'] . '/' ?>">
                <?php echo $match['short_name'] ; ?>
              </a>
            </li>

          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>