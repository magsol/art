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
      <p>Why hello, <strong><?php echo $access_token['screen_name']; ?></strong>! Looks like the app authorization worked. Remember, if at any time you no longer want this app to post, you can revoke its privileges in your profile options. Let me know too, and I'll delete your GC credentials on my server.</p>

      <p>Speaking of which, now I need your GC credentials. You have my word that I will never read them in plaintext, or decrypt them on my own, or use them for any purpose other than this app.</p>

      <form action="index.php" method="post">
        <table cellspacing="5" cellpadding="5" width="30%">
          <tr>
            <td>GC Username</td>
            <td><input type="text" size="30" name="username" /></td>
          </tr>
          <tr>
            <td>GC Password</td>
            <td><input type="password" size="30" name="password" /></td>
          </tr>
          <tr>
            <td>What time (EST) on the 1st of each month do you want this app to post?</td>
            <td>
              <select name="time">
                <option value="8">8:00am</option>
                <option value="9">9:00</option>
                <option value="10">10:00</option>
                <option value="11">11:00</option>
                <option value="12">12:00pm</option>
                <option value="13">1:00</option>
                <option value="14">2:00</option>
                <option value="15">3:00</option>
                <option value="16">4:00</option>
                <option value="17">5:00</option>
                <option value="18">6:00</option>
                <option value="19">7:00</option>
                <option value="20">8:00</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2"><center><input type="submit" value="Submit!" /></center></td>
          </tr>
        </table>
      </form>
      <hr />
      <p>If you're having problems getting this to work, try <strong><a href='./clearsessions.php'>clearing your session</a>.</p>

    </div>

  </body>
</html>
