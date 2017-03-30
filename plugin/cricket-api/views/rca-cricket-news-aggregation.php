<?php
  /**
   *  This is the template for showing the News Aggregation data.
   */
?>

<div class="rca-container rca-margin">
  <div class="rca-row">
    <div class="rca-column-4">
      <!--Latest News-->
        <div class="rca-news-widget">
          <h3>Latest News</h3>
          <?php foreach($newsaggregationData['news'] as $news): ?>
            <div class="rca-post rca-padding">
              <h4>
                <a href="<?php echo $news['link']; ?>" target="_blank">
                  <?php echo $news['title']; ?>
                </a>
              </h4>
              <?php echo $news['description']; ?>
              <p class="rca-post-info"><?php echo date("l jS \of F Y h:i:s A",strtotime($news['updated'])); ?></p>
              <p class="rca-post-info">
                <a href="<?php echo $news['provider']['url']; ?>" target="_blank">
                  <?php echo $news['provider']['name']; ?>
                </a>
              </p>
            </div>
          <?php endforeach; ?>
          
        </div>
    </div>
</div>