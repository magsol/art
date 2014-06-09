<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Twitter OAuth in PHP</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <style type="text/css">
      img {border-width: 0}
      * {font-family:'Lucida Grande', sans-serif;}

      p {
        width: 50%;
      }
    </style>
  </head>
  <body>
    <div>
      <h2>Garmin Connect Monthly</h2>

      <p>This page will authorize the "GC Monthly" app to post once-a-month statistics updates, taken from your Garmin Connect account, to your Twitter account. The monthly tweets follow the <a href="http://dailymile.com">DailyMile</a> stylistic convention:</p>

      <img src="images/example.png" style="border: 1px solid #000000;" />

      <p><strong>IMPORTANT: This requires your Garmin Connect username and password.</strong> Your username and password are not accessible through any web service. They are also encrypted while stored; I will never decrypt them or view them in plaintext. But it still comes down to whether or not you trust <a href="images/thisguy.jpg" target="_blank">this guy</a> with your Garmin Connect credentials. Unfortunately, until Garmin Connect implements some version of OAuth or provides developers a more sophisticated API, this is the best I can offer.</p>

      <p>
        What this does
        <ul>
          <li>Logs into Garmin Connect on the 1st of each month, counts up your <strong>Running</strong> items, and totals the miles and calories</li>
          <li>Uses the authorization you provide here through your Twitter account to post an update on your behalf</li>
        </ul>
      </p>

      <p>
        What this doesn't do
        <ul>
          <li>Access other services for statistics (e.g. Strava...at least, not yet!)</li>
          <li>Tabulate other types of activities on Garmin Connect (e.g. Cycling...at least, not yet!)</li>
          <li>Tweet more than once a month</li>
        </ul>
      </p>

      <p>If you're still interested, click the "Sign In" button. If you're having problems getting this to work, try <strong><a href='./clearsessions.php'>clearing your session</a>.</p>

      <!--
      <p>
        Links:
        <a href='http://github.com/abraham/twitteroauth'>Source Code</a> &amp;
        <a href='http://wiki.github.com/abraham/twitteroauth/documentation'>Documentation</a> |
        Contact @<a href='http://twitter.com/abraham'>abraham</a>
      </p>
    -->
      <hr />
      <?php if (isset($menu)) { ?>
        <?php echo $menu; ?>
      <?php } ?>
    </div>
    <?php if (isset($status_text)) { ?>
      <?php echo '<h3>'.$status_text.'</h3>'; ?>
    <?php } ?>
    <p>
      <pre>
        <?php print_r($content); ?>
      </pre>
    </p>

  </body>
</html>
