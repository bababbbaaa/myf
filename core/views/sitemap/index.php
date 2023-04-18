<?php
/* @var $urls */
/* @var $host */
/* @var $static */

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
      <?php foreach($static as $item): ?>
          <?php for($i = 0; $i < count($item); $i++): ?>
              <url>
                  <loc><?= $host .'/'. $item[$i]; ?></loc>
                  <changefreq>weekly</changefreq>
                  <priority>1</priority>
              </url>
          <?php endfor; ?>
      <?php endforeach; ?>
      <?php for($i = 0; $i < count($urls); $i++): ?>
        <url>
            <loc><?= $host .'/'. $urls[$i]; ?></loc>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
      <?php endfor; ?>
</urlset>