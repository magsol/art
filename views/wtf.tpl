{include file='header.tpl'}

  <body>
    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Twathletic</h3>
              {include file='menu.tpl' active='wtf'}
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Wtf is this?</h1>
            <p class="lead">
                A project in procrastination by a soon-to-graduate Ph.D. candidate. No, seriously.
            </p>
            <span class="glyphicon glyphicon-cog"></span>
            <p class="desc">
                On the 1st of each month, a little script will iterate through the users who have signed up with this app, aggregate a bunch of workout information from Garmin Connect, and post a summary of that month's athletic shenanigans on Twitter. <a href="../images/example.png" data-lightbox="image-4">Here's an example</a>. Simple!
            </p>
            <span class="glyphicon glyphicon-thumbs-down"></span>
            <p class="desc">
                Unfortunately, the current situation requires storing your Garmin Connect username and password (at least until <a href="http://garmin.blogs.com/my_weblog/2014/06/garmin-announces-partnerships-with-leading-fitness-training-applications-trainingpeaks-and-runcoach-.html#.U5cKBnVdWkA" target="_blank">this story goes somewhere!</a>). They will be encrypted, and you have my word that I will never decrypt them manually; they will be used only to authenticate with Garmin Connect. You can come back and delete them anytime you want, too. Of course, it really comes down to whether or not you trust <a href="../images/thisguy.jpg" data-lightbox="image-1">a guy like me</a>.
            </p>
            <span class="glyphicon glyphicon-new-window"></span>
            <p class="desc">
                What does that glyph even represent?
            </p>
            </div>

{include file='footer.tpl'}