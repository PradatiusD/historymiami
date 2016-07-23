<?php

/**
* Template Name: YouTube Channel
* Description: Show the YouTube contents of the HistoryMiami Channel
*/

require_once('lib/autoload.php');

use Madcoda\Youtube;

add_action('genesis_entry_content', 'fetch_youtube_content');
function fetch_youtube_content () {

  $API_KEY    = array('key'=>'AIzaSyDzlNWMERQBNuB2fYVPH9SevZHP0miNh84');
  $CHANNEL_ID = 'UCpmTqfuvyJ-Zzd8__sTQQWg';

  $youtube  = new Youtube($API_KEY);
  $response = $youtube->getPlaylistsByChannelId($CHANNEL_ID);

  foreach ($response as $playlist){

    echo "<h3>".$playlist->snippet->title."</h3>";
    $videos = $youtube->getPlaylistItemsByPlaylistId($playlist->id);?>

    <?php
    foreach ($videos as $video) {
      $metadata = $video->snippet;
      $date     = date_format(date_create($metadata->publishedAt), 'l jS F Y');
      $videoURL = 'https://www.youtube.com/watch?v='.$video->contentDetails->videoId;
      ?>
        <div class="video-card">
          <a href="<?php echo $videoURL;?>" target="_blank" class="video-image pull-left" style="background-image: url('<?php echo $metadata->thumbnails->high->url; ?>')">
          </a>

          <div>
            <h4>
              <a href="<?php echo $videoURL; ?>" target="_blank">
                <?php echo $metadata->title;?>
              </a><br>
              <small><?php echo $date; ?></small>
            </h4>
            <p><?php echo $metadata->description; ?></p>            
          </div>
        </div>
        <br>
      <?php
    }
    echo "<hr>";
  }
}


add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

genesis();