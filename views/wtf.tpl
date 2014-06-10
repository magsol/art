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
            <p class="desc">
                This is a little side project to make it just a tiny bit easier to tally up your monthly workout statistics. Plus it's fun to code things like this.
            </p>
            <span class="glyphicon glyphicon-cog"></span>
            <p class="desc">
                Basically this uses two mechanisms of authentication: OAuth for Twitter, and username / password for Garmin Connect. The former cannot do anything besides post to your Twitter account, and you can always revoke its posting privileges if it's been a bad app.
            </p>
            <span class="glyphicon glyphicon-thumbs-up"></span>
            <p class="desc">
                The latter, unfortunately, is unavoidable (unless <a href="http://garmin.blogs.com/my_weblog/2014/06/garmin-announces-partnerships-with-leading-fitness-training-applications-trainingpeaks-and-runcoach-.html#.U5cKBnVdWkA" target="_blank">this story goes somewhere!</a>). Your username and password will be encrypted in the database, and you have my word that I will never decrypt them manually; they will be used only to authenticate with Garmin Connect. Of course, it really comes down to whether or not you trust <a href="../images/thisguy.jpg" data-lightbox="image-1">a guy like me</a>.
            </p>
            <span class="glyphicon glyphicon-thumbs-down"></span>
            <p class="desc">
                However! I have made it possible for you to delete your information at any time. Just visit this website and delete it. No hard feelings, brosef.
            </p>
            <span class="glyphicon glyphicon-new-window"></span>
            <p class="desc">
                What does that glyph even represent?
            </p>
            </div>

{include file='footer.tpl'}